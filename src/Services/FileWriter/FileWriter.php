<?php
declare(strict_types=1);

namespace App\Services\FileWriter;

class FileWriter implements FileWriterInterface
{

    private $file;

    private $filePath;

    public function openFile(string $filePath): void
    {
        $this->file = fopen($filePath, "w");
        $this->filePath = $filePath;
    }

    public function write(Array $data): void
    {   
        if (!fwrite($this->file, print_r($data, TRUE))) {
            fclose($this->file);
            throw new \Exception(sprintf('Cannot write data to file: %s', $this->filePath));
        }

        fclose($this->file);
    }

}
