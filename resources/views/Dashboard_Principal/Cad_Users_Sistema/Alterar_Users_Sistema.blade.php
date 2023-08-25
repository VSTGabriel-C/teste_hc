@extends('Dashboard_Principal.Dashboard_HC', ['current' => 'alterar_new_user'])
@section('conts')
    <div class="conteudos_alterar_user" id="conts_usuario_A">
        <div class="box_listagem_usuarios">
            <div class="header_add1">
                <i class="fa fa-edit mr-2 text-light" style="font-size: 20px;"></i>
                <h4 class="font-weight-light text-light mb-0">Lista de Usuarios</h4>
            </div>
            <div class="table_list_user">
                <table class="table  table-sm table-bordered table-striped mt-2 mytbl bg-light" style="border-radius: 12px">
                    <thead class="bg-secondary text-light" style="border-radius: 12px">
                        <tr>
                            <th scope="col" class="font-weight-light text-center align-middle">ID</th>
                            <th scope="col" class="font-weight-light text-center align-middle">Nome</th>
                            <th scope="col" class="font-weight-light text-center align-middle">Email</th>
                            <th scope="col" class="font-weight-light text-center align-middle">Data Cadastro</th>
                            <th scope="col" class="font-weight-light text-center align-middle">Status</th>
                            <th scope="col" class="font-weight-light text-center align-middle" class="acoes">Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody id="users_lista1">

                    </tbody>
                </table>
                <div class="acabo" id="acabo" class="form-group d-flex justify-content-center">
                    <button class="btn btn-danger mr-1 btn-sm" name="ant" id="ant">Anterior</button>
                    <button class="btn btn-secondary btn-sm" name="prox" id ="prox">Próxima</button>
                    </div>
            </div>
        </div>
    </div>
    <?php
    $stats = 3;
    if (empty($_GET)) {
        $stats = 3;
    } else {
        $stats = $_GET['status'];
    }
    ?>
    @if ($stats == 0)
        <div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <?php echo $_GET['msg']; ?>
        </div>
    @elseif($stats == 1)
        <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <?php echo $_GET['msg']; ?>
        </div>
    @endif
    <div id="myModal3" class="modal">
        <div class="modal-content" id="content_modal_edit">
            <div class="modal-header">
                <h4><i class="fa fa-edit text-light"></i> Editar Usuário</h4>
                <span class="close" style="margin-bottom: -3px" onclick="modalClose2()">&times;</span>
                <form action="{{ route('hc.api.edit_User_By_Ids') }}" method="post" enctype="multipart/form-data">
            </div>
            <div class="modal-body">
                <label for="staticEmail" class="col-sm-3 col-form-label">Nome: </label>
                <div class="col-sm-12">
                    <input name="nome" id="nome" type="text" class="form-control nome_motorista">
                </div>
                <div class="col-sm-12">
                    <input name="idE" id="idE" style="display : none">
                </div>
                <label for="staticEmail" class="col-sm-3 col-form-label">Email: </label>
                <div class="col-sm-12">
                    <input name="email" id="email" type="text" class="form-control nome_motorista">
                </div>
                <label for="staticEmail" class="col-sm-3 col-form-label">Nova Senha: </label>
                <div class="col-sm-12">
                    <input name="password" id="password" type="password" class="form-control nome_motorista">
                </div>
                <label for="staticEmail" class="col-sm-3 col-form-label">Confirmar Senha: </label>
                <div class="col-sm-12">
                    <input name="password_C" id="password_C" type="password" class="form-control nome_motorista">
                </div>
            </div>
            <div class="modal-footer">
                <span class="btn btn-danger btn-sm" onclick="modalClose2()">Fechar</span>
              <label class="Vfoto2" for="imageE"><p class="sel_foto">Foto</p></label>
                <input type='file' id="imageE" name="imageE" />
                <input class="NFot2 inputGroup-sizing-sm" for="image" readonly="readonly">
                <button class="btn btn-secondary btn-sm" type="submit">Editar</button>
                </form>
            </div>
        </div>



    </div>
    <script src="{{ asset('js/apis/usuarios_api/cadastro_usuario.js') }}"></script>
    <script src="{{ asset('js/apis/usuarios_api/editar_usuario.js') }}"></script>
    <script src="{{ asset('js/apis/usuarios_api/desativar_usuario.js') }}"></script>
@endsection
