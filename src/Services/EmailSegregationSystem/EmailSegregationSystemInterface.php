<?php
declare(strict_types=1);

namespace App\Services\EmailSegregationSystem;

/**
 *  Contract to segregate emails and generate reports
 */
interface EmailSegregationSystemInterface
{   

    /**
     * segregate Take care about all proccess of segregate emails and writing reports
     * @param  string $filePath Path to file with emails to segregate
     * @param  bool $mode       High precision on or off
     * @throws Exception        Throw Exception when file with emails is not readable or file to save is not writable
     * @return Array            Array with numbers of invalid and valid emails
     */
    public function segregate(string $filePath, bool $mode): Array;

}
