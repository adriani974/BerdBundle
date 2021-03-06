<?php

namespace Berd\PersonnageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Berd\PersonnageBundle\Entity\Sac;
use Berd\PersonnageBundle\Form\SacType;

/**
 * Sac controller.
 *
 */
class SacController extends Controller
{

    /**
     * Lists all Sac entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BerdPersonnageBundle:Sac')->findAll();

        return $this->render('BerdPersonnageBundle:Sac:index.html.twig', array(
            'entities2' => $entities2,
        ));
    }
    /**
     * Creates a new Sac entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Sac();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('sac_show', array('id' => $entity->getId())));
        }

        return $this->render('BerdPersonnageBundle:Sac:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Sac entity.
     *
     * @param Sac $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Sac $entity)
    {
        $form = $this->createForm(new SacType(), $entity, array(
            'action' => $this->generateUrl('sac_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Sac entity.
     *
     */
    public function newAction()
    {
        $entity = new Sac();
        $form   = $this->createCreateForm($entity);

        return $this->render('BerdPersonnageBundle:Sac:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Sac entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdPersonnageBundle:Sac')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sac entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BerdPersonnageBundle:Sac:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Sac entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdPersonnageBundle:Sac')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sac entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BerdPersonnageBundle:Sac:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Sac entity.
    *
    * @param Sac $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Sac $entity)
    {
        $form = $this->createForm(new SacType(), $entity, array(
            'action' => $this->generateUrl('sac_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Sac entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdPersonnageBundle:Sac')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sac entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('sac_edit', array('id' => $id)));
        }

        return $this->render('BerdPersonnageBundle:Sac:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Sac entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BerdPersonnageBundle:Sac')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Sac entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('sac'));
    }

    /**
     * Creates a form to delete a Sac entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sac_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
