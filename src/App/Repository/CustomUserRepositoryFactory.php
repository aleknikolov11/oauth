<?php

declare(strict_types=1);

namespace App\Repository;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Authentication\OAuth2\Repository\Pdo\PdoService;

class CustomUserRepositoryFactory
{
	public function __invoke(ContainerInterface $container) : CustomUserRepository
	{
		return new CustomUserRepository($container->get(PdoService::class));
	}
}