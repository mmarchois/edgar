<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Auth;

use App\Application\CommandBusInterface;
use App\Application\User\Command\RegisterUserCommand;
use App\Domain\User\Exception\UserAlreadyRegisteredException;
use App\Infrastructure\Form\User\RegisterFormType;
use App\Infrastructure\Security\SymfonyUser;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class RegisterController
{
    public function __construct(
        private \Twig\Environment $twig,
        private FormFactoryInterface $formFactory,
        private RouterInterface $router,
        private CommandBusInterface $commandBus,
        private TranslatorInterface $translator,
        private Security $security,
    ) {
    }

    #[Route('/auth/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function __invoke(Request $request): Response
    {
        $command = new RegisterUserCommand();
        $form = $this->formFactory->create(RegisterFormType::class, $command);
        $form->handleRequest($request);
        $hasCommandFailed = false;

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $user = $this->commandBus->handle($command);
                $this->security->login(new SymfonyUser($user));

                return new RedirectResponse(
                    url: $this->router->generate('app_shoppinglists'),
                    status: Response::HTTP_SEE_OTHER,
                );
            } catch (UserAlreadyRegisteredException) {
                $hasCommandFailed = true;
                $errorMsg = $this->translator->trans('register.form.email.already_exist', [], 'validators');
                $form->get('email')->addError(new FormError($errorMsg));
            }
        }

        return new Response(
            content: $this->twig->render(
                name: 'auth/register.html.twig',
                context: [
                    'form' => $form->createView(),
                ],
            ),
            status: ($form->isSubmitted() && !$form->isValid()) || $hasCommandFailed
                ? Response::HTTP_UNPROCESSABLE_ENTITY
                : Response::HTTP_OK,
        );
    }
}
