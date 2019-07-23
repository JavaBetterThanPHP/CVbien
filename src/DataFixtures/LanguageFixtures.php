<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 04/02/2019
 * Time: 11:53
 */

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LanguageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        /*
        for ($i = 0; $i < 10; $i++) {
            $language = (new Language())
                ->setName($faker->languageCode);
            $manager->persist($language);
        }
        */
        $languages = ['Francais', 'Anglais', 'Espagnol', 'Italien', 'Allemand', 'Russe', 'Chinois', 'Néerlandais', 'Arabe', 'Portugais'];

        foreach ($languages as $element)
        {
            $language = (new Language())
                ->setName($element);
            $manager->persist($language);
        }


        $manager->flush();
    }
}