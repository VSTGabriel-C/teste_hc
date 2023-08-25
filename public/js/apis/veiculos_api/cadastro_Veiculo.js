$(function(){
    table_Veiculo()
})

function newVeiculo()
{
    var pref = document.getElementById('validationCustom01').value;
    var placa = document.getElementById('validationCustom02').value;
    var tipo = document.getElementById('validationCustom03').value;
    var marca = document.getElementById('validationCustom04').value;

    $.ajax({
        method: 'POST',
        url: url_p+'api/add_new_veiculo',
        data: {
            "pref": pref,
            "placa": placa,
            "tipo": tipo,
            "marca": marca
        },
        success: function(e)
        {
            let data = JSON.parse(e);
            document.getElementById('validationCustom01').value = "";
            document.getElementById('validationCustom02').value = "";
            document.getElementById('validationCustom03').value = "";
            document.getElementById('validationCustom04').value = "";
            table_Veiculo()
            if(data.status == 0)
            {
                var p = $(`<div class="alert1">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                ${data.msg}
                </div>`);
                p.hide()
                $('#cadastro_veic').append(p);          // "appendê-lo" ou "appendar" o <p>
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

function table_Veiculo()
{
    $.ajax({
        method: 'GET',
        url: url_p+'api/veiculo_all',
        success: function(e)
        {
            //$('.listagem_v').remove();
            let data = JSON.parse(e);
            $('#corpo_lista_veiculos > tr').remove();
            data.forEach(function(item)
            {
                item.data.forEach(function(dados)
                {
                    $('#corpo_lista_veiculos').append(makeTable(dados));
                    })
                })
        }
    })
}

$("#pesq").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $("#corpo_lista_veiculos tr").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});
function makeTable(item)
{
    var table = `
    <tr>
    <th scope="row" class=" text-center align-middle">${item.pref}</th>
    <th class=" text-center align-middle">${item.placa}</th>
    <th class="acoes  text-center align-middle">${item.tipo}</th>
    <th class="acoes  text-center align-middle">${item.marca}</th>`+
    verifyStatus(item.status)+`
    <th class="acoes  text-center align-middle">
        <button class="btn btn-sm btn-secondary ml-2" onclick="modalEdit(${item.id})"><i class="fa fa-edit mr-1"></i>Editar</button>
        ${habilitarDesabilitar(item)}
    </th>
  </tr>
    `;
    return table;
}
function habilitarDesabilitar(item)
{
    let opt = ``
    if(item.h_d == 1)
    {
        opt += `<button class="btn btn-sm btn-danger" onclick="modalExclude(${item.id});"><i class="fa fa-car mr-1"></i>Desabilitar</button>`
    }
    else if(item.h_d == 2)
    {
        opt += `<button class="btn btn-sm btn-success" onclick="modalExclude(${item.id});"><i class="fa fa-car mr-1"></i>Habilitar</button>`
    }
    return opt   
}

function verifyStatus(stats)
{
        if(stats == 1)
        {
            var newStatus = `<th class="acoes text-center align-middle"><span class="badge badge-pill badge-success "><i class="fa fa-check mr-1"></i> DISPONIVEL</span></th>`
            return newStatus;
        }else if(stats == 2)
        {
            var newStatus = `<th class="acoes text-center align-middle"><span class="badge badge-pill badge-primary"><i class="fa fa-shipping-fast mr-1"></i>ATENDENDO SOLICITAÇÃO</span></th>`
            return newStatus;
        }else if(stats == 3)
        {
            var newStatus = `<th class="acoes text-center align-middle"><span class="badge badge-pill badge-danger "><i class="fa fa-ambulance mr-1"></i> INDISPONIVEL</span></th>`
            return newStatus;
        }
}
