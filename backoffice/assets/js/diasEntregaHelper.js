$(document).ready(function() {
    loadDiasEntregaTable();
    $("input.numeric").numeric();

    $('body').on('change', "input[id*='dia_entrega_acepta_bolsones_']", function(e) {
        e.preventDefault();
        let idDiaEntrega = $(this).attr('data-dia-entrega-id');
        let aceptaBolsones = $(this).is(':checked') ? 1 : 0;
        setAceptaBolsonesStatus(idDiaEntrega, aceptaBolsones);
    });
});

function setAceptaBolsonesStatus(idDiaEntrega, aceptaBolsones) {
    let data = {
        'idDiaEntrega': idDiaEntrega,
        'aceptaBolsones': aceptaBolsones
    };
    $.ajax({
        url: ajaxURL + 'diasEntrega/aceptaBolsones',
        data: data,
        method: 'post',
        async: false
    }).done(function(result) {
        ocultarLoader();
        if(result.status != 'ok') {
            Swal.fire('Error', 'No se pudo modificar la opción. Intenta de nuevo.', 'error');
        }
    });
}

function getDiasEntrega() {
    var cDiasEntrega;
    $.ajax({
        url: ajaxURL + 'diasEntrega/getDiasEntrega',
        method: 'get',
        async: false
    }).done(function(result) {
        if(result.status == 'ok') {
            if(result.cDiasEntrega!=null){
                cDiasEntrega = result.cDiasEntrega;
            }
        }
    });
    return cDiasEntrega;
}

function loadDiasEntregaTable() {
    var cDiasEntrega = getDiasEntrega();
    var html = "";
    if(cDiasEntrega.length>0) {
        for(var i=0;i<cDiasEntrega.length;i++) {
            html +=" <div class='cupones-caja'>";
            html +=" <div class='cupones-caja-titulo'>"+$.format.date(cDiasEntrega[i].fechaEntrega,"dd/MM/yyyy")+"</div>";
            html +=" <div style='padding:5px;'>";
            html +=" <div class='cupones-caja-info'> ";
            html +=" <p style='text-align:center'><b>"+cDiasEntrega[i].descripcion+"</b></p>";
            html +="Acepta Bolsones:&nbsp;";
            if(cDiasEntrega[i].aceptaBolsones == 1) {
                html +=" <input data-type='checkbox-active' data-dia-entrega-id='"+cDiasEntrega[i].id_dia_entrega+"' id='dia_entrega_acepta_bolsones_"+cDiasEntrega[i].id_dia_entrega+"' type='checkbox' checked data-toggle='toggle' data-onstyle='success' data-size='xs'>";
            } else {
                html +=" <input data-dia-entrega-id='"+cDiasEntrega[i].id_dia_entrega+"' id='dia_entrega_acepta_bolsones_"+cDiasEntrega[i].id_dia_entrega+"' type='checkbox' data-toggle='toggle' data-onstyle='success' data-size='xs'>";
            }
            html +=" <span style='float:right'>";
            html +=" Acepta Pedidos: &nbsp;";
            if(cDiasEntrega[i].aceptaPedidos == 1) {
                html +=" <input data-type='checkbox-active' data-cupon-id='"+cDiasEntrega[i].id_dia_entrega+"' id='dia_entrega_acepta_pedidos_"+cDiasEntrega[i].id_dia_entrega+"' type='checkbox' checked data-toggle='toggle' data-onstyle='success' data-size='xs'>";
            } else {
                html +=" <input data-cupon-id='"+cDiasEntrega[i].id_dia_entrega+"' id='dia_entrega_acepta_pedidos_"+cDiasEntrega[i].id_dia_entrega+"' type='checkbox' data-toggle='toggle' data-onstyle='success' data-size='xs'>";
            }
            html +=" </span>";
            html +=" </div>";
            html +=" <div class='cupones-caja-info'> ";
            html +=" <p style='text-align:center'><b>Tipos de Pedido Habilitados</b></p>";
            html +="Punto de Retiro:&nbsp;";
            if(cDiasEntrega[i].puntoDeRetiroEnabled == 1) {
                html +=" <input data-type='checkbox-active' data-dia-entrega-id='"+cDiasEntrega[i].id_dia_entrega+"' id='dia_entrega_acepta_bolsones_"+cDiasEntrega[i].id_dia_entrega+"' type='checkbox' checked data-toggle='toggle' data-onstyle='success' data-size='xs'>";
            } else {
                html +=" <input data-dia-entrega-id='"+cDiasEntrega[i].id_dia_entrega+"' id='dia_entrega_acepta_bolsones_"+cDiasEntrega[i].id_dia_entrega+"' type='checkbox' data-toggle='toggle' data-onstyle='success' data-size='xs'>";
            }
            html +=" <span style='float:right'>";
            html +=" Envíos a Domicilio: &nbsp;";
            if(cDiasEntrega[i].deliveryEnabled == 1) {
                html +=" <input data-type='checkbox-active' data-cupon-id='"+cDiasEntrega[i].id_dia_entrega+"' id='dia_entrega_acepta_pedidos_"+cDiasEntrega[i].id_dia_entrega+"' type='checkbox' checked data-toggle='toggle' data-onstyle='success' data-size='xs'>";
            } else {
                html +=" <input data-cupon-id='"+cDiasEntrega[i].id_dia_entrega+"' id='dia_entrega_acepta_pedidos_"+cDiasEntrega[i].id_dia_entrega+"' type='checkbox' data-toggle='toggle' data-onstyle='success' data-size='xs'>";
            }
            html +=" </span>";
            html +=" </div>";
            html +=" <div class='cupones-caja-info'> ";
            html +=" <div class='diasEntrega-inner-caja alineado-izq'>";
                html +=" <a href='javascript:openImage(\""+cDiasEntrega[i].imagen+"\")'>";
                    html +=" <img class='img-thumbnail' src='../../assets/img/dias-entrega-imagenes/"+cDiasEntrega[i].imagen+"'/>";
                html +=" </a>";
                html +=" <br />";
                html +=" <a style='margin-left:2px;' href='javascript:editarDiaEntrega("+cDiasEntrega[i].id_dia_entrega+");'>Editar</a>";
            html +=" </div>";
            html +=" <div class='diasEntrega-inner-caja alineado-der'>";
            html +=" </div>";
            html +=" </div>";
            html +=" </div>";
            html +=" </div>";
        }
    }else{
        html = "<p style='text-align:center'>No se encontraron dias de entrega activos.</p>"
    }
    $("#diasEntregaList").html(html);
    //init de checkboxes active
    $('[data-type="checkbox-active"]').bootstrapToggle();
}

function openImage(file) {
    let html = "../../assets/img/dias-entrega-imagenes/"+file;
    window.open(html, "popupWindow", "width=600, height=400, scrollbars=yes");
}