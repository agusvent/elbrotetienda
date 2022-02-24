<header class="header-area clearfix">

    <div class="header-bottom sticky-bar header-res-padding header-padding-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-2 col-lg-2 col-md-6 col-4">
                    <div class="logo">
                        <a href="">
                            <img alt="" src="assets/img/logo.png" style="width:103px;">
                        </a>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 d-none d-lg-block">
                    <div class="main-menu">
                        <nav>
                            <ul>
                                <li>
                                    <a href="javascript:scrollToTargetAdjusted('topbanners');">Home</a>
                                </li>
                                <li><a href="javascript:scrollToTargetAdjusted('nuestroBolson');">Bolsones</a></li>
                                <li><a href="javascript:scrollToTargetAdjusted('market');"> Tienda</a>
                                <li><a href="<?=base_url();?>about">El Brote</a></li>
                                <li><a href="javascript:scrollToTargetAdjusted('certificaciones');">Certificaciones</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-6 col-8">
                    <div class="header-right-wrap">
                        <div class="same-style cart-wrap">
                            <button class="icon-cart">
                                <i class="pe-7s-shopbag"></i>
                                <span class="count-style" id="eboCartCounter">0</span>
                            </button>
                            
                            <div class="shopping-cart-content">
                            <div class="closeDiv"></div>
                                <ul id="ebo-cart-header">
                                </ul>
                                <div class="shopping-cart-total">
                                    <h4>Total : <span class="shop-total">$ <span id="subtotalHeader">0</span></span></h4>
                                </div>
                                <div class="shopping-cart-btn btn-hover text-center">
                                    <a class="default-btn" href="javascript:scrollToTargetAdjusted('datosPedido');">FINALIZAR COMPRA</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile-menu-area">
                <div class="mobile-menu">
                    <nav id="mobile-menu-active">
                        <ul class="menu-overflow">
                            <li><a href="javascript:scrollToTargetAdjusted('nuestroBolson');">Bolsones</a></li>
                            <li><a href="javascript:scrollToTargetAdjusted('market');"> Tienda</a>
                            <li><a href="javascript:goToPage('elbrote');">El Brote</a></li>
                            <li><a href="javascript:scrollToTargetAdjusted('certificaciones');">Certificaciones</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>