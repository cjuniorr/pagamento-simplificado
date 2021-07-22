<?php

namespace App\Repositories;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRepository implements IUserRepository {
    public function Add(Request $request){

        try {
                DB::beginTransaction();
                User::create([
                    'fullname' => $request->fullname,
                    'cpf' => $request->cpf,
                    'email' => $request->email,
                    'usertype' => $request->usertype,
                    'balance' =>1000
                ]);
                DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Ocorreu um erro durante a inserção do novo usuário.", $e);
        }

    }

    public function GetAll(){
        return User::all();
    }

    public function Get($id){
        return User::find($id);
    }

    public function Remove(int $id){

        try {
            DB::beginTransaction();
            $usersDeleted = User::destroy($id);
            DB::commit();

            return $usersDeleted;

        } catch(Exception $e){
            DB::rollBack();
            throw new Exception("Ocorreu um erro durante a remomção do usuário.", $e);
        }
    }
}