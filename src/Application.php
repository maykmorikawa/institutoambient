<?php
declare(strict_types=1);

namespace App;

use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Routing\Middleware\AssetMiddleware;
use Authentication\Middleware\AuthenticationMiddleware;
use Cake\Routing\Router;
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Psr\Http\Message\ServerRequestInterface;

class Application extends BaseApplication implements AuthenticationServiceProviderInterface
{
    public function bootstrap(): void
    {
        parent::bootstrap();

        // ✅ Carregar plugin de autenticação uma vez só
        $this->addPlugin('Authentication');

        if (PHP_SAPI !== 'cli') {
            FactoryLocator::add(
                'Table',
                (new TableLocator())->allowFallbackClass(false)
            );
        }
    }

    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        return $middlewareQueue
            // ✅ Middleware de autenticação antes do roteamento
            ->add(new AuthenticationMiddleware($this))

            // Middleware de roteamento
            ->add(new RoutingMiddleware($this))

            // BodyParser: trata JSON, XML, etc.
            ->add(new BodyParserMiddleware())

            // Proteção CSRF
            ->add(new CsrfProtectionMiddleware([
                'httponly' => true,
            ]));
    }

    public function services(ContainerInterface $container): void
    {
        // Aqui você pode registrar serviços se quiser usar injeção de dependência
    }

    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new AuthenticationService([
            'unauthenticatedRedirect' => Router::url('/login'),
            'queryParam' => 'redirect',
        ]);

        // Identificador: onde o Cake verifica usuário/senha
        $service->loadIdentifier('Authentication.Password', [
            'fields' => [
                'username' => 'email',
                'password' => 'password',
            ],
        ]);

        // Autenticadores (ordem importa!)
        $service->loadAuthenticator('Authentication.Session');
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => [
                'username' => 'email',
                'password' => 'password',
            ],
            'loginUrl' => '/login',
        ]);

        return $service;
    }
}
