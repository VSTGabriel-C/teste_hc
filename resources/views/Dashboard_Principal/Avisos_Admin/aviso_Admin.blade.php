@extends('Dashboard_Principal.Dashboard_HC', ['current' => 'aviso'])
@section('conts')
    <div class="conteudo_cadastro_avisos" id="conteudo_avisos">
        <div class="box_de_cadastro_avisos">
            <div class="header_cadastr_avisos">
                <i class="fa fa-edit mr-2 text-light" style="font-size: 20px;"></i>
                <h4 class="font-weight-light text-light mb-0">Solicitações em Aberto</h4>
            </div>
            <div class="body_cadastro_avisos">
                @csrf
                <table class="table table-bordered table-striped table-sm mt-2" style="border-radius: 12px">
                    <thead class="table_avisos bg-secondary  text-light">
                        <tr>
                            <th scope="col" class="aviso font-weight-light text-center align-middle">Nº Ficha</th>
                            <th scope="col" class="aviso font-weight-light text-center align-middle">Motorista</th>
                            <th scope="col" class="aviso font-weight-light text-center align-middle">Status</th>
                            <th scope="col" class="aviso font-weight-light text-center align-middle">Solicitante</th>
                            <th scope="col" class="aviso font-weight-light text-center align-middle">Usuário</th>
                            <th scope="col" id= "op" class="aviso font-weight-light text-center align-center">Opções</th>
                        </tr>
                    </thead>
                    <tbody id="corpo_tabela_avisos">

                    </tbody>
                </table>

            </div>
        </div>
    </div>


    <div id="myModal4" class="modal">
    </div>
    {{-- MODAL Editar --}}
    <div id="modal_aviso" class="modal">
    </div>

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
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{asset('js/apis/aviso_api/aviso.js')}}"></script>

@endsection
