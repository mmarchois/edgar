<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Shopping;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AddShoppingItemsController
{
    public function __construct(
        private \Twig\Environment $twig,
    ) {
    }

    #[Route('/{uuid}/add', name: 'app_shoppingitems_add', methods: ['GET', 'POST'])]
    public function __invoke(string $uuid): Response
    {
        return new Response(
            content: $this->twig->render(
                name: 'shoppingList/shoppingItem/add.html.twig',
                context: [
                    'uuid' => $uuid,
                ],
            ),
        );
    }
}
