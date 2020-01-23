<?php

declare(strict_types=1);

namespace App\Repository;

use Zend\Expressive\Authentication\OAuth2\Repository\Pdo\ClientRepository;
use Zend\Expressive\Authentication\OAuth2\Entity\ClientEntity;
use League\OAuth2\Server\Entities\ClientEntityInterface;

class AdapterClientRepository extends ClientRepository
{
	/**
	 * @{inheritDoc}
	 */
	public function getClientEntity($clientIdentifier) : ?ClientEntityInterface
	{
		$clientData = $this->getClientData($clientIdentifier);

		if(empty($clientData)) {
			return null;
		}

		return new ClientEntity(
			$clientData['id'],
			$clientData['name'] ?? '',
			$clientData['redirect'] ?? ''
		);
	}

	

    private function getClientData(string $clientIdentifier) : ?array
    {
        $statement = $this->pdo->prepare(
            'SELECT * FROM oauth_clients WHERE name = :clientIdentifier'
        );
        $statement->bindParam(':clientIdentifier', $clientIdentifier);

        if ($statement->execute() === false) {
            return null;
        }

        $row = $statement->fetch();

        if (empty($row)) {
            return null;
        }

        return $row;
    }


}