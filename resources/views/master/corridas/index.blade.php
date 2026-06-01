@extends('layouts.admin')

@section('title', 'Corridas')
@section('page_title', 'Corridas')

@section('content')

    @if (session('sucesso'))
        <div class="alert alert-success rounded-3 mb-4">{{ session('sucesso') }}</div>
    @endif

    <div class="table-card">
        <div class="table-card__header">
            <div class="table-card__title">Lista de Corridas</div>
            <a href="{{ route('master.corridas.criar') }}" class="btn-new">
                <i class="ri-add-line"></i> Nova Corrida
            </a>
        </div>

        <table class="table table-borderless mb-0">
            <thead>
                <tr>
                    <th>Capa</th>
                    <th>Nome</th>
                    <th>Data</th>
                    <th>Local</th>
                    <th>Distância</th>
                    <th>Vagas</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($corridas as $corrida)
                    <tr>
                        <td>
                            @if($corrida->capa)
                                <img src="{{ asset('uploads/corridas/' . $corrida->capa) }}"
                                     style="width:50px;height:50px;object-fit:cover;border-radius:8px;">
                            @else
                                <div style="width:50px;height:50px;background:#f4f6fb;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                    <i class="ri-image-line" style="color:#aaa;"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $corrida->nome }}</td>
                        <td>{{ $corrida->data_horario->format('d/m/Y H:i') }}</td>
                        <td>{{ $corrida->cidade }}</td>
                        <td>{{ $corrida->distancia }} km</td>
                        <td>
                            {{ $corrida->inscricoes_count }}/{{ $corrida->vagas }}
                            @if($corrida->temVagas())
                                <span style="background:hsla(142,70%,45%,.12);color:hsl(142,70%,40%);font-size:10px;font-weight:600;padding:2px 8px;border-radius:20px;margin-left:4px;">
                                    Aberta
                                </span>
                            @else
                                <span style="background:hsla(0,80%,55%,.12);color:hsl(0,80%,50%);font-size:10px;font-weight:600;padding:2px 8px;border-radius:20px;margin-left:4px;">
                                    Esgotada
                                </span>
                            @endif
                        </td>
                        <td>R$ {{ number_format($corrida->valor_inscricao, 2, ',', '.') }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('master.corridas.inscritos', $corrida->id) }}" class="btn-new" style="padding:.35rem .75rem;">
                                    <i class="ri-group-line"></i>
                                </a>
                                <a href="{{ route('master.corridas.editar', $corrida->id) }}" class="btn-new" style="padding:.35rem .75rem;">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <form action="{{ route('master.corridas.deletar', $corrida->id) }}" method="POST"
                                      onsubmit="return confirm('Tem certeza?')">
                                    @csrf
                                    <button type="submit" style="background:hsla(0,80%,55%,.12);color:hsl(0,80%,50%);border:none;border-radius:.5rem;padding:.35rem .75rem;cursor:pointer;">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Nenhuma corrida cadastrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection