<?php
/**
 * Created by PhpStorm.
 * User: Patryk Szczepanski
 * Date: 18/10/2019
 * Time: 07:42
 */

namespace App\Form\admin;

use App\Entity\Prices;
use App\Service\admin\typeFunctions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class pricesType extends AbstractType
{
    private $typeFunctions;

    public function __construct(typeFunctions $typeFunctions)
    {
        $this->typeFunctions = $typeFunctions;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('serviceId', ChoiceType::class, [
                'choices' => $this->typeFunctions->loadServicesToChoiceList(),
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('serverId', ChoiceType::class, [
                'choices' => $this->typeFunctions->loadServersToChoiceList(),
                'multiple' => true,
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('tariffId', ChoiceType::class, [
                'choices' => $this->typeFunctions->loadTariffsToChoiceList(),
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Prices::class,
        ));
    }
}
