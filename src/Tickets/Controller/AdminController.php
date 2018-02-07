<?php 

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


class AdminController
{

    public function indexAction(Request $request, Application $app)
    {
        
        $token = $app['security.token_storage']->getToken();
        if (null !== $token) {
            $user = $token->getUser();
        }
        
        
        $data = array('name' => $user->getUserName());
        
        return $app['twig']->render('admin.html.twig', $data);
    }
}
