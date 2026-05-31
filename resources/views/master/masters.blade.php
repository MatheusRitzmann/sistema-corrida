@extends('layouts.admin')

@section('title', 'Masters')
@section('page_title', 'Masters')

@section('content')

    <!-- Mensagens -->
    @if (session('sucesso'))
        <div class="alert alert-success rounded-3 mb-4">{{ session('sucesso') }}</div>
    @endif
    @if (session('erro'))
        <div class="alert alert-danger rounded-3 mb-4">{{ session('erro') }}</div>
    @endif

    <div class="table-card">
        <div class="table-card__header">
            <div class="table-card__title">Lista de Masters</div>
            @if(Auth::user()->role === 'master')
                <a href="{{ route('masters.criar') }}" class="btn-new">
                    <i class="ri-add-line"></i> Novo Master
                </a>
            @endif
        </div>

        <table class="table table-borderless mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Cadastrado em</th>
                    @if(Auth::user()->role === 'master')
                        <th>Ações</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($masters as $master)
                    <tr>
                        <td>{{ $master->id }}</td>
                        <td>{{ $master->name }}</td>
                        <td>{{ $master->email }}</td>
                        <td>{{ $master->created_at->format('d/m/Y') }}</td>
                        @if(Auth::user()->role === 'master')
                            <td>
                                <div class="d-flex gap-2">
                                    <!-- Editar -->
                                    <a href="{{ route('masters.editar', $master->id) }}" class="btn-new" style="padding: .35rem .75rem;">
                                        <i class="ri-edit-line"></i>
                                    </a>
                                    <!-- Deletar -->
                                    <form action="{{ route('masters.deletar', $master->id) }}" method="POST"
                                          onsubmit="return confirm('Tem certeza que deseja deletar este master?')">
                                        @csrf
                                        <button type="submit" style="background: hsla(0, 80%, 55%, .12); color: hsl(0, 80%, 50%); border: none; border-radius: .5rem; padding: .35rem .75rem; cursor: pointer;">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Nenhum master cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection