<?php

declare(strict_types=1);

namespace App\Infrastructure\Form\Shopping;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class ShoppingListFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                options: [
                    'label' => 'shoppingList.form.name',
                    'attr' => [
                        'placeholder' => 'shoppingList.form.name.placeholder',
                    ],
                ],
            )
        ;
    }
}
