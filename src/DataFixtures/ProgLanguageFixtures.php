<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 04/02/2019
 * Time: 11:53
 */

namespace App\DataFixtures;

use App\Entity\progLanguage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProgLanguageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');
/*
        for ($i = 0; $i < 10; $i++) {
            $proglanguage = (new ProgLanguage())
                ->setName($faker->word)
                ->setType($faker->word);
            $manager->persist($proglanguage);
        }

        $manager->flush();
*/
    }
}