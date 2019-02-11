<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('spaceName')
            ->add('isActive')
            ->add('isSearchable')
            ->add('firstname')
            ->add('lastname')
            ->add('birthdate', BirthdayType::class)
            ->add('phoneNumber')
            ->add('proPhoneNumber')
            ->add('adress')
            ->add('city')
            ->add('cityCode')
            ->add('country', EntityType::class, [
                'label' => 'Pays',
                'class' => Country::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => false,
            ])
            ->add('status')
            ->add('type')
            ->add('bannerPicture')
            ->add('profilePicture')
            ->add('isSearchable')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
