<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('penggunaan', function (Blueprint $table) {
            $table->string('id_penggunaan', 10)->primary();
            $table->string('id_pelanggan', 10);
            $table->string('bulan', 10);
            $table->string('tahun', 4);
            $table->decimal('meter_awal', 10, 2);
            $table->decimal('meter_akhir', 10, 2);
            $table->date('tanggal_catat');
            $table->enum('status_verifikasi', ['terverifikasi','belum']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('penggunaan');
    }
};
