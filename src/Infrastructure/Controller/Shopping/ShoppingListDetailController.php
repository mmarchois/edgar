<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Shopping;

use App\Application\QueryBusInterface;
use App\Application\Shopping\Query\GetShoppingListByUuidQuery;
use App\Domain\Shopping\ShoppingList;
use App\Infrastructure\Security\AuthenticatedUser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

final class ShoppingListDetailController
{
    public function __construct(
        private \Twig\Environment $twig,
        private QueryBusInterface $queryBus,
        private AuthenticatedUser $authenticatedUser,
    ) {
    }

    #[Route(
        '/shopping-lists/{uuid}',
        name: 'app_shoppinglist_detail',
        requirements: ['uuid' => '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}'],
        methods: ['GET'],
    )]
    public function __invoke(string $uuid): Response
    {
        $user = $this->authenticatedUser->getUser();
        $shoppingList = $this->queryBus->handle(new GetShoppingListByUuidQuery($uuid, $user));

        if (!$shoppingList instanceof ShoppingList) {
            throw new NotFoundHttpException();
        }

        return new Response(
            content: $this->twig->render(
                name: 'shoppingList/detail.html.twig',
                context: [
                    'shoppingList' => $shoppingList,
                ],
            ),
            status: Response::HTTP_OK,
        );
    }
}
