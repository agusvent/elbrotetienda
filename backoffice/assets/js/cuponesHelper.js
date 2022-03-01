$(document).ready(function() {
    loadCuponesTable();
    $("input.numeric").numeric();
    $("#bGuardarCupon").on("click",function(e) {
        e.preventDefault();
        if(checkCuponForm()) {
            var idCupon = $("#idCupon").val(); //si queda 0, es un nuevo cupon. >0 es edicion de cupon.
            guardarCupon(idCupon);
        }
    });
    $("#codigoCupon").on("focus",function() {
        $("#errorCodigoCupon").html("");
    });
    $("#tipoDescuentoCupon").on("focus",function() {
        $("#errorTipoDescuentoCupon").html("");
    });
    $("#descuentoCupon").on("focus",function() {
        $("#errorDescuentoCupon").html("");
    });

    $('#cuponModal').on('hidden.bs.modal', function (e) {
        $("#idCupon").val(0);
        $("#codigoCupon").val("");
        $("#tipoDescuentoCupon").val(-1);
        $("#descuentoCupon").val("");    
    });

    $('body').on('change', "input[id*='moduloCuponesHabilitado']", function(e) {
        e.preventDefault();
        let moduloCuponesStatus = $(this).is(':checked') ? 1 : 0;
        setModuloCuponesStatus(moduloCuponesStatus);
    });

    $('body').on('change', "input[id*='cupon_active_']", function(e) {
        e.preventDefault();
        let idCupon = $(this).attr('data-cupon-id');
        let cuponHabilitado = $(this).is(':checked') ? 1 : 0;
        setCuponStatus(idCupon, cuponHabilitado);
    });
    
});

function checkCuponForm() {
    var formOK = true;
    if($("#codigoCupon").val()=="") {
        $("#errorCodigoCupon").html("Debe ingresar un código para el cupón.");
        formOK = false;
    }
    if($("#tipoDescuentoCupon").val()==-1) {
        $("#errorTipoDescuentoCupon").html("Debe seleccionar un tipo de descuento.");
        formOK = false;
    }
    if($("#descuentoCupon").val()<=0) {
        $("#errorDescuentoCupon").html("Debe cargar el descuento.");
        formOK = false;
    }
    return formOK;
}

function guardarCupon(idCupon) {
    var codigoCupon = $("#codigoCupon").val();
    var idTipoDescuento = $("#tipoDescuentoCupon").val();
    var descuento = $("#descuentoCupon").val();
    let data = {
        'idCupon': idCupon,
        'codigoCupon': codigoCupon,
        'idTipoDescuento': idTipoDescuento,
        'descuento': descuento
    };
    if(idCupon==0) {
        $.ajax({
            url: ajaxURL + 'cupones/crearCupon',
            data: data,
            method: 'post',
            async: false
        }).done(function(result) {
            //$("#idNuevoCamionPreConfigurado").val(result.idCamionPreConfigurado);
            if(result.status == 'ok') {
                ocultarLoader();
                loadCuponesTable();
                hideCuponModal();
                return Swal.fire('Éxito', 'Se ha creado el Cupón '+codigoCupon+'.', 'success');
            }
            return Swal.fire('Error', 'No se pudo crear el cupón. Intenta de nuevo.', 'error');
        });
    }else{
        $.ajax({
            url: ajaxURL + 'cupones/editarCupon',
            data: data,
            method: 'post',
            async: false
        }).done(function(result) {
            //$("#idNuevoCamionPreConfigurado").val(result.idCamionPreConfigurado);
            if(result.status == 'ok') {
                ocultarLoader();
                loadCuponesTable();
                hideCuponModal();
                return Swal.fire('Éxito', 'Se ha editado el Cupón '+codigoCupon+'.', 'success');
            }
            return Swal.fire('Error', 'No se pudo editar el cupón. Intenta de nuevo.', 'error');
        });
    }
}

function getCupones() {
    var cCupones;
    $.ajax({
        url: ajaxURL + 'cupones/getCupones',
        method: 'get',
        async: false
    }).done(function(result) {
        if(result.status == 'ok') {
            if(result.cCupones!=null){
                cCupones = result.cCupones;
            }
        }
    });
    return cCupones;
}

function loadCuponesTable() {
    var cCupones = getCupones();
    var html = "";
    if(cCupones.length>0) {
        for(var i=0;i<cCupones.length;i++) {
            html +=" <div class='cupones-caja'>";
            html +=" <div class='cupones-caja-titulo'>"+cCupones[i].codigo+"</div>";
            html +=" <div style='padding:5px;'>";
            html +=" <div class='cupones-caja-info'> ";
            if(cCupones[i].id_tipo_descuento == 1) {
                html +=" Descuento: <b>$"+parseInt(cCupones[i].descuento)+"</b> ";
            } else {
                html +=" Descuento: <b>"+parseInt(cCupones[i].descuento)+"%</b> ";
            }
            html +=" <span style='float:right'>";
            html +=" Activo: &nbsp;";
            if(cCupones[i].activo == 1) {
                html +=" <input data-type='checkbox-active' data-cupon-id='"+cCupones[i].id_cupon+"' id='cupon_active_"+cCupones[i].id_cupon+"' type='checkbox' checked data-toggle='toggle' data-onstyle='success' data-size='xs'>";
            } else {
                html +=" <input data-cupon-id='"+cCupones[i].id_cupon+"' id='cupon_active_"+cCupones[i].id_cupon+"' type='checkbox' data-toggle='toggle' data-onstyle='success' data-size='xs'>";
            }
            html +=" </span>";
            html +=" </div>   ";   
            html +=" <div class='cupones-caja-info'> ";
            html +=" <a href='javascript:preEditarCupon("+cCupones[i].id_cupon+");'>Editar</a> &nbsp;";
            html +=" <span style='float:right'><a href='javascript:eliminarCupon("+cCupones[i].id_cupon+");'>Eliminar</a></span>";
            html +=" </div>";
            html +=" </div>";
            html +=" </div>";
        }
    }else{
        html = "<p style='text-align:center'>No se encontraron cupones.</p>"
    }
    $("#cuponesList").html(html);
    //init de checkboxes active
    $('[data-type="checkbox-active"]').bootstrapToggle();
}

function hideCuponModal() {
    $("#cuponModal").modal("hide");
}

function preEditarCupon(idCupon) {
    var cupon = getCuponById(idCupon);
    setCuponForm(cupon);
    $("#cuponModal").modal("show");
}

function getCuponById(idCupon) {
    var cupon;
    $.ajax({
        url: ajaxURL + 'cupones/getCuponById/'+idCupon,
        method: 'get',
        async: false
    }).done(function(result) {
        if(result.status == 'ok') {
            cupon = result.cupon;
        }
    });
    return cupon;
}

function setCuponForm(cupon) {
    $("#idCupon").val(cupon.id_cupon);
    $("#codigoCupon").val(cupon.codigo);
    $("#tipoDescuentoCupon").val(cupon.id_tipo_descuento);
    $("#descuentoCupon").val(parseInt(cupon.descuento));
}

function setModuloCuponesStatus(moduloCuponesStatus) {
    let data = {
        'moduloCuponesStatus' : moduloCuponesStatus
    };
    $.ajax({
        url: ajaxURL + 'cupones/setModuloCuponesStatus',
        data: data,
        method: 'post',
        async: true
    });
}

function eliminarCupon(idCupon){
    let data = {
        'idCupon': idCupon
    };
    $.ajax({
        url: ajaxURL + 'cupones/eliminarCupon',
        data: data,
        method: 'post',
        async: false
    }).done(function(result) {
        ocultarLoader();
        hideCuponModal();
        if(result.status == 'ok') {
            loadCuponesTable();
        }else{
            Swal.fire('Error', 'No se pudo eliminar el cupón. Intenta de nuevo.', 'error');
        }
    });
}

function setCuponStatus(idCupon, cuponHabilitado) {
    let data = {
        'idCupon': idCupon,
        'cuponHabilitado': cuponHabilitado
    };
    $.ajax({
        url: ajaxURL + 'cupones/status',
        data: data,
        method: 'post',
        async: false
    }).done(function(result) {
        ocultarLoader();
        if(result.status != 'ok') {
            Swal.fire('Error', 'No se pudo activar/inactivar el cupón. Intenta de nuevo.', 'error');
        }
    });
}