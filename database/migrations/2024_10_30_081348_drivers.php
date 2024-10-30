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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 255);
            $table->enum('vehicle_type', ['Kendaraan Kecil', 'Kendaraan Besar']);
            $table->string('vehicle_number', 255);
            $table->timestamps();
            $table->string('created_by', 255);
            $table->string('updated_by', 255)->nullable();
            $table->foreign('created_by')->references('username')->on('user_auth');
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
