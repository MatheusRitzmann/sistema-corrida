<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema Corrida') - Velox</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
   
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <style>
        :root {
            --first-color: #004aad;
            --first-color-alt: hsl(208, 88%, 40%);
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

       
        .main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        
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

        
        .content {
            flex: 1;
            padding: 2rem;
        }

        
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

    @yield('styles')
</head>
<body>


<aside class="sidebar">
    <div class="sidebar__logo">
        <img src="{{ asset('img/logo.png') }}" alt="Velox" style="width: 140px;">
    </div>

    <nav class="sidebar__nav">
        <p class="sidebar__section">Principal</p>
        <a href="{{ route('dashboard') }}" class="sidebar__link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="ri-dashboard-line"></i> Dashboard
        </a>

        <p class="sidebar__section">Gerenciar</p>

        @if(Auth::user()->role === 'master')
        <a href="{{ route('master.criarAdmin') }}" class="sidebar__link {{ request()->routeIs('master.*') ? 'active' : '' }}">
            <i class="ri-shield-user-line"></i> Administradores
        </a>
        @endif

        <a href="{{ route('usuarios.index') }}" class="sidebar__link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
            <i class="ri-group-line"></i> Usuários
        </a>

        @if(Auth::user()->role === 'master')
        <a href="{{ route('masters.index') }}" class="sidebar__link {{ request()->routeIs('masters.*') ? 'active' : '' }}">
            <i class="ri-vip-crown-line"></i> Masters
        </a>
        @endif

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
                <div class="sidebar__user-role">{{ ucfirst(Auth::user()->role) }}</div>
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

    
    <div class="topbar">
        <div>
            <div class="topbar__title">@yield('page_title', 'Dashboard')</div>
            <div class="topbar__subtitle">Bem-vindo de volta, {{ Auth::user()->name }}!</div>
        </div>
        <div class="topbar__right">
            <span class="topbar__badge">{{ ucfirst(Auth::user()->role) }}</span>
        </div>
    </div>

    <!-- Conteúdo da página -->
    <div class="content">
        @yield('content')
    </div>

</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

</body>
</html>