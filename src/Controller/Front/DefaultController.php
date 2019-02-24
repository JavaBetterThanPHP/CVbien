<?php

namespace App\Controller\Front;

use App\Repository\ModuleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/", name="front_")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index", methods="GET")
     */
    public function index(Request $request, ModuleRepository $moduleRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        return $this->render('Front/user_index.html.twig', [
            'user' => $user,
            'edit' => true
            'moduleList' => $moduleRepository->findAll()
        ]);
    }
}