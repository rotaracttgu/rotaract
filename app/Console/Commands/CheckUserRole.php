<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CheckUserRole extends Command
{
    protected $signature = 'check:user-role {email}';
    protected $description = 'Ver los roles de un usuario';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("❌ Usuario con email '$email' no encontrado");
            return Command::FAILURE;
        }

        $this->info("👤 Usuario: {$user->name} {$user->apellidos}");
        $this->info("📧 Email: {$user->email}");
        $this->info("🔑 ID: {$user->id}");
        $this->info("📅 First Login: " . ($user->first_login ? 'SÍ' : 'NO'));
        $this->info("📅 Profile Completed: {$user->profile_completed_at}");
        
        $roles = $user->roles()->pluck('name');
        
        if ($roles->isEmpty()) {
            $this->warn("⚠️  El usuario NO tiene roles asignados");
        } else {
            $this->info("\n🎭 Roles asignados:");
            foreach ($roles as $role) {
                $this->line("   - {$role}");
            }
        }

        return Command::SUCCESS;
    }
}
