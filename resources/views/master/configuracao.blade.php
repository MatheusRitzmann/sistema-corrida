@extends('layouts.admin')

@section('title', 'Configurações')
@section('page_title', 'Configurações do Sistema')

@section('content')

    @if (session('sucesso'))
        <div class="alert alert-success rounded-3 mb-4">{{ session('sucesso') }}</div>
    @endif

    <div class="row justify-content-center">
        <div class="col-12 col-md-7">
            <div class="table-card">

                <div class="table-card__header">
                    <div class="table-card__title">
                        <i class="ri-settings-3-line"></i> Integração Caçapay
                    </div>
                </div>

                <form action="{{ route('master.configuracao.salvar') }}" method="POST">
                    @csrf

                    <!-- URL do Caçapay -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">URL da API Caçapay</label>
                        <input type="url" name="cacapay_url" class="form-control"
                               value="{{ $cacapayUrl }}"
                               placeholder="http://127.0.0.1:8001/api/compras" required>
                        <div class="form-text">Endereço completo do endpoint de compras do Caçapay.</div>
                    </div>

                    <!-- Token do Caçapay -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Token de Acesso</label>
                        <input type="text" name="cacapay_token" class="form-control"
                               value="{{ $cacapayToken }}"
                               placeholder="velox_token_123" required>
                        <div class="form-text">Token fornecido pelo Caçapay para autenticação.</div>
                    </div>

                    <button type="submit" class="btn-new">
                        <i class="ri-save-line"></i> Salvar configurações
                    </button>
                </form>

            </div>
        </div>
    </div>

@endsection