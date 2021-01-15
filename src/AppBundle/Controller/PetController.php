<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $word = $request->query->get('s', null);

        if (is_numeric($word)) {
            $pets = $em->getRepository(Pet::class)->findByChip($word);
        } elseif ($this->isRut($word)) {
            $pets = $em->getRepository(Pet::class)->findByHumanRut($word);
        } elseif ($word) {
            $pets = $em->getRepository(Pet::class)->findByFirstname($word);
        } else {
            $pets = $em->getRepository(Pet::class)->findAll();
        }

        return $this->render('pet/index.html.twig', array(
            'pets' => $pets,
            's' => $word,
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

    protected function isRut($rut)
    {
        $rut = preg_replace('/[^0-9kK]/', '', $rut);

        $dv = mb_strtoupper(substr($rut, -1));
        $rut = substr($rut, 0, strlen($rut)-1);

        $s=1;

        for($m=0;$rut!=0;$rut/=10) {
            $s=($s+$rut%10*(9-$m++%6))%11;
        }

        return chr($s?$s+47:75) == $dv;
    }
}
