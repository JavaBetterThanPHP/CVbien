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

        $module = (new Module())
            ->setName("Image")
            ->setFaClass("far fa-image");
        $manager->persist($module);

        $module = (new Module())
            ->setName("Codepen")
            ->setFaClass("fab fa-codepen");
        $manager->persist($module);
      
        $module = (new Module())
            ->setName("Github")
            ->setFaClass("fab fa-github");
        $manager->persist($module);

        $module = (new Module())
            ->setName("Twitter")
            ->setFaClass("fab fa-twitter");
        $manager->persist($module);

        $module = (new Module())
            ->setName("Instagram")
            ->setFaClass("fab fa-instagram");
        $manager->persist($module);

        $module = (new Module())
            ->setName("Repl.it")
            ->setFaClass("fas fa-terminal");
        $manager->persist($module);

        $module = (new Module())
            ->setName("SoundCloud")
            ->setFaClass("fab fa-soundcloud");
        $manager->persist($module);

        $manager->flush();
    }
}