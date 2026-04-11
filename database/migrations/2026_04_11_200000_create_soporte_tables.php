<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('soporte_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('subject', 200);
            $table->enum('status', ['abierto', 'en_proceso', 'resuelto', 'cerrado'])->default('abierto');
            $table->enum('priority', ['baja', 'media', 'alta', 'urgente'])->default('media');
            $table->timestamp('last_user_message_at')->nullable();
            $table->timestamp('last_admin_message_at')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['status', 'updated_at']);
        });

        Schema::create('soporte_mensajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soporte_ticket_id')->constrained('soporte_tickets')->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->text('message');
            $table->boolean('is_admin')->default(false)->index();
            $table->timestamp('read_at')->nullable()->index();
            $table->timestamps();

            $table->index(['soporte_ticket_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soporte_mensajes');
        Schema::dropIfExists('soporte_tickets');
    }
};
