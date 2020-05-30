<?php
declare(strict_types=1);

namespace App\Services\FileReader;

class CSVFileReader implements FileReaderInterface
{

    /*Don't read more than 400 chars in one line*/
    const MAX_LINE_LENGTH = 400;

    private $file;

    public function __destruct()
    {
        if ($this->file) {
            fclose($this->file);
        }
    }

    public function read(string $filePath): void
    {
        $this->file = fopen($filePath, "r");
        if (!$this->file) {
            throw new \Exception("Cannot read this file.");
        }
    }

    public function parseToArray(): Array
    {   

        $emailsArray = Array();
        while (($emailRow = fgetcsv($this->file, self::MAX_LINE_LENGTH, "\n")) !== FALSE) {
            array_push($emailsArray, $emailRow[0]);
        }
        
        return $emailsArray;     
    }

}
