<?php

namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{

    /**
     * List of modules
     * @var array
     */
    private $modules = [];
    /**
     * @param string[] $modules Liste de module à charger
     */

    /**
     * Router
     * @var Router
     */
    private $router;

    public function __construct(array $modules = [])
    {
        $this->router = new Router();
        foreach ($modules as $module){
            $this->modules[] = new $module($this->router);
        }
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && $uri !== "/" && $uri !== rtrim($uri, "/")) {
            return (new Response())
                ->withStatus(301)
                ->withHeader("Location", substr($uri, 0, -1));
        }
       $router = $this->router->match($request);
        if (is_null($router)){
            return new Response(404, [], '<h1>Erreur 404</h1>');
        }
        $params = $router->getParams();
        $request = array_reduce(array_keys($params), function ($request, $key) use ($params){
            return $request->withAttribute($key, $params[$key]);
        }, $request);
        $response = call_user_func_array($router->getCallable(), [$request]);
        if (is_string($response)){
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
           return $response;
        } else {
            throw new \Exception('The response is not a string or an instance of ResponseInterface');
        }
    }
}
