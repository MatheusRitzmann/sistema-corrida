@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard')

@section('content')

    <!-- Mensagem de sucesso -->
    @if (session('sucesso'))
        <div class="alert alert-success rounded-3 mb-4">{{ session('sucesso') }}</div>
    @endif

    <!-- Cards de estatísticas -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--blue">
                    <i class="ri-group-line"></i>
                </div>
                <div>
                    <div class="stat-card__value">{{ $totalUsuarios }}</div>
                    <div class="stat-card__label">Total de Usuários</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--green">
                    <i class="ri-trophy-line"></i>
                </div>
                <div>
                    <div class="stat-card__value">0</div>
                    <div class="stat-card__label">Corridas Cadastradas</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--orange">
                    <i class="ri-user-add-line"></i>
                </div>
                <div>
                    <div class="stat-card__value">{{ $usuariosMes }}</div>
                    <div class="stat-card__label">Novos este Mês</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico -->
    <div class="row g-3">
        <div class="col-12">
            <div class="chart-card">
                <div class="chart-card__header">
                    <div>
                        <div class="chart-card__title">Usuários Cadastrados</div>
                        <div class="chart-card__subtitle">Últimos 6 meses</div>
                    </div>
                </div>
                <canvas id="graficoUsuarios" height="80"></canvas>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('graficoUsuarios').getContext('2d');

    const labels = @json($graficoDados['meses']);
    const dados  = @json($graficoDados['totais']);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Usuários cadastrados',
                data: dados,
                backgroundColor: 'hsla(208, 92%, 54%, .15)',
                borderColor: '#004aad',
                borderWidth: 2,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { family: 'Montserrat', size: 11 }
                    },
                    grid: { color: 'hsla(220, 20%, 10%, .05)' }
                },
                x: {
                    ticks: { font: { family: 'Montserrat', size: 11 } },
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endsection