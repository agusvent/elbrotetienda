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

/************************ ALTA/EDITAR PEDIDOS *********************/

function getConfigDiaEntrega(idDiaEntrega) {
    let configDiaEntrega;
    var data = {
        "idDiaEntrega": idDiaEntrega
    }
    $.ajax({
        url: ajaxURL + 'diasEntrega/getConfigDiaEntrega/',
        method: 'post',
        data: data,
        async: false
    }).done(function(result) {
        configDiaEntrega = {
            "puntoRetiroEnabled": result.puntoRetiroEnabled,
            "deliveryEnabled": result.deliveryEnabled,
            "bolsonEnabled": result.bolsonEnabled
        }
    });
    return configDiaEntrega;
}

/********************* FIN ALTA/EDITAR PEDIDOS *********************/
/************************ LISTADOS PEDIDOS *********************/

function destroyListadoPedidosDatatable(){
    $('#tableListadoPedidos').dataTable().fnDestroy();
}

function initListadoPedidosDatatable(){
    $('#tableListadoPedidos').DataTable({
        "bPaginate":true,
        "bLengthChange": false,
        "bFilter":true,        
        "bInfo":true,
        "sPaginationType": "full_numbers",
        "oLanguage": {
                "sSearch": 'Buscar En Listado:',
                "oPaginate": {
                        "sFirst": '<<',
                        "sLast": '>>',
                        "sNext": '>',
                        "sPrevious": '<'
                },
                "sZeroRecords": 'No hay registros para mostrar',
                "sInfoFiltered": '(Utilizando filtro)',
                "sInfo": 'Mostrando _START_ a _END_ de un total de _TOTAL_',
                "sInfoEmpty": "No hay registros"
        },
        "bSort": false,
        "iDisplayLength": 15
    });
    $('[data-toggle="tooltip"]').tooltip();
}

function fImprimirComanda(idPedido) {
    mostrarLoader();
    var dt = new Date();
    var time = dt.getHours() + dt.getMinutes() + dt.getSeconds();
    let data = {
        'idPedido': idPedido,
    };
    $.ajax({
        url: ajaxURL + 'internal/printComandaPedido',
        data: data,
        method: 'post'
    }).done(function(result) {
        ocultarLoader();
        window.open(baseURL+result.fileName+"?v="+time, "popupWindow", "width=600, height=400, scrollbars=yes");
    });                    
}

function fReenviarMailConfirmacion(idPedido) {
    mostrarLoader();
    let data = {
        'idPedido': idPedido,
    };
    $.ajax({
        url: ajaxURL + 'internal/reenviarMailConfirmacion',
        data: data,
        method: 'post'
    }).done(function(result) {
        ocultarLoader();
        alert("Mail enviado.");
    });                
    
}
/************************FIN LISTADOS PEDIDOS *********************/

/*********************ALERTA PEDIDOS PENDIENTES ******************/
$( document ).ready(function() {
    loopFetchPedidosPendientes();
});

function loopFetchPedidosPendientes() {
    fetchPedidosPendientes();
    window.setInterval(function(){
        fetchPedidosPendientes();
    }, 20000);    
}

function fetchPedidosPendientes() {
    var pedidosPendientes = getPedidosPendientes();
    var cantPedidosFetch = parseInt(pedidosPendientes.length);
    var pedidosSinVer = contPedidosAlertados(pedidosPendientes);

    $("#labelPedidosPendientesAlert").html(cantPedidosFetch);
    $("#labelPedidosSinVerAlert").html(pedidosSinVer);
    if(parseInt(pedidosSinVer) > 0) {
        executeAlert();
    }
}

function getPedidosPendientes() {
    var cPedidos;
    $.ajax({
        url: ajaxURL + 'orders/pedidosPendientes',
        method: 'get',
        async: false
    }).done(function(result) {
        cPedidos = result.pedidos;
    });                
    return cPedidos;
}

function contPedidosAlertados(pedidosPendientes) {
    var cont = 0;
    for(var i=0; i<pedidosPendientes.length; i++) {
        if(pedidosPendientes[i].alerta_pendiente_on == 1) {
            cont++;
        }
    }
    return cont;
}

function executeAlert() {
    var audio = new Audio(baseURL + '/assets/sounds/alert.mp3');
    audio.pause();
    audio.play();
}
/********************* FIN ALERTA PEDIDOS PENDIENTES ******************/


function getPedidoById(idPedido){
    var pedido;
    var data = {
        "idPedido": idPedido
    };
    $.ajax({
        url: ajaxURL + 'orders/getPedidoById',
        method: 'post',
        data: data,
        async: false
    }).done(function(result) {
        pedido = result.pedido;
    });        
    return pedido;     
}
