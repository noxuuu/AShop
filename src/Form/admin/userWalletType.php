<?php
/**
 * Created by PhpStorm.
 * User: Patryk Szczepanski
 * Date: 22/10/2019
 * Time: 07:32
 */

namespace App\Form\admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

class userWalletType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', NumberType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);
    }
}