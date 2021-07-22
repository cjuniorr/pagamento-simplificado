<?php

namespace App\Repositories;

use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionRepository implements ITransactionRepository {

    private $userRepository;

    function __construct(){ }

    public function Add(Request $request){
        try {
                $payeeBalance = DB::select('select balance from users where id = :id', ['id' => $request->payeeid])[0];
                $payerBalance = DB::select('select balance from users where id = :id', ['id' => $request->payerid])[0];
        
                $payerNewBalance = ((int)$payerBalance->balance) - ((int)$request->value);
                $payeeNewBalance = ((int)$payeeBalance->balance) + ((int)$request->value);
        
                DB::beginTransaction();
                DB::update('update users set balance = :newBalance where id = :id',['newBalance' => $payerNewBalance, 'id'=>$request->payerid]);
                DB::update('update users set balance = :newBalance where id = :id',['newBalance' => $payeeNewBalance, 'id'=>$request->payeeid]);
        
                Transaction::create(['payeeid' => $request->payeeid,
                                        'payerid' => $request-> payerid,
                                        'value' => $request->value]);
        
                DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Ocorreu um erro durante a realização da transação.", $e);
        }
    }

    public function GetAll(){
        return Transaction::all();
    }

    public function Get(int $id){
        return Transaction::find($id);
    }

    public function Remove(int $id){

        try {
            DB::beginTransaction();
            $transactionsDeleted = Transaction::destroy($id);
            DB::commit();
        } catch(Exception $e) {
            DB::rollBack();
            throw new Exception("Ocorreu um erro durante a remoção da transação.", $e);
        }
    }
}