<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Shopping\Fragment;

use Meilisearch\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

final class GetShoppingSuggestionsFragmentController
{
    public function __construct(
        private \Twig\Environment $twig,
        private Client $client,
    ) {
    }

    #[Route(
        '/_fragment/shopping-suggestions',
        name: 'app_fragment_shopping_suggestions',
        methods: ['GET'],
    )]
    public function __invoke(Request $request): Response
    {
        $search = $request->query->get('search');

        if (!$search) {
            throw new BadRequestHttpException();
        }

        $suggestions = $this->client
            ->getIndex('suggestions')
            ->search($search, ['attributesToHighlight' => ['name']])
            ->getHits();

        return new Response(
            $this->twig->render(
                name: 'shoppingList/fragments/_suggestions.html.twig',
                context: [
                    'search' => $search,
                    'suggestions' => $suggestions,
                ],
            ),
        );
    }
}
