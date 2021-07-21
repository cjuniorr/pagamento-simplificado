<?php

namespace App\Validation;

use App\Repositories\IUserRepository;
use Illuminate\Http\Client\Request;

class UserBalanceValidator extends Validator {

    private $userRepository;
    private $next;

    public function __construct(IUserRepository $userRepository, Validator $next)
    {
        $this->userRepository = $userRepository;
        $this->next =$next;
    }

    public function Validate(Request $request){

        $payer = $this->userRepository->Get($request->payerid);

        if((int)$payer->balance < $request->value) {
            $this->next->AddError('O usuário não tem saldo suficiente');
            // return response()->json(['erro' => 'O usuário não tem saldo suficiente'], 404);
        }

        return $this->next->Validate($request);
    }
}