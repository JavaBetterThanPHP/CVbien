<?php

namespace App\Controller\Back;

use App\Entity\UserLanguage;
use App\Form\UserLanguageType;
use App\Repository\UserLanguageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/userLanguage", name="back_user_language_")
 */
class UserLanguageController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(UserLanguageRepository $userLanguageRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('Back/user_language/index.html.twig', ['user_languages' => $userLanguageRepository->findAll(), 'user' => $user]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(UserLanguage $userLanguage): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('Back/user_language/show.html.twig', ['user_language' => $userLanguage, 'user' => $user]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserLanguage $userLanguage): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $form = $this->createForm(UserLanguageType::class, $userLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_user_language_index', ['id' => $userLanguage->getId()]);
        }

        return $this->render('Back/user_language/edit.html.twig', [
            'user_language' => $userLanguage,
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
