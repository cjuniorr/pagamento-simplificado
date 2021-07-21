<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Repositories\ITransactionRepository;
use Illuminate\Http\Request;

class TransactionController extends Controller {

    private $transactionRepository;

    function __construct(ITransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }


    public function GetAll(){
        return $this->transactionRepository->GetAll();
    }

    public function Add(Request $request){
        return response()->json($this->transactionRepository->Add($request), 201);
    }

    public function Get(int $id){
        $transaction = $this->transactionRepository->Get($id);

        if(is_null($transaction)){
            return response()->json('', 204);
        }

        return response()->json($transaction);
    }

    public function Remove (int $id) {
        $transactionQuantityDeleted = $this->transactionRepository->Remove($id);

        if($transactionQuantityDeleted === 0){
            return response()->json([
                'erro' =>'Transação não encontrada'
            ], 404);
        }

        return response()->json('', 204);
    }
}