<?php

declare(strict_types=1);

namespace App\Login;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

use App\Repository\CustomUserRepository;

class CustomAuthenticationAdapterFactory 
{
	public function __invoke(ContainerInterface $container) : CustomAuthenticationAdapter 
	{
		return new CustomAuthenticationAdapter(
			$container->get(CustomUserRepository::class),
			$container->get('config')['authentication'] ?? [],
			$container->get(ResponseInterface::class)
		);
	}
}