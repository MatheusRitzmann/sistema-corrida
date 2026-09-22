@extends('layouts.admin')

@section('title', 'Categorias')
@section('page_title', 'Categorias')

@section('content')

    @if (session('sucesso'))
        <div class="alert alert-success rounded-3 mb-4">{{ session('sucesso') }}</div>
    @endif

    <div class="table-card">
        <div class="table-card__header">
            <div class="table-card__title">Lista de Categorias</div>
            <a href="{{ route('admin.categorias.criar') }}" class="btn-new">
                <i class="ri-add-line"></i> Nova Categoria
            </a>
        </div>

        <table class="table table-borderless mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Categoria Pai</th>
                    <th>Subcategorias</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->id }}</td>
                        <td>{{ $categoria->nome }}</td>
                        <td>—</td>
                        <td>{{ $categoria->subcategorias->count() }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.categorias.editar', $categoria->id) }}" class="btn-new" style="padding:.35rem .75rem;">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <form action="{{ route('admin.categorias.deletar', $categoria->id) }}" method="POST"
                                      onsubmit="return confirm('Tem certeza?')">
                                    @csrf
                                    <button type="submit" style="background:hsla(0,80%,55%,.12);color:hsl(0,80%,50%);border:none;border-radius:.5rem;padding:.35rem .75rem;cursor:pointer;">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @foreach($categoria->subcategorias as $sub)
                        <tr>
                            <td>{{ $sub->id }}</td>
                            <td style="padding-left:2rem;">↳ {{ $sub->nome }}</td>
                            <td>{{ $categoria->nome }}</td>
                            <td>—</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.categorias.editar', $sub->id) }}" class="btn-new" style="padding:.35rem .75rem;">
                                        <i class="ri-edit-line"></i>
                                    </a>
                                    <form action="{{ route('admin.categorias.deletar', $sub->id) }}" method="POST"
                                          onsubmit="return confirm('Tem certeza?')">
                                        @csrf
                                        <button type="submit" style="background:hsla(0,80%,55%,.12);color:hsl(0,80%,50%);border:none;border-radius:.5rem;padding:.35rem .75rem;cursor:pointer;">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Nenhuma categoria cadastrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection