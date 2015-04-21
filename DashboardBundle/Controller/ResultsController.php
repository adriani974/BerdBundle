<?php

namespace Berd\DashboardBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Berd\DashboardBundle\Entity\Results;
use Berd\DashboardBundle\Form\ResultsType;

/**
 * Results controller.
 *
 * @Route("/results")
 */
class ResultsController extends Controller
{

    /**
     * Lists all Results entities.
     *
     * @Route("/", name="results")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BerdDashboardBundle:Results')->findAll();

        return array(
            'entities2' => $entities,
        );
    }
    /**
     * Creates a new Results entity.
     *
     * @Route("/", name="results_create")
     * @Method("POST")
     * @Template("BerdDashboardBundle:Results:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Results();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('results_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Results entity.
     *
     * @param Results $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Results $entity)
    {
        $form = $this->createForm(new ResultsType(), $entity, array(
            'action' => $this->generateUrl('results_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Results entity.
     *
     * @Route("/new", name="results_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Results();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Results entity.
     *
     * @Route("/{id}", name="results_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdDashboardBundle:Results')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Results entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Results entity.
     *
     * @Route("/{id}/edit", name="results_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdDashboardBundle:Results')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Results entity.');
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
    * Creates a form to edit a Results entity.
    *
    * @param Results $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Results $entity)
    {
        $form = $this->createForm(new ResultsType(), $entity, array(
            'action' => $this->generateUrl('results_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Results entity.
     *
     * @Route("/{id}", name="results_update")
     * @Method("PUT")
     * @Template("BerdDashboardBundle:Results:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdDashboardBundle:Results')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Results entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('results_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Results entity.
     *
     * @Route("/{id}", name="results_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BerdDashboardBundle:Results')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Results entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('results'));
    }

    /**
     * Creates a form to delete a Results entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('results_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
