<?php

declare(strict_types=1);

namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use League\OAuth2\Server\RequestTypes\AuthorizationRequestInterface;
use League\OAuth2\Server\RequestTypes\AuthorizationRequest;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Authentication\OAuth2\Entity\UserEntity;

class OAuthAuthorizationMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        // A SessionMiddleware populates a session containter
        $session = $request->getAttribute('session');
        $session->set('oauth2_request_params', $request->getQueryParams());
        $userId = $session->get(UserEntity::class);
        $authRequest = $request->getAttribute(AuthorizationRequest::class);
        // The user is authenticated
        if ($userId !== null) {
            $authRequest->setUser(new UserEntity($userId));
            $clientAllowed = $session->get('client_allowed');

            // The user needs to give or deny access to the client
            if($clientAllowed === null) {
                return new RedirectResponse('/oauth2/consent');

            // The user denied access to the client
            } elseif ($clientAllowed === False) {
                $session->unset('client_allowed');
                return new JsonResponse(array('code' => '401', 'message' => 'Client access denied'));
            }

            // The user authorized the client
            $authRequest->setAuthorizationApproved(true);
            $session->unset('oauth2_request_params');
            $session->unset('client_allowed');
            return $handler->handle($request);
        }

        // The user needs to login
        return new RedirectResponse('/oauth2/login');
    }
}
