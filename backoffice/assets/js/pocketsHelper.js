$(document).ready(function() {
    pocketsHelper.init();
});

const pocketsHelper = {
    asignoEventos: function() {
        $('button.pocket-delete').click(function() {
            let pocketId = $(this).attr('data-pocket');
            pocketsHelper.deletePocket(pocketId);
        });

        $('button.pocket-edit').click(function() {
            let pocketId = $(this).attr('data-pocket');
            pocketsHelper.convertRowToForm(pocketId);
        });
        
        $('body').on('click', 'button.pocket-cancel', function() {
            let pocketId = $(this).parent().parent().attr('data-pocket-id');
            pocketsHelper.convertFormToRow(pocketId);
        });

        $('body').on('click', 'button.pocket-save', function() {
            let pocketId = $(this).parent().parent().attr('data-pocket-id');
            let pocketName = $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-name]').find('input').val();
            let pocketPrice = $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-price]').find('input').val();
            let pocketDeliverPrice = $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-deliver_price]').find('input').val();

            pocketsHelper.savePocket(pocketId, pocketName, pocketPrice, pocketDeliverPrice);
        });

        $('body').on('change', "input[id*='active_']", function() {
            let pocketId = $(this).parent().parent().parent().attr('data-pocket-id');
            let pocketStatus = $(this).is(':checked') ? 1 : 0;

            pocketsHelper.toggleActive(pocketId, pocketStatus);
        });

        $('form.newPocketForm').submit(function(e) {
            e.preventDefault();
            let pocketName = $('input[name="newPocketForm-name"]').val();
            let pocketPrice = $('input[name="newPocketForm-price"]').val();
            let pocketDeliverPrice = $('input[name="newPocketForm-deliver_price"]').val();
            pocketsHelper.addPocket(pocketName, pocketPrice, pocketDeliverPrice);
        });
    },

    init: function() {
        this.asignoEventos();
    },

    convertRowToForm: function(pocketId) {
        let pocketName = $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-name]').attr('data-pocket-name');
        let pocketPrice = $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-price]').attr('data-pocket-price');
        let pocketDeliverPrice = $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-deliver_price]').attr('data-pocket-deliver_price');
        
        $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-name]').empty().html(`
            <input type="text" class="form-control form-control-sm" value="${pocketName}">
        `);
        $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-price]').empty().html(`
            <input type="text" class="form-control form-control-sm" value="${pocketPrice}">
        `);
        $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-deliver_price]').empty().html(`
            <input type="text" class="form-control form-control-sm" value="${pocketDeliverPrice}">
        `);

        $('button.pocket-edit, button.pocket-delete').hide();
        $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-actions]').append(`
            <button type="button" class="btn btn-success btn-sm float-right pocket-save">Guardar</button>
            <button type="button" class="btn btn-sm float-right pocket-cancel">Cancelar</button>
        `);
    },

    convertFormToRow: function(pocketId) {
        let pocketName = $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-name]').attr('data-pocket-name');
        let pocketPrice = $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-price]').attr('data-pocket-price');
        let pocketDeliverPrice = $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-deliver_price]').attr('data-pocket-deliver_price');

        $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-name]').empty().text(pocketName);
        $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-price]').empty().text(pocketPrice); 
        $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-deliver_price]').empty().text(pocketDeliverPrice); 

        $('button.pocket-edit, button.pocket-delete').show();
        $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-actions]').find('button.pocket-save,button.pocket-cancel').remove(); 
    },

    savePocket: function(pocketId, pocketName, pocketPrice, pocketDeliverPrice) {
        let data = {
            'pocketId' : pocketId,
            'pocketName' : pocketName,
            'pocketPrice' : pocketPrice,
            'pocketDeliverPrice' : pocketDeliverPrice
        };
        $.ajax({
            url: ajaxURL + 'pockets/update',
            method: 'post',
            data: data
        }).done(function(result) {
            if(result.status == 'ok') {
                $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-name]').attr('data-pocket-name', pocketName);
                $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-price]').attr('data-pocket-price', pocketPrice);
                $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-deliver_price]').attr('data-pocket-deliver_price', pocketDeliverPrice);
                pocketsHelper.convertFormToRow(pocketId);
                return Swal.fire('??Listo!', 'Los cambios se realizaron con ??xito.', 'success');
            }
            return Swal.fire('Error', 'Es posible que la informaci??n no se haya guardado. Intenta de nuevo.', 'error');
        });
    },

    deletePocket: function(pocketId) {
        if($('tr[data-pocket-id]').length - 1 <= 0) {
            return Swal.fire(
                'Error',
                'No se puede eliminar el ??nico bols??n. Crea otro primero.',
                'error'
            );
        }
        // Muestro swal para confirmar eliminar
        Swal.fire({
            title: '??Seguro?',
            text: 'Si confirmas, se eliminar?? el bols??n y no se podr?? elegir al crear un pedido.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: "Cancelar",
            confirmButtonText: "Eliminar bols??n"
        }).then(function(result) {
            if(result.value) {
                // L??gica para eliminaci??n
                let pocketName = $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-name]').attr('data-pocket-name');
                let pocketPrice = $('tr[data-pocket-id="'+pocketId+'"]').find('td[data-pocket-price]').attr('data-pocket-price');
                $.ajax({
                    url: ajaxURL + 'pockets/delete/' + pocketId,
                    method: 'get',
                }).done(function(result) {
                    if(result.status == 'ok') {
                        // Elimino la fila de la tabla
                        $('tr[data-pocket-id="'+ pocketId +'"]').remove();
                        return Swal.fire('??Eliminado!', 'El bols??n se elimin?? con ??xito.', 'success');
                    }
                    return Swal.fire('Error', 'Algo sali?? mal intentando eliminar el bols??n. Intenta de nuevo', 'error');
                });
            }
        });
    },
    
    toggleActive: function(pocketId, pocketStatus) {
        $.ajax({
            url: ajaxURL + 'pockets/status/' + pocketId + '/' + pocketStatus,
            method: 'get'
        }).done(function(result) {
            if(result.status == 'ok') {
                return Swal.fire('??Listo!', 'El bols??n ahora se encuentra ' + (pocketStatus == 1 ? 'activada' : 'desactivado') + '.', 'success');
            }
        });
    },

    addPocket: function(pocketName, pocketPrice, pocketDeliverPrice) {
        let data = {
            'pocketName' : pocketName,
            'pocketPrice' : pocketPrice,
            'pocketDeliverPrice' : pocketDeliverPrice
        };
        $.ajax({
            url: ajaxURL + 'pockets/add',
            data: data,
            method: 'post'
        }).done(function(result) {
            if(result.status == 'ok') {
                // Limpio el formulario y escondo el modal
                $('input[name="newPocketForm-name"], input[name="newPocketForm-price"]').val('');
                $('#newPocketModal').modal('hide');
                window.location.reload(true); 
                return Swal.fire('Bols??n creado', 'Bols??n creado con ??xito.', 'success');
            }
            return Swal.fire('Error al crear bols??n', 'No se pudo crear el bosl??n. Intenta de nuevo.', 'error');
        });
    }
};