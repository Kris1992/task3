<?php
declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputArgument, InputInterface, InputOption};
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Services\CSVFileValidator\CSVFileValidatorInterface;
use App\Services\EmailSegregationSystem\EmailSegregationSystemInterface;

class CsvValidateCommand extends Command
{
    protected static $defaultName = 'app:csv:validate';

    /* Path to public directory */
    private $csvDirectory;

    private $CSVFileValidator;

    private $emailSegregationSystem;

    public function __construct(CSVFileValidatorInterface $CSVFileValidator, EmailSegregationSystemInterface $emailSegregationSystem, string $csvDirectory)
    {
        parent::__construct(null);
        $this->csvDirectory = $csvDirectory;
        $this->CSVFileValidator = $CSVFileValidator;
        $this->emailSegregationSystem = $emailSegregationSystem;
    }

    protected function configure()
    {
        $this
            ->setDescription('Validate csv file from public dir given by name ')
            ->addArgument('csvName', InputArgument::REQUIRED, 'Name of csv file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $csvName = $input->getArgument('csvName');

        if ($csvName) {
            $io->note(sprintf('You passed csv name: %s', $csvName));
        }   

        $filePath = sprintf('%s/%s', $this->csvDirectory, $csvName);

        try {
            $isValid = $this->CSVFileValidator->validate($filePath);
        } catch (\Exception $e) {
            $io->error($e->getMessage());
            return 0;
        }
        
        if (!$isValid) {
            $io->error('Given file is not valid csv file');
            return 0;
        }

        $status = $this->emailSegregationSystem->segregate($filePath);

        $io->note(sprintf('Valid emails: %d', $status['valid']));
        $io->note(sprintf('Invalid emails: %d', $status['invalid']));
        $io->success('Reports generated successfull');

        return 0;
    }
}
