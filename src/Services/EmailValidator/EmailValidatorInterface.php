<?php
declare(strict_types=1);

namespace App\Services\EmailValidator;

/**
 *  Contract to validate email
 */
interface EmailValidatorInterface
{   

    /**
     * validate Validate email address
     * @param  string $email Email address to validate
     * @param  bool   $mode  Bool with high precision mode on or off
     * @return void
     */
    public function validate(?string $email, bool $mode): void;

    /**
     * getValid Get all valid emails
     * @return Array Returns array with valid emails
     */
    public function getValid(): Array;

    /**
     * getInvalid Get all invalid emails
     * @return Array Returns array with invalid emails
     */
    public function getInvalid(): Array;

}
