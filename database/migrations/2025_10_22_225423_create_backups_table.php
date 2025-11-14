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
        Schema::create('backups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre_archivo');
            $table->string('tipo', 50)->default('manual')->index();
            $table->string('ruta_archivo');
            $table->string('tamaño')->nullable();
            $table->enum('estado', ['completado', 'en_proceso', 'fallido'])->default('en_proceso')->index();
            $table->text('descripcion')->nullable();
            $table->text('error_mensaje')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('backups_user_id_foreign');
            $table->timestamp('fecha_ejecucion')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backups');
    }
};
