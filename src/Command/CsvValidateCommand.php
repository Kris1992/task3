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

    /**
     * Path to public directory
     * @var string  
     */
    private $csvDirectory;

    /**
     * @var CSVFileValidatorInterface  
     */
    private $CSVFileValidator;

    /**
     * @var EmailSegregationSystemInterface  
     */
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
            ->addOption('highPrecision', null, InputOption::VALUE_OPTIONAL, 'High precision mode (default = FALSE) [optional]')
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

            if (!$this->CSVFileValidator->validate($filePath)) {
                throw new \Exception('Given file is not valid csv file.');       
            }

        } catch (\Exception $e) {
            $io->error($e->getMessage());
            return 0;
        }

        $highPrecision = filter_var($input->getOption('highPrecision'), FILTER_VALIDATE_BOOLEAN) ?? true;

        if ($highPrecision) {
            $io->note('High precision is on, so it can take some time.');
        } else {
            $io->note('High precision is set to off!!');
        }

        try {
            $status = $this->emailSegregationSystem->segregate($filePath, $highPrecision);
        } catch (\Exception $e) {
            $io->error($e->getMessage());
            return 0;
        }
        

        $io->note(sprintf('Valid emails: %d', $status['valid']));
        $io->note(sprintf('Invalid emails: %d', $status['invalid']));
        $io->success('Reports generated successful.');

        return 0;
    }

}
