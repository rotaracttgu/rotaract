<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 LÓGICA: ¿CÓMO SE CREAN PROYECTOS EN SERVIDOR?\n";
echo "================================================\n\n";

// 1. Ver tabla calendarios y proyectos
echo "1️⃣ TABLA CALENDARIOS:\n";
$calendarios = DB::select("SELECT * FROM calendarios");
echo "   Total eventos: " . count($calendarios) . "\n";
foreach ($calendarios as $c) {
    echo "   - ID {$c->CalendarioID}: {$c->TituloEvento} | ProyectoID: {$c->ProyectoID}\n";
}

// 2. Ver tabla proyectos
echo "\n2️⃣ TABLA PROYECTOS:\n";
$proyectos = DB::select("SELECT * FROM proyectos");
echo "   Total proyectos: " . count($proyectos) . "\n";
foreach ($proyectos as $p) {
    echo "   - ID {$p->ProyectoID}: {$p->Nombre} | FechaInicio: {$p->FechaInicio}\n";
}

// 3. Ver si hay Observer o evento que cree calendarios
echo "\n3️⃣ BUSCANDO LÓGICA DE CREACIÓN:\n";
echo "   ¿Hay relación Proyecto -> Calendario?\n";

// Revisar si Proyecto model tiene relación
echo "\n4️⃣ ESTRUCTURA DE PROYECTO MODEL:\n";
$proyectoModel = new \App\Models\Proyecto();
echo "   Table: " . $proyectoModel->getTable() . "\n";
echo "   Relations: ";
$reflection = new ReflectionClass($proyectoModel);
$methods = $reflection->getMethods();
$relations = array_filter($methods, fn($m) => 
    strpos($m->getName(), 'calendario') !== false ||
    strpos($m->getName(), 'evento') !== false
);
foreach ($relations as $r) {
    echo $r->getName() . " ";
}
echo "\n   (Si no hay, significa que no hay relación automática)\n";

echo "\n";
