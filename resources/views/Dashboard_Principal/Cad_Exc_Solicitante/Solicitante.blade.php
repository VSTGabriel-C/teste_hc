@extends('Dashboard_Principal.Dashboard_HC', ['current' => 'solicitante_add_rem'])
@section('conts')
<div class="conteudo_cadastro_motorista" id="conteudo_solicitante">
    <div class="box_de_cadastro_motorista">
        <div class="header_cadastr_motorista">
            <i class="fa fa-edit mr-2 text-light" style="font-size: 20px;"></i>
            <h4 class="font-weight-light text-light mb-0">Cadastro / Exclusão de Solicitantes</h4>
        </div>
        <div class="body_cadastro_motorista">
            
            <div class="formulario_add_motorista">
                <form action="">
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                          <label for="validationCustom01">N° MATRICULA:</label>
                          <input name="n_mat" type="text" class="form-control" id="validationCustom01" placeholder="Digite o n° da matricula." required>
                          <div class="valid-feedback">
                            Looks good!
                          </div>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label for="validationCustom01">RAMAL:</label>
                          <input name="ramal" type="text" class="form-control" id="validationCustom02" placeholder="Digite o ramal." required>
                          <div class="valid-feedback">
                            Looks good!
                          </div>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label for="validationCustom01">NOME:</label>
                          <input name="nome" type="text" class="form-control" id="validationCustom03" placeholder="Digite o nome." required>
                          <div class="valid-feedback">
                            Looks good!
                          </div>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label for="validationCustom01">SOBRENOME:</label>
                          <input name="nome" type="text" class="form-control" id="validationCustom05" placeholder="Digite o sobrenome." required>
                          <div class="valid-feedback">
                            Looks good!
                          </div>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label for="validationCustom01">EMAIL:</label>
                          <input name="email" type="text" class="form-control" id="validationCustom04" placeholder="Digite o email" required>
                          <div class="valid-feedback">
                            Looks good!
                          </div>
                        </div>
                        <div class="col-md-12 mb-3 d-flex justify-content-end ">
                          <button type="button" class="btn btn-sm btn-secondary col-sm-2" onclick="newSolicitante()">Cadastrar</button>
                        </div>
                      </div>
                </form>
            </div>
			<div class="header_cadastr_motorista">
                    <i class="fas fa-search mr-2 text-light" style="font-size: 20px;"></i>
                    <h4 class="font-weight-light text-light mb-0">Buscar Solicitante</h4>
                </div>
                <div id="cont_lista" class="body_conteudo_lista">
                    <div class="bPesqSolici">
                        <form action="" class="col-md-12">
                            <input id="pesq" type="text" class="form-control" placeholder="Digite para buscar"
                                aria-label="Pesquisa" aria-describedby="basic-addon1">
                        </form>
                    </div>
                </div>
            <hr>
            <table class="table table-sm table-bordered mt-2" style="border-radius: 12px">
                <thead class="bg-secondary text-light">
                  <tr>
                    <th scope="col" class="font-weight-light text-center align-middle">N° MATRICULA</th>
                    <th scope="col" class="font-weight-light text-center align-middle">NOME</th>
                    <th scope="col" class="font-weight-light text-center align-middle">RAMAL</th>
                    <th scope="col" class="font-weight-light text-center align-middle">EMAIL</th>
                    <th scope="col" class="font-weight-light text-center align-middle" class="acoes">AÇÕES</th>
                  </tr>
                </thead>
                <tbody id="corpo_tabela_solicitante">

                </tbody>
              </table>
              <div class="acabo" id="acabo">
                <button class="btn btn-danger mr-1 btn-sm" name="ant" id="ant">Anterior</button>
                <button class="btn btn-secondary btn-sm" name="prox" id ="prox">Próxima</button>
                </div>
        </div>
    </div>
</div>

{{-- MODAL EXCLUIR --}}
<div id="myModal" class="modal">
  <div class="modal-content" id="content_modal_e">
    <div class="modal-header" >
      <h4><i class="fa fa-trash text-light"></i> Habilitar/Desabilitar Solicitante</h4>
      <span class="close" style="margin-bottom: -3px" onclick="modalClose()">&times;</span>
    </div>
    <div class="modal-body">
      <label for="staticEmail" class="col-sm-3 col-form-label">Motivo: </label>
      <div class="col-sm-12">
        <input name="nome" type="text" class="form-control nome_motorista" id="edit_mot" >
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-danger" onclick="modalClose()">Não</button>
      <button class="btn btn-secondary" onclick="excludeSolicitante();">Sim</button>
    </div>
  </div>
  
</div>
{{-- MODAL EXCLUIR --}}

{{-- MODAL Editar --}}
<div id="myModal3" class="modal">
  <div class="modal-content" id="content_modal_edit">
    <div class="modal-header" >
      <h4><i class="fa fa-edit text-light"></i> Editar Solicitante</h4>
      <span class="close" style="margin-bottom: -3px" onclick="modalClose2()">&times;</span>
    </div>
    <div class="modal-body">
        <label for="staticEmail" class="col-sm-3 col-form-label">N° Matricula: </label>
          <div class="col-sm-12">
            <input name="nome" type="text" class="form-control nome_motorista" id="edit_mat" >
          </div>
        <label for="staticEmail" class="col-sm-3 col-form-label">Ramal: </label>
          <div class="col-sm-12">
            <input name="nome" type="text" class="form-control nome_motorista" id="edit_ram" >
          </div>
        <label for="staticEmail" class="col-sm-3 col-form-label">Nome: </label>
          <div class="col-sm-12">
            <input name="nome" type="text" class="form-control nome_motorista" id="edit_nome" >
          </div>
        <label for="staticEmail" class="col-sm-3 col-form-label">E-mail: </label>
          <div class="col-sm-12">
            <input name="nome" type="text" class="form-control nome_motorista" id="edit_email" >
          </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-danger" onclick="modalClose2()">Fechar</button>
      <button class="btn btn-secondary" onclick="editSolicitante(); modalClose2();">Editar</button>
    </div>
  </div>
  
</div>
{{-- MODAL EXCLUIR --}}




<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/apis/solicitante_api/cadastro_Solicitante.js')}}"></script>
<script src="{{asset('js/apis/solicitante_api/editar_Solicitante.js')}}"></script>
<script src="{{asset('js/apis/solicitante_api/excluir_Solicitante.js')}}"></script>
@endsection