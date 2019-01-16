<?php

namespace App\Controller;

use App\Entity\UserProjectProgLanguage;
use App\Form\UserProjectProgLanguageType;
use App\Repository\UserProjectProgLanguageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/project/prog/language")
 */
class UserProjectProgLanguageController extends AbstractController
{
    /**
     * @Route("/", name="user_project_prog_language_index", methods={"GET"})
     */
    public function index(UserProjectProgLanguageRepository $userProjectProgLanguageRepository): Response
    {
        return $this->render('user_project_prog_language/index.html.twig', ['user_project_prog_languages' => $userProjectProgLanguageRepository->findAll()]);
    }

    /**
     * @Route("/new", name="user_project_prog_language_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $userProjectProgLanguage = new UserProjectProgLanguage();
        $form = $this->createForm(UserProjectProgLanguageType::class, $userProjectProgLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userProjectProgLanguage);
            $entityManager->flush();

            return $this->redirectToRoute('user_project_prog_language_index');
        }

        return $this->render('user_project_prog_language/new.html.twig', [
            'user_project_prog_language' => $userProjectProgLanguage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_project_prog_language_show", methods={"GET"})
     */
    public function show(UserProjectProgLanguage $userProjectProgLanguage): Response
    {
        return $this->render('user_project_prog_language/show.html.twig', ['user_project_prog_language' => $userProjectProgLanguage]);
    }

    /**
     * @Route("/{id}/edit", name="user_project_prog_language_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserProjectProgLanguage $userProjectProgLanguage): Response
    {
        $form = $this->createForm(UserProjectProgLanguageType::class, $userProjectProgLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_project_prog_language_index', ['id' => $userProjectProgLanguage->getId()]);
        }

        return $this->render('user_project_prog_language/edit.html.twig', [
            'user_project_prog_language' => $userProjectProgLanguage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_project_prog_language_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UserProjectProgLanguage $userProjectProgLanguage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userProjectProgLanguage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userProjectProgLanguage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_project_prog_language_index');
    }
}
