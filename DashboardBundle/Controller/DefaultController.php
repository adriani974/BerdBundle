<?php

namespace Berd\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/dashboardDefaut")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('BerdDashboardBundle:Requete')->findAll();
        $entities1 = $em->getRepository('BerdDashboardBundle:RequestList')->findAll();
		$entities2 = $em->getRepository('BerdDashboardBundle:Results')->findAll();
        $entities3 = $em->getRepository('BerdDashboardBundle:Params')->findAll();
		$entities4 = $em->getRepository('BerdDashboardBundle:ResultFields')->findAll();

        return array('entities' => $entities, 'entities1' => $entities1, 'entities2' => $entities2, 
		             'entities3' => $entities3, 'entities4' => $entities4,);
    }
}
