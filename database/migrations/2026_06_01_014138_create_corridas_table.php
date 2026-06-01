<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corridas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->dateTime('data_horario');
            $table->string('local');
            $table->string('cidade');
            $table->decimal('distancia', 5, 2);
            $table->integer('vagas');
            $table->decimal('valor_inscricao', 8, 2);
            $table->string('capa')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corridas');
    }
};