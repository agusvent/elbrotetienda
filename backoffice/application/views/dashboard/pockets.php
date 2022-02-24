<div class="card">
    <div class="card-body">
        <h4>
            Bolsones
            <button type="button" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#newPocketModal"> Agregar </button>
        </h4>
        <p>Agrega, elimina y modifica bolsones.</p>

        <div class="table-responsive">
            <table class="table table-striped table-sm pockets-table">
                <thead>
                    <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Costo de Envío</th>
                    <th>Estado</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($pockets ?? [] as $pocket) : ?>
                <tr data-pocket-id="<?=$pocket->id;?>">
                    <td data-pocket-name="<?=$pocket->name;?>"><?=$pocket->name;?></td>
                    <td data-pocket-price="<?=$pocket->price;?>"><?=$pocket->price;?></td>
                    <td data-pocket-deliver_price="<?=$pocket->delivery_price;?>"><?=$pocket->delivery_price;?></td>
                    <td data-pocket-active="<?=$pocket->active;?>">
                        <input id="active_<?=$pocket->id;?>" type="checkbox" <?=($pocket->active == 1) ? 'checked' : ''; ?> data-toggle="toggle" data-onstyle="success" data-size="sm">
                    </td>
                    <td data-pocket-actions>
                        <button type="button" class="btn btn-danger btn-sm float-right pocket-delete" data-pocket="<?=$pocket->id;?>">Eliminar</button>
                        <button type="button" class="btn btn-secondary btn-sm float-right pocket-edit" data-pocket="<?=$pocket->id;?>">Editar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="newPocketModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo bolsón</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="newPocketForm">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" class="form-control" name="newPocketForm-name">
            </div>
            <div class="form-group">
                <label>Precio:</label>
                <input type="text" class="form-control" name="newPocketForm-price">
            </div>
            <div class="form-group">
                <label>Costo de Envío:</label>
                <input type="text" class="form-control" name="newPocketForm-deliver_price">
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

<script type="text/javascript" src="<?=assets();?>js/pocketsHelper.js"></script>