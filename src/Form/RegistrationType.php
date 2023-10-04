<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => false,
                'label' => 'E-mail',
                'attr' => [
                    'placeholder' => 'Saisissez votre e-mail'
                ]
            ])
            ->add('password', PasswordType::class, [
                'required' => false,
                'label' => 'Mot de passe',
                'attr' => [
                    'placeholder' => 'Saisissez un mot de passe'
                ]
            ])
            ->add('nickname', TextType::class, [
                'required' => false,
                'label' => 'Pseudo',
                'attr' => [
                    'placeholder' => 'Saisissez Votre pseudo'
                ]
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => [
                    'class' => 'mt-3 btn btn-success' // petit rajout multiple de classes pour faire joli
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
