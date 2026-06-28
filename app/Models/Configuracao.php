<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    protected $table = 'configuracoes';

    protected $fillable = ['chave', 'valor', 'descricao'];

    // Busca um valor pela chave
    public static function get(string $chave): ?string
    {
        $config = static::where('chave', $chave)->first();
        return $config?->valor;
    }

    // Salva ou atualiza um valor
    public static function set(string $chave, string $valor): void
    {
        static::updateOrCreate(
            ['chave' => $chave],
            ['valor' => $valor]
        );
    }
}