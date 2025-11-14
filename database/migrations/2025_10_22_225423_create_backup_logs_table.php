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
        Schema::create('backup_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('backup_id')->index('backup_logs_backup_id_foreign');
            $table->string('tipo_log');
            $table->text('mensaje');
            $table->timestamp('fecha_log')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backup_logs');
    }
};
