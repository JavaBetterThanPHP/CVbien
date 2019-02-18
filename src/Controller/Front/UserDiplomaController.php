<?php

namespace App\Controller\Front;

use App\Entity\UserDiploma;
use App\Form\UserDiplomaFrontType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/", name="front_user_diploma_")
 */
class UserDiplomaController extends AbstractController
{

    /**
     * @Route("/userUpdateDiploma", name="update", methods={"GET","POST"})
     */
    public function getUpdateUserDiploma(Request $request): Response
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
            return $this->redirectToRoute('front_user_diploma_update');
        }
        return $this->render('Front/user/user_update_info_diploma.html.twig', [
            'user' => $user,
            'formUserDiplomaFront' => $formUserDiplomaFront->createView(),
        ]);
    }

    /**
     * @Route("userDiplomaDelete/{id}", name="delete", methods={"DELETE"})
     */
    public function userDiplomaDelete(Request $request, UserDiploma $userDiploma): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userDiploma->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userDiploma);
            $entityManager->flush();
        }
        return $this->redirectToRoute('front_user_diploma_update');
    }

    /**
     * @Route("userDiplomaEdit/{id}", name="edit", methods={"GET","POST"}, options={"expose"=true})
     */
    public function userDiplomaEdit(Request $request, UserDiploma $userDiploma): Response
    {
        $form = $this->createForm(UserDiplomaFrontType::class, $userDiploma, [
            'action' => $this->generateUrl('front_user_diploma_edit', ['id' => $userDiploma->getId()])
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('front_user_diploma_update');
        }
        return $this->render('Front/user/_modal_user_diploma_edit.html.twig', [
            'formEditUserDiploma' => $form->createView(),
        ]);
    }
}