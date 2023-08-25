
let id2;
function editVeiculo()
{
    let newPref = document.getElementById('edit_pref').value
    let newTipo = document.getElementById('edit_tipo').value
    let newPlaca = document.getElementById('edit_placa').value
    let newMarca = document.getElementById('edit_marca').value
    $.ajax({
        method: "POST",
        url: url_p+`api/veiculo_edit`,
        data: {
            "id": id2, 
            "pref": newPref,
            "tipo": newTipo,
            "placa": newPlaca,
            "marca": newMarca,
        },
        success: function(e){

            let response = JSON.parse(e)
            table_Veiculo()
            if(response.status == 0)
            {
                var p = $(`<div class="alert1">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                ${response.msg}
                </div>`);
                p.hide()
                $('#cadastro_veic').append(p);          // "appendê-lo" ou "appendar" o <p>
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
                $('#cadastro_veic').append(p);          // "appendê-lo" ou "appendar" o <p>
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
      url: url_p+`api/get_veiculo_by_id/${id2}`,
      success: function(e)
      {
            let nome_m = JSON.parse(e)
            let pref
            let tipo 
            let placa 
            let marca 
            nome_m.forEach(function(item)
            {
               pref =  item.pref
               tipo =  item.tipo
               placa =  item.placa
               marca =  item.marca
            })
            
            document.getElementById('edit_pref').value = pref
            document.getElementById('edit_tipo').value = tipo
            document.getElementById('edit_placa').value = placa
            document.getElementById('edit_marca').value = marca
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