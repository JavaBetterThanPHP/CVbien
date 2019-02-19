<?php

namespace App\Controller\Front;

use App\Entity\UserLanguage;
use App\Entity\UserProgLanguage;
use App\Form\UserLanguageFrontType;
use App\Form\UserProgLanguageFrontType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/", name="front_user_pro_")
 */
class UserProController extends AbstractController
{

    /**
     * @Route("/updatePro", name="update", methods={"GET","POST"})
     */
    public function updatePro(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $userProgLanguage = new UserProgLanguage();
        $userProgLanguage->setUser($user);
        $formUserProgLanguage = $this->createForm(UserProgLanguageFrontType::class, $userProgLanguage);

        $userLanguage = new UserLanguage();
        $userLanguage->setUser($user);
        $formUserLanguage = $this->createForm(UserLanguageFrontType::class, $userLanguage);

        if ($request->request->has($formUserProgLanguage->getName())) {
            $formUserProgLanguage->handleRequest($request);
            if ($formUserProgLanguage->isSubmitted() && $formUserProgLanguage->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($userProgLanguage);
                $entityManager->flush();
                return $this->redirectToRoute('front_user_pro_update');
            }
        } elseif ($request->request->has($formUserLanguage->getName())) {
            $formUserLanguage->handleRequest($request);
            if ($formUserLanguage->isSubmitted() && $formUserLanguage->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($userLanguage);
                $entityManager->flush();
                return $this->redirectToRoute('front_user_pro_update');
            }
        }
        return $this->render('Front/user/user_update_info_pro.html.twig', [
            'user' => $user,
            'formUserProgLanguageFront' => $formUserProgLanguage->createView(),
            'formUserLanguageFront' => $formUserLanguage->createView(),
        ]);
    }

    /**
     * @Route("userProgLanguageDelete/{id}", name="prog_language_delete", methods={"DELETE"})
     */
    public function userProgLanguageDelete(Request $request, UserProgLanguage $userProgLanguage): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userProgLanguage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userProgLanguage);
            $entityManager->flush();
        }
        return $this->redirectToRoute('front_user_pro_update');
    }

    /**
     * @Route("userProgLanguageEdit/{id}", name="prog_language_edit", methods={"GET","POST"}, options={"expose"=true})
     */
    public function userProgLanguageEdit(Request $request, UserProgLanguage $userProgLanguage): Response
    {
        $form = $this->createForm(UserProgLanguageFrontType::class, $userProgLanguage, [
            'action' => $this->generateUrl('front_user_pro_prog_language_edit', ['id' => $userProgLanguage->getId()])
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('front_user_pro_update');
        }
        return $this->render('Front/user/_modal_user_progLanguage_edit.html.twig', [
            'formEditProgLanguage' => $form->createView(),
        ]);
    }

    /**
     * @Route("userLanguageDelete/{id}", name="language_delete", methods={"DELETE"})
     */
    public function userLanguageDelete(Request $request, UserLanguage $userLanguage): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userLanguage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userLanguage);
            $entityManager->flush();
        }
        return $this->redirectToRoute('front_user_pro_update');
    }

    /**
     * @Route("userLanguageEdit/{id}", name="language_edit", methods={"GET","POST"}, options={"expose"=true})
     */
    public function userLanguageEdit(Request $request, UserLanguage $userLanguage): Response
    {
        $form = $this->createForm(UserLanguageFrontType::class, $userLanguage, [
            'action' => $this->generateUrl('front_user_pro_language_edit', ['id' => $userLanguage->getId()])
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('front_user_pro_update');
        }
        return $this->render('Front/user/_modal_user_language_edit.html.twig', [
            'formEditLanguage' => $form->createView(),
        ]);
    }

}