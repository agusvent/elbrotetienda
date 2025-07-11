let arrayBarriosHabilitados = [];

$(document).ready(function() {
    loadDiasEntregaTable();
    $("input.numeric").numeric();

    $('body').on('change', "input[id*='dia_entrega_acepta_bolsones_']", function(e) {
        e.preventDefault();
        let idDiaEntrega = $(this).attr('data-dia-entrega-id');
        let aceptaBolsones = $(this).is(':checked') ? 1 : 0;
        setAceptaBolsonesStatus(idDiaEntrega, aceptaBolsones);
        updateDiaEntregaBox(idDiaEntrega, aceptaBolsones);
    });
    $('body').on('change', "input[id*='dia_entrega_acepta_pedidos_']", function(e) {
        e.preventDefault();
        let idDiaEntrega = $(this).attr('data-dia-entrega-id');
        let aceptaPedidosFrontend = $(this).is(':checked') ? 1 : 0;
        setAceptaPedidosFrontend(idDiaEntrega, aceptaPedidosFrontend);
    });

    $('body').on('change', "input[id*='dia_entrega_punto_retiro_enabled_']", function(e) {
        e.preventDefault();
        let idDiaEntrega = $(this).attr('data-dia-entrega-id');
        let puntoDeRetiroStatus = $(this).is(':checked') ? 1 : 0;
        setPuntoDeRetiroStatus(idDiaEntrega, puntoDeRetiroStatus);
    });
    $('body').on('change', "input[id*='dia_entrega_delivery_enabled_']", function(e) {
        e.preventDefault();
        let idDiaEntrega = $(this).attr('data-dia-entrega-id');
        let deliveryStatus = $(this).is(':checked') ? 1 : 0;
        setDeliveryStatus(idDiaEntrega, deliveryStatus);
        if(deliveryStatus==1){
            $("#editarBarrioLink"+idDiaEntrega).show();
        } else {
            $("#editarBarrioLink"+idDiaEntrega).hide();
        }
    });
    $('body').on('change', "input[id*='diaEntregaAceptaBolsones']", function(e) {
        e.preventDefault();
        let bolsonesEnabled = $(this).is(':checked') ? 1 : 0;
        refreshImagenBolsonField(bolsonesEnabled);
    });

    $('#apagarFormularioPedidos').change(function(){
        changeFormStatus($(this).is(':checked') ? 0 : 1);
    });
    
    $('#pedidosFueraDeHora').change(function(){
        changePedidosFueraDeHoraStatus($(this).is(':checked') ? 1 : 0);
    });
    

    $("#bCrearNuevoDiaEntrega").on("click",function(e){
        e.preventDefault();
        mostrarLoader();
        var msj = checkFormCrearNuevoDiaEntrega();
        if(msj!=""){
            ocultarLoader();
            return Swal.fire('Error', msj, 'error');
        }else{
            $("#bCrearNuevoDiaEntrega").prop("disabled",true);
            var diaEntregaFecha = $("#crearDiaEntregaFecha").val();
            $("#crearDiaEntregaLabelFinal").prop("disabled",false);
            var diaEntregaLabelFinal = $("#crearDiaEntregaLabelFinal").val();
            let aceptaBolsones = $("#diaEntregaAceptaBolsones").is(':checked') ? 1 : 0;
            let puntoDeRetiroStatus = $("#diaEntregaPuntoDeRetiroStatus").is(':checked') ? 1 : 0;
            let deliveryStatus = $("#diaEntregaDeliveryStatus").is(':checked') ? 1 : 0;
            let cargaPedidosFijos = $("#diaEntregaCargaPedidosFijos").is(':checked') ? 1 : 0;

            let data = {
                'diaEntregaFecha': diaEntregaFecha,
                'diaEntregaLabelFinal': diaEntregaLabelFinal,
                'aceptaBolsones': aceptaBolsones,
                'puntoDeRetiroStatus': puntoDeRetiroStatus,
                'deliveryStatus': deliveryStatus,
                'cargaPedidosFijos': cargaPedidosFijos,
                'arrayBarriosHabilitados': arrayBarriosHabilitados 
            };
            $.ajax({
                url: ajaxURL + 'crearDiaEntrega',
                data: data,
                method: 'post',
                async: false
            }).done(function(res) {
                ocultarLoader();
                let response = JSON.parse(res);
                let idDiaEntrega = response[0].idDiaEntrega;
                var imagenBolsonData = $('#crearDiaEntregaImagenBolson').prop('files')[0];  
                var imagenBolsonDataExtension = $('#crearDiaEntregaImagenBolson').val().substr(($('#crearDiaEntregaImagenBolson').val().lastIndexOf('.') + 1));
                arrayBarriosHabilitados = [];
                var form_data = new FormData();         
                form_data.append('file', imagenBolsonData);    
                form_data.append('fileExtension', imagenBolsonDataExtension);
                form_data.append('idDiaEntrega', idDiaEntrega);

                $.ajax({
                    url: ajaxURL + 'diaEntrega/uploadImagenDiaEntrega', // point to server-side PHP script 
                    dataType: 'text', // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,             
                    type: 'post',
                    success: function(res){
                        //console.log("HOLA",res);
                        //extrasHelper.cleanAddExtraForm();
                        window.location.reload(true); 
                    }
                });  

                /*if(respuesta.diaEntregaCreado){
                    // Limpio el formulario y escondo el modal
                    limpiarFormularioCrearNuevoDiaEntrega();
                    $("#lDiaBolsonFormulario").html(diaEntregaLabelFinal);
                    $("#modalCrearDiaEntrega").modal("hide");
                    return Swal.fire('Dia de Entrega Creado', '<p>El día '+diaEntregaLabelFinal+' ha sido creado satisfactoriamente. Se crearon los pedidos fijos para: </p>'+respuesta.pedidosCreados, 'success');
                }else{
                    return Swal.fire('Error', 'No se pudo crear el dia de entrega. Intenta de nuevo.', 'error');
                }*/
            });
        }  
    });

    $("#crearDiaEntregaFecha").on("change",function(e){
        var weekday = ["LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO","DOMINGO"];
        var meses = ["ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE"];
        var fecha = $(this).val();
        var dia = fecha.substr(8,9);
        var fechaFormateada = new Date(fecha);
        var mes = fechaFormateada.getMonth();
        if(dia == 1){
            if(mes < 11){
                mes = mes + 1;
            }else{
                mes = 0;
            }
        }
        $("#crearDiaEntregaLabelFinal").val((weekday[fechaFormateada.getDay()]) + " " + dia +  " de " + (meses[mes]));
    });

    $("#bEditarImagenDiaEntrega").on("click",function(e){
        e.preventDefault();
        mostrarLoader();
        var msj = "";
        msj = checkFormEditarImagen();
        if(msj == ""){
            cargarImagen($("#idDiaEntregaEditar").val(),$('#diaEntregaEditarImagen'));
        }else{
            ocultarLoader();
            $("#diaEntregaEditarImagen").css("border","1px solid red");
            $("#lErrorEditarImagen").html(msj);
        }
    });

    $("#diaEntregaDeliveryStatus").on("change", function(e) {
        updateModalSize();
        cargarBarriosActivos();
    });

    $('body').on('change', "input[id*='diaEntregaBarrio']", function(e) {
        e.preventDefault();
        updateDiaEntregaBarrio($(this));
    });

    $('body').on('change', "input[id*='diaEntregaEdicionBarrio']", function(e) {
        e.preventDefault();
        updateDiaEntregaBarrio($(this));
    });
    
    $("#modalCrearDiaEntrega").on("show.bs.modal", function () {
        arrayBarriosHabilitados = [];
    });

    $("#modalEditarBarrios").on("hidden.bs.modal", function () {
        arrayBarriosHabilitados = [];
    });
    
    $("#bEditarBarriosHabilitados").on("click",function(e) {
        if(arrayBarriosHabilitados.length==0){
            arrayBarriosHabilitados = null;
        }
        mostrarLoader();
        e.preventDefault();
        let data = {
            'idDiaEntrega': $("#idDiaEntregaEditar").val(),
            'arrayBarriosHabilitados': arrayBarriosHabilitados 
        };
        $.ajax({
            url: ajaxURL + 'diasEntrega/editarBarriosHabilitados',
            data: data,
            method: 'post',
            async: false
        }).done(function(res) {
            ocultarLoader();
            $("#modalEditarBarrios").modal("hide");
        });
    });

    $("#seleccionarTodosBarriosHabilitados").on("change",function(e){
        let todosHabilitados = $(this).is(':checked');
        $('input[id^="diaEntregaBarrio"]').each(function(index){
            $(this).prop("checked",todosHabilitados);
            var oBarrio = {
                "idBarrio": parseInt($(this).attr("attr-barrio-id"))
            };    
            if(todosHabilitados) {
                arrayBarriosHabilitados.push(oBarrio);
            }
        });
        if(!todosHabilitados) {
            arrayBarriosHabilitados = [];
        }
    });

    $("#editarSeleccionarTodosBarriosHabilitados").on("change",function(e){
        let todosHabilitados = $(this).is(':checked');
        arrayBarriosHabilitados = [];
        $('input[id^="diaEntregaEdicionBarrio"]').each(function(index){
            $(this).prop("checked",todosHabilitados);
            var oBarrio = {
                "idBarrio": parseInt($(this).attr("attr-barrio-id"))
            };    
            if(todosHabilitados) {
                arrayBarriosHabilitados.push(oBarrio);
            }
        });
    });

    $("#modalCrearDiaEntrega").on("hidden.bs.modal", function () {
        limpiarFormularioCrearNuevoDiaEntrega();
    });

    $(".bProcesarPedidosFijos").on("click", function(){
        let idDiaEntrega = $(this).attr('data-dia-entrega-id');
        preCrearPedidosFijos(idDiaEntrega);
    });

    $("#bCrearPedidosFijos").on("click", function(){
        mostrarLoader();
        let idDiaEntrega = $(this).attr('data-dia-entrega-id');
        var data = {
            "idDiaEntrega": idDiaEntrega
        }
        $.ajax({
            url: ajaxURL + 'orders/procesarPedidosFijos',
            method: 'post',
            data: data,
            dataType: "JSON",
            async: false
        }).done(function(pedidosCreados) {
            limpiarPreCrearPedidosFijos();
            var html = "";
            for(var i=0;i<pedidosCreados.length;i++){
                html += "<p>"+pedidosCreados[i]+"</p>";
            }
            $("#editarPedidosFijosCreadosList").html(html);
            ocultarLoader();
            $("#modalPedidosFijosCreados").modal("show")
        });
    
    });
    
});

function limpiarPreCrearPedidosFijos() {
    $("#bCrearPedidosFijos").attr("data-dia-entrega-id", null);
    $("#crearPedidosFijosConfirmationModal").modal("hide");
}

function preCrearPedidosFijos(idDiaEntrega) {
    $("#bCrearPedidosFijos").attr("data-dia-entrega-id", idDiaEntrega);
    $("#crearPedidosFijosConfirmationModal").modal("show");
}

function updateDiaEntregaBarrio(elem) {
    let barrioEnabled = elem.is(':checked') ? 1 : 0;
    let idBarrio = elem.attr('attr-barrio-id');
    if(barrioEnabled) {
        var oBarrio = {
            "idBarrio": parseInt(idBarrio)
        };    
        arrayBarriosHabilitados.push(oBarrio)
    } else {
        //HAY QUE BUSCARLO PARA SACARLO DEL ARRAY
        arrayBarriosHabilitados.splice(arrayBarriosHabilitados.findIndex(oBarrio => oBarrio.idBarrio == idBarrio), 1);
    }
}

function setAceptaPedidosFrontend(idDiaEntrega, aceptaPedidosFrontend) {
    let data = {
        'idDiaEntrega': idDiaEntrega,
        'aceptaPedidosFrontend': aceptaPedidosFrontend
    };
    $.ajax({
        url: ajaxURL + 'diasEntrega/aceptaPedidosFrontend',
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

function setPuntoDeRetiroStatus(idDiaEntrega, puntoDeRetiroHabilitado) {
    let data = {
        'idDiaEntrega': idDiaEntrega,
        'puntoDeRetiroHabilitado': puntoDeRetiroHabilitado
    };
    $.ajax({
        url: ajaxURL + 'diasEntrega/puntoDeRetiroStatus',
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

function setDeliveryStatus(idDiaEntrega, deliveryHabilitado) {
    let data = {
        'idDiaEntrega': idDiaEntrega,
        'deliveryHabilitado': deliveryHabilitado
    };
    $.ajax({
        url: ajaxURL + 'diasEntrega/deliveryStatus',
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

function updateDiaEntregaStatus(idDiaEntrega) {
    let data = {
        'idDiaEntrega': idDiaEntrega
    };
    $.ajax({
        url: ajaxURL + 'diasEntrega/updateStatus',
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

/* OLD. Descomentar esta si vuelven varios dias de entrega y comentar la funcion sigueinte que se llama igual*/
/*function loadDiasEntregaTable() {
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
            html +=" Frontend: &nbsp;";
            if(cDiasEntrega[i].aceptaPedidos == 1) {
                html +=" <input data-type='checkbox-active' data-dia-entrega-id='"+cDiasEntrega[i].id_dia_entrega+"' id='dia_entrega_acepta_pedidos_"+cDiasEntrega[i].id_dia_entrega+"' type='checkbox' checked data-toggle='toggle' data-onstyle='success' data-size='xs'>";
            } else {
                html +=" <input data-dia-entrega-id='"+cDiasEntrega[i].id_dia_entrega+"' id='dia_entrega_acepta_pedidos_"+cDiasEntrega[i].id_dia_entrega+"' type='checkbox' data-toggle='toggle' data-onstyle='success' data-size='xs'>";
            }
            html +=" </span>";
            html +=" </div>";
            html +=" <div class='cupones-caja-info'> ";
            html +=" <p style='text-align:center'><b>Tipos de Pedido Habilitados</b></p>";
            html +="Punto de Retiro:&nbsp;";
            if(cDiasEntrega[i].puntoDeRetiroEnabled == 1) {
                html +=" <input data-type='checkbox-active' data-dia-entrega-id='"+cDiasEntrega[i].id_dia_entrega+"' id='dia_entrega_punto_retiro_enabled_"+cDiasEntrega[i].id_dia_entrega+"' type='checkbox' checked data-toggle='toggle' data-onstyle='success' data-size='xs'>";
            } else {
                html +=" <input data-dia-entrega-id='"+cDiasEntrega[i].id_dia_entrega+"' id='dia_entrega_punto_retiro_enabled_"+cDiasEntrega[i].id_dia_entrega+"' type='checkbox' data-toggle='toggle' data-onstyle='success' data-size='xs'>";
            }
            html +=" <span style='float:right'>";
            html +=" Envíos a Domicilio: &nbsp;";
            if(cDiasEntrega[i].deliveryEnabled == 1) {
                html +=" <input data-type='checkbox-active' data-dia-entrega-id='"+cDiasEntrega[i].id_dia_entrega+"' id='dia_entrega_delivery_enabled_"+cDiasEntrega[i].id_dia_entrega+"' type='checkbox' checked data-toggle='toggle' data-onstyle='success' data-size='xs'>";
            } else {
                html +=" <input data-dia-entrega-id='"+cDiasEntrega[i].id_dia_entrega+"' id='dia_entrega_delivery_enabled_"+cDiasEntrega[i].id_dia_entrega+"' type='checkbox' data-toggle='toggle' data-onstyle='success' data-size='xs'>";
            }
            html +=" </span>";
            html +=" </div>";
            html +=" <div class='cupones-caja-info'> ";

            var showEditImagenBolson = "";
            if(cDiasEntrega[i].aceptaBolsones == 0) {
                showEditImagenBolson = "style='visibility:hidden'";
            }

            html +=" <div id='imagenDia"+cDiasEntrega[i].id_dia_entrega+"' class='diasEntrega-inner-caja alineado-izq' "+showEditImagenBolson+">";

            let imagen = "not-available.png";
            let rutaImagen = "../assets/img/";
            if(cDiasEntrega[i].imagen!=undefined && cDiasEntrega[i].imagen.length > 0) {
                rutaImagen = "../../assets/img/dias-entrega-imagenes/";
                imagen = cDiasEntrega[i].imagen;
            }

            html +=" <a href='javascript:openImage(\""+imagen+"\")'>";
                html +=" <img class='img-thumbnail' src='"+rutaImagen+imagen+"'/>";
            html +=" </a>";
            html +=" <br />";
            html +=" <a style='margin-left:2px;' href='javascript:editarDiaEntrega("+cDiasEntrega[i].id_dia_entrega+");'>Editar</a>";
            html +=" </div>";
            var showEditBarrios = "";
            if(cDiasEntrega[i].deliveryEnabled == 0) {
                showEditBarrios = "style='display:none'";
            }
            html +=" <div id='editarBarrioLink"+cDiasEntrega[i].id_dia_entrega+"' class='diasEntrega-inner-caja alineado-der' "+showEditBarrios+">";
            var params = ''+cDiasEntrega[i].id_dia_entrega+',"'+cDiasEntrega[i].descripcion+'"';
            html +=" <a style='margin-left:2px;' href='javascript:editarBarrios("+params+");'>Editar Barrios</a>";
            html +=" </div>";
            html +=" </div>";
            html +=" </div>";
            html +=" </div>";
        }
    }else{
        html = "<p style='text-align:center'>No se encontraron dias de entrega activos.</p>"
    }
    $("#diasEntregaList").html(html);
    $('[data-type="checkbox-active"]').bootstrapToggle();
}
*/

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
            html += '<button type="button" data-dia-entrega-id="'+cDiasEntrega[i].id_dia_entrega+'" class="btn btn-primary btn-sm bProcesarPedidosFijos">Procesar Pedidos Fijos</button>';
            html +=" </span>";
            html +=" </div>";

            html +=" <div class='cupones-caja-info'> ";
            var showEditImagenBolson = "";
            if(cDiasEntrega[i].aceptaBolsones == 0) {
                showEditImagenBolson = "style='visibility:hidden'";
            }

            html +=" <div id='imagenDia"+cDiasEntrega[i].id_dia_entrega+"' class='diasEntrega-inner-caja alineado-izq' "+showEditImagenBolson+">";

            let imagen = "not-available.png";
            let rutaImagen = "../assets/img/";
            if(cDiasEntrega[i].imagen!=undefined && cDiasEntrega[i].imagen.length > 0) {
                rutaImagen = "../../assets/img/dias-entrega-imagenes/";
                imagen = cDiasEntrega[i].imagen;
            }

            html +=" <a href='javascript:openImage(\""+imagen+"\")'>";
                html +=" <img class='img-thumbnail' src='"+rutaImagen+imagen+"'/>";
            html +=" </a>";
            html +=" <br />";
            html +=" <a style='margin-left:2px;' href='javascript:editarDiaEntrega("+cDiasEntrega[i].id_dia_entrega+");'>Editar</a>";
            html +=" </div>";
            var showEditBarrios = "";
            if(cDiasEntrega[i].deliveryEnabled == 0) {
                showEditBarrios = "style='display:none'";
            }
            html +=" <div id='editarBarrioLink"+cDiasEntrega[i].id_dia_entrega+"' class='diasEntrega-inner-caja alineado-der' "+showEditBarrios+">";
            var params = ''+cDiasEntrega[i].id_dia_entrega+',"'+cDiasEntrega[i].descripcion+'"';
            html +=" <a style='margin-left:2px;' href='javascript:editarBarrios("+params+");'>Editar Barrios</a>";
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

function crearNuevoDiaDeEntrega(){
    $("#modalCrearDiaEntrega").modal("show");
}

function limpiarFormularioCrearNuevoDiaEntrega(){
    $("#crearDiaEntregaFecha").val("");
    $("#crearDiaEntregaLabelFinal").val("");
    $("#bCrearNuevoDiaEntrega").prop("disabled",false);
    $("#diaEntregaBarriosList").html("");
    $("#newDiaBarriosHabilitados").hide();
    $("#diaEntregaDeliveryStatus").prop("checked",false);
    $("#diaEntregaDeliveryStatus").parent().removeClass("btn-success"); 
    $("#diaEntregaDeliveryStatus").parent().addClass("btn-light off");
    $("#diaEntregaPuntoDeRetiroStatus").prop("checked",false);
    $("#diaEntregaPuntoDeRetiroStatus").parent().removeClass("btn-success"); 
    $("#diaEntregaPuntoDeRetiroStatus").parent().addClass("btn-light off");
    $("#diaEntregaAceptaBolsones").prop("checked",false);
    $("#diaEntregaAceptaBolsones").parent().removeClass("btn-success"); 
    $("#diaEntregaAceptaBolsones").parent().addClass("btn-light off");
    $("#diaEntregaCargaPedidosFijos").prop("checked",false);
    $("#diaEntregaCargaPedidosFijos").parent().removeClass("btn-success"); 
    $("#diaEntregaCargaPedidosFijos").parent().addClass("btn-light off");
    $("#seleccionarTodosBarriosHabilitados").prop("checked",false);
    $("#seleccionarTodosBarriosHabilitados").parent().removeClass("btn-success"); 
    $("#seleccionarTodosBarriosHabilitados").parent().addClass("btn-light off");
    $("#crearDiaEntregaImagenBolson").val("");
    $("#rowImagenBolson").hide();
    updateModalSize();
}

function updateModalSize() {
    $("#modalCrearDiaEntrega").find(".modal-dialog").toggleClass("modal-xl");
    if($("#modalCrearDiaEntrega").find(".modal-dialog").hasClass("modal-xl")) {
        $("#newDiaForm").css("width","39%");
        $("#newDiaBarriosHabilitados").css("width","61%");
        $("#newDiaBarriosHabilitados").show();
    } else {
        $("#newDiaBarriosHabilitados").hide();
        $("#newDiaBarriosHabilitados").css("width","0%");
        arrayBarriosHabilitados = [];
        $("#newDiaForm").css("width","100%");
    }
}

function limpiarBarriosHabilitadosForm() {
    $("#diaEntregaBarriosList").html("");
    $("#newDiaBarriosHabilitados").hide();
    updateModalSize();
}

function refreshImagenBolsonField(bolsonesEnabled) {
    if (bolsonesEnabled) {
        $("#rowImagenBolson").fadeIn();
    } else {
        $("#rowImagenBolson").fadeOut();
    }
}

function checkFormCrearNuevoDiaEntrega(){
    var msj = "";
    if($("#crearDiaEntregaFecha").val()==""){
        msj += "<p>Debe seleccionar una fecha en 'Nuevo Día de Entrega'.</p>";
    }
    let aceptaBolsones = $("#diaEntregaAceptaBolsones").is(':checked') ? 1 : 0;
    if (aceptaBolsones == 1) {
        if($("#crearDiaEntregaImagenBolson").val()==""){
            msj += "<p>Debe seleccionar una imagen en 'Imagen del Bolsón'.</p>";
        }else{
            var extensionDocumento = $('#crearDiaEntregaImagenBolson').val().substr(($('#crearDiaEntregaImagenBolson').val().lastIndexOf('.') + 1));
            extensionDocumento = extensionDocumento.toLowerCase();
            if(extensionDocumento!="jpg" && extensionDocumento!="jpeg" && extensionDocumento!="png") {
                msj += "<p>El archivo de 'Imagen del Bolsón' puede ser JPG, JPEG o PNG.</p>";
            }
        }    
    }
    return msj;
}

function checkFormEditarImagen(){
    var msj = "";
    if($("#diaEntregaEditarImagen").val()==""){
        msj += "<p>Debe seleccionar una imagen en 'Imagen'.</p>";
    }else{
        var extensionDocumento = $('#diaEntregaEditarImagen').val().substr(($('#diaEntregaEditarImagen').val().lastIndexOf('.') + 1));
        extensionDocumento = extensionDocumento.toLowerCase();
        if(extensionDocumento!="jpg" && extensionDocumento!="jpeg" && extensionDocumento!="png") {
            msj += "<p>El archivo 'Imagen' puede ser JPG, JPEG o PNG.</p>";
        }
    }    
    return msj;
}

function changeFormStatus(newStatus){
    Swal.fire({
        title: 'Seguro?',
        text: "Activar/desactivar esto significa que los usuarios podrán (o no) hacer pedidos desde la web. Revisa bien antes de continuar.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
        }).then((result) => {
        if (result.value) {
            $.ajax({
                url: ajaxURL + 'formStatus/' + newStatus,
                method: 'get'
            }).done(function() {
                window.location.reload(true);
            });
        }else{
            window.location.reload(true);
        }
    });    
}

function changePedidosFueraDeHoraStatus(newStatus){
    Swal.fire({
        title: 'Seguro?',
        text: "Activar/desactivar esto significa que los usuarios podrán hacer pedidos las 24hs desde la web. Revisa bien antes de continuar.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
        }).then((result) => {
        if (result.value) {
            $.ajax({
                url: ajaxURL + 'pedidosFueraDeHoraStatus/' + newStatus,
                method: 'get'
            }).done(function() {
                window.location.reload(true);
            });
        }else{
            window.location.reload(true);
        }
    });    
}

function editarDiaEntrega(idDiaEntrega) {
    $("#modalEditarImagenDia").modal("show");
    $("#idDiaEntregaEditar").val(idDiaEntrega);
}

function cargarImagen(idDiaEntrega,input) {
    var imagenBolsonData = input.prop('files')[0];  
    var imagenBolsonDataExtension = input.val().substr((input.val().lastIndexOf('.') + 1));

    var form_data = new FormData();         
    form_data.append('file', imagenBolsonData);    
    form_data.append('fileExtension', imagenBolsonDataExtension);
    form_data.append('idDiaEntrega', idDiaEntrega);

    $.ajax({
        url: ajaxURL + 'diaEntrega/uploadImagenDiaEntrega', // point to server-side PHP script 
        dataType: 'text', // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,             
        type: 'post',
        success: function(res){
            //console.log("HOLA",res);
            //extrasHelper.cleanAddExtraForm();
            window.location.reload(true); 
        }
    });
}

function updateDiaEntregaBox(idDiaEntrega, aceptaBolsones) {
    if(aceptaBolsones==1) {
        $("#imagenDia"+idDiaEntrega).css("visibility","visible");
    } else {
        $("#imagenDia"+idDiaEntrega).css("visibility","hidden");
    }
}

function cargarBarriosActivos() {
    var cBarrios = getBarriosActivos();
    var html = createBarriosHtml(cBarrios,1 /*1=creacionDia*/);
    $("#diaEntregaBarriosList").html(html);
    $('[data-type="checkbox-active"]').bootstrapToggle();
}

function getBarriosActivos() {
    var cBarrios;    
    $.ajax({
        url: ajaxURL + 'barrios/getAllActivos',
        method: 'get',
        async: false
    }).done(function(result) {
        if(result.status == 'ok') {
            if(result.cBarrios!=null){
                cBarrios = result.cBarrios;
            }
        }
    });
    return cBarrios;
}

function createBarriosHtml(cBarrios,from) {
    var html = '<div class="row">';
    var claveId = '';
    if(from==1) {
        claveId = 'diaEntregaBarrio';
    } else if(from==2) {
        claveId = 'diaEntregaEdicionBarrio';
    }
    cBarrios.forEach(function(barrio,index) {
        html += '<div class="col-xs-12 col-sm-4"><span>';
        html += '<input id="'+claveId+barrio.id+'" attr-barrio-id="'+barrio.id+'" type="checkbox" data-toggle="toggle" data-onstyle="success" data-size="xs">';
        html += '&nbsp;<label for="'+claveId+barrio.id+'">'+barrio.nombre+'</label>';
        html += '</span></div>';    
    });
    html += '</div>';
    return html;
}

function editarBarrios(idDiaEntrega, descripcionDiaEntrega) {
    arrayBarriosHabilitados = [];
    var cBarrios = getBarriosActivos();
    var cBarriosHabilitados = getBarriosHabilitadosByDiaEntrega(idDiaEntrega);
    var html = createBarriosHtml(cBarrios,2 /*2=edicionDia*/)
    $("#editarBarriosHabilitadosList").html(html);
    setBarrioshabilitados(cBarriosHabilitados); 
    $("#lNombreDiaEntrega").html(descripcionDiaEntrega);
    $("#modalEditarBarrios").modal("show");
    $("#idDiaEntregaEditar").val(idDiaEntrega);
}

function setBarrioshabilitados(cBarriosHabilitados) {
    if(cBarriosHabilitados!=null && cBarriosHabilitados.length>0) {
        cBarriosHabilitados.forEach(function(oBarrio,index) {
            $("#diaEntregaEdicionBarrio"+oBarrio.id).prop("checked",true);
            var oBarrio = {
                "idBarrio": parseInt(oBarrio.id)
            };    
            arrayBarriosHabilitados.push(oBarrio)
        });
    }
}

function getBarriosHabilitadosByDiaEntrega(idDiaEntrega) {
    var cBarrios;    
    var data = {
        "idDiaEntrega": idDiaEntrega
    }
    $.ajax({
        url: ajaxURL + 'barrios/getBarriosHabilitadosForDiaEntrega',
        method: 'post',
        data: data,
        async: false
    }).done(function(result) {
        if(result.success == true) {
            if(result.cBarriosHabilitados!=null){
                cBarrios = result.cBarriosHabilitados;
            }
        }
    });
    return cBarrios;
}