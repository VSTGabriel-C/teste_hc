let global_motorista = null
let global_qtde_cont = 0;
let global_page_atual = 1;

let lista = []

$(() => {
    chargeMotoristas()
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
    $("#hr_ini").mask("##:##");
    $("#hora_final").mask("##:##");

    /**
     * Select Multiple
     */

    $('#veiculo_id').select2({
        maximumSelectionLength: 4,
        multiple: true,
        tags: true,
        minimumResultsForSearch: 0,
        placeholder: 'Escolha um ou mais veiculos'
    })
    $('#motorista_id').select2({
        placeholder: 'Escolha o motorista'
    })

    /**
     * Atributo page
     */

    var pageFormulario = parseInt($('#formulario').attr('page'));
    var pageGestao = parseInt($('#gestao').attr('page'));

    /**
     * Evento de clique paginas
     */

    $('.aba1').on('click', (e) => {
        changePage(pageFormulario)
    })

    $('.aba2').on('click', (e) => {
        changePage(pageGestao)
    })

    novaEscala()
    fecharModalEscalas()

    searchEscalas()


})



let chargeMotoristas = () =>
{
    let veiculo = fetch(url_p+`api/get_veiculo_habilitado`)
    .then(response => response.json())
    .then(data => {
        return data
    })
    .catch(error => {

    })

    let motorista = fetch(url_p+`api/get_motorista_habilitado`)
    .then(response => response.json())
    .then(data => {
        return data
    })
    .catch(error => {

    })

    makeInputVeiculo(motorista, veiculo)
    getSelectedValues()
}

let makeInputVeiculo = (motorista_data, veiculo_data) => {

    let newArr = []
    motorista_data
    .then(data =>
    {
        addMotVeiculos(data, veiculo_data)

        data.forEach((motorista) => {

            $("#motorista_id").append(`
                <option value="${motorista.id}">${motorista.nome}</option>
            `)
        })
    })

    veiculo_data
    .then(data => {
        let opt = ""

        data.forEach(async (veiculo) =>
        {
            opt += `<option value="${veiculo.id}">${veiculo.pref}</option>`
        })

        $("#veiculo_id").append(opt)
        let spanselect = document.querySelector("#form_geral > div.container_form_geral > div.body_form_geral > form > div:nth-child(5) > div.d-flex.flex-column.col-md-4 > div > span > span.selection > span");
        let textSpan = document.querySelector("#select2-solicitantes-container");
        let spantext = document.querySelector("#form_geral > div.container_form_geral > div.body_form_geral > form > div:nth-child(5) > div.d-flex.flex-column.col-md-4 > div > span > span.selection > span");
    })

}

let getSelectedValues = () =>
{
    $(document).on('change', '#motorista_id', (e) => {
         global_motorista = parseInt(e.target.value);
    });

}


function addMotVeiculos(motorista_data, veiculo)
{

    $('#add').on("click", (e) => {

        e.preventDefault();
        if(lista.length == 0)
        {

            if($("#container_motoristas_e_veiculos").children.length <= 2)
            {
                lista = excludeItensById($("#motorista_id").val(), motorista_data);
            }


            veiculo
            .then(response => {

                let opt = ""

                let optmot = ""
                response.forEach((data) => {
                    opt += `<option value="${data.id}">${data.pref}</option>`
                })

                lista.forEach((data) => {
                    optmot += `<option value="${data.id}">${data.nome}</option>`
                })

                $('#container_motoristas_e_veiculos').append(`
                    <div class="col-5 mb-3" id='container_mot${global_qtde_cont}'>
                        <label for='motorista_id${global_qtde_cont}'>Motorista</label>
                        <select class="form-control " id="motorista_id${global_qtde_cont}" aria-describedby="motorista_id${global_qtde_cont}" required>
                            <option selected disabled value="">Escolha</option>
                        </select>
                    </div>
                    <div class="col-5 mb-3" id='container_vei${global_qtde_cont}'>
                        <label for="veiculo_id">Veiculo(s)</label>
                        <select class="form-control"
                            name="veiculo_id${global_qtde_cont}[]"
                            id="veiculo_id${global_qtde_cont}"
                            aria-describedby="veiculo_id${global_qtde_cont}"
                            required
                        ></select>
                    </div>
                    <div class="col-2 mb-3" id='container_hor${global_qtde_cont}'>
                        <label for="horarioMotEscala">Horário</label>
                        <input class="form-control"
                            name="horarioMotEscala${global_qtde_cont}"
                            id="horarioMotEscala${global_qtde_cont}"
                            aria-describedby="horarioMotEscala${global_qtde_cont}"
                            placeholder="hh x hh"
                            required
                        >
                    </div>
                `)

                $('#veiculo_id'+global_qtde_cont).select2({
                    maximumSelectionLength: 4,
                    multiple: true,
                    tags: true,
                    minimumResultsForSearch: 0,
                    placeholder: 'Escolha um ou mais veiculos'
                })

                $('#motorista_id'+global_qtde_cont).select2({

                    placeholder: 'Escolha um motorista'
                })

                $('#motorista_id'+global_qtde_cont).append(optmot)
                $('#veiculo_id'+global_qtde_cont).append(opt)

            })


            global_qtde_cont++

        }else
        {

            lista = excludeItensById($("#motorista_id"+global_qtde_cont).val(), lista);

            veiculo
            .then(response => {

                let opt = ""

                let optmot = ""
                response.forEach((data) => {
                    opt += `<option value="${data.id}">${data.pref}</option>`
                })

                lista.forEach((data) => {
                    optmot += `<option value="${data.id}">${data.nome}</option>`
                })


                $('#container_motoristas_e_veiculos').append(`
                    <div class="col-5 mb-3" id='container_mot${global_qtde_cont}'>
                        <label for='motorista_id${global_qtde_cont}'>Motorista</label>
                        <select class="form-control " id="motorista_id${global_qtde_cont}" aria-describedby="motorista_id${global_qtde_cont}" required>
                            <option selected disabled value="">Escolha</option>
                        </select>
                    </div>
                    <div class="col-5 mb-3" id='container_vei${global_qtde_cont}'>
                        <label for="veiculo_id">Veiculo</label>
                        <select class="form-control"
                            name="veiculo_id${global_qtde_cont}[]"
                            id="veiculo_id${global_qtde_cont}"
                            aria-describedby="veiculo_id${global_qtde_cont}"
                            required
                        ></select>
                    </div>
                    <div class="col-2 mb-3" id='container_hor${global_qtde_cont}'>
                        <label for="horarioMotEscala">Horário</label>
                        <input class="form-control"
                        name="horarioMotEscala${global_qtde_cont}"
                        id="horarioMotEscala${global_qtde_cont}"
                        aria-describedby="horarioMotEscala${global_qtde_cont}"
                        placeholder="hh x hh"
                        required>
                    </div>
                `)

                $('#veiculo_id'+global_qtde_cont).select2({
                    maximumSelectionLength: 4,
                    multiple: true,
                    tags: true,
                    minimumResultsForSearch: 0,
                    placeholder: 'Escolha um ou mais veiculos'
                })

                $('#motorista_id'+global_qtde_cont).select2({

                    placeholder: 'Escolha um motorista'
                })

                $('#motorista_id'+global_qtde_cont).append(optmot)
                $('#veiculo_id'+global_qtde_cont).append(opt)

            })

            global_qtde_cont++
        }

        if(global_qtde_cont > 0)
        {
            $("#remove").removeAttr('disabled')
        }else
        {
            $("#remove").attr('disabled')

        }

    });

    $('#remove').on("click", (e) => {
        e.preventDefault();

        $("#container_motoristas_e_veiculos").children().remove('#container_mot'+global_qtde_cont);
        $("#container_motoristas_e_veiculos").children().remove('#container_vei'+global_qtde_cont);
        $("#container_motoristas_e_veiculos").children().remove('#container_hor'+global_qtde_cont);

        global_qtde_cont--
        if($("#container_motoristas_e_veiculos").children().length == 3)
        {
            $("#remove").prop('disabled', true)
        }
    });

    const containerHeight = $('#formulario')[0].scrollHeight;
    $('#container_motoristas_e_veiculos').scrollTop(containerHeight);

}




let excludeItensById = (id, mot_list) => {


    let filtro = mot_list.filter((data) =>{
        return data.id !== parseInt(id)
    })

    return filtro

}


let changePage = (page) =>
{

    if(page == 1)
    {

        $('#formulario').removeClass('d-none');
        $('#gestao').addClass('d-none');
        $(".container_form").css({
            'overflow-y': "auto"
        })
        $('.aba1').css({
            cursor: 'pointer',
            width: '10vw',
            height: '100%',
            display: 'flex',
            'justify-content': 'center',
            position: 'inherit',
            'align-items': 'center',
            'background-color': 'white',
            'border-radius': '8px 8px 0px 0px',
            border: 'solid rgba(167, 162, 162, 0.653)',
            'border-width': '1px 1px 0 1px',
            'transition-property': 'background-color',
            'transition-duration': '0.5s'
        });
        $('.aba2').css({
            cursor: 'pointer',
            position: 'inherit',
            'background-color': 'transparent',
            width: '10vw',
            height: '100%',
            display: 'flex',
            color: "black",
            right: '81.6%;',
            'border': 'none',
            'justify-content': 'center',
            'align-items': 'center',
            'transition-property': 'background-color',
            'transition-duration': '0.5s',
            'border-radius': '8px 8px 0px 0px',
        });

        $(".container_form_escalas").css({
            'border-radius': '0px 10px 10px 10px'
        })

        return
    }else if(page == 2)
    {
      gerarGestaoEscalas();
    }

}


let novaEscala = () => {

    $("#cad_new_escala").on('click', e =>
    {
        e.preventDefault();

        fetch(url_p+'api/new-escala', {
            body: JSON.stringify(getAllInputs()),
            method: "POST",
            headers: {
                "content-type": "application/json"
            }
        })
        .then( res => res.json())
        .then(resp => {
            // Adicionar classe d-none à div com a classe container_form
            $('.container_form').addClass('d-none');

            // Remover classe d-none da div com a classe loader-wrapper
            $('.loader-wrapper').css('display', 'flex');

            if(resp.code == 200)
            {
                var p = $(`<div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    ${resp.msg}
                </div>`);
                p.hide()

                $('.conteudos_internos').append(p);
                p.fadeIn(500, function () {
                    window.setTimeout(function () {
                        p.fadeOut();
                    }, 2000)
                })


                setTimeout(function() {
                    location.reload();
                }, 4000); // 3000 milissegundos = 3 segundos

            }else
            {
                var p = $(`<div class="alert1">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    ${resp.msg}
                </div>`);
                p.hide()

                $('.conteudos_internos').append(p);
                p.fadeIn(500, function () {
                    window.setTimeout(function () {
                        p.fadeOut();
                    }, 2000)
                })
            }
        })
        .catch( error => {
            var p = $(`<div class="alert1">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            Erro ao gerar escala: algum dos campos não foi preenchido.
            </div>`);
            p.hide()
            $('.conteudos').append(p);
            p.fadeIn(500, function () {
                window.setTimeout(function () {
                    p.fadeOut();
                }, 4000)
            });
        })

    })
}



let getAllInputs = () => {


    let listTexts = document.querySelectorAll('input[type="text"]')

    let radio = document.querySelector('input[name="save_escala"]:checked').value

    let selects = getValsSelects();

    let inputsTexts = []

    listTexts.forEach(item => {
        inputsTexts.push(item.value)
    })


    var textosInputs = [];
    var inputs = document.querySelectorAll("input[id^='horarioMotEscala']");

    inputs.forEach(function(input) {
      textosInputs.push(input.value);
    });

    let finalInputs = {
        "text_inputs": inputsTexts,
        "save": radio === "sim" ? 1 : 1,
        "selects": selects,
        "horarios_mot": textosInputs

    }

    return finalInputs;

}



let getValsSelects = () => {

    let selectIdsVeiculo = ['veiculo_id'];
    let selectIdsMotorista = ['motorista_id'];
    let vals = [];

    $('select').each(function() {
        var selectID = $(this).attr('id');
        var regex1 = /veiculo_id\d+/;
        var regex2 = /motorista_id\d+/;

        if (regex1.test(selectID))
        {
            selectIdsVeiculo.push(selectID);
        }
        else if(regex2.test(selectID))
        {
            selectIdsMotorista.push(selectID)
        }
    });

    for(let i = 0; i < selectIdsMotorista.length; i++)
    {
        let motorista = $("#" + selectIdsMotorista[i]).val();
        let veiculos = $("#" + selectIdsVeiculo[i]).val();

        vals[i] = {
            motorista,
            veiculos
        }
    }

    return vals

}


/**
 * Requisições
 */


let getAllEscalas = () =>
{
    $(".container_escalas_show").empty()
    fetch(url_p+'api/get-all-escalas',
    {
        method: "GET"
    })
    .then(array => array.json())
    .then(resp =>
    {
        let cards = ``
        if(resp?.code && resp.code == 500)
        {
            let msg = `
                <div class="sem_escalas">
                    <h5>Não foi encontrada nenhuma escala!</h5>
                </div>
            `
            $(".container_escalas_show").append(msg)
        }else
        {
            resp.forEach((el) =>
            {

                $(".container_escalas_show").empty()


                cards +=
                `
                    <div class="card_escala">
                        <div class="indicator_active_deactive ${el.active === 0 ? 'indicator_deactive' : 'indicator_active'}"></div>
                        <div class="container_textos_escala">
                            <div class="title_escala">
                                <h4>Identificação da Escala: </h4>
                                <h5>${el.identificacao}</h5>
                            </div>

                            <div class="infos_iniciais_escala">
                                <div class="textos_infos_escala">
                                    <h6>Data Inicio</h6>
                                    <p>${getDateOrTime(el.data_inicio)}</p>
                                </div>
                                <div class="textos_infos_escala">
                                    <h6>Hora Inicio</h6>
                                    <p>${getDateOrTime(el.hora_inicio, 'time')}</p>
                                </div>
                                <div class="textos_infos_escala">
                                    <h6>Hora Fim</h6>
                                    <p>${getDateOrTime(el.hora_fim, 'time')}</p>
                                </div>
                                <div class="textos_infos_escala">
                                    <h6>Status</h6>
                                    <p class=${el.active === 0 ? "text-danger" : "text-success"}>${ el.active === 0 ? 'Desativada' : 'Ativada'} <i class=${el.active === 0 ? "fa fa-times" : "fa fa-check"} ></i></p>
                                </div>
                            </div>
                        </div>
                        <div class="container_acoes_escala">
                            <button class="${el.active === 0 ? 'btn btn-success btn-sm' : 'btn btn-danger btn-sm'}"  onClick="activeEscala(${el.id})"><i class="${el.active === 0 ? 'fa fa-check mr-2': 'fa fa-times mr-2'}"></i>${el.active === 0 ? 'Ativar': 'Desativar'}</button>
                            <button class="btn btn-primary btn-sm" onClick="visualizeEscala(${el.id})" data-toggle="modal" data-target="#modalEscalas"> <i class="fa fa-eye"></i> Visualizar</button>
                            <button class="btn btn-primary btn-sm" onClick="editEscala(${el.id})" data-toggle="modal" data-target="#modalEscalas"> <i class="fa fa-pen"></i> Editar</button>
                            <button disabled class="btn btn-danger btn-sm" onClick="excludeEscala(${el.id})"> <i class="fa fa-trash"></i> Excluir</button>
                        </div>
                    </div>
                `
            })
            $(".container_escalas_show").append(cards)
        }
    })
}

let excludeEscala = id =>
{
    let data =
    {
        "id": id
    }

    fetch(url_p+'api/exclude-escala',
    {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "content-type": "application/json"
        }
    })
    .then(resp => resp.json())
    .then(data =>
    {

        if(data.code == 200)
        {
            getAllEscalas()

            var p = $(`<div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        ${data.msg}
                    </div>
            `);
            p.hide()

            $('.conteudos_internos').append(p);
            p.fadeIn(500, function () {
                window.setTimeout(function () {
                    p.fadeOut();
                }, 2000)
            })
        }
        else
        {
            var p = $(`<div class="alert1">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    ${data.msg}
                </div>`);
                p.hide()

                $('.conteudos_internos').append(p);
                p.fadeIn(500, function () {
                    window.setTimeout(function () {
                        p.fadeOut();
                    }, 2000)
                })
        }

    })
}

let getDateOrTime = (timestamp, type = "date") =>
{
    if(type === "time")
    {
        var partes = timestamp.split(' ')[1];

        var horasMinutos = partes.split(':');

        var horaCompleta = horasMinutos[0] + ':' + horasMinutos[1] + ':' + (horasMinutos[2] || '00');

        return horaCompleta
    }

    var dataSplit = timestamp.split(' ')[0];

    var partesData = dataSplit.split('-');

    var dataFormatada = partesData[2] + '-' + partesData[1] + '-' + partesData[0];

    return dataFormatada
}

let activeEscala = (id) =>
{
    fetch(url_p+`api/active-deactive?id=${id}`,
    {
        method: "GET"
    })
    .then(array => array.json())
    .then(response =>
    {
        if(response.code == 200)
        {
            getAllEscalas()

            var p = $(`<div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    ${response.msg}
                </div>`);
                p.hide()

                $('.conteudos_internos').append(p);
                p.fadeIn(500, function () {
                    window.setTimeout(function () {
                        p.fadeOut();
                    }, 2000)
                })
        }
        else
        {
            var p = $(`<div class="alert1">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    ${response.msg}
                </div>`);
                p.hide()

                $('.conteudos_internos').append(p);
                p.fadeIn(500, function () {
                    window.setTimeout(function () {
                        p.fadeOut();
                    }, 2000)
                })
        }
    })
}

let editEscala = id =>
{
    if($("#modal_escala").hasClass('d-none'))
    {
        $("#modal_escala").removeClass('d-none')
        $("#editar_escalas_modal").removeClass('d-none')
    }

    visualizeEscala(id, "Edit")

}

let visualizeEscala = (id, type="visualizar") =>
{
    if($("#modal_escala").hasClass('d-none'))
    {
        $("#modal_escala").removeClass('d-none')
        $("#visualizar_escalas").removeClass('d-none')
    }

    let data = {
        "id_escala": id,
        "filters": {}
    }
    fetch(url_p+'api/get-all-escalas-by',
    {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "content-type": "application/json"
        }
    })
    .then(json => json.json())
    .then(response =>
    {
        let escala_data = response.filter((data) =>
        {
            const keys  = Object.keys(data)

            return (
                keys.includes('active') &&
                keys.includes('data_inicio') &&
                keys.includes('hora_inicio') &&
                keys.includes('hora_fim') &&
                keys.includes('horario_mot') &&
                keys.includes('identificacao') &&
                keys.includes('salvar_escala') &&
                keys.includes('id_escala') &&
                keys.includes('escala_moto_id')
             );

        }).map((data) => {
            return {
                active: data.active,
                data_inicio: data.data_inicio,
                hora_inicio: data.hora_inicio,
                hora_fim: data.hora_fim,
                identificacao: data.identificacao,
                salvar_escala: data.salvar_escala,
                id_escala: data.id_escala,
                horario_mot: data.horario_mot,
                escala_moto_id: data.escala_moto_id
            };
        })

        let veiculos = response.filter((data) =>
        {

            const keys  = Object.keys(data)

            return keys.includes('nome_motorista')
            && keys.includes('id_motorista')
            && keys.includes("veiculos")

        }).map((data) => {

            return {
                nome_motorista: data.nome_motorista,
                id_motorista:data.id_motorista,
                veiculos: data.veiculos,
            }
        })

        const observacoes_id = [];

        response.forEach(item => {
            item.veiculos.forEach(veiculo => {
                if (veiculo.observacao !== null) {
                    observacoes_id.push(veiculo.veiculo_mot_id);
                }
            });
        });

        const escalaMotoIds = response.map(objeto => objeto.escala_moto_id);
        generateInputsVisualize(veiculos, escala_data, type, observacoes_id, escalaMotoIds)
    })
}

let generateInputsVisualize = (lista_veiculos, lista_escala, type, observacoes_id, escalaMotoIds) =>
{

    //Inserindo dados da escala em seus inputs
    if(type == "visualizar")
    {
        $("#identify_visualize").val(lista_escala[0].identificacao)
        $("#dt_ini_visualize").val(dateFormat(lista_escala[0].data_inicio))
        $("#hr_ini_visualize").val(lista_escala[0].hora_inicio)
        $("#hora_final_visualize").val(lista_escala[0].hora_fim)
    }
    else
    {
        $("#identify_edit").val(lista_escala[0].identificacao)
        $("#dt_ini_edit").val(dateFormat(lista_escala[0].data_inicio))
        $("#hr_ini_edit").val(lista_escala[0].hora_inicio)
        $("#hora_final_edit").val(lista_escala[0].hora_fim)
    }

    if(lista_escala[0].active == 0)
    {
        $("#save_escala_visualize").prop("checked", false)
        $("#not_save_escala_visualize").prop("checked", true)
    }else
    {
        $("#save_escala_visualize").prop("checked", true)
        $("#not_save_escala_visualize").prop("checked", false)
    }


    $("#container_mot_vei_visualize").empty()
    $("#container_mot_vei_edit").empty()

    let inputs_visualize = ``
    let inputs = ``

    var veiculos_PE = [];
    var motoristas_PE = [];
    var observacoes_PE = [];
    var horario_mot_PE = [];
    var preEdicoes = {};
    if (window.innerWidth <= 1366) {
        if(lista_veiculos.length < 3){
            $(".container_form_modal").css('height', 'fit-content')
            $(".modal_escalas_interno").css('height', 'fit-content')
        }
        else{
            let a = $(".container_form_modal")
            let b = $(".modal_escalas_interno")
            if (a[0].hasAttribute("style")) {
                a[0].removeAttribute("style");
            }
            if (b[0].hasAttribute("style")) {
                b[0].removeAttribute("style");
            }
            if (a[1].hasAttribute("style")) {
                a[1].removeAttribute("style");
            }
            if (b[1].hasAttribute("style")) {
                b[1].removeAttribute("style");
            }
        }
    }else{
        if(lista_veiculos.length < 4){
            $(".container_form_modal").css('height', 'fit-content')
            $(".modal_escalas_interno").css('height', 'fit-content')
        }
        else{
            let a = $(".container_form_modal")
            let b = $(".modal_escalas_interno")
            if (a[0].hasAttribute("style")) {
                a[0].removeAttribute("style");
            }
            if (b[0].hasAttribute("style")) {
                b[0].removeAttribute("style");
            }
            if (a[1].hasAttribute("style")) {
                a[1].removeAttribute("style");
            }
            if (b[1].hasAttribute("style")) {
                b[1].removeAttribute("style");
            }
        }
    }
    lista_veiculos.forEach((data, index) =>
    {
        if(type == "visualizar")
        {

            if(data.veiculos.length >= 2)
            {
                let observacao = data.veiculos.map(veiculo =>veiculo.observacao)
                inputs_visualize += `
                <div class="row col-12">
                    <div class="col-5 mb-3">
                        <label for="motorista_id_visualize">Motorista</label>
                        <select class="form-control font-weight-bold" name="motorista_id_visualize" id="motorista_id_visualize" aria-describedby="motorista_id_visualize" disabled required>
                            <option class="font-weight-bold" selected disabled value="">${data.nome_motorista}</option>
                        </select>
                    </div>
                    <div class="col-5 mb-3">
                        <label for="veiculo_id_visualize_${index}">Veiculo</label>
                        <select class="form-control font-weight-bold select2_visualize" name="veiculo_id_visualize[]" id="veiculo_id_visualize_${index}" aria-describedby="veiculo_id_visualize_${index}" multiple disabled>
                        ${data.veiculos.map(veiculo => `<option class="font-weight-bold" selected disabled value="${veiculo.veiculo_id}">${veiculo.pref}</option>`).join('')}
                        </select>
                    </div>
                    <div class="col-2 mb-3" id='container_hor${index}'>
                        <label for="horarioMotEscala">Horário</label>
                        <input class="form-control"
                        name="horarioMotEscala${index}"
                        id="horarioMotEscala${index}"
                        aria-describedby="horarioMotEscala${index}"
                        value="${!lista_escala[index].horario_mot ? "Não informado" : lista_escala[index].horario_mot}"
                        disabled>
                    </div>
                </div>`
                    var filteredArray = observacao.filter(function(element)
                    {
                        return element !== null;
                    });

                    if (filteredArray.length > 0)
                    {
                        let filtroObs = observacao.filter(Boolean);
                        inputs_visualize += `
                            <div class="row justify-content-center observacao_${index}_visual style="margin-bottom: 15px;">
                                <div class="col-md-6">
                                    <label for="observacao${index}_visual">Observação</label>
                                    <textarea id="observacao${index}_visual" class="form-control"  rows="2" cols="100" disabled>${filtroObs[filtroObs.length-1]}</textarea>
                                </div>
                            </div>`

                    }
            }else if(data.veiculos.length <= 1)
            {
                let observacao = data.veiculos.map(veiculo =>veiculo.observacao)

                inputs_visualize += `
                <div class="row col-12">
                    <div class="col-5 mb-3">
                        <label for="motorista_id_visualize">Motorista</label>
                        <select class="form-control font-weight-bold" name="motorista_id_visualize" id="motorista_id_visualize" aria-describedby="motorista_id_visualize" disabled required>
                            <option class="font-weight-bold" selected disabled value="">${data.nome_motorista}</option>
                        </select>
                    </div>
                    <div class="col-5 mb-3">
                        <label for="veiculo_id_visualize_${index}">Veiculo</label>
                        <select class="form-control font-weight-bold " name="veiculo_id_visualize" id="veiculo_id_visualize_${index}" aria-describedby="veiculo_id_visualize_${index}" disabled>
                            ${data.veiculos.map(veiculo => `<option class="font-weight-bold" selected disabled value="${veiculo.veiculo_id}">${veiculo.pref}</option>`)}
                        </select>
                    </div>
                    <div class="col-2 mb-3" id='container_hor${index}'>
                        <label for="horarioMotEscala">Horário</label>
                        <input class="form-control"
                        name="horarioMotEscala${index}"
                        id="horarioMotEscala${index}"
                        aria-describedby="horarioMotEscala${index}"
                        value="${!lista_escala[index].horario_mot ? "Não informado" : lista_escala[index].horario_mot}"
                        disabled>
                    </div>
                </div>`
                    var filteredArray = observacao.filter(function(element)
                    {
                        return element !== null;
                    });

                    if (filteredArray.length > 0)
                    {
                        let filtroObs = observacao.filter(Boolean);
                        inputs_visualize += `
                            <div class="row justify-content-center observacao_${index}_visual style="margin-bottom: 15px;">
                                <div class="col-md-6">
                                    <label for="observacao${index}_visual">Observação</label>
                                    <textarea id="observacao${index}_visual" class="form-control"  rows="2" cols="100" disabled>${filtroObs[filtroObs.length-1]}</textarea>
                                </div>
                            </div>`

                    }

            }
        }else
        {
            let observacao_exists = data.veiculos.map(veiculo =>veiculo.observacao)
            inputs +=
            `
                <div class="row col-12">
                    <div class="col-5 mb-3">
                        <label for="motorista_id_edit">Motorista</label>
                        <select class="form-control font-weight-bold" name="motorista_id_edit" id="motorista_id_edit" aria-describedby="motorista_id_edit" disabled required>
                            <option class="font-weight-bold" selected  value="">${data.nome_motorista}</option>
                            </select>
                    </div>
                    <div class="col-5 mb-3">
                        <label for="veiculo_id_edit_${index}">Veiculo</label>
                        <select class="form-control font-weight-bold select2_edit" name="veiculo_id_edit[]" id="veiculo_id_edit_${index}" onChange="adicionaObservação(${index})" aria-describedby="veiculo_id_edit_${index}" multiple>
                        ${data.veiculos.map(veiculo => `<option class="font-weight-bold" selected value="${veiculo.veiculo_id}">${veiculo.pref}</option>`).join('')}
                        </select>
                    </div>
                    <div class="col-2 mb-3" id='container_hor${index}'>
                        <label for="horarioMotEscala_edit${index}">Horário</label>
                        <input class="form-control horario_mot_edit"
                        name="horarioMotEscala${index}"
                        id="horarioMotEscala_edit${index}"
                        aria-describedby="horarioMotEscala${index}"
                        value="${!lista_escala[index].horario_mot ? "Não informado" : lista_escala[index].horario_mot}">
                    </div>
                </div>
            `
            var filteredArray_e = observacao_exists.filter(function(element) {
                return element !== null;
            });
            if (filteredArray_e.length > 0)
            {
                let filtroObs = observacao_exists.filter(Boolean);

                inputs += `
                    <div class="row justify-content-center observacao_${index}">
                        <div class="col-md-6">
                            <label for="observacao_edit${index}">Observação</label>
                            <textarea id="observacao_edit${index}" class="form-control" data-label=${data.veiculos.map(veiculo => veiculo.veiculo_mot_id)}" rows="2" cols="100">${filtroObs[filtroObs.length-1]}</textarea>
                        </div>
                    </div>`

            }else{
                inputs += `
                <div class="row justify-content-center observacao_${index} d-none">
                    <div class="col-md-6">
                        <label for="observacao_edit${index}">Observação</label>
                        <textarea id="observacao_edit${index}" class="form-control" data-label=${data.veiculos.map(veiculo => veiculo.veiculo_mot_id)}" rows="2" cols="100" placeholder="digite o motivo da alteração"></textarea>
                    </div>
                </div>`
            }
            let veiculo = data.veiculos.map(veiculo => veiculo.veiculo_id);
            veiculos_PE.push(veiculo)
            let motorista = data.id_motorista;
            motoristas_PE.push(motorista)
            let horario_mot_d = lista_escala[index].horario_mot;
            horario_mot_PE.push(horario_mot_d)


            criarVeiculosEdit(`veiculo_id_edit_${index}`, data.veiculos.map(veiculo => veiculo.pref));
        }
    })
    if(type == "visualizar")
    {

        $("#container_mot_vei_visualize").append(inputs_visualize)

    }
    else
    {
        inputs +=
        `
            <div class="col-md-12 mb-3 d-flex justify-content-end cadEscalaDiv">
                <button class="btn btn-secondary"  type="submit" id="edit_escala">Editar</button>
            </div>
        `;

        $("#container_mot_vei_edit").append(inputs)

        var inputsOPE = document.querySelectorAll("textarea[id^='observacao_edit']");
        inputsOPE.forEach(function(i)
        {
            observacoes_PE.push(i.value);
        });

        preEdicoes =
        {
            dados_basicos:{
                "identificacao": "",
                "dt_ini":"",
                "hora_ini":"",
                "hora_fim":""
            },
            "veiculo":veiculos_PE,
            "horario_mot": horario_mot_PE,
            "observacoes": observacoes_PE,
            "fk_motorista": motoristas_PE,
            "fk_escala": lista_escala[0].id_escala,

        }
        const chaves = ["identificacao", "dt_ini", "hora_ini", "hora_fim"];

        $('.edit_text').each(function(e){
            preEdicoes.dados_basicos[chaves[e]] = $(this).val();
        });





        $("#edit_escala").on('click', e =>
        {
            // $("#edit_escala").prop('disabled', true);

            e.preventDefault();

            let veiculos_E = []
            $('.select2_edit').each(function()
            {
                var selectValue = $(this).val();
                if (Array.isArray(selectValue))
                {
                    veiculos_E.push(selectValue.map(Number));
                } else
                {
                    veiculos_E.push([Number(selectValue)]);
                }
            });

            var horario_mot_E = [];
            var inputsH = document.querySelectorAll("input[id^='horarioMotEscala_edit']");

            inputsH.forEach(function(input)
            {
                horario_mot_E.push(input.value);
            });

            var observacoes_E = [];
            var observacoes_EF = [];
            var inputsO = document.querySelectorAll("textarea[id^='observacao_edit']");

            inputsO.forEach(function(input2)
            {
                observacoes_E.push(input2.value);
                let valor = input2.dataset.label.split(',').pop().replace(/"/g, '')
                observacoes_EF.push(parseInt(valor));
            });


            let edicoes = {
                dados_basicos: {
                    "identificacao": "",
                    "dt_ini": "",
                    "hora_ini": "",
                    "hora_fim": "",
                },
                "veiculo": veiculos_E,
                "id_motorista": motoristas_PE,
                "horario_mot": horario_mot_E,
                "observacoes": observacoes_E,
                "fk_escala": lista_escala[0].id_escala,
                "observacao_veic_fk": observacoes_id,
                "horario_mot_fk": escalaMotoIds,
                "veiculos_PE": veiculos_PE,
            };


            const chaves = ["identificacao", "dt_ini", "hora_ini", "hora_fim"];

            $('.edit_text').each(function (e) {
                edicoes.dados_basicos[chaves[e]] = $(this).val();
            });

            const getDifferences = (obj1, obj2) => {
                const differences = {};

                for (let key in obj1) {
                    if (key === 'observacao_veic_fk' || key === 'horario_mot_fk' || key === 'veiculos_PE' || key === 'id_motorista') {
                        continue;
                    }

                    if (typeof obj1[key] === 'object' && !Array.isArray(obj1[key])) {
                        if (!obj2.hasOwnProperty(key)) {
                            differences[key] = obj1[key];
                        } else {
                            const nestedDifferences = getDifferences(obj1[key], obj2[key]);
                            if (Object.keys(nestedDifferences).length > 0) {
                                differences[key] = nestedDifferences;
                            }
                        }
                    } else if (JSON.stringify(obj1[key]) !== JSON.stringify(obj2[key])) {
                        if (Array.isArray(obj1[key])) {
                            if (key === 'veiculo' && Array.isArray(obj1['veiculos_PE'])) {
                                differences['new_veic'] = obj1['veiculo'].map((subArray, index) => subArray.filter(item => !obj1['veiculos_PE'][index].includes(item)));
                            } else {
                                differences[key] = obj1[key];
                            }
                        } else {
                            differences[key] = [obj1[key]];
                        }
                    }
                }

                return differences;
            };

            const differences = getDifferences(edicoes, preEdicoes);




            if(Object.keys(differences).length === 0)
            {
                var p = $(`<div class="alert2">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                Nenhum dado foi alterado.
                </div>`);
                p.hide()
                $('.conteudos').append(p);
                p.fadeIn(500, function () {
                    window.setTimeout(function () {
                        p.fadeOut();
                    }, 4000)
                });
                $("#edit_escala").prop('disabled', false);
            }else
            {
                differences['observacao_veic_fk'] = observacoes_EF;
                differences['id_motorista'] = edicoes['id_motorista'];
                differences['horario_mot_fk'] = edicoes['horario_mot_fk'];
                differences['fk_escala'] = edicoes['fk_escala'];
                differences['observacoes'] = edicoes['observacoes'];

                if('new_veic' in differences && differences['observacoes'].every(elemento => elemento === ""))
                {
                    var p = $(`<div class="alert1">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    Por favor informe o motivo da adição do novo veiculo no campo de observação.
                    </div>`);
                    p.hide()
                    $('.conteudos').append(p);
                    p.fadeIn(500, function () {
                        window.setTimeout(function () {
                            p.fadeOut();
                        }, 4000)
                    });
                }else{
                    fetch(url_p+"api/edit-escala",
                    {
                        method: "POST",
                        body: JSON.stringify(differences),
                        headers: {
                            "content-type": "application/json"
                        }
                    })
                    .then(resp => resp.json())
                    .then(edit =>
                    {
                        if(edit === 1 )
                        {
                            fecharModalEditarEscala();
                            gerarGestaoEscalas();
                            var p = $(`<div class="alert">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                            Escala editada com sucesso.
                            </div>`);
                            p.hide()
                            $('.conteudos').append(p);
                            p.fadeIn(500, function () {
                                window.setTimeout(function () {
                                    p.fadeOut();
                                }, 4000)
                            });
                        }
                    });
                }
            }


        })

    }

    $('.select2_visualize').each(function()
    {
        $(this).select2({
            maximumSelectionLength: 4,
            multiple: true,
            tags: true,
            minimumResultsForSearch: 0,
            placeholder: 'Escolha um ou mais veiculos'
        });
    });
    $('.select2_edit').each(function()
    {
        $(this).select2({
            maximumSelectionLength: 4,
            multiple: true,
            tags: true,
            minimumResultsForSearch: 0,
        }).on('select2:unselecting', function (e) {
            // Cancela a remoção da opção
            e.preventDefault();
        });
    });
}


let dateFormat = (date, type="br") =>
{
    if(type == "br")
    {
        if(date == "") return null
        let partes = date.split('-')

        let ano = partes[0];
        let mes = partes[1];
        let dia = partes[2];

        let formatada = dia + "/" + mes + "/" + ano

        return formatada
    }
    else if(type == "us"){

        if(date == "") return null
        let partes = date.split('/')

        let ano = partes[2];
        let mes = partes[1];
        let dia = partes[0];

        let formatada = ano + "-" + mes + "-" + dia

        return formatada
    }
}


let fecharModalEscalas = () =>
{
    $("#icone-fechar-modal-visualize").on("click", (e) =>
    {
        e.preventDefault()

        if(!$("#modal_escala").hasClass("d-none"))
        {
            $("#visualizar_escalas").addClass('d-none')
            $("#editar_escalas_modal").addClass('d-none')
            $("#modal_escala").addClass("d-none")
            const inputs = document.querySelectorAll("input[id^='horarioMotEscala']");
            let count = 0;

            inputs.forEach(input => {
            if (count > 0) {
                input.remove();
            }
            count++;
            });


        }
    })
    $("#icone-fechar-modal-edit").on("click", (e) =>
    {
        e.preventDefault()

        fecharModalEditarEscala();
        gerarGestaoEscalas();
    })
}


let searchEscalas = () =>
{
    $("#procurar_escalas").on("click", e =>
    {
        let data = null
        e.preventDefault()
        let date_for = dateFormat($("#dt_search").val(), "us")
        if(date_for === null)
        {
            data =
            {
                "active": $("#active_s_n").val()
            }

        }else
        {
            data =
            {
                "date_filter": dateFormat($("#dt_search").val(), "us"),
                "active": $("#active_s_n").val()
            }
        }

        fetch(url_p+"api/get-all-escalas-by",
        {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                "content-type": "application/json"
            }
        })
        .then(resp => resp.json())
        .then(escalas =>
        {

            if(escalas.length >= 1)
            {
                $(".container_escalas_show").empty()
                let cards = ``
                escalas.forEach(escala =>
                {
                    cards += `<div class="card_escala">
                    <div class="indicator_active_deactive ${escala.active === 0 ? 'indicator_deactive' : 'indicator_active'}"></div>
                        <div class="container_textos_escala">
                            <div class="title_escala">
                                <h4>Identificação da Escala: </h4>
                                <h5>${escala.identificacao}</h5>
                            </div>

                            <div class="infos_iniciais_escala">
                                <div class="textos_infos_escala">
                                    <h6>Data Inicio</h6>
                                    <p>${getDateOrTime(escala.data_inicio)}</p>
                                </div>
                                <div class="textos_infos_escala">
                                    <h6>Hora Inicio</h6>
                                    <p>${getDateOrTime(escala.hora_inicio, 'time')}</p>
                                </div>
                                <div class="textos_infos_escala">
                                    <h6>Hora Fim</h6>
                                    <p>${getDateOrTime(escala.hora_fim, 'time')}</p>
                                </div>
                                <div class="textos_infos_escala">
                                    <h6>Status</h6>
                                    <p class=${escala.active === 0 ? "text-danger" : "text-success"}>${ escala.active === 0 ? 'Desativada' : 'Ativada'} <i class=${escala.active === 0 ? "fa fa-times" : "fa fa-check"} ></i></p>
                                </div>
                            </div>
                        </div>
                        <div class="container_acoes_escala">
                            <button class="${escala.active === 0 ? 'btn btn-success btn-sm btn-xs' : 'btn btn-danger btn-sm'}"  onClick="activeEscala(${escala.id})"><i class="${escala.active === 0 ? 'fa fa-check mr-2': 'fa fa-times mr-2'}"></i>${escala.active === 0 ? 'Ativar': 'Desativar'}</button>
                            <button class="btn btn-primary btn-sm btn-xs" onClick="visualizeEscala(${escala.id})" data-toggle="modal" data-target="#modalEscalas"> <i class="fa fa-eye"></i> Visualizar</button>
                            <button class="btn btn-primary btn-sm btn-xs" onClick="editEscala(${escala.id}})" data-toggle="modal" data-target="#modalEscalas"> <i class="fa fa-pen"></i> Editar</button>
                            <button disabled class="btn btn-danger btn-sm btn-xs" onClick="excludeEscala(${escala.id})"> <i class="fa fa-trash"></i> Excluir</button>
                        </div>
                    </div>`
                })
                $(".container_escalas_show").append(cards)

            }else
            {
                $(".container_escalas_show").empty()

                $(".container_escalas_show").append(`
                    <div class="sem_escalas">
                        <h5>Não foi encontrada nenhuma escala!</h5>
                    </div>
                `)

            }

        })
    })
}

function criarVeiculosEdit(idSelect, existente)
{
    fetch(url_p+`api/get_veiculo_habilitado`)
    .then(response => response.json())
    .then(data =>
    {
        let opt = ""

        data.forEach(async (veiculo) =>
        {
            if(veiculo.pref != existente){
                opt += `<option value="${veiculo.id}">${veiculo.pref}</option>`
            }
        })

        $(`#${idSelect}`).append(opt)

    })
    $(document).on('input', `#${idSelect}`, (e) =>
    {

        global_motorista = parseInt(e.target.value);

    });
}


function adicionaObservação(index)
{
    let observacao = $(`.observacao_${index}`)[0];
    if (observacao.classList.contains("d-none")) {
        observacao.classList.remove("d-none");
    }

}


function gerarGestaoEscalas()
{
    getAllEscalas()
    $('#gestao').removeClass('d-none');
    $('#formulario').addClass('d-none');

    $(".container_form").css({
        'overflow-y': "unset"
    })

    $('.aba2').css({
        cursor: 'pointer',
        width: '10vw',
        height: '100%',
        display: 'flex',
        'justify-content': 'center',
        position: 'inherit',
        'align-items': 'center',
        'background-color': 'white',
        'border-radius': '8px 8px 0px 0px',
        border: 'solid rgba(167, 162, 162, 0.653)',
        'border-width': '1px 1px 0 1px',
        'transition-property': 'background-color',
        'transition-duration': '0.5s'
    });

    $('.aba1').css({
        cursor: 'pointer',
        position: 'inherit',
        'background-color': 'transparent',
        width: '10vw',
        height: '100%',
        display: 'flex',
        color: "black",
        right: '81.6%;',
        'border': 'none',
        'justify-content': 'center',
        'align-items': 'center',
        'transition-property': 'background-color',
        'transition-duration': '0.5s',
        'border-radius': '8px 8px 0px 0px',
    });

    $(".container_form_escalas").css({
        'border-radius': '10px 10px 10px 10px'
    })
}


function fecharModalEditarEscala()
{
    if(!$("#modal_escala").hasClass("d-none"))
    {
        $("#visualizar_escalas").addClass('d-none')
        $("#editar_escalas_modal").addClass('d-none')
        $("#modal_escala").addClass("d-none")
        const inputs = document.querySelectorAll("input[id^='horarioMotEscala']");
        let count = 0;

        inputs.forEach(input => {
        if (count > 0) {
            input.remove();
        }
        count++;
        });

    }
}
