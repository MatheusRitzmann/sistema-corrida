@extends('layouts.usuario')

@section('title', 'Minhas Atividades')

@section('content')

    @if (session('sucesso'))
        <div class="alert alert-success rounded-3 mb-3">{{ session('sucesso') }}</div>
    @endif

    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="vx-card-title mb-0">
            <i class="ri-run-line"></i> Minhas Atividades
        </div>
        <a href="{{ route('usuario.atividades.criar') }}"
           style="background:#2C8CE8;color:#fff;border-radius:8px;font-size:12px;font-weight:600;padding:7px 14px;text-decoration:none;display:inline-flex;align-items:center;gap:5px;">
            <i class="ri-add-line"></i> Nova Atividade
        </a>
    </div>

    @forelse($atividades as $atividade)
        <div class="vx-post mb-3">
            <div class="vx-post-head">
                <div class="vx-post-av" style="background:#2C8CE820;color:#2C8CE8;">
                    <i class="ri-run-line"></i>
                </div>
                <div>
                    <div class="vx-post-name">{{ $atividade->titulo }}</div>
                    <div class="vx-post-time">{{ $atividade->horario_inicio->format('d/m/Y H:i') }}</div>
                </div>
                <span class="vx-post-type">
                    {{ $atividade->categorias->first()->nome ?? 'Sem categoria' }}
                </span>
            </div>

            @if($atividade->descricao)
                <div class="vx-post-desc">{{ $atividade->descricao }}</div>
            @endif

            <div class="vx-post-stats">
                <div class="vx-pstat">
                    <div class="vx-pstat-val">{{ $atividade->distancia ?? '—' }} km</div>
                    <div class="vx-pstat-label">Distância</div>
                </div>
                <div class="vx-pstat">
                    <div class="vx-pstat-val">{{ $atividade->horario_inicio->diffInMinutes($atividade->horario_fim) }} min</div>
                    <div class="vx-pstat-label">Duração</div>
                </div>
                <div class="vx-pstat">
                    <div class="vx-pstat-val">{{ $atividade->pace ?? '—' }}/km</div>
                    <div class="vx-pstat-label">Pace</div>
                </div>
            </div>

            <div class="vx-post-actions">
                <a href="{{ route('usuario.atividades.ver', $atividade->id) }}" class="vx-act-btn">
                    <i class="ri-eye-line"></i> Ver detalhes
                </a>
                <form action="{{ route('usuario.atividades.deletar', $atividade->id) }}" method="POST"
                      onsubmit="return confirm('Tem certeza?')" style="margin-left:auto;">
                    @csrf
                    <button type="submit" class="vx-act-btn" style="color:#e24b4a;">
                        <i class="ri-delete-bin-line"></i> Deletar
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="vx-card text-center text-muted py-4">
            Nenhuma atividade registrada ainda. 
        </div>
    @endforelse

@endsection