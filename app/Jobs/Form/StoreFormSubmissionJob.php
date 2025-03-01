<?php

namespace App\Jobs\Form;

use App\Events\Forms\FormSubmitted;
use App\Http\Controllers\Forms\PublicFormController;
use App\Http\Requests\AnswerFormRequest;
use App\Models\Forms\Form;
use App\Models\Forms\FormSubmission;
use App\Service\Storage\StorageFileNameParser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;
use DB;

class StoreFormSubmissionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ?string $submissionId = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Form $form, public array $submissionData)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $formData = $this->getFormData();
        // if (session('simpanSementara') == true) {
        // }else{
            $this->addHiddenPrefills($formData);
        // }

        $this->storeSubmission($formData);
        

        $formData["submission_id"] = $this->submissionId;
        FormSubmitted::dispatch($this->form, $formData);
    }

    // public function handleSimpanSementara()
    // {
    //     $formData = $this->getFormData();
    //     // $this->addHiddenPrefills($formData);

    //     $this->storeSubmission($formData);
        

    //     $formData["submission_id"] = $this->submissionId;
    //     FormSubmitted::dispatch($this->form, $formData);
    // }

    public function getSubmissionId()
    {
        return $this->submissionId;
    }

    private function storeSubmission(array $formData)
    {
        // Create or update record
        // dd($this->submissionToUpdate());
        if (session('idUser') != 0 or session('idUser') != null) {
            $user = DB::table('users')->where('id', session('idUser'))->first();
            $id = $user->id;
        }
        else{
            $id = 0;
            // $user = DB::table('users')->orderBy('id', 'DESC')->first();
        }
        if ($previousSubmission = $this->submissionToUpdate()) {
            // dd('test');
            if (session('simpanSementara') == false) {
                $previousSubmission->savedSession = 0;
            }else{
                $previousSubmission->savedSession = 1;
            }
            $previousSubmission->data = $formData;
            $previousSubmission->save();
            $this->submissionId = $previousSubmission->id;
        } else {
            if (session('simpanSementara') != true) {
                $response = $this->form->submissions()->create([
                    'data' => $formData,
                    'savedSession' => 0,
                    'id_user' => $id
                ]);
            }else{
                $response = $this->form->submissions()->create([
                    'data' => $formData,
                    'savedSession' => 1,
                    'id_user' => $id
                ]);
            }
            $this->submissionId = $response->id;
        }
    }

    /**
     * Search for Submission record to update and returns it
     */
    private function submissionToUpdate(): ?FormSubmission
    {
        if ($this->form->editable_submissions && isset($this->submissionData['submission_id']) && $this->submissionData['submission_id']) {
            $submissionId = $this->submissionData['submission_id'] ? Hashids::decode($this->submissionData['submission_id']) : false;
            $submissionId = $submissionId[0] ?? null;
            return $this->form->submissions()->findOrFail($submissionId);
        }

        return null;
    }

    /**
     * Retrieve data from request object, and pre-format it if needed.
     * - Replace notionforms id with notion field ids
     * - Clean \ in select id values
     * - Stores file and replace value with url
     * - Generate auto increment id & unique id features for rich text field
     */
    private function getFormData()
    {
        $data = $this->submissionData;
        $cloneData = $data;
        $finalData = [];

        $properties = collect($this->form->properties);
        // Do required transformation per type (e.g. file uploads)
        foreach ($data as $answerKey => $answerValue) {
            $field = $properties->where('id', $answerKey)->first();
            if (!$field) {
                continue;
            }

            if (
                ($field['type'] == 'url' && isset($field['file_upload']) && $field['file_upload'])
                || $field['type'] == 'files') {
                    if (is_array($answerValue)) {
                    $checkSubmission = $cloneData['submission_id'] ?? null;
                    if ($checkSubmission) {
                        $fieldId = $field['id'];
                        $idForm = Hashids::decode($data['submission_id']);
                        $check = DB::table('form_submissions')->where('id', $idForm[0])
                        ->where(function ($query) use ($fieldId) {
                            $query->where('data', 'not like', '%"'.$fieldId.'":[null]%')
                                ->orWhere('data', 'not like', '%"'.$fieldId.'":null%');
                        })->first();
                        if ($check) {
                            // dd($answerValue);
                        }else{}
                    }else{}
                    $finalData[$field['id']] = [];
                    foreach ($answerValue as $file) {
                        $finalData[$field['id']][] = $this->storeFile($file);
                    }
                } else {
                    $finalData[$field['id']] = $this->storeFile($answerValue);
                }
            } else {
                if ($field['type'] == 'text' && isset($field['generates_uuid']) && $field['generates_uuid']) {
                    $finalData[$field['id']] = ($this->form->is_pro) ? Str::uuid() : "Please upgrade your OpenForm subscription to use our ID generation features";
                } else {
                    if ($field['type'] == 'text' && isset($field['generates_auto_increment_id']) && $field['generates_auto_increment_id']) {
                        $finalData[$field['id']] = ($this->form->is_pro) ? (string) ($this->form->submissions_count + 1) : "Please upgrade your OpenForm subscription to use our ID generation features";
                    } else {
                        $finalData[$field['id']] = $answerValue;
                    }
                }
            }

            // For Singrature
            if($this->form->is_pro && $field['type'] == 'signature') {
                $finalData[$field['id']] = $this->storeSignature($answerValue);
            }
        }

        return $finalData;
    }

    /**
     * Custom Back-end Value formatting. Use case:
     * - File uploads (move file from tmp storage to persistent)
     *
     * File can have 2 formats:
     * - file_name-{uuid}.{ext}
     * - {uuid}
     */
    private function storeFile(?string $value)
    {
        // dd($value);
        if ($value == null) {
            return null;
        }

        $fileNameParser = StorageFileNameParser::parse($value);

        // Make sure we retrieve the file in tmp storage, move it to persistent
        $fileName = PublicFormController::TMP_FILE_UPLOAD_PATH.'/'.$fileNameParser->uuid;
        if (!Storage::disk('s3')->exists($fileName)) {
            // File not found, we skip
            return $value;
        }
        $newPath = Str::of(PublicFormController::FILE_UPLOAD_PATH)->replace('?', $this->form->id);
        $completeNewFilename = $newPath.'/'.$fileNameParser->getMovedFileName();

        \Log::debug('Moving file to permanent storage.', [
            'uuid' => $fileNameParser->uuid,
            'destination' => $completeNewFilename,
            'form_id' => $this->form->id,
            'form_slug' => $this->form->slug,
        ]);
        Storage::disk('s3')->move($fileName, $completeNewFilename);

        return $fileNameParser->getMovedFileName();
    }

    private function storeSignature(?string $value)
    {
        if ($value == null || !isset(explode(',', $value)[1])) {
            return null;
        }

        $fileName = 'sign_'.(string) Str::uuid().'.png';
        $newPath = Str::of(PublicFormController::FILE_UPLOAD_PATH)->replace('?', $this->form->id);
        $completeNewFilename = $newPath.'/'.$fileName;

        Storage::disk('s3')->put($completeNewFilename, base64_decode(explode(',', $value)[1]));

        return $fileName;
    }

    /**
     * Adds prefill from hidden fields
     *
     * @param  array  $formData
     * @param  AnswerFormRequest  $request
     */
    private function addHiddenPrefills(array &$formData): void
    {
        // Find hidden properties with prefill, set values
        collect($this->form->properties)->filter(function ($property) {
            return isset($property['hidden'])
                && isset($property['prefill'])
                && $property['hidden']
                && !is_null($property['prefill']);
        })->each(function (array $property) use (&$formData) {
            if ($property['type'] === 'date' && isset($property['prefill_today']) && $property['prefill_today']) {
                $formData[$property['id']] = now();
            } else {
                $formData[$property['id']] = $property['prefill'];
            }
        });
    }
}
