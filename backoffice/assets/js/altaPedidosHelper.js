$(document).ready(function() {
    altaPedidosHelper.init();
});

const altaPedidosHelper = {
    asignoEventos: function() {
        //ACA VAN TODOS LOS LISTENERS
        
        $("input.numeric").numeric();
        
        $("#idEstadoPedido").on("change",function(e){
            e.preventDefault();
            if($(this).val()==3 || $(this).val()==5){
                //SI ES BONIFICADO O ABONADO
                $("#lDebe").html("0");
                $("#divAltaPedidoMontoPagado").hide();
            }else{
                $("#altaPedidoMontoPagado").val(0);
                $("#divAltaPedidoMontoPagado").show();
                calcularDebe();
            }
        })

        $("#cantBolson").click(function(e){      
            $(this).attr("attr-oldValue",$(this).val());
        }); 
    
        $("#cantBolson").on("change",function() {
            var cant = $(this).val();
            var cantAnterior = $(this).attr("attr-oldValue");
            var precioADescontar = 0;
            if(parseInt($("#precioBolson").val())>0){
                precioBolson = parseInt($("#precioBolson").val());
                precioADescontar = precioBolson * cantAnterior;
                precioBolson = precioBolson * cant;
                /*if($("#idTipoPedido").val() == 2){
                    costoEnvio = parseInt($("#altaPedidoCostoEnvio").val());
                    precioBolson = precioBolson + costoEnvio;
                    precioADescontar = precioADescontar + costoEnvio;
                }*/
                subtotal = parseInt($("#lSubtotal").html());            
                subtotal = subtotal -  precioADescontar + precioBolson;
                $("#lSubtotal").html(subtotal);
                calcularDebe();
            }
        });

        $("#idBolson").on("change",function(e){
            var precioBolson = "";
            var subtotal = "";
            
            if( $(this).val()!=-1){
                $("#cantBolson").val(1);
                $("#divCantidadBolson").show();
                $.ajax({
                    url: ajaxURL + 'pockets/getBolsonPriceById/'+$(this).val(),
                    method: 'get',
                    async: 'false'
                }).done(function(result) {
                    if(result.status == 'ok') {
                        if(parseInt($("#precioBolson").val())>0){
                            precioBolson = parseInt($("#precioBolson").val());
                            subtotal = parseInt($("#lSubtotal").html());            
                            subtotal = subtotal - precioBolson;
                            $("#lSubtotal").html(subtotal);
                            calcularDebe();
                        }
                        precioBolson = parseInt(result.bolson.price);
                        $("#precioBolson").val(precioBolson);
                        subtotal = parseInt($("#lSubtotal").html());
                        subtotal = subtotal + precioBolson;
                        $("#lSubtotal").html(subtotal);
                        calcularDebe();
                    }
                }); 
            }else{
                var subtotal = parseInt($("#lSubtotal").html());
                var cantBolson = $("#cantBolson").val();
                var precioBolson = parseInt($("#precioBolson").val());
                subtotal = subtotal - (precioBolson * cantBolson);
                $("#precioBolson").val(0);  
                $("#lSubtotal").html(subtotal);    
                $("#divCantidadBolson").hide();    
                $("#cantBolson").val(-1);
                calcularDebe();
            }
        });

        $("#idTipoPedido").on("change",function(e){
            $("#ulExtrasList").html("");
            var precioBolson = "";
            var costoBolson = "";
            var subtotal = "";
            $("#lSubtotal").html("0");
            $("#lDebe").html("0");
            $("#precioBolson").val(0);
            $("#divCantidadBolson").hide();    
            $("#cantBolson").val(-1);
        //$("#altaPedidoCostoEnvio").val(0);
            $("#altaPedidoMontoPagado").val(0);
            if(!$("#idBolson").prop("disabled")) {
                $("#idBolson").val(-1);
                $("#idBolson").prop("disabled",false);
            }
            if( $(this).val()==1 ){
                //SI ES SUCURSAL
                $("#divBarrios").hide();
                $("#divDireccion").hide();
                $("#divCostoEnvio").hide();
                $("#divPuntosRetiro").show();
                $("#idBarrio").val(-1);
            }else if( $(this).val()==2 ){
                //SI ES DOMICILIO
                $("#divPuntosRetiro").hide();
                $("#divDireccion").show();
                $("#divBarrios").show();
                $("#divCostoEnvio").show();
                $("#idSucursal").val(-1);
                recalcularCostoEnvio($("#idBarrio"));
            }else{
                $("#divPuntosRetiro").hide();
                $("#divBarrios").hide();
                $("#divDireccion").hide();
                $("#divCostoEnvio").hide();
                $("#idBolson").prop("disabled",true);
                $("#idBolson").val(-1);
            }
            if( $(this).val()!=-1 ){
                $.ajax({
                    url: ajaxURL + 'extras/getExtrasByTipoPedido/'+$(this).val(),
                    method: 'get'
                }).done(function(result) {
                    if(result.status == 'ok') {
                        var html = armarHtmlExtras(result.cExtras);
                        $("#ulExtrasList").html(html);
                        initCheckboxExtras();
                        initSelectExtras();
                    }
                }); 
            }
        });

        $("#altaPedidoMontoPagado").on("change",function(e){
            calcularDebe();
        });
        $('form.altaPedidoForm').submit(function(e) {
            e.preventDefault();
            mostrarLoader();
            $("#bConfirmarPedido").prop("disabled",true);
            var diaBolson = $("#altaPedidoDiaBolson").val();
            var idDiaBolson = $("#idDiaEntregaPedido").val();
            var nombre = $("#altaPedidoNombreCompleto").val();
            var telefono = $("#altaPedidoTelefono").val();
            var mail = $("#altaPedidoMail").val();
            var direccion = $("#altaPedidoDireccion").val();
            var direccionPisoDepto = $("#altaPedidoDireccionPisoDepto").val();
            var idTipoPedido = $("#idTipoPedido").val();
            var idBarrio = $("#idBarrio").val();
            var idSucursal = $("#idSucursal").val();
            var idBolson = $("#idBolson").val();
            var cantBolson = $("#cantBolson").val();
            var montoTotal = $("#lSubtotal").html();
            var montoPagado = $("#altaPedidoMontoPagado").val();
            var idEstadoPedido = $("#idEstadoPedido").val();
            var observaciones = $("#altaPedidoObservaciones").val();
            var checkPedidoFijo = $("#altaPedidoCheckFijarPedido").prop("checked");
            var idCupon = $("#idCupon").val();
            $("#altaPedidoMontoMontoDescuento").prop("disabled",false);
            var montoDescuento = $("#altaPedidoMontoMontoDescuento").val();
            var idPedidoFijo = 0;
            if(checkPedidoFijo){
                idPedidoFijo = 1;
            }
            var extras = [];
            /*$('.chkExtras').each(function () {
                if( $(this).prop("checked")==true ){
                    extras.push($(this).val());
                }
            });*/
            $('.selectExtras').each(function () {
                if( $(this).val() > 0 ){
                    var oExtra = {
                        "idExtra": $(this).attr("attr-idExtra"),
                        "cantidad": $(this).val()
                    };

                    extras.push(oExtra);
                }
            });
            var mensajeForm = checkAltaPedidoForm();            
            if(mensajeForm!=""){
                $("#bConfirmarPedido").prop("disabled",false);
                ocultarLoader();
                return Swal.fire('Atención', mensajeForm, 'error');
            }else{
                let data = {
                    'idDiaBolson': idDiaBolson,
                    'nombre' : nombre,
                    'telefono' : telefono,
                    'mail' : mail,
                    'direccion': direccion,
                    'direccionPisoDepto': direccionPisoDepto,
                    'idTipoPedido': idTipoPedido,
                    'idBarrio': idBarrio,
                    'idSucursal': idSucursal,
                    'idBolson': idBolson,
                    'cantBolson': cantBolson,
                    'montoTotal': montoTotal,
                    'montoPagado': montoPagado,
                    'idEstadoPedido': idEstadoPedido,
                    'observaciones': observaciones,
                    'idCupon': idCupon,
                    'montoDescuento': montoDescuento,
                    'idPedidoFijo': idPedidoFijo,
                    'extras': extras
                };
                $.ajax({
                    url: ajaxURL + 'orders/crearPedido',
                    data: data,
                    method: 'post'
                }).done(function(result) {
                    if(result.status == 'ok') {
                        if(result.idPedido > 0){
                            // Limpio el formulario y escondo el modal
                            clearAltaPedidoForm();
                            return Swal.fire('Pedido creado', 'Pedido #'+result.idPedido+' creado satisfactoriamente.', 'success');
                        }else{
                            return Swal.fire('Error al crear pedido', 'No se pudo crear el pedido cargado. Intenta de nuevo.', 'error');
                        }
                    }else{
                        return Swal.fire('Error al crear pedido', 'No se pudo crear el pedido cargado. Intenta de nuevo.', 'error');
                    }
                });                
            }
        });
        $("#bReiniciarPedido").on("click",function(e){
            clearAltaPedidoForm();
        });   
        $("#idCupon").on("change",function(e){
            e.preventDefault();
            if($('option:selected', this).val()!=-1) {
                var idTipoDescuento = parseInt($('option:selected', this).attr('data-cupon-idTipoDescuento'));
                var valorDescuento = parseInt($('option:selected', this).attr('data-cupon-descuento'));
                var descuentoAnterior = parseInt($('option:selected', this).attr('data-descuento-anterior'));

                sumarDescuentoAnterior(descuentoAnterior);
                calcularDescuentoPorcentual(valorDescuento,idTipoDescuento);
            } else {
                var descuentoAnterior = parseInt($('option:selected', this).attr('data-descuento-anterior'));
                sumarDescuentoAnterior(descuentoAnterior);
                calcularDebe();
                $("#altaPedidoMontoMontoDescuento").val(0);
                $("#idCupon option").attr('data-descuento-anterior',0);
            }
        });
        $("#idBarrio").on("change",function() {
            recalcularCostoEnvio(this);
        });
        $("#idDiaEntregaPedido").on("change",function(e){
            e.preventDefault();
            let idDiaEntrega = $(this).val();
            if(idDiaEntrega >0){
                setFormByConfigDiaEntrega(getConfigDiaEntrega(idDiaEntrega));
            } else {
                $("#idTipoPedido").html("");
            }
        })
    },
    init: function() {
        this.asignoEventos();
    },
    openAltaPedido: function(){
        $('#altaPedidosModal').modal('show');
    },
    sumarSubTotal: function(){
        var subtotal = parseInt(0);
        var precioBolson = parseInt($("#precioBolson").val());
        subtotal = subtotal + precioBolson;
        $("#lSubtotal").html(subtotal);
        calcularDebe();
    }
};

function openAltaPedido(){
    altaPedidosHelper.openAltaPedido();
}

function sumarSubTotal(){
    altaPedidosHelper.sumarSubTotal();
}

function armarHtmlItemExtra(oExtra){
    var htmlExtraItem = "";
    
    htmlExtraItem = "<li>";
    htmlExtraItem += "<select id='selExtra"+oExtra.id+"' class='selectExtras' attr-idExtra='"+oExtra.id+"' attr-oldValue='0'>";
    htmlExtraItem += "<option selected value='0'>0</option>";
    if(parseInt(oExtra.stock_ilimitado)==0){
        for(var i=1;i<=parseInt(oExtra.stock_disponible);i++){
            if(i==11){
                break;
            }
            htmlExtraItem += "<option value='"+i+"'>"+i+"</option>";
        }
    }else{
        for(var i=1;i<11;i++){
            htmlExtraItem += "<option value='"+i+"'>"+i+"</option>";
        }
    }
    htmlExtraItem += "</select>";
    htmlExtraItem += "&nbsp;<label for='selExtra"+oExtra.id+"' class='form-check-label'>"+oExtra.nombre_corto+"</label>";
    htmlExtraItem += "<label class='form-check-label' style='float:right'>$"+oExtra.price+"</label>";
    htmlExtraItem += "<input type='hidden' id='extraPrice"+oExtra.id+"' value='"+oExtra.price+"'/>"; 
    htmlExtraItem += "</li>";    
    return htmlExtraItem;
}

function armarHtmlCheckbox(oExtra){
    var htmlCheckbox = "";
    htmlCheckbox = "<li>";
    htmlCheckbox += "<input type='checkbox' id='chkExtra"+oExtra.id+"' value='"+oExtra.id+"' class='chkExtras'/>&nbsp;" ;
    htmlCheckbox += "<label for='chkExtra"+oExtra.id+"' class='form-check-label'>"+oExtra.name+"</label>";
    htmlCheckbox += "<label class='form-check-label' style='float:right'>$"+oExtra.price+"</label>";
    htmlCheckbox += "<input type='hidden' id='extraPrice"+oExtra.id+"' value='"+oExtra.price+"'/>"; 
    htmlCheckbox += "</li>";
    return htmlCheckbox;
}

function armarHtmlExtras(cExtras){
    var html = "";
    for(var i=0;i<cExtras.length;i++){
        //html += armarHtmlCheckbox(cExtras[i]);
        html += armarHtmlItemExtra(cExtras[i]);
    }
    return html;
}

function initCheckboxExtras(){
    $(".chkExtras").change(function(e){       
        var idExtra = $(this).val();
        var precio = parseInt($("#extraPrice"+idExtra).val());
        var subtotal = parseInt($("#lSubtotal").html());
        if( $(this).prop("checked")){
            subtotal = subtotal + precio;
            
        }else{
            subtotal = subtotal - precio;
        }
        $("#lSubtotal").html(subtotal);
        calcularDebe();
    });    
}

function initSelectExtras(){
    $(".selectExtras").click(function(e){      
        $(this).attr("attr-oldValue",$(this).val());
    }); 

    $(".selectExtras").change(function(e){       
        var idExtra = $(this).attr("attr-idExtra");
        var precio = parseInt($("#extraPrice"+idExtra).val());
        var cantidad = $(this).val();
        var subtotal = parseInt($("#lSubtotal").html());
        if( cantidad > 0 ){
            var cantOriginal = $(this).attr("attr-oldValue");
            subtotal = subtotal - (precio*cantOriginal);

            subtotal = subtotal + (precio*cantidad);
        }else{
            var cantOriginal = $(this).attr("attr-oldValue");
            subtotal = subtotal - (precio*cantOriginal);
        }
        $("#lSubtotal").html(subtotal);
        calcularDebe();
    });    
}

function checkAltaPedidoForm(){
    var mensaje = "";
    var idDiaEntrega = $("#idDiaEntregaPedido").val();
    var nombre = $("#altaPedidoNombreCompleto").val();
    var telefono = $("#altaPedidoTelefono").val();
    var mail = $("#altaPedidoMail").val();
    var direccion = $("#altaPedidoDireccion").val();
    var idTipoPedido = $("#idTipoPedido").val();
    var idBarrio = $("#idBarrio").val();
    var idSucursal = $("#idSucursal").val();
    var idBolson = $("#idBolson").val();
    var montoPagado = $("#altaPedidoMontoPagado").val();
    var idEstadoPedido = $("#idEstadoPedido").val();
    if(idDiaEntrega==-1){
        mensaje += "<p>Debe seleccionar el Día de Entrega.</p>";
    }    
    if(nombre==""){
        mensaje += "<p>Debe ingresar el nombre del cliente.</p>";
    }
    if(telefono==""){
        mensaje += "<p>Debe ingresar el telefono del cliente.</p>";
    }
    if(mail!=""){
        var mailOK = validateEmail(mail);
        if(!mailOK){
            mensaje += "<p>El mail ingresado no es válido.</p>";
        }
    }
    if(idTipoPedido==-1){
        mensaje += "<p>Debe seleccionar un Tipo de Pedido.</p>";
    }else{
        if(idTipoPedido==1){
            //TIPO SUCURSAL
            if(idSucursal==-1){
                mensaje += "<p>Debe seleccionar un Punto de Retiro.</p>";
            }
        }else if(idTipoPedido==2){
            //TIPO DOMICILIO
            if(direccion==""){
                mensaje += "<p>Debe ingresar una dirección.</p>";
            }
            if(idBarrio==-1){
                mensaje += "<p>Debe seleccionar un Barrio.</p>";
            }
        }
    }
    /*if(idBolson==-1){
        mensaje += "<p>Debe seleccionar un Bolson.</p>";
    }*/
    
    var extras = [];
    $('.selectExtras').each(function () {
        if( $(this).val() > 0 ){
            var oExtra = {
                "idExtra": $(this).attr("attr-idExtra"),
                "cantidad": $(this).val()
            };

            extras.push(oExtra);
        }
    });

    if(idBolson==-1 && extras.length==0){
        mensaje += "<p>Debe seleccionar un bolson o agregar productos extras al pedido.</p>";
    }
    if(idEstadoPedido==-1){
        mensaje += "<p>Debe seleccionar un Estado del Pedido.</p>";
    }
    return mensaje;
}

function clearAltaPedidoForm(){
    mostrarLoader();
    $("#idDiaEntregaPedido").val(-1);
    $("#altaPedidoNombreCompleto").val("");
    $("#altaPedidoTelefono").val("");
    $("#altaPedidoMail").val("");
    $("#altaPedidoDireccion").val("");
    $("#altaPedidoDireccionPisoDepto").val("");
    $("#divDireccion").hide();
    $("#idTipoPedido").val(-1);
    $("#idTipoPedido").html("");
    $("#idBarrio").val(-1);
    $("#divBarrios").hide();
    $("#divCostoEnvio").hide();
    //$("#altaPedidoCostoEnvio").val("")
    $("#idSucursal").val(-1);
    $("#divPuntosRetiro").hide();
    $("#idBolson").val(-1);
    $("#divCantidadBolson").hide();    
    $("#cantBolson").val(-1);
    $("#altaPedidoMontoPagado").val("0");
    $("#idEstadoPedido").val(-1);
    $("#lSubtotal").html("0");
    $("#lDebe").html("0");
    $("#ulExtrasList").html("");
    $("#altaPedidoObservaciones").val("");
    $("#bConfirmarPedido").prop("disabled",false);
    $("#idCupon").val(-1);
    $("#altaPedidoMontoMontoDescuento").val(0);
    $("#altaPedidoMontoMontoDescuento").prop("disabled",true);
    ocultarLoader();
}

function calcularDebe(){
    if($("#idEstadoPedido").val()!=3 && $("#idEstadoPedido").val()!=5){
        var montoPagado = parseInt($("#altaPedidoMontoPagado").val());
        var subtotal = parseInt($("#lSubtotal").html());
        /*
        var costoEnvio = parseInt($("#altaPedidoCostoEnvio").val());
        
        if(costoEnvio>0) {
            subtotal = subtotal + costoEnvio;
        }
        */
        if(montoPagado>0){
            if(montoPagado == subtotal){
                $("#lDebe").html(0);
            }else{
                if(montoPagado < subtotal){
                    var lDebe = parseInt($("#lDebe").html());
                    lDebe = subtotal - montoPagado;
                    $("#lDebe").html(lDebe);
                }else{
                    return Swal.fire('Atención', 'El monto pagado no puede ser mayor al total del pedido.', 'success');
                }
            }
        }else{
            $("#lDebe").html(subtotal);
        }
    }
}

function getCostoEnvioPedidos(){
    var costoEnvio = 0;
    $.ajax({
        url: baseURL + 'ordenes/getCostoEnvioPedidos/',
        method: 'post',
        async: false
    }).done(function(result) {
        costoEnvio = result.costoEnvioPedidos;
    });
    return costoEnvio;
}

function getCostoEnvioByBarrio(){
    var costoEnvio = 0;
    var data = {
        "idBarrio": idBarrio
    }
    $.ajax({
        url: baseURL + 'ordenes/getCostoByBarrio/',
        method: 'post',
        async: false
    }).done(function(result) {
        costoEnvio = result.costoEnvioPedidos;
    });
    return costoEnvio;
}

function calcularDescuentoPorcentual(descuento, idTipoDescuento) {
    if(descuento!=null && idTipoDescuento!=null) {
        var montoDescuento = 0;
        if(idTipoDescuento == 2) {
            var total = $("#lSubtotal").html();
            //Math.ceil me lleva el resultado al primer integer mayor. Si me da 1789,32, me devuelve 1790.
            montoDescuento = Math.ceil(((descuento*total)/100));
        } else {
            montoDescuento = descuento;
        }
        montoDescuento = parseInt(montoDescuento)
        $("#altaPedidoMontoMontoDescuento").val(montoDescuento);
        var subtotal = parseInt($("#lSubtotal").html());
        subtotal = subtotal - montoDescuento;
        $("#lSubtotal").html(subtotal);
        calcularDebe();
        $("#idCupon option").attr('data-descuento-anterior',montoDescuento);
    }
}

function sumarDescuentoAnterior(descuentoAnterior){
    if(descuentoAnterior>0){
        var subtotal = parseInt($("#lSubtotal").html());
        subtotal = subtotal + descuentoAnterior;
        $("#lSubtotal").html(subtotal);    
    }
}

function recalcularCostoEnvio(select) {
    let costoEnvio = parseInt($('option:selected', select).attr('data-barrio-costoEnvio'));
    let costoEnvioAnterior = parseInt($('option:selected', select).attr('data-barrio-costoEnvioAnterior'));
    $("#altaPedidoCostoEnvio").val(costoEnvio);
    let subtotal = parseInt($("#lSubtotal").html());
    if(subtotal>0){
        subtotal = subtotal - costoEnvioAnterior;
    }
    subtotal = subtotal + costoEnvio;
    $("#lSubtotal").html(subtotal)
    calcularDebe();
    $("#idBarrio option").attr('data-barrio-costoEnvioAnterior',costoEnvio);   
}

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

function setFormByConfigDiaEntrega(configDiaEntrega) {
    var html = "<option value='-1' selected>Seleccione</option>";
    if(configDiaEntrega.puntoRetiroEnabled == 1) {
        html += "<option value='1'>Sucursal</option>";
    }
    if(configDiaEntrega.deliveryEnabled == 1) {
        html += "<option value='2'>Domicilio</option>";
    }
    $("#idTipoPedido").html(html);

    if(configDiaEntrega.bolsonEnabled == 1) {
        $("#idBolson").prop("disabled",false);
    }else{
        $("#idBolson").prop("disabled",true);
    }
}