$(document).ready(function() {
    preciosPedidoExtrasHelper.init();
});

const preciosPedidoExtrasHelper = {
    asignoEventos: function() {
        //ACA VAN TODOS LOS LISTENERS
        
        $("input.numeric").numeric();
                
        $('#bGuardarMontoMinimoPedidoExtras').on("click",function(e) {
            e.preventDefault();
            mostrarLoader();
            if($("#montoMinimoPedidoExtras").val()!=null && $("#montoMinimoPedidoExtras").val()>=0){
                var montoMinimoPedidoExtras = $("#montoMinimoPedidoExtras").val();
                let data = {
                    'montoMinimoPedidoExtras': montoMinimoPedidoExtras
                };
                $.ajax({
                    url: ajaxURL + 'preciosPedidosExtra/editMontoMinimoPedidosExtras',
                    data: data,
                    method: 'post'
                }).done(function(result) {
                    if(result.updateOK == true) {
                        ocultarLoader();
                        return Swal.fire('Monto Minimo del Pedido', 'Monto editado satisfactoriamente.', 'success');
                    }else{
                        ocultarLoader();
                        return Swal.fire('Monto Minimo del Pedido', 'No se pudo editar el monto. Intenta de nuevo.', 'error');
                    }
                });                
            }else{
                ocultarLoader();
            }
        }); 

        $('#bGuardarCostoEnvioPedidoExtras').on("click",function(e) {
            e.preventDefault();
            mostrarLoader();
            if($("#costoEnvioPedidosExtras").val()!=null && $("#costoEnvioPedidosExtras").val()>=0){
                var costoEnvioPedidosExtras = $("#costoEnvioPedidosExtras").val();
                let data = {
                    'costoEnvioPedidosExtras': costoEnvioPedidosExtras
                };
                $.ajax({
                    url: ajaxURL + 'preciosPedidosExtra/editCostoEnvioPedidosExtras',
                    data: data,
                    method: 'post'
                }).done(function(result) {
                    if(result.updateOK == true) {
                        ocultarLoader();
                        return Swal.fire('Costo de Envio', 'Monto editado satisfactoriamente.', 'success');
                    }else{
                        ocultarLoader();
                        return Swal.fire('Costo de Envio', 'No se pudo editar el monto. Intenta de nuevo.', 'error');
                    }
                });                
            }else{
                ocultarLoader();
            }
        });

        $('#bGuardarMontoMinimoEnvioSinCargo').on("click",function(e) {
            e.preventDefault();
            mostrarLoader();
            if($("#montoMinimoPedidoExtrasEnvioSinCargo").val()!=null && $("#montoMinimoPedidoExtrasEnvioSinCargo").val()>=0){
                var montoMinimoPedidoExtrasEnvioSinCargo = $("#montoMinimoPedidoExtrasEnvioSinCargo").val();
                let data = {
                    'montoMinimoPedidoExtrasEnvioSinCargo': montoMinimoPedidoExtrasEnvioSinCargo
                };
                $.ajax({
                    url: ajaxURL + 'preciosPedidosExtra/editMontoMinimoEnvioSinCargoPedidosExtras',
                    data: data,
                    method: 'post'
                }).done(function(result) {
                    if(result.updateOK == true) {
                        ocultarLoader();
                        return Swal.fire('Monto Minimo para Envio Sin Cargo', 'Monto editado satisfactoriamente.', 'success');
                    }else{
                        ocultarLoader();
                        return Swal.fire('Monto Minimo para Envio Sin Cargo', 'No se pudo editar el monto. Intenta de nuevo.', 'error');
                    }
                });                
            }else{
                ocultarLoader();
            }
        });

        $("#pedidoExtrasPuntoRetiroHabilitado").on("change",function(e){
            e.preventDefault();
            mostrarLoader();
            let pedidoExtrasPuntoRetiropedidoExtrasPuntoRetiro = $(this).is(':checked') ? 1 : 0;
            let data = {
                'pedidoExtrasPuntoRetiropedidoExtrasPuntoRetiro': pedidoExtrasPuntoRetiropedidoExtrasPuntoRetiro
            };
            $.ajax({
                url: ajaxURL + 'preciosPedidosExtra/puntoRetiroHabilitado',
                data: data,
                method: 'post'
            }).done(function(result) {
                ocultarLoader();
                if(result.updateOK == true) {
                    var accion = "deshabilitados";
                    if(pedidoExtrasPuntoRetiropedidoExtrasPuntoRetiro==1){
                        accion = "habilitados";
                    }
                    return Swal.fire('Pedidos de Extras - Punto de Retiro', 'Los puntos de retiro fueron '+accion+' para pedidos solamente de extras.', 'success');
                }else{
                    ocultarLoader();
                    return Swal.fire('Pedidos de Extras - Punto de Retiro', 'Hubo un error al querer habilitar a los puntos de retiro para pedidos solamente de extras.', 'error');
                }
            });                

        });

        $("#pedidoExtrasDomicilioHabilitado").on("change",function(e){
            e.preventDefault();
            mostrarLoader();
            let pedidoExtrasDomicilioPedidoExtrasHabilitado = $(this).is(':checked') ? 1 : 0;
            let data = {
                'pedidoExtrasDomicilioPedidoExtrasHabilitado': pedidoExtrasDomicilioPedidoExtrasHabilitado
            };
            $.ajax({
                url: ajaxURL + 'preciosPedidosExtra/domicilioHabilitado',
                data: data,
                method: 'post'
            }).done(function(result) {
                ocultarLoader();
                if(result.updateOK == true) {
                    var accion = "deshabilitados";
                    if(pedidoExtrasDomicilioPedidoExtrasHabilitado==1){
                        accion = "habilitados";
                    }
                    return Swal.fire('Pedidos de Extras - Domicilio', 'Los pedidos a domicilio fueron '+accion+' para pedidos solamente de extras.', 'success');
                }else{
                    ocultarLoader();
                    return Swal.fire('Pedidos de Extras - Domicilio', 'Hubo un error al querer habilitar a los pedidos de domicilio para pedidos solamente de extras.', 'error');
                }
            });                

        });   
        
        $('#bGuardarCostoEnvioPedidos').on("click",function(e) {
            e.preventDefault();
            mostrarLoader();
            if($("#costoEnvioPedidos").val()!=null && $("#costoEnvioPedidos").val()>=0){
                var costoEnvioPedidos = $("#costoEnvioPedidos").val();
                let data = {
                    'costoEnvioPedidos': costoEnvioPedidos
                };
                $.ajax({
                    url: ajaxURL + 'configuradorPedidos/editCostoEnvioPedidos',
                    data: data,
                    method: 'post'
                }).done(function(result) {
                    if(result.updateOK == true) {
                        ocultarLoader();
                        return Swal.fire('Costo de Envio', 'Monto editado satisfactoriamente.', 'success');
                    }else{
                        ocultarLoader();
                        return Swal.fire('Costo de Envio', 'No se pudo editar el monto. Intenta de nuevo.', 'error');
                    }
                });                
            }else{
                ocultarLoader();
            }
        });

        $("#bGuardarFormasPago").on("click",function(e){
            e.preventDefault();
            mostrarLoader();
            if(checkSeniasForm()){
                var valorFormasPago = $("#valorFormasPago").val();
                let data = {
                    'valorFormasPago': valorFormasPago
                };
                $.ajax({
                    url: ajaxURL + 'configuradorPedidos/editLimiteValorFormasPago',
                    data: data,
                    method: 'post'
                }).done(function(result) {
                    if(result.updateOK == true) {
                        ocultarLoader();
                        return Swal.fire('Formas de Pago', 'Monto límite para pago en efectivo editado satisfactoriamente.', 'success');
                    }else{
                        ocultarLoader();
                        return Swal.fire('Formas de Pago', 'No se pudo editar el monto. Intenta de nuevo.', 'error');
                    }
                });                
            }else{
                ocultarLoader();
            }
        });

    },
    init: function() {
        this.asignoEventos();
    }
};

function checkSeniasForm(){
    var formOK = true;

    if($("#senaRango1").val()=="" || $("#senaRango1").val()==0){
        formOK = false;
    }
    if($("#senaRango2").val()=="" || $("#senaRango2").val()==0){
        formOK = false;
    }
    if($("#senaRango3").val()=="" || $("#senaRango3").val()==0){
        formOK = false;
    }
    return formOK;
}