<?php

namespace App\Validation;

use App\Repositories\IUserRepository;
use Illuminate\Http\Client\Request;

class UserTypeValidator extends Validator {
    private $userRepository;

    function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function Validate (Request $request) {

        $payer = $this->userRepository->Get($request->payerid);

        if($payer->usertype === 'lojista') {
            $this->next->AddError('Lojistas não podem fazer a transação.');
            // return response()->json(['erro' => 'Lojistas não podem fazer a transação.'], 404);
         }

         return $this->next->Validate($request);
    }
}