<?php

declare(strict_types=1);

namespace App;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class OauthConsentHandlerFactory
{
    public function __invoke(ContainerInterface $container) : OauthConsentHandler
    {
        return new OauthConsentHandler($container->get(TemplateRendererInterface::class));
    }
}
