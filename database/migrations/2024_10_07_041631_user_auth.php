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
        Schema::create('user_auth', function (Blueprint $table) {
            $table->string('username', 255)->primary();
            $table->string('password', 255);
            $table->string('remember_token', 100)->nullable();
            $table->tinyInteger('frp')->default(0);
            $table->enum('role', ['superadmin', 'administrator', 'user']);
            $table->timestamps();
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
