<div class="card">
    <div class="card-body">
        <h4 style="border-bottom:2px solid #FF0000;">
            Días de Entrega
            <a href="" data-toggle="modal" data-target="#cuponModal" style="margin-top:5px;width:50px;height:50px;float:right;border: solid 2px #000000;border-radius: 50px;background-color: #FFFFFF;text-align:center;">
                <img src="<?=assets();?>img/add.png" style="width:40px;margin-top: 3px;margin-left: 1px;"/>
            </a>
        </h4>
        <p style="margin-top:15px;margin-bottom:15px;">Administador de Días de Entrega.</p>
        <div id="diasEntregaList" class="cupones-wrapper">
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="cuponModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Crear Día de Entrega</h5>
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

<script type="text/javascript" src="<?=assets();?>js/diasEntregaHelper.js?v=91823"></script>