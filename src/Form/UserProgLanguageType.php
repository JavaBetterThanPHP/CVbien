<?php

namespace App\Form;

use App\Entity\ProgLanguage;
use App\Entity\User;
use App\Entity\UserProgLanguage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProgLanguageType extends AbstractType
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
            ->add('progLanguage', EntityType::class, [
                'label' => 'Prog language',
                'class' => ProgLanguage::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserProgLanguage::class,
        ]);
    }
}
