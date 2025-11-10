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
                if (!Schema::hasColumn('gastos', 'tipo')) {
                    $table->string('tipo')->nullable()->after('estado');
                }
                if (!Schema::hasColumn('gastos', 'cuenta_origen')) {
                    $table->string('cuenta_origen')->nullable()->after('tipo');
                }
                if (!Schema::hasColumn('gastos', 'cuenta_destino')) {
                    $table->string('cuenta_destino')->nullable()->after('cuenta_origen');
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
                if (Schema::hasColumn('gastos', 'tipo')) {
                    $table->dropColumn('tipo');
                }
                if (Schema::hasColumn('gastos', 'cuenta_origen')) {
                    $table->dropColumn('cuenta_origen');
                }
                if (Schema::hasColumn('gastos', 'cuenta_destino')) {
                    $table->dropColumn('cuenta_destino');
                }
            });
        }
    }
};
