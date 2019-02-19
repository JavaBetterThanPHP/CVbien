<?php

namespace App\Service;


use App\Repository\ProgLanguageRepository;

class ProgLanguageService
{

    public function getProgLanguageByIdAndName(string $key, ProgLanguageRepository $progLanguageRepository): string
    {

        return  $this->json($progLanguageRepository->findNameContaining($key));
    }
}