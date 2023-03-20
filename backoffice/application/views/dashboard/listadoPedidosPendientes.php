<div class="card">
    <div class="card-body">
        <!--<h3 style="border-bottom:2px solid #FF0000;">Pedidos Pendientes
            <div style="margin-top:5px;width:50px;height:50px;float:right;border: solid 2px #000000;border-radius: 50px;background-color: #FFFFFF;text-align:center;">
                <label id="" style="margin-top:5px;">109</label>
            </div>
        </h3>-->
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form method="post" class="listadoPedidosPendientesForm" action="goToEditarPedido">
            <input type="hidden" id="idPedido" name="idPedido" value="0"/>
            <input type="hidden" id="from" name="from" value="pedidosPendientes"/>

            <table class="listadoPedidosTable" id="tableListadoPedidos">
                <thead>
                    <tr>
                        <th style="text-align:left;width:6%">&nbsp;</th>    
                        <th style="text-align:left;width:16%">Cliente</th>
                        <th style="text-align:left;width:7%">Tel&eacute;fono</th>
                        <th style="text-align:left;width:14%">Mail</th>
                        <th style="text-align:left;width:10%">Estado</th>
                        <th style="text-align:left;width:19%">Barrio</th>
                        <th style="text-align:left;width:9%">Despachado</th>
                        <th style="text-align:left;width:9%">Entregado</th>
                        <th style="text-align:left;width:2%">&nbsp;</th>
                        <th style="text-align:left;width:8%">&nbsp;</th>
                    </tr>
                </thead>
                <tbody id="tableListadoPedidosBody">

                </tbody>
            </table>
        </form>
    </div>
</div>

<!--Modal Confirm Despachado -->
<div class="modal fade" tabindex="-1" role="dialog" id="despacharPedidoConfirmationModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Despachar Pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="deleteRegistrosLogisticaForm">
            <div class="form-group">
                <h6>Estas por despachar el pedido de <span id="sClientePedidoADespechar"></span>.</h6>
                <h6>¿Quer&eacute;s continuar? </h6>
            </div>
            <div class="modal-footer">
                <button type="button" id="bDespacharPedido" class="btn btn-green">Continuar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </form>
       </div>
    </div>
  </div>
</div>
<!--Fin Modal Confirm Despachado-->

<!--Modal Confirm Entregado -->
<div class="modal fade" tabindex="-1" role="dialog" id="entregarPedidoConfirmationModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Entregar Pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="deleteRegistrosLogisticaForm">
            <div class="form-group">
                <h6>Estas por entregar el pedido de <span id="sClientePedidoAEntregar"></span>.</h6>
                <h6>¿Quer&eacute;s continuar? </h6>
            </div>
            <div class="modal-footer">
                <button type="button" id="bEntregarPedido" class="btn btn-green">Continuar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </form>
       </div>
    </div>
  </div>
</div>
<!--Fin Modal Modal Confirm Entregado-->


<script type="text/javascript" src="<?=assets();?>js/listadoPedidosPendientesHelper.js?v=917623"></script>
<script type="text/javascript" src="<?=assets();?>js/shared.js?v=6523"></script>
