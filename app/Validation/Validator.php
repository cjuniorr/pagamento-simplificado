<?php

namespace App\Validation;

use Illuminate\Http\Client\Request;

abstract class Validator {

    protected Validator $next;
    public $errors = array();

    public function __construct(Validator $next){
        $this->next = $next;
    }

    abstract public function Validate(Request $request);

    public function AddError($errorMessage){
        $currentErrors = $this->errors;
        $this->errors = array_push($errorMessage, $currentErrors);
    }
}
