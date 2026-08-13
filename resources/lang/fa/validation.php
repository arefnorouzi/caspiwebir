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

    'accepted' => 'فیلد :attribute باید پذیرفته شود.',
    'accepted_if' => 'فیلد :attribute باید پذیرفته شود زمانی که :انتخاب شده :value.',
    'active_url' => 'فیلد :attribute باید یک آدرس اینترنتی معتبر باشد..',
    'after' => 'فیلد :attribute باید بزرگتر از  :date باشد.',
    'after_or_equal' => 'فیلد :attribute باید بزرگتر یا برابر تاریخ :date باشد.',
    'alpha' => 'برای فیلد :attribute فقط استفاده از حروف مجاز است.',
    'alpha_dash' => 'برای فیلد :attribute فقط حروف، اعداد، خط تیره و آندرلاین مجاز است.',
    'alpha_num' => 'برای فیلد :attribute فقط استفاده از حروف و اعداد مجاز است.',
    'any_of' => 'فیلد :attribute نامعتبر است.',
    'array' => 'فیلد :attribute باید بصورت آرایه وارد شو.',
    'ascii' => 'برای فیلد :attribute کد اسکی مجاز است.',
    'before' => 'برای فیلد :attribute باید تاریخ کوچیکتر از  :date انتخاب شود.',
    'before_or_equal' => 'برای فیلد :attribute باید تاریخ کوچکتر یا برابر با :date انتخاب شود.',
    'between' => [
        'array' => 'The :attribute field must have between :min and :max items.',
        'file' => 'The :attribute field must be between :min and :max kilobytes.',
        'numeric' => 'The :attribute field must be between :min and :max.',
        'string' => 'The :attribute field must be between :min and :max characters.',
    ],
    'boolean' => 'فیلد :attribute باید به صورت 0 یا 1 وارد شود.',
    'can' => 'The :attribute field contains an unauthorized value.',
    'confirmed' => 'فیلد :attribute تکرار رمز عبور با رمز مطابقت ندارد.',
    'contains' => 'The :attribute field is missing a required value.',
    'current_password' => 'رمز عبور نامعتبر است.',
    'date' => 'فیلد :attribute باید به صورت تاریخ وارد شود.',
    'date_equals' => 'The :attribute field must be a date equal to :date.',
    'date_format' => 'The :attribute field must match the format :format.',
    'decimal' => 'The :attribute field must have :decimal decimal places.',
    'declined' => 'The :attribute field must be declined.',
    'declined_if' => 'The :attribute field must be declined when :other is :value.',
    'different' => 'The :attribute field and :other must be different.',
    'digits' => 'فیلد :attribute باید بصورت :digits رقمی وارد شود.',
    'digits_between' => 'The :attribute field must be between :min and :max digits.',
    'dimensions' => 'The :attribute field has invalid image dimensions.',
    'distinct' => 'فیلد :attribute شامل مقدار تکراری است.',
    'doesnt_contain' => 'The :attribute field must not contain any of the following: :values.',
    'doesnt_end_with' => 'The :attribute field must not end with one of the following: :values.',
    'doesnt_start_with' => 'The :attribute field must not start with one of the following: :values.',
    'email' => 'برای فیلد :attribute باید یک آدرس ایمیل معتبر وارد شود.',
    'ends_with' => 'The :attribute field must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'مقدار انتخاب شده برای فیلد :attribute نامعتبر است.',
    'extensions' => 'برای فیلد :attribute فقط پسوندهای extensions: :values مجاز هستند.',
    'file' => 'فیلد :attribute باید بصورت فایل مقداردهی شود.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'array' => 'مقدار فیلد :attribute باید بزرگتر از :value آیتم باشد.',
        'file' => 'فایل :attribute باید بزرگتر از :value کیلوبایت باشد.',
        'numeric' => 'مقدار :attribute باید بزرگتر از :value باشد.',
        'string' => 'فیلد :attribute باید بزرگتر از :value حرف باشد.',
    ],
    'gte' => [
        'array' => 'The :attribute field must have :value items or more.',
        'file' => 'The :attribute field must be greater than or equal to :value kilobytes.',
        'numeric' => 'The :attribute field must be greater than or equal to :value.',
        'string' => 'The :attribute field must be greater than or equal to :value characters.',
    ],
    'hex_color' => 'مقدار فیلد :attribute باید کد رنگ معتبر بصورت hex باشد.',
    'image' => 'فیلد :attribute باید بصورت فایل تصویر مقداردهی شود.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field must exist in :other.',
    'in_array_keys' => 'The :attribute field must contain at least one of the following keys: :values.',
    'integer' => 'فیلد :attribute باید بصورت عدد صحیح وارد شود.',
    'ip' => 'The :attribute field must be a valid IP address.',
    'ipv4' => 'The :attribute field must be a valid IPv4 address.',
    'ipv6' => 'The :attribute field must be a valid IPv6 address.',
    'json' => 'فیلد :attribute باید بصورت json وارد شود.',
    'list' => 'فیلد :attribute باید بصورت لیست وارد شود.',
    'lowercase' => 'فیلد :attribute باید بصورت حروف کوچک وارد شود.',
    'lt' => [
        'array' => 'The :attribute field must have less than :value items.',
        'file' => 'The :attribute field must be less than :value kilobytes.',
        'numeric' => 'فیلد :attribute باید کوچکتر از :value باشد.',
        'string' => 'The :attribute field must be less than :value characters.',
    ],
    'lte' => [
        'array' => 'The :attribute field must not have more than :value items.',
        'file' => 'The :attribute field must be less than or equal to :value kilobytes.',
        'numeric' => 'The :attribute field must be less than or equal to :value.',
        'string' => 'The :attribute field must be less than or equal to :value characters.',
    ],
    'mac_address' => 'The :attribute field must be a valid MAC address.',
    'max' => [
        'array' => 'The :attribute field must not have more than :max items.',
        'file' => 'The :attribute field must not be greater than :max kilobytes.',
        'numeric' => 'مقدار فیلد :attribute نباید بزرگتر از :max باشد.',
        'string' => 'The :attribute field must not be greater than :max characters.',
    ],
    'max_digits' => 'The :attribute field must not have more than :max digits.',
    'mimes' => 'برای فیلد :attribute فقط فایل با پسوندهای: :values مجاز است.',
    'mimetypes' => 'برای فیلد :attribute فقط فایل با پسوندهای: :values مجاز است.',
    'min' => [
        'array' => 'The :attribute field must have at least :min items.',
        'file' => 'The :attribute باید حداقل :min کیلوبایت باشد.',
        'numeric' => 'مقدار فیلد :attribute نباید کوچکتر از :min باشد.',
        'string' => 'مقدار فیلد :attribute نباید کمتر از :min characters.',
    ],
    'min_digits' => 'The :attribute field must have at least :min digits.',
    'missing' => 'The :attribute field must be missing.',
    'missing_if' => 'The :attribute field must be missing when :other is :value.',
    'missing_unless' => 'The :attribute field must be missing unless :other is :value.',
    'missing_with' => 'The :attribute field must be missing when :values is present.',
    'missing_with_all' => 'The :attribute field must be missing when :values are present.',
    'multiple_of' => 'The :attribute field must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute field format is invalid.',
    'numeric' => 'فیلد :attribute باید بصورت عدد وارد شود.',
    'password' => [
        'letters' => 'فیلد :attribute باید شامل حداقل یک حرف باشد.',
        'mixed' => 'فیلد :attribute باید شامل حداقل یک حروف بزرگ و یک حروف کوچک باشد.',
        'numbers' => 'فیلد :attribute باید شامل حداقل یک عدد باشد.',
        'symbols' => 'فیلد :attribute باید شامل حداقل یک symbol باشد.',
        'uncompromised' => 'مقدار فیلد :attribute خیلی ساده است. لطفا یک :attribute قویتر انتخاب نمایید.',
    ],
    'present' => 'The :attribute field must be present.',
    'present_if' => 'The :attribute field must be present when :other is :value.',
    'present_unless' => 'The :attribute field must be present unless :other is :value.',
    'present_with' => 'The :attribute field must be present when :values is present.',
    'present_with_all' => 'The :attribute field must be present when :values are present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_if_accepted' => 'The :attribute field is prohibited when :other is accepted.',
    'prohibited_if_declined' => 'The :attribute field is prohibited when :other is declined.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => 'The :attribute field format is invalid.',
    'required' => 'پر کردن فیلد :attribute اجباری است.',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_if_accepted' => 'The :attribute field is required when :other is accepted.',
    'required_if_declined' => 'The :attribute field is required when :other is declined.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'پر کردن فیلد :attribute اجباری است زمانی که :values مقداردهی شود.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute field must match :other.',
    'size' => [
        'array' => 'The :attribute field must contain :size items.',
        'file' => 'The :attribute field must be :size kilobytes.',
        'numeric' => 'The :attribute field must be :size.',
        'string' => 'The :attribute field must be :size characters.',
    ],
    'starts_with' => 'فیلد :attribute باید با: :values شروع شود.',
    'string' => 'فیلد :attribute باید با حروف شروع شود.',
    'timezone' => 'The :attribute field must be a valid timezone.',
    'unique' => 'مقدار فیلد :attribute نباید از قبل در پایگاه داده وجود داشته باشد. داده تکراری مجاز نیست.',
    'uploaded' => 'The :attribute failed to upload.',
    'uppercase' => 'فیلد :attribute باید بصورت حروف بزگ وارد شود.',
    'url' => 'فیلد :attribute باید یک ادرس اینترنتی معتبر باشد.',
    'ulid' => 'The :attribute field must be a valid ULID.',
    'uuid' => 'The :attribute field must be a valid UUID.',

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
