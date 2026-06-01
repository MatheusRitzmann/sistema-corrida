<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Velox') - Sistema Corrida</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
   
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <style>
        :root {
            --blue: #2C8CE8;
            --blue-alt: #1a7fd4;
            --blue-light: #2C8CE820;
            --green: #22c78a;
            --red: #e24b4a;
            --bg: #f4f6fb;
            --card-bg: #fff;
            --border: #e8ecf5;
            --text: #1a1a1a;
            --text-muted: #999;
            --navbar-height: 60px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        /*navbar*/
        .navbar-velox {
            height: var(--navbar-height);
            background: var(--card-bg);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-velox__logo {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .navbar-velox__logo-icon {
            width: 34px;
            height: 34px;
            background: #BFFD3C;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-velox__logo-icon img {
            width: 28px;
            height: 28px;
            object-fit: contain;
        }

        .navbar-velox__logo-name {
            font-size: 18px;
            font-weight: 800;
            color: var(--text);
        }

        .navbar-velox__logo-name span {
            color: var(--blue);
        }

        .navbar-velox__nav {
            display: flex;
            gap: 6px;
        }

        .navbar-velox__link {
            background: var(--blue-light);
            border: none;
            border-radius: 8px;
            padding: 7px 16px;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            color: var(--blue);
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.15s;
        }

        .navbar-velox__link:hover {
            background: #2C8CE865;
            color: var(--blue);
        }

        .navbar-velox__link.active {
            background: var(--blue);
            color: #fff;
            box-shadow: 0 2px 8px #2C8CE840;
        }

        .navbar-velox__user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-velox__avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: var(--blue);
            background: var(--blue-light);
            flex-shrink: 0;
        }

        .navbar-velox__greet {
            font-size: 13px;
            color: #666;
        }

        .navbar-velox__greet strong {
            color: var(--text);
            font-weight: 600;
        }

        .navbar-velox__logout {
            background: none;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 12px;
            font-family: 'Inter', sans-serif;
            color: #888;
            cursor: pointer;
            transition: all 0.15s;
        }

        .navbar-velox__logout:hover {
            background: var(--red);
            color: #fff;
            border-color: var(--red);
        }

        /*contend*/
        .usuario-content {
            max-width: 900px;
            margin: 1.5rem auto;
            padding: 0 1rem;
        }

        /*box*/
        .vx-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 16px 18px;
            border: 1px solid var(--border);
        }

        .vx-card-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .vx-card-title i {
            font-size: 15px;
            color: var(--blue);
        }

        /*metricas como pace, distancia etc*/
        .vx-mc {
            background: var(--card-bg);
            border-radius: 14px;
            padding: 14px 16px;
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        .vx-mc-bar {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            border-radius: 14px 0 0 14px;
        }

        .vx-mc-label {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 6px;
            padding-left: 8px;
        }

        .vx-mc-val {
            font-size: 26px;
            font-weight: 800;
            color: var(--text);
            line-height: 1;
            padding-left: 8px;
        }

        .vx-mc-unit {
            font-size: 12px;
            font-weight: 500;
            color: #aaa;
            margin-left: 2px;
        }

        .vx-mc-delta {
            font-size: 11px;
            margin-top: 5px;
            font-weight: 500;
            padding-left: 8px;
        }

        .up { color: var(--green); }
        .dn { color: var(--red); }

        /*=============== POSTS ===============*/
        .vx-post {
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--border);
            margin-bottom: 12px;
            overflow: hidden;
        }

        .vx-post-head {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 16px 10px;
        }

        .vx-post-av {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .vx-post-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
        }

        .vx-post-time {
            font-size: 11px;
            color: #bbb;
        }

        .vx-post-type {
            font-size: 11px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 20px;
            background: var(--blue-light);
            color: var(--blue);
            margin-left: auto;
        }

        .vx-post-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
            padding: 0 16px 8px;
        }

        .vx-post-desc {
            font-size: 13px;
            color: #777;
            padding: 0 16px 10px;
            line-height: 1.5;
        }

        .vx-post-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1px;
            background: #f4f6fb;
            border-top: 1px solid #f0f2f8;
            border-bottom: 1px solid #f0f2f8;
        }

        .vx-pstat {
            background: var(--card-bg);
            padding: 10px 0;
            text-align: center;
        }

        .vx-pstat-val {
            font-size: 16px;
            font-weight: 800;
            color: var(--text);
        }

        .vx-pstat-label {
            font-size: 10px;
            color: #bbb;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            font-weight: 500;
            margin-top: 1px;
        }

        .vx-post-actions {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 8px 12px;
            border-bottom: 1px solid #f4f6fb;
        }

        .vx-act-btn {
            background: none;
            border: none;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 12px;
            font-family: 'Inter', sans-serif;
            color: #888;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
            transition: all 0.15s;
        }

        .vx-act-btn:hover { background: #f4f6fb; color: var(--text); }
        .vx-act-btn.liked { color: var(--red); }
        .vx-act-btn i { font-size: 16px; }

        .vx-comments {
            padding: 10px 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .vx-comment {
            display: flex;
            gap: 8px;
            align-items: flex-start;
        }

        .vx-comment .vx-post-av {
            width: 28px;
            height: 28px;
            font-size: 10px;
        }

        .vx-comment-bubble {
            background: #f4f6fb;
            border-radius: 10px;
            padding: 7px 10px;
            flex: 1;
        }

        .vx-comment-author {
            font-size: 11px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 2px;
        }

        .vx-comment-text {
            font-size: 12px;
            color: #555;
            line-height: 1.4;
        }

        .vx-comment-time {
            font-size: 10px;
            color: #ccc;
            margin-top: 3px;
        }

        .vx-comment-input {
            display: flex;
            gap: 8px;
            align-items: center;
            padding: 10px 16px 14px;
        }

        .vx-cinput {
            flex: 1;
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 7px 14px;
            font-size: 12px;
            font-family: 'Inter', sans-serif;
            color: var(--text);
            background: #f7f9fd;
            outline: none;
            transition: border 0.15s;
        }

        .vx-cinput:focus {
            border-color: var(--blue);
            background: #fff;
        }

        .vx-send-btn {
            background: var(--blue);
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            transition: background 0.15s;
            color: white;
            font-size: 14px;
        }

        .vx-send-btn:hover { background: var(--blue-alt); }
    </style>

    @yield('styles')
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar-velox">
        <a href="{{ route('usuario.dashboard') }}" class="navbar-velox__logo">
            <div class="navbar-velox__logo-icon">
                <img src="{{ asset('img/logo.png') }}" alt="Velox">
            </div>
            <span class="navbar-velox__logo-name">Ve<span>lox</span></span>
        </a>

        <a href="{{ route('usuario.atividades') }}" class="navbar-velox__link {{ request()->routeIs('usuario.atividades*') ? 'active' : '' }}">
            <i class="ri-run-line"></i> Atividades
        </a>
        <a href="{{ route('usuario.subscricao') }}" class="navbar-velox__link {{ request()->routeIs('usuario.subscricao*') ? 'active' : '' }}">
            <i class="ri-vip-diamond-line"></i> Planos
        </a>

        <div class="navbar-velox__nav">
            <a href="{{ route('usuario.dashboard') }}" class="navbar-velox__link {{ request()->routeIs('usuario.dashboard') ? 'active' : '' }}">
                <i class="ri-home-line"></i> Feed
            </a>
            <a href="{{ route('usuario.corridas') }}" class="navbar-velox__link {{ request()->routeIs('usuario.corridas*') ? 'active' : '' }}">
            <i class="ri-trophy-line"></i> Corridas
            </a>
        </div>

        <div class="navbar-velox__user">
            <div class="navbar-velox__avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <span class="navbar-velox__greet">
                Olá, <strong>{{ Auth::user()->name }}</strong>
            </span>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="navbar-velox__logout">Sair</button>
            </form>
        </div>
    </nav>

    <!-- Conteúdo -->
    <div class="usuario-content">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')

</body>
</html>