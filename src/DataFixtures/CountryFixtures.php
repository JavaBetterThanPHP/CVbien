<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 04/02/2019
 * Time: 11:53
 */

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CountryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        //for ($i = 0; $i < 10; $i++) {
            $country = (new Country())
                ->setName('France');
            $manager->persist($country);
        //}

        $manager->flush();
    }
}