<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AFH-Specific configuration values
    |--------------------------------------------------------------------------
    |
    | These values are pulled from the .env environment configuration file.
    | Need to pull them into a configuration file because once cached,
    | they are not available other than in config files
    |
    */

    'rg_host' => env('RG_HOST'),
    'rg_acct' => env('RG_ACCT'),
    'rg_user' => env('RG_USER'),
    'rg_pwd' => env('RG_PWD'),
    'rg_apikey' => env('RG_APIKEY'),

    'tinify_apikey' => env('TINIFY_APIKEY'),

    'default_image' => env('DEFAULT_IMAGE'),

    'thumb_dir' => env('THUMB_DIR'),
    'thumb_width' => env('THUMB_WIDTH'),
    'large_dir' => env('LARGE_DIR'),
    'large_width' => env('LARGE_WIDTH'),

    'public_image_dir' => env('PUBLIC_IMAGE_DIR'),
    'public_image_path' => env('PUBLIC_IMAGE_PATH'),
    
    'upload_dir' => env('UPLOAD_DIR'),

    'age_baby' => 112, // 16 weeks
    'age_young' => 730, // 2 years
    'age_adult' => 3650, // 10 years

    'trand_length' => 730, // 2 years

    'species_list' => [ 'Dog', 'Cat' ], // , 'Horse', 'Pig', 'Goat' ],

];
