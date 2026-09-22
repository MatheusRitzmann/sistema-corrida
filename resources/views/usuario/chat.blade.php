@extends('layouts.usuario')

@section('title', 'Assistente de Treino')

@section('content')

@if (session('sucesso'))
    <div class="alert alert-success rounded-3 mb-3">{{ session('sucesso') }}</div>
@endif

<div style="max-width:700px;margin:0 auto;">

    <!-- Header -->
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
        <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:42px;height:42px;background:linear-gradient(135deg,#004aad,#2C8CE8);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <i class="ri-robot-line" style="color:white;font-size:1.3rem;"></i>
            </div>
            <div>
                <div style="font-size:15px;font-weight:700;color:#1a1a1a;">Assistente Velox</div>
                <div style="font-size:11px;color:#22c78a;font-weight:600;">● Online</div>
            </div>
        </div>
        <form action="{{ route('usuario.chat.limpar') }}" method="POST"
              onsubmit="return confirm('Tem certeza que deseja reiniciar a conversa?')">
            @csrf
            <button type="submit"
                style="background:#f4f6fb;border:1px solid #e8ecf5;border-radius:8px;padding:6px 12px;font-size:12px;font-family:'Inter',sans-serif;color:#888;cursor:pointer;">
                <i class="ri-restart-line"></i> Reiniciar
            </button>
        </form>
    </div>

    <!-- Área do chat -->
    <div id="chatArea" style="background:white;border-radius:16px;border:1px solid #e8ecf5;height:500px;overflow-y:auto;padding:20px;display:flex;flex-direction:column;gap:12px;margin-bottom:12px;">

        <!-- Mensagem de boas-vindas se não tiver histórico -->
        @if($mensagens->isEmpty())
            <div style="display:flex;gap:10px;align-items:flex-start;">
                <div style="width:32px;height:32px;background:linear-gradient(135deg,#004aad,#2C8CE8);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="ri-robot-line" style="color:white;font-size:14px;"></i>
                </div>
                <div style="background:#f4f6fb;border-radius:0 12px 12px 12px;padding:12px 16px;max-width:80%;">
                    <div style="font-size:13px;color:#1a1a1a;line-height:1.6;">
                        Olá, <strong>{{ Auth::user()->name }}</strong>! 👋 Sou o assistente de treino da Velox.<br><br>
                        Posso te ajudar a criar um <strong>plano de treino personalizado</strong> para corridas ou tirar dúvidas sobre treinamento.<br><br>
                        Para começar, me conta:
                        <ul style="margin:8px 0 0 16px;padding:0;">
                            <li>Qual é seu objetivo? (5km, 10km, meia maratona, maratona)</li>
                            <li>Qual é seu nível? (iniciante, intermediário, avançado)</li>
                            <li>Quantos dias por semana pode treinar?</li>
                        </ul>
                    </div>
                    <div style="font-size:10px;color:#bbb;margin-top:6px;">Agora</div>
                </div>
            </div>
        @endif

        <!-- Histórico de mensagens -->
        @foreach($mensagens as $mensagem)
            @if($mensagem->role === 'user')
                <!-- Mensagem do usuário -->
                <div style="display:flex;gap:10px;align-items:flex-start;flex-direction:row-reverse;">
                    <div style="width:32px;height:32px;background:#2C8CE8;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:12px;font-weight:700;color:white;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div style="background:#2C8CE8;border-radius:12px 0 12px 12px;padding:12px 16px;max-width:80%;">
                        <div style="font-size:13px;color:white;line-height:1.6;">{{ $mensagem->conteudo }}</div>
                        <div style="font-size:10px;color:rgba(255,255,255,0.6);margin-top:6px;text-align:right;">
                            {{ $mensagem->created_at->format('H:i') }}
                        </div>
                    </div>
                </div>
            @else
                <!-- Mensagem da IA -->
                <div style="display:flex;gap:10px;align-items:flex-start;">
                    <div style="width:32px;height:32px;background:linear-gradient(135deg,#004aad,#2C8CE8);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="ri-robot-line" style="color:white;font-size:14px;"></i>
                    </div>
                    <div style="background:#f4f6fb;border-radius:0 12px 12px 12px;padding:12px 16px;max-width:80%;">
                        <div style="font-size:13px;color:#1a1a1a;line-height:1.6;">{!! nl2br(e($mensagem->conteudo)) !!}</div>
                        <div style="font-size:10px;color:#bbb;margin-top:6px;">
                            {{ $mensagem->created_at->format('H:i') }}
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        <!-- Indicador de digitando -->
        <div id="typing" style="display:none;gap:10px;align-items:flex-start;">
            <div style="width:32px;height:32px;background:linear-gradient(135deg,#004aad,#2C8CE8);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="ri-robot-line" style="color:white;font-size:14px;"></i>
            </div>
            <div style="background:#f4f6fb;border-radius:0 12px 12px 12px;padding:12px 16px;">
                <div style="display:flex;gap:4px;align-items:center;">
                    <div style="width:6px;height:6px;background:#bbb;border-radius:50%;animation:bounce 1s infinite;"></div>
                    <div style="width:6px;height:6px;background:#bbb;border-radius:50%;animation:bounce 1s infinite 0.2s;"></div>
                    <div style="width:6px;height:6px;background:#bbb;border-radius:50%;animation:bounce 1s infinite 0.4s;"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- Input de mensagem -->
    <div style="display:flex;gap:8px;align-items:center;">
        <input type="text" id="inputMensagem"
               placeholder="Digite sua mensagem..."
               style="flex:1;border:1px solid #e8ecf5;border-radius:12px;padding:12px 16px;font-size:13px;font-family:'Inter',sans-serif;color:#1a1a1a;background:#f7f9fd;outline:none;transition:border .15s;"
               onkeydown="if(event.key==='Enter') enviarMensagem()">
        <button onclick="enviarMensagem()"
            style="width:44px;height:44px;background:#2C8CE8;border:none;border-radius:12px;display:flex;align-items:center;justify-content:center;cursor:pointer;flex-shrink:0;transition:background .15s;">
            <i class="ri-send-plane-fill" style="color:white;font-size:18px;"></i>
        </button>
    </div>

</div>

@endsection

@section('styles')
<style>
@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-4px); }
}
</style>
@endsection

@section('scripts')
<script>
    const chatArea     = document.getElementById('chatArea');
    const inputMsg     = document.getElementById('inputMensagem');
    const typingIndicator = document.getElementById('typing');

    // Scroll para o final
    chatArea.scrollTop = chatArea.scrollHeight;

    function enviarMensagem() {
        const mensagem = inputMsg.value.trim();
        if (!mensagem) return;

        // Adiciona mensagem do usuário na tela
        adicionarMensagem(mensagem, 'user');
        inputMsg.value = '';

        // Mostra indicador de digitando
        typingIndicator.style.display = 'flex';
        chatArea.scrollTop = chatArea.scrollHeight;

        // Envia para o servidor
        fetch('{{ route("usuario.chat.enviar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ mensagem: mensagem }),
        })
        .then(res => res.json())
        .then(data => {
            typingIndicator.style.display = 'none';
            if (data.sucesso) {
                adicionarMensagem(data.resposta, 'assistant');
            } else {
                adicionarMensagem(data.erro, 'erro');
            }
        })
        .catch(() => {
            typingIndicator.style.display = 'none';
            adicionarMensagem('Erro ao conectar. Tente novamente.', 'erro');
        });
    }

    function adicionarMensagem(texto, tipo) {
        const div = document.createElement('div');

        if (tipo === 'user') {
            div.style = 'display:flex;gap:10px;align-items:flex-start;flex-direction:row-reverse;';
            div.innerHTML = `
                <div style="width:32px;height:32px;background:#2C8CE8;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:12px;font-weight:700;color:white;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div style="background:#2C8CE8;border-radius:12px 0 12px 12px;padding:12px 16px;max-width:80%;">
                    <div style="font-size:13px;color:white;line-height:1.6;">${texto}</div>
                    <div style="font-size:10px;color:rgba(255,255,255,0.6);margin-top:6px;text-align:right;">Agora</div>
                </div>`;
        } else if (tipo === 'assistant') {
            div.style = 'display:flex;gap:10px;align-items:flex-start;';
            div.innerHTML = `
                <div style="width:32px;height:32px;background:linear-gradient(135deg,#004aad,#2C8CE8);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="ri-robot-line" style="color:white;font-size:14px;"></i>
                </div>
                <div style="background:#f4f6fb;border-radius:0 12px 12px 12px;padding:12px 16px;max-width:80%;">
                    <div style="font-size:13px;color:#1a1a1a;line-height:1.6;">${texto.replace(/\n/g, '<br>')}</div>
                    <div style="font-size:10px;color:#bbb;margin-top:6px;">Agora</div>
                </div>`;
        } else {
            div.style = 'display:flex;gap:10px;align-items:flex-start;';
            div.innerHTML = `
                <div style="background:hsla(0,80%,55%,.1);border-radius:8px;padding:10px 14px;font-size:13px;color:hsl(0,80%,50%);">
                    ⚠️ ${texto}
                </div>`;
        }

        chatArea.insertBefore(div, typingIndicator);
        chatArea.scrollTop = chatArea.scrollHeight;
    }
</script>
@endsection