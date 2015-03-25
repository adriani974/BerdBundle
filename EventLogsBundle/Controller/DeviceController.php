<?php

namespace Berd\EventLogsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Berd\EventLogsBundle\Entity\Device;
use Berd\EventLogsBundle\Form\DeviceType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Device controller.
 *
 */
class DeviceController extends Controller
{

    /**
     * Lists all Device entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities2 = $em->getRepository('BerdEventLogsBundle:Device')->findAll();
		
        return $this->render('BerdEventLogsBundle:Device:index.html.twig', array(
            'entities2' => $entities2, 
        ));
    }
    
    /**
     * Creates a new Device entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Device();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('device_show', array('id' => $entity->getId())));
        }

        return $this->render('BerdEventLogsBundle:Device:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Device entity.
     *
     * @param Device $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Device $entity)
    {
        $form = $this->createForm(new DeviceType(), $entity, array(
            'action' => $this->generateUrl('device_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Device entity.
     *
     */
    public function newAction()
    {
        $entity = new Device();
        $form   = $this->createCreateForm($entity);

        return $this->render('BerdEventLogsBundle:Device:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Device entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdEventLogsBundle:Device')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Device entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BerdEventLogsBundle:Device:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Device entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdEventLogsBundle:Device')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Device entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BerdEventLogsBundle:Device:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Device entity.
    *
    * @param Device $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Device $entity)
    {
        $form = $this->createForm(new DeviceType(), $entity, array(
            'action' => $this->generateUrl('device_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Device entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdEventLogsBundle:Device')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Device entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('device_edit', array('id' => $id)));
        }

        return $this->render('BerdEventLogsBundle:Device:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Device entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BerdEventLogsBundle:Device')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Device entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('device'));
    }

    /**
     * Creates a form to delete a Device entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('device_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
	
	/**
	* Vérifie si l'appareil connecter est enregistrer dans la table device, si c'est pas le cas 
	* je l'enregistre dans la table Device et on renvoie la clé primaire
	*/
	public function findDeviceAction($deviceId){
		//vérifions si deviceId existe déjà dans ma table Device
		/*$resultat = findDeviceInTable($deviceId);
		
		if($resultat){
			$clePrimaire = getDeviceIdTable($deviceId);
		}else{
			
		}
		return $clePrimaire;*/
	}
	
	public function helloAction(){
		return new Response('bonjour ca va');
	}
}
