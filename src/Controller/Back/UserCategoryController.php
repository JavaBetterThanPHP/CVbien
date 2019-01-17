<?php

namespace App\Controller\Back;

use App\Entity\UserCategory;
use App\Form\UserCategoryType;
use App\Repository\UserCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/category", name="back_user_category_")
 */
class UserCategoryController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(UserCategoryRepository $userCategoryRepository): Response
    {
        return $this->render('Back/user_category/index.html.twig', ['user_categories' => $userCategoryRepository->findAll()]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $userCategory = new UserCategory();
        $form = $this->createForm(UserCategoryType::class, $userCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userCategory);
            $entityManager->flush();

            return $this->redirectToRoute('user_category_index');
        }

        return $this->render('Back/user_category/new.html.twig', [
            'user_category' => $userCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(UserCategory $userCategory): Response
    {
        return $this->render('Back/user_category/show.html.twig', ['user_category' => $userCategory]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserCategory $userCategory): Response
    {
        $form = $this->createForm(UserCategoryType::class, $userCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_category_index', ['id' => $userCategory->getId()]);
        }

        return $this->render('Back/user_category/edit.html.twig', [
            'user_category' => $userCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, UserCategory $userCategory): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_user_category_index');
    }
}
