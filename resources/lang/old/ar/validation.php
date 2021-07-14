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

    'accepted'             => ':attribute يجب ان يكون مقبولا.',
    'active_url'           => ':attribute هو عنوان غير صحيح.',
    'after'                => ':attribute يجب ان يكون التاريخ بعد :date.',
    'after_or_equal'       => ':attribute يجب ان يكون التاريخ بعد :date.',
    'alpha'                => ':attribute يجب ان يحتوي احرفا فقط.',
    'alpha_dash'           => ':attribute يجب ان يحتوي احرفا  او ارقاما او - فقط.',
    'alpha_num'            => ':attribute يجب ان يحتوي احرفا او ارقاما فقط.',
    'array'                => ':attribute must be an array.',
    'before'               => ':attribute يجب ان يكون التاريخ قبل :date.',
    'before_or_equal'      => ':attribute يجب ان يكون التاريخ قبل :date.',
    'between'              => [
        'numeric' => ':attribute must be between :min and :max.',
        'file'    => ':attribute must be between :min and :max kilobytes.',
        'string'  => ':attribute must be between :min and :max characters.',
        'array'   => ':attribute must have between :min and :max items.',
    ],
    'boolean'              => ':attribute field must be true or false.',
    'confirmed'            => ':attribute confirmation does not match.',
    'date'                 => ':attribute is not a valid date.',
    'date_format'          => ':attribute does not match the format :format.',
    'different'            => ':attribute and :other must be different.',
    'digits'               => ':attribute must be :digits digits.',
    'digits_between'       => ':attribute must be between :min and :max digits.',
    'dimensions'           => ':attribute has invalid image dimensions.',
    'distinct'             => ':attribute field has a duplicate value.',
    'email'                => ':attribute must be a valid email address.',
    'exists'               => 'اختيار :attribute غير صحيح.',
    'file'                 => ':attribute must be a file.',
    'filled'               => ':attribute field must have a value.',
    'image'                => ':attribute must be an image.',
    'in'                   => 'اخيتار :attribute غير صحيح.',
    'in_array'             => ':attribute field does not exist in :other.',
    'integer'              => ':attribute must be an integer.',
    'ip'                   => ':attribute must be a valid IP address.',
    'ipv4'                 => ':attribute must be a valid IPv4 address.',
    'ipv6'                 => ':attribute must be a valid IPv6 address.',
    'json'                 => ':attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute may not be greater than :max.',
        'file'    => ':attribute may not be greater than :max kilobytes.',
        'string'  => ':attribute may not be greater than :max characters.',
        'array'   => ':attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute must be a file of type: :values.',
    'mimetypes'            => ':attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute must be at least :min.',
        'file'    => ':attribute must be at least :min kilobytes.',
        'string'  => ':attribute must be at least :min characters.',
        'array'   => ':attribute must have at least :min items.',
    ],
    'not_in'               => 'اختيار :attribute is invalid.',
    'numeric'              => ':attribute must be a number.',
    'present'              => ':attribute field must be present.',
    'regex'                => ':attribute format is invalid.',
    'required'             => ':attribute field is required.',
    'required_if'          => ':attribute مطلوب عندما :other is :value.',
    'required_unless'      => ':attribute مطلوب الا اذا :other is in :values.',
    'required_with'        => ':attribute مطلوب عندما :values موجود.',
    'required_with_all'    => ':attribute مطلوب عندما :values يكون موجودا',
    'required_without'     => ':attribute مطلوب عندما :values لا يكون موجودا.',
    'required_without_all' => ':attribute مطلوب عندما لا يكون :values تكون موجودة.',
    'same'                 => ':attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

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

    'email.isexist' => [
        'attribute-name' => [
            'email.isexist' => '-110:Email already email ',
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
