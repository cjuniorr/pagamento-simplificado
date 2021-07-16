<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController{
    public function GetAll(){
        return User::all();
    }

    public function Add(Request $request){

        // var_dump($request->fullName);
        // exit();

        return response()
            ->json(User::create(['fullname' => $request->fullname,
                                 'cpf' => $request-> cpf,
                                 'email' => $request->email,
                                 'usertype' => $request->usertype]), 201);
    }
}