<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Master - Sistema Corrida</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --first-color: hsl(208, 92%, 54%);
            --first-color-alt: hsl(208, 88%, 50%);
            --sidebar-bg: hsl(220, 30%, 10%);
            --sidebar-width: 260px;
            --topbar-height: 64px;
            --body-bg: hsl(220, 20%, 96%);
            --card-bg: hsl(0, 0%, 100%);
            --text-color: hsl(220, 15%, 50%);
            --title-color: hsl(220, 68%, 4%);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--body-bg);
            color: var(--text-color);
        }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background-color: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform .3s;
        }

        .sidebar__logo {
            display: flex;
            align-items: center;
             justify-content: center;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid hsla(0,0%,100%,.07);
}

        .sidebar__logo-icon {
            width: 36px;
            height: 36px;
            background: var(--first-color);
            border-radius: .5rem;
            display: grid;
            place-items: center;
            color: white;
            font-size: 1.1rem;
        }

        .sidebar__logo-text {
            font-size: .95rem;
            font-weight: 700;
            color: white;
            line-height: 1.2;
        }

        .sidebar__logo-text span {
            display: block;
            font-size: .7rem;
            font-weight: 400;
            color: hsla(0,0%,100%,.4);
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .sidebar__nav {
            flex: 1;
            padding: 1rem 0;
            overflow-y: auto;
        }

        .sidebar__section {
            padding: .5rem 1.5rem .25rem;
            font-size: .65rem;
            font-weight: 600;
            color: hsla(0,0%,100%,.3);
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .sidebar__link {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .7rem 1.5rem;
            color: hsla(0,0%,100%,.55);
            text-decoration: none;
            font-size: .875rem;
            font-weight: 500;
            transition: all .2s;
            border-left: 3px solid transparent;
        }

        .sidebar__link:hover {
            color: white;
            background: hsla(0,0%,100%,.05);
        }

        .sidebar__link.active {
            color: white;
            background: hsla(208, 92%, 54%, .15);
            border-left-color: var(--first-color);
        }

        .sidebar__link i {
            font-size: 1.1rem;
            width: 20px;
        }

        .sidebar__footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid hsla(0,0%,100%,.07);
        }

        .sidebar__user {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .sidebar__avatar {
            width: 36px;
            height: 36px;
            background: var(--first-color);
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: white;
            font-size: .85rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .sidebar__user-info {
            flex: 1;
            min-width: 0;
        }

        .sidebar__user-name {
            font-size: .8rem;
            font-weight: 600;
            color: white;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar__user-role {
            font-size: .7rem;
            color: hsla(0,0%,100%,.4);
        }

        .sidebar__logout {
            background: none;
            border: none;
            color: hsla(0,0%,100%,.4);
            font-size: 1.1rem;
            cursor: pointer;
            transition: color .2s;
            padding: .25rem;
        }

        .sidebar__logout:hover { color: white; }

        /* ── MAIN ── */
        .main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── TOPBAR ── */
        .topbar {
            height: var(--topbar-height);
            background: var(--card-bg);
            border-bottom: 1px solid hsl(220, 20%, 92%);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar__title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--title-color);
        }

        .topbar__subtitle {
            font-size: .75rem;
            color: var(--text-color);
        }

        .topbar__right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .topbar__badge {
            background: var(--first-color);
            color: white;
            font-size: .7rem;
            font-weight: 700;
            padding: .2rem .6rem;
            border-radius: 2rem;
        }

        /* ── CONTENT ── */
        .content {
            flex: 1;
            padding: 2rem;
        }

        /* ── CARDS ── */
        .stat-card {
            background: var(--card-bg);
            border-radius: 1rem;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 2px 12px hsla(220, 20%, 10%, .06);
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px hsla(220, 20%, 10%, .1);
        }

        .stat-card__icon {
            width: 52px;
            height: 52px;
            border-radius: .75rem;
            display: grid;
            place-items: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .stat-card__icon--blue   { background: hsla(208, 92%, 54%, .12); color: var(--first-color); }
        .stat-card__icon--green  { background: hsla(142, 70%, 45%, .12); color: hsl(142, 70%, 40%); }
        .stat-card__icon--orange { background: hsla(30, 90%, 55%, .12);  color: hsl(30, 90%, 50%); }
        .stat-card__icon--pink   { background: hsla(340, 80%, 60%, .12); color: hsl(340, 80%, 55%); }

        .stat-card__value {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--title-color);
            line-height: 1;
        }

        .stat-card__label {
            font-size: .78rem;
            color: var(--text-color);
            margin-top: .25rem;
        }

        .chart-card {
            background: var(--card-bg);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 2px 12px hsla(220, 20%, 10%, .06);
        }

        .chart-card__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .chart-card__title {
            font-size: .95rem;
            font-weight: 700;
            color: var(--title-color);
        }

        .chart-card__subtitle {
            font-size: .75rem;
            color: var(--text-color);
        }

        .table-card {
            background: var(--card-bg);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 2px 12px hsla(220, 20%, 10%, .06);
        }

        .table-card__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .table-card__title {
            font-size: .95rem;
            font-weight: 700;
            color: var(--title-color);
        }

        .table th {
            font-size: .75rem;
            font-weight: 600;
            color: var(--text-color);
            text-transform: uppercase;
            letter-spacing: .05em;
            border-bottom: 2px solid hsl(220, 20%, 92%);
            padding: .75rem 1rem;
        }

        .table td {
            font-size: .85rem;
            color: var(--title-color);
            padding: .85rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid hsl(220, 20%, 95%);
        }

        .badge-role {
            font-size: .7rem;
            font-weight: 600;
            padding: .3rem .7rem;
            border-radius: 2rem;
        }

        .badge-role--admin  { background: hsla(208, 92%, 54%, .12); color: var(--first-color); }
        .badge-role--master { background: hsla(340, 80%, 60%, .12); color: hsl(340, 80%, 55%); }
        .badge-role--user   { background: hsla(142, 70%, 45%, .12); color: hsl(142, 70%, 40%); }

        .btn-new {
            background: var(--first-color);
            color: white;
            border: none;
            border-radius: .5rem;
            padding: .45rem 1rem;
            font-size: .8rem;
            font-weight: 600;
            font-family: 'Montserrat', sans-serif;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            transition: background .2s, box-shadow .2s;
        }

        .btn-new:hover {
            background: var(--first-color-alt);
            color: white;
            box-shadow: 0 4px 12px hsla(208, 92%, 32%, .3);
        }

        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .main { margin-left: 0; }
        }
    </style>
</head>
<body>

<!--  sidebar -->
<aside class="sidebar">
    <div class="sidebar__logo">
        <img src="{{ asset('img/logo.png') }}" alt="Velox" style="width: 140px;">
    </div>

    <nav class="sidebar__nav">
        <p class="sidebar__section">Principal</p>
        <a href="/master" class="sidebar__link active">
            <i class="ri-dashboard-line"></i> Dashboard
        </a>

        <p class="sidebar__section">Gerenciar</p>
        <a href="/master/criar-admin" class="sidebar__link">
            <i class="ri-shield-user-line"></i> Administradores
        </a>
        <a href="#" class="sidebar__link">
            <i class="ri-group-line"></i> Usuários
        </a>
        <a href="#" class="sidebar__link">
            <i class="ri-trophy-line"></i> Corridas
        </a>
    </nav>

    <div class="sidebar__footer">
        <div class="sidebar__user">
            <div class="sidebar__avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="sidebar__user-info">
                <div class="sidebar__user-name">{{ Auth::user()->name }}</div>
                <div class="sidebar__user-role">Master</div>
            </div>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="sidebar__logout" title="Sair">
                    <i class="ri-logout-box-r-line"></i>
                </button>
            </form>
        </div>
    </div>
</aside>


<main class="main">

    <!-- Topbar -->
    <div class="topbar">
        <div>
            <div class="topbar__title">Dashboard</div>
            <div class="topbar__subtitle">Bem-vindo de volta, {{ Auth::user()->name }}!</div>
        </div>
        <div class="topbar__right">
            <span class="topbar__badge">Master</span>
        </div>
    </div>

    <!-- Conteúdo -->
    <div class="content">

        <!-- Mensagem de sucesso -->
        @if (session('sucesso'))
            <div class="alert alert-success rounded-3 mb-4">{{ session('sucesso') }}</div>
        @endif

        <!-- blocos de estatísticas -->
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
                        <a href="/master/criar-admin" class="btn-new">
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
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
                borderColor: 'hsl(208, 92%, 54%)',
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

</body>
</html>