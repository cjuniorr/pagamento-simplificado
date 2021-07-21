<?php

namespace App\Validation;

use Illuminate\Http\Request;

interface IValidator {
    public function setNext(Validator $handler): Validator;

    public function handle(Request $request): ?Request;
}