<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/selectric.css">
        <link rel="stylesheet" href="assets/css/main.css?v=98726348">
        <title>El brote orgánico: Bolsones de Estación</title>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-PKMNV49');</script>
        <!-- End Google Tag Manager -->
        <meta name="facebook-domain-verification" content="iqans2qoy6rdszng2ykovogvwvebli" />
    </head>
    <body>

        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PKMNV49"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <div id="page-container">
        <div id="content-wrap">
        <div class="topbar"><img src="assets/img/logo.png" class="topbar-logo"></div>
        <div class="container-fluid">
            <div class="container content-wrapper">

                <!-- Texto previo a los formularios -->
                <div class="container howto-container">
                    <h1 class="howto-title">¿Cómo pido mi bolsón?</h1>
                    <div class="howto-divisor"></div>
                    <div class="methods-container">
                        <div class="method">
                            <img src="assets/img/btn-suc.png" alt="Retiro por sucursal (hacé click para pedir)" class="img-fluid" data-method="sucursal">
                        </div>
                        <div class="method">
                            <img src="assets/img/btn-dom.png" alt="Envío a domicilio (hacé click para pedir)" class="img-fluid" data-method="delivery">
                        </div>
                    </div>
                    <div class="howto-text">
                        <?=$mainText ?? '';?>
                    </div>
                    <div class="howto-divisor-vertical"></div>
                </div>

                <!-- Formulario para retiro en sucursal -->
                <div class="sucursal-form-wrapper">
                    <h1 class="pre-form-title">Retiro por sucursal</h1>
                    <div class="card with-topcolor">
                        <div class="card-body">
                            <h4><?=$formTitle ?? '¡Bolsón de Frutas y Verduras de estación!'?></h4>
                                <?php if($enabled == 1): ?>
                                <p><?=nl2br($formText) ?? ''; ?></p>
                                <?php else: ?>
                                <p><?=nl2br($disabledText) ?? 'Lo sentimos, pero en estos momentos no estamos recibiendo pedidos. Intenta en otro momento!'; ?></p>
                                <?php endif; ?>
                            <?php if($enabled == 1): ?>
                            <img src="assets/img/divisor.jpg" class="img-fluid">
                            <?php if(isset($errors)) : ?>
                            <div class="alert alert-danger">
                                <?php foreach($errors as $error): ?>
                                    <p><?=$error;?></p>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                            <form method="post" class="sucursal-form" action="<?=$_SERVER['PHP_SELF'];?>">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Nombre y Apellido</label>
                                    <input type="text" class="form-control" name="nombre" value="<?=$nombre;?>" required>
                                    <input type="hidden" name="csrfv" value="<?=rand(1000,5000);?>">
                                    <input type="hidden" name="type" value="SUC">
                                    <input type="hidden" name="arrExtras-sucursal" id="arrExtras-sucursal" value="">
                                </div>
                                <div class="form-group">
                                    <label class="bmd-label-floating">Mail</label>
                                    <input type="email" class="form-control" name="email" value="<?=$email;?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="bmd-label-floating">Celular (Poner 11 al inicio > ej: 1154332222)</label>
                                    <input type="text" class="form-control" name="celular" value="<?=$celular;?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="bmd-label-floating">Punto de Retiro</label>
                                    <select class="form-control" name="sucursal" required>
                                        <?php if(!isset($sucursal)): ?>
                                        <option selected disabled>Seleccionar por Barrio</option>
                                        <?php endif; ?>
                                        <?php foreach($sucursales as $sucursal): ?>
                                        <option value="<?=$sucursal->id;?>" <?=($sucursal->id == $sucursal) ? 'selected': '';?>>
                                            <?=$sucursal->name . ' > ' . $sucursal->address; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group divTipoBolson-sucursal">
                                    <h5>Cantidad de bolsones</h5>
                                    <?php foreach($bolsones as $bolson): ?>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="rbBolsones" name="bolson" id="bolsonRadio" data-price="<?=$bolson->price;?>" data-cant-bolsones="<?=$bolson->cant;?>" data-delivery-price="0" value="<?=$bolson->id;?>" <?=($bolson->id == $bolson) ? 'checked' : '';?> required>
                                                <?=$bolson->name;?> > $<?=$bolson->price;?>
                                        </label>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="form-group">
                                    <h5>Productos extras</h5>
                                    <div class="row">
                                        <?php foreach($extrasSucursales as $extra): ?>
                                            <div class="col-xs-12 col-sm-4">
                                                <div class="extra-product-card">
                                                    <?php
                                                    if(file_exists('assets/img/extras/'.$extra->imagen)):
                                                    ?>
                                                        <img src="assets/img/extras/<?=$extra->imagen;?>" class="card-img-top">
                                                    <?php endif; ?>
                                                    <h5><?=$extra->name;?></h5>
                                                    <label class="extra-product-titulo-tarjeta">
                                                        Cantidad:
                                                    </label>
                                                    <div class="form-group boxed">
                                                        <input type="radio" id="rbExtrasSuc<?=$extra->id;?>-1" data-extraName="<?=$extra->name;?>" data-extraId="<?=$extra->id;?>" data-lastCant="0" name="rbExtrasSuc<?=$extra->id;?>" class="rbExtrasSuc" value="1">
                                                        <label for="rbExtrasSuc<?=$extra->id;?>-1">1</label>

                                                        <input type="radio" id="rbExtrasSuc<?=$extra->id;?>-2" data-extraName="<?=$extra->name;?>" data-extraId="<?=$extra->id;?>" data-lastCant="0" name="rbExtrasSuc<?=$extra->id;?>" class="rbExtrasSuc" value="2">
                                                        <label for="rbExtrasSuc<?=$extra->id;?>-2">2</label>

                                                        <input type="radio" id="rbExtrasSuc<?=$extra->id;?>-3" data-extraName="<?=$extra->name;?>" data-extraId="<?=$extra->id;?>" data-lastCant="0" name="rbExtrasSuc<?=$extra->id;?>" class="rbExtrasSuc" value="3">
                                                        <label for="rbExtrasSuc<?=$extra->id;?>-3">3</label>

                                                        <input type="radio" id="rbExtrasSuc<?=$extra->id;?>-4" data-extraName="<?=$extra->name;?>" data-extraId="<?=$extra->id;?>" data-lastCant="0" name="rbExtrasSuc<?=$extra->id;?>" class="rbExtrasSuc" value="4">
                                                        <label for="rbExtrasSuc<?=$extra->id;?>-4">4</label>

                                                        <input type="radio" id="rbExtrasSuc<?=$extra->id;?>-5" data-extraName="<?=$extra->name;?>" data-extraId="<?=$extra->id;?>" data-lastCant="0" name="rbExtrasSuc<?=$extra->id;?>" class="rbExtrasSuc" value="5">
                                                        <label for="rbExtrasSuc<?=$extra->id;?>-5">5</label>

                                                    </div>
                                                    <label class="extra-product-titulo-tarjeta">
                                                        Precio Unitario: $<label id="precioUnitarioExtraSuc<?=$extra->id;?>"><?=$extra->price;?></label>
                                                    </label>
                                                    <label class="extra-product-price">
                                                        Total: $<label id="extraSuc<?=$extra->id;?>Total">0</label>
                                                    </label>
                                                    <div class="form-group">
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>    
                                    </div>

                                </div>
                                <div class="form-group">
                                    <h5>Confirmar pedido <br /> <label id="sucursal-hMontoMinimoPedidoExtra" style="display:none;font-size:1rem;">(Monto Minimo del Pedido Sin Bolson: $<?=$montoMinimoPedidoExtra?>)</label></h5>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="confirmation" class="checkConfirmation" value="<?=$diaEntregaPedidos->id_dia_entrega;?>" required> <?=$diaEntregaPedidos->descripcion; ?>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group" name="divResumenPedido" style="display:none;">
                                    <h5 style="margin-bottom:0">
                                        Total: $<label name="totalPedido" class="lTotalPedido">0</label>
                                        &nbsp;
                                        <span name="errorMonto" style="color:#FF0000;"></span>
                                </h5>
                                    <div name="divDetallePedido">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <p class="order-disclaimer">
                                        * Cuestiones climáticas o inconvenientes vinculados con las plantaciones pueden dificultar la disponibilidad 
                                        de algunos cultivos publicados. En esos casos, nos veremos obligados a reemplazar dichos productos por otros 
                                        que estén disponibles (según cantidad y calidad). Muchas gracias por comprender!
                                    </p>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="subm" class="btn btn-block btn-primary btn-submit">ENVIAR PEDIDO</button>
                                </div>
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="change-form-wrapper">
                        <a href data-method="delivery">> IR A ENVÍO A DOMICILIO</a>
                    </div>
                </div>
                <div class="delivery-form-wrapper">
                    <h1 class="pre-form-title">Envío a Domicilio</h1>
                    <div class="card with-topcolor">
                        <div class="card-body">
                            <h4><?=$formTitle ?? '¡Bolsón de Frutas y Verduras de estación!'?></h4>
                                <?php if($delivery == 1): ?>
                                <p><?=nl2br($formText) ?? ''; ?></p>
                                <?php else: ?>
                                <p><?=nl2br($disabledText) ?? 'Lo sentimos, pero en estos momentos no estamos recibiendo pedidos. Intenta en otro momento!'; ?></p>
                                <?php endif; ?>
                            <?php if($delivery == 1): ?>
                            <img src="assets/img/divisor.jpg" class="img-fluid">
                            <?php if(isset($errors)) : ?>
                            <div class="alert alert-danger">
                                <?php foreach($errors as $error): ?>
                                    <p><?=$error;?></p>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                            <form method="post" class="delivery-form" action="<?=$_SERVER['PHP_SELF'];?>">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Barrio para Envío a Domicilio</label>
                                    <select class="form-control" name="barrio" required>
                                        <?php if(!isset($barrio)): ?>
                                        <option selected disabled>Elegí tu barrio</option>
                                        <?php endif; ?>
                                        <?php foreach($barrios as $_barrio): ?>
                                        <option value="<?=$_barrio->id;?>" <?=(isset($barrio) && $_barrio->id == $barrio) ? 'selected': '';?>>
                                            <?=$_barrio->nombre; ?> > <?=$_barrio->observaciones; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="bmd-label-floating">Nombre y Apellido</label>
                                    <input type="text" class="form-control" name="nombre" value="<?=$nombre;?>" required>
                                    <input type="hidden" name="csrfv" value="<?=rand(1000,5000);?>">
                                    <input type="hidden" name="type" value="DEL">
                                    <input type="hidden" name="arrExtras-delivery" id="arrExtras-delivery" value="">
                                </div>
                                <div class="form-group">
                                    <label class="bmd-label-floating">Mail</label>
                                    <input type="email" class="form-control" name="email" value="<?=$email;?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="bmd-label-floating">Celular (Poner 11 al inicio > ej: 1154332222)</label>
                                    <input type="text" class="form-control" name="celular" value="<?=$celular;?>" required>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Dirección (Calle y altura)</label>
                                            <input type="text" class="form-control" name="direccion" value="<?=$celular;?>" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Piso / Dpto</label>
                                            <input type="text" class="form-control" name="piso" value="<?=$celular;?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group divTipoBolson-delivery">
                                    <h5>Cantidad de bolsones</h5>
                                    <?php foreach($bolsones as $bolson): ?>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="rbBolsones" name="bolson" id="bolsonRadio" data-price="<?=$bolson->price;?>" data-cant-bolsones="<?=$bolson->cant;?>" data-delivery-price="<?=$bolson->delivery_price;?>"
                                            value="<?=$bolson->id;?>"
                                            <?=($bolson->id == $bolson) ? 'checked' : '';?>
                                            required>
                                            <?=$bolson->name;?> > $<?=$bolson->price;?> + Envío a domicilio > $<?=$bolson->delivery_price;?>
                                        </label>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="form-group">
                                    <h5>Productos extras</h5>
                                    <div class="row">
                                        <?php foreach($extrasDomicilios as $extra): ?>
                                            <div class="col-xs-12 col-sm-4">
                                                <div class="extra-product-card">
                                                    <?php
                                                    if(file_exists('assets/img/extras/'.$extra->id.'.jpg')):
                                                    ?>
                                                        <img src="assets/img/extras/<?=$extra->id;?>.jpg" class="card-img-top">
                                                    <?php endif; ?>
                                                    <h5><?=$extra->name;?></h5>
                                                    <label class="extra-product-titulo-tarjeta">
                                                        Cantidad:
                                                    </label>
                                                    <div class="form-group boxed">
                                                        <input type="radio" id="rbExtrasDel<?=$extra->id;?>-1" data-extraName="<?=$extra->name;?>" data-extraId="<?=$extra->id;?>" data-lastCant="0" name="rbExtrasDel<?=$extra->id;?>" class="rbExtrasDel" value="1">
                                                        <label for="rbExtrasDel<?=$extra->id;?>-1">1</label>

                                                        <input type="radio" id="rbExtrasDel<?=$extra->id;?>-2" data-extraName="<?=$extra->name;?>" data-extraId="<?=$extra->id;?>" data-lastCant="0" name="rbExtrasDel<?=$extra->id;?>" class="rbExtrasDel" value="2">
                                                        <label for="rbExtrasDel<?=$extra->id;?>-2">2</label>

                                                        <input type="radio" id="rbExtrasDel<?=$extra->id;?>-3" data-extraName="<?=$extra->name;?>" data-extraId="<?=$extra->id;?>" data-lastCant="0" name="rbExtrasDel<?=$extra->id;?>" class="rbExtrasDel" value="3">
                                                        <label for="rbExtrasDel<?=$extra->id;?>-3">3</label>

                                                        <input type="radio" id="rbExtrasDel<?=$extra->id;?>-4" data-extraName="<?=$extra->name;?>" data-extraId="<?=$extra->id;?>" data-lastCant="0" name="rbExtrasDel<?=$extra->id;?>" class="rbExtrasDel" value="4">
                                                        <label for="rbExtrasDel<?=$extra->id;?>-4">4</label>

                                                        <input type="radio" id="rbExtrasDel<?=$extra->id;?>-5" data-extraName="<?=$extra->name;?>" data-extraId="<?=$extra->id;?>" data-lastCant="0" name="rbExtrasDel<?=$extra->id;?>" class="rbExtrasDel" value="5">
                                                        <label for="rbExtrasDel<?=$extra->id;?>-5">5</label>

                                                    </div>
                                                    <label class="extra-product-titulo-tarjeta">
                                                        Precio Unitario: $<label id="precioUnitarioExtraDel<?=$extra->id;?>"><?=$extra->price;?></label>
                                                    </label>
                                                    <label class="extra-product-price">
                                                        Total: $<label id="extraDel<?=$extra->id;?>Total">0</label>
                                                    </label>
                                                    <div class="form-group">
                                                    </div>

                                                    
                                                </div>
                                            </div>
                                        <?php endforeach; ?>    
                                    </div>
                                    
                                </div>
                                <div class="form-group">
                                    <h5>Confirmar pedido <label id="delivery-hMontoMinimoPedidoExtra" style="display:none;">(Monto Minimo del Pedido Sin Bolson: $<?=$montoMinimoPedidoExtra?>)</label></h5>
                                    <div class="checkbox">
                                        <label>
                                        <input type="checkbox" name="confirmation" class="checkConfirmation" value="<?=$diaEntregaPedidos->id_dia_entrega;?>" required> <?=$diaEntregaPedidos->descripcion; ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" name="divResumenPedido" style="display:none;">
                                    <h5>Total: $<label name="totalPedido" class="lTotalPedido">0</label></h5>
                                    <div name="divDetallePedido">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <p class="order-disclaimer">
                                        * Cuestiones climáticas o inconvenientes vinculados con las plantaciones pueden dificultar la disponibilidad 
                                        de algunos cultivos publicados. En esos casos, nos veremos obligados a reemplazar dichos productos por otros 
                                        que estén disponibles (según cantidad y calidad). Muchas gracias por comprender!
                                    </p>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="subm" class="btn btn-block btn-primary btn-submit">ENVIAR PEDIDO</button>
                                </div>
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="change-form-wrapper">
                        <a href data-method="sucursal">> IR A RETIRO POR SUCURSAL</a>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <footer class="default-footer">
            <div class="footer-container container-fluid">
                ¡Seguinos en redes! <span class="footer-hseparator"></span><a href="https://www.instagram.com/elbroteorganico/" target="_blank"><img src="<?=assets();?>img/ig-30x30.png" alt="Instagram" class="footer-social-img"></a> <a href="https://www.facebook.com/elbroteorgaico/" target="_blank"><img src="<?=assets();?>img/fb-30x30.png" alt="Facebook" class="footer-social-img"></a> El Brote Orgánico
            </div>
        </footer>
        </div>
        <div class="loading">
            <div class="loader">Loading...</div>
        </div>

        
<!-- Modal Aviso Pedidos Ya Cargados-->
<div class="modal fade" id="modalAvisoPedidosCargados" tabindex="-1" role="dialog" aria-labelledby="modalAvisoPedidosCargados" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hola!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding-top:0px;margin-top:0px;">
                <div class="row rowAvisoPedidosCargados">
                    <div class="col-xs-12 col-sm-12">
                        <h5>Ya ten&eacute;s cargado un pedido a tu nombre, para el <b><label id="labelAvisoPedidosCargadosDiaBolson"></label>.</b></h5>
                        <p>
                            Si quer&eacute;s modificar tu pedido, comunicate por WhatsApp.
                        </p>
                        <p>
                            Si quer&eacute;s cargar un nuevo pedido a tu nombre, apret&aacute; el bot&oacute;n de continuar.
                        </p>
                        <p>
                            De lo contrario, te esperamos el Mi&eacute;rcoles para que disfrutes de tu bols&oacute;n!
                        </p>
                    </div>
                </div>
                <div class="row rowAvisoPedidosCargados">
                    <div class="col-xs-12 col-sm-4">
                        <button type="button" id="bContinuarConPedido" class="btn btn-block btn-blue btn-aviso-pedidos-cargados">CONTINUAR</button>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <button type="button" id="bWhatsapp" class="btn btn-block btn-green btn-aviso-pedidos-cargados">WHATSAPP</button>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <button type="button" id="bCancelarPedido" class="btn btn-block btn-red btn-aviso-pedidos-cargados">SALIR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Message-->
<div class="modal fade" id="modalMessage" tabindex="-1" role="dialog" aria-labelledby="modalMessage" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-modalMessage">
                <h5 class="modal-title" id="messageTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding-top:0px;margin-top:0px;">
                <div class="row rowAvisoPedidosCargados">
                    <div class="col-xs-12 col-sm-12" id="messageDiv">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fin Modal Open Message-->

<!-- Modal Imagen Bolson-->
<!--<div class="modal fade" id="modalImagenBolson" tabindex="-1" role="dialog" aria-labelledby="modalMessage" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-imagenBolson" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
            </div>
            
            <div id="modalImagenBolsonBody" class="modal-body" style="padding-top:0px;margin-top:0px;">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <img src="assets/img/bolson-del-dia/imagenBolson.png" alt="No te olvides de pedir tu bolsón" class="img-fluid">
                    </div>
                    <div class="col-xs-12 col-sm-6" style="display:flex;flex-direction:column;justify-content: space-between;height:20px;">
                        <h1 style="font-weight:600">Ey!</h1> 
                        <h3>Parece que no sumaste el bols&oacute;n de esta semana a tu pedido.<br />
                            ¿Quer&eacute;s agregarlo?
                        </h3>
                        <button type="button" id="bAgregarBolson" class="btn btn-block btn-aviso-pedido-sin-bolson" style="margin-top:30px">
                            <span class="span-underline span-blue">Dale! Quiero agregarlo.</span>
                        </button>
                        <button type="button" id="bContinuarPedido" class="btn btn-block btn-aviso-pedido-sin-bolson" style="margin-top:30px">
                            <span class="span-underline span-green">No gracias, continuar con mi pedido.</span>
                        </button>
                    </div>
                </div>
                <div class="row rowAvisoPedidoDeExtrasSinBolson">
                    <div class="col-xs-12 col-sm-4">
                        
                    </div>
                    <div class="col-xs-12 col-sm-4">
                    
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
-->
<!-- Fin Modal Imagen Bolson-->

<!-- Modal Imagen Bolson-->
<div class="modal fade" id="modalImagenBolson" tabindex="-1" role="dialog" aria-labelledby="modalMessage" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-imagenBolson" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div id="modalImagenBolsonBody" class="modal-body" style="padding-top:0px;margin-top:0px;">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <img src="assets/img/bolson-del-dia/imagenBolson.jpeg" alt="No te olvides de pedir tu bolsón" class="img-fluid">
                    </div>
                    <div class="col-xs-12 col-sm-6 flex-wrapper">
                        <h1 style="font-weight:600">Ey!</h1> 
                        <h3>Parece que no sumaste el bols&oacute;n de esta semana a tu pedido.<br />
                            ¿Quer&eacute;s agregarlo?
                        </h3>
                        <button type="button" id="bAgregarBolson" class="btn btn-block btn-aviso-pedido-sin-bolson">
                            <span class="span-underline span-green">Dale! Quiero agregarlo.</span>
                        </button>
                        <button type="button" id="bContinuarPedido" class="btn btn-block btn-aviso-pedido-sin-bolson">
                            <span class="span-underline span-blue">No gracias, continuar con mi pedido.</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fin Modal Imagen Bolson-->



        <input type="hidden" id="montoMinimoPedidoExtras" value="<?=$montoMinimoPedidoExtra;?>">
        <input type="hidden" id="costoEnvioPedidoExtra" value="<?=$costoEnvioPedidoExtra;?>">
        <input type="hidden" id="montoMinimoEnvioSinCargoPedidoExtra" value="<?=$montoMinimoEnvioSinCargoPedidoExtra;?>">

        <script type="text/javascript">const baseURL = "<?=base_url();?>";</script>
        <script type="text/javascript" src="<?=assets();?>js/jquery.min.js"></script>
        <script type="text/javascript" src="<?=assets();?>js/jquery.selectric.min.js"></script>
        <script type="text/javascript" src="<?=assets();?>js/popper.min.js"></script>
        <script type="text/javascript" src="<?=assets();?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?=assets();?>js/main.js?v=92736459826345"></script>
    </body>
</html>
