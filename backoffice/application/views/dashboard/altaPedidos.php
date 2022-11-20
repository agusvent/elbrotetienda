<div class="card">
    <div class="card-body">
        <h3 style="border-bottom:2px solid #FF0000;">Alta de Pedidos</h3>
    </div>
    <div class="card-body">
        <form class="altaPedidoForm">
            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Pedido para el:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <select class="form-control" name="idDiaEntregaPedido" id="idDiaEntregaPedido" required>
                        <option value="-1" selected>Seleccione</option>
                        <?php foreach($cDiasEntrega as $diaEntrega): ?>
                            <option value="<?=$diaEntrega->id_dia_entrega;?>">
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
                    <input type="text" id="altaPedidoNombreCompleto" name="altaPedidoNombreCompleto" style="width:100%"></input>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Tel&eacute;fono:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <input type="text" id="altaPedidoTelefono" name="altaPedidoTelefono" style="width:100%"></input>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Mail:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <input type="text" id="altaPedidoMail" name="altaPedidoMail" style="width:100%"></input>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Tipo de Pedido:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <select class="form-control" name="idTipoPedido" id="idTipoPedido" required>
                        <option value="-1" selected>Seleccione</option>
                    </select>                    
                </div>
            </div>
            <div id="divDireccion" class="row form-group" style="display:none;">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Direcci&oacute;n:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <input type="text" id="altaPedidoDireccion" name="altaPedidoDireccion" style="width:75%"></input>
                    <input type="text" id="altaPedidoDireccionPisoDepto" name="altaPedidoDireccionPisoDepto" style="width:23%" placeholder="Piso/Depto" class="altaPedidoForm"></input>
                </div>
            </div>
            <div id="divBarrios" class="row form-group" style="display:none">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Barrio:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <select class="form-control" name="idBarrio" id="idBarrio">
                        <option data-barrio-costoenvio="0" data-barrio-costoEnvioAnterior="0" value="-1" selected>Seleccione</option>
                        <?php foreach($cBarrios as $barrio): ?>
                        <option data-barrio-costoenvio="<?=$barrio->costo_envio;?>" data-barrio-costoEnvioAnterior="0" value="<?=$barrio->id;?>" ;?>
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
                    <select class="form-control" name="idSucursal" id="idSucursal">
                    <option value="-1" selected>Seleccione</option>
                    <?php foreach($cSucursales as $sucursal): ?>
                        <option value="<?=$sucursal->id;?>" ;?>
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
                    <select class="form-control" name="idBolson" id="idBolson" disabled>
                        <option value="-1" selected>Seleccione</option>
                        <?php foreach($cBolsones as $bolson): ?>
                        <option value="<?=$bolson->id;?>" ;?>
                            <?=$bolson->name; ?> --> $<?=$bolson->price; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>           
                    <input type="hidden" id="precioBolson" value="0"/>         
                </div>
            </div>
            <div id="divCantidadBolson" class="row form-group" style="display:none">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Cant:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <select class="form-control" name="cantBolson" id="cantBolson">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>           
                </div>
            </div>
            <div id="divCostoEnvio" class="row form-group" style="display:none">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Costo Env&iacute;o:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <input type="text" id="altaPedidoCostoEnvio" name="altaPedidoCostoEnvio" style="width:100%" value="0" disabled></input>
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
                    <select class="form-control" name="idEstadoPedido" id="idEstadoPedido" required>
                        <option value="-1" selected>Seleccione</option>
                        <?php foreach($cEstadosPedidos as $estadoPedido): ?>
                            <?php if($estadoPedido->idEstadoPedido!=4){ ?>
                                <!--SI ES DIFERENTE DE CANCELADO, MUESTRO-->
                                <option value="<?=$estadoPedido->idEstadoPedido;?>" ;?>
                                    <?=$estadoPedido->descripcion; ?>
                                </option>
                            <?php } ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row form-group" id="divAltaPedidoMontoPagado">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Monto Pagado:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <input type="text" id="altaPedidoMontoPagado" name="altaPedidoMontoPagado" class="numeric" style="width:100%" value="0"></input>
                </div>
            </div>            
            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Cup&oacute;n de Descuento:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <select class="form-control" name="idCupon" id="idCupon">
                        <option value="-1" selected>Seleccione</option>
                        <?php foreach($cCupones as $cupon): ?>
                            <option data-cupon-descuento="<?=$cupon->descuento;?>" data-cupon-idTipoDescuento="<?=$cupon->id_tipo_descuento;?>" value="<?=$cupon->id_cupon;?>" data-descuento-anterior="0";?>
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
            <div class="row form-group" id="divAltaPedidoMontoPagado">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Monto Descuento:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <input type="text" id="altaPedidoMontoMontoDescuento" name="altaPedidoMontoMontoDescuento" class="numeric" style="width:100%" value="0" disabled></input>
                </div>
            </div>            
            <div class="row form-group">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label>Observaciones:</label>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <textarea id="altaPedidoObservaciones" rows="4" cols="30" style="width:100%;resize:none;"></textarea>
                </div>
            </div>
            <div class="row form-group" style="display:none">
                <div class="col-xs-12 col-sm-3" style="text-align:right;">
                    <label for="altaPedidoCheckFijarPedido" class="form-check-label"><label>Fijar Pedido:</label></label>                    
                </div>
                <div class="col-xs-12 col-sm-5">
                    <input id="altaPedidoCheckFijarPedido" class="form-check-input" type="checkbox" data-toggle="toggle" data-on="Sí" data-off="No" data-size="xs">
                </div>
            </div>
            <div class="row form-group" style="text-align:center">
                <div class="col-xs-12 col-sm-3">
                    &nbsp;
                </div>
                <div class="col-xs-12 col-sm-5">
                    <div id="divSubtotal" class="globosMontosPedidos">
                        Total: $ <label id="lSubtotal">0</label>.-
                    </div>
                    <div id="divAPagar" class="globosMontosPedidos">
                        Debe: $ <label id="lDebe">0</label>.-
                    </div>
                </div>
            </div>

            <div class="row form-group" style="text-align:center">
                <div class="col-xs-12 col-sm-3">
                    &nbsp;
                </div>
                <div class="col-xs-12 col-sm-5">
                    <button type="submit" id="bConfirmarPedido" class="btn btn-primary btn-sm">Confirmar Pedido</button>
                    <button type="button" id="bReiniciarPedido" class="btn btn-danger btn-sm">Reinciar Pedido</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="<?=assets();?>js/altaPedidosHelper.js?v=4134677"></script>