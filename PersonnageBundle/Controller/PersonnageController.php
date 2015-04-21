<?php

namespace Berd\PersonnageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Berd\PersonnageBundle\Entity\Personnage;
use Berd\PersonnageBundle\Form\PersonnageType;

/**
 * Personnage controller.
 *
 */
class PersonnageController extends Controller
{

    /**
     * Lists all Personnage entities.
     *
     */
    public function indexAction()
    {
		//$antispam = $this->get('berd_personnage.antispam');
		
        $em = $this->getDoctrine()->getManager();

        $entities1 = $em->getRepository('BerdPersonnageBundle:Personnage')->findAll();

        return $this->render('BerdPersonnageBundle:Personnage:index.html.twig', array(
            'entities1' => $entities1,
        ));
    }
    /**
     * Creates a new Personnage entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Personnage();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('personnage_show', array('id' => $entity->getId())));
        }

        return $this->render('BerdPersonnageBundle:Personnage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Personnage entity.
     *
     * @param Personnage $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Personnage $entity)
    {
        $form = $this->createForm(new PersonnageType(), $entity, array(
            'action' => $this->generateUrl('personnage_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Personnage entity.
     *
     */
    public function newAction()
    {
        $entity = new Personnage();
        $form   = $this->createCreateForm($entity);

        return $this->render('BerdPersonnageBundle:Personnage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Personnage entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdPersonnageBundle:Personnage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Personnage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BerdPersonnageBundle:Personnage:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Personnage entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdPersonnageBundle:Personnage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Personnage entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BerdPersonnageBundle:Personnage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Personnage entity.
    *
    * @param Personnage $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Personnage $entity)
    {
        $form = $this->createForm(new PersonnageType(), $entity, array(
            'action' => $this->generateUrl('personnage_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Personnage entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdPersonnageBundle:Personnage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Personnage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('personnage_edit', array('id' => $id)));
        }

        return $this->render('BerdPersonnageBundle:Personnage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Personnage entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BerdPersonnageBundle:Personnage')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Personnage entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('personnage'));
    }

    /**
     * Creates a form to delete a Personnage entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('personnage_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
