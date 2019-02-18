<?php

namespace App\Controller\Back;

use App\Entity\UserDiploma;
use App\Form\UserDiplomaType;
use App\Repository\UserDiplomaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/userDiploma", name="back_user_diploma_")
 */
class UserDiplomaController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(UserDiplomaRepository $userDiplomaRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('Back/user_diploma/index.html.twig', ['user_diplomas' => $userDiplomaRepository->findAll(), 'user' => $user]);
    }


    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(UserDiploma $userDiploma): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('Back/user_diploma/show.html.twig', ['user_diploma' => $userDiploma, 'user' => $user]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserDiploma $userDiploma): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $form = $this->createForm(UserDiplomaType::class, $userDiploma);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_user_diploma_index', ['id' => $userDiploma->getId()]);
        }

        return $this->render('Back/user_diploma/edit.html.twig', [
            'user_diploma' => $userDiploma,
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
