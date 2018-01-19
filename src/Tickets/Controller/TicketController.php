<?php 

namespace Tickets\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


class TicketController
{

	public function indexAction(Request $request, Application $app)
	{
		$data = array('name' => 'Ticket page');
		
		return $app['twig']->render('ticket.html.twig', $data);
	}
}
