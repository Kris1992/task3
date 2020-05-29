<?php
declare(strict_types=1);

namespace App\Services\ReportsGenerator;

/**
 *  Contract to generate reports
 */
interface ReportsGeneratorInterface
{   
    /**
     * generate Generate txt files with reports
     * @param  string $folderPath String with path to folder to save files
     * @param  Array  $invalid    Array with invalid emails
     * @param  Array  $valid      Array with valid emails
     * @return void
     */
    public function generate(string $folderPath, Array $invalid, Array $valid): void;

}
