<?php

namespace Seyi\AirtimeVend\Services;

use App\Models\UserWallet;
use Illuminate\Support\Facades\DB;

class WalletTransaction extends TransactionService
{
   public function __construct(UserWallet $user_wallet)
   {
      //parent::__construct();
      $this->user_wallet=$user_wallet;
      //$this;
   }
   
   public function update()
   {
     DB::transaction(function() {
        $this->user_wallet->update(['balance'=>$this->new_balance]);
      });
   }

   public function wallet_credit($amount)
   {
      $this->credit($amount);
      $this->update();
      return $this;
   }

   public function wallet_debit($amount)
   {
      $this->debit($amount);
      $this->update();
      return $this;
   }

   public function commission($commission, $amount)
   {
     $commission_amount=($commission/$amount)*100;
     $this->credit($commission_amount);
     $this->update();
     return $this;
   }

}