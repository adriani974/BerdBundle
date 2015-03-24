<?php

namespace Berd\EventLogsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Berd\EventLogsBundle\Entity\TableEventLogs;
use Berd\EventLogsBundle\Form\TableEventLogsType;

/**
 * TableEventLogs controller.
 *
 */
class TableEventLogsController extends Controller
{

    /**
     * Lists all TableEventLogs entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BerdEventLogsBundle:TableEventLogs')->findAll();

        return $this->render('BerdEventLogsBundle:TableEventLogs:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TableEventLogs entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TableEventLogs();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tableeventlogs_show', array('id' => $entity->getId())));
        }

        return $this->render('BerdEventLogsBundle:TableEventLogs:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TableEventLogs entity.
     *
     * @param TableEventLogs $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TableEventLogs $entity)
    {
        $form = $this->createForm(new TableEventLogsType(), $entity, array(
            'action' => $this->generateUrl('tableeventlogs_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TableEventLogs entity.
     *
     */
    public function newAction()
    {
        $entity = new TableEventLogs();
        $form   = $this->createCreateForm($entity);

        return $this->render('BerdEventLogsBundle:TableEventLogs:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TableEventLogs entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdEventLogsBundle:TableEventLogs')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TableEventLogs entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BerdEventLogsBundle:TableEventLogs:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TableEventLogs entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdEventLogsBundle:TableEventLogs')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TableEventLogs entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BerdEventLogsBundle:TableEventLogs:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TableEventLogs entity.
    *
    * @param TableEventLogs $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TableEventLogs $entity)
    {
        $form = $this->createForm(new TableEventLogsType(), $entity, array(
            'action' => $this->generateUrl('tableeventlogs_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TableEventLogs entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdEventLogsBundle:TableEventLogs')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TableEventLogs entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tableeventlogs_edit', array('id' => $id)));
        }

        return $this->render('BerdEventLogsBundle:TableEventLogs:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TableEventLogs entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BerdEventLogsBundle:TableEventLogs')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TableEventLogs entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tableeventlogs'));
    }

    /**
     * Creates a form to delete a TableEventLogs entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tableeventlogs_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
