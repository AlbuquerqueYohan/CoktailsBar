<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCocktailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'value' => '',
                    'placeholder' => 'Nom du cocktail'],
            ])
            ->add('description', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'value' => '',
                    'placeholder' => 'Décrivez vôtre cocktail'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
