var data = new Date(),
dia  = data.getDate().toString(),
diaF = (dia.length == 1) ? '0'+dia : dia,
mes  = (data.getMonth()+1).toString(), //+1 pois no getMonth Janeiro começa com zero.
mesF = (mes.length == 1) ? '0'+mes : mes,
anoF = data.getFullYear();
var diaA= anoF+"-"+mesF+"-"+diaF;
let diab =diaA.toString();

$(function()
{
    $.datepicker.regional['pt-BR'] = {
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
        yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
    Diaria(diab);
    $('.datepicker').datepicker();
    //$('.datepicker').datepicker( "option", "dateFormat", "dd/mm/yy");
})


$("#validationCustom01").mask("####/####")

function Diaria(diaA)
{
number_ficha = '';
data_pesquisa  = diaA
motorista_N   = ''
        $.ajax({
            method: "GET",

            url: url_p+"api/get_solicitations_filterDIA",
            data: {
               n_ficha: number_ficha,
               data: data_pesquisa,
               nome: motorista_N,
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
                $('#conteudo_lista_visualiza').append(p);          // "appendê-lo" ou "appendar" o <p>
                p.fadeIn(500, function()
                {
                    window.setTimeout(function(){
                        p.fadeOut();
                    },2000)
                });
              }else
              {
                $('.ss').remove()
                $('#cont_lista').append(`<table class='table table-bordered ss'>
                <thead>
                  <tr class='bg-secondary'>
                    <th scope='col'>N° Ficha</th>
                    <th scope='col'>Data</th>
                    <th scope='col'>Status</th>
                    <th scope='col'>Opções</th>
                </tr>
                </thead>
                <tbody id='corpo_lista'>

            	</tbody>
              </table>`);
              data.forEach(function(item)
              {
                item.data.forEach(function(dados)
                {
                  $('#corpo_lista').append(makeTableP(dados));
                })
                 })
              }
            }
        })
}

function changeStatusP(ret, canc, ida) {
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
function msgError()
{
    var p = $(`<div class="alert1">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                Entre pelo menos com algum valor valido nos campos !
                </div>`);
                p.hide()
                $('#conteudo_lista_visualiza').append(p);
                p.fadeIn(500, function()
                {
                    window.setTimeout(function(){
                        p.fadeOut();
                    },2000)
                });
}

function makeTableP(dataD)
{
    let dataSolicitacao = dataD.data_solicitacao.replaceAll("-", "/");
    let table =``
    table += `<tr>
    <th class="text-center align-middle" scope='row'>${dataD.numero_ficha}</th>
    <th class="text-center align-middle">${dataSolicitacao}</th>
    ${changeStatusP(dataD.retorno, dataD.cancelamento, dataD.ida)}
    <th class='d-flex justify-content-center'>
        <button value='${dataD.id_solicitacao}' onclick='editSolicitationP(${dataD.id_solicitacao});' type='button' class='btn btn-sm btn-secondary mr-1 myBtnE' id='myBtn2'><i class='fa fa-edit'></i> Editar</button>
        <button value='${dataD.id_solicitacao}' onclick='visualizeSolicitationP(${dataD.id_solicitacao})' type='button' class='btn btn-sm btn-secondary ml-1' id='myBtn'><i class='fa fa-eye'></i> Visualizar</button>
    </th>
   </tr>`
;
    return table
}

function atribuirVisualizarDestinosP(destinos)
{
    console.log("AQ2")
    let divsDestinoV = document.querySelectorAll('.visuaFormDest');
    console.log(divsDestinoV)
    for (let i = 0; i < divsDestinoV.length; i++) {
      let inputDestinoV = divsDestinoV[i].querySelector('input');

      if (i < destinos.length) {
        inputDestinoV.value = destinos[i];
      } else {
        divsDestinoV[i].classList.add('esconde');
      }
    }
}
function atribuirEditarDestinosP(destinos)
{
    let divsDestino = document.querySelectorAll('.editFormDest');

    for (let i = 0; i < divsDestino.length; i++) {
      let inputDestino = divsDestino[i].querySelector('input');

      if (i < destinos.length) {
        inputDestino.value = destinos[i];
      } else {
        divsDestino[i].classList.add('esconde');
      }
    }
}


function editSolicitationP(id)
{
    $.ajax({
        method: 'GET',
        url:  url_p+`api/get_solicitations_filter_by_id/${id}`,
        success: function(e)
        {
          var hc = $('#hc_checkbox').length;
          var incor = $('#incor_checkbox').length;
            let data = JSON.parse(e)
            var v
            $("#content_modal").remove()
            var modal = document.getElementById("myModal4");
            modal.style.display = "block";
            modal.style.paddingTop = "10px";

            let ss = data.forEach(function(value, index)
            {
                v = value
            })
            $("#myModal4").append(makeContentEditP(v))
            atribuirEditarDestinosP(v.destino.split(";"));

            $("#hora_soli").mask("##:##")
            $("#saida_horas").mask("##:##")
            $("#ch_h").mask("##:##")
            $("#ret_h").mask("##:##")
            $("#data_sol_validation").mask("##/##/####")

            $('.datepicker').datepicker();

            $('#hc_checkbox').on('click', function () {
              $("#incor_checkbox")
                  .not(incor)
                  .prop("checked", false)
                  .removeClass("theone")


                  .prop("checked", incor.is(":checked"))
                  .toggleClass("theone");
          });
          $('#incor_checkbox').on('click', function () {
            $("#hc_checkbox")
                  .not(hc)
                  .prop("checked", false)
                  .removeClass("theone")


                  .prop("checked", hc.is(":checked"))
                  .toggleClass("theone");
          });


          $('#cancelamento_check').on('click', function (e) {
              cancelamento_check = $('#cancelamento_check:checked').length;
              $('#retorno_check').prop("checked", false);
              $('#ida_check').prop("checked", false);
              if (cancelamento_check == 0) {
                  $('#ida_check').prop("checked", true);
              }
          });
          $('#retorno_check').on('click', function (e) {
              $('#cancelamento_check').prop("checked", false)
              $('#ida_check').prop("checked", true)
          });
          jQuery('input[type=number]').on('keyup', function () {
            this.value = this.value.replace(/^0+/, '');
          });
      }
  })
}
function visualizeSolicitationP(id)
{
    $.ajax({
        method: 'GET',
        url:  url_p+`api/get_solicitations_filter_by_id/${id}`,
        success: function(e)
        {
            let data = JSON.parse(e)
            var v
            $("#content_modal1").remove()
            var modal = document.getElementById("myModal5");
            modal.style.display = "block";
            modal.style.paddingTop = "10px";

            let ss = data.forEach(function(value, index)
            {
                v = value
                $("#myModal5").append(makeVisualizeP(v))
                atribuirVisualizarDestinosP(v.destino.split(";"));
            })


        }
    })
}


function modalClose1()
{
    var modal = document.getElementById("myModal4");
    modal.style.display = "none";
}
function modalClose()
{
    var modal = document.getElementById("myModal5");
    modal.style.display = "none";
}

function makeContentEditP(data)
{

    let ida = ""
    let hc  = ""
    let retorno = ""
    let uti = ""
    let incor = ""
    let cancelamento = ""

    if (data.cancelamento == "OK") {
        cancelamento = "checked"
    } else if (data.cancelamento == "NOK") {
        cancelamento = ""
    }

    if(data.ida == "OK")
    {
        ida = "checked"
    }else if(data.ida == "NOK")
    {
        ida = ""
    }

    if(data.retorno == "OK")
    {
        retorno = "checked"
    }else if(data.retorno == "NOK")
    {
        retorno = ""
    }

    if(data.uti == "OK")
    {
        uti = "checked"
    }else if(data.uti == "NOK")
    {
        uti = ""
    }

    if(data.hc == "OK")
    {
        hc = "checked"
    }else if(data)
    {
        hc = ""
    }

    if(data.incor == "OK")
    {
        incor = "checked"
    }else if(data)
    {
        incor = ""
    }
    var RamalFD = ''
    if(data.n_ramalN != 0){

      RamalFD = data.n_ramalN;

    }else{

      RamalFD = data.sol_ramal;

    }


    $.ajax({
      method: 'GET',
      url: url_p+'api/get_motorista_disponivel',
      success: function(e)
        {
            var data = JSON.parse(e);

            data.forEach(function(item, index)
            {
                $('#mot_id').append(`
                <option value="${item.nome}">${item.nome}</option>
                `)

            })
        }
    })

    $.ajax({
      method: 'GET',
      url: url_p+'api/get_veiculo_disponivel',
      success: function(e)
      {
          var data = JSON.parse(e);

          data.forEach(function(item, index)
          {
              $('#carro_disp').append(`
              <option value="${item.pref}">${item.pref}</option>
              `)

          })
      }
  })

    var oxigenio = ``
    var obeso = ``
    var isolete = ``
    var maca = ``
    var isolamento = ``
    var obito = ``


  console.log(data)
    if (data.oxigenio == "Sim") {
        oxigenio += `<select id="oxigenio" class="custom-select custom-select-sm" required >
      <option value="Sim" selected>Sim</option>
      <option value="Não">Não</option>
      </select>`
    } else if (data.oxigenio == "Não") {
        oxigenio += `<select id="oxigenio"  class="custom-select custom-select-sm" required >
      <option value="Sim">Sim</option>
      <option value="Não" selected>Não</option>
      </select>`
    } else if (data.oxigenio == "Escolha") {
        oxigenio += `<select id="oxigenio"  class="custom-select custom-select-sm" required >
    <option value="Sim">Sim</option>
    <option value="Não" selected>Não</option>
    </select>`
    }


    if (data.obeso == "Sim") {
        obeso += `<select id="obeso"  class="custom-select custom-select-sm" required >
      <option value="Sim" selected>Sim</option>
      <option value="Não">Não</option>
    </select>`
    } else if (data.obeso == "Não") {
        obeso += `<select id="obeso"  class="custom-select custom-select-sm" required >
      <option value="Sim">Sim</option>
      <option value="Não" selected>Não</option>
      </select>`
    } else if (data.obeso == "Escolha") {
        obeso += `<select id="obeso"  class="custom-select custom-select-sm" required >
      <option value="Sim">Sim</option>
      <option value="Não" selected>Não</option>
      </select>`
    }

    if (data.isolete == "Sim") {
        isolete += `<select id="isolete"  class="custom-select custom-select-sm" required >
      <option value="Sim" selected>Sim</option>
      <option value="Não">Não</option>
    </select>`
    } else if (data.isolete == "Não") {
        isolete += `<select id="isolete"  class="custom-select custom-select-sm" required >
      <option value="Sim">Sim</option>
      <option value="Não" selected>Não</option>
      </select>`
    }

    if (data.maca == "Sim") {
        maca += `<select id="maca"  class="custom-select custom-select-sm" required >
      <option value="Sim" selected>Sim</option>
      <option value="Não">Não</option>
    </select>`
    } else if (data.maca == "Não") {
        maca += `<select id="maca"  class="custom-select custom-select-sm" required >
      <option value="Sim">Sim</option>
      <option value="Não" selected>Não</option>
      </select>`
    }

    if (data.isolamento == "Sim") {
        isolamento += `<select id="ISO"  class="custom-select custom-select-sm" required >
      <option value="Sim" selected>Sim</option>
      <option value="Não">Não</option>
    </select>`
    } else if (data.isolamento == "Não") {
        isolamento += `<select id="ISO"  class="custom-select custom-select-sm" required >
      <option value="Sim">Sim</option>
      <option value="Não" selected>Não</option>
      </select>`
    }

    if (data.obito == "Sim") {
        obito += `<select id="obito"  class="custom-select custom-select-sm" required >
      <option value="Sim" selected>Sim</option>
      <option value="Não">Não</option>
    </select>`
    } else if (data.obito == "Não") {
        obito += `<select id="obito"  class="custom-select custom-select-sm" required >
      <option value="Sim">Sim</option>
      <option value="Não" selected>Não</option>
      </select>`
    }

    var formulario = `
    <div class="modal-content" id="content_modal">
      <div class="modal-header">
        <h3 id="titulo_modal1">Solicitação - ${data.numero_ficha}</h3>
        <span onclick="modalClose1()" class="close2" style="margin-bottom: -3px">&times;</span>
      </div>
      <div class="modal-body">
        <div class="form-row">
        <div class="col-md-7 mb-2">
        <label for="nome_paciente" style ="margin:10px 10px 0px 0px">Nome do Paciente</label>
        <input value="${data.nome_paciente}" type="text" class="form-control form-control-sm" id="nome_paciente" placeholder="Digite o nome do paciente" required >
        <div class="valid-feedback">
          Looks good!
        </div>
      </div>
      <div class="custom-control custom-checkbox col-md-1 ml-3 mb-3 box-box1">
        <input ${ida}  type="checkbox" class="custom-control-input" id="ida_check" disabled >
        <label class="custom-control-label" for="ida_check">IDA</label>
      </div>
      <div class="custom-control custom-checkbox col-md-1 ml-3 mb-3 box-box1">
        <input ${retorno} type="checkbox" class="custom-control-input" id="retorno_check">
        <label class="custom-control-label" for="retorno_check">Retorno</label>
    </div>
    <div class="custom-control custom-checkbox col-md-1 ml-4 mb-3 box-box1">
        <input ${cancelamento} type="checkbox" class="custom-control-input" id="cancelamento_check">
        <label class="custom-control-label" for="cancelamento_check">Cancelar</label>
        </div>
        </div>
        <div class="form-row">
          <div class="col-md-3" >
            <label for="data_sol_validation" style ="margin:10px 10px 0px 0px">Data</label>
            <input value="${trocaBarra(data.data_solicitacao)}" name="data_sol" type="text" class="form-control form-control-sm datepicker" id="data_sol_validation" required autocomplete="off" maxlength="10">
            </input>
          </div>
          <div class="col-md-2">
            <label for="hora_soli" style ="margin:10px 10px 0px 0px">Hora</label>
            <input value="${data.hora_solicitacao}" name="hora_sol" type="text" class="form-control form-control-sm" id="hora_soli" required maxlength="5">
          </div>
          <div class="col-md-3 ml-1">
                <label for="" style ="margin:10px 10px 0px 0px">Solicitante (Nome)</label>
                <select id="solicitantes" name="sol" value="${data.solicitante}"  class="custom-select custom-select-sm" disabled>
                  <option selected disabled readonly>${data.solicitante}</option>
                </select>
              </div>
        <div class="col">
          <label for="validationCustom05" style ="margin:10px 10px 0px 0px">Ramal</label>
          <input id="ramal_sol" value="${RamalFD}" name="ramal_sol" type="text" class="form-control form-control-sm" disabled>
        </div>
        </div>


        <div class="form-row">

            <div class="col-md-2">
              <label for="validationCustom01" style ="margin:10px 10px 0px 0px">Portaria</label>
              <input value="${data.portaria}" type="text" class="form-control form-control-sm" id="portaria"   >
            </div>
            <div class="col">
              <label for="validationCustom01" style ="margin:10px 10px 0px 0px">N° Ficha</label>
              <input value="${data.numero_ficha}" type="text" class="form-control form-control-sm" id="n_ficha">
            </div>

          </div>
        <div class="form-row">

            <div class="col">
              <label for="validationCustom01" style ="margin:10px 10px 0px 0px">Endereço / Local / Identificação</label>
              <input value="${data.End_Loc_ident}" type="text" class="form-control form-control-sm" id="end" placeholder="Endereço / Local / Identificação" required >
            </div>

            <div class="col-md-7 editFormDest">
                <label for="Editdestino" style ="margin:10px 10px 0px 0px">Destino</label>
                <input type="text" class="form-control form-control-sm" id="Editdestino">
            </div>
            <div class="col-md-6 editFormDest">
                <label for="Editdestino2" style ="margin:10px 10px 0px 0px">Destino2</label>
                <input type="text" class="form-control form-control-sm" id="Editdestino2">
            </div>
            <div class="col-md-6 editFormDest">
                <label for="Editdestino3" style ="margin:10px 10px 0px 0px">Destino3</label>
                <input type="text" class="form-control form-control-sm" id="Editdestino3">
            </div>
            <div class="col-md-6 editFormDest">
                <label for="Editdestino4" style ="margin:10px 10px 0px 0px">Destino4</label>
                <input type="text" class="form-control form-control-sm" id="Editdestino4">
            </div>
            <div class="col-md-6 editFormDest">
                <label for="Editdestino5" style ="margin:10px 10px 0px 0px">Destino5</label>
                <input type="text" class="form-control form-control-sm" id="Editdestino5">
            </div>

        </div>
        <hr>
        <div class="form-row">
            <div class="col-md-12 mb-3 mt-2">
              <h5 class="font-weight-bold">Ambulância</h5>
            </div>
        </div>


        <div class="form-row">
            <div class="custom-control custom-checkbox  mr-5 ml-3 mb-5 box-box1">
                <input ${uti} type="checkbox" class="custom-control-input " id="UTI" >
                <label class="custom-control-label" for="UTI">UTI</label>
            </div>
            <div class="mb-2  ml-2">
                <label for="" style ="margin:10px 10px 0px 0px">Oxigenio ?</label>
                ${oxigenio}
                <div class="invalid-feedback">Example invalid custom select feedback</div>
              </div>
            <div class="mb-2 ml-2">
                <label for="" style ="margin:10px 10px 0px 0px">Obeso ?</label>
                ${obeso}
                <div class="invalid-feedback">Example invalid custom select feedback</div>
            </div>
            <div class="mb-2 ml-2">
                <label for="" style ="margin:10px 10px 0px 0px">Isolete ?</label>
                ${isolete}
                <div class="invalid-feedback">Example invalid custom select feedback</div>
            </div>
            <div class="mb-2 ml-2">
                <label for="" style ="margin:10px 10px 0px 0px">Maca ?</label>
                ${maca}
                <div class="invalid-feedback">Example invalid custom select feedback</div>
            </div>
        </div>
        <hr>
        <div class="form-row">
             <div class="mb-2 form-control-sm ">
                <label for="" style ="margin:10px 10px 0px 0px">Isolamento ?</label>
                ${isolamento}
              <div class="invalid-feedback">Example invalid custom select feedback</div>
              </div>
              <div class="col-md-7 mb-3">
                <label for="validationCustom01" style ="margin:10px 10px 0px 0px">Qual ?</label>
                <input value="${data.isolamento_motivo}" type="text" class="form-control form-control-sm" id="isolamento" placeholder="Digite o motivo do isolamento" required >
                <div class="valid-feedback">
                  Looks good!
              </div>
              </div>
              <div class="mb-3" >
                <label for="" style ="margin:10px 10px 0px 0px">Obito ?</label>
                ${obito}
                <div class="invalid-feedback">Example invalid custom select feedback</div>
              </div>
             </div>
             <hr>
          <div class="form-row">

              <div class="mb-3 col-md-4">
                  <label for="" style ="margin:10px 10px 0px 0px">Motorista</label>
                  <select id="mot_id" value="${data.motorista_nome}" class="custom-select custom-select-sm" required disabled>
                    <option selected disabled readonly>${data.motorista_nome}</option>
                  </select>
                </div>
              <div class="mb-3 col-md-2">
                  <label for="" style ="margin:10px 10px 0px 0px">Carro</label>
                  <select id="carro_disp" class="custom-select custom-select-sm" required disabled>
                    <option selected disabled readonly>${data.veiculo_pref}</option>
                  </select>
              </div>
              <div class="custom-control custom-checkbox col-md-1 ml-4 mb-3 box-box1">
              <input ${hc} name="hc_name" type="checkbox" class="custom-control-input" id="hc_checkbox">
              <label class="custom-control-label" for="hc_checkbox">HC</label>
              </div>
              <div class="custom-control custom-checkbox col-md-1 ml-0 mb-3 box-box1">
              <input ${incor} name="incor_name"type="checkbox" class="custom-control-input" id="incor_checkbox" >
              <label class="custom-control-label" for="incor_checkbox" >INCOR</label>
              </div>
              <div class="col-md-2 mb-3">
                  <label for="validationCustom01" style ="margin:10px 10px 0px 0px">Radio</label>
                  <input value="${data.radio}" type="text" class="form-control form-control-sm" id="RADIO" placeholder="" required >
                </div>
          </div>
          <hr>
          <div class="form-row d-flex justify-content-between">
              <div class="col-md-2 mb-3">
                  <label for="validationCustom01" style ="margin:10px 10px 0px 0px">Saida(Horas)</label>
                  <input value="${data.horario_saida}" type="text" name="hora_sai" class="form-control form-control-sm" id="saida_horas" required maxlength="5">
                </div>
              <div class="col-md-3 mb-3">
                  <label for="validationCustom01" style ="margin:10px 10px 0px 0px">Chegada ao destino(Horas)</label>
                  <input value="${data.ch_horario}" name="ch_h" type="text" class="form-control form-control-sm" id="ch_h" required maxlength="5">
                </div>
              <div class="col-md-2 mb-3">
                  <label for="validationCustom01"style ="margin:10px 10px 0px 0px">Retorno ao A5(Horas)</label>
                  <input value="${data.vt_horario}" name="ret_h" type="text" class="form-control form-control-sm" id="ret_h" required maxlength="5">
                </div>
          </div>


          <div class="form-row d-flex justify-content-between">
              <div class="col-md-2 mb-3">
                  <label for="validationCustom01" style ="margin:10px 10px 0px 0px">KM</label>
                  <input name="km" id="sol_km" type="number" class="form-control form-control-sm" required  value="${data.sol_km}">
                  <div class="valid-feedback">
                    Looks good!
                  </div>
                </div>
              <div class="col-md-2 mb-3">
                  <label for="ch_c" style ="margin:10px 10px 0px 0px">KM</label>
                  <input value="${data.ch_kilometro}" type="number" class="form-control form-control-sm" id="ch_c"  >
                  <div class="valid-feedback">
                    Looks good!
                  </div>
                </div>
              <div class="col-md-2 mb-3">
                  <label for="ret_r" style ="margin:10px 10px 0px 0px">KM</label>
                  <input value="${data.vt_kilometro}" type="number" class="form-control form-control-sm" id="ret_r"  >
                  <div class="valid-feedback">
                    Looks good!
                  </div>
                </div>
          </div>
          <hr>

          <div class="form-row d-flex justify-content-between">
              <div class="col-md-4 mb-3">
                  <label for="validationCustom01" style ="margin:10px 10px 0px 0px">Contato Plantão Controlador:</label>
                  <input value="${data.contato_plantao}" type="text" class="form-control form-control-sm" id="CONTATO" placeholder="" required >
                  <div class="valid-feedback">
                    Looks good!
                  </div>
                </div>
              <div class="col-md-5 mb-3">
                  <label for="validationCustom01" style ="margin:10px 10px 0px 0px">Solicitação Atendida por:</label>
                  <input value="${data.atendida_por}" type="text" class="form-control form-control-sm" id="ATENDIDA" placeholder="Nome do Funcionario" required >
                  <div class="valid-feedback">
                    Looks good!
                  </div>
                </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="form-row d-flex justify-content-end">
            <button id="envia" class="btn btn-secondary" onclick="validaKMSP(${data.id_solicitacao});"><i class="fa fa-save mr-2"></i>Salvar</button>
          </div>
        </div>
      </div>`;

        return formulario;
}


function makeVisualizeP(data)
{
    let ida = ""
    let hc  = ""
    let retorno = ""
    let uti = ""
    let incor = ""
    let cancelamento = ""

    if (data.cancelamento == "OK") {
        cancelamento = "checked"
    } else if (data.cancelamento == "NOK") {
        cancelamento = ""
    }

    if(data.ida == "OK")
    {
        ida = "checked"
    }else if(data.ida == "NOK")
    {
        ida = ""
    }

    if(data.retorno == "OK")
    {
        retorno = "checked"
    }else if(data.retorno == "NOK")
    {
        retorno = ""
    }

    if(data.uti == "OK")
    {
        uti = "checked"
    }else if(data.uti == "NOK")
    {
        uti = ""
    }

    if(data.hc == "OK")
    {
        hc = "checked"
    }else if(data)
    {
        hc = ""
    }

    if(data.incor == "OK")
    {
        incor = "checked"
    }else if(data)
    {
        incor = ""
    }
    if(data.n_ramalN != 0){

      RamalFD = data.n_ramalN;

    }else{

      RamalFD = data.sol_ramal;

    }


  var visualize = `<div class="modal-content" id="content_modal1">
  <div class="modal-header">
    <h3>Solicitação - ${data.numero_ficha}</h3>
    <span class="close" onclick="modalClose()" style="margin-bottom: -3px">&times;</span>
  </div>
  <div class="modal-body">
    <div class="form-row">
    <div class="col-md-7  mb-2">
    <label for="validationCustom01" style ="margin:10px 10px 0px 0px">Nome do Paciente</label>
    <input value="${data.nome_paciente}" type="text" class="form-control form-control-sm" id="validationCustom01" placeholder="Digite o nome do paciente" required readonly>
    <div class="valid-feedback">
      Looks good!
    </div>
  </div>
  <div class="custom-control custom-checkbox col-md-1 ml-3 mb-3 box-box1">
    <input ${ida} type="checkbox" class="custom-control-input" id="ida_check" disabled>
    <label class="custom-control-label" for="customCheck">IDA</label>
  </div>
  <div class="custom-control custom-checkbox col-md-1 ml-3 mb-3 box-box1">
     <input ${retorno} disabled type="checkbox" class="custom-control-input" id="retorno_check">
     <label class="custom-control-label" for="retorno_check">Retorno</label>
</div>

<div class="custom-control custom-checkbox col-md-1 ml-4 mb-3 box-box1">
<input ${cancelamento} name="cancel" type="checkbox" class="custom-control-input" id="cancelamento_check">
        <label class="custom-control-label" for="cancelamento_check">Cancelar</label>
    </div>
    </div>
    <div class="form-row">
      <div class="col-md-3">
        <label for="data_soli_v" style ="margin:10px 10px 0px 0px">Data</label>
        <input value="${trocaBarra(data.data_solicitacao)}" type="text" class="form-control form-control-sm" id="data_soli_v" required readonly>
      </div>
      <div class="col-md-2">
        <label for="validationCustom03" style ="margin:10px 10px 0px 0px">Hora</label>
        <input value="${data.hora_solicitacao}" name ="hora_sol" type="text" class="form-control form-control-sm" id="hora_soli" required readonly>
      </div>
      <div class="mb-3 ml-1">
          <label for="" style ="margin:10px 10px 0px 0px">Solicitante (Nome)</label>
          <select id="solicitantes" name="sol" value="${data.solicitante}" class="custom-select custom-select-sm" required disabled readonly>
          <option value="${data.solicitante}">${data.solicitante}</option>
          </select>
        </div>
  <div class="col">
    <label for="validationCustom05" style ="margin:10px 10px 0px 0px">Ramal</label>
    <input disabled readonly id="ramal_sol" value="${RamalFD}" name="ramal_sol" type="text" class="form-control form-control-sm" id="ramal_sol" required>
  </div>
    </div>
    <div class="form-row">
        <div class="col-md-2">
          <label for="validationCustom01" style ="margin:10px 10px 0px 0px">Portaria</label>
          <input value="${data.portaria}" type="text" class="form-control form-control-sm" id="validationCustom01"  required readonly>
          <div class="valid-feedback">
            Looks good!
          </div>
        </div>
        <div class="col">
          <label for="validationCustom01"style ="margin:10px 10px 0px 0px">N° Ficha</label>
          <input value="${data.numero_ficha}" type="text" class="form-control form-control-sm" id="validationCustom01"  required readonly>
          <div class="valid-feedback">
            Looks good!
          </div>
        </div>

      </div>
    <div class="form-row">

        <div class="col">
          <label for="validationCustom01" style ="margin:10px 10px 0px 0px">Endereço / Local / Identificação</label>
          <input value="${data.End_Loc_ident}" type="text" class="form-control form-control-sm" id="validationCustom01" placeholder="Endereço / Local / Identificação" required readonly>
        </div>

        <div class="col-md-7 visuaFormDest">
            <label for="visFormDest" style ="margin:10px 10px 0px 0px">Destino</label>
            <input type="text" class="form-control form-control-sm" id="visFormDest" readonly>
        </div>
        <div class="col-md-6 visuaFormDest">
            <label for="visFormDest2" style ="margin:10px 10px 0px 0px">Destino2</label>
            <input type="text" class="form-control form-control-sm" id="visFormDest2" readonly>
        </div>
        <div class="col-md-6 visuaFormDest">
            <label for="visFormDest3" style ="margin:10px 10px 0px 0px">Destino3</label>
            <input type="text" class="form-control form-control-sm" id="visFormDest3" readonly>
        </div>
        <div class="col-md-6 visuaFormDest">
            <label for="visFormDest4" style ="margin:10px 10px 0px 0px">Destino4</label>
            <input type="text" class="form-control form-control-sm" id="visFormDest4" readonly>
        </div>
        <div class="col-md-6 visuaFormDest">
            <label for="visFormDest5" style ="margin:10px 10px 0px 0px">Destino5</label>
            <input type="text" class="form-control form-control-sm" id="visFormDest5" readonly>
        </div>

    </div>
    <hr>
    <div class="form-row">
        <div class="col-md-12 mb-3 mt-2">
          <h5 for="validationCustom01" class="font-weight-bold">Ambulância</h5>
        </div>
    </div>


    <div class="form-row">
        <div class="custom-control custom-checkbox col-md-1 ml-4 mb-3 box-box1">
            <input ${uti} type="checkbox" class="custom-control-input custom-control-sm" id="customCheck1" disabled>
            <label class="custom-control-label" for="customCheck1" style ="margin:10px 10px 0px 0px">UTI</label>
        </div>
        <div class="mb-3 ml-3">
            <label for="" style ="margin:10px 10px 0px 0px">Oxigenio ?</label>
            <select value="" class="custom-select custom-select-sm" required disabled>
              <option value="1">${data.oxigenio}</option>
            </select>
            <div class="invalid-feedback">Example invalid custom select feedback</div>
          </div>
        <div class="mb-3 ml-3">
            <label for="" style ="margin:10px 10px 0px 0px">Obeso ?</label>
            <select value="" class="custom-select custom-select-sm" required disabled>
              <option value="">${data.obeso}</option>
            </select>
            <div class="invalid-feedback">Example invalid custom select feedback</div>
        </div>
        <div class="mb-3 ml-3">
            <label for="" style ="margin:10px 10px 0px 0px">Isolete ?</label>
            <select value="" class="custom-select custom-select-sm" required disabled>
              <option value="">${data.isolete}</option>
            </select>
            <div class="invalid-feedback">Example invalid custom select feedback</div>
        </div>
        <div class="mb-3 ml-3">
            <label for="" style ="margin:10px 10px 0px 0px">Maca ?</label>
            <select value="" class="custom-select custom-select-sm" required disabled>
              <option value="">${data.maca}</option>
            </select>
            <div class="invalid-feedback">Example invalid custom select feedback</div>
        </div>
    </div>
    <hr>
    <div class="form-row">
        <div class="mb-3" ">
            <label for="" style ="margin:10px 10px 0px 0px">Isolamento ? </label>
            <select value="" class="custom-select custom-select-sm " required disabled>
              <option value="" >${data.isolamento}</option>
            </select>
            <div class="invalid-feedback">Example invalid custom select feedback</div>
          </div>

          <div class="col mb-5">
            <label for="validationCustom01" style ="margin:10px 10px 0px 0px">Qual ?</label>
            <input value="${data.isolamento_motivo}" type="text" class="form-control  form-control-sm " id="validationCustom01" placeholder="Digite o motivo do isolamento" required readonly>
            <div class="valid-feedback">
              Looks good!
            </div>
          </div>

          <div class="col-md-2">
            <label for="" style ="margin:10px 10px 0px 0px">Obito ?</label>
            <select value="" class="custom-select custom-select-sm" required disabled>
              <option value="">${data.obito}</option>
            </select>
            <div class="invalid-feedback">Example invalid custom select feedback</div>
          </div>
      </div>
      <hr>
      <div class="form-row">
          <div class="mb-3 col-md-4">
              <label for="" style ="margin:10px 10px 0px 0px">Motorista</label>
              <select value="${data.motorista_nome}" class="custom-select custom-select-sm" required disabled>
                <option value="" selected>${data.motorista_nome}</option>
              </select>
              <div class="invalid-feedback">Example invalid custom select feedback</div>
            </div>
          <div class="mb-3 col-md-2">
              <label for="" style ="margin:10px 10px 0px 0px">Carro</label>
              <select value="${data.veiculo_pref}" class="custom-select custom-select-sm" required disabled>
                <option value="" selected>${data.veiculo_pref}</option>
              </select>
              <div class="invalid-feedback">Example invalid custom select feedback</div>
          </div>
          <div class="custom-control custom-checkbox col-md-1 ml-4 mb-3 box-box1">
          <input ${hc}  disabled type="checkbox" class="custom-control-input form-control-sm" id="hc_checkbox">
          <label class="custom-control-label" for="hc_checkbox" style ="margin:10px 10px 0px 0px">HC</label>
        </div>
        <div class="custom-control custom-checkbox col-md-1 ml-0 mb-3 box-box1">
          <input ${incor} type="checkbox" class="custom-control-input form-control-sm" id="incor_checkbox" disabled>
          <label class="custom-control-label" for="incor_checkbox" style ="margin:10px 10px 0px 0px">INCOR</label>
          </div>
          <div class="col-md-2 mb-3">
              <label for="validationCustom01" style ="margin:10px 10px 0px 0px">Radio</label>
              <input value="${data.radio}" type="text" class="form-control form-control-sm" id="validationCustom01" placeholder="" required disabled>
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>


      </div>
      <hr>
      <div class="form-row d-flex justify-content-between">
            <div class="col-md-2 mb-3">
                <label for="validationCustom01">Saida(Horas)</label>
                <input type="text" class="form-control form-control-sm" id="saida_horas" name="hora_sai" required disabled value="${data.horario_saida}">
		 <div class="invalid-feedback">
                    Please provide a valid city.
                </div>
              </div>
            <div class="col-md-3 mb-3">
                <label for="validationCustom01">Chegada ao destino(Horas)</label>
                <input type="text" class="form-control form-control-sm" id="ch_h" required value="${data.ch_horario}" disabled>
                <div class="invalid-feedback ">
                    Please provide a valid city.
                </div>
              </div>
            <div class="col-md-2 mb-3">
                <label for="validationCustom01">Retorno ao A5(Horas)</label>
                <input type="text" class="form-control form-control-sm" id="validationCustom03" required disabled value="${data.vt_horario}">
                <div class="invalid-feedback">
                    Please provide a valid city.
                </div>
              </div>
        </div>
        <div class="form-row d-flex justify-content-between">
            <div class="col-md-2 mb-3">
                <label for="validationCustom01">KM</label>
                <input name="km" id="sol_km" type="number" class="form-control form-control-sm" required disabled value="${data.sol_km}">
                <div class="valid-feedback">
                  Looks good!
                </div>
              </div>
            <div class="col-md-2 mb-3">
                <label for="validationCustom01">KM</label>
                <input type="number" class="form-control form-control-sm" id="validationCustom01"  required disabled value="${data.ch_kilometro}">
                <div class="valid-feedback">
                  Looks good!
                </div>
              </div>
            <div class="col-md-2 mb-3">
                <label for="validationCustom01">KM</label>
                <input type="number" class="form-control form-control-sm" id="validationCustom01"  required required disabled value="${data.vt_kilometro}">
                <div class="valid-feedback">
                  Looks good!
                </div>
              </div>
        </div>
        <hr>
        <div class="form-row d-flex justify-content-between">
            <div class="col-md-4 mb-3">
                <label for="validationCustom01">Contato Plantão Controlador:</label>
                <input value="${data.contato_plantao}" type="text" class="form-control form-control-sm" id="validationCustom01" placeholder="" required readonly>
                <div class="valid-feedback">
                  Looks good!
                </div>
              </div>
            <div class="col-md-5 mb-3">
                <label for="validationCustom01">Solicitação Atendida por:</label>
                <input value="${data.atendida_por}" type="text" class="form-control form-control-sm" id="validationCustom01" placeholder="Nome do Funcionario" required readonly>
                <div class="valid-feedback">
                  Looks good!
                </div>
              </div>
        </div>
      </div>
      <div class="modal-footer">
        <h3>Modal Footer</h3>
      </div>
    </div>`
return visualize;
}

function obterDestinosP()
{
    let destinos = [];
    let destinosInputs = document.querySelectorAll("[id^='Editdestino']");
    destinosInputs.forEach(function(input) {
      destinos.push(input.value);
    });

    return destinos;
}
function verificarArrayP(array)
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


function updateSolicitationP(id,check_ch,check_vt)
{
  var select = document.getElementById('solicitantes');
	var text = select.options[select.selectedIndex].text;
  var select1 = document.getElementById('ch_c');
	var text1 = select1.text;
  var select2 = document.getElementById('ret_r');
	var text2 = select2.text;


    //PEGANDO TODOS OS CAMPOS
    let idaN = "";
    let utiN = "";
    let hcN = "";
    let incorN = "";
    let ida = document.getElementById('ida_check').checked;
    let ret = document.getElementById("retorno_check").checked;
    let canc = document.getElementById("cancelamento_check").checked;

    if (canc) {
        CLM = "OK"

    } else {
        CLM = "NOK"

    }
    if(ida)
    {
        idaN = "OK"
    }else
    {
        idaN = "NOK"
    }
    if(ret)
    {
        retN = "OK"
    }else
    {
        retN = "NOK"
    }
    //PEGANDO DADOS HC INCOR RADIO

    let hc = document.getElementById("hc_checkbox").checked;

    if(hc)
    {
        hcN = "OK"
    }else
    {
        hcN = "NOK"
    }

    let incor = document.getElementById("incor_checkbox").checked;

    if(incor)
    {
        incorN = "OK"
    }else
    {
        incorN = "NOK"
    }

    let uti1 = document.getElementById('UTI').checked;

    if(uti1)
    {
        utiN = "OK"
    }else
    {
        utiN = "NOK"
    }
    let d = new Date();
    let dia = d.getDate();
    let mes = d.getMonth() + 1;
    if(mes <= 9){
        mes = `0${mes}`
    }
    let ano = d.getFullYear()
    data_atual = ano + '-' + mes + '-' + dia;
    let hora_saida = document.getElementById('saida_horas').value
    let hora_chegada = document.getElementById('ch_h').value
    let hora_retorno = document.getElementById('ret_h').value
    var solicitacao = formatData($('#data_sol_validation').val())
    let km_chegada = document.getElementById('ch_c').value
    let km_retorno = document.getElementById('ret_r').value
    var confirmacao_ch = check_ch;
    var confirmacao_vt = check_vt;

    if ($('#cancelamento_check:checked').length < 1) {
      if (km_retorno == "" && km_chegada == "" || km_chegada == 0 && km_retorno == 0) {
          var p = $(`<div class="alert1">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;
        </span> Preencha os campos KM de retorno e Km de chegada.
        </div>`);
          p.hide()
          $('.conteudos').append(p);
      p.fadeIn(500, function () {
          window.setTimeout(function () {
              p.fadeOut();
          }, 2000)
      });

      return false;

    }
}

if ($('#cancelamento_check:checked').length < 1) {
  if(hora_chegada === '' || hora_chegada === null || hora_retorno === '' || hora_retorno === null){
    var p = $(`<div class="alert1">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;
    </span> Preencha os campos: Chegada ao destino e Retorno ao A5.
    </div>`);
      p.hide()
      $('.conteudos').append(p);
      p.fadeIn(500, function () {
          window.setTimeout(function () {
              p.fadeOut();
          }, 2000)
      });

      return false;
  }
}
if ($('#cancelamento_check:checked').length != 1){
    if (solicitacao === data_atual && hora_chegada <= hora_saida) {
        modalClose1();
        var p = $(`<div class="alert1">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        Falha ao editar. A hora de chegada ao destino não pode ser menor ou igual a hora de saída.
        </div>`);
        p.hide()
        $('#conteudo_lista_visualiza').append(p);
        p.fadeIn(500, function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 2000)
        });
        return false;
    }

    if (solicitacao === data_atual && hora_retorno <= hora_chegada) {
        modalClose1();
        var p = $(`<div class="alert1">
      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
      Falha ao editar. A hora de retorno não pode ser menor ou igual a hora de chegada ao destino.
      </div>`);
        p.hide()
        $('#conteudo_lista_visualiza').append(p);
        p.fadeIn(500, function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 2000)
        });
        return false;
    }
}



var data;
  if ($('#cancelamento_check:checked').length == 1) {
      data = {
          n_paciente: document.getElementById('nome_paciente').value,
          ida: idaN,
          retorno: retN,
          cancelamento: CLM,
          data_sol: formatData($('#data_sol_validation').val()),
          hora_sol: $("input[name='hora_sol']").val(),
          dest_sol: verificarArrayP(obterDestinosP()),
          port_sol: document.getElementById('portaria').value,
          end_loc_ident: document.getElementById('end').value,
          n_ficha_sol: document.getElementById('n_ficha').value,
          mot_HC: hcN,
          mot_INCOR: incorN,
          mot_radio: document.getElementById("RADIO").value,
          mot_carro: document.getElementById('carro_disp').value,
          mot_nome: document.getElementById('mot_id').value,
          sol_nome: text,
          ramal_sol: document.getElementById('ramal_sol').value,
          uti: utiN,
          oxi: document.getElementById('oxigenio').value,
          obe: document.getElementById('obeso').value,
          iso: document.getElementById('isolete').value,
          mac: document.getElementById('maca').value,
          amb_isolamento: document.getElementById('ISO').value,
          amb_iso_qual: document.getElementById('isolamento').value,
          amb_obito: document.getElementById('obito').value,
          contato: document.getElementById('CONTATO').value,
          nome_func: document.getElementById('ATENDIDA').value,
          hora_chegada: document.getElementById('ch_h').value = '00:00',
          hora_retorno: document.getElementById('ret_h').value = '00:00',
          km_chegada: document.getElementById('ch_c').value = '0000',
          km_retorno: document.getElementById('ret_r').value = '0000',
          sol_saida: document.getElementById('saida_horas').value,
          sol_km: document.getElementById('sol_km').value,
          check_ch: confirmacao_ch,
          check_vt: confirmacao_vt,
      }
    }else{
      data = {
          n_paciente: document.getElementById('nome_paciente').value,
          ida: idaN,
          retorno: retN,
          cancelamento: CLM,
          data_sol: formatData($('#data_sol_validation').val()),
          hora_sol: $("input[name='hora_sol']").val(),
          dest_sol: verificarArrayP(obterDestinosP()),
          port_sol: document.getElementById('portaria').value,
          end_loc_ident: document.getElementById('end').value,
          n_ficha_sol: document.getElementById('n_ficha').value,
          mot_HC: hcN,
          mot_INCOR: incorN,
          mot_radio: document.getElementById("RADIO").value,
          mot_carro: document.getElementById('carro_disp').value,
          mot_nome: document.getElementById('mot_id').value,
          sol_nome: text,
          ramal_sol: document.getElementById('ramal_sol').value,
          uti: utiN,
          oxi: document.getElementById('oxigenio').value,
          obe: document.getElementById('obeso').value,
          iso: document.getElementById('isolete').value,
          mac: document.getElementById('maca').value,
          amb_isolamento: document.getElementById('ISO').value,
          amb_iso_qual: document.getElementById('isolamento').value,
          amb_obito: document.getElementById('obito').value,
          contato: document.getElementById('CONTATO').value,
          nome_func: document.getElementById('ATENDIDA').value,
          hora_chegada: $("input[name='ch_h']").val(),
          hora_retorno: $("input[name='ret_h']").val(),
          km_chegada: document.getElementById('ch_c').value,
          km_retorno: document.getElementById('ret_r').value,
          sol_saida: document.getElementById('saida_horas').value,
          sol_km: document.getElementById('sol_km').value,
          check_ch: confirmacao_ch,
          check_vt: confirmacao_vt,
      }
  }

  $.ajax({
      method: 'POST',
      url:  url_p+`api/get_All_by_id/${id}`,
      data: data,
      success: function (e) {
          let data = JSON.parse(e);
          if (data.status == 0) {
              var p = $(`<div class="alert1">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    Não foi possivel editar a solicitação
                    </div>`);
              p.hide()
              $('#conteudo_lista_visualiza').append(p);
              p.fadeIn(500, function () {
                  window.setTimeout(function () {
                      p.fadeOut();
                  }, 2000)
              });
          } else if (data.status == 1) {
              modalClose1();
              Diaria(diab)
              var p = $(`<div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    ${data.msg}
                    </div>`);
              p.hide()
              $('#conteudo_lista_visualiza').append(p);
              p.fadeIn('slow', function () {
                  window.setTimeout(function () {
                      p.fadeOut();
                  }, 2000)
              });
          }
      }
  });
}
function validaKMSP(id){

  let km_chegada = document.getElementById('ch_c').value
  let km_retorno = document.getElementById('ret_r').value
  let km_inicial = document.getElementById('sol_km').value
  let km_max = parseInt(km_inicial)+110
  if ($('#cancelamento_check:checked').length < 1) {
  if (parseInt(km_retorno) < parseInt(km_chegada)) {
    // modalClose1();
    var p = $(`<div class="alert1">
      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;
      </span> Falha ao editar.O quilomêtro de retorno não pode ser menor que a chegada.
    </div>`);
    p.hide()
    $('.conteudos').append(p);
    p.fadeIn(500, function () {
        window.setTimeout(function () {
            p.fadeOut();
        }, 2000)
    });

    return false;
}
if (parseInt(km_inicial) > parseInt(km_chegada)) {
  // modalClose1();
  var p = $(`<div class="alert1">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;
    </span> Falha ao editar.O quilomêtro de chegada não pode ser menor que o inicial.
  </div>`);
  p.hide()
  $('.conteudos').append(p);
  p.fadeIn(500, function () {
      window.setTimeout(function () {
          p.fadeOut();
      }, 2000)
  });

  return false;
}
if(parseInt(km_chegada) > km_max){
  texto = `<div id='LimpabEXKMP'>
  <label for="staticEmail" style='font-size: initial;'>A quilometragem inicial informada foi de </label>
  <b style='font-weight: bold !important;'>${km_inicial} KMs.</b>
  <br></br>
  <label for="staticEmail" style='font-size: initial;'>A quilometragem de chegada ao local informada foi de </label>
  <b style='font-weight: bold !important;'>${km_chegada} KMs.</b>
  <br></br>
  <labelfor="staticEmail" style='font-size: initial;'>Existe uma diferença de ${parseInt(km_chegada)-parseInt(km_inicial)} KMs.</label>
  <labelfor="staticEmail" style='font-size: initial;'>Você confirma que estes dados estão corretos?</label>
  </div>`
  modalExcessoQuilometragemP(texto);
  $("#btnCEXP").on("click", ()=>{
    fechaModalP();
    $('#LimpabEXKMP').remove()
    updateSolicitationP(id,1,1);
  });
}else if(parseInt(km_retorno)+(parseInt(km_chegada)- km_max) > km_max){
  texto = `<div id='LimpabEXKMP'>
  <label for="staticEmail" style='font-size: initial;'>A quilometragem de retorno informada foi de </label>
  <b style='font-weight: bold !important;'>${km_retorno} KMs.</b>
  <br></br>
  <labelfor="staticEmail" style='font-size: initial;'>Os dados informados como quilometros inicias e de chegada ao destino não condizem com a quilometragem de retorno.</label>
  <br></br>
  <labelfor="staticEmail" style='font-size: initial;'>Existe uma diferença de ${parseInt(km_retorno) - km_chegada} KMs da quilometragem de chegada ao local indicado.</label>
  <br></br>
  <labelfor="staticEmail" style='font-size: initial;'>E uma diferença de ${parseInt(km_retorno) - km_inicial} KMs do quilômetro inicial informado.</label>
  <br></br>
  <labelfor="staticEmail" style='font-size: initial;'>Você confirma que estes dados estão corretos?</label>
  </div>`
  modalExcessoQuilometragemP(texto);
  $("#btnCEXP").on("click", ()=>{
    fechaModalP();
    $('#LimpabEXKMP').remove()
      updateSolicitationP(id,0,1);
  });
}else{
  updateSolicitationP(id,0,0);
}
  }else{
    updateSolicitationP(id,0,0);
  }
}


function modalExcessoQuilometragemP(texto) {
  var modal = document.getElementById("modalExP");
  var conteudo = document.getElementById("content_modalExP");
  modal.style.display = "block";
  modal.style.paddingTop = "75px";
  modal.style.paddingRight = "10px";
  conteudo.style.width = "49%";

  $('#bEXKMP').append(texto);

}

function fechaModalP() {

  var modal = document.getElementById("modalExP");
  modal.style.display = "none";
}
