<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFrontType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add("spaceName", TextType::class)
            ->add("isActive", CheckboxType::class, [
                'label' => 'Show this my user page publicly ?',
                'required' => false,
            ])
            ->add("isSearchable", CheckboxType::class, [
                'label' => 'Make my profile searchable ?',
                'required' => false,
            ])
            ->add('birthdate', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker',
                    'data-provide' => 'datetimepicker',
                    'html5' => false,
                ],
            ])
            ->add('phoneNumber', TextType::class)
            ->add('proPhoneNumber', TextType::class)
            ->add('adress', TextType::class, ['label' => 'Address'])
            ->add('cityCode', TextType::class)
            ->add('city', TextType::class)
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}
