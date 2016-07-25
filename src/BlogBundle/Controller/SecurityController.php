<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $sec = $this->get('security.authentication_utils');
        $error = $sec->getLastAuthenticationError();
        $lastUsername = $sec->getLastUsername();
    
    
    
        return $this->render('BlogBundle:Security:login.html.twig', array(
                  'last_username' => $lastUsername,
                  'error'         => $error
              ));
    }   
}
