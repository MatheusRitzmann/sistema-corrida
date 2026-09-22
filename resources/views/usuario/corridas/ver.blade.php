@extends('layouts.usuario')

@section('title', '{{ $corrida->nome }}')

@section('content')

    @if (session('sucesso'))
        <div class="alert alert-success rounded-3 mb-3">{{ session('sucesso') }}</div>
    @endif
    @if (session('erro'))
        <div class="alert alert-danger rounded-3 mb-3">{{ session('erro') }}</div>
    @endif

    <!-- Capa -->
    @if($corrida->capa)
        <img src="{{ asset('uploads/corridas/' . $corrida->capa) }}"
             style="width:100%;height:250px;object-fit:cover;border-radius:16px;margin-bottom:1rem;">
    @else
        <div style="width:100%;height:250px;background:linear-gradient(135deg,#004aad,#2C8CE8);border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
            <i class="ri-trophy-line" style="font-size:4rem;color:rgba(255,255,255,0.5);"></i>
        </div>
    @endif

    <div class="vx-card mb-3">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px;">
            <div>
                <div style="font-size:22px;font-weight:800;color:#1a1a1a;">{{ $corrida->nome }}</div>
                <div style="font-size:13px;color:#999;margin-top:4px;">{{ $corrida->local }}, {{ $corrida->cidade }}</div>
            </div>
            @if($corrida->temVagas())
                <span style="background:hsla(142,70%,45%,.12);color:hsl(142,70%,40%);font-size:12px;font-weight:600;padding:4px 12px;border-radius:20px;">
                    {{ $corrida->vagasDisponiveis() }} vagas restantes
                </span>
            @else
                <span style="background:hsla(0,80%,55%,.12);color:hsl(0,80%,50%);font-size:12px;font-weight:600;padding:4px 12px;border-radius:20px;">
                    Esgotada
                </span>
            @endif
        </div>

        <!-- Stats -->
        <div class="vx-post-stats mb-3" style="border-radius:12px;overflow:hidden;">
            <div class="vx-pstat">
                <div class="vx-pstat-val">{{ $corrida->distancia }} km</div>
                <div class="vx-pstat-label">Distância</div>
            </div>
            <div class="vx-pstat">
                <div class="vx-pstat-val">{{ $corrida->data_horario->format('d/m') }}</div>
                <div class="vx-pstat-label">Data</div>
            </div>
            <div class="vx-pstat">
                <div class="vx-pstat-val">{{ $corrida->vagas }}</div>
                <div class="vx-pstat-label">Total vagas</div>
            </div>
        </div>

        @if($corrida->descricao)
            <p style="font-size:14px;color:#555;line-height:1.6;margin-bottom:16px;">{{ $corrida->descricao }}</p>
        @endif

        <!-- Valor e inscrição -->
        <div style="display:flex;align-items:center;justify-content:space-between;padding-top:16px;border-top:1px solid #f0f2f8;">
            <div style="font-size:24px;font-weight:800;color:#2C8CE8;">
                R$ {{ number_format($corrida->valor_inscricao, 2, ',', '.') }}
            </div>

            @if($inscrito)
                @if($inscrito->status === 'cancelado')
                    <form action="{{ route('usuario.corridas.inscrever', $corrida->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            style="background:#2C8CE8;color:#fff;border:none;border-radius:8px;padding:10px 20px;font-size:13px;font-weight:600;cursor:pointer;">
                            Inscrever novamente
                        </button>
                    </form>
                @else
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span style="background:hsla(142,70%,45%,.12);color:hsl(142,70%,40%);font-size:12px;font-weight:600;padding:6px 14px;border-radius:20px;">
                            ✓ Inscrito — {{ ucfirst($inscrito->status) }}
                        </span>
                        <form action="{{ route('usuario.corridas.cancelar', $corrida->id) }}" method="POST"
                              onsubmit="return confirm('Tem certeza que deseja cancelar sua inscrição?')">
                            @csrf
                            <button type="submit"
                                style="background:hsla(0,80%,55%,.12);color:hsl(0,80%,50%);border:none;border-radius:8px;padding:8px 14px;font-size:12px;font-weight:600;cursor:pointer;">
                                Cancelar inscrição
                            </button>
                        </form>
                    </div>
                @endif
            @elseif($corrida->temVagas())
                <form action="{{ route('usuario.corridas.inscrever', $corrida->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        style="background:#2C8CE8;color:#fff;border:none;border-radius:8px;padding:10px 20px;font-size:13px;font-weight:600;cursor:pointer;">
                        Inscrever-se — R$ {{ number_format($corrida->valor_inscricao, 2, ',', '.') }}
                    </button>
                </form>
            @else
                <button disabled
                    style="background:#f4f6fb;color:#aaa;border:none;border-radius:8px;padding:10px 20px;font-size:13px;font-weight:600;cursor:not-allowed;">
                    Vagas esgotadas
                </button>
            @endif
        </div>
    </div>

    <a href="{{ route('usuario.corridas') }}" style="font-size:13px;color:#888;text-decoration:none;">
        ← Voltar para corridas
    </a>

@endsection