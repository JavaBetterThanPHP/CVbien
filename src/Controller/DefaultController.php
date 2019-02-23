<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/", name="app_")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index", methods="GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->render('Front/landing_page.html.twig');
    }

    /**
     * @Route("/u/{spaceName}", name="profilView")
     * @ParamConverter("user", options={"mapping"={"spaceName"="spaceName"}})
     *
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profilView(User $user)
    {
        if (is_null($user)) {
            throw $this->createNotFoundException('404');
        } else {
            if (!$user->getIsActive()) {
                $active_user = $this->getUser();
                if (!is_null($active_user) && $user->equals($active_user)) {
                    return $this->render('Front/user_index.html.twig', [
                        'user' => $user,
                        'edit' => false,
                        'warningNotActive' => true
                    ]);
                } else {
                    throw $this->createNotFoundException('404');
                }
            }

            return $this->render('Front/user_index.html.twig', [
                'user' => $user,
                'edit' => false,
                'warningNotActive' => false
            ]);
        }
    }
}