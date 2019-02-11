<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/", name="app_")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index", methods="GET")
     */
    public function index()
    {
        return $this->render('Front/landing_page.html.twig');
    }
}