$(function () {
  tableAviso();
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
});

function tableAviso() {
  $.ajax({
      method: 'GET',
      url: url_p+'api/get_avisos',
      success: function (e) {
          $('.listagem_s').remove();
          let data = JSON.parse(e);

          data.forEach(function (dados) {
              $('#corpo_tabela_avisos').append(`<tr class="listagem_s">
                  <th class="aviso n_ficha  text-center align-middle" >${dados.n_ficha}</th>
                  <th class="aviso n_ficha  text-center align-middle" >${dados.nome_motorista}</th>
                  <th class='d-flex-align-center text-center align-middle'><span class='badge badge-pill badge-primary text-center align-middle'><i class='fa fa-truck mr-1'></i> Solicitação em Andamento</span></th>
                  <th class="aviso n_ficha  text-center align-middle" >${dados.nome_solicitante}</th>
                  <th class="aviso n_ficha  text-center align-middle" >${dados.usuario}</th>
                      <th> <button value='${dados.id_sol}' onclick='editSolicitation(${dados.id_sol});' type='button' class='btn btn-sm btn-secondary mr-1 myBtnE' id='myBtn2' ><i class='fa fa-edit'></i> Editar</button></th>
                  </tr>
                  `);
          })
      }
  });
}

function motoristas() {
  $.ajax({
      method: 'GET',
      url: url_p+'api/motorista_all',
      success: function (e) {
          var data = JSON.parse(e);

          data.forEach(function (value, index) {
              $('#motorist_qual').append(`
              <option value="${value.nome}">${value.nome}</option>
              `)
          })
      }
  })
}

function msgError() {
  var p = $(`<div class="alert1">
              <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
              Entre pelo menos com algum valor valido nos campos !
              </div>`);
  p.hide()
  $('#corpo_tabela_avisos').append(p);
  p.fadeIn(500, function () {
      window.setTimeout(function () {
          p.fadeOut();
      }, 2000)
  });
}

function atribuirDestinos(destinos)
{
    var divsDestino = document.querySelectorAll('.editFormDest');

    for (var i = 0; i < divsDestino.length; i++) {
      var inputDestino = divsDestino[i].querySelector('input');

      if (i < destinos.length) {
        inputDestino.value = destinos[i];
      } else {
        divsDestino[i].classList.add('esconde');
      }
    }
}



function editSolicitation(id) {
  $.ajax({
      method: 'GET',
      url: url_p+`api/get_solicitations_filter_by_id/${id}`,
      success: function (e) {
          var hc = $('#hc_checkbox').length;
          var incor = $('#incor_checkbox').length;

          let data = JSON.parse(e)
          var v
          $("#content_modal").remove()
          var modal = document.getElementById("myModal4");
          modal.style.display = "block";
          modal.style.paddingTop = "10px";
          let ss = data.forEach(function (value, index) {
              v = value
          })


            $("#myModal4").append(makeContentEdit(v))
            atribuirDestinos(v.destino.split(";"));

            $("#validationCustom03").mask("##:##")
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
          jQuery('input[type = number]').on('keyup', function () {
              this.value = this.value.replace(/[^0-9\.]/g, '');
          });


      }
  })
}

function modalClose1() {
  var modal = document.getElementById("myModal4");
  modal.style.display = "none";
}

function makeContentEdit(data) {
  let ida = ""
  let hc = ""
  let retorno = ""
  let uti = ""
  let incor = ""
  let cancelamento = ""

  if (data.cancelamento == "OK") {
      cancelamento = "checked"
  } else if (data.cancelamento == "NOK") {
      cancelamento = ""
  }

  if (data.ida == "OK") {
      ida = "checked"
  } else if (data.ida == "NOK") {
      ida = ""
  }

  if (data.retorno == "OK") {
      retorno = "checked"
  } else if (data.retorno == "NOK") {
      retorno = ""
  }

  if (data.uti == "OK") {
      uti = "checked"
  } else if (data.uti == "NOK") {
      uti = ""
  }

  if (data.hc == "OK") {
      hc = "checked"
  } else if (data) {
      hc = ""
  }

  if (data.incor == "OK") {
      incor = "checked"
  } else if (data) {
      incor = ""
  }

  $.ajax({
      method: "GET",
      url: url_p+"api/solicitante_allS",
      success: function (e) {
          var data = JSON.parse(e);
          data.forEach(function (item, index) {
              $('#solicitantes').append(`
          <option value="${item.ramal}">${item.nome}</option>
        `)


              var valorCombo = document.querySelector('[name="sol"]').addEventListener('change', function (event) {
                  var ramal = event.target.value // Pegando o valor direto do evento atual
                  $('#ramal_sol').val(ramal)
              })


          })
      }
  })

  $.ajax({
      method: 'GET',
      url: url_p+'api/get_motorista_disponivel',
      success: function (e) {
          var data = JSON.parse(e);

          data.forEach(function (item, index) {
              $('#mot_id').append(`
              <option value="${item.nome}">${item.nome}</option>
              `)

          })
      }
  })

  $.ajax({
      method: 'GET',
      url: url_p+'api/get_veiculo_disponivel',
      success: function (e) {
          var data = JSON.parse(e);

          data.forEach(function (item, index) {
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
  let destinos = data.destino.split(";")

  console.log(destinos)
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
          <input value="${trocaBarra(data.data_solicitacao)}" name="data_sol" type="text" class="form-control form-control-sm datepicker" id="data_sol_validation" required  maxlength="10">
          <div class="invalid-feedback">
            Please provide a valid city.
          </div>
        </div>
        <div class="col-md-2">
          <label for="validationCustom03" style ="margin:10px 10px 0px 0px">Hora</label>
          ${teste(data.hora_solicitacao)}
          <div class="invalid-feedback">
            Please provide a valid city.
          </div>
        </div>
        <div class="col-md-3 ml-1">
              <label for="" style ="margin:10px 10px 0px 0px">Solicitante (Nome)</label>
              <select id="solicitantes" name="sol" value="${data.solicitante}"  class="custom-select custom-select-sm" >
                <option selected disabled readonly>${data.solicitante}</option>
              </select>
              <div class="invalid-feedback">Example invalid custom select feedback</div>
            </div>
      <div class="col">
        <label for="validationCustom05" style ="margin:10px 10px 0px 0px">Ramal</label>
        <input id="ramal_sol" value="${data.sol_ramal}" name="ramal_sol" type="text" class="form-control form-control-sm">
      </div>
      </div>


      <div class="form-row">
          <div class="col-md-2">
            <label for="validationCustom01" style ="margin:10px 10px 0px 0px">Portaria</label>
            <input value="${data.portaria}" type="text" class="form-control form-control-sm" id="portaria"   >
            <div class="valid-feedback">
              Looks good!
            </div>
          </div>
          <div class="col">
            <label for="validationCustom01" style ="margin:10px 10px 0px 0px">N° Ficha</label>
            <input value="${data.numero_ficha}" type="text" class="form-control form-control-sm" id="n_ficha">
            <div class="valid-feedback">
              Looks good!
            </div>
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
                <select id="mot_id" value="${data.motorista_nome}" class="custom-select custom-select-sm" required >
                  <option selected disabled readonly>${data.motorista_nome}</option>
                </select>
                <div class="invalid-feedback">Example invalid custom select feedback</div>
              </div>
            <div class="mb-3 col-md-2">
                <label for="" style ="margin:10px 10px 0px 0px">Carro</label>
                <select id="carro_disp" class="custom-select custom-select-sm" required >
                  <option selected disabled readonly>${data.veiculo_pref}</option>
                </select>
                <div class="invalid-feedback">Example invalid custom select feedback</div>
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
                <label for="RADIO" style ="margin:10px 10px 0px 0px">Radio</label>
                <input value="${data.radio}" type="text" class="form-control form-control-sm" id="RADIO" placeholder="" required >
                <div class="valid-feedback">
                  Looks good!
                </div>
              </div>
        </div>
        <hr>
        <div class="form-row d-flex justify-content-between">
            <div class="col-md-2 mb-3">
                <label for="saida_horas" style ="margin:10px 10px 0px 0px">Saida(Horas)</label>
                <input value="${data.horario_saida}" type="text" name="hora_sai" class="form-control form-control-sm" id="saida_horas" required maxlength="5">
                <div class="invalid-feedback">
                    Please provide a valid city.
                </div>
              </div>
            <div class="col-md-3 mb-3">
                <label for="ch_h" style ="margin:10px 10px 0px 0px">Chegada ao destino(Horas)</label>
                <input value="${data.ch_horario}" name="ch_h" type="text" class="form-control form-control-sm" id="ch_h" required maxlength="5">
                <div class="invalid-feedback">
                    Please provide a valid city.
                </div>
              </div>
            <div class="col-md-2 mb-3">
                <label for="ret_h"style ="margin:10px 10px 0px 0px">Retorno ao A5(Horas)</label>
                <input value="${data.vt_horario}" name="ret_h" type="text" class="form-control form-control-sm" id="ret_h" required maxlength="5">
                <div class="invalid-feedback">
                    Please provide a valid city.
                </div>
              </div>
        </div>


        <div class="form-row d-flex justify-content-between">
            <div class="col-md-2 mb-3">
                <label for="sol_km" style ="margin:10px 10px 0px 0px">KM</label>
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
          <button id="envia" class="btn btn-secondary" onclick="validaKMS(${data.id_solicitacao});" type="submit"><i class="fa fa-save mr-2"></i>Salvar</button>
        </div>
      </div>
    </div>`;

  return formulario;
}
function obterDestinos()
{
    let destinos = [];
    let destinosInputs = document.querySelectorAll("[id^='Editdestino']");
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

function updateSolicitation(id,check_ch,check_vt)
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

if (solicitacao === data_atual && hora_chegada <= hora_saida) {
    modalClose1();
    var p = $(`<div class="alert1">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    Falha ao editar. A hora de chegada ao destino não pode ser menor ou igual a hora de saída.
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
if (solicitacao === data_atual && hora_retorno <= hora_chegada) {
    modalClose1();
    var p = $(`<div class="alert1">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  Falha ao editar. A hora de retorno não pode ser menor ou igual a hora de chegada ao destino.
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

var data;
if ($('#cancelamento_check:checked').length == 1) {
  data = {
      n_paciente: document.getElementById('nome_paciente').value,
      ida: idaN,
      retorno: retN,
      cancelamento: CLM,
      data_sol: formatData($('#data_sol_validation').val()),
      hora_sol: $("input[name='hora_sol']").val(),
      dest_sol: verificarArray(obterDestinos()),
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
      ida: idaN,
      contato: document.getElementById('CONTATO').value,
      nome_func: document.getElementById('ATENDIDA').value,
      hora_chegada: document.getElementById('ch_h').value = '00:00',
      hora_retorno: document.getElementById('ret_h').value = '00:00',
      km_chegada: document.getElementById('ch_c').value = '0000',
      km_retorno: document.getElementById('ret_r').value = '0000',
      sol_saida: document.getElementById('saida_horas').value,
      sol_km: document.getElementById('sol_km').value,
      check_ch: confirmacao_ch,
      check_vt: confirmacao_vt
  }
} else {
  data = {
      n_paciente: document.getElementById('nome_paciente').value,
      ida: idaN,
      retorno: retN,
      cancelamento: CLM,
      data_sol: formatData($('#data_sol_validation').val()),
      hora_sol: $("input[name='hora_sol']").val(),
      dest_sol: verificarArray(obterDestinos()),
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
    url: url_p+`api/get_All_by_id/${id}`,
    data: data,
    success: function (e) {
      let data = JSON.parse(e);
      if (data.status == 0) {
          var p = $(`<div class="alert1">
              <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
              Não foi possivel editar a solicitação
              </div>`);
          p.hide()
          $('#corpo_tabela_avisos').append(p);
          p.fadeIn(500, function () {
              window.setTimeout(function () {
                  p.fadeOut();
              }, 2000)
          });
      } else if (data.status == 1) {

          tableAviso()
          modalClose1()
          var p = $(`<div class="alert">
              <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
              ${data.msg}
              </div>`);
          p.hide()
          $('#corpo_tabela_avisos').append(p);
          p.fadeIn('slow', function () {
              window.setTimeout(function () {
                  p.fadeOut();
              }, 2000)
          });
      }
  }
});
}
function validaKMS(id){
$('#LimpabEXKM').remove()
let km_chegada = document.getElementById('ch_c').value
let km_retorno = document.getElementById('ret_r').value
let km_inicial = document.getElementById('sol_km').value
let km_max = parseInt(km_inicial)+110

if ($('#cancelamento_check:checked').length < 1) {
if (parseInt(km_retorno) < parseInt(km_chegada)) {
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
texto = `<div id='LimpabEXKM'>
<label for="staticEmail" style='font-size: initial;'>A quilometragem inicial informada foi de </label>
<b style='font-weight: bold !important;'>${km_inicial} KMs.</b>
<br></br>
<label for="staticEmail" style='font-size: initial;'>A quilometragem de chegada ao local informada foi de </label>
<b style='font-weight: bold !important;'>${km_chegada} KMs.</b>
<br></br>
<labelfor="staticEmail" style='font-size: initial;'>Existe uma diferença de ${parseInt(km_chegada)-parseInt(km_inicial)} KMs.</label>
<labelfor="staticEmail" style='font-size: initial;'>Você confirma que estes dados estão corretos?</label>
</div>`
modalExcessoQuilometragem(texto);
$("#btnCEX").on("click", ()=>{
  fechaModal();
  $('#LimpabEXKM').remove()
  updateSolicitation(id,1,0);
});
}else if(parseInt(km_retorno)+(parseInt(km_chegada)- km_max) > km_max){
texto = `<div id='LimpabEXKM'>
<label for="staticEmail">A quilometragem de retorno informada foi de </label>
<b style='font-weight: bold !important;'>${km_retorno} KMs.</b>
<br></br>
<labelfor="staticEmail">Os dados informados como quilometros inicias e de chegada ao destino não condizem com a quilometragem de retorno.</label>
<br></br>
<labelfor="staticEmail">Existe uma diferença de ${(parseInt(km_retorno)+(parseInt(km_chegada)- km_max)) - parseInt(km_inicial)} KMs da quilometragem de chegada ao local indicado.</label>
<br></br>
<labelfor="staticEmail">E uma diferença de ${parseInt(km_retorno) - parseInt(km_inicial)} KMs do quilômetro inicial informado.</label>
<br></br>
<labelfor="staticEmail">Você confirma que estes dados estão corretos?</label>
</div>`
modalExcessoQuilometragem(texto);
$("#btnCEX").on("click", ()=>{
  fechaModal();
  $('#LimpabEXKM').remove()
  updateSolicitation(id,0,1);
});
}else{
updateSolicitation(id,0,0);
}
}else{
  updateSolicitation(id,0,0);
}
}


function modalExcessoQuilometragem(texto) {
var modal = document.getElementById("modalEx");
var conteudo = document.getElementById("content_modalEx");
modal.style.display = "block";
modal.style.paddingTop = "75px";
modal.style.paddingRight = "10px";
conteudo.style.width = "49%";

$('#bEXKM').append(texto);

}

function fechaModal() {

var modal = document.getElementById("modalEx");
modal.style.display = "none";
}


function teste(value){
    let txt = `<input value="${value}" data-mask="00:00" name="hora_sol" type="text" class="form-control form-control-sm" id="validationCustom03" required maxlength="5">`;
    return txt
}
