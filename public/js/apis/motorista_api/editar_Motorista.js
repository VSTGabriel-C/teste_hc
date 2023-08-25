let nome;
let id2;
function editMotorista()
{
    let newName = document.getElementById('edit_mot').value
    $.ajax({
        method: "POST",
        url: url_p+`api/motorista_edit`,
        data: {"id": id2, "nome": newName},
        success: function(e){

            let response = JSON.parse(e)
            table()
            if(response.status == 0)
            {
                var p = $(`<div class="alert1">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                ${response.msg}
                </div>`);
                p.hide()
                $('#conteudo_motorista').append(p);          // "appendê-lo" ou "appendar" o <p>
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
                $('#conteudo_motorista').append(p);          // "appendê-lo" ou "appendar" o <p>
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
  id2 = ids;
  $.ajax({
      method: "GET",
      url: url_p+`api/get_motorista_by_id/${id2}`,
      success: function(e)
      {
            let nome_m = JSON.parse(e)
            let nomes 
            nome_m.forEach(function(item)
            {
               nomes =  item.nome
            })            
            document.getElementById('edit_mot').value = nomes
            var modal = document.getElementById("myModal3");
            var conteudo = document.getElementById("content_modal_edit");
            modal.style.display = "block";
            modal.style.paddingTop = "190px";
            modal.style.paddingLeft = "100px";
            conteudo.style.width = "50%"; 
      }
  })
}
function modalClose1()
{
    var modal = document.getElementById("myModal3");
    modal.style.display = "none";
}
function modalClose()
{
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
}
$("#close1").on("click", function(e)
{
    var modal2 = document.getElementById("myModal3");
    if (e.target == modal2) {
        modal2.style.display = "none";
    }
})