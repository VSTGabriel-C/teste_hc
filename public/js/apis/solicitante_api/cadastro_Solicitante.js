$(function () {
    table_Solicitante()
});


function newSolicitante() {

    let cod = document.getElementById('validationCustom01').value;
    let ramal = document.getElementById('validationCustom02').value;
    let nome = document.getElementById('validationCustom03').value;
    let sobrenome = document.getElementById('validationCustom05').value;
    let email = document.getElementById('validationCustom04').value;

    if (isNaN(cod) || cod == "") {
        var p = $(`<div class="alert1">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        Por favor, preencha o campo Número de Matricula corretamente.
        </div>`);
        p.hide()
        $('#conteudo_solicitante').append(p);
        p.fadeIn('slow', function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 2000)
        });;
        return false;
    }

    if (isNaN(ramal) || ramal == "") {
        var p = $(`<div class="alert1">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        Por favor, preencha o campo Ramal corretamente.
        </div>`);
        p.hide()
        $('#conteudo_solicitante').append(p);
        p.fadeIn('slow', function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 2000)
        });;
        return false;
    }

    if (nome == "") {
        var p = $(`<div class="alert1">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        Por favor, preencha o campo Nome.
        </div>`);
        p.hide()
        $('#conteudo_solicitante').append(p);
        p.fadeIn('slow', function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 2000)
        });;
        return false;
    }
    if (sobrenome == "") {
        var p = $(`<div class="alert1">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        Por favor, preencha o campo sobrenome.
        </div>`);
        p.hide()
        $('#conteudo_solicitante').append(p);
        p.fadeIn('slow', function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 2000)
        });;
        return false;
    }

    function validateEmail(email) {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }
    let testm = validateEmail(email)

    if (email == "" || testm == false) {
        var p = $(`<div class="alert1">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        Por favor, preencha o campo Email corretamente.
        </div>`);
        p.hide()
        $('#conteudo_solicitante').append(p);
        p.fadeIn('slow', function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 2000)
        });;
        return false;
    }


    nome = nome.replace(/( )+/g, '') + ' ' + sobrenome.replace(/( )+/g, '');


    $.ajax({
        method: 'POST',
        url: url_p + 'api/add_new_solicitante',
        data: {
            'cod': cod,
            'ramal': ramal,
            'nome': nome,
            'email': email
        },
        success: function (e) {

            let data = JSON.parse(e);
            table_Solicitante();
            if (data.status == 0) {
                var p = $(`<div class="alert1">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                ${data.msg}
                </div>`);
                p.hide()
                $('#conteudo_solicitante').append(p);
                p.fadeIn(500, function () {
                    window.setTimeout(function () {
                        p.fadeOut();
                    }, 2000)
                });
                document.getElementById('validationCustom01').value = '';
                document.getElementById('validationCustom02').value = '';
                document.getElementById('validationCustom03').value = '';
                document.getElementById('validationCustom04').value = '';

            } else if (data.status == 1) {
                var p = $(`<div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                ${data.msg}
                </div>`);
                p.hide()
                $('#conteudo_solicitante').append(p);
                p.fadeIn('slow', function () {
                    window.setTimeout(function () {
                        p.fadeOut();
                    }, 2000)
                });

            }
        }
    })
}


 $("#pesq").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#corpo_tabela_solicitante tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

function table_Solicitante() {
    $.ajax({
        method: 'GET',
        url: url_p + 'api/solicitante_all',
        success: function (e) {
            $('.listagem_sol').remove();
            let data = JSON.parse(e);

            data.forEach(function (item) {
                item.data.forEach(function (dados) {
                    $('#corpo_tabela_solicitante').append(`
            <tr class="listagem_sol">
                <th scope="row" class=" text-center align-middle">${dados.matricula}</th>
                <th class=" text-center align-middle">${dados.nome}</th>
                <th class="acoes  text-center align-middle">${dados.ramal}</th>
                <th class="acoes  text-center align-middle">${dados.email}</th>
                <th class="acoes  text-center align-middle">
                    <button class="btn btn-sm btn-secondary ml-4" onclick="modalEdit(${dados.id})" ><i class="fa fa-edit mr-1"></i>Editar</button>
                    ${habilitarDesabilitar(dados)}
                </th>
            </tr> 
            `);
                })
            })
        }
    })
}

function habilitarDesabilitar(item) {
    let opt = ``
    if (item.h_d == 1) {
        opt += `<button class="btn btn-sm btn-danger" onclick="modalExclude(${item.id});"><i class="fa fa-user mr-1"></i>Desabilitar</button>`
    } else if (item.h_d == 2) {
        opt += `<button class="btn btn-sm btn-success" onclick="modalExclude(${item.id});"><i class="fa fa-user mr-1"></i>Habilitar</button>`
    }
    return opt
}