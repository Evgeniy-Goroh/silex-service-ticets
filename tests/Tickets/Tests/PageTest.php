<?php

namespace Tickets\Tests;

use Silex\WebTestCase;
use Silex\Application;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\HttpFoundation\Request;

class PageTest extends WebTestCase
{
	
	public function createApplication()
	{
		$app = new Application();
		
		$app->match('/', function () {
			return 'main';
		});
		
		$app->match('/login', function () {
			return 'login';
		});
		
		return $app;
	}
	
	public function testInitialPage()
	{
		$client = $this->createClient();
		$client->request('GET', '/');
		$response = $client->getResponse();
		$this->assertTrue($response->isSuccessful());
		$this->assertEquals('main', $response->getContent());
	}
	
	public function testInitialPageLogin()
	{
		$client = $this->createClient();
		$client->request('GET', '/login');
		$response = $client->getResponse();
		$this->assertTrue($response->isSuccessful());
		$this->assertEquals('login', $response->getContent());
	}
	
	
}

?>