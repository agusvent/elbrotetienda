let arrayLogisticaParaImprimir = [];
let idTipoLogisticaSeleccionado = -1;
let arrayCamionesToPrint = [];

$(document).ready(function() {
    logisticaHelper.init();
    $("input.numeric").numeric();
});

const logisticaHelper = {
    asignoEventos: function() {
        $("#bEditarCantidadPuntoRetiroBarrio").on("click",function(e){
            e.preventDefault();
            mostrarLoader();
            setTimeout(function(){

                    var idLogistica = $("#editarCantidadPuntoRetiroBarrioIdLogistica").val();
                    var cantModificadaBolsonFamiliar = $("#editarCantidadPuntoRetiroBarrio").val();
                    var cantModificadaBolsonIndividual = $("#editarCantidadBolsonIndividual").val();
                    let idDiaEntregaAPreparar = $("#idDiaEntregaPedido").val();
                    if(cantModificadaBolsonFamiliar!="" && cantModificadaBolsonIndividual!="" && idLogistica>0){
                        var updateOK = modificarCantidadEnLogistica(idLogistica,cantModificadaBolsonFamiliar,cantModificadaBolsonIndividual);
                        cerrarEditarCantidadPuntoRetiroBarrio();
                        if(updateOK){
                            getRegistrosLogistica(idDiaEntregaAPreparar);
                            initCheckboxes();
                            //recargo tarjeta
                            //muestro mensaje
                        }else{
                            alert("NO OK");
                            //muestro error
                        }
                    }
                    ocultarLoader();
            },300);
        });

        $("#bDeleteRegistroLogistica").on("click", function(e){
            e.preventDefault();
            mostrarLoader();
            setTimeout(function(){
                deletePreparacionLogistica();
                ocultarLoader();
            },300);
        });

        $("#bDeleteLogisticaCamion").on("click", function(e){
            e.preventDefault();
            mostrarLoader();
            setTimeout(function(){
                var idLogisticaCamion = $("#idLogisticaCamionDelete").val();
                deleteLogisticaCamion(idLogisticaCamion);
                ocultarLoader();
            },300);
        });

        $("#bCloseRegistroLogistica").on("click", function(e){
            e.preventDefault();
            mostrarLoader();
            setTimeout(function(){
                var idDiaEntrega = $("#idDiaEntregaPedido :selected").val();
                cerrarLogistica(idDiaEntrega);
                ocultarLoader();
                window.location.reload(true);
            },300);
        });

        $("#bPrepararLogisticaDiaEntrega").on("click",function(e) {
            e.preventDefault();
            mostrarLoader();
            setTimeout(function(){
                let idDiaEntregaAPreparar = $("#idDiaEntregaPedido").val();
                $("#idDiaEntregaPedido").prop("disabled",true);
                let data = {
                    'idDiaEntregaAPreparar': idDiaEntregaAPreparar
                };
                $.ajax({
                    url: ajaxURL + 'logistica/prepararDiaEntrega',
                    data: data, 
                    method: 'post',
                    async: false
                }).done(function(result) {
                    if(result.status == 'ok') {
                        ocultarLoader();
                        $("#idEstadoLogisticaDiaEntrega").val(result.idEstadoLogistica);
                        $("#idDiaEntregaSeleccionado").val(idDiaEntregaAPreparar);
                        $("#divPuntosRetiro").show();
                        $("#divBarrios").show();
                        //if($("#idEstadoLogisticaDiaEntrega").val()==2){
                            $("#aDeletePreparacionLogisticaDiaEntrega").show();
                            $("#aCloseLogisticaDiaEntrega").show();
                            $("#aDispCamion").prop("href","javascript:openDisponibilizarCamion();");
                        //}
                        $("#aResumenPedidos").prop("href","javascript:getResumenPedidos();");
                        $("#aListCamiones").prop("href","javascript:openListCamiones();");
                        $("#aPrintSelected").prop("href","javascript:openPrintSelectedPreferences();");
                        $("#aPrintSelectedInCards").prop("href","javascript:printSelectedInCards();");
                        //TENGO QUE EMPEZAR A CARGAR LOS RESUMENES
                        //PRIMERO CARGAR RESUMEN DE PUNTOS DE RETIRO
                        //CANTIDAD TOTAL DE BOLSONES (SIN CANCELADOS)
                        //POSIBILIDAD DE EDITAR EL TOTAL DE BOLSONES DE CADA PUNTO
                        //HACER QUERIES QUE BUSQUEN POR ID_DIA_ENTREGA EN LOS PEDIDOS Y EN DONDE OFFICE_ID SEA NO NULL Y BARRIO_ID SEA NULL AGRUPADO POR PUNTO DE RETIRO
                        var diaEntregaHasItems = checkIfDiaEntregaHasLogisticaItems(idDiaEntregaAPreparar);
                        if(diaEntregaHasItems==false){
                            var registrosLogisticaCreados = crearRegistrosInicialesLogistica(idDiaEntregaAPreparar);
                            var nrosOrdenCreados = setNroOrdenForPedidosByDiaEntrega(idDiaEntregaAPreparar);
                        }
                        getRegistrosLogistica(idDiaEntregaAPreparar);
                        //INICIALIZO EL LISTENER DEL CHECKBOX DE LAS CAJAS
                        initCheckboxes();

                        //INICIALIZO EL ARRAY DE IMPRESION
                        arrayLogisticaParaImprimir = [];
                        idTipoLogisticaSeleccionado = -1;

                    }else{
                        return Swal.fire('Error', 'No se pudo seleccionar el dia indicado.', 'error');
                    }
                }).fail( function( jqXHR, textStatus, errorThrown ) {
                    console.log("Error",jqXHR );
                });       
            },400);
        });

        $("#bCrearCamion").on("click",function(e){
            var nombre = $("#disponibilizarCamionNombre").val();
            var idCamionPreConfigurado = $("#disponibilizarCamionListCamionesPreConfigurados").val();
            var idDiaEntrega = $("#idDiaEntregaSeleccionado").val();
            if(nombre!=null && nombre!=""){
                mostrarLoader();
                setTimeout(function(){
                    var idLogisticaCamion = crearCamionDiaEntrega(idDiaEntrega, nombre, idCamionPreConfigurado);
                    if(idLogisticaCamion > 0 && idCamionPreConfigurado>0){
                        asociarPuntosRetiroBarriosACamion(idDiaEntrega,idLogisticaCamion);
                        getRegistrosLogistica(idDiaEntrega);
                        initCheckboxes();
                    }
                    $("#disponibilizarCamionNombre").val("");
                    $("#disponibilizarCamionModal").modal("hide");
                    ocultarLoader();
                },300);
            }else{
                return Swal.fire('Error', 'Debe ingresar un Nombre para el Camión.', 'error');
            }
        });

        $("#disponibilizarCamionListCamionesPreConfigurados").on("change",function(){
            $("#disponibilizarCamionNombre").val(
                $(this).find('option:selected').text()
            );
        });

        $("#bDeleteLogisticaFromCamion").on("click",function(){
            confirmDeleteLogisticaFromCamion();
        });
        $('#listadoPuntosRetiroYBarriosDeCamionModal').on('hidden.bs.modal', function () {
            $("#listadoCamionesModal").modal("show");
        });

        $('#deleteLogisticaCamionModal').on('hidden.bs.modal', function () {
            $("#listadoCamionesModal").modal("show");
            $("#idLogisticaCamionDelete").val(-1);
        });
        

        $('#disponibilizarCamionModal').on('hidden.bs.modal', function () {
            $("#disponibilizarCamionNombre").val("");
        });
        
        $('#listadoCamionesModal').on('hidden.bs.modal', function () {
            arrayCamionesToPrint = [];
        });
        

        $("#bAsociarPuntoRetiroOBarrioACamion").on("click",function(){
            if($("input:radio[name='radioCamionesDisponibles']:checked").length>0){
                mostrarLoader();
                setTimeout(function(){
                    var idLogistica = $("#idLogisticaParaAsociarACamion").val();
                    var idCamion = $("input:radio[name='radioCamionesDisponibles']:checked").val();
                    var camionAsociado = false;
                    camionAsociado = setCamionToLogistica(idLogistica,idCamion);
                    if(camionAsociado){
                        var idDiaEntrega = $("#idDiaEntregaSeleccionado").val();
                        getRegistrosLogistica(idDiaEntrega);
                        initCheckboxes();
                        $("#listadoSeleccionCamionesDisponiblesModal").modal("hide");
                        $("#idLogisticaParaAsociarACamion").val(-1);
                        ocultarLoader();
                    }
                },300);
            }
        });
        $("#bImprimirLogistica").on("click",function(e){
            e.preventDefault();
            mostrarLoader();
            setTimeout(function(){
                var idLogistica = $("#printPreferencesIdLogistica").val();
                var idTipoLogistica = $("#idTipoLogistica").val();
                //idTipoLogistica = 1 ==> PUNTO DE RETIRO
                //idTipoLogistica = 2 ==> BARRIO
                /*if(idTipoLogistica==1){
                    printLogisticaPuntoRetiro(idLogistica);
                }else if(idTipoLogistica==2){
                    printLogisticaBarrio(idLogistica);
                }else{
                    if(arrayLogisticaParaImprimir.length>0){
                        printLogisticaMultipleSeleccion();
                    }
                }*/
                if(arrayLogisticaParaImprimir.length>0){
                    printLogisticaMultipleSeleccion();
                }
            ocultarLoader();
            },200);
        });

        $("#printPreferencesModal").on("hidden.bs.modal", function () {
            $("#printPreferencesTipoImpresion").prop("disabled",true);
            //PREDEFINIDO EN UNA POR PAGINA
            $("#printPreferencesTipoImpresion").val(1);
            //PREDEFINIDO EN PDF
            $("#printPreferencesTipoExtension").val(2);
            //ESTO LO HACEMOS POR SI VENIA DE UNA IMPRESION INDIVIDUAL
            $("#idTipoLogistica").val(-1);
        });

        $("#printPreferencesTipoExtension").on("change",function(){
            if( $(this).val() == 1 ){
                //SI ES XLS
                $("#printPreferencesTipoImpresion").prop("disabled",true);
            }else{
                $("#printPreferencesTipoImpresion").prop("disabled",false);
            }
        })

        $("#checkSeleccionarTodosPuntosDeRetiro").on("click",function(){
            if( $(this).prop("checked") ){
                $('.checkLogistica[data-tipologistica="1"]').prop("checked",true);

                var idTipoLogistica = 1;
                if(arrayLogisticaParaImprimir.length==0){
                    idTipoLogisticaSeleccionado = idTipoLogistica;
                }
                if(idTipoLogisticaSeleccionado == idTipoLogistica){

                    $('.checkLogistica[data-tipologistica="1"]').each(function(index){
                        var oLogistica = {
                            "idLogistica": parseInt($(this).val())
                        };
        
                        arrayLogisticaParaImprimir.push(oLogistica);    
                    });

                }else{
                    alert("No podes mezclar tipos");
                    $(this).prop("checked",false);
                    $('.checkLogistica[data-tipologistica="1"]').prop("checked",false);
                }

            }else{
                $('.checkLogistica[data-tipologistica="1"]').prop("checked",false);
                arrayLogisticaParaImprimir = [];
                idTipoLogisticaSeleccionado = -1;
            }
        });

        $("#checkSeleccionarTodosBarrios").on("click",function(){
            if( $(this).prop("checked") ){
                $('.checkLogistica[data-tipologistica="2"]').prop("checked",true);

                var idTipoLogistica = 2;
                if(arrayLogisticaParaImprimir.length==0){
                    idTipoLogisticaSeleccionado = idTipoLogistica;
                }
                if(idTipoLogisticaSeleccionado == idTipoLogistica){

                    $('.checkLogistica[data-tipologistica="2"]').each(function(index){
                        var oLogistica = {
                            "idLogistica": parseInt($(this).val())
                        };
        
                        arrayLogisticaParaImprimir.push(oLogistica);    
                    });

                }else{
                    alert("No podes mezclar tipos");
                    $(this).prop("checked",false);
                    $('.checkLogistica[data-tipologistica="2"]').prop("checked",false);
                }

            }else{
                $('.checkLogistica[data-tipologistica="2"]').prop("checked",false);
                arrayLogisticaParaImprimir = [];
                idTipoLogisticaSeleccionado = -1;
            }
        });    
        $("#bImprimirAllCamiones").on("click",function(e){
            e.preventDefault();
            printAllCamiones();
        });
        $("#bImprimirAllCamionesConDetalles").on("click",function(e){
            e.preventDefault();
            printAllCamionesConDetalles();
        });
        $("#bImprimirSeleccionComandas").on("click",function(e){
            e.preventDefault();
            if(arrayCamionesToPrint.length>0) {
                printCamionesSeleccionadosInCards();
            } else {
                alert("Debe seleccionar algún camión.");
            }
        });
        $("#bImprimirSeleccion").on("click",function(e){
            e.preventDefault();
            if(arrayCamionesToPrint.length>0) {
                printCamionesSeleccionados();
            } else {
                alert("Debe seleccionar algún camión.");
            }
        });
    },

    init: function(){
        this.asignoEventos();
        getDiasEntregaAPreparar();
    }
}

function getRegistrosLogistica(idDiaEntrega){
    getLogisticaPuntosRetiroByDiaEntrega(idDiaEntrega);
    getLogisticaBarriosByDiaEntrega(idDiaEntrega);
}

function setNroOrdenForPedidosByDiaEntrega(idDiaEntregaAPreparar){
    var nrosOrdenDefinidos = false;
    let data = {
        'idDiaEntrega' : idDiaEntregaAPreparar
    };
    $.ajax({
        url: ajaxURL + 'logistica/setNroOrdenForPedidosByDiaEntrega',
        method: 'post',
        data: data,
        async: false
    }).done(function(result) {
        if(result.status == 'ok') {
            nrosOrdenDefinidos = true;
        }
    });
    return  nrosOrdenDefinidos;
}

function crearRegistrosInicialesLogistica(idDiaEntregaAPreparar){
    var registrosLogisticaCreados = false;
    let data = {
        'idDiaEntrega' : idDiaEntregaAPreparar
    };
    $.ajax({
        url: ajaxURL + 'logistica/crearRegistrosInicialesLogistica',
        method: 'post',
        data: data,
        async: false
    }).done(function(result) {
        if(result.status == 'ok') {
            registrosLogisticaCreados = true;
        }
    });
    return  registrosLogisticaCreados;
}

function checkIfDiaEntregaHasLogisticaItems(idDiaEntrega){
    let diaEntregaHasItems = false;
    $.ajax({
        url: ajaxURL + 'logistica/checkIfDiaEntregaHasLogisticaItems/'+idDiaEntrega,
        method: 'get',
        async: false
    }).done(function(result) {
        diaEntregaHasItems = result.diaEntregaHasItems;
    });
    return diaEntregaHasItems;
}

function getLogisticaPuntosRetiroByDiaEntrega(idDiaEntrega){
    let cLogisticaPuntosRetiro;
    $.ajax({
        url: ajaxURL + 'logistica/getLogisticaPuntosRetiroByDiaEntrega/'+idDiaEntrega,
        method: 'get',
        async: false
    }).done(function(result) {
        cLogisticaPuntosRetiro = result.cLogisticaPuntosRetiro;
        var idEstadoLogistica = result.idEstadoLogistica
        drawLogisticaPuntosRetiro(cLogisticaPuntosRetiro,idEstadoLogistica);
    });
}

function drawLogisticaPuntosRetiro(cLogisticaPuntosRetiro,idEstadoLogistica){
    var html = "";
    
    for(var i=0;i<cLogisticaPuntosRetiro.length;i++){
        var auxHtml = "";
        auxHtml = generateHtmlForPuntoRetiroLogisticaBox(cLogisticaPuntosRetiro[i],idEstadoLogistica);
        html += auxHtml;
    }
    $("#divContenidoPuntosRetiro").html(html);
}

function generateHtmlForPuntoRetiroLogisticaBox(oLogisticaPuntoRetiro,idEstadoLogistica){
    //console.log(oLogisticaPuntoRetiro);
    var auxHtml = "";
    var sumaCantBolsonesModificados = parseInt(oLogisticaPuntoRetiro.cantidad_modificada) + parseInt(oLogisticaPuntoRetiro.cantidad_bolsones_individuales_modificado);
    auxHtml += '<div class="col-sm-3" style="margin-bottom: 10px;padding-left:5px;padding-right:5px;">';
    auxHtml += '<div class="caja-listado-cajas">';
    auxHtml += '<input type="checkbox" class="checkLogistica" name="checkLogisticaPuntoRetiro'+oLogisticaPuntoRetiro.id_logistica+'" id="checkLogisticaPuntoRetiro'+oLogisticaPuntoRetiro.id_logistica+'" value="'+oLogisticaPuntoRetiro.id_logistica+'" data-tipoLogistica="1">';
    auxHtml += '<label class="marginLeft5" id="labelCheckLogistica'+oLogisticaPuntoRetiro.id_logistica+'" for="checkLogisticaPuntoRetiro'+oLogisticaPuntoRetiro.id_logistica+'">'+oLogisticaPuntoRetiro.puntoRetiroNombre+'</label>'
    auxHtml += '<span style="position:absolute;font-size: 40px;font-weight: 600;right: 15px;top: 15px;">'+oLogisticaPuntoRetiro.total_pedidos+'</span>';
    auxHtml += '<p style="margin-bottom:2px;font-size:12px;color:#000000;" id="pCantOriginal'+oLogisticaPuntoRetiro.id_logistica+'">Cant.Familiares: '+oLogisticaPuntoRetiro.cantidad_modificada+'</p>';
    auxHtml += '<p style="margin-bottom:2px;font-size:12px;color:#000000;" id="pCantEspeciales'+oLogisticaPuntoRetiro.id_logistica+'">Familiares Especiales: '+oLogisticaPuntoRetiro.cantidad_especiales+'</p>';
    auxHtml += '<p style="margin-bottom:2px;font-size:12px;color:#000000;" id="pCantIndividualesOriginal'+oLogisticaPuntoRetiro.id_logistica+'">Cant.Individuales: '+oLogisticaPuntoRetiro.cantidad_bolsones_individuales_modificado+'</p>';
    auxHtml += '<p style="margin-bottom:2px;font-size:12px;color:#000000;" id="pCantEspeciales'+oLogisticaPuntoRetiro.id_logistica+'">Individuales Especiales: '+oLogisticaPuntoRetiro.cantidad_bolsones_individuales_especiales+'</p>';
    auxHtml += '<p style="margin-bottom:2px;font-size:12px;color:#000000;" id="pCantPedidosTienda'+oLogisticaPuntoRetiro.id_logistica+'">Pedidos Tienda: '+oLogisticaPuntoRetiro.total_pedidos_tienda+'</p>';
    //CUANDO DESARROLLE EL DISPONIBILIZAR CAMIONES, ESTOS REGISTROS VAN A ESTAR UNIDOS A UNA TABLA NUEVA LOGISTICA_CAMIONES QUE VA A TENER
    //CADA CAMION DISPONIBILIZADO POR DIA DE ENTREGA, SI LEVANTA TEMPLATE DE UN CAMION PRE CONFIGURADO Y NOMBRE
    var tieneCamion = false;
    if(oLogisticaPuntoRetiro.id_logistica_camion!=null && oLogisticaPuntoRetiro.id_logistica_camion>0){
        auxHtml += '<p style="font-weight:600;margin-bottom:2px;font-size:12px;color:#007022;">'+oLogisticaPuntoRetiro.nombreCamion+'</p>';
        tieneCamion = true;
    }else{
        auxHtml += '<p style="font-weight:600;margin-bottom:2px;font-size:12px;color:#FF0000;">PENDIENTE</p>';
    }
    
    auxHtml += '<p style="margin-bottom:2px;text-align:right;margin-right:10px;">';
    if(tieneCamion==false && idEstadoLogistica!=3){
        auxHtml += '<a href="javascript:asociarACamion('+oLogisticaPuntoRetiro.id_logistica+');">'
        auxHtml += '<img src="../assets/img/truckIcon.png" style="width:30px;" title="Asociar a Camion"/>';
        auxHtml += '</a>';    
        auxHtml += '<a href="javascript:openEditCantidadPuntoRetiroBarrio('+oLogisticaPuntoRetiro.id_logistica+');">'
        auxHtml += '<img src="../assets/img/edit.png" style="width:24px;" title="Editar Cantidad"/>';
        auxHtml += '</a>';
    }
    //El segundo parametro de openPrintPreferences = 1 ==> Indica que es Punto de Retiro
    auxHtml += '<a href="javascript:openPrintPreferences('+oLogisticaPuntoRetiro.id_logistica+',1);">'
    auxHtml += '<img src="../assets/img/printer.png" style="width:24px;" title="Imprimir PDF"/>';
    auxHtml += '</a>';
    auxHtml += '</p>';
    auxHtml += '</div>';
    auxHtml += '</div>';
    return auxHtml;
}

function getLogisticaBarriosByDiaEntrega(idDiaEntrega){
    let cLogisticaBarrios;
    $.ajax({
        url: ajaxURL + 'logistica/getLogisticaBarriosByDiaEntrega/'+idDiaEntrega,
        method: 'get',
        async: false
    }).done(function(result) {
        cLogisticaBarrios = result.cLogisticaBarrios;
        drawLogisticaBarrios(cLogisticaBarrios);
    });
}

function drawLogisticaBarrios(cLogisticaBarrios){
    var html = "";
    
    for(var i=0;i<cLogisticaBarrios.length;i++){
        var auxHtml = "";
        auxHtml = generateHtmlForBarrioLogisticaBox(cLogisticaBarrios[i]);
        html += auxHtml;
    }
    $("#divContenidoBarrios").html(html);
}

function generateHtmlForBarrioLogisticaBox(oLogisticaBarrios){
    var auxHtml = "";
    var sumaCantBolsonesModificados = parseInt(oLogisticaBarrios.cantidad_modificada) + parseInt(oLogisticaBarrios.cantidad_bolsones_individuales_modificado);
    auxHtml += '<div class="col-sm-3" style="margin-bottom: 10px;padding-left:5px;padding-right:5px;">';
    auxHtml += '<div class="caja-listado-cajas">';
    auxHtml += '<input type="checkbox" class="checkLogistica" name="checkLogisticaBarrio'+oLogisticaBarrios.id_logistica+'" id="checkLogisticaBarrio'+oLogisticaBarrios.id_logistica+'" value="'+oLogisticaBarrios.id_logistica+'" data-tipoLogistica="2">';
    auxHtml += '<label class="marginLeft5" id="labelCheckLogistica'+oLogisticaBarrios.id_logistica+'" for="checkLogisticaBarrio'+oLogisticaBarrios.id_logistica+'">'+oLogisticaBarrios.barrioNombre+'</label>'
    auxHtml += '<span style="position:absolute;font-size: 40px;font-weight: 600;right: 15px;top: 15px;">'+oLogisticaBarrios.total_pedidos+'</span>';
    auxHtml += '<p style="margin-bottom:2px;font-size:12px;color:#000000;" id="pCantOriginal'+oLogisticaBarrios.id_logistica+'">Cant.Familiares: '+oLogisticaBarrios.cantidad_modificada+'</p>';
    auxHtml += '<p style="margin-bottom:2px;font-size:12px;color:#000000;" id="pCantEspeciales'+oLogisticaBarrios.id_logistica+'">Familiares Especiales: '+oLogisticaBarrios.cantidad_especiales+'</p>';
    auxHtml += '<p style="margin-bottom:2px;font-size:12px;color:#000000;" id="pCantIndividualesOriginal'+oLogisticaBarrios.id_logistica+'">Cant.Individuales: '+oLogisticaBarrios.cantidad_bolsones_individuales_modificado+'</p>';
    auxHtml += '<p style="margin-bottom:2px;font-size:12px;color:#000000;" id="pCantEspeciales'+oLogisticaBarrios.id_logistica+'">Individuales Especiales: '+oLogisticaBarrios.cantidad_bolsones_individuales_especiales+'</p>';
    auxHtml += '<p style="margin-bottom:2px;font-size:12px;color:#000000;" id="pCantPedidosTienda'+oLogisticaBarrios.id_logistica+'">Pedidos Tienda: '+oLogisticaBarrios.total_pedidos_tienda+'</p>';
    //CUANDO DESARROLLE EL DISPONIBILIZAR CAMIONES, ESTOS REGISTROS VAN A ESTAR UNIDOS A UNA TABLA NUEVA LOGISTICA_CAMIONES QUE VA A TENER
    //CADA CAMION DISPONIBILIZADO POR DIA DE ENTREGA, SI LEVANTA TEMPLATE DE UN CAMION PRE CONFIGURADO Y NOMBRE
    var tieneCamion = false;
    if(oLogisticaBarrios.id_logistica_camion!=null && oLogisticaBarrios.id_logistica_camion>0){
        auxHtml += '<p style="font-weight:600;margin-bottom:2px;font-size:12px;color:#007022;">'+oLogisticaBarrios.nombreCamion+'</p>';
        tieneCamion = true;
    }else{
        auxHtml += '<p style="font-weight:600;margin-bottom:2px;font-size:12px;color:#FF0000;">PENDIENTE</p>';
    }

    auxHtml += '<p style="margin-bottom:2px;text-align:right;margin-right:10px;">';
    if(tieneCamion==false){
        auxHtml += '<a href="javascript:asociarACamion('+oLogisticaBarrios.id_logistica+');">'
        auxHtml += '<img src="../assets/img/truckIcon.png" style="width:30px;" title="Asociar a Camion"/>';
        auxHtml += '</a>';    

        auxHtml += '<a href="javascript:openEditCantidadPuntoRetiroBarrio('+oLogisticaBarrios.id_logistica+');">'
        auxHtml += '<img src="../assets/img/edit.png" style="width:24px;"/>';
        auxHtml += '</a>';
    }
    //El segundo parametro de openPrintPreferences = 2 ==> Indica que es Barrio
    auxHtml += '<a href="javascript:openPrintPreferences('+oLogisticaBarrios.id_logistica+',2);">'
    auxHtml += '<img src="../assets/img/printer.png" style="width:24px;"/>';
    auxHtml += '</a>';
    auxHtml += '</p>';
    auxHtml += '</div>';
    auxHtml += '</div>';
    return auxHtml;
}

function openDeleteRegistroLogistica(){
    $("#deleteRegistroLogisticaModal").modal("show");
    $("#sDeleteRegistroLogisticaDiaEntrega").html(
        $("#idDiaEntregaPedido :selected").text()
    );
}

function deleteRegistrosLogistica(idDiaEntrega){
    var registrosLogisticaEliminados = false;
    let data = {
        'idDiaEntrega' : idDiaEntrega
    };
    
    $.ajax({
        url: ajaxURL + 'logistica/eliminarRegistrosLogistica',
        method: 'post',
        data: data,
        async: false
    }).done(function(result) {
        if(result.status == 'ok') {
            registrosLogisticaEliminados = true;
        }
    });
    return registrosLogisticaEliminados;

}

function deletePreparacionLogistica(){
    var idDiaEntrega = $("#idDiaEntregaPedido").val();
    $("#idDiaEntregaPedido").prop("disabled",false);
    deleteRegistrosLogistica(idDiaEntrega);
    limpiarContenidoDivPuntosRetiro();
    limpiarContenidoDivBarrios();
    $("#divPuntosRetiro").hide();
    $("#divBarrios").hide();
    $("#aDeletePreparacionLogisticaDiaEntrega").hide();
    $("#aCloseLogisticaDiaEntrega").hide();
    $("#deleteRegistroLogisticaModal").modal("hide");
    $("#aDispCamion").prop("href","#");
    $("#aListCamiones").prop("href","#");
    $("#idEstadoLogisticaDiaEntrega").val(-1);
    getDiasEntregaAPreparar();
}

function limpiarContenidoDivPuntosRetiro(){
    $("#divContenidoPuntosRetiro").html("");
}

function limpiarContenidoDivBarrios(){
    $("#divContenidoBarrios").html("");
}

function getDiasEntregaAPreparar(){
    let cDiasEntrega;
    $.ajax({
        url: ajaxURL + 'logistica/getDiasEntregaAPreparar/',
        method: 'get',
        async: false
    }).done(function(result) {
        cDiasEntrega = result.cDiasEntrega;
        drawDiasEntregaComboOptions(cDiasEntrega);
    });
}

function drawDiasEntregaComboOptions(cDiasEntrega){
    var html = "";
    $("#idDiaEntregaPedido").html("");
    for(var i=0;i<cDiasEntrega.length;i++){
         if(i==0){
             html += '<option value="'+cDiasEntrega[i].id_dia_entrega+'" selected>';
         }else{
            html += '<option value="'+cDiasEntrega[i].id_dia_entrega+'">';
         }
         html += '[ '+cDiasEntrega[i].estadoLogistica+' ] '+cDiasEntrega[i].descripcion;
         html += '</option>';
    }
    $("#idDiaEntregaPedido").html(html);
}

function cerrarEditarCantidadPuntoRetiroBarrio(){
    $("#editarCantidadPuntoRetiroBarrioModal").modal('hide');
    $("#editarCantidadPuntoRetiroBarrioIdLogistica").val(-1);
    $("#lNombrePuntoRetiroBarrio").html("");
    $("#editarCantidadPuntoRetiroBarrio").val("");
}

function openEditCantidadPuntoRetiroBarrio(idLogistica){
    mostrarLoader();
    $("#editarCantidadPuntoRetiroBarrioIdLogistica").val(idLogistica);
    setTimeout(function(){
        var cantBolsonFamiliar = getCantidadModificadaFromBolsonFamiliar(idLogistica);
        var cantBolsonIndividual = getCantidadModificadaFromBolsonIndividual(idLogistica);
        var nombre = getNombrePuntoRetiroBarrio(idLogistica);

        $("#editarCantidadPuntoRetiroBarrio").val(cantBolsonFamiliar);
        $("#editarCantidadBolsonIndividual").val(cantBolsonIndividual);
        $("#lNombrePuntoRetiroBarrio").html(nombre);
        $("#editarCantidadPuntoRetiroBarrioModal").modal('show');
        ocultarLoader();
    },400);
}

function getCantidadModificadaFromBolsonFamiliar(idLogistica){
    let cantModificadaBolsonFamiliar = 0;
    $.ajax({
        url: ajaxURL + 'logistica/getCantidadModificadaFromBolsonFamiliarByLogistica/'+idLogistica,
        method: 'get',
        async: false
    }).done(function(result) {
        cantModificadaBolsonFamiliar = result.cantidadModificadaBolsonFamiliar;
    });
    return cantModificadaBolsonFamiliar;
}

function getCantidadModificadaFromBolsonIndividual(idLogistica){
    let cantModificadaBolsonIndividual = 0;
    $.ajax({
        url: ajaxURL + 'logistica/getCantidadModificadaFromBolsonIndividualByLogistica/'+idLogistica,
        method: 'get',
        async: false
    }).done(function(result) {
        cantModificadaBolsonIndividual = result.cantidadModificadaBolsonIndividual;
    });
    return cantModificadaBolsonIndividual;
}

function getNombrePuntoRetiroBarrio(idLogistica){
    let nombrePuntoRetiroBarrio = "";
    $.ajax({
        url: ajaxURL + 'logistica/getNombrePuntoRetiroBarrioByLogistica/'+idLogistica,
        method: 'get',
        async: false
    }).done(function(result) {
        nombrePuntoRetiroBarrio = result.nombrePuntoRetiroBarrio;
    });
    return nombrePuntoRetiroBarrio;
}

function modificarCantidadEnLogistica(idLogistica,cantModificadaBolsonFamiliar,cantModificadaBolsonIndividual){
    var updateOK = false;
    let data = {
        'idLogistica' : idLogistica,
        'cantModificadaBolsonFamiliar' : cantModificadaBolsonFamiliar,
        'cantModificadaBolsonIndividual' : cantModificadaBolsonIndividual
    };
    $.ajax({
        url: ajaxURL + 'logistica/modificarCantidadBolsonesPuntoRetiroBarrio',
        data: data,
        method: 'post',
        async: false
    }).done(function(result) {
        updateOK = result.cantidadModificadaOK;
    });
    return updateOK;
}

function openDisponibilizarCamion(){
    let idDiaEntrega = $("#idDiaEntregaSeleccionado").val();
    var cCamionesPreConfigurados = getCamionesPreConfiguradosDisponibles(idDiaEntrega);
    setCamionesPreConfiguradosDisponibles(cCamionesPreConfigurados);
    $("#disponibilizarCamionModal").modal("show");
}

function getCamionesPreConfiguradosDisponibles(idDiaEntrega){
    var cCamionesPreConfigurados;
    $.ajax({
        url: ajaxURL + 'logistica/getCamionesPreConfiguradosDisponibles/'+idDiaEntrega,
        method: 'get',
        async: false
    }).done(function(result) {
        cCamionesPreConfigurados = result.cCamionesPreConfigurados;
    });
    return cCamionesPreConfigurados;
}

function setCamionesPreConfiguradosDisponibles(cCamionesPreConfigurados){
    var html = '<option value="-1">Ninguno</option>';
    for(var i=0;i<cCamionesPreConfigurados.length;i++){
        html += '<option value="'+cCamionesPreConfigurados[i].id_camion_preconfigurado+'">'+cCamionesPreConfigurados[i].nombre+'</option>';
    }
    $("#disponibilizarCamionListCamionesPreConfigurados").html(html);
}

function crearCamionDiaEntrega(idDiaEntrega, nombre, idCamionPreConfigurado){
    var idLogisticaDiasEntregaCamion = -1;
    let data = {
        'idDiaEntrega' : idDiaEntrega,
        'nombreCamion' : nombre,
        'idCamionPreConfigurado' : idCamionPreConfigurado
    };
    $.ajax({
        url: ajaxURL + 'logistica/createLogisticaCamionDiaEntrega',
        data: data,
        method: 'post',
        async: false
    }).done(function(result) {
        idLogisticaDiasEntregaCamion = result.idLogisticaDiasEntregaCamion;
    });
    return idLogisticaDiasEntregaCamion;   
}

function asociarPuntosRetiroBarriosACamion(idDiaEntrega, idLogisticaDiasEntregaCamion){
    var asociacionOK = false;
    let data = {
        'idDiaEntrega' : idDiaEntrega,
        'idLogisticaDiasEntregaCamion' : idLogisticaDiasEntregaCamion
    };
    $.ajax({
        url: ajaxURL + 'logistica/asociarPuntosRetiroBarriosACamion',
        data: data,
        method: 'post',
        async: false
    }).done(function(result) {
        asociacionOK = result.asociacionOK;
    });
    return asociacionOK;   
}

function openListCamiones(){
    mostrarLoader();
    setTimeout(function(){
        var idDiaEntrega = $("#idDiaEntregaSeleccionado").val();
        var cCamiones = getLogisticaCamionesByDiaEntrega(idDiaEntrega);
        drawCamionesList(cCamiones);
        $("#listadoCamionesModal").modal("show");
        ocultarLoader();
    },300)
}

function getLogisticaCamionesByDiaEntrega(idDiaEntrega){
    var cCamiones;
    $.ajax({
        url: ajaxURL + 'logistica/getCamionesByDiaEntrega/'+idDiaEntrega,
        method: 'get',
        async: false
    }).done(function(result) {
        cCamiones = result.cCamiones;
    });
    return cCamiones;
}

function drawCamionesList(cCamiones){
    var html = "";
    var total = 0;
    for(var i=0;i<cCamiones.length;i++){
        subtotal = parseInt(cCamiones[i].cantBolsonesFamiliares) + parseInt(cCamiones[i].cantBolsonesIndividuales);
        total = total + subtotal;

        html += "<tr style='border-bottom:1px dotted #000000;line-height: 30px;'>";
        html += "<td style='text-align:center'><input type='checkbox' class='checkCamionToPrint' name='checkCamionToPrint"+cCamiones[i].idLogisticaCamion+"' id='checkCamionToPrint"+cCamiones[i].idLogisticaCamion+"' value='"+cCamiones[i].idLogisticaCamion+"'>";
        html += "<td id='tdNombreCamionLogistica"+cCamiones[i].idLogisticaCamion+"'>"+cCamiones[i].nombreCamion+"</td>";
        html += "<td style='text-align:center;background-color:#cccccc'>"+subtotal+"</td>";
        
        html += "<td style='text-align:center'>"+cCamiones[i].cantBolsonesFamiliares+"</td>";
        html += "<td style='text-align:center'>"+cCamiones[i].cantBolsonesIndividuales+"</td>";
        
        html += "<td style='text-align:center'>"+cCamiones[i].cantBolsonesFamiliaresEspeciales+"</td>";
        html += "<td style='text-align:center'>"+cCamiones[i].cantBolsonesIndividualesEspeciales+"</td>";
        html += "<td style='text-align:center'><a href='javascript:viewPuntosYBarriosByCamion("+cCamiones[i].idLogisticaCamion+")'>";
        html += "<img src='../assets/img/eye.png' style='width:32px'/>";
        html += "</a></td>";
        html += "<td style='text-align:center'><a href='javascript:printCamion("+cCamiones[i].idLogisticaCamion+")'>";
        html += "<img src='../assets/img/printer.png' style='width:30px'/>";
        html += "</a></td>";
        if($("#idEstadoLogisticaDiaEntrega").val()==2){
            html += "<td style='text-align:center'><a href='javascript:openDeleteCamion("+cCamiones[i].idLogisticaCamion+")'>";
            html += "<img src='../assets/img/trash.png' style='width:35px'/>";
            html += "</a></td>";
        }else{
            html += "<td>&nbsp;</td>";
        }
        html += "</tr>";
        subtotal = 0;
    }
    html += "<tr style='line-height: 30px;'>";
    html += "<td colspan='2'>&nbsp;</td><td style='border-bottom:1px dotted #000000;text-align:center;background-color:#cccccc'><b>"+total+"</b></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
    html += "</tr>";
    $("#tListadoCamionesDiaEntrega").html(html);
    initCheckboxesCamionesToPrint();
}

function viewPuntosYBarriosByCamion(idLogisticaDiaEntregaCamion){
    $("#listadoCamionesModal").modal("hide");
    mostrarLoader();
    setTimeout(function(){
        $("#idLogisticaDiaEntregaCamion").val(idLogisticaDiaEntregaCamion);
        getDetailsByCamion(idLogisticaDiaEntregaCamion);    
        var nombrePuntoOBarrio = $("#tdNombreCamionLogistica"+idLogisticaDiaEntregaCamion).html();
        $("#lNombrePuntoRetiroOBarrio").html(nombrePuntoOBarrio);
        $("#listadoPuntosRetiroYBarriosDeCamionModal").modal("show");
        ocultarLoader();
    },300);
}

function getPuntosDeRetiroByCamion(idLogisticaDiaEntregaCamion){
    var cPuntosDeRetiro;
    $.ajax({
        url: ajaxURL + 'logistica/getPuntosRetiroByCamion/'+idLogisticaDiaEntregaCamion,
        method: 'get',
        async: false
    }).done(function(result) {
        cPuntosDeRetiro = result.cPuntosDeRetiro;
    });
    return cPuntosDeRetiro;
}

function getCamionByIdCamion(idLogisticaDiaEntregaCamion){
    var oCamion;
    $.ajax({
        url: ajaxURL + 'logistica/getCamionByIdCamion/'+idLogisticaDiaEntregaCamion,
        method: 'get',
        async: false
    }).done(function(result) {
        oCamion = result.oCamion;
    });
    return oCamion;
}

function getBarriosByCamion(idLogisticaDiaEntregaCamion){
    var cBarrios;
    $.ajax({
        url: ajaxURL + 'logistica/getBarriosByCamion/'+idLogisticaDiaEntregaCamion,
        method: 'get',
        async: false
    }).done(function(result) {
        cBarrios = result.cBarrios;
    });
    return cBarrios;
}

function getDetailsByCamion(idLogisticaDiaEntregaCamion){
    var cPuntosDeRetiro = getPuntosDeRetiroByCamion(idLogisticaDiaEntregaCamion)
    drawPuntosDeRetiroByCamiones(cPuntosDeRetiro);
    var cBarrios = getBarriosByCamion(idLogisticaDiaEntregaCamion)
    drawBarriosByCamiones(cBarrios);
}

function drawPuntosDeRetiroByCamiones(cPuntosDeRetiro){
    var html = "";
    if(cPuntosDeRetiro.length>0){
        var totalBolsones = 0;
        for(var i=0;i<cPuntosDeRetiro.length;i++){
            totalBolsones = parseInt(cPuntosDeRetiro[i].cantidad_modificada) + parseInt(cPuntosDeRetiro[i].cantidad_bolsones_individuales_modificado);
            html += "<tr style='border-bottom:1px dotted #000000;line-height: 30px;'>";
            html += "<td id='tdLogistcaName"+cPuntosDeRetiro[i].id_logistica+"'>"+cPuntosDeRetiro[i].puntoRetiro+"</td>";
            html += "<td style='text-align:center;background-color:#cccccc'>"+totalBolsones+"</td>";
            html += "<td style='text-align:center'>"+cPuntosDeRetiro[i].cantidad_modificada+"</td>";
            html += "<td style='text-align:center'>"+cPuntosDeRetiro[i].cantidad_bolsones_individuales_modificado+"</td>";
            html += "<td style='text-align:center'>"+cPuntosDeRetiro[i].cantidad_especiales+"</td>";
            html += "<td style='text-align:center'>"+cPuntosDeRetiro[i].cantidad_bolsones_individuales_especiales+"</td>";
            html += "<td style='text-align:center'><a href='javascript:deleteLogisticaFromCamion("+cPuntosDeRetiro[i].id_logistica+")'>";
            html += "<img src='../assets/img/trash.png' style='width:32px'/>";
            html += "</a></td>";
            html += "</tr>";
        }
    }else{
        html = "<tr><td colspan='7' style='text-align:center;'>No se encontraron resultados.</td></tr>";
    }
    $("#tListadoPuntosRetiroDeCamion").html(html);
}

function drawBarriosByCamiones(cBarrios){
    var html = "";
    if(cBarrios.length>0){
        var totalBolsones = 0;
        for(var i=0;i<cBarrios.length;i++){
            totalBolsones = parseInt(cBarrios[i].cantidad_modificada) + parseInt(cBarrios[i].cantidad_bolsones_individuales_modificado);
            html += "<tr style='border-bottom:1px dotted #000000;line-height: 30px;'>";
            html += "<td id='tdLogistcaName"+cBarrios[i].id_logistica+"'>"+cBarrios[i].barrio+"</td>";
            html += "<td style='text-align:center;background-color:#cccccc'>"+totalBolsones+"</td>";
            html += "<td style='text-align:center'>"+cBarrios[i].cantidad_modificada+"</td>";
            html += "<td style='text-align:center'>"+cBarrios[i].cantidad_bolsones_individuales_modificado+"</td>";
            html += "<td style='text-align:center'>"+cBarrios[i].cantidad_especiales+"</td>";
            html += "<td style='text-align:center'>"+cBarrios[i].cantidad_bolsones_individuales_especiales+"</td>";
            html += "<td style='text-align:center'><a href='javascript:deleteLogisticaFromCamion("+cBarrios[i].id_logistica+")'>";
            html += "<img src='../assets/img/trash.png' style='width:32px'/>";
            html += "</a></td>";
            html += "</tr>";
        }
    }else{
        html = "<tr><td colspan='7' style='text-align:center;'>No se encontraron resultados.</td></tr>";
    }
    $("#tListadoBarriosDeCamion").html(html);
}

function deleteLogisticaFromCamion(idLogistica){
    var nombre = $("#tdLogistcaName"+idLogistica).html();
    $("#idLogisticaParaEliminar").val(idLogistica);
    $("#sDeleteLogisticaFromCamion").html(nombre);
    $("#deleteLogisticaFromCamionModal").modal("show");
}

function confirmDeleteLogisticaFromCamion(){
    var idLogistica = $("#idLogisticaParaEliminar").val();
    
    var deleteOK = false;
    let data = {
        'idLogistica' : idLogistica
    };
    $.ajax({
        url: ajaxURL + 'logistica/deleteLogisticaFromCamion',
        data: data,
        method: 'post',
        async: false
    }).done(function(result) {
        deleteOK = result.deleteOK;
        if(deleteOK){
            mostrarLoader();
            setTimeout(function(){
                var idLogisticaDiaEntregaCamion = $("#idLogisticaDiaEntregaCamion").val();
                getDetailsByCamion(idLogisticaDiaEntregaCamion);    
                var idDiaEntrega = $("#idDiaEntregaSeleccionado").val();
                var cCamiones = getLogisticaCamionesByDiaEntrega(idDiaEntrega);
                drawCamionesList(cCamiones);    
                getRegistrosLogistica(idDiaEntrega);
                initCheckboxes();
                $("#deleteLogisticaFromCamionModal").modal("hide");
                $("#idLogisticaParaEliminar").val(-1);
                ocultarLoader();
            },400);
        }
    });
}

function asociarACamion(idLogistica){
    mostrarLoader();
    setTimeout(function(){
        $("#idLogisticaParaAsociarACamion").val(idLogistica);
        var idDiaEntrega = $("#idDiaEntregaSeleccionado").val();
        var cCamiones = getLogisticaCamionesByDiaEntrega(idDiaEntrega);
        drawCamionesDisponiblesList(cCamiones);
        var nombrePuntoOBarrio = $("label[id='labelCheckLogistica"+idLogistica+"']").html()
        $("#labelPuntoRetiroOBarrioAAsociar").html(nombrePuntoOBarrio);
        $("#listadoSeleccionCamionesDisponiblesModal").modal("show");
        ocultarLoader();
    },300);
}

function drawCamionesDisponiblesList(cCamiones){
    var html = "";
    var totalBolsonesCamion = 0;
    for(var i=0;i<cCamiones.length;i++){
        totalBolsonesCamion = parseInt(cCamiones[i].cantBolsonesFamiliares) + parseInt(cCamiones[i].cantBolsonesIndividuales);
        html += "<tr style='border-bottom:1px dotted #000000;line-height: 30px;'>";
        html += "<td style='text-align:center; vertical-align: top;padding-top: 5px;'><input class='form-check-input' type='radio' name='radioCamionesDisponibles' id='radioCamionDisponible"+cCamiones[i].idLogisticaCamion+"' value='"+cCamiones[i].idLogisticaCamion+"'></td>";
        html += "<td id='tdNombreCamionLogistica"+cCamiones[i].idLogisticaCamion+"'>"+cCamiones[i].nombreCamion+"</td>";
        html += "<td style='text-align:center;background-color:#cccccc'>"+totalBolsonesCamion+"</td>";
        html += "</tr>";
    }
    html += "</ul>";
    $("#tListadoSeleccionCamionesDisponibles").html(html);
}

function setCamionToLogistica(idLogistica, idCamion){
    var camionAsociado = false;
    let data = {
        'idLogistica' : idLogistica,
        'idCamion': idCamion
    };
    $.ajax({
        url: ajaxURL + 'logistica/setCamionToLogistica',
        method: 'post',
        data: data,
        async: false
    }).done(function(result) {
        if(result.status == 'ok') {
            camionAsociado = result.camionAsociadoOK;
        }
    });
    return  camionAsociado;
}

function openPrintSelectedPreferences(){
    //ID TIPO LOGISTICA ES SI ES PUNTO DE RETIRO O BARRIO
    if(arrayLogisticaParaImprimir.length!=0){
        $("#printPreferencesIdLogistica").val(-1);
        $("#printPreferencesTipoImpresion").prop("disabled",false);
        $("#printPreferencesModal").modal("show");
    }else{
        alert("Debe seleccionar algún Punto de Retiro o Barrio");
    }
}

function openPrintPreferences(idLogistica, idTipoLogistica){
    //HAGO ESTO PORQUE COMO AHORA ESTA UNIFICADA LA IMPRESION DE LISTADOS EN EL BOTON DE MULTIPLES, SI TOCAS LA IMPRESORA, ES COMO QUE SELECCIONAS UNICAMENTE EL QUE ESTAS TOCANDO Y LOS DEMAS DESAPARECEN.
    //PRIMERO VACIO EL ARRAY
    arrayLogisticaParaImprimir = [];
    
    //SEGUNDO DESMARCO TODOS LOS CHECKBOX DE LOS ITEMS QUE YA VENIAN SELECCIONADOS
    $(".checkLogistica").prop("checked",false);
    
    //Y DESPUES LE CARGO SOLO ESTE ID
    var oLogistica = {
        "idLogistica": parseInt(idLogistica)
    };
    idTipoLogisticaSeleccionado = idTipoLogistica;
    //arrayLogisticaParaImprimir.push(oLogistica);
    if(idTipoLogistica==1){
        $("#checkLogisticaPuntoRetiro"+idLogistica).click();
    }else{
        $("#checkLogisticaBarrio"+idLogistica).click();
    }
    //ID TIPO LOGISTICA ES SI ES PUNTO DE RETIRO O BARRIO
    $("#printPreferencesIdLogistica").val(idLogistica);
    $("#idTipoLogistica").val(idTipoLogistica);
    $("#printPreferencesModal").modal("show");
}

function printLogisticaPuntoRetiro(idLogistica){
    var tipoImpresion = $("#printPreferencesTipoImpresion").val();
    var tipoExtension = $("#printPreferencesTipoExtension").val();
    var idTipoLogistica = $("#idTipoLogistica").val();

    var dt = new Date();
    var time = dt.getHours() + dt.getMinutes() + dt.getSeconds();

    let data = {
        'idLogistica': idLogistica,
        'tipoImpresion': tipoImpresion,
        'tipoExtension': tipoExtension,
        'idTipoLogistica': idTipoLogistica
    };
    $.ajax({
        url: ajaxURL + 'logistica/printLogisticaIndividual/',
        data: data, 
        method: 'post',
        async: false
    }).done(function(result) {
        //console.log(result.fileName);
        window.open(baseURL+result.fileName+"?v="+time, "popupWindow", "width=600, height=400, scrollbars=yes");
    });
}

function printLogisticaMultipleSeleccion(){
    var tipoImpresion = $("#printPreferencesTipoImpresion").val();
    var tipoExtension = $("#printPreferencesTipoExtension").val();

    var dt = new Date();
    var time = dt.getHours() + dt.getMinutes() + dt.getSeconds();
    
    let data = {
        'arrayLogistica': arrayLogisticaParaImprimir, //variable global
        'tipoImpresion': tipoImpresion,
        'tipoExtension': tipoExtension,
        'idTipoLogistica': idTipoLogisticaSeleccionado //variable global
    };
    $.ajax({
        url: ajaxURL + 'logistica/printLogisticaMultiple/',
        data: data, 
        method: 'post',
        async: false
    }).done(function(result) {
        
        window.open(baseURL+result.fileName+"?v="+time, "popupWindow", "width=600, height=400, scrollbars=yes");
    });
}

function printLogisticaBarrio(idLogistica){
    var tipoImpresion = $("#printPreferencesTipoImpresion").val();
    var tipoExtension = $("#printPreferencesTipoExtension").val();
    var idTipoLogistica = $("#idTipoLogistica").val();

    var dt = new Date();
    var time = dt.getHours() + dt.getMinutes() + dt.getSeconds();

    let data = {
        'idLogistica': idLogistica,
        'tipoImpresion': tipoImpresion,
        'tipoExtension': tipoExtension,
        'idTipoLogistica': idTipoLogistica
    };
    $.ajax({
        url: ajaxURL + 'logistica/printLogisticaIndividual/',
        data: data, 
        method: 'post',
        async: false
    }).done(function(result) {
        //console.log(result.fileName);
        window.open(baseURL+result.fileName+"?v="+time, "popupWindow", "width=600, height=400, scrollbars=yes");
    });
}

function initCheckboxesCamionesToPrint() {
    $(".checkCamionToPrint").change(function(){
        var idCamionToPrint = $(this).val();
        var oCamion = {
            "idCamion": parseInt(idCamionToPrint)
        };
        if ($(this).prop("checked")) {
            arrayCamionesToPrint.push(oCamion);
        } else {
            //HAY QUE BUSCARLO PARA SACARLO DEL ARRAY
            arrayCamionesToPrint.splice(arrayCamionesToPrint.findIndex(oCamion => oCamion.idCamion == idCamionToPrint), 1);
        }
});
}

function initCheckboxes(){
    $(".checkLogistica").change(function(){
        var idTipoLogistica = $(this).attr("data-tipoLogistica");
        var idLogistica = $(this).val();
        if(arrayLogisticaParaImprimir.length==0){
            idTipoLogisticaSeleccionado = idTipoLogistica;
        }
        if(idTipoLogisticaSeleccionado == idTipoLogistica){
            if($(this).prop("checked")){
                var oLogistica = {
                    "idLogistica": parseInt(idLogistica)
                };

                arrayLogisticaParaImprimir.push(oLogistica);
            }else{
                //HAY QUE BUSCARLO PARA SACARLO DEL ARRAY
                arrayLogisticaParaImprimir.splice(arrayLogisticaParaImprimir.findIndex(oLogistica => oLogistica.idLogistica == idLogistica), 1);
            }
        }else{
            alert("No podes mezclar tipos");
            $(this).prop("checked",false);
            if(arrayLogisticaParaImprimir.length==0){
                idTipoLogisticaSeleccionado = -1;
            }
        }
    });
}

function printCamion(idLogisticaCamion){
    var dt = new Date();
    var time = dt.getHours() + dt.getMinutes() + dt.getSeconds();

    let data = {
        'idLogisticaCamion': idLogisticaCamion,
        'idDiaEntrega': $("#idDiaEntregaPedido").val()
    };
    $.ajax({
        url: ajaxURL + 'logistica/printCamionIndividual/',
        data: data, 
        method: 'post',
        async: false
    }).done(function(result) {
        window.open(baseURL+result.fileName+"?v="+time, "popupWindow", "width=600, height=400, scrollbars=yes");
    });

}

function getResumenPedidos(){
    var dt = new Date();
    var time = dt.getHours() + dt.getMinutes() + dt.getSeconds();

    let data = {
        'idDiaEntrega': $("#idDiaEntregaPedido").val()
    };
    $.ajax({
        url: ajaxURL + 'logistica/printResumenPedido/',
        data: data, 
        method: 'post',
        async: false
    }).done(function(result) {
        window.open(baseURL+result.fileName+"?v="+time, "popupWindow", "width=600, height=400, scrollbars=yes");
    });
    
}

function printAllCamiones(){
    var dt = new Date();
    var time = dt.getHours() + dt.getMinutes() + dt.getSeconds();
    let data = {
        'idDiaEntrega': $("#idDiaEntregaPedido").val()
    };
    $.ajax({
        url: ajaxURL + 'logistica/printAllCamiones/',
        data: data, 
        method: 'post',
        async: false
    }).done(function(result) {
        window.open(baseURL+result.fileName+"?v="+time, "popupWindow", "width=600, height=400, scrollbars=yes");
    });

}

function printAllCamionesConDetalles(){
    var dt = new Date();
    var time = dt.getHours() + dt.getMinutes() + dt.getSeconds();

    let data = {
        'idDiaEntrega': $("#idDiaEntregaPedido").val()
    };
    $.ajax({
        url: ajaxURL + 'logistica/printAllCamionesConDetalles/',
        data: data, 
        method: 'post',
        async: false
    }).done(function(result) {
        window.open(baseURL+result.fileName+"?v="+time, "popupWindow", "width=600, height=400, scrollbars=yes");
    });

}

function openDeleteCamion(idLogisticaCamion){
    $("#idLogisticaCamionDelete").val(idLogisticaCamion);
    var oCamion = getCamionByIdCamion(idLogisticaCamion);
    if(oCamion!=null && oCamion.camion!=null){
        $("#sDeleteLogisticaCamion").html(oCamion.camion);
    }
    $("#listadoCamionesModal").modal("hide");
    $("#deleteLogisticaCamionModal").modal("show");
}

function deleteLogisticaCamion(idLogisticaCamion){
    let data = {
        'idLogisticaCamion': idLogisticaCamion
    };
    $.ajax({
        url: ajaxURL + 'logistica/deleteCamionDisponibilizado/',
        data: data, 
        method: 'post',
        async: false
    }).done(function(result) {
        $("#deleteLogisticaCamionModal").modal("hide");
        var idDiaEntrega = $("#idDiaEntregaSeleccionado").val();
        getRegistrosLogistica(idDiaEntrega);
        //INICIALIZO EL LISTENER DEL CHECKBOX DE LAS CAJAS
        initCheckboxes();
        openListCamiones();       
    });
}

function openCloseRegistroLogistica(){
    var diaEntraga = $("#idDiaEntregaPedido :selected").text();
    $("#sCloseRegistroLogistica").html(diaEntraga);
    $("#closeRegistroLogisticaModal").modal("show");
}

function cerrarLogistica(idDiaEntrega){
    let data = {
        'idDiaEntrega': idDiaEntrega
    };
    $.ajax({
        url: ajaxURL + 'logistica/closeRegistroLogistica/',
        data: data, 
        method: 'post',
        async: false
    }).done(function(result) {
        $("#deleteLogisticaCamionModal").modal("hide");
        var idDiaEntrega = $("#idDiaEntregaSeleccionado").val();
        getRegistrosLogistica(idDiaEntrega);
        initCheckboxes();
    });

}

function printCamionesSeleccionados(){
    var dt = new Date();
    var time = dt.getHours() + dt.getMinutes() + dt.getSeconds();
    
    let data = {
        'arrayCamiones': arrayCamionesToPrint //variable global
    };
    $.ajax({
        url: ajaxURL + 'logistica/printCamionesSeleccionados/',
        data: data, 
        method: 'post',
        async: false
    }).done(function(result) {
        
        window.open(baseURL+result.fileName+"?v="+time, "popupWindow", "width=600, height=400, scrollbars=yes");
    });
}

function printCamionesSeleccionadosInCards() {
    var dt = new Date();
    var time = dt.getHours() + dt.getMinutes() + dt.getSeconds();
    
    let data = {
        'arrayCamiones': arrayCamionesToPrint //variable global
    };
    $.ajax({
        url: ajaxURL + 'logistica/printCamionesSeleccionadosInCards/',
        data: data, 
        method: 'post',
        async: false
    }).done(function(result) {
        
        window.open(baseURL+result.fileName+"?v="+time, "popupWindow", "width=600, height=400, scrollbars=yes");
    });
}

function printSelectedInCards() {
    if(arrayLogisticaParaImprimir.length>0){
        mostrarLoader();
        setTimeout(function(){
            if(arrayLogisticaParaImprimir.length>0){
                printLogisticaMultipleCards();
            }    
        },200);
    }else{
        alert("Debe seleccionar algún Punto de Retiro o Barrio");
    }
}

function printLogisticaMultipleCards(){
    var dt = new Date();
    var time = dt.getHours() + dt.getMinutes() + dt.getSeconds();
    
    let data = {
        'arrayLogistica': arrayLogisticaParaImprimir, //variable global
        'idTipoLogistica': idTipoLogisticaSeleccionado //variable global
    };
    $.ajax({
        url: ajaxURL + 'logistica/printLogisticaMultipleInCards/',
        data: data, 
        method: 'post',
        async: false
    }).done(function(result) {
        ocultarLoader();
        window.open(baseURL+result.fileName+"?v="+time, "popupWindow", "width=600, height=400, scrollbars=yes");
    });
}