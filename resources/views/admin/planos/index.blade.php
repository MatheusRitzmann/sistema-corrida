@extends('layouts.admin')

@section('title', 'Planos')
@section('page_title', 'Planos')

@section('content')

    @if (session('sucesso'))
        <div class="alert alert-success rounded-3 mb-4">{{ session('sucesso') }}</div>
    @endif

    <div class="table-card">
        <div class="table-card__header">
            <div class="table-card__title">Lista de Planos</div>
            <a href="{{ route('admin.planos.criar') }}" class="btn-new">
                <i class="ri-add-line"></i> Novo Plano
            </a>
        </div>

        <table class="table table-borderless mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($planos as $plano)
                    <tr>
                        <td>{{ $plano->id }}</td>
                        <td>{{ $plano->nome }}</td>
                        <td>{{ $plano->descricao ?? '—' }}</td>
                        <td>R$ {{ number_format($plano->valor, 2, ',', '.') }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.planos.editar', $plano->id) }}" class="btn-new" style="padding:.35rem .75rem;">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <form action="{{ route('admin.planos.deletar', $plano->id) }}" method="POST"
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
                        <td colspan="5" class="text-center text-muted">Nenhum plano cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection