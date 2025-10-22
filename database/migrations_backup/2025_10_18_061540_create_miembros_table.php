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
        if (!Schema::hasTable('miembros')) {
            Schema::create('miembros', function (Blueprint $table) {
                $table->id('MiembroID');
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
                $table->string('DNI_Pasaporte', 20)->nullable();
                $table->string('Nombre', 100);
                $table->string('Rol', 20)->nullable();
                $table->string('Correo', 100)->nullable();
                $table->date('FechaIngreso')->nullable();
                $table->text('Apuntes')->nullable();
                
                $table->index('user_id');
                $table->index('DNI_Pasaporte');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('miembros');
    }
};
