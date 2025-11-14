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
        if (!Schema::hasTable('historialreportes')) {
            Schema::create('historialreportes', function (Blueprint $table) {
                $table->id('HistorialReporteID');
                $table->unsignedBigInteger('ReporteID');
                $table->foreignId('UsuarioID')->nullable()->constrained('users')->onDelete('set null');
                $table->enum('Accion', ['CREACION', 'REGENERACION', 'EDICION', 'ELIMINACION']);
                $table->dateTime('FechaEvento')->useCurrent();
                $table->string('TituloSnapshot', 100)->nullable();
                $table->string('RutaArchivoSnapshot', 255)->nullable();
                $table->text('ResumenSnapshot')->nullable();
                $table->json('MetadataJSON')->nullable();
                
                $table->foreign('ReporteID')->references('ReporteID')->on('reportes')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historialreportes');
    }
};
