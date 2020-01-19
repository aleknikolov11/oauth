<?php

declare(strict_types=1);

use League\OAuth2\Server\Grant;

return [
    'authentication' => [
        'private_key'    => __DIR__ . '/../../data/private.key',
        'public_key'     => __DIR__ . '/../../data/public.key',
        'encryption_key' => base64_encode(random_bytes(32)),
        'pdo' => [
            'dsn'      => 'mysql:host=127.0.0.1;dbname=oauth',
            'username' => 'oauth_user',
            'password' => '',
            'table' => 'oauth_users',
            'field' => [
                'identity' => 'username',
                'password' => 'password',
            ],
        ], 
        'auth_code_expire'     => 'PT50M',

        // Set value to null to disable a grant
        'grants' => [
            Grant\ClientCredentialsGrant::class => Grant\ClientCredentialsGrant::class,
            Grant\PasswordGrant::class          => Grant\PasswordGrant::class,
            Grant\AuthCodeGrant::class          => Grant\AuthCodeGrant::class,
            Grant\ImplicitGrant::class          => Grant\ImplicitGrant::class,
            Grant\RefreshTokenGrant::class      => Grant\RefreshTokenGrant::class
        ],

        'redirect' => '/login',
    ]
];
