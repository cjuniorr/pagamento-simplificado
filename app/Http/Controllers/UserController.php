<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController{
    public function GetAll(){
        return User::all();
    }
}