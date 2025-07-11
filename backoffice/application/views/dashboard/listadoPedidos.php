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
            <input type="hidden" id="from" name="from" value="listadoPedidos"/>
            <input type="hidden" id="consultaFechaDesde" name="consultaFechaDesde" value="<?=$consultaFechaDesde ?? ''?>"/>
            <input type="hidden" id="consultaFechaHasta" name="consultaFechaHasta" value="<?=$consultaFechaHasta ?? ''?>"/>
            <input type="hidden" id="consultaIncluirCancelados" name="consultaIncluirCancelados" value="<?=$consultaIncluirCancelados ?? false?>"/>
            <input type="hidden" id="consultaSoloNoValidos" name="consultaSoloNoValidos" value="<?=$consultaSoloNoValidos ?? false?>"/>
            <input type="hidden" id="consultaFiltroFechasOn" name="consultaFiltroFechasOn" value="<?=$consultaFiltroFechasOn ?? false?>"/>
            <input type="hidden" id="consultaIdDiaEntrega" name="consultaIdDiaEntrega" value="<?=$consultaIdDiaEntrega ?? ''?>"/>
            <input type="hidden" id="consultaNombre" name="consultaNombre" value="<?=$consultaNombre ?? ''?>"/>
            <input type="hidden" id="consultaMail" name="consultaMail" value="<?=$consultaMail ?? ''?>"/>
            <input type="hidden" id="consultaNroPedido" name="consultaNroPedido" value="<?=$consultaNroPedido ?? ''?>"/>

            <table class="listadoPedidosTable" id="tableListadoPedidos">
                <thead>
                    <tr>
                        <th style="text-align:left;width:3%">&nbsp;</th>    
                        <th style="text-align:left;width:16%">Fecha</th>
                        <th style="text-align:left;width:16%">Cliente</th>
                        <th style="text-align:left;width:7%">Tel&eacute;fono</th>
                        <th style="text-align:left;width:14%">Mail</th>
                        <th style="text-align:left;width:10%">Estado</th>
                        <th style="text-align:left;width:21%">Barrio</th>
                        <th style="text-align:left;width:3%">&nbsp;</th>
                        <th style="text-align:left;width:6%">&nbsp;</th>
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
                                        <td>
                                            <?php if($oPedido->observaciones!=null && $oPedido->observaciones!=""){?>
                                                <span data-toggle='tooltip' data-placement='left' title='<?=$oPedido->observaciones?>'>
                                                    <img class='img img-responsive' src='../assets/img/eye.png' width='24'/>
                                                </span>
                                            <?php }?>
                                        </td>
                                        <td><?=$oPedido->deliver_date ?? '-1'?></td>
                                        <td><?=$oPedido->client_name ?? ""?></td>
                                        <td><?=$oPedido->phone ?? ""?></td>
                                        <td><?=$oPedido->email ?? ""?></td>
                                        <td><?=$oPedido->estadoPedido ?? ""?></td>
                                        <td><?=$oPedido->barrio ?? ""?></td>
                                        <td><a href='javascript:fEditarPedido("<?=$oPedido->id?>")'><img class='img img-responsive' src='../assets/img/edit.png' width='24'/></a></td>
                                        <td>
                                            <a href='javascript:fReenviarMailConfirmacion("<?=$oPedido->id?>")'><img class='img img-responsive' src='../assets/img/send_mail.png' width='24'/></a>
                                            <a href='javascript:fImprimirComanda("<?=$oPedido->id?>")'><img class='img img-responsive' src='../assets/img/comanda.png' width='24'/></a>
                                        </td>
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
                    <div class="col-xs-12 col-sm-6">
                        <label for="checkIncluirCancelados" class="form-check-label"><label>Incluir Cancelados</label></label>
                        <?php if(isset($consultaIncluirCancelados) && $consultaIncluirCancelados=="true"){?>
                            <input id="checkIncluirCancelados" class="form-check-input" type="checkbox" data-toggle="toggle" data-on="Sí" data-off="No" data-size="xs" checked>
                        <?php }else{ ?>
                            <input id="checkIncluirCancelados" class="form-check-input" type="checkbox" data-toggle="toggle" data-on="Sí" data-off="No" data-size="xs">
                        <?php }?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <label for="checkSoloNoValidos" class="form-check-label"><label>Solo NO Válidos</label></label>
                        <?php if(isset($consultaSoloNoValidos) && $consultaSoloNoValidos=="true"){?>
                            <input id="checkSoloNoValidos" class="form-check-input" type="checkbox" data-toggle="toggle" data-on="Sí" data-off="No" data-size="xs" checked>
                        <?php }else{ ?>
                            <input id="checkSoloNoValidos" class="form-check-input" type="checkbox" data-toggle="toggle" data-on="Sí" data-off="No" data-size="xs">
                        <?php }?>
                    </div>
                </div>
                <div class="row rowFiltroPedidos">
                    <div class="col-xs-6 col-sm-6">
                        Desde: 
                        <?php if(isset($consultaFiltroFechasOn) && $consultaFiltroFechasOn=="false") { ?>
                            <input type="date" class="form-control form-control-sm" name="filtroFechaDesde" id="filtroFechaDesde" value="" required>
                        <?php } else { ?>
                            <input type="date" class="form-control form-control-sm" name="filtroFechaDesde" id="filtroFechaDesde" value="<?=$consultaFechaDesde ?? date('Y-m-d');?>" max="<?=date('Y-m-d');?>" required>
                        <?php } ?>
                        <label for='filtroPedidosFechasSwitch'>Fechas</label>
                        <?php if(isset($consultaFiltroFechasOn)) { ?>
                            <?php if($consultaFiltroFechasOn=="true") {?>
                                <input id='filtroPedidosFechasSwitch' type="checkbox" data-toggle="toggle" data-onstyle="success" data-size="xs" checked>
                            <?php } else { ?>
                                <input id='filtroPedidosFechasSwitch' type="checkbox" data-toggle="toggle" data-onstyle="success" data-size="xs" data-fecha-prev-desde="<?=$consultaFechaDesde?>" data-fecha-prev-hasta="<?=$consultaFechaHasta?>" >
                            <?php } ?>
                        <?php } else { ?>
                            <input id='filtroPedidosFechasSwitch' type="checkbox" data-toggle="toggle" data-onstyle="success" data-size="xs" checked>
                        <?php } ?>
                        
                        <!--<button type="button" id="bBorrarFechasFiltro" class="btn btn-xs btn-primary btn-borrar-fechas marginTop10">Borrar Fechas</button>-->
                    </div>
                    <div class="col-xs-6 col-sm-6">
                        Hasta:&nbsp; 
                        <?php if(isset($consultaFiltroFechasOn) && $consultaFiltroFechasOn=="false") { ?>
                            <input type="date" class="form-control form-control-sm" name="filtroFechaHasta" id="filtroFechaHasta" value="">        
                        <?php } else { ?>
                            <input type="date" class="form-control form-control-sm" name="filtroFechaHasta" id="filtroFechaHasta" value="<?=$consultaFechaHasta ?? date('Y-m-d');?>" max="<?=date('Y-m-d');?>">        
                        <?php } ?>
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

<script type="text/javascript" src="<?=assets();?>js/listadoPedidosHelper.js?v=9856"></script>
<script type="text/javascript" src="<?=assets();?>js/shared.js?v=14123"></script>
