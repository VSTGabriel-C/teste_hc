$(function () {
    warning()
})
$("#botao_warning").on("click", function () {
    window.location.href = url_p + 'hc_aviso';
    // location.href='https://177.92.121.147:8095/hc_aviso'
});


function warning() {
    $.ajax({
        method: 'GET',
        url: url_p + 'api/warnings',
        success: function (e) {
            let data = JSON.parse(e)
            $("#connteents").append(makeWarning(data[0].status, data[0].qtde));

        }
    })
}


function makeWarning(status, qtde) {
    let div = ``;
    if (status == 'ok' && window.location.href != url_p + 'hc_aviso') {
        div += `
        <div class="container_warning " id="warning_container">
            <div class="header_warning">
                <div class="container-span">
                    <span><i class="fa fa-exclamation-triangle"></i> Aviso importante !</span>
                </div>
                <div class="crox" id="fechar_x" onClick="fecharWarning();">X</div>
            </div>
            <div class="texto_warning">
                <span class="text_principal">Ainda existem solicitações em aberto de dias anteriores por favor as feche para continuar.</span><br><br>
                <span class="text_qtde">Quantidade de solicitações em aberto: ${qtde}</span>
            </div>
            <div class="footer_warning">
            <button name='botWar'class="botao_warning" onClick="location.href='${url_p}hc_aviso';fecharWarning();">Ver Solicitações</button>
                <button name='botWarClose'class="botao_warning" onClick="fecharWarning();">Ok, Entendi</button>
            </div>
        </div>`;
    } else {
        div = ``
    }

    return div;
}



function fecharWarning() {

    let warning = document.getElementById("warning_container")

    warning.style.display = "none"

}