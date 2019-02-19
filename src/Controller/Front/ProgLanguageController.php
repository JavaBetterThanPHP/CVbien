<?php

namespace App\Controller\Front;

use App\Entity\DTO\ProgLanguageDTO;
use App\Repository\ProgLanguageRepository;
use App\Service\ProgLanguageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/progLanguage", name="front_prog_language_")
 */
class ProgLanguageController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(ProgLanguageRepository $progLanguageRepository, Request $request): Response
    {
       // return  $this->json($progLanguageService->getProgLanguageByIdAndName($request->get("key")));
       // return $this->json($progLanguageRepository->findNameContaining($request->get("query")));
        $data = $progLanguageRepository->findNameContaining($request->get("query"));
        $result = array();
        foreach($data as $value){
            $progLanguageDTO = new ProgLanguageDTO();
            $progLanguageDTO->setValue($value->getName());
            $progLanguageDTO->setData($value->getId());
            $result[]=$progLanguageDTO;
        }
        return $this->json(['suggestions' => $result]);

    }
}
