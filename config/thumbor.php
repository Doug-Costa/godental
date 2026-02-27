<?php declare(strict_types=1);

return [

    /*
    | The same security key used in the thumbor service to match the URL construction.
    */
    'security_key' => env('8e965d636dc76246b'),

    /*
    | Thumbor server base URL, will be used as prefix to the generated URL.
    */
    'base_url' => env('https://thumbor.dentalgo.com.br/'),
];
