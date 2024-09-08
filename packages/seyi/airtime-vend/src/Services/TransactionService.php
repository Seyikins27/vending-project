<?php

namespace Seyi\AirtimeVend\Services;

use App\Models\UserWallet;

interface Transaction
{
   static function credit($amount);
   static function debit($amount);
   static function set_source($details);
}

trait Error
{
    public function log_error($error)
     {
         throw new \Exception($error);
     }
}

abstract class TransactionService implements Transaction
{
   use Error;
   protected $user_wallet;
   public $source_details;
   public $description, $new_balance, $other_info;

   public static function credit($amount)
   {
      $source=self::$source_details;
      $type="Cr";
      self::$description='Account Credited with '.$amount;
      self::$new_balance=self::$user_wallet->balance+$amount;
      return self::record_transaction($type, $amount);
   }

   public static function debit($amount)
   {
        $source=self::$source_details;
        $type="Db";
        self::$description='Account Debited with '.$amount;
        self::$new_balance=self::$user_wallet->balance-$amount;
        return self::record_transaction($type, $amount);
   }

   private static function record_transaction($type, $amount)
   {
      try{
        return $transaction_data=[
            'user_wallet_id'=>self::$user_wallet->id,
            'reference_number'=>self::$user_wallet->user_id.date('ymdhis'),
            'transaction_type'=>$type,
            'transaction_source'=>self::$source_details??null,
            'description'=>self::$description,
            'amount'=>$amount,
            'other_info'=>self::$other_info??null
        ];
      }
    catch(\Exception $e)
    {
        return self::log_error("Transaction Error: ".$e->getMessage());
    }
        
   }

   public static function set_source($source)
   {
      self::$source_details=$source;
   }

   public static function other_info(array $data)
   {
     self::$other_info=$data;
   }

}