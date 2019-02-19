<?php

namespace App\Form;

use App\Entity\ProgLanguage;
use App\Entity\ProgTechnology;
use App\Entity\Society;
use App\Entity\User;
use App\Entity\UserProject;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('urlProject', UrlType::class)
            ->add('urlWebsite', UrlType::class)
            ->add('progLanguages', EntityType::class, [
                'label' => 'Project Languages',
                'class' => ProgLanguage::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('progTechnologies', EntityType::class, [
                'label' => 'Project Technologies',
                'class' => ProgTechnology::class,
                'choice_label' => 'label',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('society', EntityType::class, [
                'label' => 'Society',
                'class' => Society::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserProject::class,
        ]);
    }
}
