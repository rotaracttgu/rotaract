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
        DB::statement("CREATE VIEW `vw_resumen_proyecto` AS select `p`.`ProyectoID` AS `ProyectoID`,`p`.`Nombre` AS `Nombre`,sum(case when `m`.`TipoMovimiento` = 'Ingreso' then `am`.`MontoAsignado` else 0 end) AS `TotalIngresos`,sum(case when `m`.`TipoMovimiento` = 'Egreso' then `am`.`MontoAsignado` else 0 end) AS `TotalEgresos`,sum(case when `m`.`TipoMovimiento` = 'Ingreso' then `am`.`MontoAsignado` when `m`.`TipoMovimiento` = 'Egreso' then -`am`.`MontoAsignado` end) AS `Saldo` from ((`gestiones_clubrotario`.`proyectos` `p` left join `gestiones_clubrotario`.`asignacionesmovimiento` `am` on(`am`.`ProyectoID` = `p`.`ProyectoID`)) left join `gestiones_clubrotario`.`movimientos` `m` on(`m`.`MovimientoID` = `am`.`MovimientoID`)) group by `p`.`ProyectoID`,`p`.`Nombre`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `vw_resumen_proyecto`");
    }
};
