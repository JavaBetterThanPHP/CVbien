<?php

namespace App\Form;

use App\Entity\ProgLanguage;
use App\Entity\UserProgLanguage;
use App\Form\DataTransformer\StringToProgLanguageTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProgLanguageFrontType extends AbstractType
{
    private $transformer;

    public function __construct(StringToProgLanguageTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('level',RangeType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 10
                ]
            ])
            ->add('progLanguage', TextType::class, [
                'required'=>true
                ]);
            $builder->get('progLanguage')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserProgLanguage::class,
        ]);
    }
}
