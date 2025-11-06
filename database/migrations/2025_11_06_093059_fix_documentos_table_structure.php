<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Actualiza la estructura de la tabla documentos para que coincida con el modelo
     */
    public function up(): void
    {
        Schema::table('documentos', function (Blueprint $table) {
            // Agregar columnas faltantes si no existen
            if (!Schema::hasColumn('documentos', 'titulo')) {
                $table->string('titulo')->after('DocumentoID');
            }
            if (!Schema::hasColumn('documentos', 'descripcion')) {
                $table->text('descripcion')->nullable()->after('titulo');
            }
            if (!Schema::hasColumn('documentos', 'archivo_path')) {
                $table->string('archivo_path')->nullable()->after('descripcion');
            }
            if (!Schema::hasColumn('documentos', 'archivo_nombre')) {
                $table->string('archivo_nombre')->nullable()->after('archivo_path');
            }
            if (!Schema::hasColumn('documentos', 'creado_por')) {
                $table->unsignedBigInteger('creado_por')->nullable()->after('archivo_nombre');
            }
        });
        
        // Copiar datos de columnas antiguas a nuevas si existen datos
        DB::statement('UPDATE documentos SET titulo = Titulo WHERE Titulo IS NOT NULL AND (titulo IS NULL OR titulo = "")');
        DB::statement('UPDATE documentos SET archivo_path = RutaArchivo WHERE RutaArchivo IS NOT NULL AND (archivo_path IS NULL OR archivo_path = "")');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documentos', function (Blueprint $table) {
            $table->dropColumn(['titulo', 'descripcion', 'archivo_path', 'archivo_nombre', 'creado_por']);
        });
    }
};
