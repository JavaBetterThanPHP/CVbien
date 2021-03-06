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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('Back/user_prog_language/index.html.twig', ['user_prog_languages' => $userProgLanguageRepository->findAll(), 'user' => $user]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(UserProgLanguage $userProgLanguage): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('Back/user_prog_language/show.html.twig', ['user_prog_language' => $userProgLanguage, 'user' => $user]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserProgLanguage $userProgLanguage): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $form = $this->createForm(UserProgLanguageType::class, $userProgLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_user_prog_language_index', ['id' => $userProgLanguage->getId()]);
        }

        return $this->render('Back/user_prog_language/edit.html.twig', [
            'user_prog_language' => $userProgLanguage,
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
