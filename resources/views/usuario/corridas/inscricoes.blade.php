@extends('layouts.usuario')

@section('title', 'Minhas Inscrições')

@section('content')

    @if (session('sucesso'))
        <div class="alert alert-success rounded-3 mb-3">{{ session('sucesso') }}</div>
    @endif

    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="vx-card-title mb-0">
            <i class="ri-ticket-line"></i> Minhas Inscrições
        </div>
        <a href="{{ route('usuario.corridas') }}"
           style="background:#f4f6fb;border:1px solid #e8ecf5;border-radius:8px;font-size:12px;font-weight:600;padding:7px 14px;text-decoration:none;color:#888;">
            ← Voltar
        </a>
    </div>

    @forelse($inscricoes as $inscricao)
        <div class="vx-card mb-3">
            <div style="display:flex;align-items:center;gap:12px;">
                @if($inscricao->corrida->capa)
                    <img src="{{ asset('uploads/corridas/' . $inscricao->corrida->capa) }}"
                         style="width:60px;height:60px;object-fit:cover;border-radius:10px;flex-shrink:0;">
                @else
                    <div style="width:60px;height:60px;background:linear-gradient(135deg,#004aad,#2C8CE8);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="ri-trophy-line" style="color:rgba(255,255,255,0.7);font-size:1.5rem;"></i>
                    </div>
                @endif

                <div style="flex:1;">
                    <div style="font-size:15px;font-weight:700;color:#1a1a1a;">{{ $inscricao->corrida->nome }}</div>
                    <div style="font-size:12px;color:#999;margin-top:2px;">
                        {{ $inscricao->corrida->data_horario->format('d/m/Y H:i') }} — {{ $inscricao->corrida->cidade }}
                    </div>
                </div>

                <div style="text-align:right;">
                    <div style="font-size:15px;font-weight:800;color:#2C8CE8;">
                        R$ {{ number_format($inscricao->valor_pago, 2, ',', '.') }}
                    </div>
                    @if($inscricao->status === 'confirmado')
                        <span style="background:hsla(142,70%,45%,.12);color:hsl(142,70%,40%);font-size:11px;font-weight:600;padding:2px 8px;border-radius:20px;">
                            Confirmado
                        </span>
                    @elseif($inscricao->status === 'pendente')
                        <span style="background:hsla(30,90%,55%,.12);color:hsl(30,90%,50%);font-size:11px;font-weight:600;padding:2px 8px;border-radius:20px;">
                            Pendente
                        </span>
                    @else
                        <span style="background:hsla(0,80%,55%,.12);color:hsl(0,80%,50%);font-size:11px;font-weight:600;padding:2px 8px;border-radius:20px;">
                            Cancelado
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="vx-card text-center text-muted py-4">
            Você ainda não se inscreveu em nenhuma corrida. 
        </div>
    @endforelse

@endsection