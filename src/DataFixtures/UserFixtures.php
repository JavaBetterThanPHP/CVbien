<?php

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\ProgLanguage;
use App\Entity\User;
use App\Entity\UserProgLanguage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Date;


class UserFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');


        // Récupération des country
        $em = $manager->getRepository(Country::class);
        $country = $em->findAll();

        for ($i = 1; $i < 101; $i++) {

            $day = rand(1, 28);
            $month = rand(1, 12);
            $year = rand(1975, 1998);
            $month<10 ? $month = '0'.$month : $month;
            $birthdate = ''.$month.'/'.$day.'/'.$year.'';
            $lastName = $faker->lastName;
            $firstName = $faker->firstName;
            $spaceName = substr(strtolower($this->skip_accents($firstName)), 0, 1).$this->skip_accents($lastName);

            $city = $faker->randomElement($array = array ('Paris', 'Lille', 'Bordeaux' , 'Lyon' , 'Nice', 'Toulouse', 'Nantes', 'Strasbourg', 'Montpellier'));
            switch ($city){
                case 'Paris':
                    $rand = rand(1, 20);
                    $rand<10 ? $rand = '0'.$rand : $rand;
                    $cityCode='750'.$rand;
                    break;
                case 'Lille':
                    $rand = rand(1, 999);
                    $rand<100 ? $rand = '00'.$rand : $rand;
                    $rand<10 ? $rand = '0'.$rand : $rand;
                    $cityCode='59'.$rand;
                    break;
                case 'Bordeaux':
                    $rand = rand(1, 999);
                    $rand<100 ? $rand = '00'.$rand : $rand;
                    $rand<10 ? $rand = '0'.$rand : $rand;
                    $cityCode='33'.$rand;
                    break;
                case 'Lyon':
                    $rand = rand(1, 999);
                    $rand<100 ? $rand = '00'.$rand : $rand;
                    $rand<10 ? $rand = '0'.$rand : $rand;
                    $cityCode='69'.$rand;
                    break;
                case 'Nice':
                    $rand = rand(1, 999);
                    $rand<100 ? $rand = '00'.$rand : $rand;
                    $rand<10 ? $rand = '0'.$rand : $rand;
                    $cityCode='06'.$rand;
                    break;
                case 'Toulouse':
                    $rand = rand(1, 999);
                    $rand<100 ? $rand = '00'.$rand : $rand;
                    $rand<10 ? $rand = '0'.$rand : $rand;
                    $cityCode='31'.$rand;
                    break;
                case 'Nantes':
                    $rand = rand(1, 999);
                    $rand<100 ? $rand = '00'.$rand : $rand;
                    $rand<10 ? $rand = '0'.$rand : $rand;
                    $cityCode='44'.$rand;
                    break;
                case 'Strasbourg':
                    $rand = rand(1, 999);
                    $rand<100 ? $rand = '00'.$rand : $rand;
                    $rand<10 ? $rand = '0'.$rand : $rand;
                    $cityCode='67'.$rand;
                    break;
                case 'Montpellier':
                    $rand = rand(1, 999);
                    $rand<100 ? $rand = '00'.$rand : $rand;
                    $rand<10 ? $rand = '0'.$rand : $rand;
                    $cityCode='34'.$rand;
                    break;
            }

            $sexe = $faker->randomElement($array = array ('H', 'F'));
            $profilePicture = 'fixtures_pic/'.$sexe.$i.'.png';


            $user = (new User())
                ->setEmail(strtolower($this->skip_accents($lastName)).'.'.strtolower($this->skip_accents($firstName)).'@gmail.com')
                ->setLastname($lastName)
                ->setFirstname($firstName)
                ->setBirthdate(new \DateTime($birthdate))
                ->setPassword($faker->password(3,6))
                ->setRoles(["ROLE_USER"])
                ->setAdress($faker -> address)
                ->setCity($city)
                ->setProfilePicture($profilePicture)
                ->setSpaceName($spaceName.$faker->numberBetween($min = 0, $max = 9))
                ->setCityCode($cityCode)
                ->setStatus($faker->randomElement($array = array ('Freelance', 'CDI', 'CDD' , 'Libre' , 'Prestation')))
                ->setType("DEV")
                ->setPhoneNumber($faker->phoneNumber)
                ->setProPhoneNumber($faker->phoneNumber)
                ->setIsActive($faker->boolean($chanceOfGettingTrue = 90))
                ->setIsSearchable($faker->boolean($chanceOfGettingTrue = 90))
                ->setCountry($country[(array_rand($country))])
                ->setSexe($sexe)
            ;
            $manager->persist($user);
        }


        // CRÉATION DU USER DEV (user@user & demo)
        $user = (new User())
            ->setEmail('user@user')
            ->setLastname('Anduchite')
            ->setFirstname('Yves')
            ->setBirthdate(new \DateTime('09/16/1994'))
            ->setPassword('$argon2i$v=19$m=1024,t=2,p=2$a3ZKZ01lSmxIN1V5ME9nYQ$leDGM0pR2bmvWh8u/nIdOqSFEYBTNnTbXeWXg06BZc4')
            ->setRoles(["ROLE_USER"])
            ->setAdress('11 rue de la cité')
            ->setCity('Paris')
            ->setSpaceName('Yanduchite')
            ->setCityCode('75020')
            ->setStatus('Libre')
            ->setType("DEV")
            ->setPhoneNumber($faker->phoneNumber)
            ->setProPhoneNumber($faker->phoneNumber)
            ->setIsActive(1)
            ->setIsSearchable(1)
            ->setCountry($country[(array_rand($country))])
            ->setSexe('H');
        $manager->persist($user);

        // CRÉATION DU USER PREMIUM (premium@premium & demo)

        $user = (new User())
            ->setEmail('premium@premium')
            ->setLastname('Teub')
            ->setFirstname('Guy')
            ->setBirthdate(new \DateTime('11/28/1981'))
            ->setPassword('$argon2i$v=19$m=1024,t=2,p=2$a3ZKZ01lSmxIN1V5ME9nYQ$leDGM0pR2bmvWh8u/nIdOqSFEYBTNnTbXeWXg06BZc4')
            ->setRoles(["ROLE_PREMIUM"])
            ->setAdress('')
            ->setCity('Paris')
            ->setSpaceName('Gteub')
            ->setCityCode('75001')
            ->setStatus('RRH')
            ->setType("RH")
            ->setPhoneNumber($faker->phoneNumber)
            ->setProPhoneNumber($faker->phoneNumber)
            ->setIsActive(0)
            ->setIsSearchable(0)
            ->setIsProfessional(1)
            ->setCountry($country[(array_rand($country))])
            ->setSexe('H');
        $manager->persist($user);

        // CRÉATION DU USER ADMIN (admin@admin & demo)
        $user = (new User())
            ->setEmail('admin@admin')
            ->setLastname('Efoutouna')
            ->setFirstname('Walid')
            ->setBirthdate(new \DateTime())
            ->setPassword('$argon2i$v=19$m=1024,t=2,p=2$a3ZKZ01lSmxIN1V5ME9nYQ$leDGM0pR2bmvWh8u/nIdOqSFEYBTNnTbXeWXg06BZc4')
            ->setRoles(["ROLE_ADMIN"])
            ->setAdress('N/A')
            ->setCity('N/A')
            ->setSpaceName('N/A_admin_')
            ->setCityCode('N/A')
            ->setStatus('N/A')
            ->setType("N/A")
            ->setPhoneNumber($faker->phoneNumber)
            ->setProPhoneNumber($faker->phoneNumber)
            ->setIsActive(0)
            ->setIsSearchable(0)
            ->setIsProfessional(1)
            ->setCountry($country[(array_rand($country))])
            ->setSexe('H');
        $manager->persist($user);

        $manager->flush();
    }

    function skip_accents($str, $charset='utf-8') {

        $str = htmlentities($str, ENT_NOQUOTES, $charset);

        $str = preg_replace( '#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace( '#&([A-za-z]{2})(?:lig);#', '\1', $str );
        $str = preg_replace( '#&[^;]+;#', '', $str );

        return $str;
    }

    public function getDependencies()
    {
        return array(CountryFixtures::class);
    }
}