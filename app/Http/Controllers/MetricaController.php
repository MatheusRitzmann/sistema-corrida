<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Metrica;

class MetricaController extends Controller
{
    // Lista todas as métricas
    public function index()
    {
        $metricas = Metrica::orderBy('nome')->get();
        return view('admin.metricas.index', compact('metricas'));
    }

    // Exibe formulário de criação
    public function criar()
    {
        return view('admin.metricas.criar');
    }

    // Processa a criação
    public function salvar(Request $request)
    {
        $request->validate([
            'nome'      => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        Metrica::create([
            'nome'      => $request->nome,
            'descricao' => $request->descricao,
        ]);

        return redirect()->route('admin.metricas')->with('sucesso', 'Métrica criada com sucesso!');
    }

    // Exibe formulário de edição
    public function editar($id)
    {
        $metrica = Metrica::findOrFail($id);
        return view('admin.metricas.editar', compact('metrica'));
    }

    // Processa a edição
    public function atualizar(Request $request, $id)
    {
        $metrica = Metrica::findOrFail($id);

        $request->validate([
            'nome'      => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $metrica->nome      = $request->nome;
        $metrica->descricao = $request->descricao;
        $metrica->save();

        return redirect()->route('admin.metricas')->with('sucesso', 'Métrica atualizada com sucesso!');
    }

    // Deleta métrica
    public function deletar($id)
    {
        Metrica::findOrFail($id)->delete();
        return redirect()->route('admin.metricas')->with('sucesso', 'Métrica deletada com sucesso!');
    }
}