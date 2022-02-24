function mostrarLoader(){
    $(".loading").show();
}

function ocultarLoader(){
    $(".loading").hide();
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function mostrarLoaderCallback(callback){
    $(".loading").show();
    return true;
}

function getCostoEnvioPedidosExtras(){
    var costoEnvioPedidosExtras = 0;
    $.ajax({
        url: baseURL + 'ordenes/getCostoEnvioPedidosExtras/',
        method: 'get',
        async: false,
    }).done(function(result) {
        if(result.status=200){
            costoEnvioPedidosExtras = result.costoEnvioPedidoExtras
        }
    }); 
    return costoEnvioPedidosExtras;
}