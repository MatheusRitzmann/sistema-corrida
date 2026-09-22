@extends('layouts.usuario')

@section('title', 'Planos')

@section('content')

    @if (session('sucesso'))
        <div class="alert alert-success rounded-3 mb-3">{{ session('sucesso') }}</div>
    @endif

    @if (session('erro'))
        <div class="alert alert-danger rounded-3 mb-3">{{ session('erro') }}</div>
    @endif

    <!-- Subscrição atual -->
    @if($subscricao)
        <div class="vx-card mb-4">
            <div class="vx-card-title"><i class="ri-vip-diamond-line"></i> Minha Subscrição</div>
            <table class="table table-borderless mb-0">
                <thead>
                    <tr>
                        <th>Plano</th>
                        <th>Início</th>
                        <th>Fim</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscricao->planos as $plano)
                        <tr>
                            <td>{{ $plano->nome }}</td>
                            <td>{{ \Carbon\Carbon::parse($plano->pivot->data_inicio)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($plano->pivot->data_fim)->format('d/m/Y') }}</td>
                            <td>R$ {{ number_format($plano->pivot->subtotal, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="fw-bold text-end">Total:</td>
                        <td class="fw-bold">R$ {{ number_format($subscricao->valor_total, 2, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif

    <!-- Planos disponíveis -->
    <div class="vx-card-title mb-3"><i class="ri-vip-diamond-line"></i> Planos Disponíveis</div>

    <div class="row g-3">
        @forelse($planos as $plano)
            <div class="col-12 col-md-4">
                <div class="vx-card h-100">
                    <div style="font-size:18px;font-weight:800;color:#1a1a1a;margin-bottom:4px;">{{ $plano->nome }}</div>
                    <div style="font-size:26px;font-weight:800;color:#2C8CE8;margin-bottom:12px;">
                        R$ {{ number_format($plano->valor, 2, ',', '.') }}
                        <span style="font-size:13px;font-weight:500;color:#aaa;">/mês</span>
                    </div>
                    @if($plano->descricao)
                        <p style="font-size:13px;color:#777;margin-bottom:16px;">{{ $plano->descricao }}</p>
                    @endif

                    <form action="{{ route('usuario.subscricao.assinar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plano_id" value="{{ $plano->id }}">
                        <div class="mb-2">
                            <label class="form-label fw-semibold" style="font-size:12px;">Data de início</label>
                            <input type="date" name="data_inicio" class="form-control form-control-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size:12px;">Data de fim</label>
                            <input type="date" name="data_fim" class="form-control form-control-sm" required>
                        </div>
                        <button type="submit"
                            style="width:100%;background:#2C8CE8;color:#fff;border:none;border-radius:8px;padding:8px;font-size:13px;font-weight:600;cursor:pointer;">
                            Assinar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="vx-card text-center text-muted py-4">
                    Nenhum plano disponível no momento.
                </div>
            </div>
        @endforelse
    </div>

@endsection