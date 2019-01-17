<?php

namespace App\Controller\Front;

use App\Form\UserFrontType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="front_user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $form = $this->createForm(UserFrontType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('front_index', ['id' => $user->getId()]);
        }

        return $this->render('Front/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}