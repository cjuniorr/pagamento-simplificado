<?php

namespace App\Http\Controllers;

use App\Repositories\ITransactionRepository;
use App\Repositories\IUserRepository;
use App\Services\IAuthorizationService;
use App\Services\INotificationService;
use App\Validation\UserBalanceValidator;
use App\Validation\Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller {

    private $transactionRepository;
    private $userRepository;
    private $authorizationService;
    private $notificationService;

    function __construct(ITransactionRepository $transactionRepository, IUserRepository $userRepository,
                         IAuthorizationService $authorizationService)
    {
        $this->transactionRepository = $transactionRepository;
        $this->userRepository = $userRepository;
        $this->authorizationService = $authorizationService;
        // $this->notificationService = $notificationService;
    }


    public function GetAll(){
        return $this->transactionRepository->GetAll();
    }

    public function Add(Request $request){
        try{ 

            $payer = $this->userRepository->Get($request->payerid);

            // $validation = new Validator(new UserBalanceValidator().Validate($request));
    
            
            if((int)$payer->balance < $request->value) {
                return response()->json(['erro' => 'O usuário não tem saldo suficiente'], 404);
            }
    
            if($payer->usertype === 'lojista') {
                return response()->json(['erro' => 'Lojistas não podem fazer a transação.'], 404);
             }
             
             $autorizationResponse = $this->authorizationService->Authorize();


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

            return response()->json(['message'=> 'Transação realizada com sucesso.'], 201);

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