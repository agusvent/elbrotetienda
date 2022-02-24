<div class="card">
    <div class="card-body">
        <h4>
            Puntos de Retiro
            <button type="button" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#newOfficeModal"> Agregar </button>
        </h4>
        <p>Agrega, elimina y modifica puntos de retiro.</p>
        <div class="table-responsive">
            <table class="table table-striped table-sm offices-table">
                <thead>
                    <tr>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Estado</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($offices ?? [] as $office) : ?>
                <tr data-office-id="<?=$office->id;?>">
                    <td data-office-name="<?=$office->name;?>"><?=$office->name;?></td>
                    <td data-office-address="<?=$office->address;?>"><?=$office->address;?></td>
                    <td data-office-active="<?=$office->active;?>">
                        <input id="active_<?=$office->id;?>" data-office-id="<?=$office->id;?>" type="checkbox" <?=($office->active == 1) ? 'checked' : ''; ?> data-toggle="toggle" data-onstyle="success" data-size="sm">
                    </td>
                    <td data-office-actions>
                        <button type="button" class="btn btn-danger btn-sm float-right office-delete" data-office="<?=$office->id;?>">Eliminar</button>
                        <button type="button" class="btn btn-secondary btn-sm float-right office-edit" data-office="<?=$office->id;?>">Editar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="newOfficeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo Punto de Retiro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="newOfficeForm">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" class="form-control" name="newOfficeForm-name">
            </div>
            <div class="form-group">
                <label>Dirección:</label>
                <input type="text" class="form-control" name="newOfficeForm-address">
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?=assets();?>js/officesHelper.js?v=28072021"></script>