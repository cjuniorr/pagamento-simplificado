<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionRepository implements ITransactionRepository {

    public function Add(Request $request){
        Transaction::create(['payeeid' => $request->payeeid,
                                'payerid' => $request-> payerid,
                                'value' => $request->value]);
    }

    public function GetAll(){
        return Transaction::all();
    }

    public function Get(int $id){
        return Transaction::find($id);
    }

    public function Remove(int $id){
        return Transaction::destroy($id);
    }
}