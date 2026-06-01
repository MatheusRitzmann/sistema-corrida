<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtividadeFoto extends Model
{
    protected $fillable = ['atividade_id', 'nome_arquivo'];

    // Atividade relacionada
    public function atividade()
    {
        return $this->belongsTo(Atividade::class);
    }
}