<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use PDO;
use PDOException;

class CreateDatabase extends Command
{
    protected $signature = 'db:create';
    protected $description = 'Create the database if it does not exist, using .env credentials';

    public function handle()
    {
        // Get database info from .env
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbPort = env('DB_PORT', 3306);

        try {
            // Connect to MySQL without selecting a database
            $pdo = new PDO("mysql:host=$dbHost;port=$dbPort", $dbUser, $dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Create database if not exists
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

            $this->info("Database '$dbName' created or already exists.");
        } catch (PDOException $e) {
            $this->error("Database creation failed: " . $e->getMessage());
        }
    }
}
