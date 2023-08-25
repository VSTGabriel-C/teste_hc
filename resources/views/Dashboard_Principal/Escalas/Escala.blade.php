@extends('Dashboard_Principal.Dashboard_HC', ['current' => "nova_escala"])

@section('conts')
<link rel="stylesheet" href="{{ asset('css/escalas.css') }}">
<div class="container_escalas">
    <div class="pagina_em_construcao d-none">
        <h4><i class="fa fa-cog"></i> Modulo em construção.</h4>
        <p>Este modulo será liberado após o treinamento sobre ele :)</p>
    </div>
    <div class="container_form_escalas ">
        <div class="abas_controle">
            <div class="aba1">
                Gerar Escala
            </div>
            <div class="aba2">
                Gestao de Escala
            </div>
        </div>
        <div class="container_form  pl-5 pr-5 pt-5 pb-1">

            <form class="row " page=1 id="formulario">
                <div class="form-row">

                  <div class="col-md-3 mb-3">
                    <label for="identify">Indentificação: </label>
                    <input type="text" class="form-control font-weight-bold" id="identify" placeholder="Digite uma identificação para esta escala" required>
                  </div>

                  <div class="d-flex flex-column col-ml-5 col-md-3  ">
                    <label for="dt_ini" class="align-self-start"
                        style="margin:10px 10px 0px 0px">Data de inicio:</label>
                    <input type="text" name="dt_ini" class="form-control font-weight-bold datepicker" id="dt_ini" required maxlength="10">
                  </div>

                  <div class="d-flex flex-column col-ml-4 col-md-3  ">
                    <label for="hr_ini" style="margin:10px 10px 0px 0px">Hora inicio:</label>
                    <input name="hr_ini" id="hr_ini" type="text" class="form-control font-weight-bold"
                    required maxlength="5">
                  </div>

                  <div class="d-flex flex-column  col-md-3  ">
                    <label for="hora_final" style="margin:10px 10px 0px 0px">Hora fim:</label>
                    <input name="hora_final" id="hora_final" type="text" class="form-control font-weight-bold"
                    required maxlength="5">
                  </div>
                  <div class="d-flex flex-column col-md-12  mb-3">
                    <label for="hora_final" style="margin:10px 10px 0px 0px">Deseja salvar esta escala?:</label>
                  </div>

                  <div class="form-check form-check-inline col-md-1">
                    <input readonly checked class="form-check-input" type="radio" name="save_escala" id="save_escala" value="sim">
                    <label class="form-check-label" for="save_escala">Sim</label>
                  </div>
                  <div class="form-check form-check-inline col-md-3">
                    <input disabled readonly  class="form-check-input" type="radio" name="save_escala" id="not_save_escala" value="nao">
                    <label class="form-check-label" for="not_save_escala">Não</label>
                  </div>

                </div>
                <div class="form-row ">
                    <div class="col-6 mb-1">
                        <label for="motorista_id">Adicionar/Remover motorista/Veiculo </label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6 mb-3">
                        <button class="btn btn-danger btn-sm mr-2 " id="remove" disabled type="submit"><i class="fa fa-minus mb-0"></i></button>
                        <button class="btn btn-success btn-sm" id="add" type="submit"><i class="fa fa-plus"></i></button>
                    </div>

                </div>
                <div class="form-row" id="container_motoristas_e_veiculos">

                    <div class="col-5 mb-3">
                        <label for="motorista_id">Motorista</label>
                        <select class="form-control " name="motorista_id" id="motorista_id" aria-describedby="motorista_id" required>
                            <option selected disabled value="">Escolha</option>
                        </select>
                    </div>
                    <div class="col-5 mb-3">
                        <label for="veiculo_id">Veiculo(s)</label>
                        <select class="form-control"  name="veiculo_id[]" id="veiculo_id" aria-describedby="veiculo_id" required>
                        </select>
                    </div>
                    <div class="col-2 mb-3">
                        <label for="horarioMotEscala">Horário</label>
                        <input class="form-control"  name="horarioMot" id="horarioMotEscala" aria-describedby="horarioMotEscala" placeholder="hh x hh" required>

                    </div>

                </div>
                <div class="col-md-12 mb-3 d-flex justify-content-end cadEscalaDiv">
                    <button class="btn btn-secondary"  type="submit" id="cad_new_escala">Cadastrar</button>
                </div>

            </form>


            <div class="gestao_escala d-none" id="gestao" page=2>
                <div class="container_filter_escalas">
                    <div class="form-row col-12 d-flex justify-content-center">
                        <div class="d-flex flex-column col-ml-6 col-md-3 escal_gestaoPesq">
                            <label for="dt_search" class="align-self-start"
                                style="margin:10px 10px 0px 0px">Data da escala:</label>
                            <input type="text" name="dt_search" class="form-control font-weight-bold datepicker" id="dt_search" required maxlength="10">
                        </div>
                        <div class="col-3 mb-4 escal_gestaoPesq">
                            <label for="active_s_n">Escala ativa?</label>
                            <select class="form-control " name="active_s_n" id="active_s_n" aria-describedby="active_s_n" required>

                                <option  value="1" selected>Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                        <div class="col-3 mb-0 mt-2 escal_gestaoPesq">
                            <button class="btn btn-secondary mt-4" id="procurar_escalas">Procurar</button>
                        </div>
                    </div>
                </div>

                <div class="container_scrollable">
                    <div class="container_escalas_show">

                    </div>

                </div>
            </div>
        </div>
        <div class="loader-wrapper" id="meu_loader_escala">
            <div class="loader"></div>
            <p class="loader-text">Aguarde o carregamento</p>
        </div>

    </div>
</div>

<div class="modal_escalas d-none" id="modal_escala" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal_escalas_interno d-none" id="editar_escalas_modal">
        <div class="header_modal_escalas">
            <h5><i class="fa fa-edit mr-2"></i> Editar Escalas</h5>
            <i class="fa fa-times text-light mr-3" id="icone-fechar-modal-edit"></i>
        </div>
        <div class="body_modal_escalas">
            <div class="container_form_modal pl-5 pt-3 pr-2 pb-3">
                <form class="row" id="form-edit">
                    <div class="form-row">

                        <div class="col-md-3 mb-3">
                            <label for="identify_edit">Indentificação: </label>
                            <input type="text" class="form-control font-weight-bold edit_text" id="identify_edit" placeholder="Digite uma identificação para esta escala" required>
                        </div>

                        <div class="d-flex flex-column col-ml-5 col-md-3  ">
                            <label for="dt_ini_edit" class="align-self-start"
                                style="margin:10px 10px 0px 0px">Data de inicio:</label>
                            <input type="text"  name="dt_ini_edit" class="form-control font-weight-bold edit_text" id="dt_ini_edit"  maxlength="10">
                        </div>

                        <div class="d-flex flex-column col-ml-4 col-md-3  ">
                            <label for="hr_ini_edit" style="margin:10px 10px 0px 0px">Hora inicio:</label>
                            <input name="hr_ini_edit"  id="hr_ini_edit" type="text" class="form-control font-weight-bold edit_text"
                            required maxlength="10">
                        </div>

                        <div class="d-flex flex-column  col-md-3  ">
                            <label for="hora_final_edit" style="margin:10px 10px 0px 0px">Hora fim:</label>
                            <input name="hora_final_edit"  id="hora_final_edit" type="text" class="form-control font-weight-bold edit_text"
                            required maxlength="10">
                        </div>
                    </div>
                    <div class="form-row" id="container_mot_vei_edit">

                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal_escalas_interno d-none" id="visualizar_escalas">
        <div class="header_modal_escalas">
            <h5><i class="fa fa-eye mr-2"></i> Vizualização Escalas </h5>
            <i class="fa fa-times text-light mr-3" id="icone-fechar-modal-visualize"></i>
        </div>
        <div class="body_modal_escalas">
            <div class="container_form_modal pl-5 pt-3 pr-2 pb-3">

                <form class="row " page=1 id="form-visu">
                    <div class="form-row">

                      <div class="col-md-3 mb-3">
                        <label for="identify_visualize">Indentificação: </label>
                        <input type="text" class="form-control font-weight-bold" readonly id="identify_visualize" placeholder="Digite uma identificação para esta escala" required>
                      </div>

                      <div class="d-flex flex-column col-ml-5 col-md-3  ">
                        <label for="dt_ini_visualize" class="align-self-start"
                            style="margin:10px 10px 0px 0px">Data de inicio:</label>
                        <input type="text" readonly name="dt_ini_visualize" class="form-control font-weight-bold" id="dt_ini_visualize"  maxlength="10">
                      </div>

                      <div class="d-flex flex-column col-ml-4 col-md-3  ">
                        <label for="hr_ini_visualize" style="margin:10px 10px 0px 0px">Hora inicio:</label>
                        <input name="hr_ini_visualize" readonly id="hr_ini_visualize" type="text" class="form-control font-weight-bold"
                        required maxlength="5">
                      </div>

                      <div class="d-flex flex-column  col-md-3  ">
                        <label for="hora_final_visualize" style="margin:10px 10px 0px 0px">Hora fim:</label>
                        <input name="hora_final_visualize" readonly id="hora_final_visualize" type="text" class="form-control font-weight-bold"
                        required maxlength="5">
                      </div>
                      <div class="d-flex flex-column col-md-12  mb-3">
                        <label for="hora_final" style="margin:10px 10px 0px 0px">Deseja salvar esta escala?:</label>
                      </div>

                      <div class="form-check form-check-inline col-md-1">
                        <input class="form-check-input" disabled type="radio" name="save_escala" id="save_escala_visualize" value="sim">
                        <label class="form-check-label font-weight-bold"  for="save_escala_visualize">Sim</label>
                      </div>
                      <div class="form-check form-check-inline col-md-3">
                        <input class="form-check-input" disabled type="radio" name="save_escala_visualize" id="not_save_escala_visualize" value="nao">
                        <label class="form-check-label font-weight-bold"  for="not_save_escala_visualize">Não</label>
                      </div>

                    </div>
                    <div class="form-row" id="container_mot_vei_visualize">

                    </div>

                </form>
            </div>
        </div>
        <div class="footer_modal_escalas">

        </div>
    </div>
</div>

<script src="{{ asset('js/apis/escalas/escala.js') }}"></script>

@endsection
