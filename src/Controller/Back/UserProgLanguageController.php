<?php

namespace App\Controller\Back;

use App\Entity\UserProgLanguage;
use App\Form\UserProgLanguageType;
use App\Repository\UserProgLanguageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/userProgLanguage", name="back_user_prog_language_")
 */
class UserProgLanguageController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(UserProgLanguageRepository $userProgLanguageRepository): Response
    {
        return $this->render('Back/user_prog_language/index.html.twig', ['user_prog_languages' => $userProgLanguageRepository->findAll()]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $userProgLanguage = new UserProgLanguage();
        $form = $this->createForm(UserProgLanguageType::class, $userProgLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userProgLanguage);
            $entityManager->flush();

            return $this->redirectToRoute('back_user_prog_language_index');
        }

        return $this->render('Back/user_prog_language/new.html.twig', [
            'user_prog_language' => $userProgLanguage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(UserProgLanguage $userProgLanguage): Response
    {
        return $this->render('Back/user_prog_language/show.html.twig', ['user_prog_language' => $userProgLanguage]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserProgLanguage $userProgLanguage): Response
    {
        $form = $this->createForm(UserProgLanguageType::class, $userProgLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_user_prog_language_index', ['id' => $userProgLanguage->getId()]);
        }

        return $this->render('Back/user_prog_language/edit.html.twig', [
            'user_prog_language' => $userProgLanguage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, UserProgLanguage $userProgLanguage): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userProgLanguage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userProgLanguage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_user_prog_language_index');
    }
}
