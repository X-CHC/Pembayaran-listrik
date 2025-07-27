<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tarif', function (Blueprint $table) {
            $table->string('id_tarif', 10)->primary();
            $table->string('daya', 20);
            $table->decimal('tarifperkwh', 10, 2);
            $table->enum('aktif', ['Y','N']);
            $table->timestamp('created_at')->useCurrent();
        });
    }
    public function down(): void {
        Schema::dropIfExists('tarif');
    }
};
