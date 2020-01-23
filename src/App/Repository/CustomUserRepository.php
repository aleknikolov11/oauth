<?php

declare(strict_types=1);

namespace App\Repository;

use Zend\Expressive\Authentication\OAuth2\Repository\Pdo\UserRepository;
use Zend\Expressive\Authentication\OAuth2\Repository\Pdo\PdoService;
use Zend\Expressive\Authentication\OAuth2\Entity\UserEntity;
use Zend\Expressive\Authentication\UserInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;

use function password_verify;

class CustomUserRepository extends UserRepository
{

	public function authenticate(string $username, string $password) : ?UserEntity
	{
		$stmt = $this->pdo->prepare(
			'SELECT * FROM `oauth_users` WHERE `username`=:username;'
		);

		$stmt->bindParam(':username', $username);

		if($stmt->execute() === false) {
			return null;
		}

		$row = $stmt->fetch();

		if(empty($row)) {
			return null;
		}

		if(password_verify($password, $row['password']) === false) {
			return null;
		}

		return new UserEntity($row['id']);
	}

    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    ) {
        $sth = $this->pdo->prepare(
            'SELECT * FROM oauth_users WHERE username = :username'
        );
        $sth->bindParam(':username', $username);

        if (false === $sth->execute()) {
            return;
        }

        $row = $sth->fetch();

        if (! empty($row) && password_verify($password, $row['password'])) {
            return new UserEntity($row['id']);
        }

        return;
    }
}