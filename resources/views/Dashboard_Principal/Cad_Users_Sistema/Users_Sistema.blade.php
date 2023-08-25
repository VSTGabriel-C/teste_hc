@extends('Dashboard_Principal.Dashboard_HC', ['current' => 'add_new_user'])
@section('conts')
    <div id="conteudo_solicitante" class="box_de_cadastro_usuario">
        <div class="header_add">
            <i class="fa fa-user-plus mr-2 text-light" style="font-size: 20px;"></i>
            <h4 class="font-weight-light text-light mb-0">Cadastro de Usuarios</h4>
        </div>
        <div class="body_add">

            <form action="{{route('hc.api.new_user')}}" method="post" enctype="multipart/form-data">
                <div class="form-group">
                 <label for="exampleInputEmail1">Email de acesso:</label>
                  <input type="email" name="u_email" class="form-control" id="email" aria-describedby="emailHelp">
                  <small id="emailHelp" class="form-text text-muted font-weight-bold">Nunca compartilharemos seu e-mail com mais ninguém.</small>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Nome usuario:</label>
                  <input type="text" name="u_nome" class="form-control" id="nome" aria-describedby="nomeHelp">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Senha de acesso:</label>
                  <input type="password" name="u_senha" class="form-control" id="senha">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Confirme sua senha:</label>
                  <input type="password" name="s_confirm" class="form-control" id="senhaC">
                </div>
                <div class="form-group">
                  <label for="">Tipo de usuario:</label>
                  <select id="tipo" name="tipo_user" class="custom-select col-12" required>
                    <option value="" selected disabled>Escolha</option>
                    <option value="Admin" >Admin</option>
                    <option value="Normal" >Normal</option>
                  </select>
                </div> 
                <div class="area_button_new">
                    <label class="Vfoto" style="font-weight: 300; margin-bottom: 0px;" for="image">Selecionar Foto</label>
                    <input type='file' class="btn btn-secondary btn-sm" id="image" name="image" />
                    <input class="NFot" for="image" readonly="readonly">


                    <button id="cadastro" type="submit" class="btn btn-secondary">Cadastrar</button>
                </div>
              </form>
        </div>
       <?php 
          $stats = 3;
          if(empty($_GET))
          {
              $stats = 3;
          }else
          {
            $stats = $_GET['status'];
          }
        ?>

        @if ($stats == 0)
          <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <?php echo $_GET['msg']; ?>
          </div>
        @elseif($stats == 1)
          <div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <?php echo $_GET['msg']; ?>
          </div>
        @endif

    </div>



<script src="{{asset('js/jquery.js')}}"></script> 
<script src="{{asset('js/apis/usuarios_api/cadastro_usuario.js')}}"></script> 
 @endsection 