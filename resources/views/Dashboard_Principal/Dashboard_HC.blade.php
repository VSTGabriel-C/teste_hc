<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/relatorios.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modalMobile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Lista.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/motorista_cad.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-lte-free/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/jquery-ui/dist/themes/base/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/alterar_user.css') }}">
    <link rel="stylesheet" href="{{ asset('js/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="{{ asset('css/infos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/avisos.css') }}">

    <link rel="shortcut icon" href="{{ asset('img/logo_oficial.svg') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    <title>::. Gestão de Transporte - HC .::</title>
</head>
<body>
    <?php
        $teste = session()->all();
    ?>
    <input type="checkbox" id="check">
    <div class="conteudos">
        <div class="navegacao">
            <div class="toggle-bars">
                <label for="check">
                    <i class="fa fa-bars"></i>
                </label>
            </div>
        </div>
        <div class="side_bar">
            <div class="titulo_side_bar">
                <img src="{{ asset('img/hc_logo.png') }}" width="40" height="40" alt="">
                <h6 class="font-weight-light text-light mb-0 ml-3">Hospital das Clinicas</h6>
            </div>
            <div class="usuario_side_bar">
                @if ($teste['camFoto'] === '')
                    <img class="ftoP" src="img/user.png" width="75" height="60" alt="">
                    <h6 class="font-weight-light text-light mb-0 ml-3"><?php echo $teste['nome']; ?></h6>
                @else
                    <img class="ftoP" src="storage/images/fotos/<?php echo $teste['camFoto']; ?>" width="75" height="60"
                        alt="">
                    <h6 class="font-weight-light text-light mb-0 ml-3"><?php echo $teste['nome']; ?></h6>
                @endif
            </div>
            <div class="opcs">
                <ul>
                    @if ($teste['Admin'] == 1)
                        @if ($current == 'infos' && $teste['Admin'] == 1)
                            <li class="opc_selected">
                                <a href="{{ route('hc_infos') }}"><i class="fa fa-info infoss"></i>
                                    <h6 class="font-weight-light text-light mb-0 ml-3">Visualizar Informações</h6>
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('hc_infos') }}"><i class="fa fa-info infoss"></i>
                                    <h6 class="font-weight-light text-light mb-0 ml-3">Visualizar Informações</h6>
                                </a>
                            </li>
                        @endif
                        @if ($current == 'relatorios' && $teste['Admin'] == 1)
                            <li class="opc_selected">
                                <a href="{{ route('hc.make.relatorio') }}"><i class="fa fa-file infoss"></i>
                                    <h6 class="font-weight-light text-light mb-0 ml-2">Relatório</h6>
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('hc.make.relatorio') }}"><i class="fa fa-file infoss"></i>
                                    <h6 class="font-weight-light text-light mb-0 ml-2">Relatório</h6>
                                </a>
                            </li>
                        @endif
                    @else
                    @endif
                    @if ($current == 'form')
                        <li class="opc_selected">
                            <a href="{{ route('hc.novaSolicitacao') }}"><i class="fa fa-edit"></i>
                                <h6 class="font-weight-light text-light mb-0 ml-1">Solicitação de Transporte</h6>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('hc.novaSolicitacao') }}"><i class="fa fa-edit"></i>
                                <h6 class="font-weight-light text-light mb-0 ml-1">Solicitação de Transporte</h6>
                            </a>
                        </li>
                    @endif
                    @if ($current == 'aviso')
                        <li class="opc_selected">
                            <a href="{{ route('hc_aviso') }}"><i class="fas fa-exclamation-triangle"></i>
                                <h6 class="font-weight-light text-light mb-0 ml-1">Solicitações em Aberto</h6>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('hc_aviso') }}"><i class="fas fa-exclamation-triangle"></i>
                                <h6 class="font-weight-light text-light mb-0 ml-1">Solicitações em Aberto</h6>
                            </a>
                        </li>
                    @endif
                    @if ($current == 'listagem')
                        <li class="opc_selected">
                            <a href="{{ route('hc.lista') }}"><i class="fa fa-eye"></i>
                                <h6 class="font-weight-light text-light mb-0 ml-1">Visualizar Solicitações</h6>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('hc.lista') }}"><i class="fa fa-eye"></i>
                                <h6 class="font-weight-light text-light mb-0 ml-1">Visualizar Solicitações</h6>
                            </a>
                        </li>
                    @endif

                    @if ($current == 'nova_escala')
                        <li class="opc_selected">
                            <a href="{{ route('hc.new.scale') }}"><i class="fa fa-eye"></i>
                                <h6 class="font-weight-light text-light mb-0 ml-1">Gerar Escala</h6>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('hc.new.scale') }}"><i class="fa fa-calendar"></i>
                                <h6 class="font-weight-light text-light mb-0 ml-1">Gerar Escala</h6>
                            </a>
                        </li>
                    @endif


                    @if ($teste['Admin'] == 1)
                        @if ($current == 'motorista_add_rem')
                            <li class="opc_selected">
                                <a href="{{ route('hc.add_remove_view_motorista') }}"><i class="fa fa-users-cog"></i>
                                    <h6 class="font-weight-light text-light mb-0 ml-1">Adic/Desabilitar Motorista</h6>
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('hc.add_remove_view_motorista') }}"><i class="fa fa-users-cog"></i>
                                    <h6 class="font-weight-light text-light mb-0 ml-1">Adic/Desabilitar Motorista</h6>
                                </a>
                            </li>
                        @endif
                        @if ($current == 'veiculo_add_rem')
                            <li class="opc_selected">
                                <a href="{{ route('hc.add_remove_view_veiculo') }}"><i class="fa fa-ambulance"></i>
                                    <h6 class="font-weight-light text-light mb-0 ml-1">Adic/Desabilitar Veiculo</h6>
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('hc.add_remove_view_veiculo') }}"><i class="fa fa-ambulance"></i>
                                    <h6 class="font-weight-light text-light mb-0 ml-1">Adic/Desabilitar Veiculo</h6>
                                </a>
                            </li>
                        @endif
                        @if ($current == 'solicitante_add_rem')
                            <li class="opc_selected">
                                <a href="{{ route('hc.add_remove_view_solicitante') }}"><i
                                        class="fa fa-user-plus"></i>
                                    <h6 class="font-weight-light text-light mb-0 ml-1">Adic/Desabilitar Solicitante</h6>
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('hc.add_remove_view_solicitante') }}"><i
                                        class="fa fa-user-plus"></i>
                                    <h6 class="font-weight-light text-light mb-0 ml-1">Adic/Desabilitar Solicitante</h6>
                                </a>
                            </li>
                        @endif
                        @if ($current == 'add_new_user' && $teste['Admin'] == 1)
                            <li class="opc_selected">
                                <a href="{{ route('hc_add_new_admin') }}"><i class="fa fa-user"></i>
                                    <h6 class="font-weight-light text-light mb-0 ml-1">Cadastro de Usuarios</h6>
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('hc_add_new_admin') }}"><i class="fa fa-user"></i>
                                    <h6 class="font-weight-light text-light mb-0 ml-1">Cadastro de Usuarios</h6>
                                </a>
                            </li>
                        @endif
                        @if ($current == 'alterar_new_user')
                            <li class="opc_selected">
                                <a href="{{ route('hc_edit_new_admin') }}"><i class="fa fa-edit"></i>
                                    <h6 class="font-weight-light text-light mb-0 ml-1">Alterar Cadastro de Usuarios</h6>
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('hc_edit_new_admin') }}"><i class="fa fa-edit"></i>
                                    <h6 class="font-weight-light text-light mb-0 ml-1">Alterar Cadastro de Usuarios</h6>
                                </a>
                            </li>
                        @endif
                    @else
                    @endif
                </ul>
                <div class="deslogar_cont">
                    <a id="deslog" class=" est_logoff btn btn-danger"><i class="fa fa-sign-out-alt"></i> Sair</a>
                </div>
            </div>
        </div>
        <div class="footer_principal">
            <h6>Copyright © <a target="_blank" href="http://www.vstelecom.com.br/">VSTelecom</a></h6>
        </div>
        <div class="conteudos_internos">
            <div class="header_titulo_cont">
                @if ($current == 'form')
                     <h5>Solicitação de Transporte</h5>
                        <div class="borda-side"></div>
                @endif
                @if ($current == 'listagem')
                    <h5>Lista de Solicitações</h5>
                        <div class="borda-side"></div>
                @endif
                @if ($current == 'motorista_add_rem')
                    <h5>Adicionar / Remover Motorista</h5>
                        <div class="borda-side"></div>
                @endif
                @if ($current == 'veiculo_add_rem')
                    <h5>Adicionar / Remover Veiculo</h5>
                        <div class="borda-side"></div>
                @endif
                @if ($current == 'solicitante_add_rem')
                    <h5>Adicionar / Remover Solicitante</h5>
                        <div class="borda-side"></div>
                @endif
                @if ($current == 'add_new_user')
                    <h5>Cadastrar Novo Usuario</h5>
                    <div class="borda-side"></div>
                @endif
                @if ($current == 'alterar_new_user')
                    <h5>Alterar Usuario</h5>
                        <div class="borda-side"></div>
                @endif
                @if ($current == 'infos')
                    <h5>Informações Gerais</h5>
                        <div class="borda-side"></div>
                @endif
                @if ($current == 'relatorios')
                    <h5>Relatórios</h5>
                        <div class="borda-side"></div>
                @endif
                @if ($current == 'nova_escala')
                    <h5>Escala</h5>
                        <div class="borda-side"></div>
                @endif
            </div>
            <div class="conteudos-form-lista" id="conteents">
                @yield('conts', $current)
            </div>
        </div>



    </div>
    <div id="myModal8" class="modal">
        <div class="modal-content" id="sair_sistema"  style="">
            <div class="modal-header">
                <h4><i class="fa fa-sign-out-alt text-light"></i> Sair do Sistema</h4>
                <span class="close" style="margin-bottom: -3px" onclick="modalClose8()">&times;</span>
            </div>
            <div class="modal-body">
                <h4>Você deseja mesmo sair do sistema ?</h4>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" onclick="modalClose8()">Não</button>
                <a href="{{ route('hc.logoff') }}" class="btn btn-secondary" onclick="modalClose2();">Sair</a>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/variaveis.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/apis/warning_api/warning.js') }}"></script>
    <script src="{{ asset('js/form_validate.js') }}"></script>
    <script src="{{ asset('js/jquery-ui/dist/jquery-ui.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    <script src="{{ asset('js/form_validate.js') }}"></script>
    <script src="{{ asset('js/apis/newSolicitation/deslogar.js') }}"></script>
    <script src="{{ asset('js/apis/relatorio_api/relatorio.js') }}"></script>
    <script src="{{ asset('js/utils.js') }}"></script>
    <script src="{{ asset('js/select2/dist/js/select2.full.min.js') }}"></script>
</body>
</html>
