<?php

namespace App\Form;

use App\Entity\Diploma;
use App\Entity\User;
use App\Entity\UserDiploma;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserDiplomaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateOfGrant', BirthdayType::class)
            ->add('mention')
            ->add('user', EntityType::class, [
                'label' => 'User',
                'class' => User::class,
                'choice_label' => 'email',
                'multiple' => false,
                'required' => false,
            ])
            ->add('diploma', EntityType::class, [
            'label' => 'Diploma',
            'class' => Diploma::class,
            'choice_label' => 'title',
            'multiple' => false,
            'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserDiploma::class,
        ]);
    }
}
