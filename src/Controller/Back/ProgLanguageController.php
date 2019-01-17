<?php

namespace App\Controller\Back;

use App\Entity\ProgLanguage;
use App\Form\ProgLanguageType;
use App\Repository\ProgLanguageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/prog/language", name="back_prog_language_")
 */
class ProgLanguageController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(ProgLanguageRepository $progLanguageRepository): Response
    {
        return $this->render('Back/prog_language/index.html.twig', ['prog_languages' => $progLanguageRepository->findAll()]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $progLanguage = new ProgLanguage();
        $form = $this->createForm(ProgLanguageType::class, $progLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($progLanguage);
            $entityManager->flush();

            return $this->redirectToRoute('back_prog_language_index');
        }

        return $this->render('Back/prog_language/new.html.twig', [
            'prog_language' => $progLanguage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(ProgLanguage $progLanguage): Response
    {
        return $this->render('Back/prog_language/show.html.twig', ['prog_language' => $progLanguage]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProgLanguage $progLanguage): Response
    {
        $form = $this->createForm(ProgLanguageType::class, $progLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_prog_language_index', ['id' => $progLanguage->getId()]);
        }

        return $this->render('Back/prog_language/edit.html.twig', [
            'prog_language' => $progLanguage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProgLanguage $progLanguage): Response
    {
        if ($this->isCsrfTokenValid('delete' . $progLanguage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($progLanguage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_prog_language_index');
    }
}