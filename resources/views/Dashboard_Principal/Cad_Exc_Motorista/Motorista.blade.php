@extends('Dashboard_Principal.Dashboard_HC', ['current' => 'motorista_add_rem'])
@section('conts')
    <div class="conteudo_cadastro_motorista" id="conteudo_motorista">
        <div class="box_de_cadastro_motorista">
            <div class="header_cadastr_motorista">
                <i class="fa fa-edit mr-2 text-light" style="font-size: 20px;"></i>
                <h4 class="font-weight-light text-light mb-0">Cadastro / Exclusão de Motoristas</h4>
            </div>
            <div class="body_cadastro_motorista">
                <form action=""  style="width: 100%; display:flex; justify-content: center;">
                  @csrf
                    <div class="form_cadastro_motorista">
                        <div class="form-group d-flex justify-content-center wid">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Nome Motorista: </label>
                            <div class="col-sm-5">
                              <input name="nome" type="text" class="form-control nome_motorista" id="staticEmail" >
                            </div>
                            
                            <div class="col-sm-3">
                              <button id="add_motorista" type="button" onclick="cadastrar()" class="btn btn-secondary">Adicionar</button>
                            </div>
                          </div>
                    </div>
                </form>
				<div class="header_cadastr_motorista">
                    <i class="fas fa-search mr-2 text-light" style="font-size: 20px;"></i>
                    <h4 class="font-weight-light text-light mb-0">Buscar Motorista</h4>
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
                <table class="table table-bordered table-striped table-sm mt-2" style="border-radius: 12px">
                    <thead class="bg-secondary text-light">
                      <tr>
                        <th scope="col" class="font-weight-light text-center align-middle">ID</th>
                        <th scope="col" class="font-weight-light text-center align-middle">Nome Motorista</th>
                        <th scope="col" class="font-weight-light text-center align-middle">Status</th>
                        <th scope="col" class="acoes font-weight-light text-center align-middle">Ações</th>
                      </tr>
                    </thead>
                    <tbody id="corpo_tabela_motorista">
                      
                      
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
                  <h4><i class="fa fa-user text-light"></i> Desabilitar/Habilitar Motorista</h4>
                  <span class="close" style="margin-bottom: -3px" onclick="modalClose()">&times;</span>
                </div>
                <div class="modal-body">
                  <label for="staticEmail" class="col-sm-3 col-form-label">Motivo: </label>
                  <div class="col-sm-12">
                    <input name="nome" type="text" class="form-control nome_motorista" id="edit_tipo" >
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-danger" onclick="modalClose()">Não</button>
                  <button class="btn btn-secondary" onclick="excludeMotorista(); ">Sim</button>
                </div>
              </div>
              
            </div>
            {{-- MODAL EXCLUIR --}}

            {{-- MODAL Editar --}}
            <div id="myModal3" class="modal">
              <div class="modal-content" id="content_modal_edit">
                <div class="modal-header" >
                  <h4><i class="fa fa-edit text-light"></i> Editar Motorista</h4>
                  <span id="close1" class="close" style="margin-bottom: -3px" onclick="modalClose1()">&times;</span>
                </div>
                <div class="modal-body">
                  <label for="staticEmail" class="col-sm-3 col-form-label">Nome Motorista: </label>
                            <div class="col-sm-12">
                              <input name="nome" type="text" class="form-control nome_motorista" id="edit_mot" >
                            </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-danger" onclick="modalClose1()">Fechar</button>
                  <button class="btn btn-secondary" onclick="editMotorista(); modalClose1();">Editar</button>
                </div>
              </div>
              
            </div>
            {{-- MODAL EXCLUIR --}}


            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
            <script src="{{asset('js/jquery.js')}}"></script>
            <script src="{{asset('js/success_or_error.js')}}"></script>
            <script src="{{asset('js/apis/motorista_api/cadastro_Motorista.js')}}"></script>
            <script src="{{asset('js/apis/motorista_api/excluir_motorista.js')}}"></script>
            <script src="{{asset('js/apis/motorista_api/editar_Motorista.js')}}"></script>
@endsection