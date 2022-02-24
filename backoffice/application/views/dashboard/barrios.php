<div class="card">
    <div class="card-body">
        <h4>
            Zonas de entrega
            <button type="button" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#newBarrioForm"> Agregar </button>
        </h4>
        <p>Agrega, elimina y modifica zonas de entrega (barrios).</p>
        <div class="table-responsive">
            <table class="table table-striped table-sm offices-table">
                <thead>
                    <tr>
                    <th>Nombre</th>
                    <th>Observaciones</th>
                    <th style="text-align:center">Costo Env&iacute;o</th>
                    <th>Estado</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($barrios ?? [] as $barrio) : ?>
                <tr data-barrio-id="<?=$barrio->id;?>">
                    <td data-barrio-name="<?=$barrio->nombre;?>"><?=$barrio->nombre;?></td>
                    <td data-barrio-observaciones="<?=$barrio->observaciones;?>"><?=$barrio->observaciones;?></td>
                    <td data-barrio-costoEnvio="<?=$barrio->costo_envio;?>" style="text-align:center">$<?=$barrio->costo_envio;?></td>
                    <td data-barrio-active="<?=$barrio->activo;?>">
                        <input id="active_<?=$barrio->id;?>" type="checkbox" <?=($barrio->activo == 1) ? 'checked' : ''; ?> data-toggle="toggle" data-onstyle="success" data-size="sm">
                    </td>
                    <td data-barrio-actions>
                        <button type="button" class="btn btn-danger btn-sm float-right barrio-delete" data-barrio="<?=$barrio->id;?>">Eliminar</button>
                        <button type="button" class="btn btn-secondary btn-sm float-right barrio-edit" data-barrio="<?=$barrio->id;?>">Editar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="newBarrioForm">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo barrio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="newBarrioForm">
          <div class="form-group">
                <label>Nombre:</label>
                <input type="text" class="form-control" name="newBarrioForm-name" id="newBarrioForm-name">
            </div>
            <div class="form-group">
                <label>Costo Env&iacute;o:</label>
                <input type="text" class="form-control numeric" name="newBarrioForm-costoEnvio" id="newBarrioForm-costoEnvio">
            </div>
            <div class="form-group">
                <label>Observaciones:</label>
                <input type="text" class="form-control" name="newBarrioForm-observaciones" id="newBarrioForm-observaciones">
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

<script type="text/javascript" src="<?=assets();?>js/barriosHelper.js?v=91786325"></script>