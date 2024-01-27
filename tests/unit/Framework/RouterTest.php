<?php

namespace unit\Framework;

use Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase {

    /**
     * @var Router
     */
    private $router ;

    public function setUp(): void
    {
        $this->router = new Router();
    }

    public function testGetMethod()
    {
        $request = new ServerRequest('GET', '/blog');
        $this->router->get('/blog', function (){return "hello";}, 'blog');
        $routes = $this->router->match($request);

        $this->assertEquals('/blog', $routes->getName());
        $this->assertEquals('hello', call_user_func_array($routes->getCallable(), [$request]));
    }

    public function testGetMethodWithParameter()
    {
        $request = new ServerRequest('GET', '/blog/mon-slog-8');
        $this->router->get('/blog', function (){return "hello";}, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function (){return "hello";}, 'post.show');
        $routes = $this->router->match($request);

        $this->assertEquals('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', $routes->getName());
        $this->assertEquals('hello', call_user_func_array($routes->getCallable(), [$request]));
        $this->assertEquals(["slug" => "mon-slog", "id" => '8'], $routes->getParams());
        //Invalid Url
        $routes = $this->router->match(new ServerRequest("GET", "/blog/mon_slug-8"));
        $this->assertEquals(null, $routes);
    }


    public function testGetMethodIfUrlDoesExist()
    {
        $request = new ServerRequest('GET', '/blog');
        $this->router->get('/blogaze', function (){return "hello";}, 'blog');
        $routes = $this->router->match($request);

        $this->assertEquals(null, $routes);
    }

    public function testGenerateUri()
    {
        $this->router->get('/blog', function (){return "hello";}, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function (){return "hello";}, 'post.show');
        $uri = $this->router->generateUri('post.show', ["slug" => "mon-article", "id" => '18']);

        $this->assertEquals("/blog/mon-article-18", $uri);
    }

}