$(document).ready(function() {
    if($("#fullOrdersTable").length > 0) {
        $("#fullOrdersTable").DataTable({
            dom: 'Bfrtip',
            buttons: ['csv','excel','pdf','print']
        });
    }else{
        mainHelper.init();
    }

});

var mainHelper = {
    ordersTable : null,

    init: function() {
        this.asignoEventos();
        this.initOrdersTable();
        this.loadBolsonDiaFormulario();
        
        //$("#checkSoloBolsonDelDia").prop("checked",true);
        //$("#checkSoloBolsonDelDia").parent().toggleClass("btn-light off btn-primary");

        this.loadInfoPedidos();
    },

    asignoEventos: function() {
        $('#officeSelector').change(function() {
            //mainHelper.reloadOfficeOrdersTable($(this).val());
        });
        $('#stackedCheck2').change(function(){
            mainHelper.changeFormStatus($(this).is(':checked') ? 1 : 0);
        });
        $('#stackedCheck3').change(function(){
            mainHelper.changeDeliveryStatus($(this).is(':checked') ? 1 : 0);
        });
        $('.changeFromSess').click(function() {
            var newDataFrom = $('input[type="date"][name="dataFrom"]').val();
            mainHelper.updateFromValue(newDataFrom, dataTo);
        });

        $('#bDownloadExcel').click(function() {
            mostrarLoader();
            var fechaDesde = $('input[type="date"][name="dataFrom"]').val();
            var fechaHasta = $('input[type="date"][name="dataTo"]').val();
            var soloBolsonDia = $('#checkSoloBolsonDelDia').prop("checked");
            mainHelper.downloadExcelOfOrdersFromDate(fechaDesde, fechaHasta, soloBolsonDia);
        });

        $('#bConsultar').click(function() {
            mainHelper.loadInfoPedidos();
        });

        $("#bCerrarCrearNuevoDiaEntrega").on("click",function(){
            limpiarFormularioCrearNuevoDiaEntrega();
            $("#modalCrearDiaEntrega").modal("hide");
        });

        $("#bPreCrearNuevoDiaEntrega").on("click",function(e){
            crearNuevoDiaDeEntrega();
        });
    },

    initOrdersTable: function() {
        mainHelper.ordersTable = $('#officeOrdersTable').DataTable({
            dom: 'Brtip',
            buttons: ['csv','excel','pdf','print']
        });
    },

    /*reloadOfficeOrdersTable: function(officeId) {
        $.ajax({
            url: ajaxURL + 'orders/build/' + officeId,
            method: 'get'
        }).done(function(res) {
            mainHelper.ordersTable.destroy();
            $('#officeOrdersTable tbody').empty();
            mainHelper.ordersTable = $('#officeOrdersTable').DataTable({
                dom: 'Brtip',
                buttons: ['csv','excel','pdf','print'],
                //columns: res.columns,
                data: res.rows
            }).draw();
        });
    },*/

    changeFormStatus: function(newStatus) {
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
    },

    changeDeliveryStatus: function(newStatus) {
        Swal.fire({
            title: 'Seguro?',
            text: "Activar/desactivar esto significa que los usuarios podrán (o no) hacer pedidos A DOMICILIO desde la web. Revisa bien antes de continuar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: ajaxURL + 'deliveryStatus/' + newStatus,
                    method: 'get'
                }).done(function() {
                    window.location.reload(true);
                });
            }else{
                window.location.reload(true);
            }
        });
    },

    updateFromValue: function(newDate) {
        $.ajax({
            url: ajaxURL + 'dataFrom',
            method: 'post',
            data: {"date": newDate}
        }).done(function(res) {
            window.location.reload(true);
        });
    },

    loadBolsonDiaFormulario: function() {
        $.ajax({
            url: ajaxURL + 'getBolsonDiaFormulario',
            method: 'get'
        }).done(function(res) {
            $("#lDiaBolsonFormulario").html(res);
        });
    },

    downloadExcelOfOrdersFromDate: function(fechaDesde,fechaHasta,soloBolsonDia) {
        var fDesde = fechaDesde;
        var fHasta = fechaHasta;
        var dt = new Date();
        var time = dt.getHours() +""+ dt.getMinutes() +""+ dt.getSeconds();
        
        $.ajax({
            url: ajaxURL + 'getOrdersFromDateToDate/'+fDesde+'/'+fHasta+'/'+soloBolsonDia+"?v="+time,
            method: 'get',
            dataType: 'JSON',
        }).done(function(res) {
            //console.log(res[0].fileName);
            //Armo la variable time y la paso como parametro para que siempre me actualice donde 

            window.location.href = baseURL+res[0].fileName;
            ocultarLoader();
        });
    },
    loadInfoPedidos: function(){
        var bBolsonDiaChecked = $("#checkSoloBolsonDelDia").prop("checked");
        if(bBolsonDiaChecked){
            $.ajax({
                url: ajaxURL + 'getOrdersInfoFromDiaBolson',
                method: 'get',
                dataType: 'JSON',
            }).done(function(res) {
                var aInfoPedidosByTipoBolson = res[0].aInfoPedidosByTipoBolson;
                var aInfoExtrasPedidosBox = res[0].aInfoExtrasPedidosBox;
                var totalPedidosPuntoDeRetiro = res[0].totalPedidosSucursal;
                var totalPedidosDomicilio = res[0].totalPedidosDomicilio;
                var totalBolsones = res[0].totalBolsones;
                var diaBolson = res[0].diaBolson;
                drawInfoPedidos(aInfoPedidosByTipoBolson,aInfoExtrasPedidosBox,totalBolsones,diaBolson,"","",totalPedidosPuntoDeRetiro,totalPedidosDomicilio); 
            });    
        }else{
            var msj = checkInfoPedidosForm();
            if(msj==""){
                var fDesde = $("#dataFrom").val();
                var fHasta = $("#dataTo").val();
                console.log("HOLA");
                $.ajax({
                    url: ajaxURL + 'getOrdersInfoFromFechaDesdeHasta/'+fDesde+'/'+fHasta,
                    method: 'get',
                    dataType: 'JSON',
                }).done(function(res) {
                    
                    var aInfoPedidosByTipoBolson = res[0].aInfoPedidosByTipoBolson;
                    var aInfoExtrasPedidosBox = res[0].aInfoExtrasPedidosBox;
                    var totalPedidosPuntoDeRetiro = res[0].totalPedidosSucursal;
                    var totalPedidosDomicilio = res[0].totalPedidosDomicilio;    
                    var totalBolsones = res[0].totalBolsones;
                    drawInfoPedidos(aInfoPedidosByTipoBolson,aInfoExtrasPedidosBox,totalBolsones,"",fDesde,fHasta,totalPedidosPuntoDeRetiro,totalPedidosDomicilio); 
                }).fail(function (jqXHR, textStatus) {
                    console.log("Response",jqXHR);
                });
            }else{
                //alert(msj);
            }
        }
    }

};

function checkInfoPedidosForm(){
    var msj = "";
    if($("#dataFrom").val()==null || $("#dataFrom").val()==""){
        msj += "Completar FECHA DESDE.\n";
    }
    if($("#dataTo").val()==null || $("#dataTo").val()==""){
        msj += "Completar FECHA HASTA.\n";
    }
    return msj;
}

function drawInfoPedidos(aInfoPedidosByTipoBolson,aInfoExtrasPedidosBox,totalBolsones,diaBolson,fechaDesde,fechaHasta,totalPedidosPuntoDeRetiro,totalPedidosDomicilio){
    var htmlPedidos = "";
    var totalPedidos = parseInt(totalPedidosPuntoDeRetiro) + parseInt(totalPedidosDomicilio);
    htmlPedidos += '<div class="row">';
    htmlPedidos += '<div class="col-sm-1">';
    htmlPedidos += '</div>';
    htmlPedidos += '<div class="col-sm-4">';
    htmlPedidos += '</div>';
    htmlPedidos += '<div class="col-sm-2 infoPedidosTableInfo borderLeft">';
    htmlPedidos += totalPedidosPuntoDeRetiro;
    htmlPedidos += '</div>';
    htmlPedidos += '<div class="col-sm-2 infoPedidosTableInfo">';
    htmlPedidos += totalPedidosDomicilio;
    htmlPedidos += '</div>';
    htmlPedidos += '<div class="col-sm-2 infoPedidosTableInfo borderRight">';
    htmlPedidos += totalPedidos;
    htmlPedidos += '</div>';
    htmlPedidos += '<div class="col-sm-1">';
    htmlPedidos += '</div>';

    $("#infoPedidosBox").html(htmlPedidos);   

    var htmlBolsonesAndExtras = "";
    for(var i=0;i<aInfoPedidosByTipoBolson.length;i++){
        htmlBolsonesAndExtras += '<div class="row">';
        htmlBolsonesAndExtras += '<div class="col-sm-1">';
        htmlBolsonesAndExtras += '</div>';
        htmlBolsonesAndExtras += '<div class="col-sm-4 infoPedidosTableTitle">';
        htmlBolsonesAndExtras += aInfoPedidosByTipoBolson[i]['tipoBolson'];
        htmlBolsonesAndExtras += '</div>';
        htmlBolsonesAndExtras += '<div class="col-sm-2 infoPedidosTableInfo">';
        htmlBolsonesAndExtras += aInfoPedidosByTipoBolson[i]['totalSucursal'];
        htmlBolsonesAndExtras += '</div>';
        htmlBolsonesAndExtras += '<div class="col-sm-2 infoPedidosTableInfo">';
        htmlBolsonesAndExtras += aInfoPedidosByTipoBolson[i]['totalDomicilio'];
        htmlBolsonesAndExtras += '</div>';
        htmlBolsonesAndExtras += '<div class="col-sm-2 infoPedidosTableInfo borderRight">';
        htmlBolsonesAndExtras += aInfoPedidosByTipoBolson[i]['subtotalBolsones'];
        htmlBolsonesAndExtras += '</div>';
        htmlBolsonesAndExtras += '<div class="col-sm-1"></div>';
        htmlBolsonesAndExtras += '</div>';
    }
/*    htmlBolsonesAndExtras += '<div class="row">';
    htmlBolsonesAndExtras += '<div class="col-sm-1">';
    htmlBolsonesAndExtras += '</div>';
    htmlBolsonesAndExtras += '<div class="col-sm-4 infoPedidosTableTitle">';
    htmlBolsonesAndExtras += 'TOTALES';
    htmlBolsonesAndExtras += '</div>';
    htmlBolsonesAndExtras += '<div class="col-sm-2 infoPedidosTableInfo">';
    htmlBolsonesAndExtras += '</div>';
    htmlBolsonesAndExtras += '<div class="col-sm-2 infoPedidosTableInfo">';
    htmlBolsonesAndExtras += '</div>';
    htmlBolsonesAndExtras += '<div class="col-sm-2 infoPedidosTableInfo borderRight">';
    htmlBolsonesAndExtras += '<b>'+totalBolsones+'</b>';    
    htmlBolsonesAndExtras += '</div>';
    htmlBolsonesAndExtras += '<div class="col-sm-1"></div>';
    htmlBolsonesAndExtras += '</div>';
*/
    for(var i=0;i<aInfoExtrasPedidosBox.length;i++){
        htmlBolsonesAndExtras += '<div class="row">';
        htmlBolsonesAndExtras += '<div class="col-sm-1">';
        htmlBolsonesAndExtras += '</div>';
        htmlBolsonesAndExtras += '<div class="col-sm-4 infoPedidosTableTitle">';
        htmlBolsonesAndExtras += aInfoExtrasPedidosBox[i]['extraName'];
        htmlBolsonesAndExtras += '</div>';
        htmlBolsonesAndExtras += '<div class="col-sm-2 infoPedidosTableInfo">';
        htmlBolsonesAndExtras += aInfoExtrasPedidosBox[i]['totalSucursal'];
        htmlBolsonesAndExtras += '</div>';
        htmlBolsonesAndExtras += '<div class="col-sm-2 infoPedidosTableInfo">';
        htmlBolsonesAndExtras += aInfoExtrasPedidosBox[i]['totalDomicilio'];
        htmlBolsonesAndExtras += '</div>';
        htmlBolsonesAndExtras += '<div class="col-sm-2 infoPedidosTableInfo borderRight">';
        htmlBolsonesAndExtras += '<b>'+aInfoExtrasPedidosBox[i]['subtotalExtra']+'</b>';
        htmlBolsonesAndExtras += '</div>';
        htmlBolsonesAndExtras += '<div class="col-sm-1"></div>';
        htmlBolsonesAndExtras += '</div>';
    }   

    if(diaBolson!=""){
        $("#lFiltradoPor").html("Bolson del "+diaBolson.descripcion);
    }else{
        $("#lFiltradoPor").html("Fechas: "+fechaDesde+" / "+fechaHasta);
    }
    $("#infoBolsonesBox").html(htmlBolsonesAndExtras);   
}