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
        DB::statement("CREATE VIEW `vw_movimientos_extracto` AS select `m`.`MovimientoID` AS `MovimientoID`,`m`.`FechaMovimiento` AS `FechaMovimiento`,`m`.`Descripcion` AS `Descripcion`,`m`.`TipoMovimiento` AS `TipoMovimiento`,`m`.`Monto` AS `Monto`,`m`.`TipoEntrada` AS `TipoEntrada`,`m`.`CategoriaEgreso` AS `CategoriaEgreso`,`m`.`MiembroID` AS `MiembroID`,`m`.`ProyectoID` AS `ProyectoID`,`m`.`PagoID` AS `PagoID` from `gestiones_clubrotario`.`movimientos` `m` order by `m`.`FechaMovimiento`,`m`.`MovimientoID`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `vw_movimientos_extracto`");
    }
};
