<div class="card">
    <div class="card-body">
        <h3 style="border-bottom:2px solid #FF0000;">Listado de Pedidos
            <a href="javascript:preFiltrar();" style="margin-top:5px;width:50px;height:50px;float:right;border: solid 2px #000000;border-radius: 50px;background-color: #FFFFFF;text-align:center;">
                <img src="<?=assets();?>img/filter.png" style="width:32px;margin-top: 5px;margin-left: 2px;"/>
            </a>
        </h3>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form method="post" class="listadoPedidosForm" action="goToEditarPedido">
            <input type="hidden" id="idPedido" name="idPedido" value="0"/>
            <input type="hidden" id="consultaFechaDesde" name="consultaFechaDesde" value="<?=$consultaFechaDesde ?? ''?>"/>
            <input type="hidden" id="consultaFechaHasta" name="consultaFechaHasta" value="<?=$consultaFechaHasta ?? ''?>"/>
            <input type="hidden" id="consultaIncluirCancelados" name="consultaIncluirCancelados" value="<?=$consultaIncluirCancelados ?? false?>"/>
            <input type="hidden" id="consultaIdDiaEntrega" name="consultaIdDiaEntrega" value="<?=$consultaIdDiaEntrega ?? ''?>"/>
            <input type="hidden" id="consultaNombre" name="consultaNombre" value="<?=$consultaNombre ?? ''?>"/>
            <input type="hidden" id="consultaMail" name="consultaMail" value="<?=$consultaMail ?? ''?>"/>
            <input type="hidden" id="consultaNroPedido" name="consultaNroPedido" value="<?=$consultaNroPedido ?? ''?>"/>

            <table class="listadoPedidosTable" id="tableListadoPedidos">
                <thead>
                    <tr>
                        <th style="text-align:left;width:17%">Fecha</th>
                        <th style="text-align:left;width:17%">Cliente</th>
                        <th style="text-align:left;width:8%">Tel&eacute;fono</th>
                        <th style="text-align:left;width:15%">Mail</th>
                        <th style="text-align:left;width:10%">Estado</th>
                        <th style="text-align:left;width:5%">Tipo</th>
                        <th style="text-align:left;width:23%">P.Retiro / Barrio</th>
                        <th style="text-align:left;width:5%">&nbsp;</th>
                    </tr>
                </thead>
                <tbody id="tableListadoPedidosBody">
                    <?php
                        if(isset($cPedidos)){
                            foreach($cPedidos as $oPedido){
                                ?>
                                <?php if($oPedido->id_estado_pedido == 4){?>
                                    <tr class="pedidoCancelado">
                                <?php }else if($oPedido->id_estado_pedido == 3){?>
                                    <tr class="pedidoBonificado">
                                <?php }else if($oPedido->id_estado_pedido == 2){?>
                                    <tr class="pedidoEspecial">
                                <?php }else if($oPedido->id_estado_pedido == 5){?>
                                    <tr class="pedidoAbonado">                               
                                <?php }else{?>
                                    <tr>
                                <?php } ?>
                                        <td><?=$oPedido->deliver_date ?? '-1'?>
                                        <td><?=$oPedido->client_name ?? ""?>
                                        <td><?=$oPedido->phone ?? ""?>
                                        <td><?=$oPedido->email ?? ""?>
                                        <td><?=$oPedido->estadoPedido ?? ""?>
                                        <td><?=$oPedido->deliver_type ?? ""?>
                                        <?php if($oPedido->deliver_type=="SUC"){?>
                                            <td><?=$oPedido->sucursal ?? ""?>
                                        <?php }else{?>
                                            <td><?=$oPedido->nombre_barrio ?? ""?>
                                        <?php }?>
                                        <td><a href='javascript:fEditarPedido("<?=$oPedido->id?>")'><img class='img img-responsive' src='../assets/img/edit.png' width='30'/></a></td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
        </form>
    </div>
</div>

<!-- Modal Filtro de Pedidos-->
<div class="modal fade" id="modalFiltroPedidos" tabindex="-1" role="dialog" aria-labelledby="modalFiltroPedidos" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filtro de Pedidos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row rowFiltroPedidos">
                    <div class="col-xs-12 col-sm-12">
                        <label for="idDiaEntregaPedido" class="form-check-label"><label>Día de Entrega:</label></label>
                        <select class="form-control" name="idDiaEntregaPedido" id="idDiaEntregaPedido" required>
                            <option value="-1" selected>Seleccione</option>
                            <?php foreach($cDiasEntrega as $diaEntrega): ?>
                            <?php if($diaEntrega->id_dia_entrega == $consultaIdDiaEntrega) { ?>
                                <option value="<?=$diaEntrega->id_dia_entrega;?>" selected>
                            <?php } else { ?>
                                <option value="<?=$diaEntrega->id_dia_entrega;?>">
                            <?php } ?>
                                <?=$diaEntrega->descripcion; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>                    
                    </div>
                </div>
                <div class="row rowFiltroPedidos">
                    <div class="col-xs-12 col-sm-12">
                        <label for="checkIncluirCancelados" class="form-check-label"><label>Incluir Cancelados</label></label>
                        <?php if((isset($consultaIncluirCancelados) && $consultaIncluirCancelados=="true") || isset($consultaIncluirCancelados)==false){?>
                            <input id="checkIncluirCancelados" class="form-check-input" type="checkbox" data-toggle="toggle" data-on="Sí" data-off="No" data-size="xs" checked>
                        <?php }else{ ?>
                            <input id="checkIncluirCancelados" class="form-check-input" type="checkbox" data-toggle="toggle" data-on="Sí" data-off="No" data-size="xs">
                        <?php }?>
                    </div>
                </div>
                <div class="row rowFiltroPedidos">
                    <div class="col-xs-6 col-sm-6">
                        Desde: 
                        <input type="date" class="form-control form-control-sm" name="filtroFechaDesde" id="filtroFechaDesde" value="<?=$consultaFechaDesde ?? date('Y-m-d');?>" max="<?=date('Y-m-d');?>" required>
                    </div>
                    <div class="col-xs-6 col-sm-6">
                    Hasta:&nbsp; 
                    <input type="date" class="form-control form-control-sm" name="filtroFechaHasta" id="filtroFechaHasta" value="<?=$consultaFechaHasta ?? date('Y-m-d');?>" max="<?=date('Y-m-d');?>">        
                    </div>
                </div>
                <div class="row rowFiltroPedidos">
                    <div class="col-xs-12 col-sm-6">
                        Nombre: 
                        <input type="text" class="form-control form-control-sm" name="filtroNombre" id="filtroNombre" value="<?=$consultaNombre ?? ''?>"/>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                    Mail:&nbsp; 
                    <input type="text" class="form-control form-control-sm" name="filtroMail" id="filtroMail" value="<?=$consultaMail ?? ''?>"/>
                    </div>
                </div>
                <div class="row rowFiltroPedidos">
                    <div class="col-xs-12 col-sm-6">
                        Nro. Pedido: 
                        <input type="text" class="form-control form-control-sm" name="filtroNroPedido" id="filtroNroPedido" value="<?=$consultaNroPedido ?? ''?>"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="bFiltrarPedidos" class="btn btn-primary btn-sm">Filtrar</button>
                <button type="button" id="bCerrarFiltrar" data-dismiss="modal" class="btn btn-danger btn-sm">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Filtro de Pedidos-->

<script type="text/javascript" src="<?=assets();?>js/listadoPedidosHelper.js?v=9187263"></script>