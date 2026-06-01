@extends('layouts.usuario')

@section('title', 'Corridas')

@section('content')

    @if (session('sucesso'))
        <div class="alert alert-success rounded-3 mb-3">{{ session('sucesso') }}</div>
    @endif
    @if (session('erro'))
        <div class="alert alert-danger rounded-3 mb-3">{{ session('erro') }}</div>
    @endif

    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="vx-card-title mb-0">
            <i class="ri-trophy-line"></i> Corridas Disponíveis
        </div>
        <a href="{{ route('usuario.inscricoes') }}"
           style="background:#f4f6fb;border:1px solid #e8ecf5;border-radius:8px;font-size:12px;font-weight:600;padding:7px 14px;text-decoration:none;color:#888;display:inline-flex;align-items:center;gap:5px;">
            <i class="ri-ticket-line"></i> Minhas Inscrições
        </a>
    </div>

    <div class="row g-3">
        @forelse($corridas as $corrida)
            <div class="col-12 col-md-6">
                <div class="vx-card h-100" style="padding:0;overflow:hidden;">
                    <!-- Capa -->
                    @if($corrida->capa)
                        <img src="{{ asset('uploads/corridas/' . $corrida->capa) }}"
                             style="width:100%;height:160px;object-fit:cover;">
                    @else
                        <div style="width:100%;height:160px;background:linear-gradient(135deg,#004aad,#2C8CE8);display:flex;align-items:center;justify-content:center;">
                            <i class="ri-trophy-line" style="font-size:3rem;color:rgba(255,255,255,0.5);"></i>
                        </div>
                    @endif

                    <div style="padding:16px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                            <div style="font-size:16px;font-weight:700;color:#1a1a1a;">{{ $corrida->nome }}</div>
                            @if($corrida->temVagas())
                                <span style="background:hsla(142,70%,45%,.12);color:hsl(142,70%,40%);font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;">
                                    Vagas disponíveis
                                </span>
                            @else
                                <span style="background:hsla(0,80%,55%,.12);color:hsl(0,80%,50%);font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;">
                                    Esgotada
                                </span>
                            @endif
                        </div>

                        <div class="d-flex gap-3 mb-3">
                            <span style="font-size:12px;color:#999;display:flex;align-items:center;gap:4px;">
                                <i class="ri-calendar-line"></i> {{ $corrida->data_horario->format('d/m/Y') }}
                            </span>
                            <span style="font-size:12px;color:#999;display:flex;align-items:center;gap:4px;">
                                <i class="ri-map-pin-line"></i> {{ $corrida->cidade }}
                            </span>
                            <span style="font-size:12px;color:#999;display:flex;align-items:center;gap:4px;">
                                <i class="ri-route-line"></i> {{ $corrida->distancia }} km
                            </span>
                        </div>

                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <div style="font-size:18px;font-weight:800;color:#2C8CE8;">
                                R$ {{ number_format($corrida->valor_inscricao, 2, ',', '.') }}
                            </div>
                            <a href="{{ route('usuario.corridas.ver', $corrida->id) }}"
                               style="background:#2C8CE8;color:#fff;border-radius:8px;font-size:12px;font-weight:600;padding:7px 14px;text-decoration:none;">
                                Ver detalhes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="vx-card text-center text-muted py-4">
                    Nenhuma corrida disponível no momento. 🏃
                </div>
            </div>
        @endforelse
    </div>

@endsection