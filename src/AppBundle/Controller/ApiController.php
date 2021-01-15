<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Pet;

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
}
