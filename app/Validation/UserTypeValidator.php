<?php

namespace App\Validation;

use App\Repositories\IUserRepository;
use Illuminate\Http\Request;

class UserTypeValidator extends Validator {

    private $userRepository;

    function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(Request $request): ?Request {
        $payer = $this->userRepository->Get($request->payerid);
        
        echo 'validando usuario | ';
        if($payer->usertype === 'lojista') {
            echo 'Lojistas não podem fazer a transação. | ';
            parent::AddError('Lojistas não podem fazer a transação.');
        }

        return parent::handle($request);
    }
}