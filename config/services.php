<?php

return [
    'mercadopago' => [
        'access_token' => env('MERCADOPAGO_ACCESS_TOKEN'),
        'currency' => env('MERCADOPAGO_CURRENCY', 'ARS'),
    ],

    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'client_secret' => env('PAYPAL_SECRET'),
        'base_url' => env('PAYPAL_BASE_URL', 'https://api-m.sandbox.paypal.com'),
        'currency' => env('PAYPAL_CURRENCY', 'USD'),
    ],

    'bank' => [
        'holder' => env('BANK_ACCOUNT_HOLDER', 'Stitch Shop SRL'),
        'name' => env('BANK_NAME', 'Banco Ohana'),
        'cbu' => env('BANK_CBU', '0000003100098765432101'),
        'alias' => env('BANK_ALIAS', 'STITCH.OHANA.SHOP'),
    ],
];
