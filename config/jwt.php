<?php

return [

    'JWT_ISS' => env('JWT_ISS', env('APP_NAME')),
    'JWT_AUD' => env('JWT_AUD', env('APP_NAME')),
    'JWT_KEY' => env('JWT_KEY', env('APP_KEY')),
    'JWT_ALGORITHM' => env('JWT_ALGORITHM', 'HS256'),

];
