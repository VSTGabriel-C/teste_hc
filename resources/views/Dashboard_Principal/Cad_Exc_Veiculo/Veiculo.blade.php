@extends('Dashboard_Principal.Dashboard_HC', ['current' => 'veiculo_add_rem'])
@section('conts')
<div class="conteudo_cadastro_motorista" id="cadastro_veic">
    <div class="box_de_cadastro_motorista">
        <div class="header_cadastr_motorista">
            <i class="fa fa-edit mr-2 text-light" style="font-size: 20px;"></i>
            <h4 class="font-weight-light text-light mb-0">Cadastro / Exclusão de Veiculos</h4>
        </div>
        <div class="body_cadastro_motorista">
            
            <div class="formulario_add_motorista">
                <form action="">
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                          <label for="validationCustom01">PREF:</label>
                          <input name="pref" type="text" class="form-control" id="validationCustom01" placeholder="Codigo veiculo." required>
                          <div class="valid-feedback">
                            Looks good!
                          </div>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label for="validationCustom02">PLACA:</label>
                          <input name="placa" type="text" class="form-control" id="validationCustom02" placeholder="Digite a placa do veiculo." required>
                          <div class="valid-feedback">
                            Looks good!
                          </div>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label for="validationCustom03">TIPO:</label>
                          <input name="tipo" type="text" class="form-control" id="validationCustom03" placeholder="Digite o tipo do veiculo." required>
                          <div class="valid-feedback">
                            Looks good!
                          </div>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label for="validationCustom04">MARCA:</label>
                          <input name="marca" type="text" class="form-control" id="validationCustom04" placeholder="Digite a marca do veiculo" required>
                          <div class="valid-feedback">
                            Looks good!
                          </div>
                        </div>
                        <div class="col-md-12 mb-3 d-flex justify-content-end ">
                          <button type="button" class="btn btn-sm btn-secondary col-md-2" onclick="newVeiculo()">Cadastrar</button>
                        </div>
                      </div>
                </form>
            </div>
				<div class="header_cadastr_motorista">
                    <i class="fas fa-search mr-2 text-light" style="font-size: 20px;"></i>
                    <h4 class="font-weight-light text-light mb-0">Buscar Veiculo</h4>
                </div>
                <div id="cont_lista" class="body_conteudo_lista">
                    <div class="bPesqSolici">
                        <form action="" class="col-md-12">
                          <input id="pesq" type="text" class="form-control" placeholder="Digite para buscar" aria-label="Pesquisa"
                        aria-describedby="basic-addon1">
                        </form>
                    </div>
                </div>
            <hr>
            <table class="table table-sm table-striped table-bordered mt-2" style="border-radius: 12px">
                <thead class="bg-secondary text-light">
                  <tr>
                    <th scope="col" class="font-weight-light text-center align-middle">PREF</th>
                    <th scope="col" class="font-weight-light text-center align-middle">PLACA</th>
                    <th scope="col" class="font-weight-light text-center align-middle">TIPO</th>
                    <th scope="col" class="font-weight-light text-center align-middle">MARCA</th>
                    <th scope="col" class="font-weight-light text-center align-middle">STATUS</th>
                    <th scope="col" class="acoes font-weight-light text-center align-middle">AÇÕES</th>
                  </tr>
                </thead>
                <tbody id="corpo_lista_veiculos">
                  
                </tbody>
              </table>
              <div class="acabo" id="acabo">
                <button class="btn btn-danger mr-1 btn-sm" name="ant" id="ant">Anterior</button>
                <button class="btn btn-secondary btn-sm" name="prox" id ="prox">Próxima</button>
                </div>            
        </div>
    </div>
</div>

{{-- MODAL EXCLUIR VEICULO --}}
<div id="myModal" class="modal">
  <div class="modal-content" id="content_modal_e">
    <div class="modal-header" >
      <h4><i class="fa fa-car text-light"></i> Desabilitar/Habilitar Veiculo</h4>
      <span class="close" style="margin-bottom: -3px" onclick="modalClose()">&times;</span>
    </div>
    <div class="modal-body">
      <label for="staticEmail" class="col-sm-3 col-form-label">Motivo: </label>
        <div class="col-sm-12">
          <input name="nome" type="text" class="form-control nome_motorista" id="motivo_veiculo" >
        </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-danger" onclick="modalClose()">Não</button>
      <button class="btn btn-secondary" onclick="excludeVeiculo();">Sim</button>
    </div>
  </div>
  
</div>
{{-- MODAL EXCLUIR VEICULO --}}

{{-- MODAL EDITAR VEICULO --}}
<div id="myModal3" class="modal">
  <div class="modal-content" id="content_modal_edit">
    <div class="modal-header" >
      <h4><i class="fa fa-edit text-light"></i> Editar Veiculo</h4>
      <span class="close" style="margin-bottom: -3px" onclick="modalClose2()">&times;</span>
    </div>
    <div class="modal-body">
      <label for="staticEmail" class="col-sm-3 col-form-label">PREF: </label>
                <div class="col-sm-12">
                  <input name="nome" type="text" class="form-control nome_motorista" id="edit_pref" >
                </div>
                <label for="staticEmail" class="col-sm-3 col-form-label">PLACA: </label>
                <div class="col-sm-12">
                  <input name="nome" type="text" class="form-control nome_motorista" id="edit_placa" >
                </div>
                <label for="staticEmail" class="col-sm-3 col-form-label">TIPO: </label>
                <div class="col-sm-12">
                  <input name="nome" type="text" class="form-control nome_motorista" id="edit_tipo" >
                </div>
                <label for="staticEmail" class="col-sm-3 col-form-label">MARCA: </label>
                <div class="col-sm-12">
                  <input name="nome" type="text" class="form-control nome_motorista" id="edit_marca" >
                </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-danger" onclick="modalClose2()">Fechar</button>
      <button class="btn btn-secondary" onclick="editVeiculo(); modalClose2();">Editar</button>
    </div>
  </div>
  
</div>




{{-- MODAL EDITAR VEICULO --}}
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/apis/veiculos_api/cadastro_Veiculo.js')}}"></script>
<script src="{{asset('js/apis/veiculos_api/excluir_Veiculo.js')}}"></script>
<script src="{{asset('js/apis/veiculos_api/editar_Veiculo.js')}}"></script>
@endsection