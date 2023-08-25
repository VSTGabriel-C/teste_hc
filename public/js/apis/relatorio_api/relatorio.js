$("#buttonRel").on("click", function(e){
    data_ini  = $("input[name='data_ini']").val();
    data_fim  = $("input[name='data_fim']").val();
    hora_ini  = $("input[name='hora_ini']").val();
    hora_fim  = $("input[name='hora_fim']").val();
    rel_type  = document.getElementById("rel_type").value

    if(!data_ini || !data_fim || !rel_type || rel_type == "Escolha"){
        e.preventDefault();
        var p = $(`<div class="alert1">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        Campos necessários não preenchidos !
        </div>`);
        p.hide()
        $('#container_full_relatorio_msg').append(p);
        p.fadeIn(500, function()
        {
            window.setTimeout(function(){
                p.fadeOut();
            },2000)
        });
        return;
    }
});
