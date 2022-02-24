<div class="card">
    <div class="card-body">
        <h4 style="border-bottom:2px solid #FF0000;">
            Pedidos
        </h4>

        <div class="extras-wrapper" style="text-align:center">
            <div class="extras-caja">
                <div class="extras-caja-titulo">Costo de Envío</div>
                <div style="padding:5px;">
                    <div class="extras-caja-info" style="margin-bottom:20px;"> 
                        Este monto ser&aacute; el que se le cobra al cliente por Mercado Pago cuando el pedido tiene bolsón, independientemente de si tiene extras o no.
                    </div>
                    <div class="extras-caja-info"> 
                        <label>Monto:</label>
                        <input type="text" style="text-align:center;" class="form-control numeric" name="costoEnvioPedidos" id="costoEnvioPedidos" value="<?=$costoEnvioPedidos?>">
                    </div>
                    <div class="extras-caja-info" style="text-align:right"> 
                        <button type="button" id="bGuardarCostoEnvioPedidos" class="btn btn-small btn-green">Guardar</button>
                    </div>                    
                </div>
            </div>
            <div class="extras-caja">
                <div class="extras-caja-titulo">Reserva de Pedidos</div>
                <div style="padding:5px;">
                    <div class="extras-caja-info" style="margin-bottom:20px;"> 
                        Monto se le cobra al cliente, en concepto de seña por el pedido realizado, mediante Mercado Pago. Los envíos a domicilio se les cobra solo el envío, no ésta reserva.
                    </div>
                    <div class="row extras-caja-info"> 
                        <div class="col-sm-4 extra-caja-monto">
                            <label>$1 a $2500:</label>
                            <input type="text" style="text-align:center;" class="form-control numeric" name="valorReservaRango1" id="valorReservaRango1" value="<?=$valorReservaRango1?>">
                        </div>
                        <div class="col-sm-4 extra-caja-monto">
                            <label>$2501 a $3999:</label>
                            <input type="text" style="text-align:center;" class="form-control numeric" name="valorReservaRango2" id="valorReservaRango2" value="<?=$valorReservaRango2?>">
                        </div>
                        <div class="col-sm-4 extra-caja-monto">
                            <label>$4000 y m&aacute;s:</label>
                            <input type="text" style="text-align:center;" class="form-control numeric" name="valorReservaRango3" id="valorReservaRango3" value="<?=$valorReservaRango3?>">
                        </div>
                    </div>
                    <div class="extras-caja-info" style="text-align:right"> 
                        <button type="button" id="bGuardarSenasPedidos" class="btn btn-small btn-green">Guardar</button>
                    </div>                    
                </div>
            </div>
        </div>

        <h4 style="border-bottom:2px solid #FF0000;">
            Pedidos de Extras
        </h4>

        <div class="extras-wrapper" style="text-align:center">
            <div class="extras-caja">
                <div class="extras-caja-titulo">Pedidos de Extras</div>
                <div style="padding:5px;">
                    <div class="extras-caja-info" style="margin-bottom:20px;"> 
                        Los pedidos solamente de extras se pueden habilitar o deshabilitar para Puntos de Retiro o Domicilios de manera independiente.
                    </div>
                    <div class="extras-caja-info" style="float:left"> 
                        <span>Puntos de Retiro: &nbsp;
                        <input id="pedidoExtrasPuntoRetiroHabilitado" type="checkbox" <?=($pedidoExtrasPuntoDeRetiroHabilitado == 1) ? 'checked' : ''; ?> data-toggle="toggle" data-onstyle="success" data-size="xs" style="float:left;">    </span>
                    </div>
                    <div class="extras-caja-info" style="float:right"> 
                        <span>Domicilio: &nbsp;
                        <input id="pedidoExtrasDomicilioHabilitado" type="checkbox" <?=($pedidoExtrasDomicilioHabilitado == 1) ? 'checked' : ''; ?> data-toggle="toggle" data-onstyle="success" data-size="xs" style="float:left;">    </span>
                    </div>
                </div>
            </div>
        </div>

        <h4 style="border-bottom:2px solid #FF0000;margin-top:50px;">
            Precios para Pedidos de Extras
        </h4>

        <div class="extras-wrapper" style="text-align:center">
            <div class="extras-caja">
                <div class="extras-caja-titulo">Monto M&iacute;nimo del Pedido</div>
                <div style="padding:5px;">
                    <div class="extras-caja-info"> 
                        Los pedidos que sean solo de extras, tendr&aacute;n que tener este monto m&iacute;nimo para poder ser pedidos.
                    </div>
                    <div class="extras-caja-info"> 
                        <label>Monto:</label>
                        <input type="text" style="text-align:center;" class="form-control numeric" name="montoMinimoPedidoExtras" id="montoMinimoPedidoExtras" value="<?=$montoMinimoPedidoExtras?>">
                    </div>
                    <div class="extras-caja-info" style="text-align:right"> 
                        <button type="button" id="bGuardarMontoMinimoPedidoExtras" class="btn btn-small btn-green">Guardar</button>
                    </div>                    
                </div>
            </div>

            <div class="extras-caja">
                <div class="extras-caja-titulo">Costo de Env&iacute;o</div>
                <div style="padding:5px;">
                    <div class="extras-caja-info"> 
                        Este monto ser&aacute; el que se le cobra al cliente por Mercado Pago cuando el pedido es solo de extras.
                    </div>
                    <div class="extras-caja-info"> 
                        <label>Monto:</label>
                        <input type="text" style="text-align:center;" class="form-control numeric" name="costoEnvioPedidosExtras" id="costoEnvioPedidosExtras" value="<?=$costoEnvioPedidoExtras?>">
                    </div>
                    <div class="extras-caja-info" style="text-align:right"> 
                        <button type="button" id="bGuardarCostoEnvioPedidoExtras" class="btn btn-small btn-green">Guardar</button>
                    </div>                    
                </div>
            </div>

            <div class="extras-caja">
                <div class="extras-caja-titulo">Monto M&iacute;nimo para Env&iacute;o Sin Cargo</div>
                <div style="padding:5px;">
                    <div class="extras-caja-info"> 
                        Si un pedido solo de extras iguala o supera este monto, el costo de env&iacute;o ser&aacute; $0.
                    </div>
                    <div class="extras-caja-info"> 
                        <label>Monto:</label>
                        <input type="text" style="text-align:center;" class="form-control numeric" name="montoMinimoPedidoExtrasEnvioSinCargo" id="montoMinimoPedidoExtrasEnvioSinCargo" value="<?=$montoMinimoEnvioSinCargoPedidoExtras?>">
                    </div>
                    <div class="extras-caja-info" style="text-align:right"> 
                        <button type="button" id="bGuardarMontoMinimoEnvioSinCargo" class="btn btn-small btn-green">Guardar</button>
                    </div>                    
                </div>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript" src="<?=assets();?>js/preciosPedidoExtrasHelper.js?v=294738234"></script>