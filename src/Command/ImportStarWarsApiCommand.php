<?php

namespace App\Command;

use App\Service\ApiService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportStarWarsApiCommand extends Command
{
    private ApiService $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('starwars:import')
            ->setDescription('Imports Star Wars characters into the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->apiService->syncData('people');

        $output->writeln('Products synchronized!');

        return Command::SUCCESS;
    }
}