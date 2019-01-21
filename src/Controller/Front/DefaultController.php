<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="front_index", methods="GET")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $profilePicture = stream_get_contents($user->getProfilePicture());
        return $this->render('Front/Default/index.html.twig',[
            'user' => $user,
            'profilePicture' => $profilePicture
        ]);
    }
}