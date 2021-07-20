<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\IUserRepository;

class UserController{

    private $userRepository;

    function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function GetAll(){
        // return User::all();
        return $this->userRepository->GetAll();
    }

    public function Add(Request $request){
        return response()
            ->json(User::create(['fullname' => $request->fullname,
                                 'cpf' => $request-> cpf,
                                 'email' => $request->email,
                                 'usertype' => $request->usertype]), 201);
    }

    public function Get(int $id){
        $user = User::find($id);

        if(is_null($user)){
            return response()->json('', 204);
        }

        return response()->json($user);
    }

    public function Remove (int $id) {
        $userQuantityDeleted = User::destroy($id);

        if($userQuantityDeleted === 0){
            return response()->json([
                'erro' =>'Usuário não encontrado'
            ], 404);
        }

        return response()->json('', 204);
    }
}