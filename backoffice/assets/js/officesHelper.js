$(document).ready(function() {
    officesHelper.init();
});

const officesHelper = {
    asignoEventos: function() {
        $('button.office-delete').click(function() {
            let officeId = $(this).attr('data-office');
            officesHelper.deleteOffice(officeId);
        });

        $('button.office-edit').click(function() {
            let officeId = $(this).attr('data-office');
            officesHelper.convertRowToForm(officeId);
        });
        
        $('body').on('click', 'button.office-cancel', function() {
            let officeId = $(this).parent().parent().attr('data-office-id');
            officesHelper.convertFormToRow(officeId);
        });

        $('body').on('click', 'button.office-save', function() {
            let officeId = $(this).parent().parent().attr('data-office-id');
            let officeName = $('tr[data-office-id="'+officeId+'"]').find('td[data-office-name]').find('input').val();
            let officeAddress = $('tr[data-office-id="'+officeId+'"]').find('td[data-office-address]').find('input').val();

            officesHelper.saveOffice(officeId, officeName, officeAddress);
        });

        $('body').on('change', "input[id*='active_']", function(e) {
            e.preventDefault();
            //let officeId = $(this).parent().parent().parent().attr('data-office-id');
            let officeId = $(this).attr('data-office-id');
            let officeStatus = $(this).is(':checked') ? 1 : 0;

            officesHelper.toggleActive(officeId, officeStatus);
        });

        $('form.newOfficeForm').submit(function(e) {
            e.preventDefault();
            let officeName = $('input[name="newOfficeForm-name"]').val();
            let officeAddress = $('input[name="newOfficeForm-address"]').val();
            officesHelper.addOffice(officeName, officeAddress);
        });
    },

    init: function() {
        this.asignoEventos();
    },

    convertRowToForm: function(officeId) {
        let officeName = $('tr[data-office-id="'+officeId+'"]').find('td[data-office-name]').attr('data-office-name');
        let officeAddress = $('tr[data-office-id="'+officeId+'"]').find('td[data-office-address]').attr('data-office-address');
        
        $('tr[data-office-id="'+officeId+'"]').find('td[data-office-name]').empty().html(`
            <input type="text" class="form-control form-control-sm" value="${officeName}">
        `);
        $('tr[data-office-id="'+officeId+'"]').find('td[data-office-address]').empty().html(`
            <input type="text" class="form-control form-control-sm" value="${officeAddress}">
        `);

        $('button.office-edit, button.office-delete').hide();
        $('tr[data-office-id="'+officeId+'"]').find('td[data-office-actions]').append(`
            <button type="button" class="btn btn-success btn-sm float-right office-save">Guardar</button>
            <button type="button" class="btn btn-sm float-right office-cancel">Cancelar</button>
        `);
    },

    convertFormToRow: function(officeId) {
        let officeName = $('tr[data-office-id="'+officeId+'"]').find('td[data-office-name]').attr('data-office-name');
        let officeAddress = $('tr[data-office-id="'+officeId+'"]').find('td[data-office-address]').attr('data-office-address');

        $('tr[data-office-id="'+officeId+'"]').find('td[data-office-name]').empty().text(officeName);
        $('tr[data-office-id="'+officeId+'"]').find('td[data-office-address]').empty().text(officeAddress); 

        $('button.office-edit, button.office-delete').show();
        $('tr[data-office-id="'+officeId+'"]').find('td[data-office-actions]').find('button.office-save,button.office-cancel').remove(); 
    },

    saveOffice: function(officeId, officeName, officeAddress) {
        let data = {
            'officeId' : officeId,
            'officeName' : officeName,
            'officeAddress' : officeAddress
        };
        $.ajax({
            url: ajaxURL + 'offices/update',
            method: 'post',
            data: data
        }).done(function(result) {
            if(result.status == 'ok') {
                $('tr[data-office-id="'+officeId+'"]').find('td[data-office-name]').attr('data-office-name', officeName);
                $('tr[data-office-id="'+officeId+'"]').find('td[data-office-address]').attr('data-office-address', officeAddress);
                officesHelper.convertFormToRow(officeId);
                return Swal.fire('¡Listo!', 'Los cambios se realizaron con éxito.', 'success');
            }
            return Swal.fire('Error', 'Es posible que la información no se haya guardado. Intenta de nuevo.', 'error');
        });
    },

    deleteOffice: function(officeId) {
        if($('tr[data-office-id]').length - 1 <= 0) {
            return Swal.fire(
                'Error',
                'No se puede eliminar la única sucursal. Crea otra primero.',
                'error'
            );
        }
        // Muestro swal para confirmar eliminar
        Swal.fire({
            title: '¿Seguro?',
            text: 'Si confirmas, se marcará la sucursal como eliminada. Esto no afectará pedidos que la hayan marcado.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: "Cancelar",
            confirmButtonText: "Eliminar sucursal"
        }).then(function(result) {
            if(result.value) {
                // Lógica para eliminación
                let officeName = $('tr[data-office-id="'+officeId+'"]').find('td[data-office-name]').attr('data-office-name');
                let officeAddress = $('tr[data-office-id="'+officeId+'"]').find('td[data-office-address]').attr('data-office-address');
                $.ajax({
                    url: ajaxURL + 'offices/delete/' + officeId,
                    method: 'get',
                }).done(function(result) {
                    if(result.status == 'ok') {
                        // Elimino la fila de la tabla
                        $('tr[data-office-id="'+ officeId +'"]').remove();
                        return Swal.fire('¡Eliminada!', 'La sucursal se eliminó con éxito.', 'success');
                    }
                    return Swal.fire('Error', 'Algo salió mal intentando eliminar la sucursal. Intenta de nuevo', 'error');
                });
            }
        });
    },
    
    toggleActive: function(officeId, officeStatus) {
        $.ajax({
            url: ajaxURL + 'offices/status/' + officeId + '/' + officeStatus,
            method: 'get',
            async: false
        }).done(function(result) {
            if(result.status == 'ok') {
                return Swal.fire('¡Listo!', 'La sucursal ahora se encuentra ' + (officeStatus == 1 ? 'activada' : 'desactivada') + '.', 'success');
            }
        });
    },

    addOffice: function(officeName, officeAddress) {
        let data = {
            'officeName' : officeName,
            'officeAddress' : officeAddress
        };
        $.ajax({
            url: ajaxURL + 'offices/add',
            data: data,
            method: 'post'
        }).done(function(result) {
            if(result.status == 'ok') {
                // Limpio el formulario y escondo el modal
                $('input[name="newOfficeForm-name"], input[name="newOfficeForm-address"]').val('');
                $('#newOfficeModal').modal('hide');
                window.location.reload(true); 
                return Swal.fire('Sucursal creada', 'Sucursal creada con éxito.', 'success');
            }
            return Swal.fire('Error al crear sucursal', 'No se pudo crear la sucursal. Intenta de nuevo.', 'error');
        });
    }
};