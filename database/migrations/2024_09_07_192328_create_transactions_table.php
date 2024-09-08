<?php

use App\Models\NetworkProvider;
use App\Models\UserWallet;
use App\Models\VendingPartner;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(UserWallet::class);
            $table->string('reference_number')->unique();
            $table->enum('transaction_type',['Cr','Db']);
            $table->string('transaction_source');
            $table->string('description')->nullable();
            $table->double('amount');
            $table->tinyText('other_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
