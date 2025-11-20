<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class FixUserFirstLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:first-login {email}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Marca a un usuario como que completó su perfil (resuelve bucle de primer login)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("❌ Usuario con email '$email' no encontrado");
            return Command::FAILURE;
        }

        // Marcar perfil como completado
        $user->markProfileAsCompleted();

        $this->info("✅ Usuario '{$user->name}' ({$user->email}) marcado como perfil completado");
        $this->info("   - first_login: {$user->first_login}");
        $this->info("   - profile_completed_at: {$user->profile_completed_at}");

        return Command::SUCCESS;
    }
}
