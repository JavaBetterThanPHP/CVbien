<?php

namespace App\Controller\Back;

use App\Entity\Link;
use App\Form\LinkType;
use App\Repository\LinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/link", name="back_link_")
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
        return $this->render('Back/link/index.html.twig', ['links' => $linkRepository->findAll(),'user' => $user]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Link $link): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('Back/link/show.html.twig', ['link' => $link,'user' => $user]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Link $link): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_link_index', ['id' => $link->getId()]);
        }

        return $this->render('Back/link/edit.html.twig', [
            'link' => $link,
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
