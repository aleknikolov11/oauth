<?php

declare(strict_types=1);

namespace App\Login;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Session\SessionInterface;
use Zend\Expressive\Authentication\UserInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

use App\Login\CustomAuthenticationAdapter;

class LoginHandler implements RequestHandlerInterface
{
    private const REDIRECT_ATTRIBUTE = 'authentication:redirect';

    /**
     * @var TemplateRendererInterface
     */
    private $renderer;

    /**
     * @var CustomAuthenticationAdapter
     */
    private $adapter;

    public function __construct(TemplateRendererInterface $renderer, CustomAuthenticationAdapter $adapter)
    {
        $this->renderer = $renderer;
        $this->adapter = $adapter;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $session = $request->getAttribute('session');
        $redirect = $this->getRedirect($request, $session);
        // Handle submitted credentials
        if('POST' === $request->getMethod()) {
            return $this->handleLogInAttempt($request, $session, $redirect);
        }
        
        // Display initial login form
        $session->set(self::REDIRECT_ATTRIBUTE, $redirect);
        return new HtmlResponse($this->renderer->render(
            'app::login',
            [] // parameters to pass to template
        ));
    }

    private function getRedirect(
        ServerRequestInterface $request,
        SessionInterface $session
    ) : string 
    {
        $redirect = $session->get(self::REDIRECT_ATTRIBUTE);

        if(! $redirect) {
            $redirect = $request->getHeaderLine('Referer');
            if (in_array($redirect, ['', '/oauth2/login'], true)) {
                $redirect = '/oauth2/authorize';
            }
        }

        return $redirect;
    }

    private function handleLogInAttempt(
        ServerRequestInterface $request,
        SessionInterface $session,
        string $redirect
    ) : ResponseInterface {
        $session->unset(UserInterface::class);
        $requestData = $request->getParsedBody();
        $user = $this->adapter->authenticate($request);
        if($user) {
            $session->unset(self::REDIRECT_ATTRIBUTE);
            $queryParams = $session->get('oauth2_request_params');
            if($queryParams){
                $redirect .= '?';
                foreach($queryParams as $key => $value) {
                    $redirect .= $key . '=' . $value . '&';
                }
            }

            return new RedirectResponse($redirect);
        }

        return new HtmlResponse($this->renderer->render(
            'app::login',
            ['error' => 'Invalid credentials; please try again']
        ));
    }
}
