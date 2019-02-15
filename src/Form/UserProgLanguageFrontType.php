<?php

namespace App\Form;

use App\Entity\ProgLanguage;
use App\Entity\User;
use App\Entity\UserProgLanguage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProgLanguageFrontType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('level',RangeType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 10
                ]
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
