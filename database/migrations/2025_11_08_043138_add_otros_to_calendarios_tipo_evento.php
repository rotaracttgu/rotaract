<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modificar el ENUM de TipoEvento para incluir 'Otros'
        DB::statement("ALTER TABLE calendarios MODIFY COLUMN TipoEvento ENUM('Virtual','Presencial','InicioProyecto','FinProyecto','Otros') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir el cambio eliminando 'Otros' del ENUM
        DB::statement("ALTER TABLE calendarios MODIFY COLUMN TipoEvento ENUM('Virtual','Presencial','InicioProyecto','FinProyecto') NOT NULL");
    }
};
