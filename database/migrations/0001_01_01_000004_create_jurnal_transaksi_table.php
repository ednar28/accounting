<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('journal_transactions', function (Blueprint $table) {
            $table->id();
            $table->morphs('modelable');
            $table->string('description');
            $table->unsignedInteger('total_debit');
            $table->unsignedInteger('total_credit');
            $table->date('transaction_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal');
    }
};
