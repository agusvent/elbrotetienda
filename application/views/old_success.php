<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
        <link rel="stylesheet" href="<?=assets();?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?=assets();?>css/main.css">
        <title>El brote orgánico: Bolsones de Estación</title>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-PKMNV49');</script>
        <!-- End Google Tag Manager -->
    </head>
    <body>

        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PKMNV49"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <div id="page-container">
        <div id="content-wrap">
        <div class="topbar"><a href="<?=base_url();?>"><img src="<?=assets();?>img/logo.png" class="topbar-logo"></a></div>
        <div class="container-fluid">
            <div class="container content-wrapper">
                <div class="card with-topcolor">
                    <div class="card-body">
                        <h4><?=$formTitle ?? '¡Bolsón de Frutas y Verduras de estación!'?></h4>
                        <?=nl2br($successMessage);?>

                        <!-- Detalles del pedido -->
                        <h5 class="deliver-details-title">Detalles de tu pedido (#<?=$order->id;?>)</h5>

                        <p class="deliver-det-item"><strong>Tipo de pedido:</strong>
                        <?php if ($order->deliver_type == 'SUC'): ?>
                            Retiro en sucursal.
                        <?php else: ?>
                            Envío a domicilio.
                        <?php endif; ?>
                        </p>

                        <?php if ($order->deliver_type == 'SUC'): ?>
                        <p class="deliver-det-item">
                            <strong>Sucursal: </strong>
                            <?=$office->name . ': ' . $office->address;?>
                        </p>
                        <p class="deliver-det-item">
                            <strong>Fecha de retiro: </strong>
                            <?=$order->deliver_date;?>
                        </p>
                        <p class="deliver-det-item">
                            <strong>Retira a nombre de: </strong>
                            <?=$order->client_name;?>
                        </p>

                        <?php else: ?>
                        <p class="deliver-det-item">
                            <strong>Dirección de entrega: </strong>
                            <?=$order->deliver_address . ' - ' . $order->deliver_extra;?>
                        </p>
                        <p class="deliver-det-item">
                            <strong>Barrio: </strong>
                            <?=$barrio->nombre;?>
                        </p>
                        <p class="deliver-det-item">
                            <strong>Fecha de entrega: </strong>
                            <?=$order->deliver_date;?>
                        </p>
                        <p class="deliver-det-item">
                            <strong>Recibe a nombre de: </strong>
                            <?=$order->client_name;?>
                        </p>
                        <?php endif; ?>

                        <?php if ($totalPrice) { ?>
                        <p class="deliver-det-item">
                            <strong>Saldo a abonar: </strong>
                            $<?=$totalPrice;?>
                        </p>
                        <?php } ?>
                        
                        <?php if ($pocket) { ?>
                        <p class="deliver-det-item">
                            <strong>Bolsón: </strong>
                            <?=$pocket->name . ' - $' . $pocket->price;?>
                        </p>
                        <?php } ?>

                        <p class="deliver-det-item">
                            <strong>Extras: </strong>
                        </p>
                        <?php if ($extras) { ?>
                        <ul>
                        <?php foreach ($extras as $extra) { ?>
                            <li><?=$extra->cant?> x <?=$extra->name.' - $'.$extra->total;?></li>
                        <?php } ?>
                        </ul>
                        <?php }else{ ?>
                        No agregaste ningún producto extra a tu pedido.
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="change-form-wrapper">
                    <a href="<?=base_url()?>">> VOLVER AL INICIO</a>
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
        <script type="text/javascript" src="<?=assets();?>js/jquery.min.js"></script>
        <script type="text/javascript" src="<?=assets();?>js/popper.min.js"></script>
        <script type="text/javascript" src="<?=assets();?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?=assets();?>js/main.js"></script>
    </body>
</html>
