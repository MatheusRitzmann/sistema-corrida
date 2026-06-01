<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscricoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('corrida_id')->constrained('corridas')->onDelete('cascade');
            $table->decimal('valor_pago', 8, 2);
            $table->enum('status', ['pendente', 'confirmado', 'cancelado'])->default('pendente');
            $table->timestamps();

            // Impede inscrição duplicada
            $table->unique(['user_id', 'corrida_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscricoes');
    }
};