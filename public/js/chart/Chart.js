$(function(){

    chargeCards()
})


let data = [12, 19, 34,58,44,420,800]


const ctx = document.getElementById('myChart');
const ctx2 = document.getElementById('myChart2');
const ctx3 = document.getElementById('myChart3');
let minimize1 = false;
let minimize2 = false;
let minimize3 = false;
const plugin = {
    id: 'custom_canvas_background_color',
    beforeDraw: (chart) => {
      const ctx = chart.canvas.getContext('2d');
      ctx.save();
      ctx.globalCompositeOperation = 'destination-over';
      ctx.fillStyle = 'lightGreen';
      ctx.fillRect(0, 0, chart.width, chart.height);
      ctx.restore();
    }
  };


  $.ajax({
    method: "GET",
    url: url_p+"api/get_cancelamento",
    success: function(e)
    {

        let dados = JSON.parse(e);
        var arrT = new Array();
        let arrtt = new Array();
            for (let i = 0; i < dados[0].feitasF.length; i++) {
                arrT[i] = '0';
                arrtt[i] = '0';
            }

            dados[0].datasFull.forEach((Value, Key) => {
                dados[0].datasC.forEach((Value2, Key2) => {
                        if(Value === Value2){
                         arrT[Key]=Value2;
                        }
               });
            });

            var x = 0 ;
        for (let j = 0; j < arrT.length; j++)
        {
            if(arrT[j] != '0'){
            arrT[j]=setValor(j, x);
            x++;
            }
        }

        function setValor(indice, x){
                arrtt[indice]= dados[0].Canc[x];
        }

        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dados[0].datasFull,
                datasets: [{
                    label: 'Solicitações',
                    data: dados[0].feitasF,
                    backgroundColor: [
                        'rgba(0, 107, 71, 0.5)',

                    ],
                    borderColor: [
                        'rgba(0, 107, 7, 0.5)',

                    ],
                    borderWidth: 2,
                    hoverOffset: 4
                },
                {
                    label: 'Canceladas',
                    data: arrtt,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',

                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',

                    ],
                    borderWidth: 2,

                }

            ],
            },
            options: {
                responsive: true,
                bezierCurve : true,
                tension:0.4,
                padding: 20,

                plugins: {
                    tooltip: {
                        usePointStyle: true,
                        callbacks: {
                            labelPointStyle: function(context) {
                                return {
                                    pointStyle: 'square',
                                    rotation: 0
                                };
                            }
                        }
                    }
                }
            }
        });
    }
});

$.ajax({
    method: 'GET',
    url: url_p+'api/get_solicitationPIE',
    success: function(e)
    {
        data = JSON.parse(e);
        var qtdeDP= data[0].qtde_cancelamentoP;
        var qtdeCP= data[0].qtde_concluidaP;
        var qtdeAP= data[0].qtde_andamentoP;


        const myChart2 = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Em Andamento', 'Concluidas', 'Canceladas'],
                datasets: [{
                    label: 'Solicitações',
                    data: [qtdeAP,qtdeCP,qtdeDP],
                    backgroundColor: [
                        'rgba(0, 76, 255, 0.7)',
                        'rgba(0, 137, 77, 0.9)',
                        'rgba(207, 0, 12, 0.8)'
                    ],
                    borderWidth: 2,
                    hoverOffset: 4
                }
            ],
            },
            options: {
                responsive: true,
                bezierCurve : true,
                tension:0.4,
                padding: 20
            }
        });
    }
})


$.ajax({
    method: 'GET',
    url: url_p+'api/media_kilometragem',
    success: function(e)
    {
        let data = JSON.parse(e);
        let days_week = [];
        let values = [];

        data.forEach(function(item, index){
            days_week[index] = item.dia_sem;
            values[index] = item.total
        })

        const myChart3 = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: days_week,
                datasets: [{
                    label: 'Kilometragem Total',
                    data: values,
                    backgroundColor: [
                        'rgba(0, 76, 255, 0.7)',
                        'rgba(0, 137, 77, 0.9)',
                        'rgba(207, 0, 12, 0.8)'
                    ],
                    borderColor: [
                        'rgba(0, 76, 255, 0.7)',
                        'rgba(0, 137, 77, 0.9)',
                        'rgba(207, 0, 12, 0.8)'
                    ],
                    borderWidth: 1,
                }
            ],
            },
            options: {
                responsive: true,
                hover: false
            }
        });

    }
})



$("#minus").on("click", function(e)
{
    let graf_cont = document.getElementById("meu_graf");
    let graf = document.getElementById("myChart")
    let h_g = document.getElementById("h_g")
    if(!minimize1)
    {
        graf_cont.style.height = "0px";
        graf_cont.style.width = "0px";
        graf.style.display = "none";
        h_g.style.width = "320px"
        h_g.style.borderRadius = "10px 10px 10px 10px"

        minimize1 = true;
    }else
    {
        graf_cont.style.height = "auto";
        graf_cont.style.width = "360px";
        graf.style.display = "flex";
        h_g.style.width = "360px"
        h_g.style.borderRadius = "10px 10px 0px 0px"
        minimize1 = false;
    }
})
$("#minus2").on("click", function(e)
{
    let graf_cont = document.getElementById("meu_graf2");
    let graf = document.getElementById("myChart2")
    let h_g = document.getElementById("h_g2")
    if(!minimize2)
    {
        graf_cont.style.height = "0px";
        graf_cont.style.width = "0px";
        graf.style.display = "none";
        h_g.style.width = "240px"
        h_g.style.borderRadius = "10px 10px 10px 10px"

        minimize2 = true;
    }else
    {
        graf_cont.style.height = "auto";
        graf_cont.style.width = "240px";
        graf.style.display = "flex";
        h_g.style.width = "240px"
        h_g.style.borderRadius = "10px 10px 0px 0px"
        minimize2 = false;
    }
})
$("#minus4").on("click", function(e)
{
    let conts = document.getElementById("")
    let graf_cont = document.getElementById("meu_graf4");
    let graf = document.getElementById("myChart3")
    let h_g = document.getElementById("h_g4")
    if(!minimize3)
    {
        graf_cont.style.height = "0px";
        graf_cont.style.width = "0px";
        graf.style.display = "none";
        h_g.style.width = "360px"
        h_g.style.borderRadius = "10px 10px 10px 10px"

        minimize3 = true;
    }else
    {
        graf_cont.style.height = "auto";
        graf_cont.style.width = "360px";
        graf.style.display = "flex";
        h_g.style.width = "360px"
        h_g.style.borderRadius = "10px 10px 0px 0px"
        minimize3 = false;
    }
})


// $.ajax({
//     method: "GET",
//     url: "https://177.92.121.147:8095/api/",
//     success: function(e)
//     {

//     }
// })
// var dataAtual = new Date()
// var mes = dataAtual.getMonth();
// var arrayMes = new Array(12);
// arrayMes[0] = "Janeiro";
// arrayMes[1] = "Fevereiro";
// arrayMes[2] = "Março";
// arrayMes[3] = "Abril";
// arrayMes[4] = "Maio";
// arrayMes[5] = "Junho";
// arrayMes[6] = "Julho";
// arrayMes[7] = "Agosto";
// arrayMes[8] = "Setembro";
// arrayMes[9] = "Outubro";
// arrayMes[10] = "Novembro";
// arrayMes[11] = "Dezembro";

function chargeCards()
{
    $.ajax({
        method: 'GET',
        url: url_p+'api/get_solicitation',
        success: function(e)
        {
            data = JSON.parse(e);
            data.forEach(function(item, index){
                $("#sol_diario").append(`<b>${item.qtde_dia}</b>`)
                $("#sol_concluida").append(`<b>${item.qtde_concluida}</b>`)
                $("#sol_andamento").append(`<b>${item.qtde_andamento}</b>`)
                // $("#qnt_instituto").append(`<b>${item.qtde_instituto}</b>`)
                $("#qnt_cancelamento").append(`<b>${item.qtde_cancelamento}</b>`)
                $("#qnt_quiloA").append(`<b>${item.qtde_quilometragem}</b>`)
                $("#sol_realizados").append(`<b>${item.qtde_concluida_mes}</b>`)
                // if (data.length = 0) {
                //     $("#sol_diario").append(`<b>teste/b>`)
                //     $("#sol_concluida").append(`<b>teste</b>`)
                //     $("#sol_andamento").append(`<b>teste</b>`)
                // }


            })

        }
    })
}
