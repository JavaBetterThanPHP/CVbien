<?php

namespace App\Controller\Front;

use App\Entity\UserSociety;
use App\Form\UserSocietyTypeFront;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/", name="front_user_experience_")
 */
class UserExperienceController extends AbstractController
{

    /**
     * @Route("/updateExp", name="update", methods={"GET","POST"})
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
            return $this->redirectToRoute('front_user_experience_update');
        }
        return $this->render('Front/user/user_update_info_society.html.twig', [
            'user' => $user,
            'formUserSocietyFront' => $formUserSocietyFront->createView(),
        ]);
    }

    /**
     * @Route("userExpDelete/{id}", name="delele", methods={"DELETE"})
     */
    public function useExpDelete(Request $request, UserSociety $userSociety): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userSociety->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userSociety);
            $entityManager->flush();
        }
        return $this->redirectToRoute('front_user_experience_update');
    }

    /**
     * @Route("userExpEdit/{id}", name="edit", methods={"GET","POST"}, options={"expose"=true})
     */
    public function userExpEdit(Request $request, UserSociety $userSociety): Response
    {
        $form = $this->createForm(UserSocietyTypeFront::class, $userSociety, [
            'action' => $this->generateUrl('front_user_experience_edit', ['id' => $userSociety->getId()])
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('front_user_experience_update');
        }
        return $this->render('Front/user/_modal_user_exp_edit.html.twig', [
            'formEditExp' => $form->createView(),
        ]);
    }
}