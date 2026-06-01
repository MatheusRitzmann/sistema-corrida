<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atividade extends Model
{
    protected $fillable = [
        'user_id', 'titulo', 'descricao',
        'horario_inicio', 'horario_fim',
        'distancia', 'pace'
    ];

    protected function casts(): array
    {
        return [
            'horario_inicio' => 'datetime',
            'horario_fim'    => 'datetime',
        ];
    }

    // Usuário dono da atividade
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Categorias da atividade
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'atividade_categoria');
    }

    // Fotos da atividade
    public function fotos()
    {
        return $this->hasMany(AtividadeFoto::class);
    }
}