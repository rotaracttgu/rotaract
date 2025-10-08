<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class EnableTwoFactor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:enable-2fa {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Habilitar autenticación de dos factores para un usuario';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error('Usuario no encontrado con el email: ' . $email);
            return 1;
        }
        
        $user->two_factor_enabled = true;
        $user->save();
        
        $this->info('✅ 2FA habilitado correctamente para: ' . $user->name);
        $this->info('📧 Email: ' . $user->email);
        
        return 0;
    }
}