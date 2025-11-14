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
        // Verificar si la tabla existe antes de modificarla
        if (Schema::hasTable('finanzas')) {
            Schema::table('finanzas', function (Blueprint $table) {
                if (!Schema::hasColumn('finanzas', 'deleted_at')) {
                    $table->softDeletes()->after('updated_at');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('finanzas')) {
            Schema::table('finanzas', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};
