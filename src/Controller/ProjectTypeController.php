<?php

namespace App\Controller;

use App\Entity\ProjectType;
use App\Form\ProjectTypeType;
use App\Repository\ProjectTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/project/type")
 */
class ProjectTypeController extends AbstractController
{
    /**
     * @Route("/", name="project_type_index", methods={"GET"})
     */
    public function index(ProjectTypeRepository $projectTypeRepository): Response
    {
        return $this->render('project_type/index.html.twig', ['project_types' => $projectTypeRepository->findAll()]);
    }

    /**
     * @Route("/new", name="project_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $projectType = new ProjectType();
        $form = $this->createForm(ProjectTypeType::class, $projectType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projectType);
            $entityManager->flush();

            return $this->redirectToRoute('project_type_index');
        }

        return $this->render('project_type/new.html.twig', [
            'project_type' => $projectType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="project_type_show", methods={"GET"})
     */
    public function show(ProjectType $projectType): Response
    {
        return $this->render('project_type/show.html.twig', ['project_type' => $projectType]);
    }

    /**
     * @Route("/{id}/edit", name="project_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProjectType $projectType): Response
    {
        $form = $this->createForm(ProjectTypeType::class, $projectType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('project_type_index', ['id' => $projectType->getId()]);
        }

        return $this->render('project_type/edit.html.twig', [
            'project_type' => $projectType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="project_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProjectType $projectType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projectType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($projectType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('project_type_index');
    }
}
