@extends('layouts.admin')

@section('title', 'Métricas')
@section('page_title', 'Métricas')

@section('content')

    @if (session('sucesso'))
        <div class="alert alert-success rounded-3 mb-4">{{ session('sucesso') }}</div>
    @endif

    <div class="table-card">
        <div class="table-card__header">
            <div class="table-card__title">Lista de Métricas</div>
            <a href="{{ route('admin.metricas.criar') }}" class="btn-new">
                <i class="ri-add-line"></i> Nova Métrica
            </a>
        </div>

        <table class="table table-borderless mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($metricas as $metrica)
                    <tr>
                        <td>{{ $metrica->id }}</td>
                        <td>{{ $metrica->nome }}</td>
                        <td>{{ $metrica->descricao ?? '—' }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.metricas.editar', $metrica->id) }}" class="btn-new" style="padding:.35rem .75rem;">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <form action="{{ route('admin.metricas.deletar', $metrica->id) }}" method="POST"
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
                        <td colspan="4" class="text-center text-muted">Nenhuma métrica cadastrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection