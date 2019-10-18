<?php
/**
 * Created by PhpStorm.
 * User: Dawid Pierzak
 * Date: 07.01.2019
 * Time: 02:00
 */

namespace App\Form;
use App\Entity\UsersEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Wprowadź swój adres e-mail'
                ]
            ])
            ->add('username', TextType::class, [
                'label' => 'Login',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Wprowadź swój login'
                ]
            ])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Hasło'),
                'second_options' => array('label' => 'Powtórz hasło'),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Musisz wpisać hasło',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Twoje hasło musi być dłuższe niż {{ limit }} znaków',
                        'max' => 32,
                        'maxMessage' => 'Twoje hasło nie może być dłuższe niż {{ limit }} znaków'
                    ]),
                ],
            ))
            ->add('authData', TextType::class, [
                'label' => 'STEAM ID',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Wprowadź swoje STEAM_ID'
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