
<div class="options-container"> 
    <div class="options-container-left">
        Desde: 
        <input type="date" class="form-control form-control-sm" name="dataFrom" id="dataFrom" value="<?=$_SESSION['dataFrom'] ?? date('Y-m-d');?>" max="<?=date('Y-m-d');?>" required>
        <!--<button type="button" class="btn btn-sm btn-primary changeFromSess">Fijar</button>-->
        <br />
        Hasta:&nbsp; 
        <input type="date" class="form-control form-control-sm" name="dataTo" id="dataTo" value="<?=$_SESSION['dataTo'] ?? date('Y-m-d');?>" max="<?=date('Y-m-d');?>">        
        <br />        
        <div class="marginTop10">
            <div class="col-xs-12">
                <label class="form-check-label">Día de Entrega:</label>
                <select class="form-control home-filtro-dia-entrega" name="idDiaEntregaPedido" id="idDiaEntregaPedido">
                    <option value="-1">Seleccione</option>
                    <?php foreach($cDiasEntrega as $diaEntrega): ?>
                        <?php if($diaEntrega->id_dia_entrega == $pedido->id_dia_entrega) { ?>
                            <option value="<?=$diaEntrega->id_dia_entrega;?>" selected>
                        <?php } else { ?>
                            <option value="<?=$diaEntrega->id_dia_entrega;?>">
                        <?php }?>
                        <?=$diaEntrega->descripcion; ?>
                    </option>
                    <?php endforeach; ?>
                </select>                    
            </div>
        </div>
        <br />
        <button type="button" id="bDownloadExcel" class="btn btn-sm btn-primary marginTop10">Descargar Excel</button>
        <button type="button" id="bConsultar" class="btn btn-sm btn-primary marginTop10">Consultar</button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4>Pedidos</h4>
        <h6>Filtrado por: <label id="lFiltradoPor"></label></h6>
        
        <div class="row">
            <div class="col-sm-1">
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-2 infoPedidosTableHead">
                SUCURSAL
            </div>
            <div class="col-sm-2 infoPedidosTableHead">
                DOMICILIO
            </div>
            <div class="col-sm-2 infoPedidosTableHead borderRight">
                TOT. PEDIDOS
            </div>
            <div class="col-sm-1">
            </div>
        </div>
        <div id="infoPedidosBox" style="margin-bottom:20px;">
        </div>

        <div class="row">
            <div class="col-sm-1">
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-2 infoPedidosTableHead">
                SUCURSAL
            </div>
            <div class="col-sm-2 infoPedidosTableHead">
                DOMICILIO
            </div>
            <div class="col-sm-2 infoPedidosTableHead borderRight">
                TOT. PRODUCTO
            </div>
            <div class="col-sm-1">
            </div>
        </div>
        <div id="infoBolsonesBox">
        </div>
    </div>
</div>

<!-- Modal Crear Dia de Entrega-->
<div class="modal fade" id="modalCrearDiaEntrega" tabindex="-1" role="dialog" aria-labelledby="modalCrearDiaEntrega" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crean Nuevo D&iacute;a de Entrega</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row rowFiltroPedidos">
                    <div class="col-xs-4 col-sm-6">
                        Nuevo D&iacute;a de Entrega: 
                        <input type="date" class="form-control form-control-sm" name="crearDiaEntregaFecha" id="crearDiaEntregaFecha" />
                    </div>
                </div>
                <div class="row rowFiltroPedidos">
                    <div class="col-xs-12 col-sm-12">
                        Texto Final: 
                        <input type="text" class="form-control form-control-sm" name="crearDiaEntregaLabelFinal" id="crearDiaEntregaLabelFinal" value="" disabled/>
                    </div>
                </div>
                <div class="row rowFiltroPedidos">
                    <div class="col-xs-12 col-sm-12">
                        <label>Imagen del Bols&oacute;n:</label>
                        <input type="file" class="form-control" name="crearDiaEntregaImagenBolson" id="crearDiaEntregaImagenBolson">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" id="bCrearNuevoDiaEntrega" class="btn btn-primary btn-sm">Crear D&iacute;a de Entrega</button>
                <button type="button" id="bCerrarCrearNuevoDiaEntrega" data-dismiss="modal" class="btn btn-danger btn-sm">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Crear Dia de Entrega-->