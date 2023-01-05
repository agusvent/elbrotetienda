<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>El Brote Tienda Natural</title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?=assets();?>img/favi.jpg">
    
    <!-- CSS
	============================================ -->
   
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=assets();?>new_design/assets/css/bootstrap.min.css">
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="<?=assets();?>new_design/assets/css/icons.min.css">
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="<?=assets();?>new_design/assets/css/plugins.css">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="<?=assets();?>new_design/assets/css/style.css?v=2348657245">
    <link rel="stylesheet" href="<?=assets();?>new_design/assets/css/ebo.css?v=245836724">

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-PKMNV49');</script>
    <!-- End Google Tag Manager -->

</head>

    <body id="elbrote">
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PKMNV49"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->

        <header class="header-area clearfix">
            <div class="header-bottom sticky-bar header-res-padding header-padding-2">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-2 col-lg-2 col-md-6 col-4">
                            <div class="logo">
                                <a href="<?=base_url();?>">
                                    <img alt="" src="<?=assets();?>img/logo.png" style="">
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-8 d-none d-lg-block">
                            <div class="main-menu">
                                <nav>
                                    <ul>
                                        <li>
                                            <a class="eboMenuLinks" href="<?=base_url();?>#elbrote">Inicio</a>
                                        </li>
                                        <li><a class="eboMenuLinks" href="<?=base_url();?>#nuestrosBolsones">Bolsones</a></li>
                                        <li><a class="eboMenuLinks" href="<?=base_url();?>#tienda"> Tienda</a>
                                        <li><a href="<?=base_url();?>about">El Brote</a></li>
                                        <li><a class="eboMenuLinks" href="<?=base_url();?>#certificaciones">Certificaciones</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-6 col-8">
                            <div class="header-right-wrap">
                                <div class="same-style cart-wrap header-redes">
                                    <a href="https://wa.me/+5491131816011?text=¡Hola%20Brote%20Tienda!%20Quisiera%20hacerles%20una%20consulta." target="_blank" target="_blank">
                                        <div class="headerWp"></div>
                                    </a>
                                </div>

                                <div class="same-style cart-wrap header-redes">
                                    <a href="https://www.facebook.com/elbrotetienda/" target="_blank">
                                        <div class="headerFb"></div>
                                    </a>
                                </div>
                                <div class="same-style cart-wrap header-redes">
                                    <a href="https://www.instagram.com/elbrotetienda/" target="_blank">
                                        <div class="headerIg"></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-menu-area">
                        <div class="mobile-menu">
                            <nav id="mobile-menu-active">
                                <ul class="menu-overflow">
                                    <li><a href="<?=base_url();?>#elbrote">Inicio</a></li>
                                    <li><a href="<?=base_url();?>#nuestrosBolsones">Bolsones</a></li>
                                    <li><a href="<?=base_url();?>#tienda"> Tienda</a>
                                    <li><a href="<?=base_url();?>about">El Brote</a></li>
                                    <li><a href="<?=base_url();?>#certificaciones">Certificaciones</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="welcome-area pt-75 pb-80">
            <div class="container">
                <div class="welcome-content text-center">
                    <h5>PEDIDO CONFIRMADO</h5>
                    <h1>¡Gracias por tu compra!</h1>
                    <p><?=nl2br($successMessage);?></p>
                </div>
                <div class="welcome-content text-center mt-40">
                    <p class="mt-10"><strong>Tipo de pedido:</strong>
                        <?php if ($order->deliver_type == 'SUC'): ?>
                            Retiro en sucursal.
                        <?php else: ?>
                            Envío a domicilio.
                        <?php endif; ?>
                    </p>

                    <?php if ($order->deliver_type == 'SUC'): ?>
                        <p class="mt-10">
                            <strong>Sucursal: </strong>
                            <?=$office->name . ': ' . $office->address;?>
                        </p>
                        <p class="mt-10">
                            <strong>Fecha de retiro: </strong>
                            <?=$order->deliver_date;?>
                        </p>
                        <p class="mt-10">
                            <strong>Retira a nombre de: </strong>
                            <?=$order->client_name;?>
                        </p>

                    <?php else: ?>
                        <p class="mt-10">
                            <strong>Dirección de entrega: </strong>
                            <?=$order->deliver_address . ' - ' . $order->deliver_extra;?>
                        </p>
                        <p class="mt-10">
                            <strong>Barrio: </strong>
                            <?=$barrio->nombre;?>
                        </p>
                        <p class="mt-10">
                            <strong>Recibe a nombre de: </strong>
                            <?=$order->client_name;?>
                        </p>
                    <?php endif; ?>

                    <?php if ($order->id_forma_pago == 2) { ?>
                        <p class="mt-10">
                            <strong>Total abonado: </strong>
                            $<?=$montoPagado;?>
                        </p>
                    <?php } else { ?>      
                        <p class="mt-10">
                            <strong>Total a abonar (en efectivo): </strong>
                            $<?=$totalPrice;?>
                        </p>
                    <?php } ?>                    
                </div>
            </div>
        </div>
        <div class="cart-main-area pb-100">
            <div class="container">
                <h3 class="cart-page-title">Detalles del Pedido (#<?=$order->id;?>)</h3>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="table-content table-responsive cart-table-content">
                            <table>
                                <thead>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>Producto</th>
                                        <th>Precio Unitario</th>
                                        <th>Cantidad</th>
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody id="successDetallePedidoBody">
                                    <?php if(isset($order->cant_bolson) && $order->cant_bolson>0){ ?>
                                        <tr>
                                            <td class="product-thumbnail">
                                                <img class="ebo-cart-img" src="<?=assets();?>/img/bolson-del-dia/imagenBolson.jpeg" alt="">
                                            </td>
                                            <td class="product-name"><?=$pocket->name;?></td>
                                            <td class="product-price-cart"><span class="amount">$<?=$pocket->price;?></span></td>
                                            <td class="product-price-cart"><span class="amount"><?=$order->cant_bolson;?></span></td>
                                            <td class="product-subtotal">$<?=$order->total_bolson;?></td>
                                        </tr>                                
                                    <?php }?>
                                    <?php foreach($extras as $extra): ?>
                                        <tr>
                                            <td class="product-thumbnail">
                                                <img class="ebo-cart-img" src="<?=assets();?>/img/extras/<?=$extra->imagen?>" alt="">
                                            </td>
                                            <td class="product-name"><?=$extra->name?></td>
                                            <td class="product-price-cart"><span class="amount">$<?=$extra->price;?></span></td>
                                            <td class="product-price-cart"><span class="amount"><?=$extra->cant;?></span></td>
                                            <td class="product-subtotal">$<?=$extra->total;?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if($hayDescuento) { ?>
                                        <tr style="height:80px">
                                            <td class="product-thumbnail">&nbsp;</td>
                                            <td class="product-name">Cupón de Descuento aplicado</td>
                                            <td class="product-price-cart"><span class="amount">&nbsp;</span></td>
                                            <td class="product-price-cart"><span class="amount">&nbsp;</span></td>
                                            <td class="product-subtotal">-$<?=$montoDescuento;?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer-area bg-gray pt-40 pb-30">
            <div class="container">
                <div class="row ebo-footer">
                    <div class="col-sm-2">
                        <div class="copyright">
                            <div class="footer-logo">
                                <a href="<?=base_url();?>">
                                    <img alt="" src="<?=assets();?>img/logo_footer.png">
                                </a>
                            </div>
                            <p></p>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="footer-widget">
                            <div class="footer-title">
                                <a class="eboMenuLinks" href="<?=base_url();?>#elbrote"><h3>INICIO</h3></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="footer-widget">
                            <div class="footer-title">
                                <a class="eboMenuLinks" href="<?=base_url();?>#nuestrosBolsones"><h3>BOLSONES</h3></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="footer-widget">
                            <div class="footer-title">
                                <a class="eboMenuLinks" href="<?=base_url();?>#tienda"><h3>TIENDA</h3></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="footer-widget">
                            <div class="footer-title">
                                <a href="<?=base_url();?>about"><h3>EL BROTE</h3></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="footer-widget">
                            <div class="footer-title">
                                <a class="eboMenuLinks" href="<?=base_url();?>#certificaciones"><h3>CERTIFICACIONES</h3></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1 footer-redes">
                        <div class="footer-widget">
                            <div class="footer-title logo-redes">
                                <a href="https://wa.me/+5491131816011?text=¡Hola%20Brote%20Tienda!%20Quisiera%20hacerles%20una%20consulta." target="_blank" target="_blank">
                                    <div class="footerWp"></div>
                                </a>                    
                                <a href="https://www.facebook.com/elbrotetienda/" target="_blank">
                                    <div class="footerFb"></div>
                                </a>
                                <a href="https://www.instagram.com/elbrotetienda/" target="_blank">
                                    <div class="footerIg"></div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 footer-contacto">
                        <div class="footer-widget">
                            <div class="">
                                <p>CONTACTO<br 7>
                                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=hola@elbrotetienda.com&su=Consulta desde elbrotetienda.com&body=&bcc=" target="_blank">hola@elbrotetienda.com</a><br />
                                Tel/WhatsApp 11-3181-6011</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>   
        <script src="<?=assets();?>/new_design/assets/js/vendor/modernizr-3.11.7.min.js"></script>
        <script src="<?=assets();?>new_design/assets/js/vendor/jquery-v3.6.0.min.js"></script>
        <script src="<?=assets();?>new_design/assets/js/vendor/jquery-migrate-v3.3.2.min.js"></script>
        <script src="<?=assets();?>new_design/assets/js/vendor/popper.min.js"></script>
        <script src="<?=assets();?>new_design/assets/js/vendor/bootstrap.min.js"></script>
        <script src="<?=assets();?>new_design/assets/js/plugins.js"></script>
        <script src="https://kit.fontawesome.com/64e240b8d6.js" crossorigin="anonymous"></script>
        <!-- Ajax Mail -->
        <!--<script src="../assets/new_design/assets/js/ajax-mail.js"></script>-->
        <!-- Main JS -->
        <script src="<?=assets();?>new_design/assets/js/main.js?v=294735694"></script>

    </body>
</html>
