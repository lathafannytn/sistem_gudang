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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->integer('stok')->default(0);
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('lokasi_id');
            $table->timestamps();
            $table->softDeletes();
        
            // Foreign keys
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
            $table->foreign('lokasi_id')->references('id')->on('lokasis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
