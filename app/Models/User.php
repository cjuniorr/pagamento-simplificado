<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
    public $timestamps = false;
    protected $fillable = ['fullname', 'cpf', 'email', 'usertype', 'balance'];
}