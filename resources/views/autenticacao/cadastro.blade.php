<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Sistema Corrida</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
    <!-- CSS personalizado -->
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

                    <h1 class="login__title">Criar nova conta</h1>

                    <!-- Exibe erros de validação -->
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 mb-3">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <!-- Exibe mensagem de sucesso -->
                    @if (session('sucesso'))
                        <div class="alert alert-success rounded-3 mb-3">
                            {{ session('sucesso') }}
                        </div>
                    @endif

                    <form action="/cadastro" method="POST">
                        @csrf

                        <!-- Campos nome e sobrenome -->
                        <div class="login__group mb-3">
                            <div class="login__box">
                                <input type="text" id="nome" name="nome" required placeholder=" " class="login__input">
                                <label for="nome" class="login__label">Nome</label>
                                <i class="ri-id-card-fill login__icon"></i>
                            </div>
                            <div class="login__box">
                                <input type="text" id="sobrenome" name="sobrenome" required placeholder=" " class="login__input">
                                <label for="sobrenome" class="login__label">Sobrenome</label>
                                <i class="ri-id-card-fill login__icon"></i>
                            </div>
                        </div>

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
                            <i class="ri-eye-off-fill login__icon login__password" id="loginPasswordCreate"></i>
                        </div>

                        <button type="submit" class="login__button">Criar conta</button>
                    </form>

                    <!-- Link para voltar ao login -->
                    <p class="login__switch">
                        Já possui uma conta?
                        <a href="/login" class="login__switch-btn">Entrar</a>
                    </p>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        /*=============== MOSTRAR/OCULTAR SENHA ===============*/
        const passwordRegister = (loginPass, loginEye) => {
            const input   = document.getElementById(loginPass),
                  iconEye = document.getElementById(loginEye)

            iconEye.addEventListener('click', () => {
                // Alterna entre senha e texto
                input.type === 'password' ? input.type = 'text'
                                          : input.type = 'password'

                // Troca o ícone
                iconEye.classList.toggle('ri-eye-fill')
                iconEye.classList.toggle('ri-eye-off-fill')
            })
        }
        passwordRegister('password', 'loginPasswordCreate')
    </script>

</body>
</html>