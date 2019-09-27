<?php 

return [

    'server_key' => env('MIDTRANS_SERVER_KEY', ''),

    'client_key' => env('MIDTRANS_CLIENT_KEY', ''),

    'env' => env('MIDTRANS_ENV', app()->environment()),

    'sanitize' => env('MIDTRANS_SANITIZE', 'false'),

    '3ds' => env('MIDTRANS_3DS', 'false'),

    'curl_options' => [

    ],

];
