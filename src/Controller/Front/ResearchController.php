<?php

namespace App\Controller\Front;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/research", name="front_research_")
 */
class ResearchController extends AbstractController
{
    /**
     * @Route("/", name="index", methods="GET")
     */
    public function index(Request $request, UserRepository $userRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();


        return $this->render('Front/research/index.html.twig', [
            'user' => $user,
            'profileList' => $userRepository->findAll()
        ]);
    }
}