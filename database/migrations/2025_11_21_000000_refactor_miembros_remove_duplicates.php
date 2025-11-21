<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Elimina campos duplicados de miembros que ahora se obtienen de users via JOIN
     */
    public function up(): void
    {
        Schema::table('miembros', function (Blueprint $table) {
            // Eliminar campos duplicados
            $table->dropColumn(['DNI_Pasaporte', 'Nombre', 'Correo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('miembros', function (Blueprint $table) {
            // Restaurar campos eliminados
            $table->string('DNI_Pasaporte', 20)->nullable()->unique('ux_miembros_dni')->after('user_id');
            $table->string('Nombre', 100)->after('DNI_Pasaporte');
            $table->string('Correo', 100)->nullable()->after('Rol');
        });
    }
};
