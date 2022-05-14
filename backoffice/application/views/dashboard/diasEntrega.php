<div class="card">
    <div class="card-body">
        <div>
            <h4 style="border-bottom:2px solid #FF0000;">
                Días de Entrega
                <a href="" data-toggle="modal" data-target="#modalCrearDiaEntrega" style="margin-top:5px;width:50px;height:50px;float:right;border: solid 2px #000000;border-radius: 50px;background-color: #FFFFFF;text-align:center;">
                    <img src="<?=assets();?>img/add.png" style="width:40px;margin-top: 3px;margin-left: 1px;"/>
                </a>
            </h4>
            <p style="margin-top:15px;margin-bottom:15px;">Administador de Días de Entrega.</p>
            <div style="margin-bottom:15px;">
                Apagar formulario:
                    <input id="apagarFormularioPedidos" type="checkbox" data-toggle="toggle" data-onstyle="success" data-size="xs" <?=($formEnabled == 0) ? 'checked':'';?>>
                &nbsp;( modo vacaciones )
            </div>
            <div id="diasEntregaList" class="cupones-wrapper">
            </div>
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
            <div class="modal-body modal-body-dia-entrega">
                <div id="newDiaForm" style="width:100%;">
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
                                    <input id='diaEntregaPuntoDeRetiroStatus' type="checkbox" data-toggle="toggle" data-onstyle="success" data-size="xs">
                                </span>
                                <span style="">
                                    Delivery:
                                    <input id='diaEntregaDeliveryStatus' type="checkbox" data-toggle="toggle" data-onstyle="success" data-size="xs">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row rowFiltroPedidos" style="margin-top:25px">
                        <div class="col-xs-12 col-sm-12">
                            <span style="width:40%; float:left;">
                                Acepta Bolsones: 
                                <input id='diaEntregaAceptaBolsones' type="checkbox" data-toggle="toggle" data-onstyle="success" data-size="xs">
                            </span>
                            <span style="width:50%; float:right;">
                                Carga Pedidos Fijos: 
                                <input id='diaEntregaCargaPedidosFijos' type="checkbox" data-toggle="toggle" data-onstyle="success" data-size="xs">
                            </span>
                        </div>
                    </div>
                    <div id="rowImagenBolson" class="row rowFiltroPedidos" style="display:none;margin-top:25px">
                        <div class="col-xs-12 col-sm-12">
                            <label>Imagen del Bols&oacute;n:</label>
                            <input type="file" class="form-control" name="crearDiaEntregaImagenBolson" id="crearDiaEntregaImagenBolson">
                        </div>
                    </div>
                </div>
                <div id="newDiaBarriosHabilitados">
                    <div style="display: flex;flex-direction: row;align-items: center;justify-content: space-between;">
                        <h4>Barrios Habilitados</h4>
                        <span><input id='seleccionarTodosBarriosHabilitados' type="checkbox" data-toggle="toggle" data-onstyle="success" data-size="xs"><label for="seleccionarTodosBarriosHabilitados" style="font-size:12px;">Seleccionar Todos</label></span>
                    </div>
                    <div id="diaEntregaBarriosList" class="diaEntregaBarriosList">
                        <!--modelo de item
                        <div class="col-xs-12 col-sm-4">
                            <span>
                                Acepta Bolsones: 
                                <input id='diaEntregaAceptaBolsones' type="checkbox" data-toggle="toggle" data-onstyle="success" data-size="xs">
                            </span>
                        </div>                    
                        -->
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

<!-- Modal Crear Dia de Entrega-->
<div class="modal fade" id="modalEditarImagenDia" tabindex="-1" role="dialog" aria-labelledby="modalEditarImagenDia" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Im&aacute;gen D&iacute;a de Entrega</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="rowImagenBolson" class="row rowFiltroPedidos">
                    <div class="col-xs-12 col-sm-12">
                        <label>Imagen del Bols&oacute;n:</label>
                        <input type="file" class="form-control" name="diaEntregaEditarImagen" id="diaEntregaEditarImagen">
                        <label id="lErrorEditarImagen" style="margin-top:10px;color:red; font-size:12px;"></label>
                    </div>
                </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" id="bEditarImagenDiaEntrega" class="btn btn-primary btn-sm">Grabar</button>
                    <button type="button" id="bCerrarEditarImagen" data-dismiss="modal" class="btn btn-danger btn-sm">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Crear Dia de Entrega-->

<!-- Modal Editar Barrios-->
<div class="modal fade" id="modalEditarBarrios" tabindex="-1" role="dialog" aria-labelledby="modalEditarBarrios" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><label id="lNombreDiaEntrega"></label></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-dia-entrega">
                <div id="editarBarriosHabilitados">
                    <h4>Barrios Habilitados</h4>
                    <div id="editarBarriosHabilitadosList" class="diaEntregaBarriosList">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" id="bEditarBarriosHabilitados" class="btn btn-primary btn-sm">Editar</button>
                <button type="button" id="bCancelarEditarBarriosHabilitados" data-dismiss="modal" class="btn btn-danger btn-sm">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Editar Barrios-->

<input type="hidden" id="idDiaEntregaEditar" value="0">
<script type="text/javascript" src="<?=assets();?>js/diasEntregaHelper.js?v=63424"></script>