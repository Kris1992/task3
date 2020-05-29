<?php
declare(strict_types=1);

namespace App\Services\FileWriter;

/**
 *  Contract to open file and write data to file
 */
interface FileWriterInterface
{   
    /**
     * openFile Open file to write into
     * @param  string $filePath String with path to file
     * @return void
     */
    public function openFile(string $filePath): void;

    /**
     * write Write data from array to file
     * @param  Array  $data Array with data to write
     * @return void
     */
    public function write(Array $data): void;

}
