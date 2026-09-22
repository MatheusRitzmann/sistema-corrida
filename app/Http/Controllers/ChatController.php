<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\ChatMensagem;

class ChatController extends Controller
{
    // Exibe a página do chat
    public function index()
    {
        $mensagens = ChatMensagem::where('user_id', Auth::id())
                        ->orderBy('created_at', 'asc')
                        ->get();

        return view('usuario.chat', compact('mensagens'));
    }

    // Processa a mensagem do usuário
    public function enviar(Request $request)
    {
        $request->validate([
            'mensagem' => 'required|string|max:1000',
        ]);

        $usuario = Auth::user();

        // Salva mensagem do usuário
        ChatMensagem::create([
            'user_id'  => $usuario->id,
            'role'     => 'user',
            'conteudo' => $request->mensagem,
        ]);

        // Busca histórico da conversa
        $historico = ChatMensagem::where('user_id', $usuario->id)
                        ->orderBy('created_at', 'asc')
                        ->get()
                        ->map(fn($m) => [
                            'role'    => $m->role,
                            'content' => $m->conteudo,
                        ])
                        ->toArray();

        // Mensagem do sistema — contexto do assistente
        $sistema = "Você é um assistente especialista em corrida e treinamento esportivo do sistema Velox. 
                    Ajude o usuário a criar e ajustar planos de treino personalizados para corridas. 
                    O usuário se chama {$usuario->name}.
                    Seja amigável, objetivo e use linguagem simples.
                    Quando gerar um plano de treino, organize por semanas e dias.
                    Responda sempre em português brasileiro.";

        // API do Groq
        try {
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                    'Content-Type'  => 'application/json',
                ])->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model'       => env('GROQ_MODEL', 'llama3-8b-8192'),
                    'messages'    => array_merge(
                        [['role' => 'system', 'content' => $sistema]],
                        $historico
                    ),
                    'max_tokens'  => 1024,
                    'temperature' => 0.7,
                ]);

            $dados    = $response->json();
            $resposta = $dados['choices'][0]['message']['content'] ?? json_encode($dados);

            // Salva resposta da IA
            ChatMensagem::create([
                'user_id'  => $usuario->id,
                'role'     => 'assistant',
                'conteudo' => $resposta,
            ]);

            return response()->json([
                'sucesso'  => true,
                'resposta' => $resposta,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'sucesso' => false,
                'erro'    => 'Erro: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Limpa o histórico do chat
    public function limpar()
    {
        ChatMensagem::where('user_id', Auth::id())->delete();

        return redirect()->route('usuario.chat')->with('sucesso', 'Conversa reiniciada!');
    }
}