<?php 

namespace Tickets\Tests;

use PHPUnit\Framework\TestCase;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RouterTest extends TestCase
{
	public function testMapRouting()
	{
		$app = new Application();
		$app->match('/', function () {
			return 'main';
		});
		$app->match('/login', function () {
			return 'login';
		});
		
		$this->checkRouteResponse($app, '/login', 'login');
		$this->checkRouteResponse($app, '/', 'main');
		
	}
	
	public function testStatusCode()
	{
		$app = new Application();
		$app->put('/created', function () {
			return new Response('', 201);
		});
		$app->match('/forbidden', function () {
			return new Response('', 403);
		});
		$app->match('/not_found', function () {
			return new Response('', 404);
		});
		$request = Request::create('/created', 'put');
		$response = $app->handle($request);
		$this->assertEquals(201, $response->getStatusCode());
		
		$request = Request::create('/forbidden');
		$response = $app->handle($request);
		$this->assertEquals(403, $response->getStatusCode());
		
		$request = Request::create('/not_found');
		$response = $app->handle($request);
		$this->assertEquals(404, $response->getStatusCode());
	}
	
	public function testRedirect()
	{
		$app = new Application();
		
		$app->match('/redirect', function () {
			return new RedirectResponse('/target');
		});
		
		$request = Request::create('/redirect');
		$response = $app->handle($request);
		$this->assertTrue($response->isRedirect('/target'));
		
	}
	
	protected function checkRouteResponse(Application $app, $path, $expectedContent, $method = 'get', $message = null)
	{
		$request = Request::create($path, $method);
		$response = $app->handle($request);
		$this->assertEquals($expectedContent, $response->getContent(), $message);
	}
	
}