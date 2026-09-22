<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plano;

class PlanoController extends Controller
{
    // Lista todos os planos
    public function index()
    {
        $planos = Plano::orderBy('valor')->get();
        return view('admin.planos.index', compact('planos'));
    }

    // Exibe formulário de criação
    public function criar()
    {
        return view('admin.planos.criar');
    }

    // Processa a criação
    public function salvar(Request $request)
    {
        $request->validate([
            'nome'      => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'valor'     => 'required|numeric|min:0',
        ]);

        Plano::create([
            'nome'      => $request->nome,
            'descricao' => $request->descricao,
            'valor'     => $request->valor,
        ]);

        return redirect()->route('admin.planos')->with('sucesso', 'Plano criado com sucesso!');
    }

    // Exibe formulário de edição
    public function editar($id)
    {
        $plano = Plano::findOrFail($id);
        return view('admin.planos.editar', compact('plano'));
    }

    // Processa a edição
    public function atualizar(Request $request, $id)
    {
        $plano = Plano::findOrFail($id);

        $request->validate([
            'nome'      => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'valor'     => 'required|numeric|min:0',
        ]);

        $plano->nome      = $request->nome;
        $plano->descricao = $request->descricao;
        $plano->valor     = $request->valor;
        $plano->save();

        return redirect()->route('admin.planos')->with('sucesso', 'Plano atualizado com sucesso!');
    }

    // Deleta plano
    public function deletar($id)
    {
        Plano::findOrFail($id)->delete();
        return redirect()->route('admin.planos')->with('sucesso', 'Plano deletado com sucesso!');
    }
}