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
        DB::statement("CREATE VIEW `vw_saldo_proyecto_asignado` AS select `p`.`ProyectoID` AS `ProyectoID`,`p`.`Nombre` AS `Nombre`,coalesce(sum(case when `m`.`TipoMovimiento` = 'Ingreso' then `am`.`MontoAsignado` when `m`.`TipoMovimiento` = 'Egreso' then -`am`.`MontoAsignado` else 0 end),0) AS `SaldoAsignado` from ((`gestiones_clubrotario`.`proyectos` `p` left join `gestiones_clubrotario`.`asignacionesmovimiento` `am` on(`am`.`ProyectoID` = `p`.`ProyectoID`)) left join `gestiones_clubrotario`.`movimientos` `m` on(`m`.`MovimientoID` = `am`.`MovimientoID`)) group by `p`.`ProyectoID`,`p`.`Nombre`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `vw_saldo_proyecto_asignado`");
    }
};
