
let id;
function excludeMotorista() { 
    let motivo = document.getElementById('edit_tipo').value;
    if (motivo == "") {
        var p = $(`<div class="alert1">
                        <span onclick="this.parentElement.style.display='none';"></span>Por favor, digite o motivo.
                        </div>`);
        $('#myModal').append(p);
        p.fadeIn(500, function () {
            window.setTimeout(function () {
                p.fadeOut();
            }, 2000)
        });
        return false;
    }
    $.ajax({
        method: 'POST',
        url: url_p+'api/motorista_delete',
        data: {
            'id': id,
            'mot': motivo
        },
        success: function (e) {
            table()
            let data = JSON.parse(e);
            if (data.status == 0) {
                $(`<div class="alert1">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                ${data.msg}
                </div>`);
                p.hide()
                $('#conteudo_motorista').append(p); // "appendê-lo" ou "appendar" o <p>
                p.fadeIn(500, function () {
                    window.setTimeout(function () {
                        p.fadeOut();
                    }, 2000)

                });
                modalClose();
            } else if (data.status == 1) {
                var p = $(`<div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                ${data.msg}
                </div>`);
                p.hide()
                $('#conteudo_motorista').append(p); // "appendê-lo" ou "appendar" o <p>
                p.fadeIn('slow', function () {
                    window.setTimeout(function () {
                        p.fadeOut();
                    }, 2000)
                });
                modalClose();
            }  else if (data.status == 3) {
                var p = $(`<div class="alert1">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                ${data.msg}
                </div>`);
                p.hide()
                $('#conteudo_motorista').append(p); // "appendê-lo" ou "appendar" o <p>
                p.fadeIn('slow', function () {
                    window.setTimeout(function () {
                        p.fadeOut();
                    }, 2000)
                });
                modalClose();
            } 
        }
    })
}
function modalExclude(ids) {
    id = ids
    var modal = document.getElementById("myModal");
    var conteudo = document.getElementById("content_modal_e")
    modal.style.display = "block";
    modal.style.paddingTop = "250px";
    conteudo.style.width = "35%";
    return id;
}
function modalClose() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
}
