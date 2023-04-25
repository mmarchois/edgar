<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Auth;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class LoginController
{
    public function __construct(
        private \Twig\Environment $twig,
        private AuthenticationUtils $authenticationUtils,
    ) {
    }

    #[Route('/auth/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function __invoke(): Response
    {
        $error = $this->authenticationUtils->getLastAuthenticationError();
        $lastUsername = $this->authenticationUtils->getLastUsername();

        return new Response(
            $this->twig->render(
                name: 'auth/login.html.twig',
                context: [
                    'last_username' => $lastUsername,
                    'error' => $error,
                ],
            ),
        );
    }
}
