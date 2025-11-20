<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestPasswordCreation extends Command
{
    protected $signature = 'test:password';
    protected $description = 'Test password creation and validation';

    public function handle()
    {
        // Generar contraseña como en UserController
        $passwordAleatorio = \Illuminate\Support\Str::random(12) . rand(100, 999);
        
        $this->info("=== TEST DE CREACIÓN DE CONTRASEÑA ===");
        $this->info("Contraseña generada: $passwordAleatorio");
        $this->info("Longitud: " . strlen($passwordAleatorio));
        
        // Simular creación de usuario
        $testUser = new User();
        $testUser->name = 'TEST_PASSWORD_USER';
        $testUser->email = 'testpass@example.com';
        $testUser->password = $passwordAleatorio; // Sin Hash::make()
        
        $this->info("\n=== DESPUÉS DE ASIGNAR AL MODELO ===");
        $this->info("Password en modelo: " . substr($testUser->password, 0, 20) . "...");
        $this->info("¿Es un hash bcrypt?: " . (str_starts_with($testUser->password, '$2y$') ? 'SI' : 'NO'));
        
        // Verificar si coincide
        $this->info("\n=== VERIFICACIÓN ===");
        $checkResult = Hash::check($passwordAleatorio, $testUser->password);
        $this->info("Hash::check con password original: " . ($checkResult ? 'SI COINCIDE ✓' : 'NO COINCIDE ✗'));
        
        // Probar con espacios (problema común)
        $passwordConEspacio = $passwordAleatorio . ' ';
        $checkConEspacio = Hash::check($passwordConEspacio, $testUser->password);
        $this->info("Hash::check con espacio al final: " . ($checkConEspacio ? 'SI COINCIDE' : 'NO COINCIDE'));
        
        return 0;
    }
}
