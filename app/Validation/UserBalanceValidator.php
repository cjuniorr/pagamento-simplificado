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
        echo 'passou pelo balance validator | ';
        $payer = $this->userRepository->Get($request->payerid);

        if((int)$payer->balance < $request->value) {
            parent::AddError('O usuário não tem saldo suficiente');
        }

        return parent::handle($request);
    }
}