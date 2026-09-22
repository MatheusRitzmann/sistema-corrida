<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'titulo', 'descricao', 'distancia', 'duracao', 'pace'
    ];

    // Relacionamento com usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com curtidas
    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    // Relacionamento com comentários
    public function comments()
    {
        return $this->hasMany(PostComment::class)->with('user')->orderBy('created_at', 'asc');
    }

    // Verifica se o usuário já curtiu
    public function likedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
}