<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Modificar la columna accion en la tabla correcta: bitacora_sistema
        if (Schema::hasTable('bitacora_sistema')) {
            DB::statement("ALTER TABLE bitacora_sistema MODIFY COLUMN accion VARCHAR(50) NOT NULL");
        }
    }

    public function down(): void
    {
        // Revertir al ENUM original
        if (Schema::hasTable('bitacora_sistema')) {
            DB::statement("ALTER TABLE bitacora_sistema MODIFY COLUMN accion ENUM('create', 'update', 'delete', 'login', 'logout') NOT NULL");
        }
    }
};
