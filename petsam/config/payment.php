<?php

return [
    /*
    |--------------------------------------------------------------------------
    | VNPay Configuration
    |--------------------------------------------------------------------------
    |
    | VNPay is a popular payment gateway in Vietnam
    |
    */

    'tmn_code' => env('VNPAY_TMN_CODE', '2QXFZXXX'),
    'hash_secret' => env('VNPAY_HASH_SECRET', 'XXXXXXXXXXXXXXXXXXXXXXXXXXX'),
    'sandbox_url' => 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html',
    'live_url' => 'https://payment.vnpayment.vn/vpcpay.html',
    'sandbox_mode' => env('VNPAY_SANDBOX_MODE', true),

    /*
    |--------------------------------------------------------------------------
    | Bank Transfer Configuration
    |--------------------------------------------------------------------------
    */
    'bank' => [
        'account_name' => env('BANK_ACCOUNT_NAME', 'PetSam Store'),
        'account_number' => env('BANK_ACCOUNT_NUMBER', '1234567890'),
        'bank_name' => env('BANK_NAME', 'Ngân hàng TMCP Công Thương Việt Nam'),
        'bank_code' => env('BANK_CODE', 'CTG'),
    ],
];
