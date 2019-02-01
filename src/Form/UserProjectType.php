<?php

namespace App\Form;

use App\Entity\ProgTechnology;
use App\Entity\Society;
use App\Entity\UserProject;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\ProgLanguage;

class UserProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('urlProject', UrlType::class)
            ->add('urlWebsite', UrlType::class)
            ->add('user', EntityType::class, [
                'label' => 'User',
                'class' => User::class,
                'choice_label' => 'email',
                'multiple' => false,
                'required' => true,
            ])
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
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserProject::class,
        ]);
    }
}
