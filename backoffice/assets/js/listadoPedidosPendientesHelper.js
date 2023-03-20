$( document ).ready(function() {

    loopLoadPedidos();

    $("#bDespacharPedido").on("click", function(e){
        e.preventDefault();
        var idPedido = $("#idPedido").val();
        setDespachadoAndRefresh(idPedido);
    })

    $("#bEntregarPedido").on("click", function(e){
        e.preventDefault();
        var idPedido = $("#idPedido").val();
        setEntregadoAndRefresh(idPedido);
    })
});

function loopLoadPedidos() {
    loadPedidosPendientes();
    window.setInterval(function(){
        loadPedidosPendientes();
    }, 20000);    

}

function loadPedidosPendientes() {
    $('[data-toggle="tooltip"]').tooltip('dispose');
    var cPedidos = getPedidosPendientes();
    cargarListadoPedidos(cPedidos);
    ocultarLoader();
    initListadoPedidosPendientesDatatable();
    $(".chkDespacharPedido").on("click", function(e){
        e.preventDefault();
        var idPedido = $(this).data("id_pedido");
        preSetDespachado(idPedido);
    })
    $(".chkEntregarPedido").on("click", function(e){
        e.preventDefault();
        var idPedido = $(this).data("id_pedido");
        preSetEntregado(idPedido);
    })
}

function cargarListadoPedidos(pedidos){
    var html = "";
    $("#tableListadoPedidosBody").html("");
    destroyListadoPedidosDatatable();
    if(pedidos!=null && pedidos.length>0){
        for(var i=0;i<pedidos.length;i++){
            var classCustom = "";
            if(pedidos[i].id_estado_pedido==3){
                classCustom += " pedidoBonificado ";
            }else if(pedidos[i].id_estado_pedido==2){
                classCustom += " pedidoEspecial ";
            }else if(pedidos[i].id_estado_pedido==5){
                classCustom += " pedidoAbonado ";
            }

            html += "<tr class='" + classCustom + "'>";
            var alarma = "";
            if(pedidos[i].despachado==0){
                if(pedidos[i].alerta_pendiente_on == 1) {
                    var alertOnClass = " animate__animated animate__swing animate__infinite";
                    alarma = "<img class='img img-responsive"+alertOnClass+"' src='../assets/img/bell.png' width='24'/>";
                }
            }
            html += "<td style='text-align:center;'>"+alarma;
            if(pedidos[i].observaciones!=null && pedidos[i].observaciones!="") {
                html += "<span data-toggle='tooltip' data-placement='left' title='"+pedidos[i].observaciones+"'>";
                html += "<img class='img img-responsive' src='../assets/img/eye.png' width='24'/>";
                html += "</span>";
            }
            html += "</td>";
            html += "<td>"+pedidos[i].client_name+"</td>";
            
            if(pedidos[i].phone!=null && pedidos[i].phone!=""){
                html += "<td>"+pedidos[i].phone+"</td>";
            }else{
                html += "<td>-</td>";
            }
            
            if(pedidos[i].email!=null && pedidos[i].email!=""){
                html += "<td>"+pedidos[i].email+"</td>";
            }else{
                html += "<td>-</td>";
            }
            
            if(pedidos[i].estadoPedido!=null && pedidos[i].estadoPedido!=""){
                html += "<td>"+pedidos[i].estadoPedido+"</td>";
            }else{
                html += "<td>-</td>";
            }
            
            html += "<td>"+pedidos[i].nombre_barrio+"</td>";

            var custom_despachado_props = "";
            var custom_entregado_props = "";
            if(pedidos[i].despachado==1){
                custom_despachado_props += " checked disabled";
                custom_entregado_props = "";
            } else {
                custom_despachado_props += "";
                custom_entregado_props = " disabled";
            }
            html += '<td style="text-align:center"><input type="checkbox" class="chkDespacharPedido" data-id_pedido="'+pedidos[i].id+'" id="chkDespachado_'+pedidos[i].id+'" '+custom_despachado_props+'/></td>';
            html += '<td style="text-align:center"><input type="checkbox" class="chkEntregarPedido" data-id_pedido="'+pedidos[i].id+'" id="chkEntregado_'+pedidos[i].id+'" '+custom_entregado_props+'/></td>';

            html += "<td><a href='javascript:printComandaAndTurnOffAlarm("+pedidos[i].id+")'><img class='img img-responsive' src='../assets/img/comanda.png' width='24'/></a></td>";
            
            html += "<td><a href='javascript:fReenviarMailConfirmacion("+pedidos[i].id+")'><img class='img img-responsive' src='../assets/img/send_mail.png' width='24'/></a>";
            html += "<a href='javascript:fEditarPedido("+pedidos[i].id+")'><img class='img img-responsive' src='../assets/img/edit.png' width='24'/></a>";
            html += "</td>";
            html += "</tr>";
        }
    }
    $("#tableListadoPedidosBody").html(html);
}

function printComandaAndTurnOffAlarm(idPedido) {
    fImprimirComanda(idPedido);
    turnOffAlarmaPedido(idPedido);
    loadPedidosPendientes();
    fetchPedidosPendientes();
}

function turnOffAlarmaPedido(idPedido){
    var data = {
        "idPedido": idPedido
    };
    $.ajax({
        url: ajaxURL + 'orders/turnOffAlarmaPendiente',
        method: 'post',
        data: data,
        async: true
    }).done(function(result) {
        cPedidos = result.pedidos;
    });             
}

function fEditarPedido(idPedido){
    $("#idPedido").val(idPedido);
    $('form.listadoPedidosPendientesForm').submit();
}

function preSetDespachado(idPedido) {
    var oPedido = getPedidoById(idPedido);
    $("#idPedido").val(idPedido);
    $("#sClientePedidoADespechar").html(oPedido.client_name);
    $("#despacharPedidoConfirmationModal").modal("show");
}

function preSetEntregado(idPedido) {
    var oPedido = getPedidoById(idPedido);
    $("#idPedido").val(idPedido);
    $("#sClientePedidoAEntregar").html(oPedido.client_name);
    $("#entregarPedidoConfirmationModal").modal("show");
}

function setDespachadoAndRefresh(idPedido) {
    setDespachado(idPedido);
}

function setDespachado(idPedido) {
    var data = {
        "idPedido": idPedido
    };
    $.ajax({
        url: ajaxURL + 'orders/despacharPedido',
        method: 'post',
        data: data,
        async: false
    }).done(function(result) {
        loadPedidosPendientes();
        fetchPedidosPendientes();
        clearModalDespachado();    
    });             
}

function setEntregadoAndRefresh(idPedido) {
    setEntregado(idPedido);
}

function setEntregado(idPedido) {
    var data = {
        "idPedido": idPedido
    };
    $.ajax({
        url: ajaxURL + 'orders/entregarPedido',
        method: 'post',
        data: data,
        async: false
    }).done(function(result) {
        loadPedidosPendientes();
        fetchPedidosPendientes();
        clearModalEntregado();    
    });             
}

function clearModalDespachado(){
    $("#sClientePedidoADespechar").html("");
    $("#idPedido").val("");
    $("#despacharPedidoConfirmationModal").modal("hide");
}

function clearModalEntregado(){
    $("#sClientePedidoAEntregar").html("");
    $("#idPedido").val("");
    $("#entregarPedidoConfirmationModal").modal("hide");
}

function initListadoPedidosPendientesDatatable(){
    $('#tableListadoPedidos').DataTable({
        "bPaginate":false,
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
        "iDisplayLength": 100000
    });
    $('[data-toggle="tooltip"]').tooltip();
}