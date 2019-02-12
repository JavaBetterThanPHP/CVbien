<?php

namespace App\Controller\Front;

use App\Entity\UserDiploma;
use App\Entity\UserLanguage;
use App\Entity\UserProgLanguage;
use App\Entity\UserSociety;
use App\Form\UserDiplomaFrontType;
use App\Form\UserFrontType;
use App\Form\UserLanguageFrontType;
use App\Form\UserProgLanguageFrontType;
use App\Form\UserSocietyTypeFront;
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

    /**
     * @Route("/updateInfo", name="updateInfo", methods={"GET","POST"})
     */
    public function updateInfo(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $formUserFront = $this->createForm(UserFrontType::class, $user);
        $formUserFront->handleRequest($request);
        if ($formUserFront->isSubmitted() && $formUserFront->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('front_user_updateInfo');
        }
        return $this->render('Front/user/user_update_info_perso.html.twig', [
            'user' => $user,
            'formUserFront' => $formUserFront->createView(),
        ]);
    }

    /**
     * @Route("/updatePro", name="updatePro", methods={"GET","POST"})
     */
    public function updatePro(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $userProgLanguage = new UserProgLanguage();
        $userProgLanguage->setUser($user);
        $formUserProgLanguage = $this->createForm(UserProgLanguageFrontType::class, $userProgLanguage);
        $formUserProgLanguage->handleRequest($request);
        if ($formUserProgLanguage->isSubmitted() && $formUserProgLanguage->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userProgLanguage);
            $entityManager->flush();
        }
        $userLanguage = new UserLanguage();
        $userLanguage->setUser($user);
        $formUserLanguage = $this->createForm(UserLanguageFrontType::class, $userLanguage);
        $formUserLanguage->handleRequest($request);
        if ($formUserLanguage->isSubmitted() && $formUserLanguage->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userLanguage);
            $entityManager->flush();
        }
        return $this->render('Front/user/user_update_info_pro.html.twig', [
            'user' => $user,
            'formUserProgLanguageFront' => $formUserProgLanguage->createView(),
            'formUserLanguageFront' => $formUserLanguage->createView(),
        ]);
    }

    /**
     * @Route("/updateExp", name="updateExp", methods={"GET","POST"})
     */
    public function updateExp(Request $request): Response
    {
        $user = $this->getUser();
        $userSociety = new UserSociety();
        $userSociety->setUser($user);
        $formUserSocietyFront = $this->createForm(UserSocietyTypeFront::class, $userSociety);
        $formUserSocietyFront->handleRequest($request);
        if ($formUserSocietyFront->isSubmitted() && $formUserSocietyFront->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userSociety);
            $entityManager->flush();
            // TODO return js response
        }
        return $this->render('Front/user/user_update_info_society.html.twig', [
            'user' => $user,
            'formUserSocietyFront' => $formUserSocietyFront->createView(),
        ]);
    }


    /**
     * @Route("/updateDiploma", name="updateDiploma", methods={"GET","POST"})
     */
    public function updateDiploma(Request $request): Response
    {
        $user = $this->getUser();
        $userDiploma = new UserDiploma();
        $userDiploma->setUser($user);
        $formUserDiplomaFront = $this->createForm(UserDiplomaFrontType::class, $userDiploma);
        $formUserDiplomaFront->handleRequest($request);
        if ($formUserDiplomaFront->isSubmitted() && $formUserDiplomaFront->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userDiploma);
            $entityManager->flush();
// TODO return js response
        }
        return $this->render('Front/user/user_update_info_diploma.html.twig', [
            'user' => $user,
            'formUserDiplomaFront' => $formUserDiplomaFront->createView(),
        ]);
    }

//$formUserSociety = $this->createForm(UserSocietyType::class, $user);
//$formUserSociety->handleRequest($request);
//if ($formUserSociety->isSubmitted() && $formUserSociety->isValid()) {
//    $this->getDoctrine()->getManager()->flush();
//    return $this->redirectToRoute('front_user_updateInfo');
//}


}