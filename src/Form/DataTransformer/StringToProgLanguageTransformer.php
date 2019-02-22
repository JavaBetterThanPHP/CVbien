<?php

namespace App\Form\DataTransformer;

use App\Entity\ProgLanguage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StringToProgLanguageTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (progLanguage) to a string (id).
     *
     * @param  ProgLanguage|null $progLanguage
     * @return string
     */
    public function transform($progLanguage)
    {
        if (null === $progLanguage) {
            return '';
        }
        return $progLanguage->getName();
    }

    /**
     * Transforms a string (id) to an object (progLanguage).
     *
     * @param  string $progLanguageId
     * @return ProgLanguage|null
     * @throws TransformationFailedException if object (progLanguage) is not found.
     */
    public function reverseTransform($progLanguageId)
    {
        if (!$progLanguageId) {
            throw new TransformationFailedException(sprintf(
                'Please Select a valid Prog language'
            ));
        }

        $progLanguage = $this->entityManager
            ->getRepository(ProgLanguage::class)->findOneBy(["name"=>$progLanguageId]);

        if (null === $progLanguage) {
            throw new TransformationFailedException(sprintf(
                'A progLanguage with name "%s" does not exist!',
                $progLanguageId
            ));
        }
        return $progLanguage;
    }

}