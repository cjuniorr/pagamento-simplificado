<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface IUserRepository {
    public function Add(Request $request);
    public function GetAll();
    public function Get(int $id);
    public function Remove(int $id);
}