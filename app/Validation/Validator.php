<?php

namespace App\Validation;

use Illuminate\Http\Request;

abstract class Validator implements IValidator {

    private $nextHandler;
    protected $errors = [];

    public function setNext(Validator $handler): Validator {

        $this->nextHandler = $handler;

        return $handler;
    }

    public function handle(Request $request): ?Request {
        echo 'passando no handle abstract | ';

        if($this->nextHandler) {
            return $this->nextHandler->handle($request);
        }

        echo 'saindo do absctract null | ';
        return null;
    }

    public function GetErrors(){
        return $this->errors;
    }

    public function AddError($newErrorMessage){

        echo 'adicionou um erro | ';
        // $currentErrors = $this->errors;
        // $this->errors = array_push($errorMessage, $currentErrors);
        array_push($this->errors, $newErrorMessage);
    }
}
