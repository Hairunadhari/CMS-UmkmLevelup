<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Inputan :attribute harus diterima.',
    'active_url' => 'Inputan :attribute tidak memliki format URL Valid.',
    'after' => 'Inputan :attribute harus ada tanggal setelahnya :date.',
    'after_or_equal' => 'Inputan :attribute harus ada tanggal setelahnya atau sama dengan to :date.',
    'alpha' => 'Inputan :attribute hanya boleh berisi huruf.',
    'alpha_dash' => 'Inputan :attribute hanya boleh berisi huruf, angka, strip (-) dan underscores (_).',
    'alpha_num' => 'Inputan :attribute hanya boleh berisi huruf dan angka.',
    'array' => 'Inputan :attribute harus berupa array.',
    'before' => 'Inputan :attribute harus tanggal sebelum :date.',
    'before_or_equal' => 'Inputan :attribute harus tanggal sebelum atau sama dengan to :date.',
    'between' => [
        'numeric' => 'Inputan :attribute harus diantara :min sampai :max.',
        'file' => 'Inputan :attribute harus diantara :min sampai :max kilobytes.',
        'string' => 'Inputan :attribute harus diantara :min sampai :max characters.',
        'array' => 'Inputan :attribute harus ada di antara :min sampai :max items.',
    ],
    'boolean' => 'Inputan :attribute harus berupa true atau false.',
    'confirmed' => 'Inputan :attribute konfirmasi tidak cocok.',
    'date' => 'Inputan :attribute bukan tanggal yang sesuai format.',
    'date_equals' => 'Inputan :attribute harus tanggal yang sama dengan :date.',
    'date_format' => 'Inputan :attribute tidak cocok dengan formatnya :format.',
    'different' => 'Inputan :attribute dan :other harus berbeda.',
    'digits' => 'Inputan :attribute harus :digits digits.',
    'digits_between' => 'Inputan :attribute harus diantara :min sampai :max digits.',
    'dimensions' => 'Inputan :attribute memiliki dimensi gambar yang tidak valid.',
    'distinct' => 'Inputan :attribute mempunyai nilai duplikat.',
    'email' => 'Inputan :attribute harus alamat e-mail yang valid.',
    'ends_with' => 'Inputan :attribute harus diakhiri dengan salah satu dari ini: :values.',
    'exists' => 'Inputan selected :attribute tidak sesuai.',
    'file' => 'Inputan :attribute harus berupa file / dokumen.',
    'filled' => 'Inputan :attribute harus mempunyai nilai.',
    'gt' => [
        'numeric' => 'Inputan :attribute harus lebih besar dari :value.',
        'file' => 'Inputan :attribute harus lebih besar dari :value kilobytes.',
        'string' => 'Inputan :attribute harus lebih besar dari :value characters.',
        'array' => 'Inputan :attribute harus memiliki lebih dari :value items.',
    ],
    'gte' => [
        'numeric' => 'Inputan :attribute harus lebih besar dari atau sama dengan :value.',
        'file' => 'Inputan :attribute harus lebih besar dari atau sama dengan :value kilobytes.',
        'string' => 'Inputan :attribute harus lebih besar dari atau sama dengan :value characters.',
        'array' => 'Inputan :attribute harus mempunyai :value items atau lebih.',
    ],
    'image' => 'Inputan :attribute harus berupa gambar.',
    'in' => 'Inputan selected :attribute tidak sesuai.',
    'in_array' => 'Inputan :attribute tidak ada di :other.',
    'integer' => 'Inputan :attribute harus berupa angka.',
    'ip' => 'Inputan :attribute harus berupa IP Address.',
    'ipv4' => 'Inputan :attribute harus berupa IPv4 address.',
    'ipv6' => 'Inputan :attribute harus berupa IPv6 address.',
    'json' => 'Inputan :attribute harus berupa JSON format.',
    'lt' => [
        'numeric' => 'Inputan :attribute harus lebih kurang dari :value.',
        'file' => 'Inputan :attribute harus lebih kurang dari :value kilobytes.',
        'string' => 'Inputan :attribute harus lebih kurang dari :value characters.',
        'array' => 'Inputan :attribute harus memiliki kurang dari :value items.',
    ],
    'lte' => [
        'numeric' => 'Inputan :attribute harus lebih kurang dari atau sama dengan :value.',
        'file' => 'Inputan :attribute harus lebih kurang dari atau sama dengan :value kilobytes.',
        'string' => 'Inputan :attribute harus lebih kurang dari atau sama dengan :value characters.',
        'array' => 'Inputan :attribute tidak boleh memiliki lebih dari :value items.',
    ],
    'max' => [
        'numeric' => 'Inputan :attribute mungkin tidak lebih besar dari :max.',
        'file' => 'Inputan :attribute mungkin tidak lebih besar dari :max kilobytes.',
        'string' => 'Inputan :attribute mungkin tidak lebih besar dari :max characters.',
        'array' => 'Inputan :attribute mungkin tidak memiliki lebih dari :max items.',
    ],
    'mimes' => 'Inputan :attribute harus berupa file bertipe: :values.',
    'mimetypes' => 'Inputan :attribute harus berupa file bertipe: :values.',
    'min' => [
        'numeric' => 'Inputan :attribute setidaknya harus :min.',
        'file' => 'Inputan :attribute setidaknya harus :min kilobytes.',
        'string' => 'Inputan :attribute setidaknya harus :min characters.',
        'array' => 'Inputan :attribute setidaknya harus mempunyai :min items.',
    ],
    'multiple_of' => 'Inputan :attribute harus kelipatan dari :value',
    'not_in' => 'Inputan selected :attribute tidak sesuai.',
    'not_regex' => 'Inputan :attribute format tidak sesuai.',
    'numeric' => 'Inputan :attribute harus berupa angka.',
    'password' => 'Inputan password tidak sesuai.',
    'present' => 'Inputan :attribute harus hadir.',
    'regex' => 'Inputan :attribute format tidak sesuai.',
    'required' => 'Inputan :attribute wajib isi.',
    'required_if' => 'Inputan :attribute wajib isi ketika :other terisi :value.',
    'required_unless' => 'Inputan :attribute wajib isi kecuali :other ada di :values.',
    'required_with' => 'Inputan :attribute wajib isi ketika :values ada.',
    'required_with_all' => 'Inputan :attribute wajib isi ketika :values are present.',
    'required_without' => 'Inputan :attribute wajib isi ketika :values is not present.',
    'required_without_all' => 'Inputan :attribute wajib isi ketika tidak ada satu pun darinya :values are present.',
    'same' => 'Inputan :attribute dan :other harus sama.',
    'size' => [
        'numeric' => 'Inputan :attribute harus :size.',
        'file' => 'Inputan :attribute harus :size kilobytes.',
        'string' => 'Inputan :attribute harus :size characters.',
        'array' => 'Inputan :attribute harus berisi :size items.',
    ],
    'starts_with' => 'Inputan :attribute harus dimulai dengan salah satu hal berikut: :values.',
    'string' => 'Inputan :attribute harus bertipe string.',
    'timezone' => 'Inputan :attribute harus sesuai format waktu.',
    'unique' => 'Inputan :attribute sudah dipakai.',
    'uploaded' => 'Inputan :attribute gagal mengunggah.',
    'url' => 'Inputan :attribute format tidak sesuai.',
    'uuid' => 'Inputan :attribute harus sesuai format  UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
