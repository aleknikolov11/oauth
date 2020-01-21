<?php

declare(strict_types=1);

use League\OAuth2\Server\Grant;

return [
    'authentication' => [
        'private_key'    => __DIR__ . '/../../data/private.key',
        'public_key'     => __DIR__ . '/../../data/public.key',
        'encryption_key' => __DIR__ . '/../../data/encryption.key',
        'auth_code_expire'     => 'PT10M',
        'access_token_expire'  => 'P1D',
        'refresh_token_expire' => 'P1M',
        'pdo' => [
            'table' => 'user_table',
            'field' => [
                'identity' => 'username_field',
                'password' => 'password_field',
            ],
        ], 

        // Set value to null to disable a grant
        'grants' => [
            Grant\ClientCredentialsGrant::class => Grant\ClientCredentialsGrant::class,
            Grant\PasswordGrant::class          => Grant\PasswordGrant::class,
            Grant\AuthCodeGrant::class          => Grant\AuthCodeGrant::class,
            Grant\ImplicitGrant::class          => null,
            Grant\RefreshTokenGrant::class      => null,
        ],

        'redirect' => '/login',
    ]
];
