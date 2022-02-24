$(document).ready(function() {
    barriosHelper.init();
});

const barriosHelper = {
    asignoEventos: function() {
        $("input.numeric").numeric();
        $('button.barrio-delete').click(function() {
            let barrioId = $(this).attr('data-barrio');
            barriosHelper.deleteBarrio(barrioId);
        });

        $('button.barrio-edit').click(function() {
            let barrioId = $(this).attr('data-barrio');
            barriosHelper.convertRowToForm(barrioId);
        });
        
        $('body').on('click', 'button.barrio-cancel', function() {
            let barrioId = $(this).parent().parent().attr('data-barrio-id');
            barriosHelper.convertFormToRow(barrioId);
        });

        $('body').on('click', 'button.barrio-save', function() {
            let barrioId = $(this).parent().parent().attr('data-barrio-id');
            let barrioName = $('tr[data-barrio-id="'+barrioId+'"]').find('td[data-barrio-name]').find('input').val();
            let costoEnvio = $('tr[data-barrio-id="'+barrioId+'"]').find('td[data-barrio-costoEnvio]').find('input').val();
            let barrioObservaciones = $('tr[data-barrio-id="'+barrioId+'"]').find('td[data-barrio-observaciones]').find('input').val();

            barriosHelper.saveBarrio(barrioId, barrioName, barrioObservaciones, costoEnvio);
        });

        $('body').on('change', "input[id*='active_']", function() {
            let barrioId = $(this).parent().parent().parent().attr('data-barrio-id');
            let barrioStatus = $(this).is(':checked') ? 1 : 0;

            barriosHelper.toggleActive(barrioId, barrioStatus);
        });

        $('form.newBarrioForm').submit(function(e) {
            e.preventDefault();
            let barrioName = $('input[name="newBarrioForm-name"]').val();
            let costoEnvio = $('input[name="newBarrioForm-costoEnvio"]').val();
            let barrioObservaciones = $('input[name="newBarrioForm-observaciones"]').val();
            if(barriosHelper.newBarrioFormOK(barrioName, costoEnvio, barrioObservaciones)) {
                barriosHelper.addBarrio(barrioName,barrioObservaciones, costoEnvio);
            } else {

            }
            
        });

        $("#newBarrioForm-name").on("click",function() {
            $("#newBarrioForm-name").removeClass("input-error");
        });
        $("#newBarrioForm-costoEnvio").on("click",function() {
            $("#newBarrioForm-costoEnvio").removeClass("input-error");
        });
        $("#newBarrioForm").on("hidden.bs.modal", function() {
            $("#newBarrioForm-name").removeClass("input-error");
            $("#newBarrioForm-costoEnvio").removeClass("input-error");
        })
    },

    init: function() {
        this.asignoEventos();
    },

    convertRowToForm: function(barrioId) {
        let barrioName = $('tr[data-barrio-id="'+barrioId+'"]').find('td[data-barrio-name]').attr('data-barrio-name');
        let costoEnvio = $('tr[data-barrio-id="'+barrioId+'"]').find('td[data-barrio-costoEnvio]').attr('data-barrio-costoEnvio');
        let barrioObservaciones = $('tr[data-barrio-id="'+barrioId+'"]').find('td[data-barrio-observaciones]').attr('data-barrio-observaciones');
        
        $('tr[data-barrio-id="'+barrioId+'"]').find('td[data-barrio-name]').empty().html(`
            <input type="text" class="form-control form-control-sm" value="${barrioName}">
        `);

        $('tr[data-barrio-id="'+barrioId+'"]').find('td[data-barrio-observaciones]').empty().html(`
            <input type="text" class="form-control form-control-sm" value="${barrioObservaciones}">
        `);
        
        $('tr[data-barrio-id="'+barrioId+'"]').find('td[data-barrio-costoEnvio]').empty().html(`
            <input type="text" class="form-control form-control-sm numeric" value="${costoEnvio}">
        `);
        
        $("input.numeric").numeric();

        $('button.barrio-edit, button.barrio-delete').hide();
        $('tr[data-barrio-id="'+barrioId+'"]').find('td[data-barrio-actions]').append(`
            <button type="button" class="btn btn-success btn-sm float-right barrio-save">Guardar</button>
            <button type="button" class="btn btn-sm float-right barrio-cancel">Cancelar</button>
        `);
    },

    convertFormToRow: function(barrioId) {
        let barrioName = $('tr[data-barrio-id="'+barrioId+'"]').find('td[data-barrio-name]').attr('data-barrio-name');
        let costoEnvio = $('tr[data-barrio-id="'+barrioId+'"]').find('td[data-barrio-costoEnvio]').attr('data-barrio-costoEnvio');
        let barrioObservaciones = $('tr[data-barrio-id="'+barrioId+'"]').find('td[data-barrio-observaciones]').attr('data-barrio-observaciones');

        $('tr[data-barrio-id="'+barrioId+'"]').find('td[data-barrio-name]').empty().text(barrioName);
        $('tr[data-barrio-id="'+barrioId+'"]').find('td[data-barrio-costoEnvio]').empty().text("$"+costoEnvio);
        $('tr[data-barrio-id="'+barrioId+'"]').find('td[data-barrio-observaciones]').empty().text(barrioObservaciones);

        $('button.barrio-edit, button.barrio-delete').show();
        $('tr[data-barrio-id="'+barrioId+'"]').find('td[data-barrio-actions]').find('button.barrio-save,button.barrio-cancel').remove(); 
    },

    saveBarrio: function(barrioId, barrioName, barrioObservaciones, costoEnvio) {
        let data = {
            'barrioId': barrioId,
            'barrioName': barrioName,
            'barrioObservaciones': barrioObservaciones,
            'costoEnvio': costoEnvio
        };
        $.ajax({
            url: ajaxURL + 'barrios/update',
            method: 'post',
            data: data
        }).done(function(result) {
            if(result.status == 'ok') {
                $('tr[data-barrio-id="'+barrioId+'"]').find('td[data-barrio-name]').attr('data-barrio-name', barrioName);
                barriosHelper.convertFormToRow(barrioId);
                window.location.reload(true); 
                return Swal.fire('¡Listo!', 'Los cambios se realizaron con éxito.', 'success');
            }
            return Swal.fire('Error', 'Es posible que la información no se haya guardado. Intenta de nuevo.', 'error');
        });
    },

    deleteBarrio: function(barrioId) {
        if($('tr[data-barrio-id]').length - 1 <= 0) {
            return Swal.fire(
                'Error',
                'No se puede eliminar el único barrio. Crea otro primero.',
                'error'
            );
        }
        // Muestro swal para confirmar eliminar
        Swal.fire({
            title: '¿Seguro?',
            text: 'Si confirmas, se marcará el barrio como eliminado. Esto no afectará pedidos que lo hayan marcado.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: "Cancelar",
            confirmButtonText: "Eliminar barrio"
        }).then(function(result) {
            if(result.value) {
                // Lógica para eliminación
                let barrioName = $('tr[data-barrio-id="'+barrioId+'"]').find('td[data-barrio-name]').attr('data-barrio-name');
                $.ajax({
                    url: ajaxURL + 'barrios/delete/' + barrioId,
                    method: 'get',
                }).done(function(result) {
                    if(result.status == 'ok') {
                        // Elimino la fila de la tabla
                        $('tr[data-barrio-id="'+ barrioId +'"]').remove();
                        return Swal.fire('¡Eliminada!', 'El barrio se eliminó con éxito.', 'success');
                    }
                    return Swal.fire('Error', 'Algo salió mal intentando eliminar el barrio. Intenta de nuevo', 'error');
                });
            }
        });
    },
    
    toggleActive: function(barrioId, barrioStatus) {
        $.ajax({
            url: ajaxURL + 'barrios/status/' + barrioId + '/' + barrioStatus,
            method: 'get'
        }).done(function(result) {
            if(result.status == 'ok') {
                return Swal.fire('¡Listo!', 'El barrio ahora se encuentra ' + (barrioStatus == 1 ? 'activado' : 'desactivado') + '.', 'success');
            }
        });
    },

    addBarrio: function(barrioName,barrioObservaciones, costoEnvio) {
        let data = {
            'barrioName': barrioName,
            'costoEnvio': costoEnvio,
            'barrioObservaciones': barrioObservaciones
        };
        $.ajax({
            url: ajaxURL + 'barrios/add',
            data: data,
            method: 'post'
        }).done(function(result) {
            if(result.status == 'ok') {
                // Limpio el formulario y escondo el modal
                $('input[name="newBarrioForm-name"]').val('');
                $('#newBarrioModal').modal('hide');
                window.location.reload(true); 
                return Swal.fire('Barrio creado', 'Barrio creado con éxito.', 'success');
            }
            return Swal.fire('Error al crear barrio', 'No se pudo crear el barrio. Intenta de nuevo.', 'error');
        });
    },

    newBarrioFormOK: function(barrioName, costoEnvio) {
        let formOK = true;
        if(barrioName==undefined || barrioName.length<3) {
            $("#newBarrioForm-name").addClass("input-error");
            formOK = false;
        }
        if(costoEnvio==undefined || costoEnvio.length<3) {
            $("#newBarrioForm-costoEnvio").addClass("input-error");
            formOK = false;
        }
        return formOK;
    }
};