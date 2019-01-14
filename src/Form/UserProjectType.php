<?php

namespace App\Form;

use App\Entity\UserProject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('urlProject')
            ->add('urlWebsite')
            ->add('user')
            ->add('society')
            ->add('projectType')
            ->add('progLanguage')
            ->add('progTechnologies')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserProject::class,
        ]);
    }
}
