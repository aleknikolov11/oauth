<?php

declare(strict_types=1);

namespace App\Login;

use Psr\Container\ContainerInterface;;
use Zend\Expressive\Template\TemplateRendererInterface;

use App\Login\CustomAuthenticationAdapter;

class LoginHandlerFactory
{
    public function __invoke(ContainerInterface $container) : LoginHandler
    {
        return new LoginHandler(
            $container->get(TemplateRendererInterface::class),
            $container->get(CustomAuthenticationAdapter::class)
        );
    }
}
