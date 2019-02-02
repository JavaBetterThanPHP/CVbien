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
            return $this->redirectToRoute('front_index');
        }

        return $this->render('Front/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/updateProfilePicture", name="updateProfilePicture", methods={"POST"})
     */
    public function updateProfilePicture(Request $request): Response
    {
        try {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $user = $this->getUser();
            $entityManager = $this->getDoctrine()->getManager();
            $user->setImageFile($request->files->get('data'));
            $entityManager->flush();
        } catch (exception $e) {

        }
        /*
        $form = $this->createForm(UserFrontType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('front_index');
        }else{
            return $this->render('Front/default/index.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }
        */
        return new Response("ok");
    }

    /**
     * @Route("/updateBanner", name="updateBanner", methods={"POST"})
     */
    public function updateBanner(Request $request): Response
    {
        try {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $user = $this->getUser();
            $entityManager = $this->getDoctrine()->getManager();
            $user->setBannerImageFile($request->files->get('data'));
            $entityManager->flush();
        } catch (exception $e) {

        }
        return new Response("ok");
    }

}