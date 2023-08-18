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

    'accepted' => 'Inputan :attribute must be accepted.',
    'active_url' => 'Inputan :attribute is not a valid URL.',
    'after' => 'Inputan :attribute must be a date after :date.',
    'after_or_equal' => 'Inputan :attribute must be a date after or equal to :date.',
    'alpha' => 'Inputan :attribute may only contain letters.',
    'alpha_dash' => 'Inputan :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'Inputan :attribute may only contain letters and numbers.',
    'array' => 'Inputan :attribute must be an array.',
    'before' => 'Inputan :attribute must be a date before :date.',
    'before_or_equal' => 'Inputan :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'Inputan :attribute must be between :min and :max.',
        'file' => 'Inputan :attribute must be between :min and :max kilobytes.',
        'string' => 'Inputan :attribute must be between :min and :max characters.',
        'array' => 'Inputan :attribute must have between :min and :max items.',
    ],
    'boolean' => 'Inputan :attribute field must be true or false.',
    'confirmed' => 'Inputan :attribute confirmation does not match.',
    'date' => 'Inputan :attribute is not a valid date.',
    'date_equals' => 'Inputan :attribute must be a date equal to :date.',
    'date_format' => 'Inputan :attribute does not match the format :format.',
    'different' => 'Inputan :attribute and :other must be different.',
    'digits' => 'Inputan :attribute must be :digits digits.',
    'digits_between' => 'Inputan :attribute must be between :min and :max digits.',
    'dimensions' => 'Inputan :attribute has invalid image dimensions.',
    'distinct' => 'Inputan :attribute field has a duplicate value.',
    'email' => 'Inputan :attribute must be a valid email address.',
    'ends_with' => 'Inputan :attribute must end with one of the following: :values.',
    'exists' => 'Inputan selected :attribute is invalid.',
    'file' => 'Inputan :attribute must be a file.',
    'filled' => 'Inputan :attribute field must have a value.',
    'gt' => [
        'numeric' => 'Inputan :attribute must be greater than :value.',
        'file' => 'Inputan :attribute must be greater than :value kilobytes.',
        'string' => 'Inputan :attribute must be greater than :value characters.',
        'array' => 'Inputan :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'Inputan :attribute must be greater than or equal :value.',
        'file' => 'Inputan :attribute must be greater than or equal :value kilobytes.',
        'string' => 'Inputan :attribute must be greater than or equal :value characters.',
        'array' => 'Inputan :attribute must have :value items or more.',
    ],
    'image' => 'Inputan :attribute must be an image.',
    'in' => 'Inputan selected :attribute is invalid.',
    'in_array' => 'Inputan :attribute field does not exist in :other.',
    'integer' => 'Inputan :attribute must be an integer.',
    'ip' => 'Inputan :attribute must be a valid IP address.',
    'ipv4' => 'Inputan :attribute must be a valid IPv4 address.',
    'ipv6' => 'Inputan :attribute must be a valid IPv6 address.',
    'json' => 'Inputan :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'Inputan :attribute must be less than :value.',
        'file' => 'Inputan :attribute must be less than :value kilobytes.',
        'string' => 'Inputan :attribute must be less than :value characters.',
        'array' => 'Inputan :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'Inputan :attribute must be less than or equal :value.',
        'file' => 'Inputan :attribute must be less than or equal :value kilobytes.',
        'string' => 'Inputan :attribute must be less than or equal :value characters.',
        'array' => 'Inputan :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'Inputan :attribute may not be greater than :max.',
        'file' => 'Inputan :attribute may not be greater than :max kilobytes.',
        'string' => 'Inputan :attribute may not be greater than :max characters.',
        'array' => 'Inputan :attribute may not have more than :max items.',
    ],
    'mimes' => 'Inputan :attribute must be a file of type: :values.',
    'mimetypes' => 'Inputan :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'Inputan :attribute must be at least :min.',
        'file' => 'Inputan :attribute must be at least :min kilobytes.',
        'string' => 'Inputan :attribute must be at least :min characters.',
        'array' => 'Inputan :attribute must have at least :min items.',
    ],
    'multiple_of' => 'Inputan :attribute must be a multiple of :value',
    'not_in' => 'Inputan selected :attribute is invalid.',
    'not_regex' => 'Inputan :attribute format is invalid.',
    'numeric' => 'Inputan :attribute must be a number.',
    'password' => 'Inputan password is incorrect.',
    'present' => 'Inputan :attribute field must be present.',
    'regex' => 'Inputan :attribute format is invalid.',
    'required' => 'Inputan :attribute field is required.',
    'required_if' => 'Inputan :attribute field is required when :other is :value.',
    'required_unless' => 'Inputan :attribute field is required unless :other is in :values.',
    'required_with' => 'Inputan :attribute field is required when :values is present.',
    'required_with_all' => 'Inputan :attribute field is required when :values are present.',
    'required_without' => 'Inputan :attribute field is required when :values is not present.',
    'required_without_all' => 'Inputan :attribute field is required when none of :values are present.',
    'same' => 'Inputan :attribute and :other must match.',
    'size' => [
        'numeric' => 'Inputan :attribute must be :size.',
        'file' => 'Inputan :attribute must be :size kilobytes.',
        'string' => 'Inputan :attribute must be :size characters.',
        'array' => 'Inputan :attribute must contain :size items.',
    ],
    'starts_with' => 'Inputan :attribute must start with one of the following: :values.',
    'string' => 'Inputan :attribute must be a string.',
    'timezone' => 'Inputan :attribute must be a valid zone.',
    'unique' => 'Inputan :attribute has already been taken.',
    'uploaded' => 'Inputan :attribute failed to upload.',
    'url' => 'Inputan :attribute format is invalid.',
    'uuid' => 'Inputan :attribute must be a valid UUID.',

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
