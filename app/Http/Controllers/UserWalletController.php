<?php

namespace App\Http\Controllers;

use App\Models\UserWallet;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Seyi\AirtimeVend\Services\TransactionService;
use Seyi\AirtimeVend\Services\WalletTransaction;

class UserWalletController extends Controller
{
    public function balance()
    {
        try{
            $user=auth()->user()->id;
            $wallet=UserWallet::where('user_id',$user)->firstOrFail();
            return response()->json([
                'status' => true,
                'message' => 'Balance Fetched',
                'data' => [
                    'wallet_id'=>$wallet->wallet_id,
                    'balance'=>$wallet->balance
                ],
            ]);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Wallet ',
                'error' => $e->getMessage(),
            ]);
        }
        catch(Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'Error Fetching Wallet details',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function transactions()
    {
        try{
            $user=auth()->user()->id;
            $wallet=UserWallet::where('user_id',$user)->with('transactions')->firstOrFail();
            return response()->json([
                'status' => true,
                'message' => 'Balance Fetched',
                'data' => [
                    'balance'=>$wallet->balance,
                    'transactions'=>$wallet->transactions
                ],
            ]);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Wallet ',
                'error' => $e->getMessage(),
            ]);
        }
        catch(Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'Error Fetching Wallet transactions',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function topup(Request $request)
    {
        try{
             $request->validate([
                'amount'=>'required'
             ]);
            $user=auth()->user()->id;
            $wallet=UserWallet::where('user_id',$user)->firstOrFail(); 
            $topup_request=new WalletTransaction($wallet);
            $topup_request->set_source('ACCT-CREDITED')->wallet_credit($request->amount);
            return response()->json([
                'status' => true,
                'message' => 'Account credited successfully',
            ]);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Wallet',
                'error'=>$e->getMessage()
            ]);
        }
        catch(Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'Error crediting Account ',
                'error'=>$e->getMessage()
            ]);
        }
    }
}
