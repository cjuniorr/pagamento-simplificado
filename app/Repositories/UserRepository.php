<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;

class UserRepository implements IUserRepository {
    public function Add(Request $request){
        User::create(['fullname' => $request->fullname,
                                 'cpf' => $request-> cpf,
                                 'email' => $request->email,
                                 'usertype' => $request->usertype,
                                 'balance' =>1000]);
    }

    public function GetAll(){
        return User::all();
    }

    public function Get($id){
        return User::find($id);
    }

    public function Remove(int $id){
        return User::destroy($id);
    }
}