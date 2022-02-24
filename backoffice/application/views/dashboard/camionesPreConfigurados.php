<div class="card">
    <div class="card-body">
        <h4 style="border-bottom:2px solid #FF0000;">
            Camiones PreConfigurados
            <a href="" data-toggle="modal" data-target="#newCamionPreConfiguradoModal" style="margin-top:5px;width:49px;height:49px;float:right;border: solid 2px #000000;border-radius: 50px;background-color: #FFFFFF;text-align:center;">
                <img src="<?=assets();?>img/add.png" style="width:40px;margin-top: 3px;margin-left: 1px;"/>
            </a>
            <a id="aIconAlertPuntosBarriosPendientesAsociacion" class="animate__slower animate__infinite" href="javascript:openPuntosRetioBarriosPendientesDeAsociar()" style="margin-right:10px; margin-top:5px;width:49px;height:49px;float:right;border: solid 2px #000000;border-radius: 50px;background-color: #FFFFFF;text-align:center;">
                <img id="imgIconAlertPuntosBarriosPendientesAsociacion" src="<?=assets();?>img/alertOff.png" style="width:40px;margin-top: 3px;margin-left: 1px;"/>
            </a>
        </h4>
        <p style="margin-top:15px;margin-bottom:15px;">&nbsp;</p>
        <div class="listado-cajas-wrapper">
            <?php foreach($cCamionesPreConfigurados ?? [] as $camionPreConfigurado) : ?>
            <div class="listado-cajas-caja">
                <div class="listado-cajas-caja-titulo"> 
                  <?=$camionPreConfigurado->nombre;?>  
                  <span style="position:relative;float:right;top:-1px;">
                    <a href="javascript:preDeleteCamion(<?=$camionPreConfigurado->id_camion_preconfigurado;?>,'<?=$camionPreConfigurado->nombre;?>');">
                      <img src="<?=assets();?>img/delete_small.png"/>
                    </a>
                  </span>
                </div>
                <div style="padding:5px;">
                    <div class="listado-cajas-caja-info texto-grande" style="text-align:center;"> 
                        <a href="javascript:openEditarCamionPreConfigurado(<?=$camionPreConfigurado->id_camion_preconfigurado;?>)">Editar Cami&oacute;n</a>
                    </div>
                    <div class="listado-cajas-caja-info texto-grande" style="text-align:center;font-size:14px;"> 
                        <a href="javascript:openEditarPuntosRetiroBarrios(<?=$camionPreConfigurado->id_camion_preconfigurado;?>)">Editar Puntos de Retiro y Barrios</a>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>

<!--Modal Nuevo Camion Pre Configurado-->
<div class="modal fade" tabindex="-1" role="dialog" id="newCamionPreConfiguradoModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo Cami&oacute;n Pre Configurado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="newCamionPreConfiguradoForm">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" class="form-control" name="newCamionPreConfiguradoNombre" id="newCamionPreConfiguradoNombre">
            </div>
            <div class="modal-footer">
                <button type="button" id="bGrabarNuevoCamion" class="btn btn-green">Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </form>
       </div>
    </div>
  </div>
</div>
<!--Fin Modal Nuevo Camion Pre Configurado-->

<!--Modal Editar Camion Pre Configurado-->
<div class="modal fade" tabindex="-1" role="dialog" id="editarCamionPreConfiguradoModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Cami&oacute;n Pre Configurado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="editCamionPreConfiguradoForm">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" class="form-control" name="editarCamionPreConfiguradoNombre" id="editarCamionPreConfiguradoNombre">
            </div>
            <div class="modal-footer">
                <button type="button" id="bEditarCamion" class="btn btn-green">Editar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </form>
       </div>
    </div>
  </div>
</div>
<!--Fin Modal Editar Camion Pre Configurado-->

<!--Modal Editar Puntos de Retiro y Barrios-->
<div class="modal fade" tabindex="-1" role="dialog" id="editarPuntosRetiroBarriosModal">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Puntos de Retiro y Barrios</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5>Cami&oacute;n: <span class="font-style:italic;" id="spanNombreCamionPreConfigurado"></span></h5>
        <form class="editPuntosRetiroBarriosForm">
            <h5>Puntos de Retiro&nbsp;<span style="text-decoration:none!important;margin-left:15px;font-size:10px;color:#FF0000;" id="mensajeGrabadoPuntosRetiro"></span></h5>
            <div id="divPuntosDeRetiro">
            </div>
            <h5>Barrios&nbsp;<span style="text-decoration:none!important;margin-left:15px;font-size:10px;color:#FF0000;" id="mensajeGrabadoBarrios"></span></h5>
            <div id="divBarrios">
            </div>
        </form>
       </div>
    </div>
  </div>
</div>
<!--Fin Modal Editar Puntos de Retiro y Barrios-->


<!--Modal Puntos y Barrios Sin Asociar-->
<div class="modal fade" tabindex="-1" role="dialog" id="puntosRetiroBarriosPendientesAsociacion">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pendientes!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="puntosRetiroBarriosPendientesAsociacionBody" class="modal-body">
      
      </div>
    </div>
  </div>
</div>
<!--Fin Modal Puntos y Barrios Sin Asociar-->

<!--Modal Confirmar Eliminar Camion-->
<div class="modal fade" tabindex="-1" role="dialog" id="confirmEliminarCamionModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Atenci&oacute;n!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="eliminarCamionBody" class="modal-body">
      
      </div>
      <div class="modal-footer">
          <button type="submit" id="bGrabarEliminarCamion" class="btn btn-primary btn-sm">Eliminar</button>
          <button type="button" id="bCancelarEliminarCamion" data-dismiss="modal" class="btn btn-danger btn-sm">Cancelar</button>
      </div>
    </div>
  </div>
  <input type="hidden" id="idEliminarCamion" value="0"/>
</div>
<!--Fin Modal Puntos y Barrios Sin Asociar-->

<input type="hidden" id="idCamionPreConfigurado" value="-1"/>
<script type="text/javascript" src="<?=assets();?>js/camionesPreConfiguradosHelper.js?v=97263"></script>