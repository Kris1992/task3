<?php
declare(strict_types=1);

namespace App\Services\EmailValidator;

/**
 *  Contract to validate email
 */
interface EmailValidatorInterface
{   

    public function validate(?string $email): void;

    public function getValid(): Array;

    public function getInvalid(): Array;

}
