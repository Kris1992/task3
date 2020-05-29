<?php
declare(strict_types=1);

namespace App\Services\EmailValidator;

class EmailValidator implements EmailValidatorInterface
{

    private $validArray = [];

    private $invalidArray = [];

    public function validate(?string $email): void
    {
        if ($this->basicValidator($email) && $this->regexValidator($email)) {
            array_push($this->validArray, $email);
        } else {
            array_push($this->invalidArray, $email);
        }

    }

    public function getInvalid(): Array
    {
        return $this->invalidArray;
    }

    public function getValid(): Array
    {
        return $this->validArray;
    }

    private function basicValidator(?string $email): bool
    {
       if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
           return true; 
       }
       
       return false;
    }

    private function regexValidator(?string $email): bool
    {
        //sprawdzić czy są dwie kropki w domenie
        //sprawdzić czy końcowka ma 2 litery

       //$emailParts = explode("@", $email);
       
       // preg_match()

       //var_dump($emailParts[1]);

       if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
           return true; 
       }
       
       return false;
    }

}
