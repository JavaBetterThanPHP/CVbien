<?php

namespace App\Form;

use App\Entity\JobType;
use App\Entity\Society;
use App\Entity\UserSociety;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSocietyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstDate', BirthdayType::class)
            ->add('lastDate', BirthdayType::class)
            ->add('isActive', CheckboxType::class, [
                'required' => false,
            ])
            ->add('society', EntityType::class, [
                'label' => 'Société',
                'class' => Society::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => false,
            ])
            ->add('jobType', EntityType::class, [
                'label' => 'Job',
                'class' => JobType::class,
                'choice_label' => 'label',
                'multiple' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserSociety::class,
        ]);
    }
}
