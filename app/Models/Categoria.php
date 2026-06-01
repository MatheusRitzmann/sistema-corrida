<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['nome', 'categoria_pai'];

    // Categoria pai
    public function pai()
    {
        return $this->belongsTo(Categoria::class, 'categoria_pai');
    }

    // Subcategorias
    public function subcategorias()
    {
        return $this->hasMany(Categoria::class, 'categoria_pai');
    }

    // Atividades relacionadas
    public function atividades()
    {
        return $this->belongsToMany(Atividade::class, 'atividade_categoria');
    }
}