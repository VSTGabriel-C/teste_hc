
function habilit_desabilit(id_user, ativo_user)
{
    let ids = id_user;
    let atv = ativo_user

    $.ajax({
        method: "POST",
        url: url_p+"api/habilitar_desabilitar",
        data:{
            id: ids,
            ativo: atv
        },
        success: function(e)
        {
            let data = JSON.parse(e);
            loadUsers()
            if(data.status == 0)
            {
                var p = $(`<div class="alert1">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                ${data.msg}
                </div>`);
                p.hide()
                $('#conts_usuario_A').append(p);          // "appendê-lo" ou "appendar" o <p>
                p.fadeIn(500, function()
                {
                    window.setTimeout(function(){
                        p.fadeOut();
                    },2000)
                }); 
                
                
            }else if(data.status == 1)
            {
                var p = $(`<div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                ${data.msg}
                </div>`);
                p.hide()
                $('#conts_usuario_A').append(p);          // "appendê-lo" ou "appendar" o <p>
                p.fadeIn('slow', function()
                {
                    window.setTimeout(function(){
                        p.fadeOut();
                    },2000)
                }); 
                
            }
        }
    })
}