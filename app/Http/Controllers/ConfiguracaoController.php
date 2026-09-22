<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracao;

class ConfiguracaoController extends Controller
{
    // Exibe tela de configuração
    public function index()
    {
        $cacapayUrl   = Configuracao::get('cacapay_url') ?? '';
        $cacapayToken = Configuracao::get('cacapay_token') ?? '';

        return view('master.configuracao', compact('cacapayUrl', 'cacapayToken'));
    }

    // Salva as configurações
    public function salvar(Request $request)
    {
        $request->validate([
            'cacapay_url'   => 'required|url',
            'cacapay_token' => 'required|string',
        ]);

        Configuracao::set('cacapay_url', $request->cacapay_url);
        Configuracao::set('cacapay_token', $request->cacapay_token);

        return redirect()->route('master.configuracao')->with('sucesso', 'Configurações salvas com sucesso!');
    }
}