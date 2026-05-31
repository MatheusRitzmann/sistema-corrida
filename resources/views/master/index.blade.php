@extends('layouts.admin')

@section('title', 'Dashboard Master')
@section('page_title', 'Dashboard')

@section('content')

    <!-- Mensagem de sucesso -->
    @if (session('sucesso'))
        <div class="alert alert-success rounded-3 mb-4">{{ session('sucesso') }}</div>
    @endif

    <!-- Cards de estatísticas -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
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
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--pink">
                    <i class="ri-shield-user-line"></i>
                </div>
                <div>
                    <div class="stat-card__value">{{ $totalAdmins }}</div>
                    <div class="stat-card__label">Administradores</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
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
        <div class="col-12 col-sm-6 col-xl-3">
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

    <!-- Gráfico + Tabela -->
    <div class="row g-3">

        <!-- Gráfico de usuários -->
        <div class="col-12 col-xl-7">
            <div class="chart-card">
                <div class="chart-card__header">
                    <div>
                        <div class="chart-card__title">Usuários Cadastrados</div>
                        <div class="chart-card__subtitle">Últimos 6 meses</div>
                    </div>
                </div>
                <canvas id="graficoUsuarios" height="120"></canvas>
            </div>
        </div>

        <!-- Tabela de admins -->
        <div class="col-12 col-xl-5">
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
    // Gráfico de usuários cadastrados por mês
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