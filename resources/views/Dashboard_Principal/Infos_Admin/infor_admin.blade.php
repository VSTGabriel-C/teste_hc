@extends('Dashboard_Principal.Dashboard_HC', ['current' => 'infos'])
@section('conts')

<div class="container_geral_infos">

    <div class="container_cards">
        <div class="cards">
        <div class="cards_infos1 mb-3">
            <div class="container-interno-card">
                <div class="textos_contss">
                    <div class="first_text">
                        <h5 id="sol_diario"></h5>
                    </div>
                    <div class="second_text">
                        <h5><b>Numero diario de solicitações.</b></h5>
                    </div>
                </div>
                <div class="icone_contss">
                    <i class="fa fa-file-alt"></i>
                </div>
            </div>
            <div class="container_text_button1">
                <a href="#ModalDiaria"><i class="fa fa-arrow-circle-right"></i> Mais informações</a>
            </div>
        </div>
        <div class="cards_infos2">
            <div class="container-interno-card">
                <div class="textos_contss">
                    <div class="first_text">
                        <h5 id="sol_realizados"></h5>
                    </div>
                    <div class="second_text">
                        <h5><b>Transportes Realizados(Ano).</b></h5>
                    </div>
                </div>
                <div class="icone_contss">
                    <i class="fa fa-truck"></i>
                </div>
            </div>
            <div class="container_text_button4">
                <a href="#ModalRealizados"><i class="fa fa-arrow-circle-right"></i> Mais informações</a>
            </div>
        </div>
        <div class="cards_infos2">
            <div class="container-interno-card">
                <div class="textos_contss">
                    <div class="first_text">
                        <h5 id="sol_concluida"></h5>
                    </div>
                    <div class="second_text">
                        <h5><b>Numero de Solicitações concluidas(Dia).</b></h5>
                    </div>
                </div>
                <div class="icone_contss">
                    <i class="fa fa-check"></i>
                </div>
            </div>
            <div class="container_text_button2">
                <a href="#ModalConcluidas"><i class="fa fa-arrow-circle-right"></i> Mais informações</a>
            </div>
        </div>
        <div class="cards_infos3">
            <div class="container-interno-card">
                <div class="textos_contss">
                    <div class="first_text">
                        <h5 id="sol_andamento"></h5>
                    </div>
                    <div class="second_text">
                        <h5><b>Numero de Solicitações em andamento.</b></h5>
                    </div>
                </div>
                <div class="icone_contss">
                    <i class="fa fa-road" style="font-size: 60px;"></i>
                </div>
            </div>
            <div class="container_text_button3">
                <a href="#ModalAndamento"><i class="fa fa-arrow-circle-right"></i> Mais informações</a>
            </div>
        </div>
        {{-- <div class="cards_infos4" >
            <div class="container-interno-card">
                <div class="textos_contss">
                    <div class="first_text">
                        <h5 id="qnt_instituto"></h5>
                    </div>
                    <div class="second_text">
                        <h5><b>Quantidade por Instituto.</b></h5>
                    </div>
                </div>
                <div class="icone_contss">
                    <i class="fa fa-hospital" ></i>
                </div>
            </div>
            <div class="container_text_button4">
                <a href=""><i class="fa fa-arrow-circle-right"></i> Mais informações</a>
            </div>
        </div> --}}
        <div class="cards_infos4" >
            <div class="container-interno-card">
                <div class="textos_contss">
                    <div class="first_text">
                        <h5 id="qnt_cancelamento"></h5>
                    </div>
                    <div class="second_text">
                        <h5><b>Qnt por Cancelamento.</b></h5>
                    </div>
                </div>
                <div class="icone_contss">
                    <i class="fa fa-times-circle" ></i>
                </div>
            </div>
            <div class="container_text_button4">
                <a href="#ModalCancelamento"><i class="fa fa-arrow-circle-right"></i> Mais informações</a>
            </div>
        </div>
        <div class="cards_infos4" >
            <div class="container-interno-card">
                <div class="textos_contss">
                    <div class="first_text">
                        <h5 id="qnt_quiloA"></h5>
                    </div>
                    <div class="second_text">
                        <h5><b>Alta Quilometragem.</b></h5>
                    </div>
                </div>
                <div class="icone_contss">
                    <i class="fa fa-triangle-exclamation"></i>
                </div>
            </div>
            <div class="container_text_button4">
                <a href="#ModalQuilometragem"><i class="fa fa-arrow-circle-right"></i> Mais informações</a>
            </div>
        </div>
    </div>
</div>
</div>


        {{-- <div class="cards_infos3">
            <div class="container-interno-card">
                <div class="textos_contss">
                    <div class="first_text">
                        <h5><b>08</b></h5>
                    </div>
                    <div class="second_text">
                        <h5><b>Quantidade de veiculos disponiveis.</b></h5>
                    </div>
                </div>
                <div class="icone_contss">
                    <i class="fa fa-ambulance" style="font-size: 60px;"></i>
                </div>
            </div>
            <div class="container_text_button3">
                <a href=""><i class="fa fa-arrow-circle-right"></i> Mais informações</a>
            </div>
        </div>
        <div class="cards_infos3 mb-3">
            <div class="container-interno-card">
                <div class="textos_contss">
                    <div class="first_text">
                        <h5><b>03</b></h5>
                    </div>
                    <div class="second_text">
                        <h5><b>Numero de Solicitações canceladas.</b></h5>
                    </div>
                </div>
                <div class="icone_contss">
                    <i class="fa fa-times-circle" style="font-size: 60px;"></i>
                </div>
            </div>
            <div class="container_text_button3">
                <a href=""><i class="fa fa-arrow-circle-right"></i> Mais informações</a>
            </div>
        </div> --}}

    </div>
    <div class="container_grafos_listas">
        <div class="segundo_container">
            <div class="conts_grafico">
                <div id="h_g" class="header_grafico">
                    <div class="header_text">
                        <h6><i class="fa fa-file mr-1"></i>Solicitações por dia</h6>
                    </div>
                    <div class="header_text2">
                        <h6 id="minus"><i class="fa fa-minus mr-1"></i></h6>
                    </div>
                    <div class="header_icon">

                    </div>
                </div>
                <div id="meu_graf" class="meu_grafico">
                    <canvas id="myChart" class="canva1"></canvas>
                </div>
            </div>


        </div>
        <div class="terceiro_container">
            <div class="conts_grafico2">
                <div id="h_g2" class="header_grafico2">
                    <div class="header_text">
                        <h6><i class="fa fa-chart-pie mr-1"></i>Solicitações Overview</h6>
                    </div>
                    <div class="header_text2_2">
                        <h6 id="minus2"><i class="fa fa-minus mr-1"></i></h6>
                    </div>
                    <div class="header_icon">

                    </div>
                </div>
                <div id="meu_graf2" class="meu_grafico2">
                    <canvas id="myChart2" class="canva1"></canvas>
                </div>
            </div>
            <div class="conts_grafico mt-3 mb-2">
                <div id="h_g4" class="header_grafico">
                    <div class="header_text">
                        <h6><i class="fa fa-chart-bar mr-1"></i>Kilometros por dia</h6>
                    </div>
                    <div class="header_text2">
                        <h6 id="minus4"><i class="fa fa-minus mr-1"></i></h6>
                    </div>
                    <div class="header_icon">

                    </div>
                </div>
                <div id="meu_graf4" class="meu_grafico">
                    <canvas id="myChart3" class="canva1"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modal Diaria --}}
<div class="modal" id="modalDiaria">
    <div class="modal-content" id="content_modal_Diaria">

        <div class="modal-header">
            <h5 class="Modal-title">Solicitações de Hoje</h5>
            <button type="button" id='fecharX1' class="close">
                <span class="close" style="margin-bottom: -3px">&times;</span>
            </button>
        </div>

        <div id="cont_diaria" class="modal-body">

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" id='fecharDiaria'>Fechar</button>
        </div>

    </div>
</div>
{{-- Final Modal Diaria --}}

{{-- Modal Concluidas --}}
<div class="modal" id="modalConcluidas">
    <div class="modal-content" id="content_modal_Concluidas" >

        <div class="modal-header">
            <h5 class="Modal-title">Solicitações Concluidas</h5>
            <button type="button" id='fecharX2' class="close">
                <span class="close" style="margin-bottom: -3px">&times;</span>
            </button>
        </div>

        <div id="cont_concluidas"class="modal-body">


        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" id='fecharConcluidas'>Fechar</button>
        </div>

    </div>
</div>
{{-- Final Modal Concluidas --}}

{{-- Modal Andamento --}}
<div class="modal" id="modalAndamento">
    <div class="modal-content" id="content_modal_Andamento">

        <div class="modal-header">
            <h5 class="Modal-title">Solicitações em Andamento</h5>
            <button type="button" id='fecharX3' class="close">
                <span class="close" style="margin-bottom: -3px">&times;</span>
            </button>
        </div>

        <div id="cont_andamento" class="modal-body">

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" id='fecharAndamento'>Fechar</button>
        </div>

    </div>
</div>
{{-- Final Modal Andamento --}}

{{-- Modal Cancelamento --}}
<div class="modal" id="modalCancelamento">
    <div class="modal-content" id="content_modal_Cancelamento">

        <div class="modal-header">
            <h5 class="Modal-title">Solicitações Canceladas</h5>
            <button type="button" id='fecharX4' class="close">
                <span class="close" style="margin-bottom: -3px">&times;</span>
            </button>
        </div>

        <div id="cont_Cancelamento" class="modal-body">

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" id='fecharCancelamento'>Fechar</button>
        </div>

    </div>
</div>
{{-- Final Modal Cancelamento --}}

{{-- Modal Quilometragem --}}
<div class="modal" id="modalQuilometragem">
    <div class="modal-content" id="content_modal_Quilometragem">

        <div class="modal-header">
            <h5 class="Modal-title">Alta Quilometragem</h5>
            <button type="button" id='fecharX5' class="close">
                <span class="close" style="margin-bottom: -3px">&times;</span>
            </button>
        </div>

        <div id="cont_quilometragem" class="modal-body">

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" id='fecharQuilometragem'>Fechar</button>
        </div>

    </div>
</div>
{{-- Final Modal Quilometragem --}}

{{-- Modal Realizados --}}
<div class="modal" id="modalRealizados">
    <div class="modal-content" id="content_modal_Realizados" style="margin-left:345px;">

        <div class="modal-header">
            <h5 class="Modal-title">Alta Quilometragem</h5>
            <button type="button" id='fecharX6' class="close">
                <span class="close" style="margin-bottom: -3px">&times;</span>
            </button>
        </div>

        <div id="cont_realizados" class="modal-body">
            <div class="trocagraf" id="grafyearsel">
                <select id="grafyear" style="width: 5%;" class="selectyeargraf custom-select custom-select-sm" required="" name="grafyear">
            </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" id='fecharRealizados'>Fechar</button>
        </div>

    </div>
</div>
{{-- Final Realizados --}}




<script type="module" src="{{asset('js\chart\ModalsInfo.js')}}"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <script src="{{ asset('js/slick/setup.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="module" src="{{ asset('js/chart/Chart.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="module" src="{{ asset('js/chart/Chart.js') }}"></script>






 @endsection
