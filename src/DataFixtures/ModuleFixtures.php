<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 04/02/2019
 * Time: 11:53
 */

namespace App\DataFixtures;

use App\Entity\Module;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ModuleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $module = (new Module())
            ->setName("Texte")
            ->setFaClass("fas fa-align-left");
        $manager->persist($module);

        $module = (new Module())
            ->setName("Competences")
            ->setFaClass("fas fa-star");
        $manager->persist($module);

        $module = (new Module())
            ->setName("Lien")
            ->setFaClass("fas fa-link");
        $manager->persist($module);

        $module = (new Module())
            ->setName("StackOverflow")
            ->setFaClass("fab fa-stack-overflow");
        $manager->persist($module);

        $manager->flush();
    }
}