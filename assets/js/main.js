let aExtras = [];
let currentForm = "";

$(document).ready(function() {
    var current = null;

    $('body').bootstrapMaterialDesign();
    $('select').selectric({
        disableOnMobile: false,
        nativeOnMobile: false
    });
    $('.rbBolsones').on("change",function(e){
        calcularTotalPedido();
        getResumenPedido();
        checkIfAnyBolsonIsSelected();
    });
    $('.method > img, a[data-method]').click(function(e) {
        e.preventDefault();
        let method = $(this).attr('data-method');
        aExtras = [];
        currentForm = method;
        $('.delivery-form-wrapper, .sucursal-form-wrapper').hide().promise().done(function() {
            $(`.${method}-form-wrapper`).show().promise().done(function() {
                scrollToElem(`.${method}-form-wrapper`);
                current = method;
            });
        });
    });

    $('button[name="subm"]').click(function(e) {
        $(".loading").show();
        e.preventDefault();
        $('input').parent().find('p.input-error').remove();
        $('select').parent().parent().find('p.input-error').remove();
        setTimeout(function() {
            let nombre    = $(`.${current}-form input[name="nombre"]`).val();
            let mail      = $(`.${current}-form input[name="email"]`).val();
            let celular   = $(`.${current}-form input[name="celular"]`).val();
            let sucursal  = $(`.${current}-form select[name="sucursal"]`).val();
            let bolsones  = $(`.${current}-form input[name="bolson"]:checked`).val();
            let confirmar = $(`.${current}-form input[name="confirmation"]`).is(':checked');

            let pedidoSoloExtras = false;

            switch (current) {
                case 'delivery':
                    if(nombre == "") {
                        $('.'+current+'-form input[name="nombre"]').parent().append(buildInputError(
                            'Por favor, ingresa tu nombre y apellido.'
                        ));
                        scrollToElem('input[name="nombre"]');
                        $(".loading").hide();
                        return false;
                    }
                    if(!validEmail(mail)) {
                        $('.'+current+'-form input[name="email"]').parent().append(buildInputError(
                            'Por favor, ingresa un correo electrónico válido.'
                        ));
                        scrollToElem('input[name="email"]');
                        $(".loading").hide();
                        return false;
                    }
                    if(!validPhone(celular)) {
                        $('.'+current+'-form input[name="celular"]').parent().append(buildInputError(
                            'Solo se aceptan números, espacios y "+".'
                        ));
                        scrollToElem('input[name="celular"]');
                        $(".loading").hide();
                        return false;
                    }
                    var pedidosExtrasEnabled = 0;
                    pedidosExtrasEnabled = getTipoPedidoHasPedidosExtrasHabilitado();
                    if(pedidosExtrasEnabled==0){
                        //SI NO PUEDE SOLICITAR PEDIDOS DE EXTRAS
                        if(typeof bolsones === 'undefined') {
                            //SI EL PEDIDO NO TIENE BOLSON NI EXTRAS
                            $($('.'+current+'-form input[name="bolson"]:last')[0]).parent().append(buildInputError(
                                'Por favor, elija un bolsón.'
                            ));
                            scrollToElem('.divTipoBolson-delivery');
                            $(".loading").hide();
                            return false;
                        }                        
                    }else if(pedidosExtrasEnabled==1){
                        if(typeof bolsones === 'undefined' && aExtras.length==0) {
                            //SI EL PEDIDO NO TIENE BOLSON NI EXTRAS
                            $($('.'+current+'-form input[name="bolson"]:last')[0]).parent().append(buildInputError(
                                'Por favor, elija un bolsón o agregue algún producto (compra mínima $'+$("#montoMinimoPedidoExtras").val()+').'
                            ));
                            scrollToElem('.divTipoBolson-delivery');
                            $(".loading").hide();
                            return false;
                        }else{
                            if(typeof bolsones === 'undefined' && aExtras.length>0){
                                pedidoSoloExtras = true;
                                //SI EN EL PEDIDO NO HAY BOLSON, PERO SI EXTRAS
                                if(!isTotalGreaterThanMontoMinimoPedidoExtras()){
                                    var montoMinimoPedidoExtras = getMontoMinimoPedidoSoloExtras();
                                    $("#"+current+"-hMontoMinimoPedidoExtra").css("color","#FF0000"); //CON ESTO SE PONE EN ROJO LA LEYENDA DEL MINIMO DEL PEDIDO DE SOLO EXTRAS
                                    //openMessage("ATENCIÓN!", "El monto minimo para pedidos sin bolsón es de $"+montoMinimoPedidoExtras+"."); //CON ESTO SE ABRE EL MODAL DE ATENCION
                                    $(".loading").hide();
                                    return false;
                                }else{
                                    $("#"+current+"-hMontoMinimoPedidoExtra").css("color","#000000");
                                }
                            }
                        }     
                    }               
                    if(confirmar == false) {
                        $('.'+current+'-form input[name="confirmation"]').parent().append(buildInputError(
                            'Por favor, confirma el pedido.'
                        ));
                        scrollToElem('input[name="confirmation"]');
                        $(".loading").hide();
                        return false;
                    }

                break;

                case 'sucursal':
                    if(nombre == "") {
                        $('.'+current+'-form input[name="nombre"]').parent().append(buildInputError(
                            'Por favor, ingresa tu nombre y apellido.'
                        ));
                        scrollToElem('input[name="nombre"]');
                        $(".loading").hide();
                        return false;
                    }
                    if(!validEmail(mail)) {
                        $('.'+current+'-form input[name="email"]').parent().append(buildInputError(
                            'Por favor, ingresa un correo electrónico válido.'
                        ));
                        scrollToElem('input[name="email"]');
                        $(".loading").hide();
                        return false;
                    }
                    if(!validPhone(celular)) {
                        $('.'+current+'-form input[name="celular"]').parent().append(buildInputError(
                            'Solo se aceptan números, espacios y "+".'
                        ));
                        scrollToElem('input[name="celular"]');
                        $(".loading").hide();
                        return false;
                    }
                    if(sucursal == null) {
                        $('.'+current+'-form select[name="sucursal"]').parent().parent().append(buildInputError(
                            'Por favor, elige una sucursal.'
                        ));
                        scrollToElem('select[name="sucursal"]');
                        $(".loading").hide();
                        return false;
                    }
                    var pedidosExtrasEnabled = 0;
                    pedidosExtrasEnabled = getTipoPedidoHasPedidosExtrasHabilitado();
                    if(pedidosExtrasEnabled==0){
                        //SI NO PUEDE SOLICITAR PEDIDOS DE EXTRAS

                        if(typeof bolsones === 'undefined') {
                            $($('.'+current+'-form input[name="bolson"]:last')[0]).parent().append(buildInputError(
                                'Por favor, elige un bolsón.'
                            ));
                            scrollToElem('.divTipoBolson-sucursal');
                            $(".loading").hide();
                            return false;
                        }
                    }else if(pedidosExtrasEnabled==1){
                        if(typeof bolsones === 'undefined' && aExtras.length==0) {
                            //SI EL PEDIDO NO TIENE BOLSON NI EXTRAS
                            $($('.'+current+'-form input[name="bolson"]:last')[0]).parent().append(buildInputError(
                                'Por favor, elija un bolsón o agregue algún producto (compra mínima $'+$("#montoMinimoPedidoExtras").val()+').'
                            ));
                            scrollToElem('.divTipoBolson-sucursal');
                            $(".loading").hide();
                            return false;
                        }else{
                            if(typeof bolsones === 'undefined' && aExtras.length>0){
                                //SI EN EL PEDIDO NO HAY BOLSON, PERO SI EXTRAS
                                pedidoSoloExtras = true;
                                if(!isTotalGreaterThanMontoMinimoPedidoExtras()){
                                    var montoMinimoPedidoExtras = getMontoMinimoPedidoSoloExtras();
                                    $("#"+current+"-hMontoMinimoPedidoExtra").css("color","#FF0000"); //CON ESTO SE PONE EN ROJO LA LEYENDA DEL MINIMO DEL PEDIDO DE SOLO EXTRAS
                                    //$("span[name='errorMonto']").html("El monto minimo para pedidos sin bolsón es de $"+montoMinimoPedidoExtras+"."); //CON ESTO SALE MENSAJE ABAJO DE TOTAL
                                    //openMessage("ATENCIÓN!", "El monto minimo para pedidos sin bolsón es de $"+montoMinimoPedidoExtras+"."); //CON ESTO SALE MODAL DE ATENCION
                                    $(".loading").hide();
                                    return false;
                                }else{
                                    $("#"+current+"-hMontoMinimoPedidoExtra").css("color","#000000");
                                    //$("span[name='errorMonto']").html("");

                                }
                            }
                        }
                    }
                    if(confirmar == false) {
                        $('.'+current+'-form input[name="confirmation"]').parent().append(buildInputError(
                            'Por favor, confirma el pedido.'
                        ));
                        scrollToElem('input[name="confirmation"]');
                        $(".loading").hide();
                        return false;
                    }
                break;
            }
            
            //PRIMERO VERIFICAMOS SI ES PEDIDO SOLO DE EXTRAS. SI ES ASI, MOSTRAMOS EL MODAL PARA SUGERIR EL AGREGADO DEL BOLSON
            if(pedidoSoloExtras){
                openImagenBolson();
            }else{
                //SI PASA TODOS LOS CONTROLES, VERIFICO QUE NO EXISTA YA UN PEDIDO CON ESTE MAIL Y DIA.
                var responseSearch = searchOrdersDuplicadas(mail,celular);
                if(responseSearch.existePedidoCargado){
                    $("#labelAvisoPedidosCargadosDiaBolson").html(responseSearch.diaBolson);
                    $("#modalAvisoPedidosCargados").modal("show");
                }else{
                    //console.log(`${current}`);
                    aExtras = JSON.stringify(aExtras);
                    //console.log(aExtras);
                    if(`${current}` == "delivery"){
                        $("#arrExtras-delivery").val(aExtras);
                    }else{
                        $("#arrExtras-sucursal").val(aExtras);
                    }
                    
                    $(`.${current}-form`).submit();
                }

            }

        }, 500);
    });

    $("#modalAvisoPedidosCargados").on("hide.bs.modal",function(){
        $(".loading").hide();
    });

    $("#bContinuarConPedido").on("click",function(e){
        $("#modalAvisoPedidosCargados").modal("hide");
        aExtras = JSON.stringify(aExtras);
        if(`${current}` == "delivery"){
            $("#arrExtras-delivery").val(aExtras);
        }else{
            $("#arrExtras-sucursal").val(aExtras);
        }
        $(`.${current}-form`).submit();
    });

    $("#bWhatsapp").on("click",function(e){
        $(".loading").hide();
        $("#modalAvisoPedidosCargados").modal("hide");
        window.open("https://wa.me/+5491131816011?text=Hola,%20quiero%20hacer%20cambios%20en%20mi%20pedido%20por%20favor.","_blank");
        window.open("https://www.instagram.com/elbroteorganico/?hl=es-la.","_self");
    });

    $("#bCancelarPedido").on("click",function(e){
        $("#modalAvisoPedidosCargados").modal("hide");
        window.open("https://www.instagram.com/elbroteorganico/?hl=es-la.","_self");
    });


    $('input, select').change(function() {
        $(this).parent().find('p.input-error').remove();
    });

    $(".rbExtrasDel").on("click",function(){
        var idExtra = $(this).attr("data-extraid");
        var extraName = $(this).attr("data-extraName");
        var cant = $(this).val();
        var precio = $("#precioUnitarioExtraDel"+idExtra).html();
        var lastCant = $(this).attr("data-lastCant");
        var total = 0;
        precio = parseInt(precio);

        if(lastCant==cant){
            $(this).prop("checked",false);
            $(this).attr("data-lastCant",0);
            total = 0;
            removeExtraFromArray(idExtra);
        }else{
            $(this).attr("data-lastCant",cant);
            total = precio * cant;
            //Remuevo por las dudas si es que esta el extra primero y despues agrego, ya que puede estar con una cantidad X y entra a este else porque ahora tiene cantidad Y.
            removeExtraFromArray(idExtra);
            addExtraToArray(idExtra,cant,total,extraName);
        }
        $("#extraDel"+idExtra+"Total").html(total);
        getResumenPedido();
    });       
    
    $(".rbExtrasSuc").on("click",function(){
        var idExtra = $(this).attr("data-extraid");
        var extraName = $(this).attr("data-extraName");
        var cant = $(this).val();
        var precio = $("#precioUnitarioExtraSuc"+idExtra).html();
        var lastCant = $(this).attr("data-lastCant");
        var total = 0;
        precio = parseInt(precio);

        if(lastCant==cant){
            $(this).prop("checked",false);
            $(this).attr("data-lastCant",0);
            total = 0;
            removeExtraFromArray(idExtra);
        }else{
            $(this).attr("data-lastCant",cant);
            total = precio * cant;
            //Remuevo por las dudas si es que esta el extra primero y despues agrego, ya que puede estar con una cantidad X y entra a este else porque ahora tiene cantidad Y.
            removeExtraFromArray(idExtra);
            addExtraToArray(idExtra,cant,total,extraName);
        }
        $("#extraSuc"+idExtra+"Total").html(total);
        getResumenPedido();
    });       

    $(".checkConfirmation").on("change",function(e){
        if($(this).prop("checked")){
            getResumenPedido();
            checkIfAnyBolsonIsSelected();
            $(`.${current}-form div[name="divResumenPedido"]`).fadeIn();
        }else{
            $(`.${current}-form div[name="divResumenPedido"]`).fadeOut();
        }
    });

    $("#bAgregarBolson").on("click",function(e){
        e.preventDefault();
        cerrarModalImagenBolson();
        scrollToElem(`.divTipoBolson-${current}`);
        $(".loading").hide();
    });

    $("#bContinuarPedido").on("click",function(e){
        cerrarModalImagenBolson();
        let mail      = $(`.${current}-form input[name="email"]`).val();
        let celular   = $(`.${current}-form input[name="celular"]`).val();

        var responseSearch = searchOrdersDuplicadas(mail,celular);
        if(responseSearch.existePedidoCargado){
            $("#labelAvisoPedidosCargadosDiaBolson").html(responseSearch.diaBolson);
            $("#modalAvisoPedidosCargados").modal("show");
        }else{
            //console.log(`${current}`);
            aExtras = JSON.stringify(aExtras);
            //console.log(aExtras);
            if(`${current}` == "delivery"){
                $("#arrExtras-delivery").val(aExtras);
            }else{
                $("#arrExtras-sucursal").val(aExtras);
            }
            
            $(`.${current}-form`).submit();
        }
    });
    
    $('#modalImagenBolson').on('hidden.bs.modal', function (e) {
        cerrarModalImagenBolson();
    });
    function checkIfAnyBolsonIsSelected(){
        var bolsones  = $(`.${current}-form input[name="bolson"]:checked`).val();
        var anyBolsonChecked = false;
        if( typeof bolsones === 'undefined'){
            //SI DA UNDEFINED ES PORQUE NO HAY BOLSON SELECCIONADO ENTONCES ES UN PEDIDO DE EXTRAS
            $(`#${current}-hMontoMinimoPedidoExtra`).show();
        }else{
            $(`#${current}-hMontoMinimoPedidoExtra`).hide();
            anyBolsonChecked = true;
        }
        return anyBolsonChecked;
    }

    function buildInputError(message) {
        $('input, select').parent().find('p.input-error').remove()
        return `<p class="input-error">${message}</p>`;
    }

    function validEmail(input) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(input);
    }

    function validPhone(input) {
        var re= /^[\d ()+-]+$/;
        return re.test(input);
    }

    function scrollToElem(selector) {
        $([document.documentElement, document.body]).animate({
            scrollTop: $(selector).offset().top - 20
        }, 500);
    }

    function addExtraToArray(idExtra,cantExtra,total,extraName){
        var oExtra = {
            "idExtra"   : idExtra,
            "extraName" : extraName,
            "cantExtra" : cantExtra,
            "total"     : total
        }
        aExtras.push(oExtra);
    }

    function removeExtraFromArray(idExtra){
        // get index of object with id of 37
        var removeIndex = aExtras.findIndex( oExtra => oExtra.idExtra === idExtra );
        // remove object
        if(removeIndex>-1){
            aExtras.splice( removeIndex, 1 );
        }
    }

    function calcularTotalPedido(){
        var precioBolson  = $(`.${current}-form input[name="bolson"]:checked`).attr("data-price");
        var precioDelivery = $(`.${current}-form input[name="bolson"]:checked`).attr("data-delivery-price");
        if(isNaN(precioBolson)){
            precioBolson = 0;
        }
        if(isNaN(precioDelivery)){
            precioDelivery = 0;
        }
        precioBolson = parseFloat(precioBolson);
        precioDelivery = parseFloat(precioDelivery);
        var totalExtras = parseFloat(0);
        var total = parseFloat(0);
        for(var i=0;i<aExtras.length;i++){
            totalExtras = totalExtras + parseFloat(aExtras[i].total);
        }
        total = precioBolson + precioDelivery + totalExtras;
        return total;
    }

    function setTotalPedido(total){
        //var precioDelivery = $(`.${current}-form input[name="bolson"]:checked`).attr("data-delivery-price");
        //precioDelivery = parseFloat(precioDelivery);
        
        $(`.${current}-form label[name="totalPedido"]`).html(total);
        //if(precioDelivery>0){
        //    $(`.${current}-form label[name="costoDelivery"]`).html(precioDelivery);
        //}
        
    }

    function getResumenPedido(){
        var html = "";
        setTotalPedido(calcularTotalPedido());
        html = getHTMLResumenPedido();
        $(`.${current}-form div[name="divDetallePedido"]`).html(html);
        
    }   
    
    function getHTMLResumenPedido(){
        html = "<ul>";
        var precioBolson  = $(`.${current}-form input[name="bolson"]:checked`).attr("data-price");
        if(!isNaN(precioBolson)){
            html += getHtmlDetalleBolson();
        }
        html += getHtmlDetalleExtras();
        html += "</ul>";
        if(`${current}`=="delivery"){
            html += getHtmlCostoEnvio();
        }
        return html;
    }

    function getHtmlDetalleBolson(){
        var precioBolson  = $(`.${current}-form input[name="bolson"]:checked`).attr("data-price");
        var cantBolson  = $(`.${current}-form input[name="bolson"]:checked`).attr("data-cant-bolsones");
        var precioDelivery = $(`.${current}-form input[name="bolson"]:checked`).attr("data-delivery-price");
        precioDelivery = parseFloat(precioDelivery);
    
        var html = "";    
            html += "<li>"+cantBolson+" x Bolson de 8kgs: $"+precioBolson+"</li>";
        return html;
    }    

    function getHtmlCostoEnvio(){
        var precioDelivery = $(`.${current}-form input[name="bolson"]:checked`).attr("data-delivery-price");
        var envioSinCargo = false;
        if(typeof precioDelivery === "undefined"){
            //SI ES UNDEFINED, ES QUE NO TIENE SELECCIONADO NINGUN BOLSON ASIQUE SE MUESTRA EL COSTO DE ENVIO DE PEDIDO SIN BOLSON. CONTROLAR SI NO ES ENVIO GRATIS
            precioDelivery = getCostoDeEnvioPedidoSoloExtras();
            if(isTotalGreaterThanMontoMinimoEnvioSinCargoPedidoExtras()){
                envioSinCargo = true;
            }
        }
        precioDelivery = parseFloat(precioDelivery);    
        var html = "<ul>";
        if(precioDelivery>0 && !envioSinCargo){
            html += "<li>Costo de Envío: $"+precioDelivery+"</li>";
            html += "<li style='list-style-type: none;max-width: 429px;font-size: 0.7rem;'>";
            html += "ATENCIÓN: El valor de Envío a Domicilio se abona a continuación por MercadoPago. El resto del valor de la compra se abona en efectivo, al recibir el pedido en el domicilio. Gracias por tu compra!";
            html += "</li>";
        }else{
            if(envioSinCargo){
                html += "<li>Costo de Envío: $<span style='text-decoration:line-through;'>"+precioDelivery+"</span> SIN CARGO</li>";
                html += "<li style='list-style-type: none;max-width: 429px;font-size: 0.7rem;'>";
                html += "ATENCIÓN: El valor de Envío a Domicilio se abona a continuación por MercadoPago. El resto del valor de la compra se abona en efectivo, al recibir el pedido en el domicilio. Gracias por tu compra!";
                html += "</li>";    
            }
        }
        html += "</ul>";
        return html;
    }

    function isTotalGreaterThanMontoMinimoEnvioSinCargoPedidoExtras(){
        var isTotalGreaterThanMontoMinimoEnvioSinCargoPedidoExtras = false;
        var total = calcularTotalPedido();
        var montoMinimoEnvioSinCargo = getMontoMinimoEnvioSinCargoPedidoSoloExtras();

        total = parseFloat(total);
        montoMinimoEnvioSinCargo = parseFloat(montoMinimoEnvioSinCargo);

        if(total>=montoMinimoEnvioSinCargo){
            isTotalGreaterThanMontoMinimoEnvioSinCargoPedidoExtras = true;
        }
        return isTotalGreaterThanMontoMinimoEnvioSinCargoPedidoExtras;

    }

    function isTotalGreaterThanMontoMinimoPedidoExtras(){
        var isTotalGreaterThanMontoMinimoPedidoExtras = false;
        var total = calcularTotalPedido();
        var montoMinimoPedidoSoloExtras = getMontoMinimoPedidoSoloExtras();

        total = parseFloat(total);
        montoMinimoPedidoSoloExtras = parseFloat(montoMinimoPedidoSoloExtras);
        
        if(total>=montoMinimoPedidoSoloExtras){
            isTotalGreaterThanMontoMinimoPedidoExtras = true;
        }
        return isTotalGreaterThanMontoMinimoPedidoExtras;
    }
    
});


function getHtmlDetalleExtras(){
    var html = "";
    for(var i=0;i<aExtras.length;i++){
        html += "<li>"+aExtras[i].cantExtra+" x "+aExtras[i].extraName+": $"+aExtras[i].total+"</li>";
    }
    return html;
}

function getMontoMinimoPedidoSoloExtras(){
    var montoMinimoPedidoExtras = 0;
    $.ajax({
        url: baseURL + 'getMontoMinimoPedidoExtras',
        method: 'post',
        async: false
    }).done(function(result) {
        console.log(result);
        if(result.success) {
            if(result.montoMinimoPedidoExtras!=null){
                montoMinimoPedidoExtras = result.montoMinimoPedidoExtras;
            }
        }
    });
    return montoMinimoPedidoExtras;
}

function getMontoMinimoEnvioSinCargoPedidoSoloExtras(){
    var montoMinimoEnvioSinCargo = 0;
    $.ajax({
        url: baseURL + 'getMontoMinimoEnvioSinCargoPedidoExtras',
        method: 'post',
        async: false
    }).done(function(result) {
        console.log(result);
        if(result.success) {
            if(result.montoMinimoEnvioSinCargoPedidoExtras != null){
                montoMinimoEnvioSinCargo = result.montoMinimoEnvioSinCargoPedidoExtras;
            }
        }
    });
    return montoMinimoEnvioSinCargo;
}

function getCostoDeEnvioPedidoSoloExtras(){
    var costoEnvio = 0;
    $.ajax({
        url: baseURL + 'getCostoEnvioPedidoExtras',
        method: 'post',
        async: false
    }).done(function(result) {
        console.log(result);
        if(result.success) {
            if(result.costoEnvioPedidoExtras != null){
                costoEnvio = result.costoEnvioPedidoExtras;
            }
        }
    });
    return costoEnvio;
}

function openMessage(title,message){
    var msj = "<p>"+message+"</p>";
    $("#messageTitle").html(title);
    $("#messageDiv").html(msj);
    $("#modalMessage").modal("show");
}

function openImagenBolson(){
    $("#modalImagenBolson").modal("show");
}

function cerrarModalImagenBolson(){
    $("#modalImagenBolson").modal("hide");
    $(".loading").hide();
}

function searchOrdersDuplicadas(mail,celular){
    var response  = false;
    let data = {
        'mail' : mail,
        'telefono': celular
    };
    $.ajax({
        url: baseURL + 'searchOrdersByDiaActualBolsonAndMailAndPhone',
        data: data,
        method: 'post',
        async: false
    }).done(function(result) {
        response = result;
    });
    return response;
}

function getTipoPedidoHasPedidosExtrasHabilitado(){
    var tipoPedidoHasPedidosExtrasHabilitado = 0;
    let data = {
        'currentForm' : currentForm
    };
    $.ajax({
        url: baseURL + 'getTipoPedidoHasPedidosExtrasHabilitado',
        data: data,
        method: 'post',
        async: false
    }).done(function(result) {
        tipoPedidoHasPedidosExtrasHabilitado = result.tipoPedidoHasPedidosExtrasHabilitado;
    });
    return tipoPedidoHasPedidosExtrasHabilitado;
}
