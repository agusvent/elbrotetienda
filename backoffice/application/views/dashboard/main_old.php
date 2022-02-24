
<div class="options-container"> 
    <div class="options-container-left">
        Desde: 
        <input type="date" class="form-control form-control-sm" name="dataFrom" id="dataFrom" value="<?=$_SESSION['dataFrom'] ?? date('Y-m-d');?>" max="<?=date('Y-m-d');?>" required>
        <button type="button" class="btn btn-sm btn-primary changeFromSess">Fijar</button>
        <br />
        Hasta:&nbsp; 
        <input type="date" class="form-control form-control-sm" name="dataTo" id="dataTo" value="<?=$_SESSION['dataTo'] ?? date('Y-m-d');?>" max="<?=date('Y-m-d');?>">        
        <br />        
        <label for="checkSoloBolsonDelDia" class="form-check-label">Solo <label id="lDiaBolsonFormulario"></label></label>
        <input id="checkSoloBolsonDelDia" class="form-check-input" type="checkbox" data-toggle="toggle" data-on="Sí" data-off="No" data-size="xs">
        <br />
        <button type="button" id="bDownloadExcel" class="btn btn-sm btn-primary marginTop10">Descargar Excel</button>
        <button type="button" id="bConsultar" class="btn btn-sm btn-primary marginTop10">Consultar</button>
    </div>
    <div class="options-container-right">
        <div class="form-check pl-0">
            <label for="stackedCheck2" class="form-check-label">¿Se aceptan pedidos a sucursales?</label>
            <input id="stackedCheck2" class="form-check-input" type="checkbox" data-toggle="toggle" data-on="Sí" data-off="No" data-size="xs" <?=($formEnabled == 1) ? 'checked':'';?>>
        </div>
        <div class="form-check pl-0">
            <label for="stackedCheck3" class="form-check-label">¿Se aceptan pedidos a domicilio?</label>
            <input id="stackedCheck3" class="form-check-input" type="checkbox" data-toggle="toggle" data-on="Sí" data-off="No" data-size="xs" <?=($deliveryEnabled == 1) ? 'checked':'';?>>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4>Pedidos</h4>
        <h6>Filtrado por: <label id="lFiltradoPor"></label></h6>
        <div class="row">
            <div class="col-sm-1">
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-2 infoPedidosTableHead">
                SUCURSAL
            </div>
            <div class="col-sm-2 infoPedidosTableHead">
                DOMICILIO
            </div>
            <!--<div class="col-sm-2 infoPedidosTableHead">
                TOT. PEDIDOS
            </div>-->
            <div class="col-sm-2 infoPedidosTableHead borderRight">
                TOT. BOLSONES
            </div>
            <div class="col-sm-1">
            </div>
        </div>
        <div id="infoPedidosBox">
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4>Pedidos por sucursales/barrios</h4>
        
        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="resumen-sucursal-tab-2" data-toggle="pill" href="#resumen-sucursal-2" role="tab" aria-controls="resumen-sucursal-2" aria-selected="true">Sucursales</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="resumen-delivery-tab-2" data-toggle="pill" href="#resumen-delivery-2" role="tab" aria-controls="resumen-delivery-2" aria-selected="true">Barrios</a>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="resumen-sucursal-2" role="tabpanel" aria-labelledby="resumen-sucursal-tab-2">
                <ul>
                    <?php foreach($ordersResume['sucursal']['offices'] as $office) : ?>
                    <li><?=$office['officeName'];?>: <?=$office['quantity'];?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="tab-pane fade" id="resumen-delivery-2" role="tabpanel" aria-labelledby="resumen-delivery-tab-2">
                <ul>
                    <?php foreach($ordersResume['delivery']['barrios'] as $barrio) : ?>
                    <li><?=$barrio['barrioName'];?>: <?=$barrio['quantity'];?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4>Listas para sucursales</h4>
        <select class="form-control" id="officeSelector" style="margin-bottom:25px;">
        <?php foreach($offices as $office): ?>
            <option value="<?=$office->id;?>"><?=$office->name;?></option>
        <?php endforeach; ?>
        </select>
        <table class="table" id="officeOrdersTable">
            <thead>
                <tr>
                    <?php foreach($officeOrders['columns'] as $column): ?>
                    <th><?=$column;?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach($officeOrders['rows'] as $row): ?>
                <tr>
                    <?php foreach($row as $rowValue): ?>
                    <td><?=$rowValue;?></td>
                    <?php endforeach; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<table id="tPedidosSucursales" class="xlsExportTable" style="display:none">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Mail</th>
            <th>Celular</th>
            <th>Cantidad Bolsones</th>
            <th>Miel Orgánica en Panal (300gr)</th>
            <th>Mix Polen + Nibs de Cacao (100gr)</th>
            <th>Miel Cremosa (500grs)</th>
            <th>Fecha Creacion</th>
        </tr>
    </thead>    
</table>