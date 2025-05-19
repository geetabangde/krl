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
        Schema::create('ledger_master', function (Blueprint $table) {
            $table->id();
            $table->string('ledger_name');
            $table->string('group_id');
            $table->string('pan');
            $table->string('tan');
            $table->string('gst');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledger_master');
    }
};
