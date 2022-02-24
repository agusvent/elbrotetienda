<div class="card">
    <div class="card-body">
        <h4 style="border-bottom:2px solid #FF0000;">
            Log&iacute;stica
            <a id="aDispCamion" href="#" style="margin-top:5px;width:49px;height:49px;float:right;border: solid 2px #000000;border-radius: 50px;background-color: #b5f9b4;text-align:center;">
                <img src="<?=assets();?>img/truckAdd.png" style="width:40px;margin-top: 5px;margin-left: 1px;"/>
            </a>
            <a id="aListCamiones" href="#" style="margin-top:5px;width:49px;height:49px;float:right;border: solid 2px #000000;border-radius: 50px;background-color: #b4d3f9;text-align:center;">
                <img src="<?=assets();?>img/truck.png" style="width:40px;margin-top: 3px;margin-left: 1px;"/>
            </a>
            <a id="aResumenPedidos" href="#" style="margin-top:5px;width:49px;height:49px;float:right;border: solid 2px #000000;border-radius: 50px;background-color: #b1b3b7;text-align:center;">
                <img src="<?=assets();?>img/excel.png" style="width:38px;margin-top: 3px;margin-left: 1px;"/>
            </a>
            <a id="aPrintSelected" href="#" style="margin-top:5px;width:49px;height:49px;float:right;border: solid 2px #000000;border-radius: 50px;background-color: #f77070;text-align:center;">
                <img src="<?=assets();?>img/printer.png" style="width:38px;margin-top: 3px;margin-left: 1px;"/>
            </a>
        </h4>
        <p style="margin-top:15px;margin-bottom:15px;">&nbsp;</p>

        <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Dia de Entrega a Preparar:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <select class="form-control" name="idDiaEntregaPedido" id="idDiaEntregaPedido">
                    </select> 
                </div>
                <div class="col-xs-12 col-sm-4" style="text-align:left;">
                    <button type="button" id="bPrepararLogisticaDiaEntrega" class="btn btn-square btn-primary btn-sm">Preparar</button>
                    <a id="aDeletePreparacionLogisticaDiaEntrega" title="Borrar Preparación de Logística" href="javascript:openDeleteRegistroLogistica();" style="display:none">
                        <img src="<?=assets();?>img/trash.png" style="width:40px;"/>
                    </a>
                    <a id="aCloseLogisticaDiaEntrega" title="Cerrar Logística Día de Entrega" href="javascript:openCloseRegistroLogistica();" style="display:none">
                        <img src="<?=assets();?>img/taskCompleted.png" style="width:40px;"/>
                    </a>

                </div>
            </div>
            <div id="divPuntosRetiro" style="display:none">
                <h5>
                  <span style="text-decoration:underline">Puntos de Retiro</span>
                  &nbsp; <input type="checkbox" name="checkSeleccionarTodosPuntosDeRetiro" id="checkSeleccionarTodosPuntosDeRetiro">
                  <label for="checkSeleccionarTodosPuntosDeRetiro" style="font-size:12px;">Seleccionar Todos</label>
                </h5>
                <div class="row form-group" id="divContenidoPuntosRetiro" >
                    <!--
                    <div class="col-sm-3" style="margin-bottom: 10px;padding-left:5px;padding-right:5px;">
                        <div class="caja-camion-preConfigurado">
                            <input type="checkbox" name="checkPuntoRetiro1" id="checkPuntoRetiro1" value="1">
                            <label for="checkPuntoRetiro1">ACASSUSO</label>
                            <span style="position:absolute;font-size: 40px;font-weight: 600;right: 15px;top: 15px;">119</span>
                            <p style="margin-bottom:2px;font-size:12px;color:#000000;" id="pCantOriginal1">Cant.Original: 120</p>
                            <p style="margin-bottom:2px;font-size:12px;color:#FF0000;" id="pCamionAsociadoPuntoRetiro1">Max Power (SUCURSAL)</p>
                            <p style="margin-bottom:2px;text-align:right;margin-right:10px;">
                                <a href="javascript:openEditCantidadPuntoRetiro();">
                                    <img src="../img/edit.png" style="width:24px;"/>
                                </a>
                                <a href="javascript:printPuntoRetiro();">
                                    <img src="../img/printer.png" style="width:24px;"/>
                                </a>
                            </p>
                        </div>
                    </div>
                    -->
                </div>
            </div>
            <div id="divBarrios" style="display:none">
                <h5>
                  <span style="text-decoration:underline">Barrios</span>  
                  &nbsp; <input type="checkbox" name="checkSeleccionarTodosBarrios" id="checkSeleccionarTodosBarrios">
                  <label for="checkSeleccionarTodosBarrios" style="font-size:12px;">Seleccionar Todos</label>
                </h5>
                <div class="row form-group" id="divContenidoBarrios" >

                </div>
            </div>            
    </div>
</div>

<!--Modal Editar Cantidad Punto Retiro y Barrios -->
<div class="modal fade" tabindex="-1" role="dialog" id="editarCantidadPuntoRetiroBarrioModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Cantidad De Bolsones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="editCantidadPuntoRetiroBarrioForm">
            <div class="form-group">
                <h6 id="lNombrePuntoRetiroBarrio"></h6>
                <input type="hidden" id="editarCantidadPuntoRetiroBarrioIdLogistica" value="-1"/>
            </div>
            <div class="form-group">
                <label>Cantidad Bolson Familiar:</label>
                <input type="text" class="form-control numeric" name="editarCantidadPuntoRetiroBarrio" id="editarCantidadPuntoRetiroBarrio">
            </div>
            <div class="form-group">
                <label>Cantidad Bolson Individual:</label>
                <input type="text" class="form-control numeric" name="editarCantidadBolsonIndividual" id="editarCantidadBolsonIndividual">
            </div>
            <div class="modal-footer">
                <button type="button" id="bEditarCantidadPuntoRetiroBarrio" class="btn btn-green">Editar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </form>
       </div>
    </div>
  </div>
</div>
<!--Fin Modal Editar Camion Pre Configurado-->

<!--Modal Delete Registros Logisitca -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteRegistroLogisticaModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registros de Log&iacute;stica</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="deleteRegistrosLogisticaForm">
            <div class="form-group">
                <h6>Estas por eliminar todos los registros de logística relacionados al <span id="sDeleteRegistroLogisticaDiaEntrega"></span>.</h6>
                <h6>¿Quer&eacute;s continuar? </h6>
            </div>
            <div class="modal-footer">
                <button type="button" id="bDeleteRegistroLogistica" class="btn btn-green">Continuar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </form>
       </div>
    </div>
  </div>
</div>
<!--Fin Modal Delete Registros Logisitca-->

<!--Modal Cerrar Logisitca -->
<div class="modal fade" tabindex="-1" role="dialog" id="closeRegistroLogisticaModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registros de Log&iacute;stica</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="deleteRegistrosLogisticaForm">
            <div class="form-group">
                <h6>Estas por cerrar el día <span id="sCloseRegistroLogistica"></span>. No vas a poder modificar más nada, solo mirar.</h6>
                <h6>¿Quer&eacute;s continuar? </h6>
            </div>
            <div class="modal-footer">
                <button type="button" id="bCloseRegistroLogistica" class="btn btn-green">Continuar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </form>
       </div>
    </div>
  </div>
</div>
<!--Fin Modal Cerrar Logisitca-->

<!--Modal Disponibilizar Camion -->
<div class="modal fade" tabindex="-1" role="dialog" id="disponibilizarCamionModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Disponibilizar Cami&oacute;n</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="disponibilizarCamionForm">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" class="form-control" name="disponibilizarCamionNombre" id="disponibilizarCamionNombre">
            </div>

            <div class="form-group">
                <label>Camion PreConfigurado:</label>
                <select class="form-control" name="disponibilizarCamionListCamionesPreConfigurados" id="disponibilizarCamionListCamionesPreConfigurados">
                    <option value="-1">Ninguno</option>
                </select> 
            </div>

            <div class="modal-footer">
                <button type="button" id="bCrearCamion" class="btn btn-green">Crear Cami&oacute;n</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </form>
       </div>
    </div>
  </div>
</div>
<!--Fin Modal Disponibilizar Camion -->

<!--Modal Listado Camiones -->
<div class="modal fade" tabindex="-1" role="dialog" id="listadoCamionesModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Listado Camiones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="listadoCamionesForm">
            <div style="width:100%">
              <p style="text-align:right;margin-bottom:0px;">
                <button type="button" class="btn btn-small btn-primary" style="padding-top: 4px" id="bImprimirSeleccion"><img src="<?=assets();?>img/printer.png" style="width:20px;"/>&nbsp;Imprimir Selecci&oacute;n</button>
                <button type="button" class="btn btn-small btn-primary" style="padding-top: 4px" id="bImprimirAllCamiones"><img src="<?=assets();?>img/printer.png" style="width:20px;"/>&nbsp;Imprimir Todos</button>
                <button type="button" class="btn btn-small btn-primary" style="padding-top: 4px" id="bImprimirAllCamionesConDetalles"><img src="<?=assets();?>img/printer.png" style="width:20px;"/>&nbsp;Imprimir Barrios Detalles</button>
              </p>
            </div>
            <table style="width:100%;border:1px solid #00000; background-color:#FFFFFF;">
                <thead>
                    <tr style="border-bottom:1px solid #000000;font-weight:600;line-height: 30px;">
                      <td style="text-align:center;width:10%">&nbsp;</td>
                      <td style="width:35%">CAMI&Oacute;N</td>
                      <td style="text-align:center;width:15%">TOTALES</td>
                      <td style="text-align:center;width:15%">FAMILIARES</td>
                      <td style="text-align:center;width:15%">INDIVIDUALES</td>
                      <td style="text-align:center;width:15%">FAMILIARES ESPECIALES</td>
                      <td style="text-align:center;width:15%">INDIVIDUALES ESPECIALES</td>
                      <td style="text-align:center;width:15%">&nbsp;</td>
                      <td style="text-align:center;width:10%">&nbsp;</td>
                      <td style="text-align:center;width:10%">&nbsp;</td>
                    </tr>
                </thead>
                <tbody id="tListadoCamionesDiaEntrega">
                </tbody>
            </table>

            <!--<div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>-->
        </form>
       </div>
    </div>
  </div>
</div>
<!--Fin Modal Listado Camiones -->

<!--Modal Listado Puntos y Barrios de Camion -->
<div class="modal fade" tabindex="-1" role="dialog" id="listadoPuntosRetiroYBarriosDeCamionModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Puntos de Retiro / Barrios - <label id="lNombrePuntoRetiroOBarrio"></label></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="idLogisticaDiaEntregaCamion" value="-1"/>
        <form class="puntosRetiroYBarriosDeCamionForm" style="max-height:500px;overflow:scroll;">

            <table style="width:100%;border:1px solid #00000; background-color:#FFFFFF;margin-bottom:25px;">
                <thead>
                    <tr style="border-bottom:1px solid #000000;font-weight:600;line-height: 30px;">
                        <td style="width:40%">PUNTO DE RETIRO</td>
                        <td style="text-align:center;width:15%">TOTALES</td>
                        <td style="text-align:center;width:15%">FAMILIARES</td>
                        <td style="text-align:center;width:15%">INDIVIDUALES</td>
                        <td style="text-align:center;width:15%">FAMILIARES ESPECIALES</td>
                        <td style="text-align:center;width:15%">INDIVIDUALES ESPECIALES</td>
                        <td style="text-align:center;width:15%">&nbsp;</td>
                    </tr>
                </thead>
                <tbody id="tListadoPuntosRetiroDeCamion">
                </tbody>
            </table>
            
            <table style="width:100%;border:1px solid #00000; background-color:#FFFFFF;">
                <thead>
                    <tr style="border-bottom:1px solid #000000;font-weight:600;line-height: 30px;">
                        <td style="width:40%">BARRIO</td>
                        <td style="text-align:center;width:15%">TOTALES</td>
                        <td style="text-align:center;width:15%">FAMILIARES</td>
                        <td style="text-align:center;width:15%">INDIVIDUALES</td>
                        <td style="text-align:center;width:15%">FAMILIARES ESPECIALES</td>
                        <td style="text-align:center;width:15%">INDIVIDUALES ESPECIALES</td>
                        <td style="text-align:center;width:15%">&nbsp;</td>
                    </tr>
                </thead>
                <tbody id="tListadoBarriosDeCamion">
                </tbody>
            </table>

            <!--<div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>-->
        </form>
       </div>
    </div>
  </div>
</div>
<!--Fin Modal Listado Puntos y Barrios de Camion -->

<!--Modal Delete Logistica From Camion -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteLogisticaFromCamionModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Atenci&oacute;n!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="deleteRegistrosLogisticaForm">
            <div class="form-group">
                <h6>Estas por eliminar el Punto de Retiro / Barrio "<span id="sDeleteLogisticaFromCamion"></span>".</h6>
                <h6>¿Quer&eacute;s continuar? </h6>
                <input type="hidden" id="idLogisticaParaEliminar" value="-1"/>
            </div>
            <div class="modal-footer">
                <button type="button" id="bDeleteLogisticaFromCamion" class="btn btn-green">Continuar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </form>
       </div>
    </div>
  </div>
</div>
<!--Fin Modal Delete Registros Logisitca-->

<!--Modal Listado Camiones -->
<div class="modal fade" tabindex="-1" role="dialog" id="listadoSeleccionCamionesDisponiblesModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Asociar a Cami&oacute;n - <label id="labelPuntoRetiroOBarrioAAsociar"></label></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="listadoSeleccionCamionesDisponiblesForm">
            <input type="hidden" id="idLogisticaParaAsociarACamion" value="-1"/>
            <table style="width:100%;border:1px solid #00000; background-color:#FFFFFF;">
                <thead>
                    <tr style="border-bottom:1px solid #000000;font-weight:600;line-height: 30px;">
                        <td style="width:10%">&nbsp;</td>
                        <td style="width:65%">CAMI&Oacute;N</td>
                        <td style="text-align:center;width:25%">TOTALES</td>
                    </tr>
                </thead>
                <tbody id="tListadoSeleccionCamionesDisponibles">
                </tbody>
            </table>

            <div class="modal-footer">
                <button type="button" id="bAsociarPuntoRetiroOBarrioACamion" class="btn btn-green">Asociar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </form>
       </div>
    </div>
  </div>
</div>
<!--Fin Modal Listado Camiones -->


<!--Modal Print Preferences -->
<div class="modal fade" tabindex="-1" role="dialog" id="printPreferencesModal">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Preferencias de Impresi&oacute;n</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="preferenciasImpresionForm">
          <input type="hidden" id="printPreferencesIdLogistica" value="-1"/>
          <input type="hidden" id="idTipoLogistica" value="-1"/>
            <div class="form-group">
              <label>Impresi&oacute;n:</label>
                <select class="form-control" name="print" id="printPreferencesTipoImpresion" disabled>
                    <option value="1">Una por p&aacute;gina</option>
                    <option value="2">Todas continuadas</option>
                </select> 
            </div>

            <div class="form-group">
                <label>Tipo:</label>
                <select class="form-control" name="print" id="printPreferencesTipoExtension">
                    <option value="1">XLS</option>
                    <option value="2" selected>PDF</option>
                </select> 
            </div>

            <div class="modal-footer">
                <button type="button" id="bImprimirLogistica" class="btn btn-green">Imprimir</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </form>
       </div>
    </div>
  </div>
</div>
<!--Fin Modal Print Preferences -->

<!--Modal Delete Camion Disponibilizado -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteLogisticaCamionModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Eliminar Camión Disponible</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="deleteLogisticaCamionForm">
            <input type="hidden" id="idLogisticaCamionDelete" value="-1"/>
            <div class="form-group">
                <h6>Estas por eliminar al camión <span id="sDeleteLogisticaCamion"></span>.</h6>
                <h6>¿Quer&eacute;s continuar? </h6>
            </div>
            <div class="modal-footer">
                <button type="button" id="bDeleteLogisticaCamion" class="btn btn-green">Continuar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </form>
       </div>
    </div>
  </div>
</div>
<!--Fin Modal Delete Camion Disponibilizado-->
<input type="hidden" id="idDiaEntregaSeleccionado" value="-1"/>
<input type="hidden" id="idEstadoLogisticaDiaEntrega" value="-1"/>

<script type="text/javascript" src="<?=assets();?>js/logisticaHelper.js?v=6678686"></script>