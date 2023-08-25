function adcSolicitante() {
    let adc_cod = document.getElementById('adc_cod').value;
    let adc_ramal = document.getElementById('adc_ramal').value;
    let adc_nome = document.getElementById('adc_nome').value;
    let adc_sobrenome = document.getElementById('adc_sobrenome').value;
    let adc_email = document.getElementById('adc_email').value;

    if (isNaN(adc_cod) || adc_cod == "") {
        var p = $(`<div class="alert1">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        Por favor, preencha o campo Número de Matricula corretamente.
        </div>`);
        p.hide()
        $('#content_modal_adcSolic').append(p);
        p.fadeIn('slow', function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 2000)
        });;
        return false;
    }

    if (isNaN(adc_ramal) || adc_ramal == "") {
        var p = $(`<div class="alert1">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        Por favor, preencha o campo Ramal corretamente.
        </div>`);
        p.hide()
        $('#content_modal_adcSolic').append(p);
        p.fadeIn('slow', function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 2000)
        });;
        return false;
    }

    if (adc_nome == "") {
        var p = $(`<div class="alert1">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        Por favor, preencha o campo Nome.
        </div>`);
        p.hide()
        $('#content_modal_adcSolic').append(p);
        p.fadeIn('slow', function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 2000)
        });;
        return false;
    }


    if (adc_sobrenome == "") {
        var p = $(`<div class="alert1">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        Por favor, preencha o campo sobrenome.
        </div>`);
        p.hide()
        $('#content_modal_adcSolic').append(p);
        p.fadeIn('slow', function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 2000)
        });;
        return false;
    }

    let testme = validateEmail(adc_email)

    function validateEmail(email) {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }

    if (adc_email == "" || testme == false) {
        var p = $(`<div class="alert1">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        Por favor, preencha o campo Email corretamente.
        </div>`);
        p.hide()
        $('#content_modal_adcSolic').append(p);
        p.fadeIn('slow', function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 2000)
        });;
        return false;
    }


    nome = nome.replace(/( )+/g, '') + '' + sobrenome.replace(/( )+/g, '');

    $.ajax({
        method: 'POST',
        url: url_p+'api/add_new_solicitante',
        data: {
            'cod': adc_cod,
            'ramal': adc_ramal,
            'nome': adc_nome,
            'email': adc_email
        },
        success: function (e) {

            modalClose5();
            let data = JSON.parse(e);
            if (data.status == 0) {
                var p = $(`<div class="alert1">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    ${data.msg}
                    </div>`);
                p.hide()
                $('#form_geral').append(p);
                p.fadeIn(1000, function () {
                    window.setTimeout(function () {
                        p.fadeOut();
                    }, 2000)
                });
            } else if (data.status == 1) {
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
                    clear();
                    chargeComboSolicitante();
                });

            }
            window.setTimeout(function () {
                p.fadeOut();
            }, 2000)
        }
    })
}

function modalAdcSolic() {
    var modal = document.getElementById("modalAS");
    var conteudo = document.getElementById("content_modal_adcSolic");
    modal.style.display = "block";
    modal.style.paddingTop = "75px";
    modal.style.paddingLeft = "100px";
    conteudo.style.width = "49%";

}

function modalClose6() {
    var modal = document.getElementById("modalAS");
    modal.style.display = "none";
}

function clear() {
    document.getElementById('adc_cod').value = "";
    document.getElementById('adc_ramal').value = "";
    document.getElementById('adc_nome').value = "";
    document.getElementById('adc_email').value = "";
}