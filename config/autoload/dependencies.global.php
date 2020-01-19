<?php

declare(strict_types=1);


use Zend\Expressive\Authentication\AuthenticationInterface;
use Zend\Expressive\Authentication\Session\PhpSession;
use Zend\Expressive\Authentication\UserRepositoryInterface;
use Zend\Expressive\Authentication\UserRepository\PdoDatabase;

return [
    // Provides application-wide services.
    // We recommend using fully-qualified class names whenever possible as
    // service names.
    'dependencies' => [
        // Use 'aliases' to alias a service name to another service. The
        // key is the alias name, the value is the service to which it points.
        'aliases' => [
            Authentication\AuthenticationInterface::class => Authentication\OAuth2\OAuth2Adapter::class,
            AuthenticationInterface::class => PhpSession::class,
            UserRepositoryInterface::class => PdoDatabase::class,
        ],
        // Use 'invokables' for constructor-less services, or services that do
        // not require arguments to the constructor. Map a service name to the
        // class name.
        'invokables' => [
            // Fully\Qualified\InterfaceName::class => Fully\Qualified\ClassName::class,
        ],
        // Use 'factories' for services provided by callbacks/factory classes.
        'factories'  => [
            // Fully\Qualified\ClassName::class => Fully\Qualified\FactoryName::class,
        ],
    ],
];
