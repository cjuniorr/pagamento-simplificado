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
        
        echo 'passou pelo user validator | ';

        if($payer->usertype === 'lojista') {
            parent::AddError('Lojistas não podem fazer a transação.');
        }

        return parent::handle($request);
    }
}