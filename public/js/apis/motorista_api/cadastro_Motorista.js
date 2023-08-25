$(function() {
    table()
});

function escapeHTML(s) { 
    return s.replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
}

var button_cadastrar = document.getElementById('add_motorista');
$('#staticEmail').on('keydown', function() {
    var regex = new RegExp("^[a-zA-Z0-9-Zàèìòùáéíóúâêîôûãõ \b]+$");
    var _this = this;
    // Curta pausa para esperar colar para completar
    setTimeout( function(){
        var texto = $(_this).val();
        if(!regex.test(texto))
        {
            $(_this).val(texto.substring(0, (texto.length-1)))
        }
    }, 100);
});

function cadastrar()
{
    var valor = document.getElementById('staticEmail').value;
    var valorF =  escapeHTML(valor);

    $.ajax({
        method: 'POST',
        url: url_p+'api/add_new_motorista',
        data: {'nome': valorF},
        success: function(e)
        {
            let data = JSON.parse(e);
            table();
            if(data.status == 0)
            {
                var p = $(`<div class="alert1">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                ${data.msg}
                </div>`);
                p.hide()
                $('#conteudo_motorista').append(p);   
                p.fadeIn(500, function()
                {
                    window.setTimeout(function(){
                        p.fadeOut();
                    },2000)
                }); 
                document.getElementById('staticEmail').value = '';
                
            }else if(data.status == 1)
            {
                var p = $(`<div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                ${data.msg}
                </div>`);
                p.hide()
                $('#conteudo_motorista').append(p);       
                p.fadeIn('slow', function()
                {
                    window.setTimeout(function(){
                        p.fadeOut();
                    },2000)
                }); 
                document.getElementById('staticEmail').value = '';
            }
        }
    })
}
$("#pesq").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $("#corpo_tabela_motorista tr").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});
function table()
{
    $.ajax({
        method: 'GET',
        url: url_p+'api/motorista_allL',
        success: function(e)
        {
            $('.listagem_m').remove();
            let data = JSON.parse(e);
            data.forEach(function(item)
            {
    		item.data.forEach(function(dados)
        	{
        	$('#corpo_tabela_motorista').append(`<tr class="listagem_m" id="nome_mot">
        	<th scope="row"class="acoes  text-center align-middle ">${dados.id}</th>
    		<th class="acoes nomePessoa  text-center align-middle" >${dados.nome}</th>`+
    		statusMotorista(dados.status)+
    	        `<th class="acoes  text-center align-middle">
    		<button class="btn btn-sm btn-secondary ml-4" onclick="modalEdit(`+dados.id+`)"><i class="fa fa-edit mr-1"></i>Editar</button>
        	${habilitarDesabilitar(dados)}
                </th>
    	        </tr>`);
    	     })
	})
        }
    })

    function habilitarDesabilitar(Dats)
    {
        let opt = ``
        if(Dats.h_d == 1)
        {
            opt += `<button class="btn btn-sm btn-danger" onclick="modalExclude(${Dats.id});"><i class="fa fa-user mr-1"></i>Desabilitar</button>`
        }else if(Dats.h_d == 2)
        {
            opt += `<button class="btn btn-sm btn-success" onclick="modalExclude(${Dats.id});"><i class="fa fa-user mr-1"></i>Habilitar</button>`
        }

        return opt
    }


    function statusMotorista(status)
    {
        if(status == 1)
        {
            var newStatus = `<th class="acoes text-center align-middle"><span class="badge badge-pill badge-success "><i class="fa fa-check mr-1"></i> DISPONIVEL</span></th>`
            return newStatus;
        }else if(status == 2)
        {
            var newStatus = `<th class="acoes text-center align-middle"><span class="badge badge-pill badge-primary"><i class="fa fa-shipping-fast mr-1"></i>ATENDENDO SOLICITAÇÃO</span></th>`
            return newStatus;
        }else if(status == 3)
        {
            var newStatus = `<th class="acoes text-center align-middle"><span class="badge badge-pill badge-danger "><i class="fa fa-user-times mr-1"></i> INDISPONIVEL</span></th>`
            return newStatus;
        }
    }
}



