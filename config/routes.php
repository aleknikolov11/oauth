<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;
use Zend\Expressive\Authentication\OAuth2;
use Zend\Expressive\Session\SessionMiddleware;
use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;

/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/:id', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Handler\ContactHandler::class,
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    $app->get('/', App\Handler\HomePageHandler::class, 'home');
    $app->get('/api/ping', App\Handler\PingHandler::class, 'api.ping');
    $app->post('/api/users', [
    	Zend\Expressive\Authentication\AuthenticationMiddleware::class,
    	App\Action\AddUserAction::class,
    ], 'api.add.user');
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
