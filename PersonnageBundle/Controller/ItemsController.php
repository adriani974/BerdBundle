<?php

namespace Berd\PersonnageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Berd\PersonnageBundle\Entity\Items;
use Berd\PersonnageBundle\Form\ItemsType;

/**
 * Items controller.
 *
 */
class ItemsController extends Controller
{

    /**
     * Lists all Items entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BerdPersonnageBundle:Items')->findAll();

        return $this->render('BerdPersonnageBundle:Items:index.html.twig', array(
            'entities3' => $entities3,
        ));
    }
    /**
     * Creates a new Items entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Items();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('items_show', array('id' => $entity->getId())));
        }

        return $this->render('BerdPersonnageBundle:Items:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Items entity.
     *
     * @param Items $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Items $entity)
    {
        $form = $this->createForm(new ItemsType(), $entity, array(
            'action' => $this->generateUrl('items_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Items entity.
     *
     */
    public function newAction()
    {
        $entity = new Items();
        $form   = $this->createCreateForm($entity);

        return $this->render('BerdPersonnageBundle:Items:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Items entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdPersonnageBundle:Items')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Items entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BerdPersonnageBundle:Items:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Items entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdPersonnageBundle:Items')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Items entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BerdPersonnageBundle:Items:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Items entity.
    *
    * @param Items $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Items $entity)
    {
        $form = $this->createForm(new ItemsType(), $entity, array(
            'action' => $this->generateUrl('items_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Items entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdPersonnageBundle:Items')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Items entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('items_edit', array('id' => $id)));
        }

        return $this->render('BerdPersonnageBundle:Items:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Items entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BerdPersonnageBundle:Items')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Items entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('items'));
    }

    /**
     * Creates a form to delete a Items entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('items_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
