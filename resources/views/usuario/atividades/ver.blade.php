@extends('layouts.usuario')

@section('title', 'Detalhes da Atividade')

@section('content')

    <div class="vx-card mb-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="vx-card-title mb-0">
                <i class="ri-run-line"></i> {{ $atividade->titulo }}
            </div>
            <a href="{{ route('usuario.atividades') }}" class="btn btn-outline-secondary btn-sm">Voltar</a>
        </div>

        <!-- Descrição -->
        @if($atividade->descricao)
            <p style="font-size:14px;color:#555;margin-bottom:1rem;">{{ $atividade->descricao }}</p>
        @endif

        <!-- Stats -->
        <div class="vx-post-stats mb-3" style="border-radius:12px;overflow:hidden;">
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

        <!-- Horários -->
        <div class="row g-2 mb-3">
            <div class="col-6">
                <div style="background:#f7f9fd;border-radius:10px;padding:10px 14px;">
                    <div style="font-size:11px;color:#aaa;text-transform:uppercase;letter-spacing:.4px;">Início</div>
                    <div style="font-size:14px;font-weight:600;color:#1a1a1a;">{{ $atividade->horario_inicio->format('d/m/Y H:i') }}</div>
                </div>
            </div>
            <div class="col-6">
                <div style="background:#f7f9fd;border-radius:10px;padding:10px 14px;">
                    <div style="font-size:11px;color:#aaa;text-transform:uppercase;letter-spacing:.4px;">Fim</div>
                    <div style="font-size:14px;font-weight:600;color:#1a1a1a;">{{ $atividade->horario_fim->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>

        <!-- Categorias -->
        @if($atividade->categorias->count())
            <div class="mb-3">
                <div style="font-size:12px;font-weight:600;color:#aaa;text-transform:uppercase;margin-bottom:6px;">Categorias</div>
                <div class="d-flex gap-2 flex-wrap">
                    @foreach($atividade->categorias as $categoria)
                        <span style="background:#2C8CE810;color:#2C8CE8;font-size:12px;font-weight:600;padding:4px 10px;border-radius:20px;">
                            {{ $categoria->nome }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Fotos -->
        @if($atividade->fotos->count())
            <div>
                <div style="font-size:12px;font-weight:600;color:#aaa;text-transform:uppercase;margin-bottom:8px;">Fotos</div>
                <div class="row g-2">
                    @foreach($atividade->fotos as $foto)
                        <div class="col-4">
                            <img src="{{ asset('uploads/atividades/' . $foto->nome_arquivo) }}"
                                 style="width:100%;border-radius:10px;object-fit:cover;height:100px;">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

@endsection