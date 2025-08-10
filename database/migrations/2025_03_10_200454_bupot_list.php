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
        Schema::create('bupot_list', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('supplier_id');
            $table->enum('sbu', ['rck', 'ckl'])->default('rck');
            $table->date('date');
            $table->string('docId');
            $table->string('dpp');
            $table->string('pph');
            $table->string('whdate');
            $table->timestamps();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bupot_list');
    }
};
