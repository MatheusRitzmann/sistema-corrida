@extends('layouts.admin')

@section('title', 'Editar Corrida')
@section('page_title', 'Editar Corrida')

@section('content')

    <div class="row justify-content-center">
        <div class="col-12 col-md-8">

            @if ($errors->any())
                <div class="alert alert-danger rounded-3 mb-3">{{ $errors->first() }}</div>
            @endif

            <div class="table-card">
                <form action="{{ route('master.corridas.atualizar', $corrida->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nome da corrida</label>
                        <input type="text" name="nome" class="form-control" value="{{ $corrida->nome }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3">{{ $corrida->descricao }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Data e horário</label>
                        <input type="datetime-local" name="data_horario" class="form-control"
                               value="{{ $corrida->data_horario->format('Y-m-d\TH:i') }}" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Local</label>
                            <input type="text" name="local" class="form-control" value="{{ $corrida->local }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Cidade</label>
                            <input type="text" name="cidade" class="form-control" value="{{ $corrida->cidade }}" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-4">
                            <label class="form-label fw-semibold">Distância (km)</label>
                            <input type="number" name="distancia" step="0.01" class="form-control" value="{{ $corrida->distancia }}" required>
                        </div>
                        <div class="col-4">
                            <label class="form-label fw-semibold">Vagas</label>
                            <input type="number" name="vagas" min="1" class="form-control" value="{{ $corrida->vagas }}" required>
                        </div>
                        <div class="col-4">
                            <label class="form-label fw-semibold">Valor (R$)</label>
                            <input type="number" name="valor_inscricao" step="0.01" min="0" class="form-control" value="{{ $corrida->valor_inscricao }}" required>
                        </div>
                    </div>

                    <!-- Capa atual -->
                    @if($corrida->capa)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Capa atual</label>
                            <div>
                                <img src="{{ asset('uploads/corridas/' . $corrida->capa) }}"
                                     style="width:200px;border-radius:10px;object-fit:cover;">
                            </div>
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Nova capa <span class="text-muted fw-normal">(deixe em branco para manter)</span></label>
                        <input type="file" name="capa" class="form-control" accept="image/*">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-new">
                            <i class="ri-save-line"></i> Salvar
                        </button>
                        <a href="{{ route('master.corridas') }}" class="btn btn-outline-secondary btn-sm">Voltar</a>
                    </div>
                </form>
            </div>

        </div>
    </div>

@endsection