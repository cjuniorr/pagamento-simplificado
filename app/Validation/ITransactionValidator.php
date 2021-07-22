<?php

namespace App\Validation;

interface ITransactionValidator {
    public function IsValid();
    public function SetIsValid($isvalid);

    public function GetErrorMessages();
    public function AddErrorMessage($errorMessage);

    public function GetPayerId();
    public function SetPayerId($payerid);

    public function GetPayeeId();
    public function SetPayeeId($payeeid);

    public function GetValue();
    public function SetValue($value);
}