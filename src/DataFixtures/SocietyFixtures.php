<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 04/02/2019
 * Time: 11:53
 */

namespace App\DataFixtures;

use App\Entity\Society;
use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SocietyFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $em = $manager->getRepository(Country::class);
        $country = $em->findAll();

        for ($i = 0; $i < 10; $i++){
            $society = (new Society())
                ->setName($faker->word)
                ->setAdress($faker->address)
                ->setCity($faker->city)
                ->setCityCode($faker->randomNumber(2,true))
                ->setCountry($country[(array_rand($country))]);
            $manager->persist($society);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(CountryFixtures::class);
    }
}