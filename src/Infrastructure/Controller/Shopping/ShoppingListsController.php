<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Shopping;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ShoppingListsController
{
    public function __construct(
        private \Twig\Environment $twig,
    ) {
    }

    #[Route('/shopping-lists', name: 'app_shoppinglists', methods: ['GET'])]
    public function __invoke(): Response
    {
        return new Response(
            content: $this->twig->render(
                name: 'shoppingList/index.html.twig',
                context: [],
            ),
            status: Response::HTTP_OK,
        );
    }
}
