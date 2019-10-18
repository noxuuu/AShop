<?php
/**
 * Created by PhpStorm.
 * User: Dawid Pierzak
 * Date: 04.01.2019
 * Time: 18:04
 */

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SmsPaymentType
{
//    public function buildForm(FormBuilderInterface $builder, array $options) {
//        $builder
//            ->add('smsCode', TextType::class, [
//                'label' => 'Kod sms',
//                'required' => true,
//                'attr' => [
//                    'class' => 'input-upload-image',
//                    'id' => 'file',
//                ]
//            ])
//            ->add('service', EntityType::class, [
//                'label' => 'Wybór usługi',
//                'class' => ServiceEntity::class,
//                'required' => true,
//                'choice_label' => 'title',
//                'attr' => [
//                    'class' => 'form-control'
//                ]
//            ]);
//    }
//
//    public function configureOptions(OptionsResolver $resolver) {
//        $resolver->setDefaults([
//            'data_class' => ServiceEntity::class,
//        ]);
//    }

}