<?php

declare(strict_types=1);

namespace App;

use Psr\Container\ContainerInterface;

class OauthAuthorizationMiddlewareFactory
{
    public function __invoke(ContainerInterface $container) : OauthAuthorizationMiddleware
    {
        return new OauthAuthorizationMiddleware();
    }
}
