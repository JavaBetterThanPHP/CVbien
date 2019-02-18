<?php

namespace App\Controller\Back;

use App\Entity\UserSociety;
use App\Form\UserSocietyType;
use App\Repository\UserSocietyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/userSociety", name="back_user_society_")
 */
class UserSocietyController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(UserSocietyRepository $userSocietyRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('Back/user_society/index.html.twig', ['user_societies' => $userSocietyRepository->findAll(), 'user' => $user]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(UserSociety $userSociety): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('Back/user_society/show.html.twig', ['user_society' => $userSociety]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserSociety $userSociety): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $form = $this->createForm(UserSocietyType::class, $userSociety);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_user_society_index', ['id' => $userSociety->getId()]);
        }

        return $this->render('Back/user_society/edit.html.twig', [
            'user_society' => $userSociety,
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
