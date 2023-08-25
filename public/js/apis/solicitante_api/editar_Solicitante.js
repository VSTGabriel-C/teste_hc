
let id3;
function editSolicitante()
{
    let mat = document.getElementById('edit_mat').value
    let ram = document.getElementById('edit_ram').value
    let nome = document.getElementById('edit_nome').value
    let email = document.getElementById('edit_email').value
    $.ajax({
        method: "POST",
        url: url_p+`api/edit_solicitante`,
        data: {
            "id": id3, 
            "mat": mat,
            "ram": ram,
            "nome": nome,
            "email": email,
        },
        success: function(e){
            let response = JSON.parse(e)
            table_Solicitante()
            if(response.status == 0)
            {
                var p = $(`<div class="alert1">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                ${response.msg}
                </div>`);
                p.hide()
                $('#conteudo_solicitante').append(p);          // "appendê-lo" ou "appendar" o <p>
                p.fadeIn(500, function()
                {
                    window.setTimeout(function(){
                        p.fadeOut();
                    },2000)
                }); 
                
                
            }else if(response.status == 1)
            {
                var p = $(`<div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                ${response.msg}
                </div>`);
                p.hide()
                $('#conteudo_solicitante').append(p);          // "appendê-lo" ou "appendar" o <p>
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


function modalEdit(ids)
{
  id3 = ids;
  $.ajax({
      method: "GET",
      url: url_p+`api/get_solicitante_by_id/${id3}`,
      success: function(e)
      {
            let nome_m = JSON.parse(e)
            let mat
            let ram
            let nome 
            let email 
            nome_m.forEach(function(item)
            {
               mat =  item.matricula
               ram =  item.ramal
               nome =  item.nome
               email =  item.email
            })
            
            document.getElementById('edit_mat').value = mat
            document.getElementById('edit_ram').value = ram
            document.getElementById('edit_nome').value = nome
            document.getElementById('edit_email').value = email
            var modal = document.getElementById("myModal3");
            var conteudo = document.getElementById("content_modal_edit");
            modal.style.display = "block";
            modal.style.paddingTop = "75px";
            modal.style.paddingLeft = "100px";
            conteudo.style.width = "49%"; 
      }
  })

}

function modalClose2()
{
    var modal = document.getElementById("myModal3");
    modal.style.display = "none";
}