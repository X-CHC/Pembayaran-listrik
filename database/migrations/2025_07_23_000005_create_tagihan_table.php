<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->string('id_tagihan', 10)->primary();
            $table->string('id_penggunaan', 10);
            $table->string('id_pelanggan', 10);
            $table->string('bulan', 10);
            $table->string('tahun', 4);
            $table->decimal('jumlah_meter', 10, 2);
            $table->enum('status', ['lunas','belum','tunggak']);
            $table->date('tanggal_jatuh_tempo');
            $table->timestamp('tanggal_dibuat')->useCurrent();
        });
    }
    public function down(): void {
        Schema::dropIfExists('tagihan');
    }
};
