<?php
declare(strict_types=1);

namespace App\Services\EmailSegregationSystem;

use App\Services\FileReader\FileReaderInterface;
use App\Services\EmailValidator\EmailValidatorInterface;
use App\Services\ReportsGenerator\ReportsGeneratorInterface;

class EmailSegregationSystem implements EmailSegregationSystemInterface
{   
    
    private $CSVfileReader;
    private $emailValidator;
    private $reportsGenerator;
    private $csvDirectory;

    /**
     * @param FileReaderInterface       $CSVfileReader   
     * @param EmailValidatorInterface   $emailValidator   
     * @param ReportsGeneratorInterface $reportsGenerator
     * @param string                    $csvDirectory
     */
    public function __construct(FileReaderInterface $CSVfileReader, EmailValidatorInterface $emailValidator, ReportsGeneratorInterface $reportsGenerator, string $csvDirectory)
    {
        $this->CSVfileReader = $CSVfileReader;
        $this->emailValidator = $emailValidator;
        $this->reportsGenerator = $reportsGenerator;
        $this->csvDirectory = $csvDirectory;
    }

    public function segregate(string $filePath): Array
    {
        $this->CSVfileReader->read($filePath);
        $emailsArray = $this->CSVfileReader->parseToArray();
        
        foreach ($emailsArray as $email) {
            $this->emailValidator->validate($email);
        }

        $valid = $this->emailValidator->getValid();
        $invalid = $this->emailValidator->getInvalid();

        $this->reportsGenerator->generate($this->csvDirectory, $invalid, $valid);

        return [
            'valid' => count($valid),
            'invalid' => count($invalid),
        ];
    }

}
