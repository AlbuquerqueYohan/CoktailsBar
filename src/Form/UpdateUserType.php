<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateUserType extends AbstractType
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
            ->add('roles', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'A saisir si Admin',
                    'class' => 'form_control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
