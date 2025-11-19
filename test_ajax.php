<?php
// Script simple para testear la respuesta AJAX

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap/app.php';

// Simular una petición AJAX
$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/admin/configuracion/roles/ajax';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

$request = \Illuminate\Http\Request::createFromGlobals();
$request->headers->set('X-Requested-With', 'XMLHttpRequest');

echo "Testing AJAX request...\n";
echo "Is AJAX? " . ($request->ajax() ? "YES" : "NO") . "\n";
echo "Wants JSON? " . ($request->wantsJson() ? "YES" : "NO") . "\n";

// Intentar cargar el controlador
try {
    $controller = new \App\Http\Controllers\Admin\Configuracion\RoleController();
    echo "Controller loaded successfully\n";
    
    // Verificar si el método existe
    if (method_exists($controller, 'ajaxIndex')) {
        echo "Method ajaxIndex exists\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
