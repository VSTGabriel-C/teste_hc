<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loginNew.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/logo_oficial.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VS | Sistema de Controle Integrado</title>
</head>

<body>
    <nav class="navbar navbar-light bg-light">
        <div class="container">
             <a class="navbar-brand" href="#">
                <div class="imagem">
                    <img src="img/logo_oficial.svg" alt="" width="50" height="60">
                </div>
            </a>
            <div class="col-8">
                <h3>Sistema de Controle Integrado</h3>
            </div>
        </div>
    </nav>
    {{--  --}}
    <div class="containerlOGIN">
        <div class="wrapper">
            <div class="title"><span>Login</span></div>
            <form action="{{ route('hc.autenticate') }}" method="POST">
                @csrf
                <div class="row">
                    <i class="fas fa-user"></i>
                    <input type="email" placeholder="Usuario" name="user">
                </div>
                <div class="row">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Password" name="pass">
                </div>
                <div class="robo">
                    <div class="cont_robo">
                        <div class="loader"></div>
                        <div class="form-check">
                            <input class="form-check-input" class="ch" type="radio" id="check"
                                name="checkbox">
                            <label class="form-check-label" id= "label_robo" for="flexCheckIndeterminate">
                                Não sou um robô
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row button">
                    <input type="submit" value="Entrar">
                </div>
            </form>
        </div>
        <div class="msg_error">
            @if (session('msg'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('msg') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
    <div class="footer_principal">
        <h6>Copyright © <a target="_blank" href="http://www.vstelecom.com.br/">VSTelecom</a></h6>
    </div>
    {{--  --}}
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/adminlte.js') }}"></script>
    <script src="{{ asset('js/login.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
    </script>
</body>

</html>
