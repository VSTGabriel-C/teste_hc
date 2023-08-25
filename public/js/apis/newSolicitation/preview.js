$("#nome_paciente").on('change paste keyup input', function (e) {
    var data = $(this).val();
    $("#nome_paciente_m").val(data);
});
$("#n_ficha").on('change paste keyup input', function (e) {
    var data = $(this).val();
    $("#n_ficha_m").val(data);
});
$('#IDA').on('click', function () {
    var ida = $('#IDA:checked').length;
    if (ida == 1) {
        $('#ida_m').attr("checked", true);
    } else if (ida == 0) {
        $('#ida_m').attr("checked", false);
    }
});
$('#UTI').on('click', function () {
    var uti = $('#UTI:checked').length;
    if (uti == 1) {
        $('#uti_m').attr("checked", true);
    } else if (uti == 0) {
        $('#uti_m').attr("checked", false);
    }
});
$("#ramal_sol").on('change paste keyup input', function (e) {
    var data = $(this).val();
    $("#ramal_sol_m").val(data);
});
$('#solicitantes').on('change', function () {
    var solicitante_preview = $('#solicitantes option:selected').text();
    $('#sol_nome_m').val(solicitante_preview);
});
$('#nome_mot').on('click', function () {
    var mot_preview = $('#nome_mot option:selected').val();
    $('#nome_mot_m').val(mot_preview);
});
$('#carro_disp').on('click', function () {
    var mot_preview = $('#carro_disp option:selected').val();
    $('#carro_disp_m').val(mot_preview).text();
});

$('#hc_checkbox').on('click', function () {
    var hc = $('#hc_checkbox:checked').length;
    if (hc == 1) {
        $('#hc_m').attr("checked", true);
    } else if (hc == 0) {
        $('#hc_m').attr("checked", false);
    }
});
$('#incor_checkbox').on('click', function () {
    var incor = $('#incor_checkbox:checked').length;
    if (incor == 1) {
        $('#incor_m').attr("checked", true);
    } else if (incor == 0) {
        $('#incor_m').attr("checked", false);
    }
});

$("#end").on('change paste keyup input', function (e) {
    var data = $(this).val();
    $("#end_m").val(data);
});
$("#portaria").on('change paste keyup input', function (e) {
    var data = $(this).val();
    $("#portaria_p").val(data);
});
$("#FormDestino").on('change paste keyup input', function (e) {
    var data = $(this).val();
    $("#destino_m").val(data);
});
// Evento de delegação para o elemento pai estático
$(document).on('change paste keyup input delete', '#FormDestino2', function (e) {
    var data = $(this).val();
    $("#destino_m2").val(data);
});

$(document).on('change paste keyup input delete', '#FormDestino3', function (e) {
    var data = $(this).val();
    $("#destino_m3").val(data);
});
$(document).on('change paste keyup input delete','#FormDestino4', function (e) {
    var data = $(this).val();
    $("#destino_m4").val(data);
});
$(document).on('change paste keyup input delete', '#FormDestino5',function (e) {
    var data = $(this).val();
    $("#destino_m5").val(data);
});
$("#prevCad").on('click', function (e) {

    var dest_p = $("#FormDestino").val();
    var dest_p2 = $("#FormDestino2").val();
    $(".dest2p").attr("style", "display: " + (dest_p2 === "" || dest_p2 === null || dest_p2 === undefined ? "none !important" : "block"));
    var dest_p3 = $("#FormDestino3").val();
    $(".dest3p").attr("style", "display: " + (dest_p3 === "" || dest_p3 === null || dest_p3 === undefined ? "none !important" : "block"));
    var dest_p4 = $("#FormDestino4").val();
    $(".dest4p").attr("style", "display: " + (dest_p4 === "" || dest_p4 === null || dest_p4 === undefined ? "none !important" : "block"));
    var dest_p5 = $("#FormDestino5").val();
    $(".dest5p").attr("style", "display: " + (dest_p5 === "" || dest_p5 === null || dest_p5 === undefined ? "none !important" : "block"));

    var dest_p2 = $("#FormDestino2").val();
    var dest_p3 = $("#FormDestino3").val();
    var dest_p4 = $("#FormDestino4").val();
    var dest_p5 = $("#FormDestino5").val();
    $("#destino_m").val(dest_p);
    $("#destino_m2").val(dest_p2);
    $("#destino_m3").val(dest_p3);
    $("#destino_m4").val(dest_p4);
    $("#destino_m5").val(dest_p5);

    var data = $("#data_soli").val();
    var hora = $("#hora_sol").val();
    var hora_s = $("#sol_saida").val();
    $("#data_soli_m").val(data);
    $("#hora_m").val(hora);
    $("#saida_m").val(hora_s);
});
$("#oxigenio").on("change paste keyup input", function (e) {
    var data = $(this).val();
    $("#oxigenio_m").val(data);
});
$("#obeso").on("change paste keyup input", function (e) {
    var data = $(this).val();
    $("#obeso_m").val(data);
});
$("#isolete").on("change paste keyup input", function (e) {
    var data = $(this).val();
    $("#isolete_m").val(data);
});
$("#maca").on("change paste keyup input", function (e) {
    var data = $(this).val();
    $("#maca_m").val(data);
});
$("#ISO").on("change paste keyup input", function (e) {
    var data = $(this).val();
    $("#iso_m").val(data);
});
$("#isolamento").on('input', function (e) {
    var data = $(this).val();
    $("#isolamento_m").val(data);
});
$("#obito").on('change paste keyup input', function (e) {
    var data = $(this).val();
    $("#obito_m").val(data);
});
$("#sol_saida").on('change paste keyup input', function (e) {
    var data = $(this).val();
    $("#saida_m").val(data);
});
$("#CONTATO").on('change paste keyup input', function (e) {
    var data = $(this).val();
    $("#contato_m").val(data);
});
$("#ATENDIDA").on('change paste keyup input', function (e) {
    var data = $(this).val();
    $("#atendida_m").val(data);
});
$("#sol_km").on('change paste keyup input', function (e) {
    var data = $(this).val();
    $("#sol_km_m").val(data);
});

$('#obsevacao ').on('input', function (e) {
    var data = $(this).val();
    $('#observacao_m').val(data);
})

function limparCampos() {
    $('#nome_paciente_m').val('');
    $('#n_ficha_m').val('');
    $('#ida_m').attr("checked", false);
    $('#uti_m').attr("checked", false);
    $('#ramal_sol_m').val('');
    $('#sol_nome_m').val('');
    $('#nome_mot_m').val('');
    $('#carro_disp_m').val('');
    $('#hc_m').attr("checked", false);
    $('#incor_m').attr("checked", false);
    $('#end_m').val('');
    $('#destino_m').val('');
    $('#data_soli_m').val('');
    $('#hora_m').val("");
    $('#oxigenio_m').val('');
    $('#obeso_m').val('');
    $('#isolete_m').val('');
    $('#maca_m').val('');
    $('#iso_m').val('');
    $('#isolamento_m').val('');
    $('#obito_m').val('');
    $('#saida_m').val("");
    $('#contato_m').val('');
    $('#atendida_m').val('');
}
