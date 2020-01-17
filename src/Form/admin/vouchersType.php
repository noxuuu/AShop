<?php
/**
 * Created by PhpStorm.
 * User: Patryk Szczepanski
 * Date: 18/10/2019
 * Time: 07:42
 */

namespace App\Form\admin;

use App\Entity\Vouchers;
use App\Service\admin\typeFunctions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class vouchersType extends AbstractType
{
    private $typeFunctions;

    public function __construct(typeFunctions $typeFunctions)
    {
        $this->typeFunctions = $typeFunctions;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('priceId', ChoiceType::class, [
                'choices' => $this->typeFunctions->loadPricesToChoiceList(),
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('code', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Vouchers::class,
        ));
    }
}
