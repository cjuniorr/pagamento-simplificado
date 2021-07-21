<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionRepository implements ITransactionRepository {

    private $userRepository;

    function __construct(){ }

    public function Add(Request $request){
        $payeeBalance = DB::select('select balance from users where id = :id', ['id' => $request->payeeid])[0];
        $payerBalance = DB::select('select balance from users where id = :id', ['id' => $request->payerid])[0];

        $payerNewBalance = ((int)$payerBalance->balance) - ((int)$request->value);
        $payeeNewBalance = ((int)$payeeBalance->balance) + ((int)$request->value);
        DB::update('update users set balance = :newBalance where id = :id',['newBalance' => $payerNewBalance, 'id'=>$request->payerid]);
        DB::update('update users set balance = :newBalance where id = :id',['newBalance' => $payeeNewBalance, 'id'=>$request->payeeid]);

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