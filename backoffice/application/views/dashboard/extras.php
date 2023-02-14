<div class="card">
    <div class="card-body">
        <h4 style="border-bottom:2px solid #FF0000;">
            Productos extras
            <a href="" data-toggle="modal" data-target="#newExtraModal" style="margin-top:5px;width:50px;height:50px;float:right;border: solid 2px #000000;border-radius: 50px;background-color: #FFFFFF;text-align:center;">
                <img src="<?=assets();?>img/add.png" style="width:40px;margin-top: 3px;margin-left: 1px;"/>
            </a>
            <!--<button type="button" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#newExtraModal"> Agregar </button>-->
        </h4>
        <p style="margin-top:15px;margin-bottom:15px;">Agrega, elimina y modifica productos adicionales al pedido.</p>
        <div class="extras-wrapper">
            <?php foreach($extras ?? [] as $extra) : ?>
            <div class="extras-caja">
                <div class="extras-caja-titulo"> <?=$extra->name;?>  </div>
                <div style="padding:5px;">
                    <div class="extras-caja-info"> 
                        Precio: <b>$<?=$extra->price;?></b> 
                        <span style="float:right">Órden: <b>#<?=$extra->orden;?></b></span>
                    </div>
                    <div class="extras-caja-info"> 
                        Stock: <b><?=$extra->stock_disponible;?></b> 
                        &nbsp;
                        <span style="float:right">Stock Ilimitado: &nbsp;
                        <input data-extra-id="<?=$extra->id;?>" id="stock_ilimitado_<?=$extra->id;?>" type="checkbox" <?=($extra->stock_ilimitado == 1) ? 'checked' : ''; ?> data-toggle="toggle" data-onstyle="success" data-size="xs" style="float:left;">    </span>
                    </div>
                    <div class="extras-caja-info"> 
                    </div>
                    <div class="extras-caja-info"> 
                        Activo: &nbsp;
                        <input data-extra-id="<?=$extra->id;?>" id="active_<?=$extra->id;?>" type="checkbox" <?=($extra->active == 1) ? 'checked' : ''; ?> data-toggle="toggle" data-onstyle="success" data-size="xs">           
                        <span style="float:right">&Oacute;rden Listados: &nbsp;
                        <b>#<?=$extra->orden_listados;?></b> 
                    </div>         
                    <div class="extras-caja-info"> 
                        <div class="botonera">
                            <a href="javascript:viewImagenExtra(<?=$extra->id;?>);">Ver Imagen</a>
                            <span>
                                <a href="javascript:viewInTienda(<?=$extra->id;?>);">Ver en Tienda</a>
                                <a href="javascript:copyLink(<?=$extra->id;?>);">
                                    <img src="<?=assets();?>img/copy-link.png" width="16"/>
                                </a>
                            </span>
                            <a href="javascript:openEditExtra(<?=$extra->id;?>);">Editar</a>
                        </div>
                    </div>         
                    
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="newExtraModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo producto extra</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="newExtraForm">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" class="form-control" name="newExtraForm-name" id="newExtraForm-name">
            </div>
            <div class="form-group">
                <label>Nombre Corto:</label>
                <input type="text" class="form-control" name="newExtraForm-nombreCorto" id="newExtraForm-nombreCorto">
            </div>
            <div class="form-group">
                <label>Precio:</label>
                <input type="text" class="form-control" name="newExtraForm-price" id="newExtraForm-price">
            </div>
            <div class="form-group">
                <label>Imagen:</label>
                <input type="file" class="form-control" name="newExtraForm-image" id="newExtraForm-image">
                <input type="hidden" id="idNuevoExtra" value="0"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
       </div>
    </div>
  </div>
</div>

<!-- Modal Editar Extras-->
<div class="modal fade" id="modalEditarExtra" tabindex="-1" role="dialog" aria-labelledby="modalEditarExtra" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Extra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="row rowEditarExtra">
                    <div class="col-sm-12">
                        Nombre: 
                        <input type="text" class="form-control form-control-sm" name="editExtraName" id="editExtraName"/>
                    </div>
                </div>
                <div class="row rowEditarExtra">
                    <div class="col-sm-12">
                        Nombre Corto: 
                        <input type="text" class="form-control form-control-sm" name="editExtraNombreCorto" id="editExtraNombreCorto"/>
                    <label style="font-size:12px;">* El Nombre Corto es usado en los reportes de Log&iacute;stica</label>
                    </div>
                </div>
                <div class="row rowEditarExtra">
                    <div class="col-xs-12 col-sm-6">
                        Precio: 
                        <input type="text" class="form-control form-control-sm" name="editExtraPrice" id="editExtraPrice"/>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        Stock: 
                        <input type="text" class="form-control form-control-sm" name="editExtraStockDisponible" id="editExtraStockDisponible"/>
                    </div>
                </div>
                <div class="row rowEditarExtra">
                <div class="col-xs-12 col-sm-6">
                        Orden FrontEnd: 
                        <input type="text" class="form-control form-control-sm" name="editExtraOrden" id="editExtraOrden"/>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        Orden Listados: 
                        <input type="text" class="form-control form-control-sm" name="editExtraOrdenListados" id="editExtraOrdenListados"/>
                    </div>
                </div>
                <div class="row rowEditarExtra">
                    <div class="form-group col-sm-12">
                        <label>Imagen:</label>
                        <input type="file" class="form-control" name="editExtraImageForm-image" id="editExtraImageForm-image">
                        <input type="hidden" id="idEditExtra" value="0"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="bEditarExtra" class="btn btn-green btn-sm">Grabar</button>
                <button type="button" id="bCerrarEditarExtra" data-dismiss="modal" class="btn btn-danger btn-sm">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Editar Extras-->

<script type="text/javascript" src="<?=assets();?>js/extrasHelper.js?v=1876111"></script>