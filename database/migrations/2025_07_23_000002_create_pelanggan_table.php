<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->string('id_pelanggan', 10)->primary();
            $table->string('username', 50);
            $table->string('password', 255);
            $table->string('nomor_kwh', 20);
            $table->string('nama_pelanggan', 100);
            $table->text('alamat');
            $table->string('id_tarif', 10);
            $table->enum('status_aktif', ['aktif','nonaktif']);
            $table->date('tanggal_daftar');
        });
    }
    public function down(): void {
        Schema::dropIfExists('pelanggan');
    }
};
