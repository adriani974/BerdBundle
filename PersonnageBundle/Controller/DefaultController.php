<?php
namespace Berd\PersonnageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * 
     */
    public function indexAction()
    {
		$em = $this->getDoctrine()->getManager();

        $entities1 = $em->getRepository('BerdPersonnageBundle:Personnage')->findAll();
		$entities2 = $em->getRepository('BerdPersonnageBundle:Sac')->findAll();
		$entities3 = $em->getRepository('BerdPersonnageBundle:Items')->findAll();
		
        return $this->render('BerdPersonnageBundle:Default:index.html.twig', array(
            'entities1' => $entities1, 'entities2' => $entities2, 'entities3' => $entities3,
        ));
    }
}
