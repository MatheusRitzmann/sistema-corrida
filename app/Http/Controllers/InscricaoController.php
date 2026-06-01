<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Corrida;
use App\Models\Inscricao;

class InscricaoController extends Controller
{
    // Processa a inscrição
    public function inscrever(Request $request, $corridaId)
    {
        $corrida = Corrida::findOrFail($corridaId);

        // Verifica se tem vagas
        if (!$corrida->temVagas()) {
            return redirect()->route('usuario.corridas.ver', $corridaId)
                             ->with('erro', 'Não há vagas disponíveis para esta corrida!');
        }

        // Verifica se já está inscrito
        $jaInscrito = Inscricao::where('user_id', Auth::id())
                                ->where('corrida_id', $corridaId)
                                ->exists();

        if ($jaInscrito) {
            return redirect()->route('usuario.corridas.ver', $corridaId)
                             ->with('erro', 'Você já está inscrito nesta corrida!');
        }

        Inscricao::create([
            'user_id'    => Auth::id(),
            'corrida_id' => $corridaId,
            'valor_pago' => $corrida->valor_inscricao,
            'status'     => 'pendente',
        ]);

        return redirect()->route('usuario.corridas.ver', $corridaId)
                         ->with('sucesso', 'Inscrição realizada com sucesso!');
    }

    // Cancela inscrição
    public function cancelar($corridaId)
    {
        $inscricao = Inscricao::where('user_id', Auth::id())
                               ->where('corrida_id', $corridaId)
                               ->firstOrFail();

        $inscricao->status = 'cancelado';
        $inscricao->save();

        return redirect()->route('usuario.corridas.ver', $corridaId)
                         ->with('sucesso', 'Inscrição cancelada com sucesso!');
    }

    // Lista inscrições do usuário
    public function minhasInscricoes()
    {
        $inscricoes = Inscricao::with('corrida')
                        ->where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('usuario.corridas.inscricoes', compact('inscricoes'));
    }
}