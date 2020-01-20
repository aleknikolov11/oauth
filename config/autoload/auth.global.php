<?php

declare(strict_types=1);

use League\OAuth2\Server\Grant;

return [
    'authentication' => [
        'private_key'    => __DIR__ . '/../../data/private.key',
        'public_key'     => __DIR__ . '/../../data/public.key',
        'encryption_key' => __DIR__ . '/../../data/encription.key',
    ]
];
