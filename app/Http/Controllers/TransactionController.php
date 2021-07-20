<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController {

    public function GetAll(){
        return Transaction::all();
    }

    public function Add(Request $request){
        return response()
            ->json(Transaction::create(['payeeid' => $request->payeeid,
                                'payerid' => $request-> payerid,
                                'value' => $request->value]), 201);
    }

    public function Get(int $id){
        $transaction = Transaction::find($id);

        if(is_null($transaction)){
            return response()->json('', 204);
        }

        return response()->json($transaction);
    }

    public function Remove (int $id) {
        $transactionQuantityDeleted = Transaction::destroy($id);

        if($transactionQuantityDeleted === 0){
            return response()->json([
                'erro' =>'Transação não encontrada'
            ], 404);
        }

        return response()->json('', 204);
    }
}