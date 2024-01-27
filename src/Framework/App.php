<?php

namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{

    private $modules = [];
    /**
     * @param string[] $modules Liste de module à charger
     */
    public function __construct(array $modules = [])
    {
        foreach ($modules as $module){
            $this->modules[] = new $module();
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
        if ($uri === '/blog') {
            return new Response(200, [], '<h1>Bienvenue sur le blog</h1>');
        }

        return new Response(404, [], '<h1>Erreur 404</h1>');
    }
}
