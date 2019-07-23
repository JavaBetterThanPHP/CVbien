<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\ElasticType\UserResearchType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\ElasticaBundle\FOSElasticaBundle;
use FOS\ElasticaBundle\Manager\RepositoryManagerInterface;
use FOS\ElasticaBundle\Finder\FinderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @Route("/research", name="front_research_")
 */
class ResearchController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET", "POST"})
     */
    public function index(Request $request, RepositoryManagerInterface $finder, UserRepository $userRepository)
    {
        $form = $this->createForm(UserResearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $results = $finder->getRepository(User::class)->find($request->request->get('user_research')['user_research'], '101');
            dump(count($results));
            //dump($results);die;

            return $this->render('Front/research/index.html.twig', [
                'form' => $form->createView(),
                'user' => $this->getUser(),
                'profileList' => $results
            ]);
        }
        //dump($userRepository->findBy(['isProfessional' => false]));die;
        //echo '<pre>';print_r();echo '</pre>';die;

        dump(count($userRepository->findBy(['isProfessional' => false, 'isSearchable' => true, 'isActive' => true])));
        return $this->render('Front/research/index.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser(),
            'profileList' => $userRepository->findBy(['isProfessional' => false, 'isSearchable' => true, 'isActive' => true])
        ]);
    }


    /**
     * @Route("/autoProgLanguage", name="prog_language_search", methods={"GET", "POST"})
     * @return JsonResponse
     */
    public function searchProgLanguage(UserRepository $userRepository, Request $request)
    {
        $query = $request->query->all();
        $search = isset($query['user_research[user_research]']) && !empty($query['user_research[user_research]']) ? $query['user_research[user_research]'] : null;
        $progLanguage = $userRepository->search($search);

        foreach ($progLanguage as $element) {
            $data[] = [
                'name' => $element->getUserProgLanguages(),
            ];
        }

        return new JsonResponse($data);
    }
}