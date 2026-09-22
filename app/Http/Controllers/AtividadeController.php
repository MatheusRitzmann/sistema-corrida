<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Atividade;
use App\Models\AtividadeFoto;
use App\Models\Categoria;

class AtividadeController extends Controller
{
    // Lista todas as atividades do usuário
    public function index()
    {
        $atividades = Atividade::with(['categorias', 'fotos'])
                        ->where('user_id', Auth::id())
                        ->orderBy('horario_inicio', 'desc')
                        ->get();

        return view('usuario.atividades.index', compact('atividades'));
    }

    // Exibe formulário de criação
    public function criar()
    {
        $categorias = Categoria::whereNull('categoria_pai')->with('subcategorias')->get();
        return view('usuario.atividades.criar', compact('categorias'));
    }

    // Processa a criação
    public function salvar(Request $request)
    {
        $request->validate([
            'titulo'         => 'required|string|max:255',
            'descricao'      => 'nullable|string',
            'horario_inicio' => 'required|date',
            'horario_fim'    => 'required|date|after:horario_inicio',
            'distancia'      => 'nullable|numeric',
            'pace'           => 'nullable|string',
            'categorias'     => 'nullable|array',
            'fotos'          => 'nullable|array|max:5',
            'fotos.*'        => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Cria a atividade
        $atividade = Atividade::create([
            'user_id'        => Auth::id(),
            'titulo'         => $request->titulo,
            'descricao'      => $request->descricao,
            'horario_inicio' => $request->horario_inicio,
            'horario_fim'    => $request->horario_fim,
            'distancia'      => $request->distancia,
            'pace'           => $request->pace,
        ]);

        // Vincula categorias
        if ($request->categorias) {
            $atividade->categorias()->attach($request->categorias);
        }

        // Upload de fotos — máximo 5
        if ($request->hasFile('fotos')) {
            $fotos = $request->file('fotos');
            $limite = min(count($fotos), 5);

            for ($i = 0; $i < $limite; $i++) {
                $nomeArquivo = time() . '_' . $i . '.' . $fotos[$i]->getClientOriginalExtension();
                $fotos[$i]->move(public_path('uploads/atividades'), $nomeArquivo);

                AtividadeFoto::create([
                    'atividade_id' => $atividade->id,
                    'nome_arquivo' => $nomeArquivo,
                ]);
            }
        }

        return redirect()->route('usuario.atividades')->with('sucesso', 'Atividade registrada com sucesso!');
    }

    // Exibe detalhes da atividade
    public function ver($id)
    {
        $atividade = Atividade::with(['categorias', 'fotos', 'user'])
                        ->where('user_id', Auth::id())
                        ->findOrFail($id);

        return view('usuario.atividades.ver', compact('atividade'));
    }

    // Deleta atividade
    public function deletar($id)
    {
        $atividade = Atividade::where('user_id', Auth::id())->findOrFail($id);

        // Remove fotos do servidor
        foreach ($atividade->fotos as $foto) {
            $path = public_path('uploads/atividades/' . $foto->nome_arquivo);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $atividade->delete();

        return redirect()->route('usuario.atividades')->with('sucesso', 'Atividade deletada com sucesso!');
    }
}