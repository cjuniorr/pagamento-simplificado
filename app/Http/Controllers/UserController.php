<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\IUserRepository;

class UserController extends Controller {

    private $userRepository;

    function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function GetAll() {
        return $this->userRepository->GetAll();
    }

    public function Add(Request $request){
        return response()->json($this->userRepository->Add($request), 201);
    }

    public function Get(int $id){
        $user = $this->userRepository->Get($id);

        if(is_null($user)){
            return response()->json('', 204);
        }

        return response()->json($user);
    }

    public function Remove (int $id) {
        $userQuantityDeleted = $this->userRepository->Remove($id);

        if($userQuantityDeleted === 0){
            return response()->json([
                'erro' =>'Usuário não encontrado'
            ], 404);
        }

        return response()->json('', 204);
    }
}