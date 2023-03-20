<div class="card">
    <div class="card-body">
        <h3 style="border-bottom:2px solid #FF0000;">Editar Pedido <label style="float:right"> <?=$pedido->client_name?> - #<?=$pedido->id?></label></h3>
    </div>
    <div class="card-body">
        <form method="post" class="editarPedidoForm" action="volverListadoPedidos">
            <input type="hidden" name="editarPedidoIdPedido" id="editarPedidoIdPedido" value="<?=$pedido->id?>"/>
            <input type="hidden" name="consultaFechaDesde" id="consultaFechaDesde" value="<?=$consultaFechaDesde?>"/>
            <input type="hidden" name="consultaFechaHasta" id="consultaFechaHasta" value="<?=$consultaFechaHasta?>"/>
            <input type="hidden" name="consultaIncluirCancelados" id="consultaIncluirCancelados" value="<?=$consultaIncluirCancelados?>"/>
            <input type="hidden" name="consultaSoloNoValidos" id="consultaSoloNoValidos"  value="<?=$consultaSoloNoValidos?>"/>
            <input type="hidden" name="consultaIdDiaEntrega" id="consultaIdDiaEntrega" value="<?=$consultaIdDiaEntrega?>"/>
            <input type="hidden" name="consultaNombre" id="consultaNombre" value="<?=$consultaNombre?>"/>
            <input type="hidden" name="consultaNroPedido" id="consultaNroPedido" value="<?=$consultaNroPedido?>"/>
            <input type="hidden" name="consultaFiltroFechasOn" id="consultaFiltroFechasOn" value="<?=$consultaFiltroFechasOn?>"/>
            <input type="hidden" name="consultaMail" id="consultaMail" value="<?=$consultaMail?>"/>
            <input type="hidden" name="from" id="from" value="<?=$from?>"/>
            <input type="hidden" name="precioBolson" id="precioBolson" value="<?=$precioBolson ?? ''?>"/>
            <input type="hidden" name="precioDeliveryBolson" id="precioDeliveryBolson" value="<?=$precioDeliveryBolson ?? ''?>"/>
            <input type="hidden" name="accion" id="accion" value=""/>
            <input type="hidden" name="tieneBolson" id="tieneBolson" value="<?=$tieneBolson ?? '0'?>"/>

            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Pedido para el:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <select class="form-control" name="idDiaEntregaPedido" id="idDiaEntregaPedido" required>
                        <option value="-2">Seleccione</option>
                        <!-- se controla con -2 porque existe el dia de entrega -1 y solo puede aparecer en el editar pedido porque es el dia SIN FECHA SISTEMA -->
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
            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Nombre Completo:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <input type="text" id="editarPedidoNombreCompleto" name="editarPedidoNombreCompleto" style="width:100%" value="<?=$pedido->client_name?>"></input>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Tel&eacute;fono:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <input type="text" id="editarPedidoTelefono" name="editarPedidoTelefono" style="width:100%" value="<?=$pedido->phone?>"></input>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Mail:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <input type="text" id="editarPedidoMail" name="editarPedidoMail" style="width:100%" value="<?=$pedido->email?>"></input>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Tipo de Pedido:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <select class="form-control" name="editarPedidoIdTipoPedido" id="editarPedidoIdTipoPedido" required>
                        <!--<option value="-1" selected>Seleccione</option>-->
                        <?php foreach($cTiposPedidos as $tipoPedido): ?>

                            <?php
                                //para reactivar SUCURSAL, sacar este if
                                if($tipoPedido->idTipoPedido == 2){?>
                                    <?php 
                                    if($tipoPedido->codigo == $pedido->deliver_type){?>
                                        <option selected value="<?=$tipoPedido->idTipoPedido;?>">
                                    <?php 
                                    }else{?>
                                        <option value="<?=$tipoPedido->idTipoPedido;?>">
                                    <?php
                                    }?>
                                <?php
                                }?>
                                <?=$tipoPedido->descripcion; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>                    
                </div>
            </div>
            <div id="divDireccion" class="row form-group" style="display:none;">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Direcci&oacute;n:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <input type="text" id="editarPedidoDireccion" name="editarPedidoDireccion" style="width:75%" value="<?=$pedido->deliver_address?>"></input>
                    <input type="text" id="editarPedidoDireccionPisoDepto" name="editarPedidoDireccionPisoDepto" style="width:23%" placeholder="Piso/Depto" class="editarPedidoForm" value="<?=$pedido->deliver_extra?>"></input>
                </div>
            </div>
            <div id="divBarrios" class="row form-group" style="display:none">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Barrio:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <select class="form-control" name="editarPedidoIdBarrio" id="editarPedidoIdBarrio">
                        <option data-barrio-costoenvio="0" data-barrio-costoEnvioAnterior="<?=$costoEnvio?>" value="-1">Seleccione</option>
                        <?php foreach($cBarrios as $barrio): ?>

                            <?php
                                if($barrio->id == $pedido->barrio_id){?>
                                    <option data-barrio-costoenvio="<?=$barrio->costo_envio;?>" data-barrio-costoEnvioAnterior="<?=$costoEnvio?>" selected value="<?=$barrio->id;?>">
                                <?php 
                                }else{?>
                                    <option data-barrio-costoenvio="<?=$barrio->costo_envio;?>" data-barrio-costoEnvioAnterior="<?=$costoEnvio?>" value="<?=$barrio->id;?>">
                                <?php
                                }?>

                                <?=$barrio->nombre; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>                    
                </div>
            </div>
            <div id="divPuntosRetiro" class="row form-group" style="display:none">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Punto de Retiro:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <select class="form-control" name="editarPedidoIdSucursal" id="editarPedidoIdSucursal">
                    <option value="-1" selected>Seleccione</option>
                    <?php foreach($cSucursales as $sucursal): ?>
                        <?php
                            if($sucursal->id == $pedido->office_id){?>
                                <option selected value="<?=$sucursal->id;?>">
                            <?php 
                            }else{?>
                                <option value="<?=$sucursal->id;?>">
                            <?php
                            }?>

                            <?=$sucursal->name; ?>
                        </option>

                        <?php endforeach; ?>
                    </select>                    
                </div>
            </div>
            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Bolson:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <select class="form-control" name="editarPedidoIdBolson" id="editarPedidoIdBolson">
                        <option value="-1" selected>Seleccione</option>
                        <?php foreach($cBolsones as $bolson): ?>
                            <?php
                                if($bolson->id == $pedido->pocket_id){?>
                                    <option selected value="<?=$bolson->id;?>">
                                <?php 
                                }else{?>
                                    <option value="<?=$bolson->id;?>">
                                <?php
                                }?>

                                    <?=$bolson->name; ?> --> $<?=$bolson->price; ?>
                                </option>
                        <?php endforeach; ?>
                    </select>           
                </div>
            </div>
            <div id="divCantidadBolson" class="row form-group" style="display:none">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Cant:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <select class="form-control" name="cantBolson" id="cantBolson">
                        <?php for($i=1;$i<4;$i++) {?>
                            <?php if($pedido->cant_bolson == $i){?>
                                <option selected value="<?=$i;?>"><?=$i;?></option>
                            <?php }else{ ?>
                                <option value="<?=$i;?>"><?=$i;?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>           
                </div>
            </div>
            <div id="divCostoEnvio" class="row form-group" style="display:none">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Costo Env&iacute;o:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <input type="text" id="editarPedidoCostoEnvio" name="editarPedidoCostoEnvio" style="width:100%" value="<?=$costoEnvio?>" disabled></input>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Seleccione Extras:</label>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <ul id="ulExtrasList" style="list-style: none;">
                    </ul>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Estado del Pedido:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <select class="form-control" name="editarPedidoIdEstadoPedido" id="editarPedidoIdEstadoPedido" required>
                        <option value="-1" selected>Seleccione</option>
                        <?php foreach($cEstadosPedidos as $estadoPedido): ?>
                            <?php if($estadoPedido->idEstadoPedido == $pedido->id_estado_pedido){?>
                                <option selected value="<?=$estadoPedido->idEstadoPedido;?>">
                            <?php 
                            }else{?>
                                <option value="<?=$estadoPedido->idEstadoPedido;?>">
                            <?php
                            }?>

                                <?=$estadoPedido->descripcion; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Forma de Pago:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <select class="form-control" name="editarPedidoIdFormaPago" id="editarPedidoIdFormaPago" required>
                        <option value="-1">Seleccione</option>
                        <?php foreach($cFormasPago as $formaPago): ?>
                            <?php if($formaPago->id == $pedido->id_forma_pago){?>
                                <option selected value="<?=$formaPago->id;?>">
                            <?php 
                            }else{?>
                                <option value="<?=$formaPago->id;?>">
                            <?php
                            }?>

                                <?=$formaPago->descripcion; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row form-group" id="divEditarPedidoMontoPagado">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Monto Pagado:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <input type="text" id="editarPedidoMontoPagado" name="editarPedidoMontoPagado" class="numeric" style="width:100%" value="<?=$pedido->monto_pagado ?>"></input>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Cup&oacute;n de Descuento:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <select class="form-control" name="idCupon" id="idCupon">
                        <?php if(isset($pedido->id_cupon) && $pedido->id_cupon>0) { ?>
                            <option value="-1" data-descuento-anterior="<?=($pedido->id_cupon>0)?$pedido->monto_descuento:0;?>">Seleccione</option>
                        <?php } else { ?>
                            <option value="-1" data-descuento-anterior="<?=($pedido->id_cupon>0)?$pedido->monto_descuento:0;?>" selected>Seleccione</option>
                        <?php } ?>
                        <?php foreach($cCupones as $cupon): ?>
                            <?php if($pedido->id_cupon == $cupon->id_cupon) { ?>
                                <option data-cupon-descuento="<?=$cupon->descuento;?>" data-cupon-idTipoDescuento="<?=$cupon->id_tipo_descuento;?>" value="<?=$cupon->id_cupon;?>" data-descuento-anterior="<?=($pedido->id_cupon>0)?$pedido->monto_descuento:0;?>" selected>
                            <?php } else { ?>
                                <option data-cupon-descuento="<?=$cupon->descuento;?>" data-cupon-idTipoDescuento="<?=$cupon->id_tipo_descuento;?>" value="<?=$cupon->id_cupon;?>" data-descuento-anterior="<?=($pedido->id_cupon>0)?$pedido->monto_descuento:0;?>">
                            <?php } ?> 
                            <?php if($cupon->id_tipo_descuento==1) {?>
                                <?=$cupon->codigo;?>&nbsp;( $<?=$cupon->descuento;?> ) 
                            <?php } else { ?>
                                <?=$cupon->codigo;?>&nbsp;( <?=$cupon->descuento;?>% ) 
                            <?php } ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row form-group" id="divEditarPedidoMontoPagado">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Monto Descuento:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <input type="text" id="editarPedidoMontoDescuento" name="editarPedidoMontoDescuento" class="numeric" style="width:100%" value="<?=($pedido->id_cupon>0)?$pedido->monto_descuento:0;?>" disabled></input>
                </div>
            </div>                        
            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Observaciones:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <textarea id="editarPedidoObservaciones" rows="4" cols="30" style="width:100%;resize:none;"><?=$pedido->observaciones?></textarea>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label for="editarPedidoCheckFijarPedido" class="form-check-label"><label>Fijar Pedido:</label></label>
                    
                </div>
                <div class="col-xs-12 col-sm-5 mobileAlignRight">
                    <?php if((isset($pedido->id_pedido_fijo) && $pedido->id_pedido_fijo==1)){?>
                        <input id="editarPedidoCheckFijarPedido" class="form-check-input" type="checkbox" data-toggle="toggle" data-on="Sí" data-off="No" data-size="xs" checked>
                    <?php }else{ ?>
                        <?php if((isset($pedido->id_pedido_original) && $pedido->id_pedido_original>0)){?>
                            <input id="editarPedidoCheckFijarPedido" class="form-check-input" type="checkbox" data-toggle="toggle" data-on="Sí" data-off="No" data-size="xs" disabled>
                        <?php }else{ ?>
                            <input id="editarPedidoCheckFijarPedido" class="form-check-input" type="checkbox" data-toggle="toggle" data-on="Sí" data-off="No" data-size="xs">
                        <?php } ?>
                    <?php } ?>
                    <?php if((isset($pedido->id_pedido_original) && $pedido->id_pedido_original>0)){?>
                        <label style="font-size:12px">(No se puede fijar porque este pedido viene de uno fijo: #<?=$pedido->id_pedido_original?>)</label>
                    <?php }?>
                </div>
            </div>


            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label class="form-check-label"><label>Fecha Creación:</label></label>
                </div>
                <div class="col-xs-12 col-sm-5 mobileAlignRight">
                    <?php if(isset($pedido->created_at)) {?>
                        <?=$pedido->created_at?>
                        <?php }?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label class="form-check-label"><label>Fecha Despachado:</label></label>
                </div>
                <div class="col-xs-12 col-sm-5 mobileAlignRight">
                    <?php if(isset($pedido->fecha_despachado)) {?>
                        <?=$pedido->fecha_despachado?>
                        <?php }?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label class="form-check-label"><label>Fecha Entregado:</label></label>
                </div>
                <div class="col-xs-12 col-sm-5 mobileAlignRight">
                    <?php if(isset($pedido->fecha_entregado)) {?>
                        <?=$pedido->fecha_entregado?>
                        <?php }?>
                </div>
            </div>
            <div class="row form-group" style="text-align:center">
                <div class="col-xs-12 col-sm-3">
                    &nbsp;
                </div>
                <div class="col-xs-12 col-sm-5">
                    <div id="divSubtotal" class="globosMontosPedidos">
                        Total: $ <label id="lEditarPedidoSubtotal"><?=$pedido->monto_total-0?></label>.-
                    </div>
                    <div id="divAPagar" class="globosMontosPedidos">
                        Debe: $ <label id="lEditarPedidoDebe"><?=$pedido->monto_total - $pedido->monto_pagado?></label>.-
                    </div>
                </div>
            </div>
            <div class="row form-group" style="text-align:center">
                <div class="col-xs-12 col-sm-3">
                    &nbsp;
                </div>
                <div class="col-xs-12 col-sm-5">
                    <button type="submit" id="bGrabarEditar" class="btn btn-primary btn-sm">Grabar</button>
                    <button type="button" id="bCancelarEditar" class="btn btn-danger btn-sm">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!--Modal Confirm Editar -->
<div class="modal fade" tabindex="-1" role="dialog" id="passEditModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="deleteRegistrosLogisticaForm">
            <div class="form-group">
                <h6>El pedido ya esta despachado/entregado y no puede editarse.</h6>
                <h6>Para continuar, tenes que ingresar la contrase&ntilde;a.</h6>
                <p>
                    <input type="password" id="masterPass" name="masterPass" style="width:100%" value=""></input>
                </p>
                <p>
                    <span id="editWithPassError" style="color:#FF0000"></span>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" id="bEditarPedidoWithPass" class="btn btn-green">Editar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </form>
       </div>
    </div>
  </div>
</div>
<!--Fin Modal Confirm Editar-->

<script type="text/javascript" src="<?=assets();?>js/editarPedidosHelper.js?v=97162"></script>