<?php

namespace App\Form;

use App\Entity\ProgLanguage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\ProgTechnology;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProgLanguageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('type')
            ->add('progTechnologies', EntityType::class, array(
                'class'   => ProgTechnology::class,
                'choice_label' => 'label',
                'multiple' => true,
                'expanded' => true,
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProgLanguage::class,
        ]);
    }
}
