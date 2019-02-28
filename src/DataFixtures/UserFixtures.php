<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 04/02/2019
 * Time: 11:53
 */

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');


        // Récupération des country
        $em = $manager->getRepository(Country::class);
        $country = $em->findAll();


        for ($i = 0; $i < 100; $i++) {
            $user = (new User())
                ->setEmail($faker->email)
                ->setLastname($faker->lastName)
                ->setFirstname($faker->firstName)
                ->setPassword($faker->password(3,6))
                ->setRoles(["ROLE_USER"])
                ->setAdress($faker -> address)
                ->setCity($faker -> city)
                ->setCityCode($faker ->numberBetween($min = 1000, $max = 9000))
                ->setStatus($faker->randomElement($array = array ('Freelance', 'CDI', 'CDD' , 'Libre' , 'Prestation')))
                ->setType("DEV")
                ->setPhoneNumber($faker->phoneNumber)
                ->setIsActive($faker->boolean($chanceOfGettingTrue = 90))
                ->setIsSearchable($faker->boolean($chanceOfGettingTrue = 90))
                ->setCountry($country[(array_rand($country))]);
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(CountryFixtures::class);
    }
}