<?php

namespace unit\Framework;

use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase {

    public function setUp(): void
    {
        $this->router = new Router();
    }

    public function testGetMethod()
    {
        $request = new Request('GET', '/blog');
        $this->router->get('/blog', function (){return "hello";}, 'blog');
        $routes = $this->router->match($request);

        $this->assertEquals('blog', $routes->getName());
        $this->assertEquals('hello', call_user_func_array($routes->getCallback(), [$request]));
    }

    public function testGetMethodIfUrlDoesExist()
    {
        $request = new Request('GET', '/blog');
        $this->router->get('/blogaze', function (){return "hello";}, 'blog');
        $routes = $this->router->match($request);

        $this->assertEquals(null, $routes);
    }

    public function testGetMethodWithParameter()
    {
        $request = new Request('GET', '/blog/mon-slog-8');
        $this->router->get('/blog', function (){return "hello";}, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function (){return "hello";}, 'post.show');
        $routes = $this->router->match($request);

        $this->assertEquals('post.show', $routes->getName());
        $this->assertEquals('hello', call_user_func_array($routes->getCallback(), [$request]));
        $this->assertEquals(["slug" => "mon-slog", "id" => '8'], $routes->getParameters);
    }
}