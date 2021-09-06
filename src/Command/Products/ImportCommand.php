<?php

declare(strict_types=1);

namespace App\Command\Products;

use App\Service\Products\ImportService;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCommand extends Command
{
    protected static $defaultName = 'app:products:import';

    public function __construct(private ImportService $importService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Import products from an imported file');
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $output->writeln('Start Import');
            $this->importService->importFromFile();
            $output->writeln('Products imported: ' . $this->importService->getAddedProductsCount());
            $output->writeln('End Import');
        } catch (Exception $exception) {
            throw new Exception('Import has errors. Check logs', 0, $exception);
        }

        return Command::SUCCESS;
    }
}