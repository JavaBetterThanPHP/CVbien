<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 04/02/2019
 * Time: 11:53
 */

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\Diploma;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class DiplomaFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');


        // Récupération des country
        $em = $manager->getRepository(Country::class);
        $country = $em->findAll();


        for ($i = 0; $i < 10; $i++) {
            $diploma = (new Diploma())
                ->setTitle($faker->word)
                ->setLevel($faker->randomElement(['3', '2', '5']))
                ->setIsInternational($faker->boolean)
                ->setCountry($country[(array_rand($country))]);
            $manager->persist($diploma);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(CountryFixtures::class);
    }
}