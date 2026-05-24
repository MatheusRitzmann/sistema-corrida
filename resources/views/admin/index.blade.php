<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Admin - Sistema Corrida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>
<body>

    <nav class="navbar navbar-dark bg-dark px-4">
        <span class="navbar-brand">Sistema Corrida — Admin</span>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-sm">Sair</button>
        </form>
    </nav>

    <div class="container mt-5">
        <h2>Bem-vindo, {{ Auth::user()->name }}!</h2>
        <p class="text-muted">Você está logado como <strong>Administrador</strong>.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>