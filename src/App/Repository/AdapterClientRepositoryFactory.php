<?php

declare(strict_types=1);

namespace App\Repository;

use Zend\Expressive\Authentication\OAuth2\Repository\Pdo\PdoService;
use Psr\Container\ContainerInterface;

class AdapterClientRepositoryFactory
{
	public function __invoke(ContainerInterface $container) : AdapterClientRepository
	{
		return new AdapterClientRepository(
			$container->get(PdoService::class)
		);
	}
}