<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pet controller.
 *
 * @Route("pet")
 */
class PetController extends Controller
{
    /**
     * Lists all pet entities.
     *
     * @Route("/", name="pet_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pets = $em->getRepository('AppBundle:Pet')->findAll();

        return $this->render('pet/index.html.twig', array(
            'pets' => $pets,
        ));
    }

    /**
     * Creates a new pet entity.
     *
     * @Route("/new", name="pet_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pet = new Pet();
        $form = $this->createForm('AppBundle\Form\PetType', $pet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pet);
            $em->flush();

            return $this->redirectToRoute('pet_show', array('id' => $pet->getId()));
        }

        return $this->render('pet/new.html.twig', array(
            'pet' => $pet,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pet entity.
     *
     * @Route("/{id}", name="pet_show")
     * @Method("GET")
     */
    public function showAction(Pet $pet)
    {
        $deleteForm = $this->createDeleteForm($pet);

        return $this->render('pet/show.html.twig', array(
            'pet' => $pet,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pet entity.
     *
     * @Route("/{id}/edit", name="pet_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pet $pet)
    {
        $deleteForm = $this->createDeleteForm($pet);
        $editForm = $this->createForm('AppBundle\Form\PetType', $pet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pet_edit', array('id' => $pet->getId()));
        }

        return $this->render('pet/edit.html.twig', array(
            'pet' => $pet,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pet entity.
     *
     * @Route("/{id}", name="pet_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Pet $pet)
    {
        $form = $this->createDeleteForm($pet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pet);
            $em->flush();
        }

        return $this->redirectToRoute('pet_index');
    }

    /**
     * Creates a form to delete a pet entity.
     *
     * @param Pet $pet The pet entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pet $pet)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pet_delete', array('id' => $pet->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
