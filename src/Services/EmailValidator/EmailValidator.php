<?php
declare(strict_types=1);

namespace App\Services\EmailValidator;

class EmailValidator implements EmailValidatorInterface
{

    private $validArray = [];

    private $invalidArray = [];

    public function validate(?string $email, bool $mode): void
    {
        if ($this->isValid($email, $mode)) {
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

    private function isValid(?string $email, bool $mode): bool
    {   
        if ($mode) {
           $isValid = $this->basicValidator($email);
           
           if ($isValid) {
               $isValid = $this->dnsValidator($email);
           }

        } else {
            $isValid = $this->basicValidator($email);
        }

        return $isValid;
    }

    private function basicValidator(?string $email): bool
    {
       if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
           return true; 
       }
       
       return false;
    }

    private function dnsValidator(?string $email): bool
    {   
        $emailParts = explode("@", $email);
        return checkdnsrr($emailParts[1], 'MX');
    }

    private function regexValidator(?string $email): bool
    {
        

       //$emailParts = explode("@", $email);
       
       // preg_match()

       //var_dump($emailParts[1]);

       if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
           return true; 
       }
       
       return false;
    }

}
