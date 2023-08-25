@extends('Dashboard_Principal.Dashboard_HC', ['current' => 'relatorios'])
@section('conts')
<div class="container_full_relatorio" id="container_full_relatorio_msg">
    <form method="post" action="{{ route('hc.relatorio') }}"enctype="multipart/form-data" class="formulario_relatorio" target="_blank">
        @csrf
        <div class="container-left-data-hora">
                <div class="first_cont_rel">
                    <div class="datas_hora">
                        <div class="titulo_container_rel">
                            <label for=""><i class="fa fa-calendar"></i> Selecionar Datas</label>
                            <div class="hr_personal"></div>
                        </div>
                        <div class="first_cont_data">
                            <div class="container_de_datas">
                                <div class="titulo_input">
                                    <label for="">Data Inicio:</label>
                                </div>
                                <input class="input_de_data datepicker" type="date" name="data_ini" id="data_ini">
                            </div>
                            <div class="container_de_datas">
                                <div class="titulo_input">
                                    <label for="">Data Fim:</label>
                                </div>
                                <input class="input_de_data datepicker" type="date" name="data_fim" id="data_fim">
                            </div>
                        </div>
                        <div class="first_cont_hora">
                            <div class="container_de_datas">
                                <div class="titulo_input">
                                    <label for="">Hora Inicio:</label>
                                </div>
                                <input class="input_de_hora" type="time" name="hora_ini" id="hora_ini">
                            </div>
                            <div class="container_de_datas">
                                <div class="titulo_input">
                                    <label for="">Hora Fim:</label>
                                </div>
                                <input class="input_de_hora" type="time" name="hora_fim" id="hora_fim">
                            </div>
                        </div>
                        <div class="lista_relatorios mt-2">
                            <div class="titulo_container_rel">
                                <label for=""><i class="fa fa-file"></i> Tipo de Relatório</label>

                                <div class="hr_sinal"></div>
                            </div>
                            <div class="container_select_tip_rel">
                                <div class="titulo_sel_rel">
                                    <label for=""class="mb-0">Selecionar Relatório</label><br>
                                </div>
                                <div class="select_tip_rel">
                                    <select class="select_rel_tip" name="rel_type" id="rel_type">
                                        <option selected disabled>Escolha</option>
                                        <option>Atendimentos Realizados</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="hr_sinal mt-3"></div>
                        <div class="container_btn_rel">
                            <button id="buttonRel" type="submit" class="btn btn-secondary btn-sm button-gerar-xls">Gerar xls</button>
                        </div>
                    </div>
                </div>
        </div>
    </form>
</div>
    <script src="{{ asset('js/apis/relatorio_api/relatorio.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
@endsection


