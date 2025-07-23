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
use Cake\Routing\Middleware\AssetMiddleware; // Não está sendo usado, pode remover se não precisar
use Authentication\Middleware\AuthenticationMiddleware;
use Cake\Routing\Router;
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Event\AtividadeListener;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Event\EventManagerInterface;

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

    public function events(EventManagerInterface $eventManager): EventManagerInterface
    {
        parent::events($eventManager);

        // Registra seu listener aqui
        $eventManager->on(new AtividadeListener());

        return $eventManager;
    }

    /**
     * Define the HTTP middleware layers for this application.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to update.
     * @return \Cake\Http\MiddlewareQueue
     * @throws \Exception
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        return $middlewareQueue
            // Manipulador de erros deve ser o primeiro para capturar exceções dos outros middlewares.
            ->add(new ErrorHandlerMiddleware())

            // O middleware de ativos é importante para servir arquivos estáticos.
            // Geralmente vem antes do roteamento, mas depois de manipuladores de erro.
            // Eu o adicionei aqui, pois você o importou mas não o usou.
            ->add(new AssetMiddleware([
                'cacheTime' => '+1 year'
            ]))

            // ✅ Middleware de autenticação antes do roteamento para proteger as rotas.
            // Certifique-se de que a rota de login esteja pública ou o middleware permita.
            ->add(new AuthenticationMiddleware($this))

            // Middleware de roteamento: lê o URL e direciona para a ação do controller.
            // Este middleware deve vir antes do BodyParser e CSRF, pois eles dependem da rota.
            ->add(new RoutingMiddleware($this))

            // BodyParser: trata dados de requisições POST (JSON, XML, form-urlencoded).
            // Deve vir depois do roteamento para que a rota possa ser determinada primeiro.
            ->add(new BodyParserMiddleware())

            // Proteção CSRF: sempre por último entre os principais middlewares para proteger os formulários.
            // Depende do BodyParser para que os dados POST já estejam disponíveis.
            ->add(new CsrfProtectionMiddleware([
                'httponly' => true,
            ]));
    }

    public function services(ContainerInterface $container): void
    {
        // Aqui você pode registrar serviços se quiser usar injeção de dependência
        // Para o seu caso atual, este método pode permanecer vazio ou ser removido se não for usado.
    }

    /**
     * Returns an authentication service instance for the request.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @return \Authentication\AuthenticationServiceInterface
     */
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new AuthenticationService([
            // Redireciona para esta URL se o usuário não estiver autenticado
            'unauthenticatedRedirect' => Router::url('/admin/login'),
            'queryParam' => 'redirect', // Nome do parâmetro de query para redirecionar após o login
        ]);

        // Identificador: onde o Cake verifica usuário/senha
        // Usando o identificador 'Authentication.Password' para verificar credenciais no banco de dados.
        $service->loadIdentifier('Authentication.Password', [
            'fields' => [
                'username' => 'email', // Campo do seu banco de dados para o username
                'password' => 'password', // Campo do seu banco de dados para a senha
            ],
            // 'resolver' => 'Authentication.Orm', // Padrão se não especificado, usa OrmResolver
            // 'userModel' => 'Users', // Padrão é 'Users', mude se seu modelo de usuário for outro (ex: 'MeusUsuarios')
        ]);

        // Autenticadores (ordem importa! A sessão geralmente vem primeiro)
        // 1. SessionAuthenticator: Verifica se o usuário já está logado na sessão.
        $service->loadAuthenticator('Authentication.Session');

        // 2. FormAuthenticator: Lida com submissões de formulário de login.
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => [
                'username' => 'email', // Campos esperados no formulário de login
                'password' => 'password',
            ],
            'loginUrl' => '/admin/login', // URL para o formulário de login
            // 'urlChecker' => 'Authentication.Callback', // Para controlar onde o form authenticator deve agir
            // 'urlChecker' => [
            //     'loginUrl' => '/admin/login',
            //     'checkAll' => false,
            //     'allowedUris' => [],
            // ],
        ]);

        return $service;
    }
}