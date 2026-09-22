<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Corrida;
use App\Models\Inscricao;
use App\Models\Configuracao;

class InscricaoController extends Controller
{
    // Processa a inscrição com Caçapay
    public function inscrever(Request $request, $corridaId)
    {
        $corrida = Corrida::findOrFail($corridaId);
        $usuario = Auth::user();

        // Verifica se tem vagas
        if (!$corrida->temVagas()) {
            return redirect()->route('usuario.corridas.ver', $corridaId)
                             ->with('erro', 'Não há vagas disponíveis para esta corrida!');
        }

        // Verifica se já está inscrito
        $jaInscrito = Inscricao::where('user_id', $usuario->id)
                                ->where('corrida_id', $corridaId)
                                ->whereIn('status', ['pendente', 'confirmado'])
                                ->exists();

        if ($jaInscrito) {
            return redirect()->route('usuario.corridas.ver', $corridaId)
                             ->with('erro', 'Você já está inscrito nesta corrida!');
        }

        // Busca configurações do Caçapay
        $cacapayUrl   = Configuracao::get('cacapay_url');
        $cacapayToken = Configuracao::get('cacapay_token');

        if (!$cacapayUrl || !$cacapayToken) {
            return redirect()->route('usuario.corridas.ver', $corridaId)
                             ->with('erro', 'Sistema de pagamento não configurado. Contate o administrador.');
        }

        // Chama a API do Caçapay
        try {
            $response = Http::post($cacapayUrl, [
                'cpf'   => $usuario->cpf,
                'token' => $cacapayToken,
                'valor' => $corrida->valor_inscricao,
                'nome'  => $usuario->name,
                'email' => $usuario->email,
            ]);

            $dados = $response->json();

            // Pagamento negado
            if ($response->status() === 422) {
                return redirect()->route('usuario.corridas.ver', $corridaId)
                                 ->with('erro', 'Pagamento negado: ' . ($dados['message'] ?? 'Saldo insuficiente.'));
            }

            // Pagamento aprovado
            if ($response->successful()) {
                Inscricao::create([
                    'user_id'    => $usuario->id,
                    'corrida_id' => $corridaId,
                    'valor_pago' => $corrida->valor_inscricao,
                    'status'     => 'confirmado',
                ]);

                return redirect()->route('usuario.corridas.ver', $corridaId)
                                 ->with('sucesso', 'Inscrição realizada e pagamento confirmado!');
            }

            return redirect()->route('usuario.corridas.ver', $corridaId)
                             ->with('erro', 'Erro ao processar pagamento. Tente novamente.');

        } catch (\Exception $e) {
            return redirect()->route('usuario.corridas.ver', $corridaId)
                             ->with('erro', 'Não foi possível conectar ao sistema de pagamento.');
        }
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