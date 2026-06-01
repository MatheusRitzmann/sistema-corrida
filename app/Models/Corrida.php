<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Corrida extends Model
{
    protected $fillable = [
        'nome', 'descricao', 'data_horario', 'local',
        'cidade', 'distancia', 'vagas', 'valor_inscricao', 'capa'
    ];

    protected function casts(): array
    {
        return [
            'data_horario' => 'datetime',
        ];
    }

    // Inscrições da corrida
    public function inscricoes()
    {
        return $this->hasMany(Inscricao::class);
    }

    // Vagas disponíveis
    public function vagasDisponiveis()
    {
        return $this->vagas - $this->inscricoes()->whereIn('status', ['pendente', 'confirmado'])->count();
    }

    // Verifica se tem vagas
    public function temVagas()
    {
        return $this->vagasDisponiveis() > 0;
    }
}