<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cart Cookie Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of the cookie that will be used to store the cart ID.
    | You can change this value to any name you prefer.
    |
    */

    'cookie' => [
        'name' => env('CART_COOKIE_NAME', 'cart_cookie'),
        'expiration' => 7 * 24 * 60, // 7 days in minutes

    ],

];