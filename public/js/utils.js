function formatData(elementValue){
    if(elementValue){
        let dataSolicitacao = elementValue;
        dataSolicitacao = dataSolicitacao.replaceAll("/", "-");
        let dataSolicitacao_array = dataSolicitacao.split("-");
        dataSolicitacao = `${dataSolicitacao_array[2]}-${dataSolicitacao_array[1]}-${dataSolicitacao_array[0]}`
        return dataSolicitacao
    }else{
        return "";
    }
}

function trocaBarra(value){
    if (value){
        let dataBanco = value;
        dataSolicitacao = dataBanco.replaceAll("-", "/");
        let dataSolicitacao_array = dataSolicitacao.split("/");
        dataSolicitacao = `${dataSolicitacao_array[2]}/${dataSolicitacao_array[1]}/${dataSolicitacao_array[0]}`
        return dataSolicitacao
    }else{
        return "";
    }
}
