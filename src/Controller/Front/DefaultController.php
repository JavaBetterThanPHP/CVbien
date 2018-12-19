<?php
    namespace App\Controller\Front;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;


    /**
     * @Route("/")
     */
    class DefaultController extends AbstractController
    {
        /**
         * @Route("/", name="front_index", methods="GET")
         */
        public function index()
        {
            return $this->render('Front/Default/index.html.twig');
        }
    }