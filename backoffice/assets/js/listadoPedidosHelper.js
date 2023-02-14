$( document ).ready(function() {
    /*$('#tableListadoPedidos').DataTable({
        dom: 'Brtip',
        buttons: ['csv','excel','pdf','print']
    });*/

    initListadoPedidosDatatable();

    $("#bFiltrarPedidos").on("click",function(e){
        $('#modalFiltroPedidos').modal("hide");
        mostrarLoader();
        var diaBolson = $("#lDiaBolsonFormulario").html();
        var idDiaEntrega = $("#idDiaEntregaPedido").val();
        var incluirCancelados = $("#checkIncluirCancelados").prop("checked");
        if(incluirCancelados){
            incluirCancelados = 1;
        }else{
            incluirCancelados = 0;
        }
        var soloNoValidos = $("#checkSoloNoValidos").prop("checked");
        if(soloNoValidos){
            soloNoValidos = 1;
        }else{
            soloNoValidos = 0;
        }
        var nombre = $("#filtroNombre").val();
        var mail = $("#filtroMail").val();
        var fechaDesde = $("#filtroFechaDesde").val() ? $("#filtroFechaDesde").val() : "";
        var fechaHasta = $("#filtroFechaHasta").val() ? $("#filtroFechaHasta").val() : "";
        var filtroFechasOn = $("#filtroPedidosFechasSwitch").is(':checked');
        var nroPedido = $("#filtroNroPedido").val();
        let data = {
            'diaBolson': diaBolson,
            'idDiaEntrega':  idDiaEntrega,
            'incluirCancelados':  incluirCancelados,
            'soloNoValidos': soloNoValidos,
            'nombre' : nombre,
            'mail' : mail,
            'fechaDesde': fechaDesde,
            'fechaHasta': fechaHasta,
            'nroPedido': nroPedido,
            'filtroFechasOn': filtroFechasOn
        };
        $.ajax({
            url: ajaxURL + 'orders/consultaPedidos',
            data: data,
            method: 'post'
        }).done(function(result) {
            //console.log(result.pedidos);
            cargarListadoPedidos(result.pedidos);
            ocultarLoader();
        });                

    });
    $("#bBorrarFechasFiltro").on("click",function(e){
        $("#filtroFechaDesde").val("");
        $("#filtroFechaHasta").val("");
    });
    $('body').on('change', "input[id='filtroPedidosFechasSwitch']", function(e) {
        e.preventDefault();
        let fechasEnabled = $(this).is(':checked');
        if(!fechasEnabled) {
            $("#filtroPedidosFechasSwitch").attr("data-fecha-prev-desde", $("#filtroFechaDesde").val());
            $("#filtroPedidosFechasSwitch").attr("data-fecha-prev-hasta", $("#filtroFechaHasta").val());
            $("#filtroFechaDesde").val("");
            $("#filtroFechaHasta").val("");
        } else {
            $("#filtroFechaDesde").val($("#filtroPedidosFechasSwitch").attr("data-fecha-prev-desde"));
            $("#filtroFechaHasta").val($("#filtroPedidosFechasSwitch").attr("data-fecha-prev-hasta"));
        }
    });    
});

function preFiltrar(){
    $('#modalFiltroPedidos').modal("show");
}

function cargarListadoPedidos(pedidos){
    var html = "";
    $("#tableListadoPedidosBody").html("");
    destroyListadoPedidosDatatable();
    if(pedidos!=null && pedidos.length>0){
        for(var i=0;i<pedidos.length;i++){
            if(pedidos[i].id_estado_pedido==4){
                html += "<tr class='pedidoCancelado'>";
            }else if(pedidos[i].id_estado_pedido==3){
                html += "<tr class='pedidoBonificado'>";
            }else if(pedidos[i].id_estado_pedido==2){
                html += "<tr class='pedidoEspecial'>";
            }else if(pedidos[i].id_estado_pedido==5){
                html += "<tr class='pedidoAbonado'>";
            }else{
                html += "<tr>";
            }
            html += "<td>"+pedidos[i].deliver_date+"</td>"
                html += "<td>"+pedidos[i].client_name+"</td>"
                
                if(pedidos[i].phone!=null && pedidos[i].phone!=""){
                    html += "<td>"+pedidos[i].phone+"</td>"
                }else{
                    html += "<td>-</td>";
                }
                
                if(pedidos[i].email!=null && pedidos[i].email!=""){
                    html += "<td>"+pedidos[i].email+"</td>"
                }else{
                    html += "<td>-</td>";
                }
                
                if(pedidos[i].estadoPedido!=null && pedidos[i].estadoPedido!=""){
                    html += "<td>"+pedidos[i].estadoPedido+"</td>"
                }else{
                    html += "<td>-</td>"
                }
                
                html += "<td>"+pedidos[i].nombre_barrio+"</td>"
                
                html += "<td>";
                html += "<a href='javascript:fEditarPedido("+pedidos[i].id+")'><img class='img img-responsive' src='../assets/img/edit.png' width='24'/></a>"
                html += "</td>";
                
                html += "<td>";
                html += "<a href='javascript:fReenviarMailConfirmacion("+pedidos[i].id+")'><img class='img img-responsive' src='../assets/img/send_mail.png' width='24'/></a>"
                html += "<a href='javascript:fImprimirComanda("+pedidos[i].id+")'><img class='img img-responsive' src='../assets/img/comanda.png' width='24'/></a>"                
                html += "</td>";
            html += "</tr>";
        }
    }
    $("#tableListadoPedidosBody").html(html);
    
    initListadoPedidosDatatable();
}

function fEditarPedido(idPedido){
    $("#idPedido").val(idPedido);
    if( $("#checkIncluirCancelados").prop("checked") ){
        $("#consultaIncluirCancelados").val(true);
    }else{
        $("#consultaIncluirCancelados").val(false);
    }
    if( $("#checkSoloNoValidos").prop("checked") ){
        $("#consultaSoloNoValidos").val(true);
    }else{
        $("#consultaSoloNoValidos").val(false);
    }
    if($("#filtroPedidosFechasSwitch").is(':checked')) {
        $("#consultaFechaDesde").val($("#filtroFechaDesde").val());
        $("#consultaFechaHasta").val($("#filtroFechaHasta").val());    
    } else {
        $("#consultaFechaDesde").val($("#filtroPedidosFechasSwitch").attr("data-fecha-prev-desde"));
        $("#consultaFechaHasta").val($("#filtroPedidosFechasSwitch").attr("data-fecha-prev-hasta"));    
    }
    $("#consultaIdDiaEntrega").val($("#idDiaEntregaPedido").val());
    $("#consultaNombre").val($("#filtroNombre").val());
    $("#consultaMail").val($("#filtroMail").val());
    $("#consultaNroPedido").val($("#filtroNroPedido").val());
    $("#consultaFiltroFechasOn").val($("#filtroPedidosFechasSwitch").is(':checked'));
    $('form.listadoPedidosForm').submit();
}

function editarPedido(idPedido){
    mostrarLoader();
    let data = {
        'idPedido': idPedido,
    };
    $.ajax({
        url: 'editarPedido',
        data: data,
        method: 'get'
    }).done(function(result) {
        console.log("redirecting...");
    });                

}