<?php

declare(strict_types=1);

use League\OAuth2\Server\Grant;

return [
    'authentication' => [
        'private_key'    => __DIR__ . '/../../data/oauth/private.key',
        'public_key'     => __DIR__ . '/../../data/oauth/public.key',
        'encryption_key' => __DIR__ . '/../../data/oauth/encryption.key',
        'auth_code_expire'     => 'PT10M',
        'access_token_expire'  => 'P1D',
        'refresh_token_expire' => 'P1M',
        'pdo' => [
            'table' => 'oauth_users',
            'field' => [
                'identity' => 'username',
                'password' => 'password',
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
