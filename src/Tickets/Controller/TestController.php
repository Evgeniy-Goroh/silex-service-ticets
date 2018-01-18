<?php 

namespace Tickets\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class TestController
{

	public function testAction(Request $request, Application $app)
	{
		
		return $app['twig']->render('test.html.twig', $data);
	}
}
?>