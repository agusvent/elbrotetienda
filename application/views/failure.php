<!DOCTYPE html>
<html lang="es">
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
    <body>
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
                                    <a href="https://www.instagram.com/elbroteorganico/?hl=es-la." target="_blank">
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
                    <h5>¡Ups!</h5>
                    <h1>No se pudo realizar el pedido</h1>
                    <p>
                        Lo sentimos, pero tu pedido no pudo ser procesado. Por favor, intentalo de nuevo o 
                        hacé tu pedido por WhatsApp al 11-3181-6011 o nuestras redes sociales.<br><br>
                        Disculpá las molestias.
                    </p>
                    <p style="margin-top:120px;">
                        <a href="<?=base_url();?>#nuestrosBolsones"><button type="button" id="bWhatsapp" class="ebo-cart-btn-green" >VOLVER A HACER EL PEDIDO</button></a>
                    </p>
                </div>
            </div>
        </div>
        
        <footer class="footer-area bg-gray pt-40 pb-50">
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
                            <div class="footer-title">
                                <a href="https://www.facebook.com/elbrotetienda/" target="_blank">
                                    <img src="<?=assets();?>/img/fb_logo.png" width="33px"/>
                                </a>
                                <a href="https://www.instagram.com/elbroteorganico/?hl=es-la." target="_blank">
                                    <img src="<?=assets();?>img/ig_logo.png" width="33px"/>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 footer-contacto">
                        <div class="footer-widget">
                            <div class="">
                                <p>CONTACTO<br 7>
                                hola@elbrotetienda.com<br />
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
