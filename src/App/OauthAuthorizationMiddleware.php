<?php

declare(strict_types=1);

namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use League\OAuth2\Server\RequestTypes\AuthorizationRequestInterface;
use League\OAuth2\Server\RequestTypes\AuthorizationRequest;
use Zend\Expressive\Authentication\UserInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Authentication\OAuth2\Entity\UserEntity;

class OAuthAuthorizationMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        // Assume the SessionMiddleware handles and populates a session
        // container
        $session = $request->getAttribute('session');
        $user = $session->get(UserInterface::class);
        
        $authRequest = $request->getAttribute(AuthorizationRequest::class);
        $session->set('oauth2_request_params', $request->getQueryParams());
        // The user is authenticated:
        if ($user) {
            $user = new UserEntity($user['username']);
            $authRequest->setUser($user);

            $clientAllowed = $session->get('client_allowed');

            if($clientAllowed === null) {
                return new RedirectResponse('/oauth2/consent');
            } elseif ($clientAllowed === False) {
                $session->unset('client_allowed');
                return new JsonResponse(array('code' => '401', 'message' => 'Client access denied'));
            }

            $authRequest->setAuthorizationApproved(true);
            $session->unset('oauth2_request_params');
            $session->unset('client_allowed');
            return $handler->handle($request);
        }

        return new RedirectResponse('/oauth2/login');
    }
}
