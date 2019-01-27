<?php

namespace App\Controller\Front;

use App\Form\UserProfilePictureType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="front_index", methods="GET")
     */
    public function index(Request $request)
    {
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        //$user = $this->getUser();
        //return $this->render('Front/Default/index.html.twig',[
          //  'user' => $user
        //]);
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        // return $this->render('Front/Default/index.html.twig');
        //$form = $this->createForm(UserProfilePictureType::class, $user);
        //$form->handleRequest($request);
        //if ($form->isSubmitted() && $form->isValid()) {
         //   $this->getDoctrine()->getManager()->flush();
        //    return $this->redirectToRoute('front_index');
        //}else{
            return $this->render('Front/Default/index.html.twig', [
                'user' => $user,
             //   'form' => $form->createView(),
            ]);
        //}

    }
}