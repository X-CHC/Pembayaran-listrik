<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->string('id_pembayaran', 10)->primary();
            $table->string('id_tagihan', 10);
            $table->string('id_pelanggan', 10);
            $table->dateTime('tanggal_pembayaran');
            $table->string('bulan_bayar', 10);
            $table->string('tahun_bayar', 4);
            $table->decimal('biaya_admin', 10, 2);
            $table->decimal('total_bayar', 10, 2);
            $table->string('id_user', 10);
            $table->enum('metode_pembayaran', ['tunai','transfer','e-wallet']);
            $table->string('bukti_pembayaran', 255)->nullable();
        });
    }
    public function down(): void {
        Schema::dropIfExists('pembayaran');
    }
};
