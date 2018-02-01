<?php
namespace Tickets\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class IndexController
{
	public function indexAction(Request $request, Application $app)
    {
    	
    	$data = array('test' => 'ert');
        
    	return $app['twig']->render('index.html.twig', $data);
    }
}
