<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Corrida</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <!-- Forma blob com a imagem de fundo -->
    <svg class="login__blob" viewBox="0 0 566 840" xmlns="http://www.w3.org/2000/svg">
        <mask id="mask0" mask-type="alpha">
            <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 
            0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 
            591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 
            167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z"/>
        </mask>
        <g mask="url(#mask0)">
            <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 
            0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 
            591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 
            167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z"/>
            <image class="login__img" href="{{ asset('img/utmb.jpg') }}"
                   x="-150" y="0" width="750" height="840"
                   preserveAspectRatio="xMidYMid slice"/>
        </g>
    </svg>

    <!-- Área principal da página -->
    <div class="login-wrapper">
        <div class="container login-panel">
            <div class="row justify-content-start">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">

                <!-- Logo -->
                    <div class="mb-4">
                     <img src="{{ asset('img/logo.png') }}" alt="Velox" style="width: 120px;">
                        </div>

                            

                    <h1 class="login__title">Entre na sua conta</h1>

                    <!-- Exibe erros de login -->
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 mb-3">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="/login" method="POST">
                        @csrf

                        <!-- Campo e-mail -->
                        <div class="login__box">
                            <input type="email" id="email" name="email" required placeholder=" " class="login__input">
                            <label for="email" class="login__label">E-mail</label>
                            <i class="ri-mail-fill login__icon"></i>
                        </div>

                        <!-- Campo senha -->
                        <div class="login__box">
                            <input type="password" id="password" name="password" required placeholder=" " class="login__input">
                            <label for="password" class="login__label">Senha</label>
                            <i class="ri-eye-off-fill login__icon login__password" id="loginPassword"></i>
                        </div>

                        <a href="#" class="login__forgot">Esqueceu sua senha?</a>

                        <button type="submit" class="login__button">Entrar</button>
                    </form>

                    
                    <p class="login__social-title">Ou entre com</p>
                    <div class="login__social-links">
                        <a href="#" class="login__social-link">
                            <img src="{{ asset('img/icon-google.svg') }}" alt="Google" class="login__social-img">
                        </a>
                        <a href="#" class="login__social-link">
                            <img src="{{ asset('img/icon-facebook.svg') }}" alt="Facebook" class="login__social-img">
                        </a>
                        <a href="#" class="login__social-link">
                            <img src="{{ asset('img/icon-apple.svg') }}" alt="Apple" class="login__social-img">
                        </a>
                    </div>

                    
                    <p class="login__switch">
                        Ainda não possui uma conta?
                        <a href="/cadastro" class="login__switch-btn">Criar conta</a>
                    </p>

                </div>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>

</body>
</html>