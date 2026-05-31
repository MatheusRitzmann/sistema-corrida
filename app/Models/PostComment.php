<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    protected $fillable = ['post_id', 'user_id', 'comentario'];

    // Relacionamento com post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Relacionamento com usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}