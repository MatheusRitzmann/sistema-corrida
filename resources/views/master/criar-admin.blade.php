<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Admin - Sistema Corrida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>
<body>

    <nav class="navbar navbar-dark bg-dark px-4">
        <span class="navbar-brand">Sistema Corrida — Master</span>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-sm">Sair</button>
        </form>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">

                <h4 class="mb-4">Criar novo Administrador</h4>

                <!-- Exibe erros -->
                @if ($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form action="/master/criar-admin" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nome completo</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Senha</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Criar Admin</button>
                        <a href="/master" class="btn btn-outline-secondary">Voltar</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>