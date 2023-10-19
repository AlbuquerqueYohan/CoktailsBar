<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'value' => '',
                    'placeholder' => 'Vôtre nom d\'utilisateur',
                    'class' => 'form_control'],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mot de passe doivent correspondre.',
                'required' => true,
                'first_options'  => [
                    'label' => false,
                    'attr' => ['class' => 'form_control', 'placeholder' => 'Mot de passe'],
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => ['class' => 'form_control', 'placeholder' => 'Répeter le mot de passe'],
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
