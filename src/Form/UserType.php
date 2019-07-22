<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\User;
use function Sodium\add;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class)
            ->add('spaceName', TextType::class)
            ->add('sexe', ChoiceType::class)
            ->add('isActive', CheckboxType::class)
            ->add('isSearchable', CheckboxType::class)
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('birthdate', BirthdayType::class)
            ->add('phoneNumber', TextType::class)
            ->add('proPhoneNumber', TextType::class)
            ->add('adress', TextType::class)
            ->add('city', TextType::class)
            ->add('cityCode', TextType::class)
            ->add('isProfessional', CheckboxType::class)
            ->add('country', EntityType::class, [
                'label' => 'Pays',
                'class' => Country::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
