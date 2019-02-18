<?php

namespace App\Controller\Back;

use App\Entity\UserProject;
use App\Form\UserProjectType;
use App\Repository\UserProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/userProject", name="back_user_project_")
 */
class UserProjectController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(UserProjectRepository $userProjectRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('Back/user_project/index.html.twig', ['user_projects' => $userProjectRepository->findAll(), 'user' => $user]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(UserProject $userProject): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('Back/user_project/show.html.twig', ['user_project' => $userProject, 'user' => $user]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserProject $userProject): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $form = $this->createForm(UserProjectType::class, $userProject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_user_project_index', ['id' => $userProject->getId()]);
        }

        return $this->render('Back/user_project/edit.html.twig', [
            'user_project' => $userProject,
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
