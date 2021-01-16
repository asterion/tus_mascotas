<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Pet;
use AppBundle\Entity\Human;
use Symfony\Component\HttpFoundation\Request;

/**
 * Api controller.
 *
 * @Route("/api")
 */
class ApiController extends Controller
{
    /**
     * @Route("/pet/{chip}", methods={"GET"}, requirements={"chip"="\d+"})
     */
    public function petAction($chip)
    {
        $em = $this->getDoctrine()->getManager();
        $pet = $em->getRepository('AppBundle:Pet')->findByChip($chip);

        if (! $pet ) {
            return $this->json([], 404, array(
                'Content-Type' => 'application/json'
            ));
        } else {
            return $this->json($pet, 200, array(
                'Content-Type' => 'application/json'
            ));
        }
    }

    /**
     * @Route("/human", methods={"POST"}, name="api_post_human")
     */
    public function humanAction(Request $request)
    {
        $human = new Human();

        $form = $this->createForm('AppBundle\Form\HumanType', $human);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($human);
            $em->flush();
        } else {
            foreach ($form->getErrors() as $error) {
                $errors[$form->getName()][] = $error->getMessage();
            }

            foreach ($form as $child) {
                if (!$child->isValid()) {
                    foreach ($child->getErrors() as $error) {
                        $errors[$child->getName()][] = $error->getMessage();
                    }
                }
            }

            return $this->json($errors, 400, array(
                'Content-Type' => 'application/json'
            ));
        }

        return $this->json($human, 201, array(
            'Content-Type' => 'application/json'
        ));
    }
}
