@extends('layouts.admin')

@section('title', 'Editar Métrica')
@section('page_title', 'Editar Métrica')

@section('content')

    <div class="row justify-content-center">
        <div class="col-12 col-md-6">

            @if ($errors->any())
                <div class="alert alert-danger rounded-3 mb-3">{{ $errors->first() }}</div>
            @endif

            <div class="table-card">
                <form action="{{ route('admin.metricas.atualizar', $metrica->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nome</label>
                        <input type="text" name="nome" class="form-control" value="{{ $metrica->nome }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3">{{ $metrica->descricao }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-new">
                            <i class="ri-save-line"></i> Salvar
                        </button>
                        <a href="{{ route('admin.metricas') }}" class="btn btn-outline-secondary btn-sm">Voltar</a>
                    </div>
                </form>
            </div>

        </div>
    </div>

@endsection