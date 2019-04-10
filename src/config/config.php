<?php 

$config = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
    'configToken' => [
        "key" => "cApImA_secret_key",
        "iss" => "http://127.0.0.1",
        "aud" => "http://127.0.0.1",
        "iat" => time(),
        "nbf" => time()
    ],
];