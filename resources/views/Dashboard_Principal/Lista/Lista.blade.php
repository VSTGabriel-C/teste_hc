@extends('Dashboard_Principal.Dashboard_HC', ['current' => 'listagem'])
@section('conts')
    <div class="conteudo_lista" id="conteudo_lista_visualiza">
        <div class="header_conteudo_lista">
            <i class="fa fa-eye mr-2 text-light"></i>
            <h5 class="mb-0 text-light">Visualizar Solicitações</h5>
        </div>
        <div id="cont_lista" class="body_conteudo_lista">
            <div class="formulario_de_pesquisa">
              <form action="">
                <div class="form-row">
                  <div class="col-md-3 mb-3">
                    <label for="validationCustom01">N° da Ficha</label>
                    <input type="text" class="form-control" id="validationCustom01" placeholder="Digite o N° da Ficha" maxlength="9">
                    <div class="valid-feedback">
                      Looks good!
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="validationCustom03">Data</label>
                    <input type="text" name="data_pesq" class="form-control datepicker" id="validationCustom03" maxlength="10">
                    <div class="invalid-feedback">
                      Please provide a valid city.
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="">Motorista</label>
                    <select class="custom-select" id="motorist_qual">
                      <option value="" selected disabled>Escolha</option>

                    </select>
                    <div class="invalid-feedback">Example invalid custom select feedback</div>
                  </div>
                  {{-- <div class="mb-3 ml-1">
                    <label for="">Status</label>
                    <select class="custom-select" required>
                      <option value="" selected>Escolha</option>
                      <option value="1">Em Curso</option>
                      <option value="2">Concuido</option>
                    </select>
                    <div class="invalid-feedback">Example invalid custom select feedback</div>
                  </div> --}}
                  <button id="buscar" class="btn btn-secondary botao_enviar" type="button"><i class="fa fa-search mr-1"></i>Buscar</button>
                </div>
              </form>
            </div>

        </div>
        <div class="acabo" id="acabo">
          <button class="btn btn-danger mr-1 btn-sm" style="position:asolute;" name="ant" id="ant">Anterior</button>
          <button class="btn btn-secondary btn-sm" style="position:asolute;" name="prox" id ="prox">Próxima</button>
          </div>
    </div>

    <div id="myModal3" class="modal">
      <div class="modal-content" id="content_modal_edit">
        <div class="modal-header" >
          <h4><i class="fa fa-edit text-light"></i> Sair do Sistema</h4>
          <span class="close" style="margin-bottom: -3px" onclick="modalClose2()">&times;</span>
        </div>
        <div class="modal-body">
            <h4>Você deseja mesmo sair do sistema ?</h4>
        </div>
        <div class="modal-footer">
          <button class="btn btn-danger" onclick="modalClose2()">Não</button>
          <a href="{{route("hc.api.deslogar_user")}}"class="btn btn-secondary" onclick="modalClose2();">Sair</a>
        </div>
      </div>

    </div>
    <div id="myModal3" class="modal">
      <div class="modal-content" id="content_modal_edit">
        <div class="modal-header" >
          <h4><i class="fa fa-edit text-light"></i> Sair do Sistema</h4>
          <span class="close" style="margin-bottom: -3px" onclick="modalClose2()">&times;</span>
        </div>
        <div class="modal-body">
            <h4>Você deseja mesmo sair do sistema ?</h4>
        </div>
        <div class="modal-footer">
          <button class="btn btn-danger" onclick="modalClose2()">Não</button>
          <a href="{{route("hc.api.deslogar_user")}}"class="btn btn-secondary" onclick="modalClose2();">Sair</a>
        </div>
      </div>

    </div>
    <div id="myModal4" class="modal">
    </div>
    <div id="myModal5" class="modal">
    </div>

    {{-- Inicio Modal Excesso de Quilometragem --}}
    <div class="modal" id="modalEx">
      <div class="modal-content" id="content_modalEx">
        <div class="modal-header">
          <h5 class="Modal-title">Excesso de Quilometragem</h5>
          <button type="button" class="close" onclick="fechaModal();">
              <span class="close" style="margin-bottom: -3px" onclick="fechaModal()">&times;</span>
          </button>
      </div>
      <div class="modal-body" id='bEXKM'>

      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" id="btnCEX">Confirmar</button>
          <button type="button" class="btn btn-danger" onclick="fechaModal();">Cancelar</button>
      </div>
    </div>

</div>
{{-- Término da Modal --}}
    {{-- Inicio Modal Excesso de Quilometragem --}}
    <div class="modal" id="modalExP">
      <div class="modal-content" id="content_modalExP">
        <div class="modal-header">
          <h5 class="Modal-title">Excesso de Quilometragem</h5>
          <button type="button" class="close" onclick="fechaModalP();">
              <span class="close" style="margin-bottom: -3px" onclick="fechaModalP()">&times;</span>
          </button>
      </div>
      <div class="modal-body" id='bEXKMP'>

      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" id="btnCEXP">Confirmar</button>
          <button type="button" class="btn btn-danger" onclick="fechaModalP();">Cancelar</button>
      </div>
    </div>

</div>
{{-- Término da Modal --}}


    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    <script src="{{asset('js/apis/pesquisa_solicitacoes/new_Pesq.js')}}"></script>
    <script src="{{asset('js/apis/pesquisa_solicitacoes/pesq_diaria.js')}}"></script>


@endsection
