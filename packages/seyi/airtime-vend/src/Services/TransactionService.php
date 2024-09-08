<?php

namespace Seyi\AirtimeVend\Services;

use App\Models\Transaction as ModelsTransaction;
use App\Models\UserWallet;
use Exception;

interface Transaction
{
   function credit($amount);
   function debit($amount);
}

trait Error
{
    public function log_error($error)
     {
         throw new \Exception($error);
     }
}

class TransactionService implements Transaction
{
   use Error;
   protected $user_wallet;
   public $source_details;
   public $description, $new_balance, $other_info;

   public function credit($amount)
   {
      $type="Cr";
      $this->description='Account Credited with '.$amount;
      $this->new_balance=$this->user_wallet->balance+$amount;
      $this->record_transaction($type, $amount);
      return $this;
   }

   public function debit($amount)
   {
        $source=$this->source_details;
        $type="Db";
        $this->description='Account Debited with '.$amount;
        $wallet_balance=$this->user_wallet->balance;
        if($wallet_balance<$amount)
        {
         throw new Exception("Your Wallet balance is insufficient");
        }
        $this->new_balance=$wallet_balance-$amount;
        $this->record_transaction($type, $amount);
        return $this;
   }

   private function record_transaction($type, $amount)
   {
      try{
         $transaction_data=[
            'user_wallet_id'=>$this->user_wallet->id,
            'reference_number'=>$this->user_wallet->user_id.date('ymdhis').\uniqid(),
            'transaction_type'=>$type,
            'transaction_source'=>$this->source_details??"ACCT-NA",
            'description'=>$this->description,
            'amount'=>$amount,
            'other_info'=>$this->other_info??null
        ];
        ModelsTransaction::create($transaction_data);
      }
    catch(\Exception $e)
    {
        return $this->log_error("Transaction Error: ".$e->getMessage());
    }
        
   }

   public function set_source($source)
   {
      $this->source_details=$source;
      return $this;
   }

   public function other_info(array $data)
   {
     $this->other_info=$data;
     return $this;
   }

}

