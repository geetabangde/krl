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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_type'); // Payment, Receipt, etc.
            $table->date('voucher_date');
            $table->string('to_account')->nullable(); 
            $table->string('from_account')->nullable();// Destination account
            $table->text('description')->nullable();
            $table->text('amount')->nullable();
            $table->text('tally_narration')->nullable();
            $table->text('narration')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable(); // ID of assigned person/entity
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
