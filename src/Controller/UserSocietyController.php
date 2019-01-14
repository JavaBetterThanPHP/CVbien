<?php

namespace App\Controller;

use App\Entity\UserSociety;
use App\Form\UserSocietyType;
use App\Repository\UserSocietyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/society")
 */
class UserSocietyController extends AbstractController
{
    /**
     * @Route("/", name="user_society_index", methods={"GET"})
     */
    public function index(UserSocietyRepository $userSocietyRepository): Response
    {
        return $this->render('user_society/index.html.twig', ['user_societies' => $userSocietyRepository->findAll()]);
    }

    /**
     * @Route("/new", name="user_society_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $userSociety = new UserSociety();
        $form = $this->createForm(UserSocietyType::class, $userSociety);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userSociety);
            $entityManager->flush();

            return $this->redirectToRoute('user_society_index');
        }

        return $this->render('user_society/new.html.twig', [
            'user_society' => $userSociety,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_society_show", methods={"GET"})
     */
    public function show(UserSociety $userSociety): Response
    {
        return $this->render('user_society/show.html.twig', ['user_society' => $userSociety]);
    }

    /**
     * @Route("/{id}/edit", name="user_society_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserSociety $userSociety): Response
    {
        $form = $this->createForm(UserSocietyType::class, $userSociety);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_society_index', ['id' => $userSociety->getId()]);
        }

        return $this->render('user_society/edit.html.twig', [
            'user_society' => $userSociety,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_society_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UserSociety $userSociety): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userSociety->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userSociety);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_society_index');
    }
}
