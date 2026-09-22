<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMensagem extends Model
{
    protected $table = 'chat_mensagens';

    protected $fillable = ['user_id', 'role', 'conteudo'];

    // Usuário dono da mensagem
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}