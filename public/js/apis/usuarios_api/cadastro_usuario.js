$('#image').on("change",function(){
    var nomeDoArquivo = $(this)[0].files[0].name; // obtem o nome
    $(".NFot").val(nomeDoArquivo); // coloca o nome dentro da div
});

window.setTimeout(function(){
    $('.alert').fadeOut(2000);
    $('.alert1').fadeOut(2000)
});

