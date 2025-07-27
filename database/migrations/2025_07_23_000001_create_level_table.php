<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('level', function (Blueprint $table) {
            $table->string('id_level', 10)->primary();
            $table->string('nama_level', 50);
        });
    }
    public function down(): void {
        Schema::dropIfExists('level');
    }
};
