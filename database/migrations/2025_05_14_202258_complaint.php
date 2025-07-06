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
        Schema::create('complaint', function (Blueprint $table) {
            $table->string('troubleID')->primary(); // Digunakan sebagai primary key
            $table->bigInteger('nik');
            $table->string('devices');
            $table->text('trouble');
            $table->text('action')->nullable();
            $table->enum('status', ['Added', 'On Process', 'Finished'])->default('Added');
            $table->string('photo')->nullable();
            $table->foreign('nik')->references('nik')->on('user_detail')->cascadeOnDelete();
            $table->timestamps(); // created_at dan updated_at
            $table->string('created_by', 255);
            $table->string('updated_by', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('it-docs');
        // Hapus foreign key jika ada
    }
};
