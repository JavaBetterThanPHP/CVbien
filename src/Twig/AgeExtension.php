<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 25/02/2019
 * Time: 19:16
 */

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AgeExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('age', [$this, 'birthdateToAge']),
        ];
    }

    public function birthdateToAge($birthdate)
    {
        if (!$birthdate instanceof \DateTime) // On vérifie qu'il s'agit d'une date
            return "-";

        return (new \DateTime())->diff($birthdate)->y;
    }
}