<?php

namespace App\Controller\Back;

use App\Entity\UserStatus;
use App\Form\UserStatusType;
use App\Repository\UserStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/status", name="back_user_status_")
 */
class UserStatusController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(UserStatusRepository $userStatusRepository): Response
    {
        return $this->render('Back/user_status/index.html.twig', ['user_statuses' => $userStatusRepository->findAll()]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $userStatus = new UserStatus();
        $form = $this->createForm(UserStatusType::class, $userStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userStatus);
            $entityManager->flush();

            return $this->redirectToRoute('back_user_status_index');
        }

        return $this->render('Back/user_status/new.html.twig', [
            'user_status' => $userStatus,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(UserStatus $userStatus): Response
    {
        return $this->render('Back/user_status/show.html.twig', ['user_status' => $userStatus]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserStatus $userStatus): Response
    {
        $form = $this->createForm(UserStatusType::class, $userStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_user_status_index', ['id' => $userStatus->getId()]);
        }

        return $this->render('Back/user_status/edit.html.twig', [
            'user_status' => $userStatus,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, UserStatus $userStatus): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userStatus->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userStatus);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_user_status_index');
    }
}
