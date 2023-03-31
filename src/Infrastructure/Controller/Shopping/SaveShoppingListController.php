<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Shopping;

use App\Application\CommandBusInterface;
use App\Application\Shopping\Command\SaveShoppingListCommand;
use App\Infrastructure\Form\Shopping\ShoppingListFormType;
use App\Infrastructure\Security\AuthenticatedUser;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

final class SaveShoppingListController
{
    public function __construct(
        private \Twig\Environment $twig,
        private FormFactoryInterface $formFactory,
        private RouterInterface $router,
        private CommandBusInterface $commandBus,
        private AuthenticatedUser $authenticatedUser,
    ) {
    }

    #[Route('/shopping-lists/save', name: 'app_shoppinglists_save', methods: ['GET', 'POST'])]
    public function __invoke(Request $request): Response
    {
        $command = new SaveShoppingListCommand($this->authenticatedUser->getUser());
        $form = $this->formFactory->create(ShoppingListFormType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $shoppingListUuid = $this->commandBus->handle($command);

            return new RedirectResponse(
                url: $this->router->generate('app_dashboard'),
                status: Response::HTTP_SEE_OTHER,
            );
        }

        return new Response(
            content: $this->twig->render(
                name: 'shoppingList/save.html.twig',
                context: [
                    'form' => $form->createView(),
                ],
            ),
            status: ($form->isSubmitted() && !$form->isValid())
                ? Response::HTTP_UNPROCESSABLE_ENTITY
                : Response::HTTP_OK,
        );
    }
}
