<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Models\UserWallet;

class UserWalletObserver
{
    /**
     * Handle the UserWallet "created" event.
     */
    public function created(UserWallet $userWallet): void
    {
        Transaction::create([
            'user_wallet_id'=>$userWallet->id,
            'reference_number'=>$userWallet->user_id.date('ymdhis'),
            'transaction_type'=>'Cr',
            'transaction_source'=>'ACCT-CREATED',
            'description'=>'Initial Deposit',
            'amount'=>$userWallet->balance,
            'other_info'=>null
        ]);
    }

    /**
     * Handle the UserWallet "updated" event.
     */
    public function updated(UserWallet $userWallet): void
    {
        //
    }

    /**
     * Handle the UserWallet "deleted" event.
     */
    public function deleted(UserWallet $userWallet): void
    {
        //
    }

    /**
     * Handle the UserWallet "restored" event.
     */
    public function restored(UserWallet $userWallet): void
    {
        //
    }

    /**
     * Handle the UserWallet "force deleted" event.
     */
    public function forceDeleted(UserWallet $userWallet): void
    {
        //
    }
}
