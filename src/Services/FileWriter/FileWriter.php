<?php
declare(strict_types=1);

namespace App\Services\FileWriter;

class FileWriter implements FileWriterInterface
{

    private $file;

    /**
     * Absolute file path
     * @var string
     */
    private $filePath;

    public function openFile(string $filePath): void
    {
        $this->file = fopen($filePath, "w");
        if (!$this->file) {
            throw new Exception(sprintf('Cannot write to this file: %s.', $filePath));
        }
        
        $this->filePath = $filePath;
    }

    public function write(Array $data): void
    {   
    
        if (!fwrite($this->file, implode("\n", $data))) {
            fclose($this->file);
            throw new \Exception(sprintf('Cannot write data to file: %s', $this->filePath));
        }

        fclose($this->file);
    }

}
