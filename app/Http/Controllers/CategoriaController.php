<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    // Lista todas as categorias
    public function index()
    {
        $categorias = Categoria::whereNull('categoria_pai')->with('subcategorias')->get();
        return view('admin.categorias.index', compact('categorias'));
    }

    // Exibe formulário de criação
    public function criar()
    {
        $categorias = Categoria::whereNull('categoria_pai')->get();
        return view('admin.categorias.criar', compact('categorias'));
    }

    // Processa a criação
    public function salvar(Request $request)
    {
        $request->validate([
            'nome'          => 'required|string|max:255',
            'categoria_pai' => 'nullable|exists:categorias,id',
        ]);

        Categoria::create([
            'nome'          => $request->nome,
            'categoria_pai' => $request->categoria_pai,
        ]);

        return redirect()->route('admin.categorias')->with('sucesso', 'Categoria criada com sucesso!');
    }

    // Exibe formulário de edição
    public function editar($id)
    {
        $categoria  = Categoria::findOrFail($id);
        $categorias = Categoria::whereNull('categoria_pai')->where('id', '!=', $id)->get();
        return view('admin.categorias.editar', compact('categoria', 'categorias'));
    }

    // Processa a edição
    public function atualizar(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);

        $request->validate([
            'nome'          => 'required|string|max:255',
            'categoria_pai' => 'nullable|exists:categorias,id',
        ]);

        $categoria->nome          = $request->nome;
        $categoria->categoria_pai = $request->categoria_pai;
        $categoria->save();

        return redirect()->route('admin.categorias')->with('sucesso', 'Categoria atualizada com sucesso!');
    }

    // Deleta categoria
    public function deletar($id)
    {
        Categoria::findOrFail($id)->delete();
        return redirect()->route('admin.categorias')->with('sucesso', 'Categoria deletada com sucesso!');
    }
}