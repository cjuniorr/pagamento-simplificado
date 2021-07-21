<?php

namespace App\Http\Controllers;

use App\Repositories\ITransactionRepository;
use App\Repositories\IUserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        try{ 

            $payer = $this->userRepository->Get($request->payerid);

    
            if((int)$payer->balance < $request->value) {
                return response()->json(['erro' => 'O usuário não tem saldo suficiente'], 404);
            }
    
            if($payer->usertype === 'lojista') {
                return response()->json(['erro' => 'Lojistas não podem fazer a transação.'], 404);
             }

             
            $autorizationResponse = Http::withOptions(['verify' => false])->get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
                
            if($autorizationResponse->failed()){ 
                Log::warning('A autorização não foi autorizada.');
                return response()->json(['erro' => 'A transação não foi autorizada.'], 403);
            }
            
            $this->transactionRepository->Add($request);
            
            $notificationResponse = Http::withOptions(['verify' => false])->get('http://o4d9z.mocklab.io/notify');

            if($notificationResponse->failed()){
                Log::warning('Não possível notificar o beneficiário.');
                return response()->json(['erro' => 'Não foi possível notificar o beneficiário'], 404);
            }

            return response()->json(['Transação realizada com sucesso.'], 201);

        } catch(Exception $e) {
            Log::error('Ocorreu um erro durante do registro da transação');
            throw new Exception('Ocorreu um erro durante do registro da transação', $e);
        }

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