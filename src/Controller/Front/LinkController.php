<?php

namespace App\Controller\Front;

use App\Entity\Link;
use App\Form\LinkFrontType;
use App\Repository\LinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/link", name="front_link_")
 */
class LinkController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(LinkRepository $linkRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('Front/link/index.html.twig', ['links' => $linkRepository->findAll(), 'user' => $user]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $link = new Link();
        $form = $this->createForm(LinkFrontType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($link);
            $entityManager->flush();

            return $this->redirectToRoute('front_link_index');
        }

        return $this->render('Front/link/new.html.twig', [
            'link' => $link,
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Link $link): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $form = $this->createForm(LinkFrontType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_link_index', ['id' => $link->getId()]);
        }

        return $this->render('Front/link/edit.html.twig', [
            'link' => $link,
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Link $link): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        if ($this->isCsrfTokenValid('delete' . $link->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($link);
            $entityManager->flush();
        }

        return $this->redirectToRoute('front_link_index');
    }
}