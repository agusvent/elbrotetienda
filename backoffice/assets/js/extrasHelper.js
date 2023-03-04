$(document).ready(function() {
    extrasHelper.init();
});

const extrasHelper = {
    asignoEventos: function() {
        $("input.numeric").numeric();

        $('button.extra-delete').click(function() {
            let extraId = $(this).attr('data-extra');
            extrasHelper.deleteExtra(extraId);
        });

        $('button.extra-edit').click(function() {
            let extraId = $(this).attr('data-extra');
            extrasHelper.convertRowToForm(extraId);
        });
        
        $('body').on('click', 'button.extra-cancel', function() {
            let extraId = $(this).parent().parent().attr('data-extra-id');
            extrasHelper.convertFormToRow(extraId);
        });

        $('body').on('change', "input[id*='active_']", function() {
            mostrarLoader();
            let extraId = $(this).attr('data-extra-id');
            let extraStatus = $(this).is(':checked') ? 1 : 0;

            extrasHelper.toggleActive(extraId, extraStatus);
        });

        $('body').on('change', "input[id*='visible_sucursal_']", function() {
            mostrarLoader();
            let extraId = $(this).attr('data-extra-id');
            let extraStatus = $(this).is(':checked') ? 1 : 0;

            extrasHelper.toggleVisibleSucursal(extraId, extraStatus);
        });

        $('body').on('change', "input[id*='visible_domicilio_']", function() {
            mostrarLoader();
            let extraId = $(this).attr('data-extra-id');
            let extraStatus = $(this).is(':checked') ? 1 : 0;

            extrasHelper.toggleVisibleDomicilio(extraId, extraStatus);
        });

        $('body').on('change', "input[id*='stock_ilimitado_']", function() {
            mostrarLoader();
            let extraId = $(this).attr('data-extra-id');
            let extraStockIlimitadoStatus = $(this).is(':checked') ? 1 : 0;

            extrasHelper.toggleStockIlimitado(extraId, extraStockIlimitadoStatus);
        });

        $('form.editExtraImageForm').submit(function(e) {
            e.preventDefault();
            var idExtra = $("#idEditExtra").val();
            var file_data = $('#editExtraImageForm-image').prop('files')[0];   
            var fileExtension = $('#editExtraImageForm-image').val().substr(($('#editExtraImageForm-image').val().lastIndexOf('.') + 1));
            var form_data = new FormData();                  
            form_data.append('file', file_data);        
            form_data.append('idExtra', idExtra);
            form_data.append('fileExtension', fileExtension);
            $.ajax({
                url: ajaxURL + 'extras/uploadExtraImage', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(res){
                    extrasHelper.cleanEditExtraImageForm();
                    window.location.reload(true); 
                    return Swal.fire('Producto Extra', 'Imagen editada con éxito.', 'success');
                }
            });                
        });
        $('form.newExtraForm').submit(function(e) {
            e.preventDefault();
            let extraName = $('input[name="newExtraForm-name"]').val();
            let extraNombreCorto = $('input[name="newExtraForm-nombreCorto"]').val();
            let extraPrice = $('input[name="newExtraForm-price"]').val();
            extrasHelper.addExtra(extraName, extraNombreCorto, extraPrice);
            var idExtra = $("#idNuevoExtra").val();
            var file_data = $('#newExtraForm-image').prop('files')[0];   
            var fileExtension = $('#newExtraForm-image').val().substr(($('#newExtraForm-image').val().lastIndexOf('.') + 1));
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('idExtra', idExtra);
            form_data.append('fileExtension', fileExtension);
            $.ajax({
                url: ajaxURL + 'extras/uploadExtraImage', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data, 
                type: 'post',
                success: function(res){
                    //console.log("HOLA",res);
                    extrasHelper.cleanAddExtraForm();
                    window.location.reload(true); 
                }
            });            
        });
        $("#bEditarExtra").on("click",function(e){
            e.preventDefault();
            editExtra();
        });
        $("#bDeleteProducto").on("click",function(e){
            e.preventDefault();
            deleteProducto();
        });
    },
    init: function() {
        this.asignoEventos();
    },

    convertRowToForm: function(extraId) {
        let extraName = $('tr[data-extra-id="'+extraId+'"]').find('td[data-extra-name]').attr('data-extra-name');
        let extraPrice = $('tr[data-extra-id="'+extraId+'"]').find('td[data-extra-price]').attr('data-extra-price');
        
        $('tr[data-extra-id="'+extraId+'"]').find('td[data-extra-name]').empty().html(`
            <input type="text" class="form-control form-control-sm" value="${extraName}">
        `);
        $('tr[data-extra-id="'+extraId+'"]').find('td[data-extra-price]').empty().html(`
            <input type="text" class="form-control form-control-sm" size="5" value="${extraPrice}">
        `);
        $('button.extra-edit, button.extra-delete').hide();
        $('tr[data-extra-id="'+extraId+'"]').find('td[data-extra-actions]').append(`
            <button type="button" class="btn btn-success btn-sm float-right extra-save">Guardar</button>
            <button type="button" class="btn btn-sm float-right extra-cancel">Cancelar</button>
        `);


        var stockIlimitado = false;
        if( $("#stock_ilimitado_"+extraId).prop("checked") ){
            stockIlimitado = true;
        }
        if(!stockIlimitado){
            $("#stock_disponible_"+extraId).prop("disabled",false);
        }
        $("#tdEditImage"+extraId).show();
    },

    convertFormToRow: function(extraId) {
        let extraName = $('tr[data-extra-id="'+extraId+'"]').find('td[data-extra-name]').attr('data-extra-name');
        let extraPrice = $('tr[data-extra-id="'+extraId+'"]').find('td[data-extra-price]').attr('data-extra-price');

        $('tr[data-extra-id="'+extraId+'"]').find('td[data-extra-name]').empty().text(extraName);
        $('tr[data-extra-id="'+extraId+'"]').find('td[data-extra-price]').empty().text(extraPrice); 

        $('button.extra-edit, button.extra-delete').show();
        $('tr[data-extra-id="'+extraId+'"]').find('td[data-extra-actions]').find('button.extra-save,button.extra-cancel').remove(); 
        $("#stock_disponible_"+extraId).prop("disabled",true);
        $("#tdEditImage"+extraId).hide();
    },

    saveExtra: function(extraId, extraName, extraNombreCorto, extraPrice,extraStockDisponible, extraOrden, extraOrdenListados) {
        var extraEditedOK = false;
        let data = {
            'extraId' : extraId,
            'extraName' : extraName,
            'extraNombreCorto' : extraNombreCorto,
            'extraPrice' : extraPrice,
            'extraStockDisponible':extraStockDisponible,
            'extraOrden' : extraOrden,
            'extraOrdenListados': extraOrdenListados
        };
        $.ajax({
            url: ajaxURL + 'extras/update',
            method: 'post',
            data: data,
            async: false
        }).done(function(result) {
            if(result.status == 'ok') {
                extraEditedOK = true;
            }
        });
        return  extraEditedOK;
    },

    deleteExtra: function(extraId) {
        if($('tr[data-extra-id]').length - 1 <= 0) {
            return Swal.fire(
                'Error',
                'No se puede eliminar el único producto extra. Crea otro primero.',
                'error'
            );
        }
        // Muestro swal para confirmar eliminar
        Swal.fire({
            title: '¿Seguro?',
            text: 'Si confirmas, se eliminará el producto extra y no se podrá elegir al crear un pedido.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: "Cancelar",
            confirmButtonText: "Eliminar producto"
        }).then(function(result) {
            if(result.value) {
                // Lógica para eliminación
                let extraName = $('tr[data-extra-id="'+extraId+'"]').find('td[data-extra-name]').attr('data-extra-name');
                let extraPrice = $('tr[data-extra-id="'+extraId+'"]').find('td[data-extra-price]').attr('data-extra-price');
                $.ajax({
                    url: ajaxURL + 'extras/delete/' + extraId,
                    method: 'get',
                }).done(function(result) {
                    if(result.status == 'ok') {
                        // Elimino la fila de la tabla
                        $('tr[data-extra-id="'+ extraId +'"]').remove();
                        return Swal.fire('¡Eliminado!', 'El producto se eliminó con éxito.', 'success');
                    }
                    return Swal.fire('Error', 'Algo salió mal intentando eliminar el producto. Intenta de nuevo', 'error');
                });
            }
        });
    },
    
    toggleActive: function(extraId, extraStatus) {
        $.ajax({
            url: ajaxURL + 'extras/status/' + extraId + '/' + extraStatus,
            method: 'get'
        }).done(function(result) {
            ocultarLoader();
            if(result.status == 'ok') {
                return Swal.fire('¡Listo!', 'El producto ahora se encuentra ' + (extraStatus == 1 ? 'activado' : 'desactivado') + '.', 'success');
            }
        });
    },
    toggleVisibleSucursal: function(extraId, extraStatus) {
        $.ajax({
            url: ajaxURL + 'extras/visibleSucursal/' + extraId + '/' + extraStatus,
            method: 'get'
        }).done(function(result) {
            ocultarLoader();
            if(result.status == 'ok') {
                return Swal.fire('¡Listo!', 'El producto ahora se encuentra ' + (extraStatus == 1 ? 'visible' : 'oculto') + ' para SUCURSAL.', 'success');
            }
        });
    },
    toggleVisibleDomicilio: function(extraId, extraStatus) {
        $.ajax({
            url: ajaxURL + 'extras/visibleDomicilio/' + extraId + '/' + extraStatus,
            method: 'get'
        }).done(function(result) {
            ocultarLoader();
            if(result.status == 'ok') {
                return Swal.fire('¡Listo!', 'El producto ahora se encuentra ' + (extraStatus == 1 ? 'visible' : 'oculto') + ' para DOMICILIO.', 'success');
            }
        });
    },
    toggleStockIlimitado: function(extraId,extraStockIlimitadoStatus){
        $.ajax({
            url: ajaxURL + 'extras/stockIlimitado/' + extraId + '/' + extraStockIlimitadoStatus,
            method: 'get'
        }).done(function(result) {
            ocultarLoader();
            if(result.status == 'ok') {
                $.ajax({
                    url: ajaxURL + 'extras/stockIlimitado/' + extraId + '/' + extraStockIlimitadoStatus,
                    method: 'get'
                }).done(function(result) {
                    if(result.status == 'ok') {
                        $("#stock_disponible_"+extraId).val(0);
                        
                        return Swal.fire('¡Listo!', 'Cambios realizados con éxito.', 'success');
                    }else{
                        return Swal.fire('Error!', 'Ocurrio un error.', 'error');
                    }
                });
            }else{
                return Swal.fire('Error!', 'Ocurrio un error.', 'error');
            }
        });
    },
    cleanAddExtraForm: function(){
        $('input[name="newExtraForm-name"], input[name="newExtraForm-price"], input[name="newExtraForm-image"]').val('');
        $('#newExtraModal').modal('hide');
    },
    cleanEditExtraImageForm: function(){
        $("#idEditExtra").val(0);
        $("#editExtraImageForm-image").val("");
        $('#editExtraImageModal').modal('hide');
    },
    addExtra: function(extraName, extraNombreCorto,extraPrice) {
        let data = {
            'extraName' : extraName,
            'extraNombreCorto': extraNombreCorto,
            'extraPrice' : extraPrice
        };
        $.ajax({
            url: ajaxURL + 'extras/add',
            data: data,
            method: 'post',
            async: false
        }).done(function(result) {
            $("#idNuevoExtra").val(result.idExtra);
            if(result.status == 'ok') {
                // Limpio el formulario y escondo el modal
                return Swal.fire('Producto creado', 'Producto creado con éxito.', 'success');
            }
            return Swal.fire('Error al crear producto', 'No se pudo crear el producto. Intenta de nuevo.', 'error');
        });
    },
    openEditExtraImage: function(idExtra){
        $('#editExtraImageModal').modal('show');
        $('#idEditExtra').val(idExtra);
    }
};

function openEditExtraImage(idExtra){
    extrasHelper.openEditExtraImage(idExtra);
}

function viewImagenExtra(idExtra){
    let extra = getExtraById(idExtra);
    //como siempre son jpg, lo puedo hacer directo así.
    //Sino, tendría que ir a buscar el nombre del archivo para ponerlo directo aca abajo
    var w = window.open("../../assets/img/extras/"+extra.imagen, "popupWindow", "width=600, height=400, scrollbars=yes");
}

function completarFormularioEdicionExtra(oExtra){
    if(oExtra.name!=null && oExtra.name!=""){
        $("#editExtraName").val(oExtra.name);
    }
    if(oExtra.nombre_corto!=null && oExtra.nombre_corto!=""){
        $("#editExtraNombreCorto").val(oExtra.nombre_corto);
    }
    if(oExtra.price!=null && oExtra.price!=""){
        $("#editExtraPrice").val(oExtra.price);   
    }
    if(oExtra.stock_disponible!=null && oExtra.stock_disponible!=""){
        $("#editExtraStockDisponible").val(oExtra.stock_disponible);   
    }
    if(oExtra.orden!=null && oExtra.orden!=""){
        $("#editExtraOrden").val(oExtra.orden);   
    }    
    if(oExtra.orden_listados!=null && oExtra.orden_listados!=""){
        $("#editExtraOrdenListados").val(oExtra.orden_listados);   
    }    
}

function openEditExtra(idExtra){
    $.ajax({
        url: ajaxURL + 'extras/getExtraById/' + idExtra,
        method: 'get',
        async: false
    }).done(function(result) {
        if(result.status == 'ok') {
            completarFormularioEdicionExtra(result.extra);
            $('#idEditExtra').val(idExtra);
        }
        ocultarLoader();
    });
    $("#modalEditarExtra").modal('show');
}

function getExtraById(idExtra) {
    let extra = null;
    mostrarLoader();
    $.ajax({
        url: ajaxURL + 'extras/getExtraById/' + idExtra,
        method: 'get',
        async: false
    }).done(function(result) {
        if(result.status == 'ok') {
            extra = result.extra;
        }
        ocultarLoader();
    });
    return extra;
}

function checkFormEditarExtra(){
    var msj = "";
    if($("#editExtraName").val()==""){
        msj += "<p>Debe ingresar un nombre para el Extra.</p>";
    }
    if($("#editExtraPrice").val()==""){
        msj += "<p>Debe ingresar un precio para el Extra.</p>";
    }
    if($("#editExtraOrden").val()==""){
        msj += "<p>Debe ingresar el # de órden para el Extra.</p>";
    }
    if($("#editExtraOrdenListados").val()==""){
        msj += "<p>Debe ingresar el # de órden para el Extra.</p>";
    }
    if($("#editExtraStockDisponible").val()<0){
        msj += "<p>La cantidad de stock no puede ser negativa.</p>";
    }
    return msj;
}

function editExtra(){
    var msj = "";
    msj = checkFormEditarExtra();
    if(msj!=""){
        return Swal.fire('Faltan Compeltar Campos!', msj, 'error');
    }else{
        $("#modalEditarExtra").modal('hide');
        mostrarLoader();
        let extraId = $('#idEditExtra').val();
        let extraName = $("#editExtraName").val();
        let extraNombreCorto = $("#editExtraNombreCorto").val();
        let extraPrice = $("#editExtraPrice").val();
        let extraStockDisponible = parseInt($("#editExtraStockDisponible").val());
        let extraOrden = $("#editExtraOrden").val();
        let extraOrdenListados = $("#editExtraOrdenListados").val();
        var extraEditedOK = false;

        extraEditedOK = extrasHelper.saveExtra(extraId, extraName, extraNombreCorto, exƒtraPrice,extraStockDisponible,extraOrden, extraOrdenListados);

        var seEditaImagen = false;
        if($('#editExtraImageForm-image').prop('files')[0] != null){
            seEditaImagen = true;
        }
        if(seEditaImagen){
            var file_data = $('#editExtraImageForm-image').prop('files')[0];   
            var fileExtension = $('#editExtraImageForm-image').val().substr(($('#editExtraImageForm-image').val().lastIndexOf('.') + 1));
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('idExtra', extraId);
            form_data.append('fileExtension', fileExtension);
            $.ajax({
                url: ajaxURL + 'extras/uploadExtraImage', // point to server-side PHP script 
                dataType: 'text', // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                async:false,
                success: function(res){
                    window.location.reload(true); 
                    return Swal.fire('Edicion de Producto Extra', 'Producto editado con éxito.', 'success');
                }
            });            
        }else{
            window.location.reload(true); 
            return Swal.fire('Edicion de Producto Extra', 'Producto editado con éxito.', 'success');
        }
    }
}

function viewInTienda(idProducto){
    window.open("https://elbrotetienda.com/#tienda-"+idProducto);    
}

function copyLink(idProducto){
    var url = `https://elbrotetienda.com/#tienda-${idProducto}`;
    const elem = document.createElement('textarea');
    elem.value = url;
    document.body.appendChild(elem);
    elem.select();
    document.execCommand('copy');
    document.body.removeChild(elem);
}

function preDeleteProduct(idProducto, producto) {
    $('#sDeleteProducto').html(producto);
    $('#removeIdProducto').val(idProducto);
    $('#deleteProductoModal').modal('show');
}

function deleteProducto() {
    let data = {
        'extraId' : $("#removeIdProducto").val(),
    };
    $.ajax({
        url: ajaxURL + 'extras/delete',
        method: 'post',
        data: data,
        async: false
    }).done(function(result) {
        if(result.status == 'ok') {
            window.location.reload(true); 
        }
    });    
}