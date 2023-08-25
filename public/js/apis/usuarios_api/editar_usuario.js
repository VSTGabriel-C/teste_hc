
$('#imageE').on("change",function(){
    var nomeDoArquivo = $(this)[0].files[0].name; // obtem o nome
    $(".NFot2").val(nomeDoArquivo); // coloca o nome dentro da div 
});

let id_usuarios;
$(function()
{
    loadUsers();
})




function loadUsers()
{
    $.ajax(
        {
            method: 'GET',
            url: url_p+'api/all_users_1L',
            success: function(e)
            {
                $('.listagem_u').remove();
                let data = JSON.parse(e);
                data.forEach(function(item)
                {
                    item.data.forEach(function(dados)
                    {
                    $('#users_lista1').append(`<tr class="listagem_u" id="nome_u">
                    <th scope="row" class=" text-center align-middle">${dados.id}</th>
                    <td scope="row" class=" text-center align-middle">${dados.name}</td>
                    <td scope="row" class=" text-center align-middle">${dados.email}</td>
                    <td scope="row" class=" text-center align-middle">${dados.data}</td>
                    <td scope="row" class=" text-center align-middle ">${status_User(dados)}</td>
                    <td scope="row" class=" text-center align-middle" class="acoes_user">${button_A_D(dados)}</td>
                </tr>`);
                        })
            })
        }
        })
}
    

function status_User(data)
{
    if(data.ativo == 1)
    {
        var newStatus = `<span class="badge badge-pill badge-success "><i class="fa fa-check mr-1"></i> ATIVO</span>`
        return newStatus;
    }else if(data.ativo == 0)
    {
        var newStatus = `<span class="badge badge-pill badge-danger "><i class="fa fa-user-times mr-1"></i> INDISPONIVEL</span>`
            return newStatus;
    }
}


function button_A_D(data)
{
    let opt = ``;

    if(data.ativo == 1)
    {
        opt += `<button class="btn btn-sm btn-danger myBtnUser mr-1" id="hbl" onclick="habilit_desabilit(${data.id}, ${data.ativo});"><i class="fa fa-user mr-1"></i>Desabilitar</button>`
        opt += `<button class="btn btn-sm btn-secondary myBtnUser text-light" style="margin: 2px;" onclick="Modal_Edit_Users(${data.id});"><i class="fa fa-edit mr-1"></i>Editar</button>`
    }else if(data.ativo == 0)
    {
        opt += `<button class="btn btn-sm btn-success myBtnUser mr-1" id="hbl" onclick="habilit_desabilit(${data.id}, ${data.ativo});"><i class="fa fa-user mr-1"></i>Habilitar</button>`
        opt += `<button class="btn btn-sm btn-secondary myBtnUser text-light" style="margin: 2px;" onclick="Modal_Edit_Users(${data.id});"><i class="fa fa-edit mr-1"></i>Editar</button>`  
    }

    return opt;
}



function Modal_Edit_Users(id)
{
    document.getElementById("idE").value = id
    let idUser = id
    id_usuarios = id
    $.ajax({
        method: 'GET',
        url: url_p+`api/usuario_by_id/${idUser}`,
        data:{
            id: idUser
        },
        success: function(e)
        {
            let data = JSON.parse(e);
            data.forEach(function(item, index)
            {
                nome = item.name
                email= item.email
            })
            var modal = document.getElementById("myModal3");
            var conteudo = document.getElementById("content_modal_edit");
            document.getElementById("nome").value = nome
            document.getElementById("email").value = email
            modal.style.display = "block";
            modal.style.paddingTop = "5%";
            modal.style.paddingLeft = "100px";
            conteudo.style.width = "49%";
        }
    })
}

function edit_Usuarios()
{  
    let u_Nome = document.getElementById("nome").value;
    let u_Email = document.getElementById("email").value;
    let u_Pass = document.getElementById("password").value;
    let u_Pass_C = document.getElementById("password_C").value;
    $("#listagem_user").remove();
    $.ajax({
        method: "POST",
        url: url_p+"api/edit_usuario_by_id",
        data: {
            nome: u_Nome,
            email: u_Email,
            password: u_Pass,
            password_C: u_Pass_C,
            id: id_usuarios
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
                $('#conts_usuario_A').append(p);   
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
                $('#conts_usuario_A').append(p);       
                p.fadeIn('slow', function()
                {
                    window.setTimeout(function(){
                        p.fadeOut();
                    },2000)
                }); 
                document.getElementById('nome').value = '';
                document.getElementById('email').value = '';
                document.getElementById('password').value = '';
                document.getElementById('password_C').value = '';
            }
        }
    })
}

function modalClose2()
{
    var modal = document.getElementById("myModal3");
    modal.style.display = "none";
}

window.setTimeout(function(){
   
    $('.alert').fadeOut(6000);
    $('.alert1').fadeOut(6000)
});