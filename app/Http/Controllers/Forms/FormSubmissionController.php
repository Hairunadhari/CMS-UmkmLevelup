<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormSubmissionResource;
use App\Models\Forms\Form;
use App\Exports\FormSubmissionExport;
use App\Service\Forms\FormSubmissionFormatter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class FormSubmissionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function submissions(string $id)
    {
        $form = Form::findOrFail((int) $id);
        // $form = Form::where('id', (int) $id)->firstOrFail();
        $this->authorize('view', $form);

        // DB::enableQueryLog();
        return 
        FormSubmissionResource::collection(
            $form->submissions()
            ->join('users', 'users.id', '=', 'form_submissions.id_user')
            ->select('form_submissions.*', 'users.name')
            ->where('users.aktif', 1)
            ->paginate(100));
        // dd(DB::getQueryLog());
    }

    public function export(string $id)
    {
        $form = Form::findOrFail((int) $id);
        $this->authorize('view', $form);

        $allRows = [];
        foreach ($form->submissions->toArray() as $row) {
            $formatter = (new FormSubmissionFormatter($form, $row['data']))
                ->outputStringsOnly()
                ->setEmptyForNoValue()
                ->showRemovedFields();
            $tmp = $formatter->getCleanKeyValue();
            $tmp['Create Date'] = date("Y-m-d H:i", strtotime($row['created_at']));
            $allRows[] = $tmp;
        }
        $csvExport = (new FormSubmissionExport($allRows));
        return Excel::download(
            $csvExport,
            $form->slug.'-submission-data.csv',
            \Maatwebsite\Excel\Excel::CSV
        );
    }

    public function submissionFile($id, $fileName = null)
    {
        // $form = Form::findOrFail((int) $id);
        // $this->authorize('view', $form);

        $fileName = Str::of(PublicFormController::FILE_UPLOAD_PATH)->replace('?', $id).'/'
            .urldecode($fileName);

        if (!Storage::disk('s3')->exists($fileName)) {
            return $this->error([
                'message' => 'File not found.',
            ], 404);
        }

        return redirect(
            Storage::disk('s3')->temporaryUrl($fileName, now()->addMinute())
        );
    }
}
