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
        if (Schema::hasTable('gastos')) {
            Schema::table('gastos', function (Blueprint $table) {
                if (!Schema::hasColumn('gastos', 'comision')) {
                    $table->decimal('comision', 10, 2)->nullable()->after('monto')->comment('Comisión bancaria o cobrada por la transferencia');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('gastos')) {
            Schema::table('gastos', function (Blueprint $table) {
                if (Schema::hasColumn('gastos', 'comision')) {
                    $table->dropColumn('comision');
                }
            });
        }
    }
};
