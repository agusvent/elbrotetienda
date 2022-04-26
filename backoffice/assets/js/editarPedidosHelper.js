$(document).ready(function() {
    mostrarLoader();
    editarPedidosHelper.init();
    setTimeout(function(){
        hideShowFields($("#editarPedidoIdTipoPedido").val());
        var tieneBolson = 0;
        tieneBolson = $("#tieneBolson").val();
        if(tieneBolson == 1) {
            $("#divCantidadBolson").show();
        }    
        ocultarLoader();
    },500);
    
});

const editarPedidosHelper = {
    asignoEventos: function() {
        //ACA VAN TODOS LOS LISTENERS
        
        $("input.numeric").numeric();
        
        $("#editarPedidoIdEstadoPedido").on("change",function(e){
            e.preventDefault();
            if($(this).val()==3 || $(this).val()==5){
                //SI ES BONIFICADO O ABONADO
                $("#lEditarPedidoDebe").html("0");
                $("#divEditarPedidoMontoPagado").hide();
            }else{
                $("#editarPedidoMontoPagado").val(0);
                $("#divEditarPedidoMontoPagado").show();
                editarPedidoCalcularDebe();
            }
        })

        $("#editarPedidoIdBolson").on("change",function(e){
            var precioBolsonOriginal = $("#precioBolson").val();
            var precioBolson = "";
            var subtotal = "";

            /*if(precioBolsonOriginal==""){
                //ESTO PUEDE SER SI ES UN PEDIDO UNICAMENTE DE EXTRAS
                precioBolsonOriginal = 0;
            }

            precioBolsonOriginal = parseInt(precioBolsonOriginal);
            subtotal = parseInt($("#lEditarPedidoSubtotal").html());
            subtotal = subtotal - precioBolsonOriginal;
            $("#lEditarPedidoSubtotal").html(subtotal);
            //editarPedidoCalcularDebe();
            */
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
                            editarPedidoCalcularDebe();
                        }


                        precioBolson = parseInt(result.bolson.price);
                        $("#precioBolson").val(precioBolson);
                        subtotal = parseInt($("#lEditarPedidoSubtotal").html());
                        subtotal = subtotal + precioBolson;
                        $("#lEditarPedidoSubtotal").html(subtotal);
                        editarPedidoCalcularDebe();
                    }
                }); 
            }else{
                var subtotal = parseInt($("#lEditarPedidoSubtotal").html());
                var cantBolson = $("#cantBolson").val();
                var precioBolson = parseInt($("#precioBolson").val());
                subtotal = subtotal - (precioBolson * cantBolson);

                $("#precioBolson").val(0);
                $("#lEditarPedidoSubtotal").html(subtotal);    
                $("#divCantidadBolson").hide();    
                $("#cantBolson").val(-1);
                editarPedidoCalcularDebe();
            }
        });

        $("#editarPedidoIdTipoPedido").on("change",function(e){
            var idTipoPedido = $(this).val();
            $("#ulExtrasList").html("");
            $("#divCantidadBolson").hide();    
            $("#cantBolson").val(-1);
            $("#lEditarPedidoSubtotal").html("0");
            $("#lEditarPedidoDebe").html("0");
            $("#precioBolson").val(0);
            $("#precioDeliveryBolson").val(0);
            $("#editarPedidoCostoEnvio").val(0);
            $("#editarPedidoMontoPagado").val(0);
            $("#editarPedidoIdBolson").val(-1);
            $("#idCupon").val(-1);
            $("#editarPedidoMontoDescuento").val(0);
            //$("#editarPedidoIdBolson").prop("disabled",false);
            hideShowFields(idTipoPedido);
            cargarExtras(idTipoPedido);
            /*if(idTipoPedido==2){
                costoEnvio = parseInt(getCostoEnvio());
                $("#editarPedidoCostoEnvio").val(costoEnvio);
                $("#lEditarPedidoSubtotal").html(costoEnvio);
                editarPedidoCalcularDebe();        
            }*/
        });

        $("#editarPedidoMontoPagado").on("change",function(e){
            editarPedidoCalcularDebe();
        });
        
        $("#bCancelarEditar").on("click",function(e){
            $("#accion").val("cancelar");
            $("form.editarPedidoForm").submit();
        });

        $("#bReiniciarPedido").on("click",function(e){
            clearEditarPedidoForm();
        });      

        $("#bGrabarEditar").on("click",function(e){
            e.preventDefault();
            mostrarLoader();
            $("#bGrabarEditar").prop("disabled",true);
            var idPedido = $("#editarPedidoIdPedido").val();
            var idDiaEntrega = $("#idDiaEntregaPedido").val();
            var nombre = $("#editarPedidoNombreCompleto").val();
            var telefono = $("#editarPedidoTelefono").val();
            var mail = $("#editarPedidoMail").val();
            var direccion = $("#editarPedidoDireccion").val();
            var direccionPisoDepto = $("#editarPedidoDireccionPisoDepto").val();
            var idTipoPedido = $("#editarPedidoIdTipoPedido").val();
            var idBarrio = $("#editarPedidoIdBarrio").val();
            var idSucursal = $("#editarPedidoIdSucursal").val();
            var idBolson = $("#editarPedidoIdBolson").val();
            var cantBolson = $("#cantBolson").val();
            var montoTotal = $("#lEditarPedidoSubtotal").html();
            var montoPagado = $("#editarPedidoMontoPagado").val();
            var idEstadoPedido = $("#editarPedidoIdEstadoPedido").val();
            var observaciones = $("#editarPedidoObservaciones").val();
            var idCupon = $("#idCupon").val();
            var montoDescuento = $("#editarPedidoMontoDescuento").val();
            var checkPedidoFijo = $("#editarPedidoCheckFijarPedido").prop("checked");
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
            console.log(extras);
            var mensajeForm = checkEditarPedidoForm();            
            if(mensajeForm!=""){
                $("#bGrabarEditar").prop("disabled",false);
                ocultarLoader();
                return Swal.fire('Atención', mensajeForm, 'error');
            }else{
                let data = {
                    'idPedido': idPedido,
                    'idDiaEntrega': idDiaEntrega,
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
                    url: ajaxURL + 'orders/editarPedido',
                    data: data,
                    method: 'post'
                }).done(function(result) {
                    if(result.status == 'ok') {
                        if(result.idPedido > 0){
                            $("#accion").val("volver");
                            $("form.editarPedidoForm").submit();                                            
                        }else{
                            return Swal.fire('Error', 'Hubo un error al editar el pedido. Intenta de nuevo.', 'error');
                        }
                    }else{
                        return Swal.fire('Error', 'Hubo un error al editar el pedido. Intenta de nuevo.', 'error');
                    }
                });                
            }
        });

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
                if($("#editarPedidoIdTipoPedido").val() == 2){
                    costoEnvio = parseInt($("#editarPedidoCostoEnvio").val());
                    precioBolson = precioBolson + costoEnvio;
                    precioADescontar = precioADescontar + costoEnvio;
                }
                subtotal = parseInt($("#lEditarPedidoSubtotal").html());            
                subtotal = subtotal -  precioADescontar + precioBolson;
                $("#lEditarPedidoSubtotal").html(subtotal);
                editarPedidoCalcularDebe();
            }
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
                var descuentoAnterior = parseInt($("#idCupon option:selected").attr('data-descuento-anterior'));
                sumarDescuentoAnterior(descuentoAnterior);
                editarPedidoCalcularDebe();
                $("#editarPedidoMontoDescuento").val(0);
                $("#idCupon option").attr('data-descuento-anterior',0);
            }
        });

        $("#editarPedidoIdBarrio").on("change",function() {
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
    sumarSubTotal: function(){
        var subtotal = parseInt(0);
        var precioBolson = parseInt($("#precioBolson").val());
        subtotal = subtotal + precioBolson;
        $("#lEditarPedidoSubtotal").html(subtotal);
        editarPedidoCalcularDebe();
    }
};

function sumarSubTotal(){
    editarPedidosHelper.sumarSubTotal();
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
        html += armarHtmlCheckbox(cExtras[i]);
    }
    return html;
}

function checkEditarPedidoForm(){
    var mensaje = "";
    var nombre = $("#editarPedidoNombreCompleto").val();
    var telefono = $("#editarPedidoTelefono").val();
    var mail = $("#editarPedidoMail").val();
    var direccion = $("#editarPedidoDireccion").val();
    var idTipoPedido = $("#editarPedidoIdTipoPedido").val();
    var idBarrio = $("#editarPedidoIdBarrio").val();
    var idSucursal = $("#editarPedidoIdSucursal").val();
    var idBolson = $("#editarPedidoIdBolson").val();
    var montoPagado = $("#editarPedidoMontoPagado").val();
    var idEstadoPedido = $("#editarPedidoIdEstadoPedido").val();
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
    if(idEstadoPedido==-1){
        mensaje += "<p>Debe seleccionar un Estado del Pedido.</p>";
    }
    return mensaje;
}

function clearEditarPedidoForm(){
    mostrarLoader();
    $("#editarPedidoNombreCompleto").val("");
    $("#editarPedidoTelefono").val("");
    $("#editarPedidoMail").val("");
    $("#editarPedidoDireccion").val("");
    $("#editarPedidoDireccionPisoDepto").val("");
    $("#divDireccion").hide();
    $("#editarPedidoIdTipoPedido").val(-1);
    $("#editarPedidoIdBarrio").val(-1);
    $("#divBarrios").hide();
    $("#divCostoEnvio").hide();
    $("#editarPedidoCostoEnvio").val("")
    $("#editarPedidoIdSucursal").val(-1);
    $("#divPuntosRetiro").hide();
    $("#editarPedidoIdBolson").val(-1);
    $("#editarPedidoMontoPagado").val("0");
    $("#editarPedidoIdEstadoPedido").val(-1);
    $("#lEditarPedidoSubtotal").html("0");
    $("#lEditarPedidoDebe").html("0");
    $("#ulExtrasList").html("");
    $("#editarPedidoObservaciones").val("");
    $("#bConfirmarPedido").prop("disabled",false);
    ocultarLoader();
}


function hideShowFields(idTipoPedido){

    //SI ES BONIFICADO OCULTO MONTO PAGADO
    if($("#editarPedidoIdEstadoPedido").val()==3 || $("#editarPedidoIdEstadoPedido").val()==5){
        $("#divEditarPedidoMontoPagado").hide();
    }

    if( idTipoPedido == 1 ){
        //SI ES SUCURSAL
        $("#divBarrios").hide();
        $("#divDireccion").hide();
        $("#divCostoEnvio").hide();
        $("#divPuntosRetiro").show();
    }else if( idTipoPedido == 2 ){
        //SI ES DOMICILIO
        $("#divPuntosRetiro").hide();
        $("#divDireccion").show();
        $("#divBarrios").show();
        $("#divCostoEnvio").show();
        cargarExtras(idTipoPedido);
    }else{
        $("#divPuntosRetiro").hide();
        $("#divBarrios").hide();
        $("#divDireccion").hide();
        $("#divCostoEnvio").hide();
        $("#editarPedidoIdBolson").prop("disabled",true);
        $("#editarPedidoIdBolson").val(-1);
    }

    //Cargo los extras visibles dependiendo del tipo de pedido y que tengan stock>0 o stock ilimitado
    cargarExtras(idTipoPedido);
    

    //Cargo los extras del pedido y los marco en los select de los extras cargados con la funcion cargarExtras
    var idPedido = $("#editarPedidoIdPedido").val();
    var cExtras = getExtrasByIdPedido(idPedido);
    //console.log(cExtras);
    for(var i=0;i<cExtras.length;i++){
        //console.log("ESTE VA: ",cExtras[i].id);
        if( $("#selExtra"+cExtras[i].id).length>0 ){
            //ESTO QUIERE DECIR QUE EL ELEMENTO EXISTE DIBUJADO EN PANTALLA
            $("#selExtra"+cExtras[i].id).val(cExtras[i].cant);
            $("#selExtra"+cExtras[i].id).prop("disabled",false);
        }
    }
}

function cargarExtras(idTipoPedido){
    if( idTipoPedido != -1 ){
        $.ajax({
            url: ajaxURL + 'extras/getExtrasByTipoPedidoForEditPedido/'+idTipoPedido,
            method: 'get',
            async: false,
        }).done(function(result) {
            if(result.status == 'ok') {
                var html = editarPedidoArmarHtmlExtras(result.cExtras);
                $("#ulExtrasList").html(html);
                //editarPedidoInitCheckboxExtras();
                editarPedidoInitSelectExtras();
            }
        }); 
    }    
}

function getExtrasByIdPedido(idPedido){
    var cExtras;
    $.ajax({
        url: ajaxURL + 'extras/getExtrasByIdPedido/'+idPedido,
        method: 'get',
        async: false,
    }).done(function(result) {
        if(result.status == 'ok') {
            cExtras = result.cExtras;
        }
    }); 
    return cExtras;
}

function editarPedidoArmarHtmlItemExtra(oExtra){
    var htmlExtraItem = "";
    //console.log(oExtra);
    htmlExtraItem = "<li>";
    if(oExtra.stock_disponible > 0 || oExtra.stock_ilimitado == 1){
        htmlExtraItem += "<select id='selExtra"+oExtra.id+"' class='selectExtras' attr-idExtra='"+oExtra.id+"' attr-oldValue='0'>";
    }else{
        htmlExtraItem += "<select id='selExtra"+oExtra.id+"' class='selectExtras' attr-idExtra='"+oExtra.id+"' attr-oldValue='0' disabled>";
    }
    htmlExtraItem += "<option selected value='0'>0</option>";
    if(parseInt(oExtra.stock_ilimitado)==0){
        for(var i=1;i<=10;i++){
            if(i==11){
                break;
            }
            if(i<= parseInt(oExtra.stock_disponible)){
                htmlExtraItem += "<option value='"+i+"'>"+i+"</option>";
            }else{
                htmlExtraItem += "<option value='"+i+"' disabled>"+i+"</option>";
            }
        }
    }else{
        for(var i=1;i<11;i++){
            htmlExtraItem += "<option value='"+i+"'>"+i+"</option>";
        }
    }
    htmlExtraItem += "</select>";
    htmlExtraItem += "&nbsp;<label for='selExtra"+oExtra.id+"' class='form-check-label'>"+oExtra.name+"</label>";
    htmlExtraItem += "<label class='form-check-label' style='float:right'>$"+oExtra.price+"</label>";
    htmlExtraItem += "<input type='hidden' id='editarPedidoExtraPrice"+oExtra.id+"' value='"+oExtra.price+"'/>"; 
    htmlExtraItem += "</li>";    
    return htmlExtraItem;
}

function editarPedidoArmarHtmlCheckbox(oExtra){
    var htmlCheckbox = "";
    htmlCheckbox = "<li>";
    if(oExtra.stock_disponible > 0 || oExtra.stock_ilimitado == 1){
        htmlCheckbox += "<input type='checkbox' id='chkExtra"+oExtra.id+"' value='"+oExtra.id+"' class='chkExtras'/>&nbsp;" ;
    }else{
        htmlCheckbox += "<input type='checkbox' id='chkExtra"+oExtra.id+"' value='"+oExtra.id+"' class='chkExtras' disabled/>&nbsp;" ;
    }
    htmlCheckbox += "<label for='chkExtra"+oExtra.id+"' class='form-check-label'>"+oExtra.name+"</label>";
    htmlCheckbox += "<label class='form-check-label' style='float:right'>$"+oExtra.price+"</label>";
    htmlCheckbox += "<input type='hidden' id='editarPedidoExtraPrice"+oExtra.id+"' value='"+oExtra.price+"'/>"; 
    htmlCheckbox += "</li>";
    return htmlCheckbox;
}

function editarPedidoArmarHtmlExtras(cExtras){
    var html = "";
    for(var i=0;i<cExtras.length;i++){
        //html += editarPedidoArmarHtmlCheckbox(cExtras[i]);
        html += editarPedidoArmarHtmlItemExtra(cExtras[i]);
    }
    return html;
}



function editarPedidoInitSelectExtras(){
    $(".selectExtras").click(function(e){      
        $(this).attr("attr-oldValue",$(this).val());
    }); 

    $(".selectExtras").change(function(e){       
        var idExtra = $(this).attr("attr-idExtra");
        var precio = parseInt($("#editarPedidoExtraPrice"+idExtra).val());
        var subtotal = parseInt($("#lEditarPedidoSubtotal").html());
        var cantidad = $(this).val();
        if( cantidad > 0 ){
            var cantOriginal = $(this).attr("attr-oldValue");
            subtotal = subtotal - (precio*cantOriginal);
            subtotal = subtotal + (precio*cantidad);
        }else{
            var cantOriginal = $(this).attr("attr-oldValue");
            subtotal = subtotal - (precio*cantOriginal);
        }
        $("#lEditarPedidoSubtotal").html(subtotal);
        editarPedidoCalcularDebe();
    });    
}

function editarPedidoInitCheckboxExtras(){
    $(".chkExtras").change(function(e){       
        var idExtra = $(this).val();
        var precio = parseInt($("#editarPedidoExtraPrice"+idExtra).val());
        var subtotal = parseInt($("#lEditarPedidoSubtotal").html());
        if( $(this).prop("checked")){
            subtotal = subtotal + precio;
            
        }else{
            subtotal = subtotal - precio;
        }
        $("#lEditarPedidoSubtotal").html(subtotal);
        editarPedidoCalcularDebe();
    });    
}

function editarPedidoCalcularDebe(){
    if($("#editarPedidoIdEstadoPedido").val()!=3 && $("#editarPedidoIdEstadoPedido").val()!=5){
        var montoPagado = parseInt($("#editarPedidoMontoPagado").val());
        var subtotal = parseInt($("#lEditarPedidoSubtotal").html());
        if(montoPagado>0){
            if(montoPagado == subtotal){
                $("#lEditarPedidoDebe").html(0);
            }else{
                if(montoPagado < subtotal){
                    var lDebe = $("#lEditarPedidoDebe").html();
                    console.log(lDebe);
                    lDebe = subtotal - montoPagado;
                    $("#lEditarPedidoDebe").html(lDebe);
                }else{
                    return Swal.fire('Atención', 'El monto pagado no puede ser mayor al total del pedido.', 'success');
                }
            }
        }else{
            $("#lEditarPedidoDebe").html(subtotal);
        }
    }
}

function getCostoEnvio(){
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

function calcularDescuentoPorcentual(descuento, idTipoDescuento) {
    if(descuento!=null && idTipoDescuento!=null) {
        var montoDescuento = 0;
        if(idTipoDescuento == 2) {
            var total = $("#lEditarPedidoSubtotal").html();
            //Math.ceil me lleva el resultado al primer integer mayor. Si me da 1789,32, me devuelve 1790.
            montoDescuento = Math.ceil(((descuento*total)/100));
        } else {
            montoDescuento = descuento;
        }
        montoDescuento = parseInt(montoDescuento)
        $("#editarPedidoMontoDescuento").val(montoDescuento);
        var subtotal = parseInt($("#lEditarPedidoSubtotal").html());
        subtotal = subtotal - montoDescuento;
        $("#lEditarPedidoSubtotal").html(subtotal);
        editarPedidoCalcularDebe();
        $("#idCupon option").attr('data-descuento-anterior',montoDescuento);
    }
}

function sumarDescuentoAnterior(descuentoAnterior){
    if(descuentoAnterior>0){
        var subtotal = parseInt($("#lEditarPedidoSubtotal").html());
        subtotal = subtotal + descuentoAnterior;
        $("#lEditarPedidoSubtotal").html(subtotal);    
    }
}

function recalcularCostoEnvio(select) {
    let costoEnvio = parseInt($('option:selected', select).attr('data-barrio-costoEnvio'));
    let costoEnvioAnterior = parseInt($('option:selected', select).attr('data-barrio-costoEnvioAnterior'));
    $("#editarPedidoCostoEnvio").val(costoEnvio);
    let subtotal = parseInt($("#lEditarPedidoSubtotal").html());
    subtotal = subtotal - costoEnvioAnterior + costoEnvio;
    $("#lEditarPedidoSubtotal").html(subtotal)
    editarPedidoCalcularDebe();
    $("#editarPedidoIdBarrio option").attr('data-barrio-costoEnvioAnterior',costoEnvio);   
}

function setFormByConfigDiaEntrega(configDiaEntrega) {
    var html = "<option value='-1' selected>Seleccione</option>";
    if(configDiaEntrega.puntoRetiroEnabled == 1) {
        html += "<option value='1'>Sucursal</option>";
    }
    if(configDiaEntrega.deliveryEnabled == 1) {
        html += "<option value='2'>Domicilio</option>";
    }
    $("#editarPedidoIdTipoPedido").html(html);
    $("#editarPedidoIdTipoPedido").change();

    if(configDiaEntrega.bolsonEnabled == 1) {
        $("#editarPedidoIdBolson").prop("disabled",false);
    }else{
        $("#editarPedidoIdBolson").prop("disabled",true);
    }
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
