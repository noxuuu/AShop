<?php
/**
 * Created by PhpStorm.
 * User: Patryk Szczepanski
 * Date: 22/10/2019
 * Time: 07:32
 */

namespace App\Form\admin;

use App\Service\admin\typeFunctions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class usersServicesAddType extends AbstractType
{
    private $typeFunctions;

    public function __construct(typeFunctions $typeFunctions)
    {
        $this->typeFunctions = $typeFunctions;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('service', ChoiceType::class, [
                'choices' => $this->typeFunctions->loadServicesToChoiceList(true),
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('server', ChoiceType::class, [
                'choices' => $this->typeFunctions->loadServersToChoiceList(),
                'multiple' => true,
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('authData', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('value', IntegerType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);
    }
}