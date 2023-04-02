<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Shopping;

use App\Application\QueryBusInterface;
use App\Application\Shopping\Query\GetUserShoppingListsQuery;
use App\Infrastructure\Security\AuthenticatedUser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ShoppingListsController
{
    public function __construct(
        private \Twig\Environment $twig,
        private QueryBusInterface $queryBus,
        private AuthenticatedUser $authenticatedUser,
    ) {
    }

    #[Route('/shopping-lists', name: 'app_shoppinglists', methods: ['GET'])]
    public function __invoke(): Response
    {
        $user = $this->authenticatedUser->getUser();
        $shoppingLists = $this->queryBus->handle(new GetUserShoppingListsQuery($user));

        return new Response(
            content: $this->twig->render(
                name: 'shoppingList/index.html.twig',
                context: [
                    'shoppingLists' => $shoppingLists,
                ],
            ),
            status: Response::HTTP_OK,
        );
    }
}
