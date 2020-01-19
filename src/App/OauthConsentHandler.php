<?php

declare(strict_types=1);

namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Expressive\Session\SessionInterface;

class OauthConsentHandler implements RequestHandlerInterface
{
    private const REDIRECT_ATTRIBUTE = 'authentication:redirect';

    /**
     * @var TemplateRendererInterface
     */
    private $renderer;

    public function __construct(TemplateRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $session = $request->getAttribute('session');
        $redirect = $this->getRedirect($request, $session);

        if($request->getMethod() === 'POST') {
            return $this->validateConsent($request, $session, $redirect);
        }

        $session->set(self::REDIRECT_ATTRIBUTE, $redirect);
        return new HtmlResponse($this->renderer->render(
            'app::oauth-consent',
            []
        ));
    }

    private function getRedirect(ServerRequestInterface $request, SessionInterface $session) : string 
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

    private function validateConsent(ServerRequestInterface $request, SessionInterface $session, string $redirect) : ResponseInterface
    {
        $requestData = $request->getParsedBody();
        $session->unset(self::REDIRECT_ATTRIBUTE);
        if(array_key_exists('allow', $requestData)) {
            $session->set('client_allowed', true);
        } elseif(array_key_exists('deny', $requestData)) {
            $session->set('client_allowed', false);
        }
        $queryParams = $session->get('oauth2_request_params');
        if($queryParams){
            $redirect .= '?';
            foreach($queryParams as $key => $value) {
                $redirect .= $key . '=' . $value . '&';
            }
        }
        return new RedirectResponse($redirect);
    }
}
