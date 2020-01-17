<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 17:19
 */

namespace App\Form\admin;

use App\Service\admin\typeFunctions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


class SettingsType extends AbstractType
{
    private $typeFunctions;

    public function __construct(typeFunctions $typeFunctions)
    {
        $this->typeFunctions = $typeFunctions;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('shop_title', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('shop_address', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('shop_email', EmailType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('shop_commands', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('payment_url_livetime', NumberType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('debug', ChoiceType::class, [
                'choices'  => [
                    'Wyłączony' => 0,
                    'Włączony' => 1,
                ],
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('contact_group', ChoiceType::class, [
                'choices'  => $this->typeFunctions->loadGroupsToChoiceList(),
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('steam_bot_login', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('steam_bot_password', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('allow_steam_bot_info', ChoiceType::class, [
                'choices'  => [
                    'Wyłączony' => 0,
                    'Włączony' => 1,
                ],
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('stats_target_income', NumberType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('stats_target_sold_services', NumberType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('stats_target_send_sms', NumberType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);
    }
}