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

    'accepted'             => 'L\'attribut: doit être accepté.',
    'active_url'           => "L'attribut: n'est pas une URL valide.",
    'after'                => "L'attribut: doit être une date après: date.",
    'after_or_equal'       => "L'attribut: doit être une date postérieure ou égale à: date.",
    'alpha'                => "L'attribut: ne peut contenir que des lettres.",
    'alpha_dash'           => 'L\'attribut: ne peut contenir que des lettres, des chiffres et des tirets.',
    'alpha_num'            => "L'attribut: ne peut contenir que des lettres et des chiffres.",
    'array'                => 'L\'attribut: doit être un tableau.',
    'before'               => 'L\'attribut: doit être une date antérieure à: date.',
    'before_or_equal'      => 'L\'attribut: doit être une date antérieure ou égale à: date.',
    'between'              => [
        'numeric' => "L'attribut: doit être compris entre: min et: max.",
        'file'    => 'L\'attribut: doit être compris entre: min et: max kilo-octets.',
        'string'  => 'L\'attribut: doit être compris entre: min et: max caractères.',
        'array'   => 'L\'attribut: doit avoir entre: min et: max éléments.',
    ],
    'boolean'              => "Le champ d'attribut: doit être vrai ou faux.",
    'confirmed'            => 'La confirmation d\'attribut ne correspond pas.',
    'date'                 => "L'attribut: n'est pas une date valide.",
    'date_format'          => 'L\'attribut: ne correspond pas au format: format.',
    'different'            => "L'attribut: et l'autre doivent être différents.",
    'digits'               => "L'attribut: doit être: chiffres chiffres.",
    'digits_between'       => "L'attribut: doit être compris entre: min et: max chiffres.",
    'dimensions'           => "L'attribut: a des dimensions d'image non valides.",
    'distinct'             => 'Le champ d\'attribut: a une valeur en double.',
    'email'                => "L'attribut: doit être une adresse e-mail valide.",
    'exists'               => "L'attribut sélectionné n'est pas valide.",
    'file'                 => "L'attribut: doit être un fichier.",
    'filled'               => "Le champ d'attribut: doit avoir une valeur.",
    'image'                => 'L\'attribut: doit être une image.',
    'in'                   => "L'attribut sélectionné n'est pas valide.",
    'in_array'             => "Le champ d'attribut: n'existe pas dans: autre.",
    'integer'              => "L'attribut: doit être un entier.",
    'ip'                   => 'L\'attribut: doit être une adresse IP valide.',
    'ipv4'                 => 'L\'attribut: doit être une adresse IPv4 valide.',
    'ipv6'                 => "L'attribut: doit être une adresse IPv6 valide.",
    'json'                 => 'L\'attribut: doit être une chaîne JSON valide.',
    'max'                  => [
        'numeric' => 'L\'attribut: ne doit pas être supérieur à: max.',
        'file'    => 'L\'attribut: ne doit pas être supérieur à: kilo-octets max.',
        'string'  => 'L\'attribut: ne doit pas être supérieur à: caractères max.',
        'array'   => 'L\'attribut: ne peut pas avoir plus de: max éléments.',
    ],
    'mimes'                => 'L\'attribut: doit être un fichier de type:: valeurs.',
    'mimetypes'            => 'L\'attribut: doit être un fichier de type:: valeurs.',
    'min'                  => [
        'numeric' => 'L\'attribut: doit être au moins: min.',
        'file'    => 'L\'attribut: doit être d\'au moins: min kilo-octets.',
        'string'  => 'L\'attribut: doit contenir au moins: min caractères.',
        'array'   => 'L\'attribut: doit avoir au moins: min éléments.',
    ],
    'not_in'               => "L'attribut sélectionné n'est pas valide.",
    'numeric'              => "L'attribut: doit être un nombre.",
    'present'              => "Le champ d'attribut: doit être présent.",
    'regex'                => "Le format d'attribut: n'est pas valide.",
    'required'             => 'Le champ d\'attribut: est obligatoire.',
    'required_if'          => 'Le champ: attribut est obligatoire lorsque: autre est: valeur.',
    'required_unless'      => 'Le champ: attribut est obligatoire sauf si: autre est dans: valeurs.',
    'required_with'        => 'Le champ: attribut est obligatoire lorsque: valeurs ​​est présent.',
    'required_with_all'    => 'Le champ: attribut est obligatoire lorsque: valeurs ​​est présent.',
    'required_without'     => "Le champ: attribut est obligatoire lorsque: valeurs ​​n'est pas présent.",
    'required_without_all' => "Le champ d'attribut: est obligatoire lorsqu'aucune des valeurs: n'est présente.",
    'same'                 => 'L\'attribut: et: autre doivent correspondre.',
    'size'                 => [
        'numeric' => 'L\'attribut: doit être: taille.',
        'file'    => 'L\'attribut: doit être: size kilo-octets.',
        'string'  => 'L\'attribut: doit être: caractères de taille.',
        'array'   => 'L\'attribut: doit contenir: des éléments de taille.',
    ],
    'string'               => 'L\'attribut: doit être une chaîne.',
    'timezone'             => 'L\'attribut: doit être une zone valide.',
    'unique'               => 'L\'attribut: a déjà été pris.',
    'uploaded'             => 'L\'attribut: n\'a pas pu être téléchargé.',
    'url'                  => "Le format d'attribut: n'est pas valide.",

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