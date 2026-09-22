<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscricao;
use App\Models\Plano;

class SubscricaoController extends Controller
{
    // Exibe planos disponíveis e subscrição atual
    public function index()
    {
        $planos      = Plano::orderBy('valor')->get();
        $subscricao  = Subscricao::with('planos')->where('user_id', Auth::id())->first();
        return view('usuario.subscricao', compact('planos', 'subscricao'));
    }

    // Processa a subscrição
    public function assinar(Request $request)
    {
        $request->validate([
            'plano_id'    => 'required|exists:planos,id',
            'data_inicio' => 'required|date',
            'data_fim'    => 'required|date|after:data_inicio',
        ]);

        $plano = Plano::findOrFail($request->plano_id);

        // Cria ou busca subscrição do usuário
        $subscricao = Subscricao::firstOrCreate(
            ['user_id' => Auth::id()],
            ['valor_total' => 0]
        );

        // Adiciona plano na pivot
        $subscricao->planos()->attach($plano->id, [
            'data_inicio' => $request->data_inicio,
            'data_fim'    => $request->data_fim,
            'subtotal'    => $plano->valor,
        ]);

        // Atualiza valor total
        $subscricao->valor_total += $plano->valor;
        $subscricao->save();

        return redirect()->route('usuario.subscricao')->with('sucesso', 'Plano assinado com sucesso!');
    }
}