<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscricao extends Model
{
    // Informa o nome correto da tabela
    protected $table = 'subscricoes';

    protected $fillable = ['user_id', 'valor_total'];

    // Usuário dono da subscrição
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Planos relacionados
    public function planos()
    {
        return $this->belongsToMany(Plano::class, 'subscricao_plano')
                    ->withPivot('data_inicio', 'data_fim', 'subtotal')
                    ->withTimestamps();
    }
}