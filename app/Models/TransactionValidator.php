<?php

namespace App\Models;

use App\Validation\ITransactionValidator;
use Illuminate\Http\Request;

class TransactionValidator{
    public $payerid;
    public $payeeid;
    public $value;
    private $errors = [];
    private $isValid = false;

    public function IsValid(){
        return $this->isValid;
    }

    public function GetErrorMessages(){
        return $this->errors;
    }

    public function __construct($payerid, $payeeid, $value){
        $this->payerid = $payerid;
        $this->payeeid = $payeeid;
        $this->value = $value;
    }

    public function GetPayerId(){
        return $this->payerid;
    }

    public function SetPayerId($payerid){
        $this->payerid = $payerid;
    }

    public function GetPayeeId(){
        return $this->payeeid;
    }

    public function GetValue(){
        return $this->value;
    }
}