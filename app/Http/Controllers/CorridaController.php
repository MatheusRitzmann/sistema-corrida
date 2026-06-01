<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Corrida;
use App\Models\Inscricao;
use Illuminate\Support\Facades\Auth;

class CorridaController extends Controller
{
    // Lista corridas para o usuário
    public function index()
    {
        $corridas = Corrida::withCount('inscricoes')
                        ->orderBy('data_horario')
                        ->get();

        return view('usuario.corridas.index', compact('corridas'));
    }

    // Detalhes da corrida
    public function ver($id)
    {
        $corrida    = Corrida::withCount('inscricoes')->findOrFail($id);
        $inscrito   = Inscricao::where('user_id', Auth::id())
                        ->where('corrida_id', $id)
                        ->first();

        return view('usuario.corridas.ver', compact('corrida', 'inscrito'));
    }

    // Lista corridas para o master
    public function indexMaster()
    {
        $corridas = Corrida::withCount('inscricoes')->orderBy('data_horario')->get();
        return view('master.corridas.index', compact('corridas'));
    }

    // Exibe formulário de criação
    public function criar()
    {
        return view('master.corridas.criar');
    }

    // Processa a criação
    public function salvar(Request $request)
    {
        $request->validate([
            'nome'            => 'required|string|max:255',
            'descricao'       => 'nullable|string',
            'data_horario'    => 'required|date',
            'local'           => 'required|string',
            'cidade'          => 'required|string',
            'distancia'       => 'required|numeric',
            'vagas'           => 'required|integer|min:1',
            'valor_inscricao' => 'required|numeric|min:0',
            'capa'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $nomeCapa = null;

        // Upload da capa
        if ($request->hasFile('capa')) {
            $nomeCapa = time() . '.' . $request->capa->getClientOriginalExtension();
            $request->capa->move(public_path('uploads/corridas'), $nomeCapa);
        }

        Corrida::create([
            'nome'            => $request->nome,
            'descricao'       => $request->descricao,
            'data_horario'    => $request->data_horario,
            'local'           => $request->local,
            'cidade'          => $request->cidade,
            'distancia'       => $request->distancia,
            'vagas'           => $request->vagas,
            'valor_inscricao' => $request->valor_inscricao,
            'capa'            => $nomeCapa,
        ]);

        return redirect()->route('master.corridas')->with('sucesso', 'Corrida criada com sucesso!');
    }

    // Exibe formulário de edição
    public function editar($id)
    {
        $corrida = Corrida::findOrFail($id);
        return view('master.corridas.editar', compact('corrida'));
    }

    // Processa a edição
    public function atualizar(Request $request, $id)
    {
        $corrida = Corrida::findOrFail($id);

        $request->validate([
            'nome'            => 'required|string|max:255',
            'descricao'       => 'nullable|string',
            'data_horario'    => 'required|date',
            'local'           => 'required|string',
            'cidade'          => 'required|string',
            'distancia'       => 'required|numeric',
            'vagas'           => 'required|integer|min:1',
            'valor_inscricao' => 'required|numeric|min:0',
            'capa'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload da nova capa
        if ($request->hasFile('capa')) {
            // Remove capa antiga
            if ($corrida->capa) {
                $path = public_path('uploads/corridas/' . $corrida->capa);
                if (file_exists($path)) unlink($path);
            }

            $nomeCapa = time() . '.' . $request->capa->getClientOriginalExtension();
            $request->capa->move(public_path('uploads/corridas'), $nomeCapa);
            $corrida->capa = $nomeCapa;
        }

        $corrida->nome            = $request->nome;
        $corrida->descricao       = $request->descricao;
        $corrida->data_horario    = $request->data_horario;
        $corrida->local           = $request->local;
        $corrida->cidade          = $request->cidade;
        $corrida->distancia       = $request->distancia;
        $corrida->vagas           = $request->vagas;
        $corrida->valor_inscricao = $request->valor_inscricao;
        $corrida->save();

        return redirect()->route('master.corridas')->with('sucesso', 'Corrida atualizada com sucesso!');
    }

    // Deleta corrida
    public function deletar($id)
    {
        $corrida = Corrida::findOrFail($id);

        // Remove capa
        if ($corrida->capa) {
            $path = public_path('uploads/corridas/' . $corrida->capa);
            if (file_exists($path)) unlink($path);
        }

        $corrida->delete();

        return redirect()->route('master.corridas')->with('sucesso', 'Corrida deletada com sucesso!');
    }

    // Lista inscritos na corrida
    public function inscritos($id)
    {
        $corrida   = Corrida::findOrFail($id);
        $inscritos = Inscricao::with('user')->where('corrida_id', $id)->get();
        return view('master.corridas.inscritos', compact('corrida', 'inscritos'));
    }
}