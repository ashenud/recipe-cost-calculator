<?php

return [

    /*
    |--------------------------------------------------------------------------
    | System Type
    |--------------------------------------------------------------------------
    |
    */
    'type' => env('RCC_TYPE', "SALES FORCE AUTOMATION SYSTEM"),

    /*
    |--------------------------------------------------------------------------
    | Company Name
    |--------------------------------------------------------------------------
    |
    */
    'name' => env('RCC_NAME', "Nature's Beauty Creations Ltd"),

    /*
    |--------------------------------------------------------------------------
    | Company Short Name
    |--------------------------------------------------------------------------
    |
    */
    'short_name' => env('RCC_SHORT_NAME', 'NBC'),

    /*
    |--------------------------------------------------------------------------
    | System User Types
    |--------------------------------------------------------------------------
    |
    */
    'admin_type' => env('RCC_ADMIN_TYPE', 1),

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    | This use to get ajax request when app run without domain 
    |
    */

   'base_url' => env('RCC_BASE_URL', '/tealeaves'),

];