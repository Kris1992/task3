<?php
declare(strict_types=1);

namespace App\Services\FileReader;

/**
 *  Contract to read file
 */
interface FileReaderInterface
{   
    /**
     * read Open file to read
     * @param  string $filePath String with path to file
     * @return void
     */
    public function read(string $filePath): void;

    /**
     * parseToArray Parse data from file to array
     * @return Array
     */
    public function parseToArray(): Array;

}
