<?php
/**
 * Created by PhpStorm.
 * User: Patryk Szczepanski
 * Date: 18/10/2019
 * Time: 04:14
 */

namespace App\Form\admin;

use App\Entity\Services;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class servicesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('webDescription', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'textarea',
                    'style' => 'width: 100%; height: 240px'
                ]
            ])
            ->add('serverDescription', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'textarea',
                    'style' => 'width: 100%; height: 240px'
                ]
            ])
            ->add('imageUrl', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('sufix', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Flagi' => 1,
                    'Zapytanie MySQL' => 2,
                    'Inne (Bazujące na API)' => 3,
                ],
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control round-input'
                ]
            ])
            ->add('flags', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('orderNumber', IntegerType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Services::class,
        ));
    }
}
