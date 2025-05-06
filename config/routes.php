<?php

/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Route\Route;


/*
 * This file is loaded in the context of the `Application` class.
 * So you can use `$this` to reference the application class instance
 * if required.
 */

return function (RouteBuilder $routes): void {
     /*
     * The default class to use for all routes
     *
     * The following route classes are supplied with CakePHP and are appropriate
     * to set as the default:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * If no call is made to `Router::defaultRouteClass()`, the class used is
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Note that `Route` does not do any inflections on URLs which will result in
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
     $routes->setRouteClass(Route::class);


     $routes->scope('/', function (RouteBuilder $builder): void {
          $builder->setRouteClass(DashedRoute::class);
     
          // ROTAS ESPECÍFICAS PRIMEIRO
          $builder->connect('/', ['controller' => 'Pages', 'action' => 'manutencao']);
          $builder->connect('/home', ['controller' => 'Pages', 'action' => 'home']);
          $builder->connect('/quem_somos', ['controller' => 'Pages', 'action' => 'display', 'quemsomos']);
          $builder->connect('/conselho', ['controller' => 'Pages', 'action' => 'display', 'conselho']);
          $builder->connect('/transparencia', ['controller' => 'Pages', 'action' => 'display', 'transparencia']);
          $builder->connect('/galeria_de_videos', ['controller' => 'Pages', 'action' => 'display', 'videos']);
     
          // 🔥 SUA ROTA PERSONALIZADA AQUI
          $builder->connect(
          '/noticia/:slug',
          ['controller' => 'Pages', 'action' => 'view'],
          ['pass' => ['slug'], 'slug' => '[a-z0-9\-]+']
          );
     
          $builder->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);
     
          // ✅ CHAME O Fallbacks **DENTRO** do escopo
          $builder->fallbacks(DashedRoute::class);
     
          /*
         * Connect catchall routes for all controllers.
         *
         * The `fallbacks` method is a shortcut for
         *
         * ```
         * $builder->connect('/{controller}', ['action' => 'index']);
         * $builder->connect('/{controller}/{action}/*', []);
         * ```
         *
         * It is NOT recommended to use fallback routes after your initial prototyping phase!
         * See https://book.cakephp.org/5/en/development/routing.html#fallbacks-method for more information
         */
     });

        // Prefixo Admin
     $routes->prefix('Admin', ['path' => '/admin'], function (RouteBuilder $builder): void {
               $builder->setRouteClass(DashedRoute::class);
                $builder->connect('/', ['controller' => 'Users', 'action' => 'admin']); // opcional

               $builder->connect('/login', ['controller' => 'Users', 'action' => 'login']);
               $builder->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
               $builder->fallbacks(DashedRoute::class);
     });
     

        // Fallback geral (redundante mas seguro em casos específicos)
     $routes->fallbacks(DashedRoute::class);
     /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder): void {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */
};
