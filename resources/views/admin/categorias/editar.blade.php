@extends('layouts.admin')

@section('title', 'Editar Categoria')
@section('page_title', 'Editar Categoria')

@section('content')

    <div class="row justify-content-center">
        <div class="col-12 col-md-6">

            @if ($errors->any())
                <div class="alert alert-danger rounded-3 mb-3">{{ $errors->first() }}</div>
            @endif

            <div class="table-card">
                <form action="{{ route('admin.categorias.atualizar', $categoria->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nome</label>
                        <input type="text" name="nome" class="form-control" value="{{ $categoria->nome }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Categoria pai <span class="text-muted fw-normal">(opcional)</span></label>
                        <select name="categoria_pai" class="form-select">
                            <option value="">Nenhuma — categoria principal</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}" {{ $categoria->categoria_pai == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-new">
                            <i class="ri-save-line"></i> Salvar
                        </button>
                        <a href="{{ route('admin.categorias') }}" class="btn btn-outline-secondary btn-sm">Voltar</a>
                    </div>
                </form>
            </div>

        </div>
    </div>

@endsection