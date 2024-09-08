<?php

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
        Schema::create('vending_partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('endpoint');
            $table->text('header_information');
            $table->text('parameters');
            $table->string('network_attribute');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vending_partners');
    }
};
