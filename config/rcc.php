<?php

return [

    /*
    |--------------------------------------------------------------------------
    | System Type
    |--------------------------------------------------------------------------
    |
    */
    'type' => env('RCC_TYPE', "COST CALCULATOR"),

    /*
    |--------------------------------------------------------------------------
    | Company Name
    |--------------------------------------------------------------------------
    |
    */
    'name' => env('RCC_NAME', "RECIPE COST CALCULATOR"),

    /*
    |--------------------------------------------------------------------------
    | Company Short Name
    |--------------------------------------------------------------------------
    |
    */
    'short_name' => env('RCC_SHORT_NAME', 'RECIPE'),

    /*
    |--------------------------------------------------------------------------
    | System User Types
    |--------------------------------------------------------------------------
    |
    */
    'admin_type' => env('RCC_ADMIN_TYPE', 1),

    /*
    |--------------------------------------------------------------------------
    | System User Types
    |--------------------------------------------------------------------------
    |
    */
    'cur_lka' => env('RCC_CUR_LKA', 1),

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    | This use to get ajax request when app run without domain 
    |
    */

   'base_url' => env('RCC_BASE_URL', '/'),

    /*
    |--------------------------------------------------------------------------
    | Company Details
    |--------------------------------------------------------------------------
    |
    | This use to get ajax request when app run without domain 
    |
    */

    'company_name'=>env('COMPANY_NAME',"FLUSION CUSINE BY SUNANDA"),
    'company_email'=>env('COMPANY_ADDRESS',"chefweeratunga@gmail.com"),
    'company_telephone'=>env('COMPANY_TELEPHONE',"+94 70 100 0074"),

];