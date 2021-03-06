<?php

namespace Berd\DashboardBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Berd\DashboardBundle\Entity\Requete;
use Berd\DashboardBundle\Entity\Params;
use Berd\DashboardBundle\Form\RequeteType;

/**
 * Requete controller.
 *
 * @Route("/requete")
 */
class RequeteController extends Controller
{
	/**
	* fonction contenant une liste d'opérateur
	* @return une liste d'opérateur
	*/
	function getOperators(){
		return [ '=', '<=', '>=', '<', '>', '!=', '<>'];
	}
	
	/**
	 * cette fonction est appeler dans createAction elle permet de recuperer les paramêtres d'une requête
	 * @param requete la requete sur laquel on extrait les paramêtres
     * @Route("/recupererParams", name="_recupererParams")
     */
	 function decouperRequeteAction($requete, $requeteId){
		//Sépare le corps des parametres
		$firstSplit = explode('WHERE', $requete);
		//Separe les mots dans la partie parametre et stockage dans des tableaux
		$secondSplit = explode(' ', $firstSplit[1]);
		$requestParams = [];
		$params = [];
		$requestParams['requestBody'] = $requete;
		$cpt = 0;
		$nbFields = 0;
		
		foreach($secondSplit as $segment){
			if( in_array( $segment , $this->getOperators()) ){
				$params['operator'] = $segment;
			}
			else{
				if(strpos($segment,':') !== false){
					if(strpos($segment,'(') !== false){//si des valeurs sont trouver on les récupèrent
						$recupValue = explode('(',$segment);
						$params['field'] = $recupValue[0];
						$recupValue = explode(')', $recupValue[1]);
						$params['value'] = $recupValue[0];
						$secondSplit[$cpt] = $params['field'];
						array_push($requestParams, $params);
						unset($params);
						unset($recupValue);
						$nbFields++;
						
					}else{//on récupère seulement le paramètre
						$params['field'] = $segment;
						array_push($requestParams, $params);
						unset($params);
						$nbFields++;
					}	
				}
			} 
			$cpt++;
		}
		//recompose le corp de la requête
		$parti1 = $firstSplit[0];
		$parti2 = implode(' ', $secondSplit);
		$requestParams['requestBody'] = $parti1.' WHERE '.$parti2; 
		
		$this->saveParamsAction($requestParams, $requeteId, $nbFields);
		
		return array('$requestParams' => $requestParams,);
	}

	/**
	*  cette fonction sauvegarde les params dans la table params
	*  @param requestParams est un tableau contenant les valeurs à sauvegarder
	*  @param requeteId est l'id de l'entité requete
	*  @param nbFields indique le nombre de champs à enregistrer
	*/
	function saveParamsAction($requestParams, $requeteId, $nbFields){
		
		for($cpt = 0; $cpt < $nbFields; $cpt++){
			$em= $this->getDoctrine()->getManager();
			$entity = new Params();
			$entity->setParamKey($requestParams[$cpt]['field']);
			if(isset($requestParams[$cpt]['value']) != null){$entity->setParamValue($requestParams[$cpt]['value']);}
			$entity->setOperator($requestParams[$cpt]['operator']);
			$entity->setRequete($requeteId);
			$entity->setUserId('7OwNzMxcQD');
			$em->persist($entity);
			$em->flush();
		}	
	}
	
	/**
	*	met à jour le champ body.
	*  @param id correspond à l'id de l'enregistrement qu'on souhaite mettre à jour
	*  @param body correspond à la nouvelle valeur qu'on souhaite sauvegarder
	*/
	function updateFieldBodyAction($id, $body)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdDashboardBundle:Requete')->find($id);
		$entity->setBody($body);
        $em->persist($entity);
        $em->flush();
    }
	
	////////////////////////////////CRUD////////////////////////////////////////////////////////
    /**
     * Lists all Requete entities.
     *
     * @Route("/", name="requete")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BerdDashboardBundle:Requete')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Requete entity.
     *
     * @Route("/create", name="requete_create")
     * @Method("POST")
     * @Template("BerdDashboardBundle:Requete:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Requete();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
		
		//récupération des valeurs issue du formulaire
		$stringTeste = $entity->getBody();
		
		//appel de la fonction : 
		$entity->setUserId('7OwNzMxcQD');
		
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
			
			$requestParams = $this->decouperRequeteAction($stringTeste, $entity);
			$requestParams2 = array_shift($requestParams);
			$body = array_shift($requestParams2);
			$requeteId = $entity->getId();
			
			$this->updateFieldBodyAction($requeteId, $body);

            return $this->redirect($this->generateUrl('requete_show', array('id' => $entity->getId())));
        }

        return array( 'entity' => $entity, 'form'   => $form->createView(), );
    }

    /**
     * Creates a form to create a Requete entity.
     *
     * @param Requete $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Requete $entity)
    {
        $form = $this->createForm(new RequeteType(), $entity, array(
            'action' => $this->generateUrl('requete_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Requete entity.
     *
     * @Route("/new", name="requete_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Requete();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Requete entity.
     *
     * @Route("/{id}", name="requete_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdDashboardBundle:Requete')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Requete entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Requete entity.
     *
     * @Route("/{id}/edit", name="requete_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdDashboardBundle:Requete')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Requete entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Requete entity.
    *
    * @param Requete $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Requete $entity)
    {
        $form = $this->createForm(new RequeteType(), $entity, array(
            'action' => $this->generateUrl('requete_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Requete entity.
     *
     * @Route("/{id}", name="requete_update")
     * @Method("PUT")
     * @Template("BerdDashboardBundle:Requete:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdDashboardBundle:Requete')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Requete entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('requete_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
	
	
    /**
     * Deletes a Requete entity.
     *
     * @Route("/{id}", name="requete_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BerdDashboardBundle:Requete')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Requete entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('requete'));
    }

    /**
     * Creates a form to delete a Requete entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('requete_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }	
}
