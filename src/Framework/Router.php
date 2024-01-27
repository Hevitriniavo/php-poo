<?php

namespace Framework;

use Framework\Router\Route;
use Mezzio\Router\FastRouteRouter;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Register and match routes
 *
 */
class Router {

    /**
     * @var FastRouteRouter
     */
   private $router ;

    public function __construct()
    {
        $this->router = new FastRouteRouter();
    }

    /**
     * @param string $path
     * @param callable $callable
     * @param string $name
     * @return void
     */
    public function get(string $path, callable $callable, string $name)
    {
        $route = new \Mezzio\Router\Route($path, $callable, ['GET'], $name);
        $this->router->addRoute($route);
    }





    /**
     * @param ServerRequestInterface $request
     * @return Route|null
     */

    public function match(ServerRequestInterface $request): ?Route
    {
         $result =  $this->router->match($request);
         if ($result->isSuccess()){
             return new Route(
                 $result->getMatchedRouteName(),
                 $result->getMatchedMiddleware(),
                 $result->getMatchedParams()
             );
         }
         return null;
    }

    public function generateUri(string $name, array $params): ?string
    {
      return $this->router->generateUri($name, $params);
    }
}