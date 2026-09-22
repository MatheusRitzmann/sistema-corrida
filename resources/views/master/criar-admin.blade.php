@extends('layouts.admin')

@section('title', 'Criar Master')
@section('page_title', 'Criar Master')

@section('content')

    <div class="row justify-content-center">
        <div class="col-12 col-md-6">

            @if ($errors->any())
                <div class="alert alert-danger rounded-3 mb-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="table-card">
                <form action="{{ route('master.criarAdmin.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nome completo</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">E-mail</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Senha</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-new">
                            <i class="ri-user-add-line"></i> Criar Master
                        </button>
                        <a href="{{ route('masters.index') }}" class="btn btn-outline-secondary btn-sm">
                            Voltar
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>

@endsection