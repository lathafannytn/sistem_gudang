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
        Schema::create('mutasis', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('jenis_mutasi', ['Penambahan Stok', 'Pengurangan Stok']);
            $table->integer('jumlah');
            $table->unsignedBigInteger('barangs_id');
            $table->unsignedBigInteger('users_id');
            $table->timestamps();
            $table->softDeletes();
        
            // Foreign keys
            $table->foreign('barangs_id')->references('id')->on('barangs')->onDelete('cascade');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasis');
    }
};
