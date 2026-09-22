<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    // Informa o nome correto da tabela
    protected $table = 'inscricoes';

    protected $fillable = ['user_id', 'corrida_id', 'valor_pago', 'status'];

    // Usuário inscrito
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Corrida relacionada
    public function corrida()
    {
        return $this->belongsTo(Corrida::class);
    }
}