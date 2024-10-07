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
        Schema::create('user_detail', function (Blueprint $table) {
            $table->bigInteger('nik', 255)->primary();
            $table->string('username', 255);
            $table->string('fullname', 255);
            $table->string('position', 255);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('username')->references('username')->on('user_auth');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
