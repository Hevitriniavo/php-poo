<?php

namespace unit\Framework;

use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase {
    public function testRedirectTrainingSlash(){
        $app = new App();
        $request = new ServerRequest("GET", "/demoslash/");
        $response = $app->run($request);

        $this->assertEquals('/demoslash', $response->getHeaderLine('Location'));
        $this->assertEquals(301, $response->getStatusCode());
    }

    public function testBlog(){
        $app = new App();
        $request = new ServerRequest("GET", "/blog");
        $response = $app->run($request);

        $this->assertStringContainsString('<h1>Bienvenue sur le blog</h1>', (string) $response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testError404(){
        $app = new App();
        $request = new ServerRequest("GET", "/aze");
        $response = $app->run($request);

        $this->assertStringContainsString('<h1>Erreur 404</h1>', (string) $response->getBody());
        $this->assertEquals(404, $response->getStatusCode());
    }
}
