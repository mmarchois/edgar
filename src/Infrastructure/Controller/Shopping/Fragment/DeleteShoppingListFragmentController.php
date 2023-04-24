<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Shopping\Fragment;

use App\Application\CommandBusInterface;
use App\Application\Shopping\Command\DeleteShoppingListByUuidCommand;
use App\Domain\Shopping\Exception\ShoppingListNotFoundException;
use App\Infrastructure\Security\AuthenticatedUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;

final class DeleteShoppingListFragmentController
{
    public function __construct(
        private \Twig\Environment $twig,
        private CommandBusInterface $commandBus,
        private AuthenticatedUser $authenticatedUser,
    ) {
    }

    #[Route(
        '/_fragment/shopping-lists/{uuid}',
        name: 'fragment_shoppinglist_delete',
        requirements: ['uuid' => '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}'],
        methods: ['DELETE'],
    )]
    public function __invoke(Request $request, string $uuid): Response
    {
        $user = $this->authenticatedUser->getUser();

        try {
            $this->commandBus->handle(new DeleteShoppingListByUuidCommand($uuid, $user));
        } catch (ShoppingListNotFoundException) {
            throw new NotFoundHttpException();
        }

        $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

        return new Response(
            content: $this->twig->render(
                name: 'shoppingList/fragments/_delete.stream.html.twig',
                context: [
                    'uuid' => $uuid,
                ],
            ),
        );
    }
}
