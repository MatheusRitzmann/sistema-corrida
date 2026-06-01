<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    protected $fillable = ['nome', 'descricao', 'valor'];

    // Subscrições relacionadas
    public function subscricoes()
    {
        return $this->belongsToMany(Subscricao::class, 'subscricao_plano')
                    ->withPivot('data_inicio', 'data_fim', 'subtotal')
                    ->withTimestamps();
    }
}