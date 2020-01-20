<?php

declare(strict_types=1);

use League\OAuth2\Server\Grant;

return [
    'authentication' => [
        'pdo' => [
            'dsn'      => '',
            'username' => '',
            'password' => '',
            'table' => '',
            'field' => [
                'identity' => '',
                'password' => '',
            ],
        ], 
        'auth_code_expire'     => 'PT10M',
        'access_token_expire'  => 'P1D',
        'refresh_token_expire' => 'P1M',

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
