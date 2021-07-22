<?php

namespace App\Validation;

use App\Repositories\IUserRepository;
use Illuminate\Http\Request;

class UserBalanceValidator extends Validator {

    private $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(Request $request): ?Request {
        $payer = $this->userRepository->Get($request->payerid);
        
        echo 'validando saldo | ';
        if((int)$payer->balance < $request->value) {
            echo 'O usuário não tem saldo suficiente | ';
            parent::AddError('O usuário não tem saldo suficiente');
        }

        return parent::handle($request);
    }

    public function Validate(){
        
    }
}