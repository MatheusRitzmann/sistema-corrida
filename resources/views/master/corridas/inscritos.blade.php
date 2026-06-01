@extends('layouts.admin')

@section('title', 'Inscritos')
@section('page_title', 'Inscritos — {{ $corrida->nome }}')

@section('content')

    <div class="table-card">
        <div class="table-card__header">
            <div class="table-card__title">{{ $corrida->nome }}</div>
            <a href="{{ route('master.corridas') }}" class="btn btn-outline-secondary btn-sm">Voltar</a>
        </div>

        <div class="d-flex gap-3 mb-3">
            <span style="font-size:13px;color:#666;">
                <i class="ri-map-pin-line"></i> {{ $corrida->cidade }}
            </span>
            <span style="font-size:13px;color:#666;">
                <i class="ri-calendar-line"></i> {{ $corrida->data_horario->format('d/m/Y H:i') }}
            </span>
            <span style="font-size:13px;color:#666;">
                <i class="ri-group-line"></i> {{ $inscritos->count() }}/{{ $corrida->vagas }} inscritos
            </span>
        </div>

        <table class="table table-borderless mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Valor pago</th>
                    <th>Status</th>
                    <th>Data inscrição</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($inscritos as $inscricao)
                    <tr>
                        <td>{{ $inscricao->id }}</td>
                        <td>{{ $inscricao->user->name }}</td>
                        <td>{{ $inscricao->user->email }}</td>
                        <td>R$ {{ number_format($inscricao->valor_pago, 2, ',', '.') }}</td>
                        <td>
                            @if($inscricao->status === 'confirmado')
                                <span style="background:hsla(142,70%,45%,.12);color:hsl(142,70%,40%);font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;">
                                    Confirmado
                                </span>
                            @elseif($inscricao->status === 'pendente')
                                <span style="background:hsla(30,90%,55%,.12);color:hsl(30,90%,50%);font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;">
                                    Pendente
                                </span>
                            @else
                                <span style="background:hsla(0,80%,55%,.12);color:hsl(0,80%,50%);font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;">
                                    Cancelado
                                </span>
                            @endif
                        </td>
                        <td>{{ $inscricao->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Nenhum inscrito ainda.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection