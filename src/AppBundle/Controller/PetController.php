<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\ValidateTrait;

/**
 * Pet controller.
 *
 * @Route("pet")
 */
class PetController extends Controller
{
    use ValidateTrait;

    /**
     * Lists all pet entities.
     *
     * @Route("/", name="pet_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $word = $request->query->get('s', null);

        if (is_numeric($word)) {
            $pets = $em->getRepository(Pet::class)->findByChip($word);
        } elseif (self::isRut($word)) {
            $pets = $em->getRepository(Pet::class)->findByHumanRut($word);
        } elseif ($word) {
            $pets = $em->getRepository(Pet::class)->findByFirstname($word);
        } else {
            $pets = $em->getRepository(Pet::class)->findAll();
        }

        $forms = array();
        foreach ($pets as $pet) {
            $forms[$pet->getId()] = $this->createDeleteForm($pet)->createView();
        }

        return $this->render('pet/index.html.twig', array(
            'pets' => $pets,
            's' => $word,
            'forms' => $forms
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

            $this->addFlash(
                 'notice',
                 'Success new pet!'
             );

            return $this->redirectToRoute('pet_index');
        }

        $formHuman = $this->createForm('AppBundle\Form\HumanType', new \AppBundle\Entity\Human(), array(
            'action' => $this->generateUrl('api_post_human'),
            'method' => 'POST',
        ));

        return $this->render('pet/new.html.twig', array(
            'pet' => $pet,
            'form' => $form->createView(),
            'formHuman' => $formHuman->createView(),
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
        $editForm->remove('chip');
        $editForm->remove('human');
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                 'notice',
                 'Success edit!'
             );

            return $this->redirectToRoute('pet_index');
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

            $this->addFlash(
                 'notice',
                 'Success delete!'
             );
        } else {
            $this->addFlash(
                 'error',
                 'Error!'
             );
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
