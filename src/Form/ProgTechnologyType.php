<?php

namespace App\Form;

use App\Entity\ProgLanguage;
use App\Entity\ProgTechnology;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProgTechnologyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label')
            ->add('progLanguage', EntityType::class, [
                'label' => 'Related Language',
                'class' => ProgLanguage::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProgTechnology::class,
        ]);
    }
}
