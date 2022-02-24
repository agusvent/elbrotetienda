<div class="card">
    <div class="card-body">
        <h4 style="border-bottom:2px solid #FF0000;">
            Cupones
        </h4>
        <div class="cupones-wrapper" style="text-align:center">
            <div class="cupones-caja">
                <div class="cupones-caja-titulo">Módulo de Cupones Habilitado</div>
                <div style="padding:5px;">
                    <div class="cupones-caja-info" style="margin-bottom:20px;"> 
                        Si el módulo de cupones está habilitado, el cliente tendrá la posibilidad de cargar un cupón de descuento en el front.
                    </div>
                    <div class="cupones-caja-info" style="text-align:center"> 
                        <span>Habilitado: &nbsp;
                        <input id="moduloCuponesHabilitado" type="checkbox" <?=($moduloCuponesEnabled == 1) ? 'checked' : ''; ?> data-toggle="toggle" data-onstyle="success" data-size="xs" style="float:left;">    </span>
                    </div>
                </div>
            </div>
        </div>
        <h4 style="border-bottom:2px solid #FF0000;">
            Listado Cupones
            <a href="" data-toggle="modal" data-target="#cuponModal" style="margin-top:5px;width:50px;height:50px;float:right;border: solid 2px #000000;border-radius: 50px;background-color: #FFFFFF;text-align:center;">
                <img src="<?=assets();?>img/add.png" style="width:40px;margin-top: 3px;margin-left: 1px;"/>
            </a>
        </h4>
        <p style="margin-top:15px;margin-bottom:15px;">Agrega, elimina y modifica cupones de descuento.</p>
        <div id="cuponesList" class="cupones-wrapper">
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="cuponModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Crear/Editar Cupón</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="newExtraForm">
            <input type="hidden" id="idCupon" value="0"/>
            <div class="form-group">
                <label>C&oacute;digo:</label>
                <input type="text" class="form-control" name="codigoCupon" id="codigoCupon">
                <p class="red-message-error" id="errorCodigoCupon"></p>
            </div>
            <div class="form-group">
                <label>Tipo Descuento:</label>
                <select class="form-control" name="tipoDescuentoCupon" id="tipoDescuentoCupon">
                    <option value="-1">Seleccionar</option>
                    <?php foreach($tiposDescuento ?? [] as $tipoDescuento) : ?>
                        <option value="<?=$tipoDescuento->id_tipo_descuento;?>"><?=$tipoDescuento->descripcion;?></option>
                    <?php endforeach;?>
                </select> 
                <p class="red-message-error" id="errorTipoDescuentoCupon"></p>
            </div>
            <div class="form-group">
                <label>Descuento:</label>
                <input type="text" class="form-control numeric" name="descuentoCupon" id="descuentoCupon">
                <p class="red-message-error" id="errorDescuentoCupon"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="bGuardarCupon" class="btn btn-primary">Guardar</button>
            </div>
        </form>
       </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?=assets();?>js/cuponesHelper.js?v=132678"></script>