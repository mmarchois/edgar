<?php

declare(strict_types=1);

namespace App\Infrastructure\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                options: [
                    'label' => 'register.form.firstName',
                    'attr' => [
                        'placeholder' => 'register.form.firstName.placeholder',
                    ],
                ],
            )
            ->add(
                'lastName',
                TextType::class,
                options: [
                    'label' => 'register.form.lastName',
                    'attr' => [
                        'placeholder' => 'register.form.lastName.placeholder',
                    ],
                ],
            )
            ->add(
                'email',
                EmailType::class,
                options: [
                    'label' => 'register.form.email',
                    'attr' => [
                        'placeholder' => 'register.form.email.placeholder',
                    ],
                ],
            )
            ->add(
                'password',
                RepeatedType::class,
                options: [
                    'type' => PasswordType::class,
                    'invalid_message' => 'register.form.password.notmatch',
                    'first_options' => [
                        'label' => 'register.form.password',
                        'attr' => [
                            'placeholder' => 'register.form.password.placeholder',
                        ],
                    ],
                    'second_options' => [
                        'label' => 'register.form.password.confirm',
                        'attr' => [
                            'placeholder' => 'register.form.password.confirm.placeholder',
                        ],
                    ],
                ],
            )
        ;
    }
}
