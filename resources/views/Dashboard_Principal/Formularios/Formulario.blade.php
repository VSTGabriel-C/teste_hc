@extends('Dashboard_Principal.Dashboard_HC', ['current' => 'form'])
@section('conts')

    <?php
    $teste = session()->all();
    ?>

    <input type="hidden" id="id_escala_atual" value="<?php echo $escala_id?>" name="input_name" style="display: none;">
    <div id="form_geral" class="conteudo_formulario_geral">
        <div class="container_form_geral">
            <div class="header_form_geral">
                <i class="fa fa-edit"></i>
                <h5 class="">Transporte de Paciente</h5>
            </div>

            <div class="body_form_geral">
                <form class="needs-validation" method="post" action="{{ route('hc.api.newSolicitation') }}" autocomplete="off" novalidate>
                    @csrf
                    <div class="form-row">
                        <div class="col-12 ">
                            <h5 for="validationCustom01" class="titulos">Dados da Ocorrência</h5>
                        </div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="col-md-8">
                            <label for="validationCustom01" style="margin: 10px 5px 0px 0px">Nome do Paciente</label>
                            <input type="text" class="form-control form-control-sm" name="n_paciente" id="nome_paciente"
                                placeholder="Digite o nome do paciente" required>
                        </div>
                        <div class="col-md-2">
                            <label for="validationCustom01" style="    margin: -21px 0px 9px 0px;
                                                font-size: x-small;">N° Ficha Controle de
                                Tráfego</label>
                            <input name="n_ficha_sol" type="text" class=" form-control form-control-sm" maxlength="9"
                                id="n_ficha" required>
                        </div>

                        <div class=" custom-checkbox  ml-5  box-box1">
                            <input name="ida" type="checkbox" class="custom-control-input" id="IDA">
                            <label class="custom-control-label" for="IDA">IDA</label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="validationCustom01" style="margin: 10px 5px 0px 0px;">Endereço / Local /
                                Identificação</label>
                            <input name="end_loc_ident" type="text" class="form-control form-control-sm" id="end"
                                placeholder="Endereço / Local / Identificação">

                        </div>
                        <div class="d-flex flex-column col-md-4">
                            <label for="" style="margin:10px 10px 0px 0px">Solicitante(Nome)</label>
                            <div class="input-group-append">
                                <select id="solicitantes" class="custom-select custom-select-sm" style="width: 100% !important" required name="sol_nome">

                                </select>
                                {{-- <button class="  btn_adc" type="button" id="btnadd"
                                    onclick="modalAdcSolic()">Adicionar</button> --}}
                            </div>

                        </div>
                        <div class="col-md-2">
                            <label for="ramal_sol" style="margin: 10px 0px 0px 0px">Ramal</label>
                            <input name="ramal_sol" type="number" class="form-control form-control-sm" id="ramal_sol"
                                required >
                        </div>

                    </div>

                    <div class="form-row">

                        <div class="col-md-2  d-none">
                            <label for="ramal_sol">ID</label>
                            <input name="id_user" type="text" class="form-control" id="id_user"
                                value="<?php echo $teste['idUser']; ?>" required>
                        </div>
                        <div class="col-md-5" style="margin: 5px 0px 0px 0px">
                            <label for="FormDestino" style="margin: 5px 5px 0px 0px">Destino</label>
                            <div class="input-group">
                                <input name="dest_sol" type="text" class="form-control form-control-sm" id="FormDestino" placeholder="Digite o destino">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary btn-circle btn-sm" style="z-index: auto;background-color: #6c757d;border-color: #6c757d;" onclick="adicionarDestino()">
                                        +
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 ">
                            <label for="" style="margin: 10px 5px 0px 0px">Portaria</label>
                            <input name="port_sol" type="text" class="form-control form-control-sm" id="portaria"
                                maxlength="15">
                        </div>
                        <div class="d-flex flex-column col-ml-5 col-md-3  ">
                            <label for="data_soli" class="align-self-start"
                                style="margin:10px 10px 0px 0px">Data</label>
                            <input type="text" name="data_sol" class="form-control form-control-sm datepicker" id="data_soli" required maxlength="10">
                        </div>

                        <div class="d-flex flex-column col-ml-4 col-md-2  ">
                            <label for="hora_sol" style="margin:10px 10px 0px 0px">Hora</label>
                            <input name="hora_sol" id="hora_sol" type="text" class="form-control form-control-sm"
                            required maxlength="5">
                        </div>
                    </div>
                    <div class="form-row" id="destinos-container">

                    </div>
                    <br>
                    <div class="col-md-12 ">
                        <h5 for="validationCustom01" class="titulos">Ambulância</h5>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="uti_div">
                            <div class="custom-checkbox mr-4 ml-5 box-box1">
                                <input name="uti" type="checkbox" class="custom-control-input" id="UTI">
                                <label class="custom-control-label" for="UTI">UTI</label>
                            </div>
                        </div>


                        <div id="oxi" class=" ml-2 mr-2">
                            <label for="" style="margin: 10px 0px 0px 0px">Oxigenio ? *</label>
                            <select id="oxigenio" name="oxi" class="custom-select custom-select-sm" required>
                                <option selected disabled>Escolha</option>
                                <option>Sim</option>
                                <option>Não</option>
                            </select>
                        </div>
                        <div class=" ml-2 mr-2">
                            <label for="" style="margin: 10px 0px 0px 0px">Obeso ? *</label>
                            <select id="obeso" name="obe" class="custom-select custom-select-sm" required>
                                <option selected disabled>Escolha</option>
                                <option>Sim</option>
                                <option>Não</option>
                            </select>
                            <div class="invalid-feedback">Example invalid custom select feedback</div>
                        </div>
                        <div class=" ml-2  mr-2">
                            <label for="" style="margin: 10px 0px 0px 0px">Isolete ? *</label>
                            <select id="isolete" name="iso" class="custom-select custom-select-sm" required>
                                <option selected disabled>Escolha</option>
                                <option>Sim</option>
                                <option>Não</option>
                            </select>
                            <div class="invalid-feedback">Example invalid custom select feedback</div>
                        </div>
                        <div class=" ml-2 mr-2">
                            <label for="" style="margin: 10px 0px 0px 0px">Maca ? *</label>
                            <select id="maca" name="mac" class="custom-select custom-select-sm" required>
                                <option selected disabled>Escolha</option>
                                <option>Sim</option>
                                <option>Não</option>
                            </select>
                            <div class="invalid-feedback">Example invalid custom select feedback</div>
                        </div>
                    </div>
                </form>
                <div class="form-row">

                    <div class="col-md-2">
                        <label for="" style="margin: 10px 0px 0px 0px">Isolamento ? *</label>
                        <select id="ISO" name="amb_isolamento" class="custom-select custom-select-sm" required>
                            <option selected disabled>Escolha</option>
                            <option>Sim</option>
                            <option>Não</option>
                        </select>
                        <div class="invalid-feedback">Example invalid custom select feedback</div>
                    </div>
                    <div class="col-md-8">
                        <label for="validationCustom01" style="margin: 10px 0px 0px 0px">Qual ?</label>
                        <input id="isolamento" name="amb_iso_qual" type="text" class="form-control form-control-sm"
                            id="" placeholder="Digite o motivo do isolamento">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="obito_div">
                        <label for="" style="margin: 10px 0px 0px 0px">Obito ? *</label>
                        <select id="obito" name="amb_obito" class="custom-select custom-select-sm" required>
                            <option selected disabled>Escolha</option>
                            <option>Sim</option>
                            <option>Não</option>
                        </select>
                        <div class="invalid-feedback">Example invalid custom select feedback</div>
                    </div>
                </div>
                <br>
                <div class="col-md-12 ">
                    <h5 for="validationCustom01" class="titulos">Dados do Veículo</h5>
                </div>
                <hr>

                <div class="form-row">
                    <div class=" col-md-4">
                        <label for="" style="margin: 10px 0px 0px 0px">Motorista</label>
                        <select id="nome_mot" name="mot_nome" class="custom-select custom-select-sm" required>
                            <option value="" selected disabled>Escolha</option>
                        </select>
                    </div>
                    <div class=" col-md-3 ">
                        <label for="" style="margin: 10px 0px 0px 0px">Carro</label>
                        <select id="carro_disp" name="mot_carro" class="custom-select custom-select-sm" required>
                            <option value="" selected>Escolha</option>
                        </select>
                    </div>
                    <div class=" custom-checkbox col-md-1 ml-4  box-box1">
                        <input name="mot_HC" type="checkbox" class="custom-control-input" id="hc_form">
                        <label class="custom-control-label" for="hc_form">HC</label>
                    </div>
                    <div class=" custom-checkbox col-md-1 ml-4  box-box1">
                        <input name="mot_INCOR" type="checkbox" class="custom-control-input" id="incor_form">
                        <label class="custom-control-label" for="incor_form">INCOR</label>
                    </div>
                    <div class="col-md-2">
                        <label for="validationCustom01" style="margin: 10px 0px 0px 0px">Radio</label>
                        <input name="mot_radio" type="text" class="form-control form-control-sm" id="RADIO"
                            placeholder="">
                    </div>
                </div>

                <div class="form-row d-flex">
                    <div class="col-md-2 ">
                        <label for="validationCustom01" style="margin: 10px 0px 0px 0px">Saida(Horas) *</label>
                        <input name="sol_saida" id="sol_saida" type="text" class="form-control form-control-sm"
                            required maxlength="5">
                    </div>
                    <div class="col-md-2">
                        <label for="sol_km" style="margin: 10px 0px 0px 0px">KM Inicial *</label>
                        <input name="km" id="sol_km" type="number" class="form-control form-control-sm" required>
                    </div>
                </div>
                <div class="form-row d-flex justify-content-between">
                    <div class="col-md-5">
                        <label for="validationCustom01" style="margin: 10px 0px 0px 0px">Contato Plantão
                            Controlador</label>
                        <input name="contato" type="text" class="form-control form-control-sm" id="CONTATO"
                            placeholder="" required>
                    </div>
                    <div class="col-md-6 ">
                        <label for="validationCustom01" style="margin: 10px 0px 0px 0px">Solicitação Atendida por
                            (Funcionario de Transportes)</label>
                        <input name="nome_func" type="text" class="form-control form-control-sm" id="ATENDIDA"
                            placeholder="Nome do Funcionario" required>
                    </div>
                    <div class="col-md-12">
                        <label for="exampleFormControlTextarea1" style="margin: 10px 0px 0px 0px">Observação</label>
                        <textarea class="form-control" id="obsevacao" name="obs" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-row d-flex justify-content-end" style="padding:10px;">
                    <button class="btn btn-secondary" id="prevCad" onclick="prevFormulario()">Visualizar</button>
                </div>
                </form>
            </div>
        </div>

        {{-- MODAL AdcSolic --}}
        <div class="modal" id="modalAS">
            <div class="modal-content" id="content_modal_adcSolic">

                <div class="modal-header">
                    <h5 class="Modal-title">Adicionar Solicitante</h5>
                    <button type="button" class="close" onclick="modalClose6();">
                        <span class="close" style="margin-bottom: -3px" onclick="modalClose6()">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <label for="staticEmail" class="col-sm-3 col-form-label">N° Matricula: </label>
                    <div class="col-sm-12">
                        <input name="nome" type="text" class="form-control nome_motorista" id="adc_cod">
                    </div>
                    <label for="staticEmail" class="col-sm-3 col-form-label">Ramal: </label>
                    <div class="col-sm-12">
                        <input name="nome" type="text" class="form-control nome_motorista" id="adc_ramal">
                    </div>
                    <label for="staticEmail" class="col-sm-3 col-form-label">Nome: </label>
                    <div class="col-sm-12">
                        <input name="nome" type="text" class="form-control nome_motorista" id="adc_nome">
                    </div>
                    <label for="staticEmail" class="col-sm-3 col-form-label">Sobrenome: </label>
                    <div class="col-sm-12">
                        <input name="sobrenome" type="text" class="form-control nome_motorista" id="adc_sobrenome">
                    </div>
                    <label for="staticEmail" class="col-sm-3 col-form-label">E-mail: </label>
                    <div class="col-sm-12">
                        <input name="nome" type="text" class="form-control nome_motorista" id="adc_email">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="modalClose6();">Cancelar</button>
                    <button class="btn btn-secondary" id="btnAD" onclick=" adcSolicitante();">Adicionar</button>
                </div>

            </div>
        </div>

        {{-- End MODAL AdcSolic --}}

        {{-- Modal Preview --}}
        <div class="modal" id="modalForm_Preview">
            <div class="modal-content" id="content_modal_prv">
                <div class="modal-header">
                    <h5 class="Modal-title">Preview Formulário</h5>
                    <button type="button" class="close" onclick="modalClose10();">
                        <span class="close" style="margin-bottom: -3px"
                            onclick="modalClose10()">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class=" d-flex flex-column  col-md-10">
                            <label for="validationCustom01" for="nome_paciente_m">Nome do Paciente: </label>
                            <input type="text" class="  " name="nome_paciente_m" id="nome_paciente_m"
                                size=60; disabled>
                        </div>
                        <div class=" custom-checkbox box-box1  " style="margin: 9px 2px -8px 78px">
                            <input name="ida_m" type="checkbox" class="ida custom-control-input" id="ida_m" disabled>
                            <label class=" custom-control-label" for="ida_m">IDA</label>
                        </div>
                        <div class="d-flex flex-column col-ml-5 col-md-3 ">
                            <label for="data_soli_m" class="lign-self-start"
                                style="margin:10px 10px 0px 0px">Data</label>
                            <input type="text" name="data_soli_m" class="datepicker" id="data_soli_m" disabled>
                        </div>
                        <div class="d-flex flex-column col-ml-4 col-md-2  ">
                            <label for="hora_m" style="margin:10px 0px 0px 0px">Hora</label>
                            <input name="hora_m" type="text" class=" " id="hora_m" disabled>
                        </div>
                        <div class="d-flex flex-column col-md-5">
                            <label for="sol_nome_m" style="margin:10px 10px 0px 0px">Solicitante(Nome)</label>
                            <input name="sol_nome_m" type="text" class=" " id="sol_nome_m" size=27;
                                disabled>
                        </div>
                        <div class="col-md-2">
                            <label for="ramal_sol_m" style="display:block; margin: 10px 0px 0px 0px">Ramal</label>
                            <input name="ramal_sol_m" type="text" class="" size=10; id="ramal_sol_m"
                                disabled>
                        </div>
                        <div class="d-flex flex-column col-md-4">
                            <label for="end_m" style="margin: 10px 5px 0px 0px;">Origem</label>
                            <input name="end_m" type="text" size=15; id="end_m" disabled>
                        </div>
                        <div class="col-md-2 d-flex flex-column" style="margin: 5px 0px 0px 0px">
                            <label for="portaria_p" style="margin: 5px 5px 0px 0px">Portaria</label>
                            <input name="portaria_p" type="text" id="portaria_p" disabled>
                        </div>
                        <div class="col-md-6 d-flex flex-column" style="margin: 5px 0px 0px 0px">
                            <label for="destino_m" style="margin: 5px 5px 0px 0px">Destino</label>
                            <input name="destino_m" type="text" id="destino_m" disabled>
                        </div>
                        <div class="col-md-6 d-flex flex-column dest2p" style="margin: 5px 0px 0px 0px">
                            <label for="destino_m2" style="margin: 5px 5px 0px 0px">Destino2</label>
                            <input name="destino_m2" type="text" id="destino_m2" disabled>
                        </div>
                        <div class="col-md-6 d-flex flex-column dest3p" style="margin: 5px 0px 0px 0px">
                            <label for="destino_m3" style="margin: 5px 5px 0px 0px">Destino3</label>
                            <input name="destino_m3" type="text" id="destino_m3" disabled>
                        </div>
                        <div class="col-md-6 d-flex flex-column dest4p" style="margin: 5px 0px 0px 0px">
                            <label for="destino_m4" style="margin: 5px 5px 0px 0px">Destino4</label>
                            <input name="destino_m4" type="text" id="destino_m4" disabled>
                        </div>
                        <div class="col-md-6 d-flex flex-column dest5p" style="margin: 5px 0px 0px 0px">
                            <label for="destino_m5" style="margin: 5px 5px 0px 0px">Destino5</label>
                            <input name="destino_m5" type="text" id="destino_m5" disabled>
                        </div>

                    </div>
                    <div class="form-row">

                        <div class="col-md-2  d-none">
                            <label for="ramal_sol">ID</label>
                            <input name="id_user" type="text" class="form-control" id="id_user"
                                value="<?php echo $teste['idUser']; ?>" disabled>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12 ">
                        <h5 for="validationCustom01" class="titulos">Ambulância</h5>
                    </div>
                    <hr>
                    <div class="form-row" style="margin-left: 3%;">
                        <div class="l custom-checkbox mr-4 ml-5 box-box1">
                            <input name="uti_m" id="uti_m" type="checkbox" class="custom-control-input" id="uti_m"
                                disabled>
                            <label class="custom-control-label" for="uti_m">UTI</label>
                        </div>
                        <div class=" ml-2 mr-2">
                            <label for="oxigenio_m" style="margin: 10px 0px 0px 0px">Oxigenio ? </label>
                            <select id="oxigenio_m" name="oxi" class="custom-select custom-select-sm" disabled>
                                <option selected disabled>Escolha</option>
                                <option>Sim</option>
                                <option>Não</option>
                            </select>
                        </div>
                        <div class=" ml-2 mr-2">
                            <label for="obeso_m" style="margin: 10px 0px 0px 0px">Obeso ? *</label>
                            <select id="obeso_m" name="obe" class="custom-select custom-select-sm" disabled>
                                <option selected disabled>Escolha</option>
                                <option>Sim</option>
                                <option>Não</option>
                            </select>

                        </div>
                        <div class=" ml-2  mr-2">
                            <label for="isolete_m" style="margin: 10px 0px 0px 0px">Isolete ? </label>
                            <select id="isolete_m" name="iso" class="custom-select custom-select-sm" disabled>
                                <option selected disabled>Escolha</option>
                                <option>Sim</option>
                                <option>Não</option>
                            </select>
                        </div>
                        <div class=" ml-2 mr-2">
                            <label for="maca_m" style="margin: 10px 0px 0px 0px">Maca ? </label>
                            <select id="maca_m" name="mac" class="custom-select custom-select-sm" disabled>
                                <option selected disabled>Escolha</option>
                                <option>Sim</option>
                                <option>Não</option>
                            </select>
                        </div>
                    </div>
                    </form>
                    <div class="form-row">

                        <div class="col-md-2">
                            <label for="iso_m" style="margin: 10px 0px 0px 0px">Isolamento ? </label>
                            <select id="iso_m" name="amb_isolamento" class="custom-select custom-select-sm" disabled>
                                <option selected disabled>Escolha</option>
                                <option>Sim</option>
                                <option>Não</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label for="isolamento_m" style="margin: 10px 0px 0px 0px">Qual ?</label>
                            <input id="isolamento_m" name="isolamento_m" type="text"
                                class="form-control form-control-sm" disabled>
                        </div>
                        <div class="col-md-2">
                            <label for="obito_m" style="margin: 10px 0px 0px 0px">Obito ? </label>
                            <select id="obito_m" name="amb_obito" class="custom-select custom-select-sm" disabled>
                                <option selected disabled>Escolha</option>
                                <option>Sim</option>
                                <option>Não</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12 ">
                        <h5 for="validationCustom01" class="titulos">Dados do Veículo</h5>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class=" d-flex flex-column col-md-4">
                            <label for="nome_mot_m" style="margin: 10px 0px 0px 0px">Motorista</label>
                            <input name="nome_mot_m" type="text" size="20" id="nome_mot_m" disabled>
                        </div>
                        <div class="d-flex flex-column col-md-4">
                            <label  for="carro_disp_m" style="margin: 10px 0px 0px 0px">Carro</label>
                            <input name="carro_disp_m" type="text" id="carro_disp_m" disabled>

                        </div>
                        <div class=" custom-checkbox col-md-2 ml-5  box-box1">
                            <input name="hc_m" type="checkbox" class=" custom-control-input" id="hc_m" disabled>
                            <label class="custom-control-label" for="hc_m">HC</label>
                        </div>
                        <div class=" custom-checkbox col-md-1 ml-1s  box-box1">
                            <input name="incor_m" type="checkbox" class=" custom-control-input" id="incor_m" disabled>
                            <label class="custom-control-label" for="incor_m">INCOR</label>
                        </div>
                    </div>
                    <div class="form-row ">
                        <div class="col-md-3 d-flex flex-column">
                            <label for="saida_m" style="margin: 10px 0px 0px 0px">Saida(Horas)</label>
                            <input name="saida_m" id="saida_m" type="text" class="" disabled>
                        </div>
                        <div class="col-md-2 d-flex flex-column">
                            <label for="sol_km_m" style="margin: 10px 0px 0px 0px">KM Inicial</label>
                            <input name="sol_km_m" id="sol_km_m" type="number" class="" disabled>
                        </div>
                    </div>
                    <div class="form-row d-flex justify-content-between">
                        <div class="col-md-6">
                            <label for="contato_m" style="display:block; margin: 10px 0px 0px 0px">Contato Plantão
                                Controlador</label>
                            <input name="contato" type="text" style="width: 100%;" id="contato_m" placeholder="" disabled>
                        </div>
                        <div class="col-md-6 ">
                            <label for="atendida_m" style="margin: 10px 0px 0px 0px">Solicitação Atendida por (Funcionario de Transportes)</label>
                            <input name="nome_func" type="text" id="atendida_m" style="width: 100%;" disabled>
                        </div>
                        <div class="col-md-12">
                            <label for="exampleFormControlTextarea1" style="margin: 10px 0px 0px 0px">Observação</label>
                            <textarea class="form-control" id="observacao_m" name="obs_m" rows="3"
                                disabled></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="modalClose10();">Cancelar</button>
                    <button class="btn btn-success" id="enviar">Enviar</button>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="{{ asset('js/apis/solicitante_api/adic_Solicitante.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
        <script src="{{ asset('js/apis/newSolicitation/actions_formulario.js') }}"></script>
        <script src="{{ asset('js/apis/newSolicitation/preview.js') }}"></script>
    @endsection
