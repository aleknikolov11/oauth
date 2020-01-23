<?php

declare(strict_types=1);

namespace App\Login;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Authentication\OAuth2\Entity\UserEntity;
use Zend\Expressive\Session\SessionInterface;
use Zend\Expressive\Session\SessionMiddleware;

use App\Repository\CustomUserRepository;

class CustomAuthenticationAdapter
{
	/**
	 * @var array
	 */
	private $config;

	/**
	 * @var
	 */
	private $userRepository;

	/**
	 * @var callable
	 */
	private $responseFactory;

	public function __construct(CustomUserRepository $repository, array $config, callable $responseFactory) {
		$this->userRepository = $repository;
		$this->config = $config;
		$this->responseFactory = function () use ($responseFactory) : ResponseInterface {
			return $responseFactory;
		};
	}

	/**
	 * {inheritDoc}
	 */
	public function authenticate(ServerRequestInterface $request) : ?UserEntity
	{
		$session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);

		if(strtoupper($request->getMethod()) !== 'POST') {
			return null;
		}

		$params = $request->getParsedBody();
		$username = $this->config['username'] ?? 'username';
		$password = $this->config['password'] ?? 'password';
		if(!isset($params[$username]) || !isset($params[$password])) {
			return null;
		}

		$user = $this->userRepository->authenticate($params[$username], $params[$password]);
		if($user) {
			$session->set(UserEntity::class, $user->getIdentifier());
			$session->regenerate();
		}

		return $user;
	}

	/**
	 * {inheritDoc}
	 */
	public function unauthorizedResponse(ServerRequestInterface $request) : ResponseInterface
	{
		return ($this->responseFactory)()
				->withHeader(
					'Location',
					$this->config['redirect']
				)->withStatus(302);
	}
}