<?php

namespace Berd\DashboardBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Berd\DashboardBundle\Entity\ResultFields;
use Berd\DashboardBundle\Form\ResultFieldsType;

/**
 * ResultFields controller.
 *
 * @Route("/resultfields")
 */
class ResultFieldsController extends Controller
{

    /**
     * Lists all ResultFields entities.
     *
     * @Route("/", name="resultfields")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BerdDashboardBundle:ResultFields')->findAll();

        return array(
            'entities4' => $entities,
        );
    }
    /**
     * Creates a new ResultFields entity.
     *
     * @Route("/", name="resultfields_create")
     * @Method("POST")
     * @Template("BerdDashboardBundle:ResultFields:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ResultFields();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('resultfields_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ResultFields entity.
     *
     * @param ResultFields $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ResultFields $entity)
    {
        $form = $this->createForm(new ResultFieldsType(), $entity, array(
            'action' => $this->generateUrl('resultfields_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ResultFields entity.
     *
     * @Route("/new", name="resultfields_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ResultFields();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ResultFields entity.
     *
     * @Route("/{id}", name="resultfields_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdDashboardBundle:ResultFields')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ResultFields entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ResultFields entity.
     *
     * @Route("/{id}/edit", name="resultfields_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdDashboardBundle:ResultFields')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ResultFields entity.');
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
    * Creates a form to edit a ResultFields entity.
    *
    * @param ResultFields $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ResultFields $entity)
    {
        $form = $this->createForm(new ResultFieldsType(), $entity, array(
            'action' => $this->generateUrl('resultfields_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ResultFields entity.
     *
     * @Route("/{id}", name="resultfields_update")
     * @Method("PUT")
     * @Template("BerdDashboardBundle:ResultFields:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdDashboardBundle:ResultFields')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ResultFields entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('resultfields_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ResultFields entity.
     *
     * @Route("/{id}", name="resultfields_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BerdDashboardBundle:ResultFields')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ResultFields entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('resultfields'));
    }

    /**
     * Creates a form to delete a ResultFields entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('resultfields_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
