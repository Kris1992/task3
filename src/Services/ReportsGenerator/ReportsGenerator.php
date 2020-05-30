<?php
declare(strict_types=1);

namespace App\Services\ReportsGenerator;

use App\Services\FileWriter\FileWriterInterface;

class ReportsGenerator implements ReportsGeneratorInterface
{   
    
    /**
     * @var FileWriterInterface
     */
    private $fileWriter;

    public function __construct(FileWriterInterface $fileWriter)
    {
        $this->fileWriter = $fileWriter;
    }

    public function generate(string $folderPath, Array $invalid, Array $valid): void
    {

        $this->fileWriter->openFile(sprintf('%s/%s', $folderPath, 'invalidEmails.txt'));
        $this->fileWriter->write($invalid);

        $this->fileWriter->openFile(sprintf('%s/%s', $folderPath, 'validEmails.txt'));
        $this->fileWriter->write($valid);

        $report = [
            'Number of valid emails:',
            count($valid),
            'Number of invalid emails:',
            count($invalid)
        ];

        $this->fileWriter->openFile(sprintf('%s/%s', $folderPath, 'report.txt'));
        $this->fileWriter->write($report);
    }

}
