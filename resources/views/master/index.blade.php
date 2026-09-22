@extends('layouts.admin')

@section('title', 'Dashboard Master')
@section('page_title', 'Dashboard')

@section('content')

    @if (session('sucesso'))
        <div class="alert alert-success rounded-3 mb-4">{{ session('sucesso') }}</div>
    @endif

    <!-- Cards de estatísticas -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--blue">
                    <i class="ri-group-line"></i>
                </div>
                <div>
                    <div class="stat-card__value">{{ $totalUsuarios }}</div>
                    <div class="stat-card__label">Usuários</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--pink">
                    <i class="ri-shield-user-line"></i>
                </div>
                <div>
                    <div class="stat-card__value">{{ $totalAdmins }}</div>
                    <div class="stat-card__label">Admins</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--green">
                    <i class="ri-trophy-line"></i>
                </div>
                <div>
                    <div class="stat-card__value">{{ $totalCorridas }}</div>
                    <div class="stat-card__label">Corridas</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--orange">
                    <i class="ri-ticket-line"></i>
                </div>
                <div>
                    <div class="stat-card__value">{{ $totalInscricoes }}</div>
                    <div class="stat-card__label">Inscrições</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--blue">
                    <i class="ri-user-add-line"></i>
                </div>
                <div>
                    <div class="stat-card__value">{{ $usuariosMes }}</div>
                    <div class="stat-card__label">Novos este Mês</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--green">
                    <i class="ri-money-dollar-circle-line"></i>
                </div>
                <div>
                    <div class="stat-card__value">R$ {{ number_format($receitaTotal, 2, ',', '.') }}</div>
                    <div class="stat-card__label">Receita Total</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row g-3 mb-4">

        <!-- Gráfico usuários por mês -->
        <div class="col-12 col-xl-4">
            <div class="chart-card">
                <div class="chart-card__header">
                    <div>
                        <div class="chart-card__title">Usuários Cadastrados</div>
                        <div class="chart-card__subtitle">Últimos 6 meses</div>
                    </div>
                </div>
                <canvas id="graficoUsuarios" height="160"></canvas>
            </div>
        </div>

        <!-- Gráfico receita por mês -->
        <div class="col-12 col-xl-4">
            <div class="chart-card">
                <div class="chart-card__header">
                    <div>
                        <div class="chart-card__title">Receita por Mês</div>
                        <div class="chart-card__subtitle">Últimos 6 meses</div>
                    </div>
                </div>
                <canvas id="graficoReceita" height="160"></canvas>
            </div>
        </div>

        <!-- Gráfico inscrições por corrida -->
        <div class="col-12 col-xl-4">
            <div class="chart-card">
                <div class="chart-card__header">
                    <div>
                        <div class="chart-card__title">Inscrições por Corrida</div>
                        <div class="chart-card__subtitle">Top 5</div>
                    </div>
                </div>
                <canvas id="graficoCorridas" height="160"></canvas>
            </div>
        </div>

    </div>

    <!-- Tabela de admins -->
    <div class="row g-3">
        <div class="col-12">
            <div class="table-card">
                <div class="table-card__header">
                    <div class="table-card__title">Administradores</div>
                    <a href="{{ route('master.criarAdmin') }}" class="btn-new">
                        <i class="ri-add-line"></i> Novo
                    </a>
                </div>
                <table class="table table-borderless mb-0">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admins as $admin)
                            <tr>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">Nenhum admin cadastrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    // Gráfico usuários por mês
    new Chart(document.getElementById('graficoUsuarios'), {
        type: 'bar',
        data: {
            labels: @json($graficoDados['meses']),
            datasets: [{
                label: 'Usuários',
                data: @json($graficoDados['totais']),
                backgroundColor: 'hsla(208, 92%, 54%, .15)',
                borderColor: '#004aad',
                borderWidth: 2,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, font: { family: 'Montserrat', size: 11 } }, grid: { color: 'hsla(220, 20%, 10%, .05)' } },
                x: { ticks: { font: { family: 'Montserrat', size: 11 } }, grid: { display: false } }
            }
        }
    });

    // Gráfico receita por mês
    new Chart(document.getElementById('graficoReceita'), {
        type: 'line',
        data: {
            labels: @json($graficoDados['mesesReceita']),
            datasets: [{
                label: 'Receita (R$)',
                data: @json($graficoDados['valoresReceita']),
                backgroundColor: 'hsla(142, 70%, 45%, .1)',
                borderColor: 'hsl(142, 70%, 40%)',
                borderWidth: 2,
                pointBackgroundColor: 'hsl(142, 70%, 40%)',
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { font: { family: 'Montserrat', size: 11 }, callback: v => 'R$ ' + v }, grid: { color: 'hsla(220, 20%, 10%, .05)' } },
                x: { ticks: { font: { family: 'Montserrat', size: 11 } }, grid: { display: false } }
            }
        }
    });

    // Gráfico inscrições por corrida
    new Chart(document.getElementById('graficoCorridas'), {
        type: 'doughnut',
        data: {
            labels: @json($graficoDados['corridasNomes']),
            datasets: [{
                data: @json($graficoDados['corridasCounts']),
                backgroundColor: [
                    'hsla(208, 92%, 54%, .7)',
                    'hsla(142, 70%, 45%, .7)',
                    'hsla(30, 90%, 55%, .7)',
                    'hsla(340, 80%, 60%, .7)',
                    'hsla(270, 70%, 55%, .7)',
                ],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { font: { family: 'Montserrat', size: 11 } } }
            }
        }
    });
</script>
@endsection