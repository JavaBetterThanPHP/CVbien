<?php

namespace App\Form;

use App\Entity\Language;
use App\Entity\User;
use App\Entity\UserLanguage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserLanguageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('level')
            ->add('user', EntityType::class, [
                'label' => 'User',
                'class' => User::class,
                'choice_label' => 'email',
                'multiple' => false,
                'required' => false,
            ])
            ->add('language', EntityType::class, [
                'label' => 'Language',
                'class' => Language::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserLanguage::class,
        ]);
    }
}
