var DatModal = new Date(),
dia  = DatModal.getDate().toString(),
diaF = (dia.length == 1) ? '0'+dia : dia,
mes  = (DatModal.getMonth()+1).toString(), //+1 pois no getMonth Janeiro começa com zero.
mesF = (mes.length == 1) ? '0'+mes : mes,
anoF = DatModal.getFullYear();
var DiaMod= anoF+"-"+mesF+"-"+diaF;
let DiaModF =DiaMod.toString();
var arrayMes = new Array(12);
arrayMes[1] = "Janeiro";
arrayMes[2] = "Fevereiro";
arrayMes[3] = "Março";
arrayMes[4] = "Abril";
arrayMes[5] = "Maio";
arrayMes[6] = "Junho";
arrayMes[7] = "Julho";
arrayMes[8] = "Agosto";
arrayMes[9] = "Setembro";
arrayMes[10] = "Outubro";
arrayMes[11] = "Novembro";
arrayMes[12] = "Dezembro";

$('a[href$="#ModalDiaria"]').on( "click", function(e) {
    modalDiarias();
 });
 $('a[href$="#ModalConcluidas"]').on( "click", function(e) {
    modalConcluidas();
 });
 $('a[href$="#ModalAndamento"]').on( "click", function(e) {
    modalAndamento();
 });
 $('a[href$="#ModalCancelamento"]').on( "click", function(e) {
  modalCancelamento();
});
$('a[href$="#ModalQuilometragem"]').on( "click", function(e) {
  modalQuilometragem();
});
$('a[href$="#ModalRealizados"]').on( "click", function(e) {
  modalRealizados();
});
 $("#fecharDiaria").on( "click", function(e) {
    modalClose6();
 });
 $("#fecharX1").on( "click", function(e) {
    modalClose6();
 });
 $("#fecharConcluidas").on( "click", function(e) {
    modalClose7();
 });
 $("#fecharX2").on( "click", function(e) {
    modalClose7();
 });
  $("#fecharAndamento").on( "click", function(e) {
    modalClose8();
 });
 $("#fecharX3").on( "click", function(e) {
    modalClose8();
 });
 $("#fecharCancelamento").on( "click", function(e) {
  modalClose9();
});
$("#fecharX4").on( "click", function(e) {
  modalClose9();
});
$("#fecharQuilometragem").on( "click", function(e) {
  modalClose10();
});
$("#fecharX5").on( "click", function(e) {
  modalClose10();
});
$("#fecharRealizados").on( "click", function(e) {
  modalClose11();
});
$("#fecharX6").on( "click", function(e) {
  modalClose11();
});

 function modalDiarias() {
  $.ajax({
    method: "GET",

    url: url_p+"api/get_Diarias",
    data: {
       data: DiaModF,
    },
    success: function(e)
    {
      var data = JSON.parse(e);
      if(data.status == 0)
      {
        var p = $(`<div class="alert1">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        ${data.msg}
        </div>`);
        p.hide()
        $('#content_modal_Diaria').append(p);          // "appendê-lo" ou "appendar" o <p>
        p.fadeIn(500, function()
        {
            window.setTimeout(function(){
                p.fadeOut();
            },2000)
        });
      }else
      {
        $('.ss').remove()
        $('#cont_diaria').append(`<table class='table table-bordered ss table-sm'>
        <thead>
          <tr class='bg-secondary '>
            <th scope='col'>Hora</th>
            <th scope='col'>Instituição</th>
            <th scope='col'>Endereço</th>
            <th scope='col'>Nº Ficha</th>
            <th scope='col'>Nome Motorista</th>
            <th scope='col'>Nome solicitante</th>
            <th scope='col'>Status</th>
        </tr>
        </thead>
        <tbody id='corpo_lista_diaria'>

        </tbody>
      </table>`);
      data.forEach(function(item)
      {
        item.data.forEach(function(dados)
        {
          $('#corpo_lista_diaria').append(makeTableModalDia(dados));
        })
         })
      }
    }
})
var modal = document.getElementById("modalDiaria");
var conteudo = document.getElementById("content_modal_Diaria");
modal.style.display = "block";
modal.style.paddingTop = "75px";
modal.style.paddingLeft = "100px";
conteudo.style.width = "75%";
}

function modalConcluidas() {
    $.ajax({
        method: "GET",

        url: url_p+"api/get_Concluidas",
        data: {
           data: DiaModF,
        },
        success: function(e)
        {
          var data = JSON.parse(e);
          if(data.status == 0)
          {
            var p = $(`<div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            ${data.msg}
            </div>`);
            p.hide()
            $('#content_modal_Concluidas').append(p);          // "appendê-lo" ou "appendar" o <p>
            p.fadeIn(500, function()
            {
                window.setTimeout(function(){
                    p.fadeOut();
                },2000)
            });
          }else
          {
            $('.ss').remove()
            $('#cont_concluidas').append(`<table class='table table-bordered ss table-sm'>
            <thead>
              <tr class='bg-secondary '>
                <th scope='col'>Hora</th>
                <th scope='col'>Instituição</th>
                <th scope='col'>Endereço</th>
                <th scope='col'>Nº Ficha</th>
                <th scope='col'>Nome Motorista</th>
                <th scope='col col-sm'>Nome solicitante</th>
                <th scope='col'>Status</th>

            </tr>
            </thead>
            <tbody id='corpo_lista_concluidas'>

            </tbody>
          </table>`);
          data.forEach(function(item)
          {
            item.data.forEach(function(dados)
            {
              $('#corpo_lista_concluidas').append(makeTableModalCon(dados));
            })
             })
          }
        }
    })
    var modal = document.getElementById("modalConcluidas");
    var conteudo = document.getElementById("content_modal_Concluidas");
    modal.style.display = "block";
    modal.style.paddingTop = "75px";
    modal.style.paddingLeft = "100px";
    conteudo.style.width = "75%";

}
function modalAndamento() {
  $.ajax({
    method: "GET",

    url: url_p+"api/get_Andamento",
    data: {
       data: DiaModF,
    },
    success: function(e)
    {
      var data = JSON.parse(e);
      if(data.status == 0)
      {
        var p = $(`<div class="alert1">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        ${data.msg}
        </div>`);
        p.hide()
        $('#content_modal_Andamento').append(p);          // "appendê-lo" ou "appendar" o <p>
        p.fadeIn(500, function()
        {
            window.setTimeout(function(){
                p.fadeOut();
            },2000)
        });
      }else
      {
        $('.ss').remove()
        $('#cont_andamento').append(`<table class='table table-bordered ss table-sm'>
        <thead>
          <tr class='bg-secondary '>
            <th scope='col'>Hora</th>
            <th scope='col'>Instituição</th>
            <th scope='col'>Endereço</th>
            <th scope='col'>Nº Ficha</th>
            <th scope='col'>Nome Motorista</th>
            <th scope='col col-sm'>Nome solicitante</th>
            <th scope='col'>Status</th>

        </tr>
        </thead>
        <tbody id='corpo_lista_andamento'>

        </tbody>
      </table>`);
      data.forEach(function(item)
      {
        item.data.forEach(function(dados)
        {
          $('#corpo_lista_andamento').append(makeTableModalAnd(dados));
        })
         })
      }
    }
})
    var modal = document.getElementById("modalAndamento");
    var conteudo = document.getElementById("content_modal_Andamento");
    modal.style.display = "block";
    modal.style.paddingTop = "75px";
    modal.style.paddingLeft = "100px";
    conteudo.style.width = "75%";

}
function modalCancelamento() {
  $.ajax({
    method: "GET",

    url: url_p+"api/get_CancelamentoModal",
    data: {
       data: DiaModF,
    },
    success: function(e)
    {
      var data = JSON.parse(e);
      if(data.status == 0)
      {
        var p = $(`<div class="alert1">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        ${data.msg}
        </div>`);
        p.hide()
        $('#content_modal_Cancelamento').append(p);          // "appendê-lo" ou "appendar" o <p>
        p.fadeIn(500, function()
        {
            window.setTimeout(function(){
                p.fadeOut();
            },2000)
        });
      }else
      {
        $('.ss').remove()
        $('#cont_Cancelamento').append(`<table class='table table-bordered ss table-sm'>
        <thead>
          <tr class='bg-secondary '>
            <th scope='col'>Hora</th>
            <th scope='col'>Instituição</th>
            <th scope='col'>Endereço</th>
            <th scope='col'>Nº Ficha</th>
            <th scope='col'>Nome Motorista</th>
            <th scope='col col-sm'>Nome solicitante</th>
            <th scope='col'>Status</th>

        </tr>
        </thead>
        <tbody id='corpo_lista_Cancelamento'>

        </tbody>
      </table>`);
      data.forEach(function(item)
      {
        item.data.forEach(function(dados)
        {
          $('#corpo_lista_Cancelamento').append(makeTableModalCanc(dados));
        })
         })
      }
    }
})
    var modal = document.getElementById("modalCancelamento");
    var conteudo = document.getElementById("content_modal_Cancelamento");
    modal.style.display = "block";
    modal.style.paddingTop = "75px";
    modal.style.paddingLeft = "100px";
    conteudo.style.width = "75%";

}
function modalQuilometragem() {
  $.ajax({
    method: "GET",
    url: url_p+"api/get_QuilometragemModal",
    success: function(e)
    {
      var data = JSON.parse(e);
      if(data.status == 0)
      {
        var p = $(`<div class="alert1">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        ${data.msg}
        </div>`);
        p.hide()
        $('#content_modal_Quilometragem').append(p);          // "appendê-lo" ou "appendar" o <p>
        p.fadeIn(500, function()
        {
            window.setTimeout(function(){
                p.fadeOut();
            },2000)
        });
      }else
      {
        $('.ss').remove()
        $('#cont_quilometragem').append(`<table class='table table-bordered ss table-sm'>
        <thead>
          <tr class='bg-secondary '>
            <th class="font-weight-light text-center align-middle">Data</th>
            <th class="font-weight-light text-center align-middle">N Ficha</th>
            <th class="font-weight-light text-center align-middle">End/Loc</th>
            <th class="font-weight-light text-center align-middle">Destino</th>
            <th class="font-weight-light text-center align-middle">Confirmação</th>
            <th class="font-weight-light text-center align-middle">KM Inicial</th>
            <th class="font-weight-light text-center align-middle">KM Chegada</th>
            <th class="font-weight-light text-center align-middle">KM Retorno</th>
            <th class="font-weight-light text-center align-middle">Diferença KM</th>
            <th class="font-weight-light text-center align-middle">Status</th>
          </tr>
        </thead>
        <tbody id='corpo_lista_Quilometragem'>

        </tbody>
      </table>`);
      data.forEach(function(item)
      {
        item.data.forEach(function(dados)
        {
          $('#corpo_lista_Quilometragem').append(makeTableModalQuilo(dados));
        })
         })
      }
    }
})
    var modal = document.getElementById("modalQuilometragem");
    var conteudo = document.getElementById("content_modal_Quilometragem");
    modal.style.display = "block";
    modal.style.paddingTop = "75px";
    // modal.style.paddingLeft = "100px";
    conteudo.style.width = "95%";
}
function modalRealizados() {
    var dataAtual = new Date()
    let ano_a = dataAtual.getFullYear()
    let ano_mes_inicial = `${ano_a}-01`
    let primeiro_ano = 2021

  $.ajax({
    method: "GET",
    url: url_p+"api/card_dados_anual",
    data: {
        inicio: ano_mes_inicial,
     },
    success: function(e)
    {
        var data = JSON.parse(e);
        let days_week = [];
        let values = [];
        let days_week2 = [];
        let values2 = [];
        data['quilo'].forEach(function(item, index){
            days_week[index] = arrayMes[item.Mes];
            values[index] = item.Total
        })
        data['reali'].forEach(function(item, index){
            days_week2[index] = arrayMes[item.Mes_realizadas];
            values2[index] = item.solicitacoes_no_dia
        })
        for (let index = primeiro_ano; index <= ano_a; index++) {
            if($(`#optyear${ano_a}`)[0] === null || $(`#optyear${ano_a}`)[0] === undefined)
            {
                $(`#grafyear`).append(`<option id="optyear${index}" value="" selected="">${index}</option>`)
            }
        }

          $('#cont_realizados').append(`<div id="meu_graf5" class="meu_grafico_modal_year">
                                            <div id="graficos" style ="width:50%; height:90%; padding:10px;">
                                                <canvas style="width: 100%;height: 100%;" id="grafyear_canv"></canvas>
                                            </div>

                                            <div class="v-line">
                                            </div>

                                            <div id="graficos" style ="width:50%; height:90%; padding:10px;">
                                                <canvas style="width: 100%;height: 100%;" id="grafyear_canv2"></canvas>
                                            </div>
                                        </div>`);

            const ctx4 = document.getElementById("grafyear_canv");
            const myChart4 = new Chart(ctx4, {
                type: 'bar',
                data: {
                    labels: days_week,
                    datasets: [{
                        label: `Quilometragem - 2022`,
                        data: values,
                        backgroundColor: [
                            'rgba(0, 76, 255, 0.7)',
                            'rgba(0, 137, 77, 0.9)',
                            'rgba(207, 0, 12, 0.8)'
                        ],
                        borderColor: [
                            'rgba(0, 76, 255, 0.7)',
                            'rgba(0, 137, 77, 0.9)',
                            'rgba(207, 0, 12, 0.8)'
                        ],
                        borderWidth: 1,
                    }
                ],
                },
                options: {
                    responsive: true,
                    hover: false
                }
            });
            const ctx5 = document.getElementById("grafyear_canv2");

            const myChart5 = new Chart(ctx5, {
                type: 'bar',
                data: {
                    labels: days_week2,
                    datasets: [{
                        label: `Transportes Realizados - 2022`,
                        data: values2,
                        backgroundColor: [
                            'rgba(0, 76, 255, 0.7)',
                            'rgba(0, 137, 77, 0.9)',
                            'rgba(207, 0, 12, 0.8)'
                        ],
                        borderColor: [
                            'rgba(0, 76, 255, 0.7)',
                            'rgba(0, 137, 77, 0.9)',
                            'rgba(207, 0, 12, 0.8)'
                        ],
                        borderWidth: 1,
                    }
                ],
                },
                options: {
                    responsive: true,
                    hover: false
                }
            });

            $('#grafyear').on( "change", function(e) {
                var select = document.getElementById("grafyear");
                var opcaoTexto = select.options[select.selectedIndex].text;
                $.ajax({
                    method: "GET",
                    url: url_p+"api/card_dados_anual",
                    data: {
                        inicio: `${opcaoTexto}-01`
                        },
                    success: function(e)
                    {
                        console.log(days_week)
                        days_week = [];
                        values = [];
                        days_week2 = [];
                        values2 = [];

                        var data2 = JSON.parse(e);

                        data2['quilo'].forEach(function(item, index){
                            days_week[index] = arrayMes[item.Mes];
                            values[index] = item.Total
                        })
                        data2['reali'].forEach(function(item, index){
                            days_week2[index] = arrayMes[item.Mes_realizadas];
                            values2[index] = item.solicitacoes_no_dia
                        })

                        myChart4.destroy()
                        myChart5.destroy()
                        $('#meu_graf5').remove()
                        $('#cont_realizados').append(`<div id="meu_graf5" class="meu_grafico_modal_year">
                        <div id="graficos" style ="width:50%; height:90%; padding:10px;">
                            <canvas style="width: 100%;height: 100%;" id="grafyear_canv3"></canvas>
                        </div>

                        <div class="v-line">
                        </div>

                        <div id="graficos" style ="width:50%; height:90%; padding:10px;">
                            <canvas style="width: 100%;height: 100%;" id="grafyear_canv4"></canvas>
                        </div>
                        </div>`);

                        const ctx6 = document.getElementById("grafyear_canv3");
                        const myChart6 = new Chart(ctx6, {
                            type: 'bar',
                            data: {
                                labels: days_week,
                                datasets: [{
                                    label: `Quilometragem - 2022`,
                                    data: values,
                                    backgroundColor: [
                                        'rgba(0, 76, 255, 0.7)',
                                        'rgba(0, 137, 77, 0.9)',
                                        'rgba(207, 0, 12, 0.8)'
                                    ],
                                    borderColor: [
                                        'rgba(0, 76, 255, 0.7)',
                                        'rgba(0, 137, 77, 0.9)',
                                        'rgba(207, 0, 12, 0.8)'
                                    ],
                                    borderWidth: 1,
                                }
                            ],
                            },
                            options: {
                                responsive: true,
                                hover: false
                            }
                        });

                        const ctx7 = document.getElementById("grafyear_canv4");

                        const myChart7 = new Chart(ctx7, {
                            type: 'bar',
                            data: {
                                labels: days_week2,
                                datasets: [{
                                    label: `Transportes Realizados - 2022`,
                                    data: values2,
                                    backgroundColor: [
                                        'rgba(0, 76, 255, 0.7)',
                                        'rgba(0, 137, 77, 0.9)',
                                        'rgba(207, 0, 12, 0.8)'
                                    ],
                                    borderColor: [
                                        'rgba(0, 76, 255, 0.7)',
                                        'rgba(0, 137, 77, 0.9)',
                                        'rgba(207, 0, 12, 0.8)'
                                    ],
                                    borderWidth: 1,
                                }
                            ],
                            },
                            options: {
                                responsive: true,
                                hover: false
                            }
                        });


                    }
                })
            })
    }

})

    var modal = document.getElementById("modalRealizados");
    var modalbody = document.getElementById("cont_realizados");
    var conteudo = document.getElementById("content_modal_Realizados");
    modal.style.display = "block";
    modal.style.paddingTop = "60px";
    // modal.style.paddingLeft = "100px";
    conteudo.style.width = "70%";
    conteudo.style.height = "90%";
    modalbody.style.height = "72%";
}
function removeData(chart) {
    chart.data.labels.pop();
    chart.data.datasets.forEach((dataset) => {
        dataset.data.pop();
    });
    chart.update();
}
function addData(chart, label, data) {
    chart.data.labels.push(label);
    chart.data.datasets.forEach((dataset) => {
        dataset.data.push(data);
    });
    chart.update();
}
function modalClose6() {
    var modal = document.getElementById("modalDiaria");
    modal.style.display = "none";
}
function modalClose7() {
    var modal = document.getElementById("modalConcluidas");
    modal.style.display = "none";
}
function modalClose8() {
    var modal = document.getElementById("modalAndamento");
    modal.style.display = "none";
}
function modalClose9() {
  var modal = document.getElementById("modalCancelamento");
  modal.style.display = "none";
}
function modalClose10() {
  var modal = document.getElementById("modalQuilometragem");
  modal.style.display = "none";
}
function modalClose11() {
    $('#meu_graf5').remove()
    $('#grafyear' ).remove()
  var modal = document.getElementById("modalRealizados");
  modal.style.display = "none";
}

function clear() {
}


function makeTableModalDia(dataD)
{
    let table =``
    table += `<tr>
    <th class="text-center align-middle">${dataD.hora}</th>
    <th class="text-center align-middle">${dataD.destino}</th>
    <th class="text-center align-middle">${dataD.ende}</th>
    <th class="text-center align-middle">${dataD.n_ficha}</th>
    <th class="text-center align-middle">${dataD.nome_motorista}</th>
    <th class="text-center align-middle">${dataD.nome_solicitante}</th>
    ${changeStatusD(dataD.retorno, dataD.cancelamento, dataD.ida)}
    </th>
   </tr>`
;
    return table
}
function changeStatusD(ret, canc, ida) {
  var stats = ``
  if (ret == "NOK" && ida == "OK" && canc == "NOK") {
    stats += `<th class='d-flex-align-center text-center align-middle'><span class='badge badge-pill badge-primary text-center align-middle'><i class='fa fa-truck mr-1'></i> Solicitação em Andamento</span></th>`
  } else if (ret == "OK" && ida == "OK" && canc == "NOK") {
    stats += `<th class='d-flex-align-center text-center align-middle'><span class='badge badge-pill badge-success'><i class='fa fa-check-circle mr-1 '></i> Solicitação Concluida</span></th>`
  } else if (ret == "NOK" && ida == "NOK" && canc == "OK") {
    stats += `<th class='d-flex-align-center text-center align-middle'><span class='badge badge-pill badge-danger text-center align-middle'><i class='fa fa-times-circle mr-1'></i>Solicitação Cancelada</span></th>`
  }
  return stats;
}

function makeTableModalCon(dataD)
{
    let table =``
    table += `<tr>
    <th class="text-center align-middle">${dataD.hora}</th>
    <th class="text-center align-middle">${dataD.destino}</th>
    <th class="text-center align-middle">${dataD.ende}</th>
    <th class="text-center align-middle">${dataD.n_ficha}</th>
    <th class="text-center align-middle">${dataD.nome_motorista}</th>
    <th class="text-center align-middle">${dataD.nome_solicitante}</th>
    <th class='d-flex-align-center text-center align-middle'><span class='badge badge-pill badge-success'><i class='fa fa-check-circle mr-1 '></i> Solicitação Concluida</span></th>
    </th>
   </tr>`
;
    return table
}

function makeTableModalAnd(dataD)
{
    let table =``
    table += `<tr>
    <th class="text-center align-middle">${dataD.hora}</th>
    <th class="text-center align-middle">${dataD.destino}</th>
    <th class="text-center align-middle">${dataD.ende}</th>
    <th class="text-center align-middle">${dataD.n_ficha}</th>
    <th class="text-center align-middle">${dataD.nome_motorista}</th>
    <th class="text-center align-middle">${dataD.nome_solicitante}</th>
    <th class='d-flex-align-center text-center align-middle'><span class='badge badge-pill badge-primary text-center align-middle'><i class='fa fa-truck mr-1'></i> Solicitação em Andamento</span></th>
    </th>
   </tr>`
;
    return table
}
    function makeTableModalCanc(dataD)
{
    let table =``
    table += `<tr>
    <th class="text-center align-middle">${dataD.hora}</th>
    <th class="text-center align-middle">${dataD.destino}</th>
    <th class="text-center align-middle">${dataD.ende}</th>
    <th class="text-center align-middle">${dataD.n_ficha}</th>
    <th class="text-center align-middle">${dataD.nome_motorista}</th>
    <th class="text-center align-middle">${dataD.nome_solicitante}</th>
    <th class='d-flex-align-center text-center align-middle'><span class='badge badge-pill badge-danger text-center align-middle'><i class='fa fa-times-circle mr-1'></i>Solicitação Cancelada</span></th>
    </th>
   </tr>`
;
    return table
}
function makeTableModalQuilo(dataD)
{
  let diferenca = 0

    diferenca = dataD.vt_kilometro - dataD.sol_km

    let table =``
    table += `<tr>
    <th class="text-center align-middle">${dataD.data_solicitacao}</th>
    <th class="text-center align-middle">${dataD.numero_ficha}</th>
    <th class="text-center align-middle">${dataD.End_Loc_ident}</th>
    <th class="text-center align-middle">${dataD.destino}</th>
    <th class="text-center align-middle">${dataD.atendida_por}</th>
    <th class="text-center align-middle">${dataD.sol_km}</th>
    <th class="text-center align-middle">${dataD.ch_kilometro}</th>
    <th class="text-center align-middle">${dataD.vt_kilometro}</th>
    <th class="text-center align-middle">${diferenca}</th>
    <th class='d-flex-align-center text-center align-middle'><span class='text-weight-light badge badge-pill badge-warning text-center align-middle'><i class="fa fa-triangle-exclamation"></i> Alta Quilômetragem</th>
    </th>
   </tr>`
;
    return table
}
