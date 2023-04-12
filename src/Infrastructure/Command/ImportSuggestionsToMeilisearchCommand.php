<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

use Meilisearch\Client;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:meilisearch:suggestions',
    description: 'Import shopping suggestions into Meilisearch.',
)]
final class ImportSuggestionsToMeilisearchCommand extends Command
{
    public function __construct(
        private readonly Client $client,
        private string $fixturesFile,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $items = json_decode(file_get_contents($this->fixturesFile), true);
        $index = $this->client->index('suggestions');
        $index->updateSearchableAttributes(['name']);
        $index->addDocuments($items);
        $output->writeln(sprintf('<info>%d suggestions successfully imported to Meilisearch!</info>', \count($items)));

        return Command::SUCCESS;
    }
}
