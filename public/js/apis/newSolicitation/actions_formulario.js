$(function () {
    chargeComboSolicitante()
    chargeComboMotorista()
    chargeComboVeiculos()
    $.datepicker.regional['pt-BR'] =
    {
        closeText: 'Fechar',
        prevText: '&#x3c;Anterior',
        nextText: 'Pr&oacute;ximo&#x3e;',
        currentText: 'Hoje',
        monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
        'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
        'Jul','Ago','Set','Out','Nov','Dez'],
        dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
        dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 0,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

    $('.datepicker').datepicker();

    $("#solicitantes").on("change",(e)=>
    {
        var solicitante_preview = $("#solicitantes").find(':selected')[0].text;
        $('#sol_nome_m')[0].value = solicitante_preview;
    })


})
var contadorDestinos = 1;
var botaoRemoverAnterior = null;

function adicionarDestino() {
  if (contadorDestinos <= 4) {
    var destinoInput = document.getElementById("FormDestino");
    var novoDestinoInput = destinoInput.cloneNode(true);
    novoDestinoInput.value = "";

    var destinoLabel = document.querySelector("label[for='FormDestino']");
    var novoDestinoLabel = destinoLabel.cloneNode(true);
    novoDestinoLabel.textContent = "Destino " + (contadorDestinos + 1);

    var novoDestinoId = "FormDestino" + (contadorDestinos + 1);
    novoDestinoInput.id = novoDestinoId;
    novoDestinoInput.name = novoDestinoId;
    novoDestinoLabel.setAttribute("for", novoDestinoId);

    var destinoInputGroup = destinoInput.parentNode.parentNode;
    destinoInputGroup.appendChild(novoDestinoLabel);

    var novoDestinoInputGroup = document.createElement("div");
    novoDestinoInputGroup.className = "input-group" + " FormDestino" + (contadorDestinos + 1);

    var novoDestinoInputGroupAppend = document.createElement("div");
    novoDestinoInputGroupAppend.className = "input-group-append";

    novoDestinoInputGroup.appendChild(novoDestinoInput);
    novoDestinoInputGroup.appendChild(novoDestinoInputGroupAppend);

    destinoInputGroup.appendChild(novoDestinoInputGroup);

    var botaoRemover = document.createElement("button");
    botaoRemover.type = "button";
    botaoRemover.className = "btn btn-danger btn-circle btn-sm btnRemDest";
    botaoRemover.style.zIndex = "auto";
    botaoRemover.style.width = "25px"; // Defina o tamanho desejado aqui
    botaoRemover.innerText = "-";
    botaoRemover.onclick = function() {
      removerDestino(novoDestinoId);
    };

    novoDestinoInputGroupAppend.appendChild(botaoRemover);

    if (botaoRemoverAnterior) {
      botaoRemoverAnterior.style.display = "none";
    }

    botaoRemoverAnterior = botaoRemover;

    contadorDestinos++;
  }
}

function removerDestino(destinoId) {
  console.log(destinoId);
  var inputGroupRemove = document.getElementsByClassName("input-group " + destinoId);
  var destinoLabelToRemove = document.querySelector("label[for='" + destinoId + "']");

  inputGroupRemove[0].remove();
  destinoLabelToRemove.parentNode.removeChild(destinoLabelToRemove);

  contadorDestinos--;

  if (contadorDestinos === 0) {
    botaoRemoverAnterior = null;
  } else {
    var ultimoDestinoId = "FormDestino" + contadorDestinos;
    botaoRemoverAnterior = document.querySelector(".FormDestino" + contadorDestinos + " .btnRemDest");
    botaoRemoverAnterior.style.display = "inline-block";
  }
}

function obterDestinos()
{
    var destinos = [];
    var destinosInputs = document.querySelectorAll("[id^='FormDestino']");
    destinosInputs.forEach(function(input) {
      destinos.push(input.value);
    });

    return destinos;
}

function verificarArray(array)
{
    if (Array.isArray(array) && array.length > 0) {
      var filteredArray = array.filter(function(element) {
        return element !== '' && element !== null && element !== undefined;
      });

      if (filteredArray.length > 1) {
        return filteredArray.join(';');
      } else {
        return filteredArray[0];
      }
    } else {
      return '';
    }
}

function verificarDestinosAdicionados() {
    var destinoInputs = document.querySelectorAll(".input-group:not(:first-of-type) [name^='FormDestino']");
    var destinoLabels = document.querySelectorAll("label[for^='FormDestino']:not([for='FormDestino'])");

    for (var i = 0; i < destinoInputs.length; i++) {
      var destinoInput = destinoInputs[i];
      var destinoLabel = destinoLabels[i];

      destinoInput.closest('.input-group').remove();
      destinoLabel.parentNode.removeChild(destinoLabel);
    }

    contadorDestinos = 1;
  }





let ano_atual = new Date().getFullYear()
$("#data_soli").mask("##/##/####");
$("#hora_sol").mask("##:##");

$("#sol_saida").mask("##:##");
$("#n_ficha").mask("####/####");
$("#enviar").on("click", function (e)
{
    let destinos = obterDestinos();

    modalClose10()

    var select = document.getElementById('solicitantes');
    var text = select.options[select.selectedIndex].text;
    var oxigenio_validation = $('#oxigenio').val();
    var obeso_validation = $('#obeso').val();
    var isolete_validation = $('#isolete').val();
    var maca_validation = $('#maca').val();
    var isolamento_val = $('#ISO').val();
    var obito_validation = $('#obito').val();
    var km_validation = $('#sol_km').val();
    var hora_validation = $('#sol_saida').val();
    var data_validation = $('#data_soli').val();
    var horaS_validation = $('#hora_sol').val();
    var nome_paciente = $('#nome_paciente_m').val();
    var ramal_sol = $('#ramal_sol_m').val();
    var carro = $('#carro_disp_m').val();
    var origem = $('#end_m').val();
    var destino = $('#destino_m').val();
    var motorista = $('#nome_mot_m').val();
    var contato = $('#contato_m').val();
    var solicitante = $('#sol_nome_m').val();
    var atendida_por = $('#atendida_m').val();
    var ida_m = document.getElementById("ida_m")
    var n_ficha = document.getElementById("n_ficha").value


    if (nome_paciente == '') {
        modalClose10();
        var p = $(`<div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            Erro ao Enviar: Nome do paciente é um campo obrigatório.
            </div>`);
        p.hide()
        $('.body_form_geral').append(p);
        p.fadeIn(500, function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 4000)
        });
        return false;
    }
    if (n_ficha === '') {
        modalClose10();
        var p = $(`<div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            Erro ao Enviar: O numero da ficha deve ser informado.
            </div>`);
        p.hide()
        $('.body_form_geral').append(p);
        p.fadeIn(500, function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 4000)
        });
        return false;
    }
    if (ida_m.checked === false) {
        modalClose10();
        var p = $(`<div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            Erro ao Enviar: O campo de ida deve ser selecionado.
            </div>`);
        p.hide()
        $('.body_form_geral').append(p);
        p.fadeIn(500, function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 4000)
        });
        return false;
    }
    if (solicitante == '') {
        modalClose10();
        var p = $(`<div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            Erro ao Enviar: O nome do solicitante é um campo obrigatório.
            </div>`);
        p.hide()
        $('.body_form_geral').append(p);
        p.fadeIn(500, function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 4000)
        });
        return false;
    }

    if (origem == '') {
        modalClose10();
        var p = $(`<div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            Erro ao Enviar: Endereço do transporte é um campo obrigatório.
            </div>`);
        p.hide()
        $('.body_form_geral').append(p);
        p.fadeIn(500, function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 4000)
        });
        return false;
    }
    if (destino == '') {
        modalClose10();
        var p = $(`<div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            Erro ao Enviar: Destino do transporte é um campo obrigatório.
            </div>`);
        p.hide()
        $('.body_form_geral').append(p);
        p.fadeIn(500, function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 4000)
        });
        return false;
    }
    if (ramal_sol == '') {
        modalClose10();
        var p = $(`<div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            Erro ao Enviar: Ramal do solicitante é um campo obrigatório.
            </div>`);
        p.hide()
        $('.body_form_geral').append(p);
        p.fadeIn(500, function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 4000)
        });
        return false;
    }
    if (horaS_validation == '') {
        modalClose10();
        var p = $(`<div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            Erro ao Enviar: Hora da solicitação é um campo obrigatório.
            </div>`);
        p.hide()
        $('.body_form_geral').append(p);
        p.fadeIn(500, function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 4000)
        });
        return false;
    }
    if (carro == '') {
        modalClose10();
        var p = $(`<div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            Erro ao Enviar: O carro deve ser informado.
            </div>`);
        p.hide()
        $('.body_form_geral').append(p);
        p.fadeIn(500, function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 4000)
        });
        return false;
    }

    let datasplit = data_validation.split('/')
    ano = Date.parse(datasplit[2])
    const dataAtual = new Date();
    const anoAtual = dataAtual. getFullYear();
    ano_atual = Date.parse(anoAtual)
    if(data_validation != '' && ano != ano_atual)
    {
        modalClose10();
        var p = $(`<div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            Erro ao Enviar: Ano da solicitação é diferente do ano atual.
            </div>`);
        p.hide()
        $('.body_form_geral').append(p);
        p.fadeIn(500, function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 4000)
        });
        return false;
    }
    if (data_validation == '') {
        modalClose10();
        var p = $(`<div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            Erro ao Enviar: Data da solicitação é um campo obrigatório.
            </div>`);
        p.hide()
        $('.body_form_geral').append(p);
        p.fadeIn(500, function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 4000)
        });
        return false;
    }

    if (km_validation == '' || hora_validation == '') {
        modalClose10();
        var p = $(`<div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            Erro ao Enviar: Horário de Saida e KM Inicial são campos obrigatórios.
            </div>`);
        p.hide()
        $('.body_form_geral').append(p);
        p.fadeIn(500, function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 4000)
        });
        return false;
    }
    if (contato == '') {
        modalClose10();
        var p = $(`<div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            Erro ao Enviar: O nome do contato é um campo obrigatório.
            </div>`);
        p.hide()
        $('.body_form_geral').append(p);
        p.fadeIn(500, function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 4000)
        });
        return false;
    }
    if (atendida_por == '') {
        modalClose10();
        var p = $(`<div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            Erro ao Enviar: O nome de quem fez a solicitação é um campo obrigatório.
            </div>`);
        p.hide()
        $('.body_form_geral').append(p);
        p.fadeIn(500, function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 4000)
        });
        return false;
    }

    if (motorista == '') {
        modalClose10();
        var p = $(`<div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            Erro ao Enviar: O nome do motorista é um campo obrigatório.
            </div>`);
        p.hide()
        $('.body_form_geral').append(p);
        p.fadeIn(500, function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 4000)
        });
        return false;
    }

    if (oxigenio_validation == null || isolete_validation == null || obeso_validation == null || isolete_validation == null || maca_validation == null || isolamento_val == null || obito_validation == null) {
        modalClose10();
        var p = $(`<div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
               Existem campos obrigatórios não preenchidos.
            </div>`);
        p.hide()
        $('.body_form_geral').append(p);
        p.fadeIn(500, function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 4000)
        });
        return false;
    }

    let hc_val = $('#hc_form:checked').length;
    let incor_val = $('#incor_form:checked').length;
    if (hc_val == 0 && incor_val == 0) {
        modalClose10();
        var p = $(`<div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                Erro ao Enviar: pelo menos um dos institutos deve ser selecionado.
            </div>`);
        p.hide()
        $('#form_geral').append(p);
        p.fadeIn('slow', function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 4000)
        });
        return false
    }




    //PEGANDO TODOS OS CAMPOS

    let idaN = "";
    let utiN = "";
    let hcN = "";
    let incorN = "";
    let ida = document.getElementById('IDA').checked;
    if (ida.checked) {
        idaN = "OK"
    } else {
        idaN = "NOK"
    }
    //PEGANDO DADOS HC INCOR RADIO

    let hc = document.getElementById("hc_form").checked;

    if (hc) {
        hcN = "OK"
    } else {
        hcN = "NOK"
    }

    let incor = document.getElementById("incor_form").checked;

    if (incor) {
        incorN = "OK"
    } else {
        incorN = "NOK"
    }

    let uti1 = document.getElementById('UTI').checked;

    if (uti1) {
        utiN = "OK"
    } else {
        utiN = "NOK"
    }

    if ($("input[name='ret_h']").val() < $("input[name='ch_h']").val()) {
        var p = $(`<div class="alert1">
     <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
     Falha ao editar. A hora de retorno não pode ser menor que a hora de chegada.
     </div>`);
        p.hide()
        $('#conteudo_lista_visualiza').append(p);
        p.fadeIn(500, function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 4000)
        });
        $("input[name='ret_h']").val() = '';
        $("input[name='ch_h']").val() = '';
        return false;
    }
    let port = ''
    let rad = ''
    let obs = ''
    if(document.getElementById("portaria").value === '')
    {
        port = '--'
    }else{
        port = document.getElementById("portaria").value
    }
    if(document.getElementById("RADIO").value === '')
    {
        rad = '--'
    }else{
        rad = document.getElementById("RADIO").value
    }
    if(document.getElementById("obsevacao").value === '')
    {
        obs = '--'
    }else{
        obs = document.getElementById("obsevacao").value
    }

    let n_paciente = document.getElementById('nome_paciente').value;
    let endereco_paciente = document.getElementById('end').value;
    let dest_sol = verificarArray(destinos);
    let port_sol = document.getElementById('portaria').value;
    let dia_soli = $("#data_soli").val();
    let hora_saida = $("input[name='sol_saida']").val();
    let hora_ficha = document.getElementById('hora_sol').value;
    let nome_mot = document.getElementById('nome_mot').value;
    let obs_ficha = document.getElementById('obsevacao').value;
    let plant_controlador = document.getElementById('ATENDIDA').value;
    const selectCarro = document.getElementById("carro_disp");
    const selectedOptionCarro = selectCarro.options[selectCarro.selectedIndex];
    const email_veiculo = selectedOptionCarro.getAttribute("data-id");
    let ramal_sol_R = $("#ramal_sol").val();
    let oxiR = $("#oxigenio").val();
    let obesoR = $("#obeso").val();
    let isoleteR = $("#isolete").val();
    let macaR = $("#maca").val();
    let isolamentoR = $("#ISO").val();
    let isolamentoMotivoR = $("#isolamento").val();
    let obitoR = $("#obito").val();
    let utiR = '';
    if ($('#UTI:checked').length == 1) {
        utiR =  'Sim';
    } else if ($('#UTI:checked').length == 0) {
        utiR =  'Não';
    }



    // const regexPort = /\bportaria\b/gi;
    // if(regexPort.test(port_sol))
    // {
    //     port_sol = port_sol.replace(regexPort, "");
    // }

    $(".conteudos").append(`<div class="carregamento">
                                <div class="content">
                                    <img src="img/Spinner-1s-200px.svg" alt="carregamento">
                                    <h6 style="font-weight: 700;">Por favor aguarde enquanto a ficha é criada e a rota é enviada ao motorista.</h6>
                                </div>
                            </div>`);

    $.ajax(
    {
        method: 'POST',
        url: "https://127.0.0.1:12000/enviar-rota",
        data:
        {
            nome: n_paciente,
            endereco: endereco_paciente,
            destino: dest_sol,
            portaria: port_sol,
            dia: dia_soli,
            hora_ficha: hora_ficha,
            hora_saida: hora_saida,
            nome_mot: nome_mot,
            plantao_controlador: plant_controlador,
            email: email_veiculo,
            uti: utiR,
            obito: obitoR,
            oxigenio: oxiR,
            obeso: obesoR,
            isolete: isoleteR,
            maca: macaR,
            isolamento: isolamentoR,
            motivo: isolamentoMotivoR,
            ramal: ramal_sol_R,
            obs_ficha: obs_ficha,
        },
        success: function (e)
        {
            console.log(e.Success);
            if(e.Success)
            {
                $(".carregamento").remove()
            }

            verificarDestinosAdicionados();

            $.ajax({
                method: 'POST',
                url: url_p+'api/new_solicitation',
                data: {
                    n_paciente: document.getElementById('nome_paciente').value,
                    ida: document.getElementById('IDA').value,
                    data_sol: formatData($("#data_soli").val()),
                    hora_sol: $("input[name='hora_sol']").val(),
                    dest_sol: dest_sol,
                    port_sol: port,
                    end_loc_ident: document.getElementById('end').value,
                    n_ficha_sol: document.getElementById('n_ficha').value,
                    mot_HC: hcN,
                    mot_INCOR: incorN,
                    mot_radio: rad,
                    mot_carro: document.getElementById('carro_disp').value,
                    mot_nome: document.getElementById('nome_mot').value,
                    sol_nome: text,
                    sol_id: $('#solicitantes').val(),
                    ramal_sol: document.getElementById('ramal_sol').value,
                    uti: utiN,
                    oxi: oxigenio_validation,
                    obe: obeso_validation,
                    iso: isolamento_val,
                    mac: maca_validation,
                    amb_isolamento: document.getElementById('ISO').value,
                    amb_iso_qual: document.getElementById('isolamento').value,
                    amb_obito: obito_validation,
                    ida: idaN,
                    sol_saida: $("input[name='sol_saida']").val(),
                    contato: document.getElementById('CONTATO').value,
                    nome_func: document.getElementById('ATENDIDA').value,
                    idUser: document.getElementById('id_user').value,
                    observacao: obs,
                    sol_km: document.getElementById('sol_km').value,
                    id_escala: $("#id_escala_atual").val()
                },
                success: function (e) {
                    let data = JSON.parse(e);
                    if (data.status == 0) {
                        var p = $(`<div class="alert1">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        ${data.msg}
                        </div>`);
                        p.hide()
                        $('#form_geral').append(p);
                        p.fadeIn(500, function () {
                            window.setTimeout(function () {
                                p.fadeOut();
                            }, 2000)
                        });

                    } else if (data.status == 1) {
                        prevFormulario()
                        modalClose10()
                        limparCampos()

                        var p = $(`<div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        ${data.msg}
                        </div>`);
                        p.hide()
                        $('#form_geral').append(p);
                        p.fadeIn('slow', function () {
                            window.setTimeout(function () {
                                p.fadeOut();
                            }, 2000)
                        });

                        document.getElementById('nome_paciente').value = '';
                        let i = document.getElementById('IDA');
                        i.checked = false;
                        $('#solicitantes').val('Escolha').trigger("change");
                        document.getElementById('ramal_sol').value = '';
                        document.getElementById('FormDestino').value = '';
                        document.getElementById('portaria').value = '';
                        document.getElementById('n_ficha').value = '';
                        document.getElementById('end').value = '';
                        document.getElementById('carro_disp').value = '';
                        document.getElementById('nome_mot').value = '';
                        document.getElementById('RADIO').value = '';
                        document.getElementById('oxigenio').value = '';
                        document.getElementById('obeso').value = '';
                        document.getElementById('isolete').value = '';
                        document.getElementById('maca').value = '';
                        document.getElementById('ISO').value = '';
                        document.getElementById('isolamento').value = '';
                        document.getElementById('obito').value = '';
                        document.getElementById('CONTATO').value = '';
                        document.getElementById('ATENDIDA').value = '';
                        document.getElementById('obsevacao').value = '';
                        document.getElementById('sol_km').value = '';
                        document.getElementById('sol_saida').value = '';
                        document.getElementById('data_soli').value = '';
                        document.getElementById('hora_sol').value = '';
                        let u = document.getElementById('UTI')
                        u.checked = false;
                        let h = document.getElementById('hc_form')
                        h.checked = false
                        let inc = document.getElementById('incor_form')
                        inc.checked = false
                    }
                }
            })
        }
    })
})

function chargeComboSolicitante() {
    $.ajax({
        method: 'GET',
        url: url_p+'api/solicitante_all_condition',
        success: function (e) {
            var data = JSON.parse(e);
            $('#solicitantes').empty();
            $('#solicitantes').append(`<option value="Escolha" selected  disabled>Escolha</option>`);
            var options = "";
            data.forEach(async function (item, index) {
                await item.forEach(function (item2, index2) {
                    options += `<option  id="optSoli${item2.id}" value="${item2.id}">${item2.nome}</option>`
                })
            })
            $('#solicitantes').append(options);
            $('#solicitantes').select2();

            let text = document.querySelector("#form_geral > div.container_form_geral > div.body_form_geral > form > div:nth-child(5) > div.d-flex.flex-column.col-md-4 > div > span > span.selection");
            let spanselect = document.querySelector("#form_geral > div.container_form_geral > div.body_form_geral > form > div:nth-child(5) > div.d-flex.flex-column.col-md-4 > div > span > span.selection > span");
            let textSpan = document.querySelector("#select2-solicitantes-container");
            let spantext = document.querySelector("#form_geral > div.container_form_geral > div.body_form_geral > form > div:nth-child(5) > div.d-flex.flex-column.col-md-4 > div > span > span.selection > span");
            spantext.style.height = "31px";
            textSpan.style.marginTop = "-7.5px";
            textSpan.style.fontWeight = "200";
            spantext.style.fontWeight = "900";
            spanselect.style.borderColor = "#ced4da";
        }
    })
}

function chargeComboMotorista() {

    fetch(url_p+"api/retrieve-motoristas-by-escala-active",
    {
        method: "GET"
    })
    .then(response => response.json())
    .then(motoristas =>
    {
        if(motoristas.length <= 0)
        {
            $.ajax({
                method: 'GET',
                url: url_p+'api/get_motorista_disponivel',
                success: function (e) {
                    var data = JSON.parse(e);

                    data.forEach(function (item, index) {
                        $('#nome_mot').append(`
                        <option value="${item.nome}">${item.nome}</option>
                        `)

                    })
                }
            })

            return;
        }

        motoristas.forEach(motorista =>
        {
            $('#nome_mot').append(`
                <option value="${motorista.nome_motorista}">${motorista.nome_motorista}</option>
            `)
        })

        return;

    });
}

function chargeComboVeiculos() {

    fetch(url_p+"api/retrieve-veiculos-by-escala-active",
    {
        method: "GET"
    })
    .then(response => response.json())
    .then(veiculos =>
    {
        console.log(veiculos);

        if(veiculos.length <= 0)
        {
            $.ajax({
                method: 'GET',
                url: url_p+'api/get_veiculo_disponivel',
                success: function (e) {
                    var data = JSON.parse(e);

                    data.forEach(function (item, index) {
                        $('#carro_disp').append(`
                            <option data-id="${item.email}" value="${item.pref}">${item.pref}</option>
                        `)
                    })
                }
            })

            return
        }

        veiculos.forEach(veiculo =>
        {
            $('#carro_disp').append(`
                <option data-id="${veiculo.email}" value="${veiculo.pref}">${veiculo.pref}</option>
            `)
        })

    })

}

$('#hc_form').on('click', function () {
    var hc = $('#hc_form:checked').length;
    if (hc === 1) {
        $('#incor_form').attr("disabled", true);
        $('#hc_m').attr("checked", true);
    } else {
        $('#incor_form').attr("disabled", false);
        $('#hc_m').attr("checked", false);
    }
});
$('#incor_form').on('click', function () {
    var incor = $('#incor_form:checked').length;
    if (incor === 1) {
        $('#hc_form').attr("disabled", true);
        $('#incor_m').attr("checked", true);
    } else {
        $('#hc_form').attr("disabled", false);
        $('#incor_m').attr("checked", false);
    }
});

function modalClose10() {
    var modal = document.getElementById("modalForm_Preview");
    modal.style.display = "none";
}

function prevFormulario() {
    var content = document.getElementById("modalForm_Preview");
    var body_modal = document.getElementById("content_modal_prv");
    content.style.display = "block";
    content.style.paddingTop = "75px";
    content.style.paddingLeft = "46px";
    content.style.overflow = "auto"
    body_modal.style.width = "60%";
}


function limparCampos() {

    var entradas = document.querySelectorAll("input[type='text']");
    [].map.call(entradas, entrada => entrada.value = '');
}
jQuery('input[type=number]').on('keyup', function () {
    this.value = this.value.replace(/^0+/, '');
});
