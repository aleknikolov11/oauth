<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;
use Zend\Expressive\Authentication\OAuth2;
use Zend\Expressive\Session\SessionMiddleware;
use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;

return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    $app->get('/', App\Handler\HomePageHandler::class, 'home');
    $app->get('/api/ping', App\Handler\PingHandler::class, 'api.ping');
    $app->post('/oauth2/token', OAuth2\TokenEndpointHandler::class);
    $app->route('/oauth2/authorize',[
	    	Zend\Expressive\Session\SessionMiddleware::class,
	    	OAuth2\AuthorizationMiddleware::class,
	    	App\OauthAuthorizationMiddleware::class,
	    	OAuth2\AuthorizationHandler::class,
    	],
    	['GET', 'POST'],
    	'authorize'
  	);
    $app->route(
    	'/oauth2/login',
    	[
    		BodyParamsMiddleware::class,
    		Zend\Expressive\Session\SessionMiddleware::class,
    		App\Login\LoginHandler::class,
    	],
    	['GET', 'POST'],
    	'login'
    );
    $app->route(
    	'/oauth2/consent',
    	[
    		BodyParamsMiddleware::class,
    		Zend\Expressive\Session\SessionMiddleware::class,
    		App\OauthConsentHandler::class,
    	],
    	['GET', 'POST'],
    	'consent'
    );
};
