<?php

namespace Berd\EventLogsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BerdEventLogsBundle:Default:index.html.twig', array('name' => $name));
    }
}
