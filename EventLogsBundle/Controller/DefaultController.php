<?php

namespace Berd\EventLogsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('BerdEventLogsBundle:TableEventLogs')->findAll();
        $entities1 = $em->getRepository('BerdEventLogsBundle:Actions')->findAll();
		$entities2 = $em->getRepository('BerdEventLogsBundle:Device')->findAll();

        return $this->render('BerdEventLogsBundle:Default:index.html.twig', array(
            'entities' => $entities, 'entities1' => $entities1, 'entities2' => $entities2, ));
    }
	
	
}
