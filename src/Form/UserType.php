<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Jméno'
            ))
            ->add('plainPassword', PasswordType::class, array(
                'label' => 'Heslo',
                'mapped' => false
            ))
            ->add('email', EmailType::class, array(
                'label' => 'E-mail'
            ))
            ->add('role', ChoiceType::class, array(
                'label' => 'Role',
                'choices' => [
                    'Administrátor' => 'admin',
                    'Uživatel' => 'user'
                ]
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Uložit'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
