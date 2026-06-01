@extends('layouts.usuario')

@section('title', 'Nova Atividade')

@section('content')

    <div class="vx-card">
        <div class="vx-card-title"><i class="ri-run-line"></i> Nova Atividade</div>

        @if ($errors->any())
            <div class="alert alert-danger rounded-3 mb-3">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('usuario.atividades.salvar') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Título -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Título</label>
                <input type="text" name="titulo" class="form-control" required>
            </div>

            <!-- Descrição -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Descrição</label>
                <textarea name="descricao" class="form-control" rows="3"></textarea>
            </div>

            <!-- Horários -->
            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label class="form-label fw-semibold">Horário de início</label>
                    <input type="datetime-local" name="horario_inicio" class="form-control" required>
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold">Horário de fim</label>
                    <input type="datetime-local" name="horario_fim" class="form-control" required>
                </div>
            </div>

            <!-- Distância e Pace -->
            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label class="form-label fw-semibold">Distância (km)</label>
                    <input type="number" name="distancia" step="0.01" class="form-control">
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold">Pace (ex: 5:30)</label>
                    <input type="text" name="pace" class="form-control" placeholder="5:30">
                </div>
            </div>

            <!-- Categorias -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Categorias</label>
                <div class="row g-2">
                    @foreach($categorias as $categoria)
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       name="categorias[]" value="{{ $categoria->id }}"
                                       id="cat-{{ $categoria->id }}">
                                <label class="form-check-label" for="cat-{{ $categoria->id }}">
                                    {{ $categoria->nome }}
                                </label>
                            </div>
                            @foreach($categoria->subcategorias as $sub)
                                <div class="form-check ms-3">
                                    <input class="form-check-input" type="checkbox"
                                           name="categorias[]" value="{{ $sub->id }}"
                                           id="cat-{{ $sub->id }}">
                                    <label class="form-check-label" for="cat-{{ $sub->id }}">
                                        ↳ {{ $sub->nome }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Fotos -->
            <div class="mb-4">
                 <label class="form-label fw-semibold">Fotos <span class="text-muted fw-normal">(máximo 5)</span></label>
                 <input type="file" name="fotos[]" class="form-control" multiple accept="image/*" max="5">
                <div class="form-text">Segure Ctrl para selecionar várias fotos ao mesmo tempo.</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit"
                    style="background:#2C8CE8;color:#fff;border-radius:8px;font-size:13px;font-weight:600;padding:8px 16px;border:none;cursor:pointer;">
                    <i class="ri-save-line"></i> Salvar
                </button>
                <a href="{{ route('usuario.atividades') }}" class="btn btn-outline-secondary btn-sm">Voltar</a>
            </div>
        </form>
    </div>

@endsection