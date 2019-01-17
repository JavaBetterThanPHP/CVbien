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
 * @Route("/user/project", name="back_user_project_")
 */
class UserProjectController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(UserProjectRepository $userProjectRepository): Response
    {
        return $this->render('Back/user_project/index.html.twig', ['user_projects' => $userProjectRepository->findAll()]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $userProject = new UserProject();
        $form = $this->createForm(UserProjectType::class, $userProject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userProject);
            $entityManager->flush();

            return $this->redirectToRoute('back_user_project_index');
        }

        return $this->render('Back/user_project/new.html.twig', [
            'user_project' => $userProject,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(UserProject $userProject): Response
    {
        return $this->render('Back/user_project/show.html.twig', ['user_project' => $userProject]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserProject $userProject): Response
    {
        $form = $this->createForm(UserProjectType::class, $userProject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_user_project_index', ['id' => $userProject->getId()]);
        }

        return $this->render('Back/user_project/edit.html.twig', [
            'user_project' => $userProject,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, UserProject $userProject): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userProject->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userProject);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_user_project_index');
    }
}
