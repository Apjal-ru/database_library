<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('peminjaman', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_buku');
        $table->string('nama_peminjam');
        $table->string('judul_buku');
        $table->string('penerbit_buku');
        $table->integer('jumlah');
        $table->integer('terbit');
        $table->date('tanggal_peminjaman');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
