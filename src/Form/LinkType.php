<?php

namespace App\Form;

use App\Entity\Link;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class LinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('website')
            ->add('url', UrlType::class)
            ->add('name')
            ->add('imageUrl')
            ->add('user', EntityType::class,[
                'label' => 'User',
                'class' => User::class,
                'choice_label' => 'email',
                'multiple' => false,
                'required' => true]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Link::class,
        ]);
    }
}
