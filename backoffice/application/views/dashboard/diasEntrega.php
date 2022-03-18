<div class="card">
    <div class="card-body">
        <h4 style="border-bottom:2px solid #FF0000;">
            Días de Entrega
            <a href="" data-toggle="modal" data-target="#modalCrearDiaEntrega" style="margin-top:5px;width:50px;height:50px;float:right;border: solid 2px #000000;border-radius: 50px;background-color: #FFFFFF;text-align:center;">
                <img src="<?=assets();?>img/add.png" style="width:40px;margin-top: 3px;margin-left: 1px;"/>
            </a>
        </h4>
        <p style="margin-top:15px;margin-bottom:15px;">Administador de Días de Entrega.</p>
        <div id="diasEntregaList" class="cupones-wrapper">
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
                <div class="row rowFiltroPedidos" style="margin-top:25px">
                    <div class="col-xs-12 col-sm-12">
                        <p><b>Tipos de Pedido</b></p> 
                        <div style="text-align:center">
                            <span style="margin-right:15%;">
                                Punto De Retiro:
                                <input data-type="checkbox-active" id='diaEntregaPuntoDeRetiroStatus' type="checkbox" checked data-toggle="toggle" data-onstyle="success" data-size="xs">
                            </span>
                            <span style="">
                                Delivery:
                                <input data-type="checkbox-active" id='diaEntregaDeliveryStatus' type="checkbox" checked data-toggle="toggle" data-onstyle="success" data-size="xs">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row rowFiltroPedidos" style="margin-top:25px">
                    <div class="col-xs-12 col-sm-12">
                        Acepta Bolsones: 
                        <input data-type="checkbox-active" id='diaEntregaAceptaBolsones' type="checkbox" checked data-toggle="toggle" data-onstyle="success" data-size="xs">
                    </div>
                </div>
                <div id="rowImagenBolson" class="row rowFiltroPedidos">
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

<script type="text/javascript" src="<?=assets();?>js/diasEntregaHelper.js?v=991923"></script>