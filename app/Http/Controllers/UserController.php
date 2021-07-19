<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController{
    public function GetAll(){
        return User::all();
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