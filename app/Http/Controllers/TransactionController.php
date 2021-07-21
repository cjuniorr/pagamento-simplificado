<?php

namespace App\Http\Controllers;

use App\Repositories\ITransactionRepository;
use App\Repositories\IUserRepository;
use Illuminate\Http\Request;

class TransactionController extends Controller {

    private $transactionRepository;
    private $userRepository;

    function __construct(ITransactionRepository $transactionRepository, IUserRepository $userRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->userRepository = $userRepository;
    }


    public function GetAll(){
        return $this->transactionRepository->GetAll();
    }

    public function Add(Request $request){
        $payer = $this->userRepository->Get($request->payerid);
        
        if((int)$payer->balance < $request->value) {
            return response()->json(['erro' => 'O usuário não tem saldo suficiente'], 403);
        }

        if($payer->usertype === 'lojista') {
            return response()->json(['erro' => 'Lojistas não podem fazer a transação.'], 403);
         }

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