<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Shopping;

use App\Application\QueryBusInterface;
use App\Infrastructure\Security\AuthenticatedUser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ShowShoppingListController extends AbstractShoppingListController
{
    public function __construct(
        private \Twig\Environment $twig,
        private AuthenticatedUser $authenticatedUser,
        QueryBusInterface $queryBus,
    ) {
        parent::__construct($queryBus);
    }

    #[Route(
        '/shopping-lists/{uuid}',
        name: 'app_shoppinglist_show',
        requirements: ['uuid' => '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}'],
        methods: ['GET'],
    )]
    public function __invoke(string $uuid): Response
    {
        $user = $this->authenticatedUser->getUser();
        $shoppingList = $this->getShoppingList($uuid, $user);

        return new Response(
            content: $this->twig->render(
                name: 'shoppingList/show.html.twig',
                context: [
                    'shoppingList' => $shoppingList,
                ],
            ),
            status: Response::HTTP_OK,
        );
    }
}
