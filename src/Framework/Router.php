<?php

namespace Framework;

use Framework\Router\Route;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Register and match routes
 *
 */
class Router {

    /**
     * @param string $path
     * @param callable $callable
     * @param string $name
     * @return void
     */
    public function get(string $path, callable $callable, string $name)
    {


    }

    /**
     * @param ServerRequestInterface $request
     * @return Route|null
     */

    public function match(ServerRequestInterface $request): ?Route
    {

    }
}