<?php
/**
 * Created by PhpStorm.
 * User: Patryk Szczepanski
 * Date: 31/10/2019
 * Time: 04:06
 */

namespace App\Form\admin;


use App\Entity\UsersEntity;
use App\Service\admin\typeFunctions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class adminUsersType extends AbstractType
{
    private $typeFunctions;

    public function __construct(typeFunctions $typeFunctions)
    {
        $this->typeFunctions = $typeFunctions;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('username', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => false,
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Musisz wpisać hasło',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Hasło musi być dłuższe niż {{ limit }} znaków',
                        'max' => 32,
                        'maxMessage' => 'Hasło nie może być dłuższe niż {{ limit }} znaków'
                    ]),
                ],
            ))
            ->add('groupId', ChoiceType::class, [
                'choices' => $this->typeFunctions->loadGroupsToChoiceList(),
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('authData', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'STEAM_1:1:123456'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => UsersEntity::class,
        ));
    }


}