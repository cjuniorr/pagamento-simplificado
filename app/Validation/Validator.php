<?php

namespace App\Validation;

use Illuminate\Http\Request;

abstract class Validator implements IValidator {

    private $nextHandler;
    public $errors = array();

    public function setNext(Validator $handler): Validator {

        $this->nextHandler = $handler;

        return $handler;
    }

    public function handle(Request $request): ?Request {
        echo 'passando no handle abstract | ';

        if($this->nextHandler) {
            echo 'executando handler | ';
            return $this->nextHandler->handle($request);
        }

        echo 'saindo do absctract null';
        return null;
    }

    public function GetErrors(){
        return $this->errors;
    }

    public function AddError($errorMessage){
        $currentErrors = $this->errors;
        $this->errors = array_push($errorMessage, $currentErrors);
    }
}
