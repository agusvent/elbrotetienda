let aExtras = [];
let disabledExtras = [];
let oBolson = undefined;
let idTipoPedidoSelected = 0;
let pedidoSoloExtras = false;

$(window).on("load", function () {
    var urlHash = window.location.href.split("#")[1];
    var section = $("#"+urlHash);
    $('html, body').animate({
        scrollTop: section.offset().top-200
    }, 500);
});

$(document).ready(function() {
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            $("#aEBTWhatsApp").addClass("mobile");
            $("#aEBTWhatsApp").show();
        }
        if(!window.matchMedia("(max-width: 767px)").matches){
            ocultarColumnasResumenPedido();
        }
        
        //ESTA FUNCION ES PARA LA ACTIVACION DE COLOR EN LOS ELEMENTOS DEL HEADER
        window.addEventListener('scroll', function(e) {
            $(".eboMenuLinks").removeClass("eboMenuLinkActivo")
            $(".eboMenuMobileLink").removeClass("eboMenuLinkActivo")
    
            if( isOnScreen( $("#elbrote" ) ) ) { 
                $("#eboMenuHome").addClass("eboMenuLinkActivo");
                changeURL("elbrote");
                if(!$("#aEBTWhatsApp").hasClass("mobile")) {
                    $("#aEBTWhatsApp").fadeOut();
                }
            }else if( isOnScreen( $("#comboFamiliar" ) ) ) { 
                $("#eboMenuComboFamiliar").addClass("eboMenuLinkActivo");
                $("#eboMenuMobileComboFamiliar").addClass("eboMenuLinkActivo");
                changeURL("comboFamiliar");
                if(!$("#aEBTWhatsApp").hasClass("mobile")) {
                    $("#aEBTWhatsApp").fadeIn();
                }
            }else if( isOnScreen( $("#tienda" ) ) ) { 
                $("#eboMenuTienda").addClass("eboMenuLinkActivo");
                $("#eboMenuMobileTienda").addClass("eboMenuLinkActivo");
                changeURL("tienda");
            }else if( isOnScreen( $("#certificaciones" ) ) ) { 
                $("#eboMenuCertificaciones").addClass("eboMenuLinkActivo");
                $("#eboMenuMobileCertificaciones").addClass("eboMenuLinkActivo");
                changeURL("certificaciones");
            }

            if( isOnScreen( $("#datosPedido" ) ) ) { 
                ocultarFinalizarCompra();
            }
        });

        $(".eboMenuMobileLink").on("click",function(e){
            e.preventDefault();
            var urlHash = $(this).prop("href").split("#")[1];
            console.log(urlHash);
            var section = $("#"+urlHash);
            console.log(section);
            $('html, body').animate({
                scrollTop: section.offset().top-150
            }, 500);
            $(".meanmenu-reveal").click();
        })
        

        $(".eboMenuLinks").on('click', function (event) {
            //event.preventDefault();
            var urlHash = $(this).prop("href").split("#")[1];
            var section = $("#"+urlHash);
            //console.log(section)
            $('html, body').animate({
                scrollTop: section.offset().top-150
            }, 500);
        });
    
        $(".closeDiv").on("click",function(e){
            $('.shopping-cart-content').removeClass('cart-visible');
        });
        
        //TEXTO DE INFO ADICIONAL AL SELECCIONAR UN PDR
        $(".infoAdicionalPdR").hide();

        $("#aEBTWhatsApp").on("click",function(){
            $("#aEBTWhatsApp").blur();
        });
        var formEnabled = getFormStatus();
        if(formEnabled==1) {
            initMarket();
            $(".rbBolson").on("click",function(){
                let aceptaBolsones = diaAceptaBolsones();

                if(aceptaBolsones) {
                    var idBolson = $(this).attr("data-idbolson");
                    var bolsonName = $(this).attr("data-bolsonname");
                    var bolsonImg = $("#imgBolsonPortada").prop("src");
                    var cant = $(this).val();
                    var precio = $(this).attr("data-bolsonprice");
                    var total = 0;
                    precio = parseInt(precio);
                    total = precio * cant;
                    oBolson = [];
                    oBolson = {
                        "idBolson": idBolson,
                        "name": bolsonName,
                        "cant": cant,
                        "precioUnitario": precio,
                        "total": total,
                        "img": bolsonImg
                        
                    };            
                    
                    $("#bolsonIndividualTotal").html(calcularSubtotalBolsonIndividual(cant));
        
                    getResumenPedido();
                    refreshCart();
                    if(!window.matchMedia("(max-width: 767px)").matches){
                        if(!$('.shopping-cart-content').hasClass("cart-visible")){
                            if(!$('.shopping-cart-content').hasClass("cart-visible")){
                                $('.shopping-cart-content').toggleClass('cart-visible');
                                setTimeout(function(){
                                    $('.shopping-cart-content').toggleClass('cart-visible');
                                },3000);
                            }    
                        }
                    }
                    mostrarFinalizarCompra();
                    $("#errorBolsonIndividual").html("");
                } else {
                    $("#modalDiaEntregaSinBolsonShort").modal("show");
                    $("input[type='radio'][class='rbBolson']").prop("checked",false);
                }
            });  
    
            $(".rbBolsonBasico").on("click",function(){
                let aceptaBolsones = diaAceptaBolsones();

                if(aceptaBolsones) {
    
                    var idExtra = $(this).attr("data-extraid");
                    var extraName = $(this).attr("data-extraName");
                    var extraImg = $(this).attr("data-extraImg");
                    var cant = $(this).val();
                    var precio = $(this).attr("data-extraprice");
                    var total = 0;
                    precio = parseInt(precio);
                    total = precio * cant;
                    //Remuevo por las dudas si es que esta el extra primero y despues agrego, ya que puede estar con una cantidad X y entra a este else porque ahora tiene cantidad Y.
                    removeExtraFromArray(idExtra);
                    addExtraToArray(idExtra,cant,precio,total,extraName,extraImg);
                    $("#bolsonBasicoTotal").html(calcularSubtotalBolsonBasico(cant));
                    getResumenPedido();
                    refreshCart();
                    if(!window.matchMedia("(max-width: 767px)").matches){
                        if(!$('.shopping-cart-content').hasClass("cart-visible")){
                            $('.shopping-cart-content').toggleClass('cart-visible');
                            setTimeout(function(){
                                $('.shopping-cart-content').toggleClass('cart-visible');
                            },3000);
                        }
                    }   
                    mostrarFinalizarCompra(); 
                } else {
                    $("#modalDiaEntregaSinBolsonShort").modal("show");
                    $("input[type='radio'][class='rbBolsonBasico']").prop("checked",false);
                }
            });  
    
    
            $(".input-datos-pedido").on("change",function(e){
                $(this).find('p.pFormError').html("");
                //LO VUELVO A INHABILITAR POR SI MODIFICAN ALGO. LOS OBLIGO A PASAR OTRA VEZ POR EL CONFIRMAR DATOS.
                $("#bRealizarPedido").prop("disabled",true);
            });
    
            $(".input-datos-pedido").on("click",function(e){
                //LO VUELVO A INHABILITAR POR SI MODIFICAN ALGO. LOS OBLIGO A PASAR OTRA VEZ POR EL CONFIRMAR DATOS.
                $("#bRealizarPedido").prop("disabled",true);
            });
            
            $("#idBarrio").on("click",function(e){
                if($("#idBarrio").hasClass("selectError")){
                    $("#idBarrio").removeClass("selectError");
                }    
            });
    
            $("#idBarrio").on("change",function(e){
                //let subtotal = $("#totalPedido").html();
                var infoDelBarrio = $("option:selected",this).attr("data-horarioEntrega");
                $("#datosBarrio").html(infoDelBarrio);
                $(".infoAdicionalBarrios").show();
                //calcularPrecioDelivery(subtotal);
                calcularTotalPedido();
            });

            $("#idPuntoRetiro").on("change",function(e){
                if($("#idPuntoRetiro").hasClass("selectError")){
                    $("#idPuntoRetiro").removeClass("selectError");
                }    
                var infoDelPdR = $("option:selected",this).attr("data-domiciliohorario");
                $("#datosPuntoDeRetiro").html(infoDelPdR);
                $(".infoAdicionalPdR").show();
            }); 
    
            $("#bFinalizarPedido").on("click",function(e){
                var isMobile = detectMobile();
                if(checkForm() && checkConfiguracionPedido()){
                    $(this).prop("disabled", true);
                    validationsAndSubmit();
                }else if(!checkForm()){
                    if(isMobile) {
                        scrollToTargetAdjusted("datosPedido");
                    } 
                } else {
                    if(isMobile) {
                        scrollToTargetAdjusted("errorBolsonIndividual");
                    }
                }
            });

            $("#bContinuarPedidoFueraHorario").on("click",function(e){
                $(this).prop("disabled", true);
                e.preventDefault();
                eboSubmit();
            });

            $("#modalAvisoPedidosCargados").on("hide.bs.modal",function(){
                $(".loading").hide();
            });

            $("#bContinuarConPedido").on("click",function(e){
                $("#modalAvisoPedidosCargados").modal("hide");
                validationsAndSubmit();
            });
        
            $("#bWhatsapp").on("click",function(e){
                $(".loading").hide();
                window.open("https://wa.me/+5491131816011?text=Hola,%20quiero%20hacer%20cambios%20en%20mi%20pedido%20por%20favor.","_blank");
            });
        
            $("#bCancelarPedido").on("click",function(e){
                $("#modalAvisoPedidosCargados").modal("hide");
                window.open("https://www.instagram.com/elbrotetienda/","_self");
            });     
            
            $(".close, .closeAvisoPedidosCargados").on("click",function(e){
                $("#modalAvisoPedidosCargados").modal("hide");
                $("#bRealizarPedido").prop("disabled",true);
            });
    
            $(".close, .closeAvisoPedidoSinBolson").on("click",function(e){
                $("#modalImagenBolson").modal("hide");
                $("#bRealizarPedido").prop("disabled",true);
            });

            $(".close, .closeDiaEntregaSinBolsonShort").on("click",function(e){
                $("#modalDiaEntregaSinBolsonShort").modal("hide");
            });

            $(".closeAvisoPedidosFueraHorario").on("click",function(e){
                $("#modalAvisoPedidosFueraHorario").modal("hide");
            });

            $('#modalExtrasCantError').on('hidden.bs.modal', function (e) {
                $("#bFinalizarPedido").prop("disabled", false);
            });

            $('#modalAvisoPedidosFueraHorario').on('hidden.bs.modal', function (e) {
                $("#bFinalizarPedido").prop("disabled", false);
                $("#bContinuarPedidoFueraHorario").prop("disabled", false);
            });
            
            $(".closeExtrasCantError").on("click",function(e){
                cerrarModalErroresExtras();
            });

            $("#bDiaEntregaSinBolsonShort").on("click",function(e) {
                $("#modalDiaEntregaSinBolsonShort").modal("hide");
            });

            $("#bAgregarBolson").on("click",function(e){
                e.preventDefault();
                cerrarModalImagenBolson();
                scrollToTargetAdjusted("comboFamiliar");
                $(".loading").hide();
            });
            
            $("#bContinuarPedido").on("click",function(e){
                e.preventDefault();
                cerrarModalImagenBolson();
                var responseSearch = searchOrdersDuplicadas($("#mail").val(),$("#celular").val());
                if(responseSearch.existePedidoCargado){
                    $("#labelAvisoPedidosCargadosDiaBolson").html(responseSearch.diaBolson);
                    $("#modalAvisoPedidosCargados").modal("show");
                }
            });    

            $("#bDiaEntregaDisabled").on("click",function(e){
                rebootWeb();
            });

            $("#bExtrasCantErrorAceptar").on("click", function(e){
                cerrarModalErroresExtras();
                scrollToTargetAdjusted("seccionResumenPedido");
            });

            initMasMenosCantProductoResumen();
        } else {
            hideSections();
            initMarketDiferencial();
        }

        $("#bEnviarNewsletter").on("click",function(e) {
            newsletterSuscribe();
        });

        $("#bCloseNewsletter").on("click",function(e){
            e.preventDefault();
            hideNewsletter();
        });

        $('#modalNewsletter').on('hidden.bs.modal', function (e) {
            $("#newsletterMail").val("");
        });
        
        if(newsletterEnabled()) {
            showNewsletter();
        }

        if(cuponesEnabled()) {
            showModuloCupones();
        }

        $("#cuponDescuento").on("focus",function(e) {
            e.preventDefault();
            $("#errorCuponDescuento").html("");
            $("#successCuponDescuento").html("");
        })

        $("#dTiposEntregaButtons").show();
        $("#tipoPedidoOrden").html("Seleccioná un método de entrega.");
        $("#pErrorDiaEntrega").html("");
        $("#messageProductoEliminado").html("");
        $("#messageProductoEliminado").hide();            
        loadDiaEntregaConfig($(this).val());
        
        $("#bCambiarTipoPedido").on("click", function(e){
            e.preventDefault();
            $("#idDiaEntrega").change();
            $("#tipoPedidoOrden").html("Seleccioná un método de entrega.");
            disabledExtras = [];
            idTipoPedidoSelected = 0;
            $("#modalExtraDisabledTipoPedido").modal("hide");
        });

        $("#bEliminarProductosPedido").on("click", function(e) {
            e.preventDefault();
            deleteDisabledExtras();

            $("#messageProductoEliminado").html("Los productos fueron eliminados del pedido. Para continuar toca Finalizar Compra");
            $("#messageProductoEliminado").show();
            $("#modalExtraDisabledTipoPedido").modal("hide");
            scrollToTargetAdjusted('seccionResumenPedido');                 
        });

        //ES PARA QUE NO PUEDAN HACER CLICK POR FUERA DEL MODAL
        $('#modalDiaEntregaSinBolson').modal({backdrop: 'static', keyboard: false}) 
        $('#modalExtraDisabledTipoPedido').modal({backdrop: 'static', keyboard: false}) 

        $("#bCambiarDiaEntrega").on("click",function(e) {
            e.preventDefault();
            cambiarDiaEntrega();
        });

        $("#bEliminarBolsonesPedido").on("click",function(e) {
            e.preventDefault();
            eliminarBolsonesDelPedido();
        });
});


function scrollToTargetAdjusted(id){
    var element = document.getElementById(id);
    var offset = 150;
    var top = 0;
    var left = 0;
    while(element.tagName != "BODY") {
        top += element.offsetTop;
        left += element.offsetLeft;
        element = element.offsetParent;
    }

    window.scrollTo({
         top: top - offset,
         behavior: "smooth"
    });
}

function initMarket(){
    var cExtras = getMarket();
    drawMarket(cExtras);
    initMarketRadioButtons();
}

function initMarketDiferencial(){
    var cExtras = getMarket();
    drawMarketDiferencal(cExtras);
}

function showExtrasErrors(aErrors) {
    var htmlErrors = "";
    var extraName = "";
    var hayStock = "quedan ";
    var noHayStock = "no hay stock";

    aErrors.forEach(error => {
        extraName = error.name    
        htmlErrors += "<li>" + extraName + ": "; 
        if(error.stock_left>0) {
            htmlErrors += "<span class='span-green'><b>" + hayStock + error.stock_left;
        } else { 
            htmlErrors += "<span class='span-red'><b>" + noHayStock;
        }
        htmlErrors += "</b></span></li>";
    });

    $("#erroresExtrasList").html(htmlErrors);
    $("#modalExtrasCantError").modal("show");
}

function validationsAndSubmit() {
/*  var response_extras_enabled = verifyExtrasEnabledByTipoPedido(idTipoPedidoSelected);
    if(response_extras_enabled.extras_enabled) {
        */
        if(checkTiendaOpen()) { 
            var response = validateExtrasQuantities();
            if(response.continue) {
                var tiendaFueraDeHorario = getTiendaFueraDeHorario();
                if(!tiendaFueraDeHorario) {
                    eboSubmit();
                } else {
                    setFueraDeHorarioMessage();
                    $("#modalAvisoPedidosFueraHorario").modal("show");
                }
            } else{
                showExtrasErrors(response.error);
            }
        } else {
            $("#modalDiaEntregaDisabled").modal("show");
        }            
    /*
    } else {
        var errores = "";
        for(var i=0; i<response_extras_enabled.errores.length; i++) {
            errores += "<li> * " + response_extras_enabled.errores[i].name + "</li>";
            disabledExtras.push(response_extras_enabled.errores[i].id_extra);
        }
        $("#erroresExtrasDisabled").html(errores);        
        $("#modalExtraDisabledTipoPedido").modal("show");                    
    } 
    */   
}

function getTiendaFueraDeHorario() {
    var fueraHorario = false;
    $.ajax({
        url: baseURL + 'get_tienda_fuera_horario',
        method: 'get',
        async: false
    }).done(function(result) {
        if(result.fuera_horario!=null) {
            fueraHorario = result.fuera_horario;
        }
    });
    return fueraHorario;
}

function validateExtrasQuantities() {
    var response = {};
    var data = {
        "extras" :JSON.stringify(aExtras)
    }
    $.ajax({
        url: baseURL + 'verify_extras_quantities_to_submit',
        method: 'post',
        data: data,
        async: false
    }).done(function(result) {
        response = result;
    });
    return response;
}

function getMarket(){
    var cExtras = [];
    $.ajax({
        url: baseURL + 'getExtras',
        method: 'post',
        async: false
    }).done(function(result) {
        if(result.cExtras!=null) {
            cExtras = result.cExtras;
        }
    });
    return cExtras;
}


function getMarketByTipoPedido(idTipoPedido){
    var cExtras = [];
    let data = {
        'idTipoPedido' : idTipoPedido
    };
    $.ajax({
        url: baseURL + 'getExtrasByTipoPedido',
        data: data,
        method: 'post',
        async: false
    }).done(function(result) {
        if(result.cExtras!=null) {
            cExtras = result.cExtras;
            //console.log(cExtras);
        }
    });
    return cExtras;
}

function drawMarketDiferencal(cExtras){
    if(cExtras!=null && cExtras.length>0){
        var html = '';
        for(var i=0;i<cExtras.length;i++){
            html += '<div id="tienda-'+cExtras[i].id+'" class="custom-col-5 mb-40">';
                html += '<div class="product-wrap-2 mb-25 scroll-zoom">';
                    html += '<div class="product-img">';
                        html += '<div>';
                            //<!--<img class="default-img" src="assets/new_design/assets/img/product/hm3-pro-1.jpg" alt="">-->
                            html += '<img class="default-img" src="assets/img/extras/'+cExtras[i].imagen+'" alt="">';
                            html += '<img class="hover-img" src="assets/img/extras/'+cExtras[i].imagen+'" alt="">';
                        html += '</div>';
                        //html += '<span class="pink">-10%</span>';
                        html += '<div class="product-action-2">';
                            //html += '<a title="Add To Cart" href="#"><i class="fa fa-shopping-cart"></i></a>';
                            //html += '<a title="Quick View" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a>';
                            //html += '<a title="Compare" href="#"><i class="fa fa-retweet"></i></a>';
                        html += '</div>';
                    html += '</div>';
                    html += '<div class="product-content-2">';
                        html += '<div class="title-price-wrap-2">';
                            html += '<h5 style="min-height:45px;font-size:16px;">'+cExtras[i].name+'</h5>';
                            html += '<div class="price-2">';
                                html += '<span>Precio Unitario: $<label id="precioUnitarioExtra'+cExtras[i].id+'">'+cExtras[i].price+'</span>';
                                //html += '<span class="old">$ 60.00</span>';
                            html += '</div>';
                            html += '<div class="price-2">';
                                //html += '<span><b>Total: $<label id="extra'+cExtras[i].id+'Total">0</b></span>';
                            html += '</div>';

                        html += '</div>';
                        html += '<div class="pro-wishlist-2">';
                            //html += '<a title="Wishlist" href="wishlist.html"><i class="fa fa-heart-o"></i></a>';
                        html += '</div>';
                    html += '</div>';
                html += '</div>';
            html += '</div>';
        }
        $("#marketContainer").html(html);
    }    
}

function drawMarket(cExtras){
    if(cExtras!=null && cExtras.length>0){
        var html = '';
        for(var i=0;i<cExtras.length;i++){
            html += '<div id="tienda-'+cExtras[i].id+'" class="custom-col-5 mb-40">';
                html += '<div class="product-wrap-2 mb-25 scroll-zoom">';
                    html += '<div class="product-img">';
                        html += '<div>';
                            //<!--<img class="default-img" src="assets/new_design/assets/img/product/hm3-pro-1.jpg" alt="">-->
                            html += '<img class="default-img" src="assets/img/extras/'+cExtras[i].imagen+'" alt="">';
                            html += '<img class="hover-img" src="assets/img/extras/'+cExtras[i].imagen+'" alt="">';
                        html += '</div>';
                        //html += '<span class="pink">-10%</span>';
                        html += '<div class="product-action-2">';
                            //html += '<a title="Add To Cart" href="#"><i class="fa fa-shopping-cart"></i></a>';
                            //html += '<a title="Quick View" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a>';
                            //html += '<a title="Compare" href="#"><i class="fa fa-retweet"></i></a>';
                        html += '</div>';
                    html += '</div>';
                    html += '<div class="product-content-2">';
                        html += '<div class="title-price-wrap-2">';
                            html += '<h3 style="min-height:45px;"><a href="javascript:selectOneFromExtra('+cExtras[i].id+')">'+cExtras[i].name+'</a></h3>';
                            html += '<div class="price-2">';
                                html += '<span>Precio Unitario: $<label id="precioUnitarioExtra'+cExtras[i].id+'">'+cExtras[i].price+'</span>';
                                //html += '<span class="old">$ 60.00</span>';
                            html += '</div>';
                            html += '<div class="price-2">';
                                html += '<span><b>Total: $<label id="extra'+cExtras[i].id+'Total">0</b></span>';
                            html += '</div>';

                            html += '<div class="product-details-content mt-10">';
                                html += '<div class="pro-details-size-color">';
                                    html += '<div class="pro-details-size">';
                                        html += '<span>Elegir Cantidad</span>';
                                        html += '<div class="pro-details-size-content boxed">';
                                            html += '<ul>';
                                                html += '<li>';
                                                    if(parseInt(cExtras[i].stock_ilimitado) == 1 || 1<= parseInt(cExtras[i].stock_disponible)) {
                                                        html += '<input type="radio" id="rbExtras'+cExtras[i].id+'-1" data-extraName="'+cExtras[i].name+'" data-extraId="'+cExtras[i].id+'" data-lastCant="0" data-extraImg="'+cExtras[i].imagen+'" name="rbExtras'+cExtras[i].id+'" class="rbExtras option-disabled" value="1">';
                                                        html += '<label for="rbExtras'+cExtras[i].id+'-1">1</label>';
                                                    }else{
                                                        html += '<label class="optionDisabled" for="rbExtras'+cExtras[i].id+'-1">1</label>';
                                                    }
                                                html += '</li>';
                                                html += '<li>';
                                                    if(parseInt(cExtras[i].stock_ilimitado) == 1 || 2<= parseInt(cExtras[i].stock_disponible)) {
                                                        html += '<input type="radio" id="rbExtras'+cExtras[i].id+'-2" data-extraName="'+cExtras[i].name+'" data-extraId="'+cExtras[i].id+'" data-lastCant="0" data-extraImg="'+cExtras[i].imagen+'" name="rbExtras'+cExtras[i].id+'" class="rbExtras" value="2">';
                                                        html += '<label for="rbExtras'+cExtras[i].id+'-2">2</label>';
                                                    }else {
                                                        html += '<label class="optionDisabled" for="rbExtras'+cExtras[i].id+'-2">2</label>';
                                                    }
                                                html += '</li>';
                                                html += '<li>';
                                                    if(parseInt(cExtras[i].stock_ilimitado) == 1 || 3<= parseInt(cExtras[i].stock_disponible)) {
                                                        html += '<input type="radio" id="rbExtras'+cExtras[i].id+'-3" data-extraName="'+cExtras[i].name+'" data-extraId="'+cExtras[i].id+'" data-lastCant="0" data-extraImg="'+cExtras[i].imagen+'" name="rbExtras'+cExtras[i].id+'" class="rbExtras" value="3">';
                                                        html += '<label for="rbExtras'+cExtras[i].id+'-3">3</label>';
                                                    } else {
                                                        html += '<label class="optionDisabled" for="rbExtras'+cExtras[i].id+'-3">3</label>';
                                                    }
                                                html += '</li>';
                                                html += '<li>';
                                                    if(parseInt(cExtras[i].stock_ilimitado) == 1 || 4<= parseInt(cExtras[i].stock_disponible)) {
                                                        html += '<input type="radio" id="rbExtras'+cExtras[i].id+'-4" data-extraName="'+cExtras[i].name+'" data-extraId="'+cExtras[i].id+'" data-lastCant="0" data-extraImg="'+cExtras[i].imagen+'" name="rbExtras'+cExtras[i].id+'" class="rbExtras" value="4">';
                                                        html += '<label for="rbExtras'+cExtras[i].id+'-4">4</label>';
                                                    } else {
                                                        html += '<label class="optionDisabled" for="rbExtras'+cExtras[i].id+'-4">4</label>';
                                                    }
                                                html += '</li>';
                                                html += '<li>';
                                                    if(parseInt(cExtras[i].stock_ilimitado) == 1 || 5<= parseInt(cExtras[i].stock_disponible)) {
                                                        html += '<input type="radio" id="rbExtras'+cExtras[i].id+'-5" data-extraName="'+cExtras[i].name+'" data-extraId="'+cExtras[i].id+'" data-lastCant="0" data-extraImg="'+cExtras[i].imagen+'" name="rbExtras'+cExtras[i].id+'" class="rbExtras" value="5">';
                                                        html += '<label for="rbExtras'+cExtras[i].id+'-5">5</label>';
                                                    } else {
                                                        html += '<label class="optionDisabled" for="rbExtras'+cExtras[i].id+'-5">5</label>';
                                                    }
                                                html += '</li>';
                                            html += '</ul>';
                                        html += '</div>';
                                    html += '</div>';
                                html += '</div>';
                            html += '</div>';


                        html += '</div>';
                        html += '<div class="pro-wishlist-2">';
                            //html += '<a title="Wishlist" href="wishlist.html"><i class="fa fa-heart-o"></i></a>';
                        html += '</div>';
                    html += '</div>';
                html += '</div>';
            html += '</div>';
        }
        $("#marketContainer").html(html);
    }
}

function clearDomicilioForm(){
    $("#idBarrio").val(-1);
    $("#domicilio").val("");
    $("#domicilioPisoDepto").val("");
    $("#pErrorDomicilio").html("");
}

function clearPuntosDeRetiroForm(){
    $("#idPuntoRetiro").val(-1);
}

function prepareFormOrderByTipoPedido(idTipoPedido){
    var tipoPedido = "";
    idTipoPedidoSelected = idTipoPedido;
    $(".cart-btn-tipo-pedido").removeClass("buttonSelected");
    $("#pErrorTipoPedido").html("");
    $("#errorBolsonIndividual").html("");
    $("#datosPuntoDeRetiro").html("");
    $(".infoAdicionalPdR").hide();
    if(idTipoPedido==1){
        //PUNTO DE RETIRO
        tipoPedido = "PUNTO DE RETIRO";
        clearDomicilioForm();
        preparePuntosDeRetiro();
        setValorEnvioCero();
    }else if(idTipoPedido==2){
        //DOMICILIO
        tipoPedido = "DOMICILIO";
        clearPuntosDeRetiroForm();
        prepareBarrios();
        //calcularPrecioDelivery();
    }
    calcularTotalPedido();
    $("#tipoPedidoOrden").html(tipoPedido)
}

function verifyExtrasEnabledByTipoPedido(idTipoPedido) {
    var response = {};
    var data = {
        "extras" :JSON.stringify(aExtras),
        "id_tipo_pedido": idTipoPedido
    }
    $.ajax({
        url: baseURL + 'verifyExtrasEnabledByTipoPedido',
        method: 'post',
        data: data,
        async: false
    }).done(function(result) {
        response = result;
    });
    return response;
}

function preparePuntosDeRetiro(){
    var cPuntosDeRetiro = getPuntosDeRetiro();
    if(cPuntosDeRetiro!=null && cPuntosDeRetiro.length>0){
        var html = "";
        html += "<option value='-1'>--Seleccione--</option>";
        for(var i=0;i<cPuntosDeRetiro.length;i++){
            html += "<option data-domicilioHorario='"+cPuntosDeRetiro[i].address+"' value='"+cPuntosDeRetiro[i].id+"'>"+cPuntosDeRetiro[i].name+" - "+cPuntosDeRetiro[i].address+"</option>";
        }
        $("#idPuntoRetiro").html(html);
    }
    $("#bPuntosRetiro").addClass("buttonSelected");
    $(".input-datos-pedido-domicilio").css("display","none");
    $(".input-datos-pedido-puntoretiro").css("display","block");

    //setValorReserva($("#totalPedido").html());

    $("#liResumenPedidoEnvio").hide()
    $("#liResumenPedidoReserva").show()
}

function prepareBarrios(){
    var cBarrios = getBarriosHabilitados();
    var html = "<option value='-1'>-- Seleccione --</option>";
    if(cBarrios!=null && cBarrios.length>0){
        for(var i=0;i<cBarrios.length;i++){
            html += "<option data-horarioEntrega='"+cBarrios[i].observaciones+"' value='"+cBarrios[i].id+"'>"+cBarrios[i].nombre+"</option>";
        }
    }
    $("#idBarrio").html(html);
    $("#bDomicilio").addClass("buttonSelected");
    $(".input-datos-pedido-puntoretiro").css("display","none");
    $(".input-datos-pedido-domicilio").css("display","block");
    $("#valorReservaPedido").html(0);    
    $("#liResumenPedidoReserva").hide()
    $("#liResumenPedidoEnvio").show();
}

function getPuntosDeRetiro(){
    var cPuntosDeRetiro = [];
    $.ajax({
        url: baseURL + 'getPuntosDeRetiro',
        method: 'post',
        async: false
    }).done(function(result) {
        if(result.cPuntosDeRetiro!=null) {
            cPuntosDeRetiro = result.cPuntosDeRetiro;
        }
    }).fail( function( jqXHR, textStatus, errorThrown ) {
        
        //console.log( jqXHR );
    });
    return cPuntosDeRetiro;
}

function getBarrios(){
    var cBarrios = [];
    $.ajax({
        url: baseURL + 'getBarrios',
        method: 'post',
        async: false
    }).done(function(result) {
        if(result.cBarrios!=null) {
            cBarrios = result.cBarrios;
        }
    });
    return cBarrios;
}

function getBarriosHabilitados(){
    var cBarriosHabilitados = [];
    var data = {
        "idDiaEntrega": $("#idDiaEntrega").val()
    }
    $.ajax({
        url: baseURL + 'getBarriosHabilitados',
        method: 'post',
        data: data,
        async: false
    }).done(function(result) {
        if(result.cBarriosHabilitados!=null) {
            cBarriosHabilitados = result.cBarriosHabilitados;
        }
    });
    return cBarriosHabilitados;
}

function removeExtraFromArray(idExtra){
    // get index of object with id of 37
    var removeIndex = aExtras.findIndex( oExtra => oExtra.idExtra == idExtra );
    // remove object
    if(removeIndex>-1){
        aExtras.splice( removeIndex, 1 );
    }
}

function addExtraToArray(idExtra,cantExtra,precio, total,extraName,extraImg){
    var oExtra = {
        "idExtra"       : idExtra,
        "extraName"     : extraName,
        "cantExtra"     : cantExtra,
        "precioUnitario": precio,
        "total"         : total,
        "extraImg"      : extraImg
    }
    aExtras.push(oExtra);
    sortExtrasArray("idExtra",true);
}

function sortExtrasArray(prop, asc) {
    aExtras.sort(function(a, b) {
        if (asc) {
            return (a[prop] > b[prop]) ? 1 : ((a[prop] < b[prop]) ? -1 : 0);
        } else {
            return (b[prop] > a[prop]) ? 1 : ((b[prop] < a[prop]) ? -1 : 0);
        }
    });
}

function initMarketRadioButtons(){
    $(".rbExtras").on("click",function(){
        var idExtra = $(this).attr("data-extraid");
        var extraName = $(this).attr("data-extraName");
        var extraImg = $(this).attr("data-extraImg");
        var cant = $(this).val();
        var precio = $("#precioUnitarioExtra"+idExtra).html();
        var lastCant = $(this).attr("data-lastCant");
        var total = 0;
        precio = parseInt(precio);


        total = precio * cant;
        //Remuevo por las dudas si es que esta el extra primero y despues agrego, ya que puede estar con una cantidad X y entra a este else porque ahora tiene cantidad Y.
        removeExtraFromArray(idExtra);
        addExtraToArray(idExtra,cant,precio,total,extraName,extraImg);

        refreshCart();
        $("#extra"+idExtra+"Total").html(total);
        getResumenPedido();
        if(!window.matchMedia("(max-width: 767px)").matches){
            if(!$('.shopping-cart-content').hasClass("cart-visible")){
                $('.shopping-cart-content').toggleClass('cart-visible');
                setTimeout(function(){
                    $('.shopping-cart-content').toggleClass('cart-visible');
                },3000);
            }
        }
        mostrarFinalizarCompra();
    });      
}

function getResumenPedido(){
    var html = "";
    calcularTotalPedido();
}   

function setTotalPedido(total){
    $("#valorTotalPedido").html(total);
}

function setSubTotalPedido(subtotal){
    $("#totalPedido").html(subtotal);
    $("#subtotalHeader").html(subtotal);
}

function calcularFormaDePago(total) {
    var cFormasPago = getFormasPagoByTotal(total);
    populateFormasPago(cFormasPago);
}

function populateFormasPago(cFormasPago){
    $("#idFormaPago").empty();
    var options = "";
    for(var i=0;i<cFormasPago.length;i++) {
        options += "<option value='"+cFormasPago[i].id+"'>"+cFormasPago[i].descripcion+"</option>";
    }
    $("#idFormaPago").html(options);
}

function getFormasPagoByTotal(total){
    var cFormasPago;
    let data = {
        'importe_total' : total
    };
    $.ajax({
        url: baseURL + 'getFormasDePago',
        data: data,
        method: 'post',
        async: false
    }).done(function(result) {
        cFormasPago = result.cFormasPago;
    });
    return cFormasPago;        
}

function calcularTotalPedido(){
    var cantBolson = 0;
    var totalExtras = parseFloat(0);
    var subtotal = parseFloat(0);
    var total = parseFloat(0);
    var precioBolson  = 0;
    var precioDelivery = 0;

    cantBolson = $('input[name=rbBolson]:checked').val();    
    if(cantBolson>0){
        precioBolson = parseFloat(getPrecioBolson()) * cantBolson;
    }

    for(var i=0;i<aExtras.length;i++){
        totalExtras = totalExtras + parseFloat(aExtras[i].total);
    }
    subtotal = precioBolson + totalExtras;

    precioDelivery = calcularPrecioDelivery(subtotal);
    
    /*

    var valorReserva = 0;
    if(idTipoPedidoSelected>0){
        if(idTipoPedidoSelected==1){
            valorReserva = getValorReservaByValorInRango(subtotal);
        }else{
            if($("#idBarrio").val() > 0) {
                precioDelivery = calcularPrecioDelivery(subtotal);
                if(precioDelivery == 0){
                    valorReserva = getValorReservaByValorInRango(subtotal)
                }    
            } 
        }
    }
    total = subtotal - valorReserva;

    */

    var montoDescuento = 0;
    var cuponAplicado = $("#cuponAplicado").val();
    if(cuponAplicado==1) {
        var codigo = $("#cuponDescuento").val();
        var cupon = getCuponByCodigo(codigo);
        if(cupon.idTipoDescuento==1) {
            //si es monto fijo
            montoDescuento = cupon.descuento;
        } else {
            montoDescuento = Math.ceil((subtotal*cupon.descuento)/100);
        }
    }

    total = subtotal + precioDelivery - montoDescuento;
    calcularFormaDePago(total);
    //setValorReserva(valorReserva);
    setSubTotalPedido(subtotal);
    setTotalPedido(total);
    setMontoDescuento(montoDescuento);

    return total;
}

function setMontoDescuento(montoDescuento) {
    if(montoDescuento>0) {
        $("#valorMontoCuponDescuento").html("-$"+montoDescuento);
        $("#liResumenPedidoCuponDescuento").show();
    } else {
        $("#liResumenPedidoCuponDescuento").hide();
        $("#valorMontoCuponDescuento").html("");
    }
    
}

function calcularPrecioDelivery(subtotal){
    var costoDelivery = 0;
    var idBarrio = $("#idBarrio").val();
    if(idTipoPedidoSelected==2 && idBarrio>0){
        if(!isTotalGreaterThanMontoMinimoEnvioSinCargo(subtotal)){
            //costoDelivery = getCostoDeEnvioDomicilio();
            costoDelivery = getCostoEnvioByBarrio();
        }
        costoDelivery = parseFloat(costoDelivery);

        if(costoDelivery > 0){
            $("#tituloEnvioPedido").css("text-decoration","none");
            $("#agregadoTituloEnvioPedido").html("")
            //$("#mensajeReservaCostoEnvio").show();
            //$("#liResumenPedidoReserva").hide();
        }else{
            $("#tituloEnvioPedido").css("text-decoration","line-through");
            $("#agregadoTituloEnvioPedido").html(" Bonificado!")
            $("#agregadoTituloEnvioPedido").css("text-decoration","none");
            //$("#mensajeReservaCostoEnvio").hide();
            //$("#liResumenPedidoReserva").show();
        }
        $("#valorEnvioDomicilio").html(costoDelivery);
    }else{
        setValorEnvioCero();
    }
    return costoDelivery;
}

function setValorReserva(valorReserva){
    $("#valorReservaPedido").html(valorReserva);
    if(valorReserva==0){
        $("#mensajeReservaReserva").html("Pedido Sin Reserva");
    } else {
        $("#mensajeReservaReserva").html("Monto a abona en MercadoPago.");
    }
}

function getValorReservaByValorInRango(subtotal){
    var valorReserva = 0;
    subtotal = parseInt(subtotal)
    let data = {
        'monto' : subtotal
    };
    $.ajax({
        url: baseURL + 'getValorReservaByValorInRango',
        data: data,
        method: 'post',
        async: false
    }).done(function(result) {
        valorReserva = result.valorReserva;
    });
    return valorReserva;    
}

function refreshCart(){
    var htmlCarrito = "";
    var htmlCarritoMobile = "";
    var htmlResumenHeader = "";
    var imagenBolson = $("#imgBolsonPortada").prop("src");

    if(oBolson){
        htmlCarrito += '<tr>';
        htmlCarrito += '<td class="product-thumbnail">';
        htmlCarrito += '<a href="#"><img class="ebo-cart-img" src="'+imagenBolson+'" alt=""></a>';
        htmlCarrito += '</td>';
        htmlCarrito += '<td class="product-name">'+oBolson.name+'</td>';
        htmlCarrito += '<td class="product-price-cart"><span class="amount">$'+oBolson.precioUnitario+'</span></td>';
        htmlCarrito += '<td class="product-quantity">';
        htmlCarrito += '<div class="cart-plus-minus">';
        htmlCarrito += '<div class="dec qtybutton resumenpedido-bolson-qty" data-idproducto="'+oBolson.idBolson+'">-</div>';
        htmlCarrito += '<input class="cart-plus-minus-box" id="resumenCantProductoBolson'+oBolson.idBolson+'" type="text" name="qtybutton" value="'+oBolson.cant+'" disabled>';
        htmlCarrito += '<div class="inc qtybutton resumenpedido-bolson-qty" data-idproducto="'+oBolson.idBolson+'">+</div>';
        htmlCarrito += '</div>';
        htmlCarrito += '</td>';
        htmlCarrito += '<td class="product-subtotal">$'+oBolson.total+'</td>';
        htmlCarrito += '<td class="product-remove">';
        htmlCarrito += '<a href="javascript:scrollToTargetAdjusted(\'producto1-'+oBolson.idBolson+'\');"><i class="fa fa-pencil"></i></a>';
        htmlCarrito += '<a href="javascript:deleteBolsonFromCarrito('+oBolson.idBolson+')"><i class="fa fa-times"></i></a>';
        htmlCarrito += '</td>';
        htmlCarrito += '</tr>';

        htmlCarritoMobile += '<tr>';
        htmlCarritoMobile += '<td class="product-name">'+oBolson.name+'</td>';
        htmlCarritoMobile += '<td class="product-quantity">';
        htmlCarritoMobile += '<div class="cart-plus-minus">';
        htmlCarritoMobile += oBolson.cant;
        htmlCarritoMobile += '</div>';
        htmlCarritoMobile += '</td>';
        htmlCarritoMobile += '<td class="product-subtotal">$'+oBolson.total+'</td>';
        htmlCarritoMobile += '<td class="product-remove">';
        htmlCarritoMobile += '<a href="javascript:scrollToTargetAdjusted(\'producto1-'+oBolson.idBolson+'\');"><i class="fa fa-pencil"></i></a>';
        htmlCarritoMobile += '<a href="javascript:deleteBolsonFromCarrito('+oBolson.idBolson+')"><i class="fa fa-times"></i></a>';
        htmlCarritoMobile += '</td>';
        htmlCarritoMobile += '</tr>';

        //CARRITO RESUMEN DEL BOTON DEL HEADER
        htmlResumenHeader += '<li class="single-shopping-cart">';
        htmlResumenHeader += '<div class="shopping-cart-img">';
        htmlResumenHeader += '<a href="#"><img class="ebo-cart-header-img" alt="" src="'+imagenBolson+'"></a>';
        htmlResumenHeader += '</div>';
        htmlResumenHeader += '<div class="shopping-cart-title">';
        htmlResumenHeader += '<h4>'+oBolson.name+'</h4>';
        htmlResumenHeader += '<h6>Cantidad: '+oBolson.cant+'</h6>';
        htmlResumenHeader += '<span>$'+oBolson.total+'</span>';
        htmlResumenHeader += '</div>';
        htmlResumenHeader += '<div class="shopping-cart-delete">';
        htmlResumenHeader += '<a href="javascript:deleteBolsonFromCarrito('+oBolson.idBolson+')"><i class="fa fa-times-circle"></i></a>';
        htmlResumenHeader += '</div>';
        htmlResumenHeader += '</li>';
        
    }

    if(aExtras.length>0){
        for(var i=0;i<aExtras.length;i++){

            //CARRITO RESUMEN DE ABAJO DE LA WEB
            htmlCarrito += '<tr>';
            htmlCarrito += '<td class="product-thumbnail">';
            htmlCarrito += '<img class="ebo-cart-img" src="assets/img/extras/'+aExtras[i].extraImg+'" alt="">';
            htmlCarrito += '</td>';
            htmlCarrito += '<td class="product-name">'+aExtras[i].extraName+'</td>';
            htmlCarrito += '<td class="product-price-cart"><span class="amount">$'+aExtras[i].precioUnitario+'</span></td>';
            htmlCarrito += '<td class="product-quantity">';
            htmlCarrito += '<div class="cart-plus-minus">';
            htmlCarrito += '<div class="dec qtybutton resumenpedido-qty" data-idproducto="'+aExtras[i].idExtra+'">-</div>';
            htmlCarrito += '<input class="cart-plus-minus-box" id="resumenCantProducto'+aExtras[i].idExtra+'" type="text" name="qtybutton" value="'+aExtras[i].cantExtra+'" disabled>';
            htmlCarrito += '<div class="inc qtybutton resumenpedido-qty" data-idproducto="'+aExtras[i].idExtra+'">+</div>';
            htmlCarrito += '</div>';
            htmlCarrito += '</td>';
            htmlCarrito += '<td class="product-subtotal">$'+aExtras[i].total+'</td>';
            htmlCarrito += '<td class="product-remove">';
            htmlCarrito += '<a href="javascript:scrollToTargetAdjusted(\'tienda-'+aExtras[i].idExtra+'\');"><i class="fa fa-pencil"></i></a>';
            htmlCarrito += '<a href="javascript:deleteProduct('+aExtras[i].idExtra+')"><i class="fa fa-times"></i></a>';
            htmlCarrito += '</td>';
            htmlCarrito += '</tr>';

            //CARRITO RESUMEN DE ABAJO DE LA WEB MOBILE
            htmlCarritoMobile += '<tr>';
            htmlCarritoMobile += '<td class="product-name">'+aExtras[i].extraName+'</td>';
            htmlCarritoMobile += '<td class="product-quantity">';
            htmlCarritoMobile += '<div class="cart-plus-minus">';
            htmlCarritoMobile += aExtras[i].cantExtra;
            htmlCarritoMobile += '</div>';
            htmlCarritoMobile += '</td>';
            htmlCarritoMobile += '<td class="product-subtotal">$'+aExtras[i].total+'</td>';
            htmlCarritoMobile += '<td class="product-remove">';
            htmlCarritoMobile += '<a href="javascript:scrollToTargetAdjusted(\'tienda-'+aExtras[i].idExtra+'\');"><i class="fa fa-pencil"></i></a>';
            htmlCarritoMobile += '<a href="javascript:deleteProduct('+aExtras[i].idExtra+')"><i class="fa fa-times"></i></a>';
            htmlCarritoMobile += '</td>';
            htmlCarritoMobile += '</tr>';

            //CARRITO RESUMEN DEL BOTON DEL HEADER
            htmlResumenHeader += '<li class="single-shopping-cart">';
            htmlResumenHeader += '<div class="shopping-cart-img">';
            htmlResumenHeader += '<img class="ebo-cart-header-img" alt="" src="assets/img/extras/'+aExtras[i].extraImg+'">';
            htmlResumenHeader += '</div>';
            htmlResumenHeader += '<div class="shopping-cart-title">';
            htmlResumenHeader += '<h4>'+aExtras[i].extraName+'</h4>';
            htmlResumenHeader += '<h6>Cantidad: '+aExtras[i].cantExtra+'</h6>';
            htmlResumenHeader += '<span>$'+aExtras[i].total+'</span>';
            htmlResumenHeader += '</div>';
            htmlResumenHeader += '<div class="shopping-cart-delete">';
            htmlResumenHeader += '<a href="javascript:deleteProduct('+aExtras[i].idExtra+')"><i class="fa fa-times-circle"></i></a>';
            htmlResumenHeader += '</div>';
            htmlResumenHeader += '</li>';

        }
    }

    var carritoCant = 0;
    if(oBolson){
        carritoCant=1;
    }
    carritoCant = carritoCant + aExtras.length;
    $("#eboCartCounter").html(carritoCant);
    if(htmlCarrito==""){
        htmlCarrito ="<tr><td colspan='6'>No hay items en el carrito</td></tr>";
    }
    $("#resumenPedidoBody").html(htmlCarrito);
    $("#resumenPedidoBodyMobile").html(htmlCarritoMobile);
    $("#ebo-cart-header").html(htmlResumenHeader);
    initMasMenosCantProductoResumen();
}

function deleteProduct(idProducto){
    if(idProducto==1){
        //SI ES EL EXTRA DEL BOLSON DE BASICOS
        $("input[type='radio'][class='rbBolsonBasico']").prop("checked",false);
        $("#bolsonBasicoTotal").html("0");
    }else{
        $("input[type='radio'][name='rbExtras"+idProducto+"']").prop("checked",false);
    }
    removeExtraFromArray(idProducto);
    refreshCart();
    $("#extra"+idProducto+"Total").html(0);

    getResumenPedido();
}

function selectBolsonCant(cant){
    $("#rbBolson-"+cant).click();
}

function selectBolsonBasicoCant(cant){
    $("#rbExtras1-"+cant).click();
}

function calcularSubtotalBolsonIndividual(cant){
    var precio = $("#precioUnitarioBolsonIndividual").html();
    var total = 0;
    precio = parseInt(precio);
    total = precio * cant;
    return total;
}

function calcularSubtotalBolsonBasico(cant){
    var precio = $("#precioUnitarioBolsonBasico").html();
    var total = 0;
    precio = parseInt(precio);
    total = precio * cant;
    return total;
}

function deleteBolsonFromCarrito(idBolson){
    oBolson = null;
    $("input[type='radio'][class='rbBolson']").prop("checked",false);
    $("#bolsonIndividualTotal").html("0");
    refreshCart();
    getResumenPedido();
}

function deleteDisabledExtras() {
    for(var i=0; i<disabledExtras.length; i++) {
        deleteProduct(disabledExtras[i]);
    }
    disabledExtras = [];
}

function goToAbout(){
    $.ajax({
        url: baseURL + 'about',
        method: 'post'
    });
}

function initMasMenosCantProductoResumen(){
    /*----------------------------
        Cart Plus Minus Button
    ------------------------------ */
    var CartPlusMinus = $('.cart-plus-minus');
    //CartPlusMinus.prepend('<div class="dec qtybutton">-</div>');
    //CartPlusMinus.append('<div class="inc qtybutton">+</div>');
    $(".resumenpedido-qty").on("click", function() {
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
        var newVal = oldValue;

        var idProducto = $(this).attr("data-idproducto");
        
        if ($button.text() === "+") {
            if(idProducto>1){
                if(parseFloat(oldValue) + 1 <=5){
                    newVal = parseFloat(oldValue) + 1;
                }
            }else{
                //ESTE ES EL BOLSON INDIVIDUAL
                if(parseFloat(oldValue) + 1 <=3){
                    newVal = parseFloat(oldValue) + 1;
                }
            }
        } else {
            // No permito restar si ya es 1. Para poner 0 hay que eliminar.
            if(parseFloat(oldValue) - 1 >=1){
                if (oldValue > 0) {
                    newVal = parseFloat(oldValue) - 1;
                }/* else {
                    newVal = 1;
                }*/
            }
        }

        productStock = validateExtraRequestedCant(newVal, idProducto);
        if(productStock['have_stock']) {
            $button.parent().find("input").val(newVal);
        } else {
            if(productStock['stock_disponible']>0) {
                $button.parent().find("input").val(productStock['stock_disponible']);
            }
        }
    });

    $(".resumenpedido-bolson-qty").on("click", function() {
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
        var newVal = oldValue;
        if ($button.text() === "+") {
            if(parseFloat(oldValue) + 1 <=3){
                newVal = parseFloat(oldValue) + 1;
            }
        } else {
            // No permito restar si ya es 1. Para poner 0 hay que eliminar.
            if(parseFloat(oldValue) - 1 >=1){
                if (oldValue > 0) {
                    newVal = parseFloat(oldValue) - 1;
                }/* else {
                    newVal = 1;
                }*/
            }
        }
        $button.parent().find("input").val(newVal);
    });

    $(".resumenpedido-qty").on("click",function(e){
        var idProducto = $(this).attr("data-idproducto");
        var cant = $("#resumenCantProducto"+idProducto).val();
        
        $("#rbExtras"+idProducto+"-"+cant).click();
    });
    
    $(".resumenpedido-bolson-qty").on("click",function(e){
        var $button = $(this);
        var cant = $button.parent().find("input").val();
        //var cant = $(this).val();
        $("#rbBolson"+"-"+cant).click();
    });
}

function finalizarCompra(){
    $('.shopping-cart-content').removeClass('cart-visible');
    scrollToTargetAdjusted('datosPedido');
}

function checkForm(){
    var formOK = true;
    if(idTipoPedidoSelected==0){
        $("#pErrorTipoPedido").html("Por favor, seleccioná un método de entrega.");
        formOK = false;
    }
    if($("#nombreApellido").val()==undefined || $("#nombreApellido").val()==""){
        //$("#nombreApellido").prop("placeholder","Por favor, ingresá tu nombre y apellido.");
        $("#pErrorNombreApellido").html("Por favor, ingresá tu nombre y apellido.");
        formOK = false;
    }
    if($("#mail").val()==undefined || $("#mail").val()==""){
        //$("#mail").prop("placeholder","Por favor, ingresá un correo electrónico válido.");
        $("#pErrorMail").html("Por favor, ingresá un correo electrónico válido.");
        formOK = false;
    }else{
        //Le saco los espacios por delante o atras que pueda tener el mail.
        $("#mail").val($.trim($("#mail").val()));
        if(!validEmail($("#mail").val())){
            //$("#mail").prop("placeholder","Por favor, ingresá un correo electrónico válido.");
            $("#pErrorMail").html("Por favor, ingresá un correo electrónico válido.");
            formOK = false;
        }
    }
    if($("#celular").val()==undefined || $("#celular").val()==""){
        //$("#celular").prop("placeholder","Solo se aceptan números, espacios y '+'.");
        $("#pErrorCelular").html("Solo se aceptan números, espacios y '+'.");
        formOK = false;
    }else{
        if(!validPhone($("#celular").val())){
            //$("#celular").prop("placeholder","Solo se aceptan números, espacios y '+'.");
            $("#pErrorCelular").html("Solo se aceptan números, espacios y '+'.");
            formOK = false;
        }
    }

    if(idTipoPedidoSelected==1){
        //SI ES PUNTOS DE RETIRO
        if($("#idPuntoRetiro").val()==-1){
            if(!$("#idPuntoRetiro").hasClass("selectError")){
                $("#idPuntoRetiro").addClass("selectError");
            }
            formOK = false;
        }
    }else if (idTipoPedidoSelected==2){
        if($("#idBarrio").val()==-1){
            if(!$("#idBarrio").hasClass("selectError")){
                $("#idBarrio").addClass("selectError");
            }
            formOK = false;
        }
        if($("#domicilio").val()==undefined || $("#domicilio").val()==""){
            //$("#nombreApellido").prop("placeholder","Por favor, ingresá tu nombre y apellido.");
            $("#pErrorDomicilio").html("Por favor, ingresá el domicilio de entrega.");
            formOK = false;
        }
    
    }
    return formOK;
}

function validEmail(input) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(input);
}

function validPhone(input) {
    var re= /^[\d ()+-]+$/;
    return re.test(input);
}

function getTipoPedidoHasPedidosExtrasHabilitado(){
    var tipoPedidoHasPedidosExtrasHabilitado = 0;
    let data = {
        'currentForm' : idTipoPedidoSelected
    };
    $.ajax({
        url: baseURL + 'getTipoPedidoHasPedidosExtrasHabilitado',
        data: data,
        method: 'post',
        async: false
    }).done(function(result) {
        tipoPedidoHasPedidosExtrasHabilitado = result.tipoPedidoHasPedidosExtrasHabilitado;
    });
    return tipoPedidoHasPedidosExtrasHabilitado;
}

//LA USAMOS PARA CONTROLAR QUE NO SE CARGUEN PEDIDOS UNA VEZ CERRADO EL DIA DE ENTREGA 
//COMO AHORA SE VA A ENTREGAR TODOS LOS DIAS, SIEMPRE VA A ESTAR HABILITADO
function checkDiaEntregaHabilitado(){
    var diaEntregaHabilitado = false;
    let idDiaEntrega = $("#idDiaEntrega").val();

    let data = {
        'idDiaEntrega': idDiaEntrega
    };
    $.ajax({
        url: baseURL + 'getDiaEntregaHabilitado',
        data: data,
        method: 'post',
        async: false
    }).done(function(result) {
        diaEntregaHabilitado = result.dia_entrega_enabled;
    });
    return diaEntregaHabilitado;    
}

function checkTiendaOpen(){
    var tiendaOpen = true;
    $.ajax({
        url: baseURL + 'getTiendaAbierta',
        method: 'get',
        async: false
    }).done(function(result) {
        tiendaOpen = result.tienda_open;
    });
    return tiendaOpen;    
}

function checkConfiguracionPedido(){
    //FUNCION PARA SABER SI ACEPTA O NO PEDIDOS SOLO DE EXTRAS EN BASE AL TIPO DE PEDIDO SELECCIONADO (PUNTO DE RETIRO / DOMICILIO)
    var configurationOK = true;
    var pedidosExtrasEnabled = getTipoPedidoHasPedidosExtrasHabilitado();
    //BORRO EL MENSAJE ANTERIOR, SI ES QUE HABIA
    $("#errorBolsonIndividual").html("");

    if(pedidosExtrasEnabled==0){
        //SI NO ESTA HABILITADO
        pedidoSoloExtras = false;
        if(oBolson===undefined || oBolson===null){
            configurationOK = false;
            $("#errorBolsonIndividual").html("Por favor, elige un <a class='red-link' href='javascript:scrollToTargetAdjusted(\"comboFamiliar\");'>bolsón</a>.")
        }
    }else if(pedidosExtrasEnabled==1){
        if((oBolson===undefined || oBolson===null) && aExtras.length==0){
            configurationOK = false;
            $("#errorBolsonIndividual").html("Por favor agregá algún producto para procesar tu pedido.");
        }else{
            if((oBolson===undefined || oBolson===null) && aExtras.length>0){
                pedidoSoloExtras = true;
                //SI EN EL PEDIDO NO HAY BOLSON, PERO SI EXTRAS
                if(!isTotalGreaterThanMontoMinimoPedidoExtras()){
                    $("#errorBolsonIndividual").html("El monto mínimo para realizar un pedido es de $" + $("#montoMinimoPedidoExtras").val() + ". Por favor agregá más productos a tu compra.");
                    configurationOK = false;    
                }
            }else{
                pedidoSoloExtras = false;
            }

        }
    }
    return configurationOK;
}

function getMontoMinimoPedidoSoloExtras(){
    var montoMinimoPedidoExtras = 0;
    $.ajax({
        url: baseURL + 'getMontoMinimoPedidoExtras',
        method: 'post',
        async: false
    }).done(function(result) {
        //console.log(result);
        if(result.success) {
            if(result.montoMinimoPedidoExtras!=null){
                montoMinimoPedidoExtras = result.montoMinimoPedidoExtras;
            }
        }
    });
    return montoMinimoPedidoExtras;
}

function getMontoMinimoEnvioSinCargo(){
    var montoMinimoEnvioSinCargo = 0;
    $.ajax({
        url: baseURL + 'getMontoMinimoEnvioSinCargoPedidoExtras',
        method: 'post',
        async: false
    }).done(function(result) {
        //console.log(result);
        if(result.success) {
            if(result.montoMinimoEnvioSinCargoPedidoExtras != null){
                montoMinimoEnvioSinCargo = result.montoMinimoEnvioSinCargoPedidoExtras;
            }
        }
    });
    return montoMinimoEnvioSinCargo;
}

function isTotalGreaterThanMontoMinimoEnvioSinCargo(subtotal){
    var isTotalGreaterThanMontoMinimoEnvioSinCargo = false;
    
    var montoMinimoEnvioSinCargo = parseFloat(getMontoMinimoEnvioSinCargo());
    var total = parseFloat(subtotal);

    if(total>=montoMinimoEnvioSinCargo){
        isTotalGreaterThanMontoMinimoEnvioSinCargo = true;
    }
    return isTotalGreaterThanMontoMinimoEnvioSinCargo;

}

function isTotalGreaterThanMontoMinimoPedidoExtras(){
    var isTotalGreaterThanMontoMinimoPedidoExtras = false;
    //var total = calcularTotalPedido();
    var total = $("#totalPedido").html();
    var montoMinimoPedidoSoloExtras = getMontoMinimoPedidoSoloExtras();

    total = parseFloat(total);
    montoMinimoPedidoSoloExtras = parseFloat(montoMinimoPedidoSoloExtras);
    
    if(total>=montoMinimoPedidoSoloExtras){
        isTotalGreaterThanMontoMinimoPedidoExtras = true;
    }
    return isTotalGreaterThanMontoMinimoPedidoExtras;
}

function openImagenBolson(){
    $("#modalImagenBolson").modal("show");
}

function searchOrdersDuplicadas(mail,celular){
    var response  = false;
    let idDiaEntrega = $("#idDiaEntrega").val();

    let data = {
        'mail' : mail,
        'telefono': celular,
        'idDiaEntrega': idDiaEntrega
    };
    $.ajax({
        url: baseURL + 'searchOrdersByDiaActualBolsonAndMailAndPhone',
        data: data,
        method: 'post',
        async: false
    }).done(function(result) {
        response = result;
    });
    return response;
}

function cerrarModalImagenBolson(){
    $("#modalImagenBolson").modal("hide");
    $(".loading").hide();
}

function cerrarModalErroresExtras() {
    $("#modalExtrasCantError").modal("hide");
    $("#erroresExtrasList").html("");
}

function setValorEnvioCero(){
    $("#agregadoTituloEnvioPedido").html("");
    $("#tituloEnvioPedido").css("text-decoration","none");
    $("#valorEnvioDomicilio").html(0);
}

function setValorEnvioDomicilioPedidoExtras(){
    var envioSinCargo = false;
    if(isTotalGreaterThanMontoMinimoEnvioSinCargoPedidoExtras()){
        envioSinCargo = true;
    }
    if(!envioSinCargo){
        $("#tituloEnvioPedido").css("text-decoration","none");
        $("#agregadoTituloEnvioPedido").html("")
        $("#valorEnvioDomicilio").html(getCostoDeEnvioPedidoSoloExtras());
    }else{
        $("#tituloEnvioPedido").css("text-decoration","line-through");
        $("#agregadoTituloEnvioPedido").html(" Bonificado!")
        $("#agregadoTituloEnvioPedido").css("text-decoration","none");
        $("#valorEnvioDomicilio").html(0);
    }
}

function getCostoDeEnvioDomicilio(){
    var costoEnvio = 0;
    $.ajax({
        url: baseURL + 'getCostoDeEnvioPedidoConBolson',
        method: 'post',
        async: false
    }).done(function(result) {
        //console.log(result);
        if(result.success) {
            if(result.costoEnvioPedidosConBolson != null){
                costoEnvio = result.costoEnvioPedidosConBolson;
            }
        }
    });
    return costoEnvio;
}

function getCostoEnvioByBarrio(){
    var idBarrio = $("#idBarrio").val();
    var costoEnvio = 0;
    var data = {
        "idBarrio": idBarrio
    }
    $.ajax({
        url: baseURL + 'getCostoDeEnvioByBarrio',
        data: data,
        method: 'post',
        async: false
    }).done(function(result) {
        //console.log(result);
        if(result.success) {
            if(result.costoEnvio != null){
                costoEnvio = result.costoEnvio;
            }
        }
    });
    return costoEnvio;
}

function getCostoDeEnvioPedidoSoloExtras(){
    var costoEnvio = 0;
    $.ajax({
        url: baseURL + 'getCostoEnvioPedidoExtras',
        method: 'post',
        async: false
    }).done(function(result) {
        //console.log(result);
        if(result.success) {
            if(result.costoEnvioPedidoExtras != null){
                costoEnvio = result.costoEnvioPedidoExtras;
            }
        }
    });
    return costoEnvio;
}

function setValorEnvioDomicilio(){
    $("#valorEnvioDomicilio").html(getCostoDeEnvioDomicilio());
}

function eboSubmit(){
    $(".loading").show();
    if(idTipoPedidoSelected==1){
        $("#type").val("SUC");
    }else{
        $("#type").val("DEL");
    }
    $("#cuponDescuento").prop("disabled",false);
    aExtras = JSON.stringify(aExtras);
    $("#arrExtras-ebo").val(aExtras);
    var montoDelivery = parseFloat($("#valorEnvioDomicilio").html());
    $("#montoDelivery").val(montoDelivery);
    $(".ebo-form").submit();             
}

function ocultarColumnasResumenPedido(){
    $('table#tResumenPedido th:nth-child(0)').hide();
    $('table#tResumenPedido td:nth-child(0)').hide();
}

function selectOneFromExtra(idExtra){
    $("#rbExtras"+idExtra+"-1").click();
}

function getPrecioBolson(){
    var precioBolson = 0;
    oBolsonAux = getBolson();
    if(oBolsonAux!=null){
        precioBolson = oBolsonAux.price;
    }
    return precioBolson;
}

function getBolson(){
    var oBolsonAux = null;
    $.ajax({
        url: baseURL + 'getBolson',
        method: 'post',
        async: false
    }).done(function(result) {
        //console.log(result);
        if(result.success) {
            if(result.oBolson != null){
                oBolsonAux = result.oBolson;
            }
        }
    });
    return oBolsonAux;
    
}

function isOnScreen(elem) {
	// if the element doesn't exist, abort
	if( elem.length == 0 ) {
		return;
	}
    var ancho = $(window).width();
	var $window = jQuery(window)
	var viewport_top = $window.scrollTop()
	var viewport_height = $window.height()
	var viewport_bottom = viewport_top + viewport_height
	var $elem = jQuery(elem)
    if(ancho>1441){
        var top = $elem.offset().top-300
    }else if (ancho >767 && ancho <= 1440){
        var top = $elem.offset().top
    }else if (ancho <= 767){
        var top = $elem.offset().top
    }
	var height = $elem.height()
	var bottom = top + height

	return (top >= viewport_top && top < viewport_bottom) ||
	(bottom > viewport_top && bottom <= viewport_bottom) ||
	(height > viewport_height && top <= viewport_top && bottom >= viewport_bottom)
}

function changeURL(element){
    const nextURL = baseURL + '#'+ element;
    const nextTitle = 'El brote Tienda Natural';
    const nextState = { additionalInformation: 'Updated the URL with JS' };
    // This will create a new entry in the browser's history, without reloading
    window.history.pushState({}, '', nextURL);
}

function getFormStatus(){
    var enabled = 0;
    $.ajax({
        url: baseURL + 'getFormStatus',
        method: 'post',
        async: false
    }).done(function(result) {
        //console.log(result);
        if(result.formEnabled!=null) {
            enabled = result.formEnabled;
        }
    });
    return enabled;
}

function hideSections() {
    $("#seccionProductoBolsones").remove();
    $("#seccionResumenPedido").remove();
    $("#datosPedido").remove();
    $("#carritoHeader").remove();
}

function detectMobile(){
    var isMobile = false;
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        isMobile = true;
    }
    return isMobile;
}

function mostrarFinalizarCompra(){
    $(".finalizarCompraSection").fadeIn();
}

function ocultarFinalizarCompra(){
    $(".finalizarCompraSection").fadeOut();
}

function verifyNewsletterForm(){
    var formOK = true;
    if( $("#newsletterMail").val() == "" ) {
        $("#pErrorNewsletterMail").html("Por favor, ingresá un correo electrónico.");
        $("#pErrorNewsletterMail").removeClass("pErrorNotVisible");
        formOK = false;
    }else{
        if(!validEmail($("#newsletterMail").val())){
            $("#pErrorNewsletterMail").html("Por favor, ingresá un correo electrónico válido.");
            $("#pErrorNewsletterMail").removeClass("pErrorNotVisible");
            formOK = false;
        }
    }
    return formOK;
}

function newsletterSuscribe(){
    if(verifyNewsletterForm()) {
        var mail = $("#newsletterMail").val();
        if( !isMailSuscribedToNewsletter(mail) ) {
            let data = {
                'mail' : mail
            };
            $.ajax({
                url: baseURL + 'newsletterSuscribe',
                data: data,
                method: 'post',
                async: false
            }).done(function(result) {
                hideNewsletter();
            });
        } else {
            $("#pErrorNewsletterMail").html("Ya estás suscripto a nuestro Newsletter.");
            $("#pErrorNewsletterMail").removeClass("pErrorNotVisible");            
        }
    }
}

function showNewsletter() {
    $("#modalNewsletter").modal("show")
}

function hideNewsletter() {
    $("#modalNewsletter").modal("hide")
}

function isMailSuscribedToNewsletter(mail) {
    var isSuscribed = false;
    let data = {
        'mail' : mail
    };
    $.ajax({
        url: baseURL + 'getIsMailSuscribedToNewsletter',
        data: data,
        method: 'post',
        async: false
    }).done(function(result) {
        isSuscribed = result.isSuscribed;
    });
    return isSuscribed;       
}

function newsletterEnabled() {
    var isEnabled = false;
    $.ajax({
        url: baseURL + 'getNewsletterEnabled',
        method: 'post',
        async: false
    }).done(function(result) {
        isEnabled = result.newsletterEnabled;
    });
    return isEnabled;       
}

function aplicarCupon() {
    if(checkCuponForm()) {
        var codigo = $("#cuponDescuento").val();
        var cupon = getCuponByCodigo(codigo);
        setCupon(cupon);
        getResumenPedido();
    }
}

function checkCuponForm() {
    var formOK = true;
    if( $("#cuponDescuento").val() == "" ) {
        $("#errorCuponDescuento").html("Debe ingresar el código del cupón.");
        formOK = false;
    }
    if((oBolson===undefined || oBolson===null) && aExtras.length==0) {
        $("#errorCuponDescuento").html("Debe seleccionar algún producto.");
        formOK = false;
    }
    return formOK;
}

function getCuponByCodigo(codigo) {
    var cupon;
    let data = {
        'codigoCupon' : codigo
    };
    $.ajax({
        url: baseURL + 'getCuponByCodigo',
        data: data,
        method: 'post',
        async: false
    }).done(function(result) {
        cupon = result.cupon;        
    });
    return cupon;
}

function setCupon(cupon) {
    if(cupon!=null) {
        $("#cuponAplicado").val(1);
        disableCupon();
        var mensajeDto = "";
        if(cupon.idTipoDescuento==1) {
            //Si es monto fijo
            mensajeDto = "de $"+parseInt(cupon.descuento);
        } else {
            //Si es porcentaje
            mensajeDto = "del "+parseInt(cupon.descuento)+"%";
        }
        $("#successCuponDescuento").html("Aplicaste un descuento "+mensajeDto);
        
    } else {
        $("#errorCuponDescuento").html("El cup&oacute;n "+$("#cuponDescuento").val()+" no existe.");
    }
}

function cuponesEnabled() {
    var isEnabled = false;
    $.ajax({
        url: baseURL + 'getModuloCuponesEnabled',
        method: 'post',
        async: false
    }).done(function(result) {
        isEnabled = result.moduloCuponesEnabled;
    });
    return isEnabled;       
}

function showModuloCupones() {
    $(".colFormEmptyShowHide").hide();
}

function disableCupon() {
    $("#cuponDescuento").prop("disabled",true);
    $("#bAplicarCupon").hide();
}

function loadDiaEntregaConfig() {
    let diaEntrega = getDiaEntrega();
    refreshFormByConfigDiaEntrega(diaEntrega);
}

function getDiaEntrega() {
    let diaEntrega;
    $.ajax({
        url: baseURL + 'getDiaEntrega',
        method: 'post',
        async: false
    }).done(function(result) {
        diaEntrega = result.diaEntrega;
    });
    return diaEntrega;
}

function refreshFormByConfigDiaEntrega(diaEntrega) {
    let puntoRetiro = false;
    let domicilio = false;
    if(diaEntrega.puntoDeRetiroEnabled != undefined && diaEntrega.puntoDeRetiroEnabled == 1) {
        $("#bPuntosRetiro").prop("disabled",false);
        $("#bPuntosRetiro").show();
        puntoRetiro = true;
    }else{
        $("#bPuntosRetiro").prop("disabled",true);
        $("#bPuntosRetiro").hide();
        puntoRetiro = false;
    }
    if(diaEntrega.deliveryEnabled != undefined && diaEntrega.deliveryEnabled == 1) {
        $("#bDomicilio").prop("disabled",false);
        $("#bDomicilio").show();
        domicilio = true;
    }else{
        $("#bDomicilio").prop("disabled",true);
        $("#bDomicilio").hide();
        domicilio = false;
    }
    if(puntoRetiro && !domicilio) {
        $("#bPuntosRetiro").click();
    } else if(!puntoRetiro && domicilio) {
        $("#bDomicilio").click();
    } else {
        $("#bPuntosRetiro").removeClass("buttonSelected");
        $("#bDomicilio").removeClass("buttonSelected");
        $(".input-datos-pedido-domicilio").css("display","none");
        $(".input-datos-pedido-puntoretiro").css("display","none");
   }

   if(isAnyBolsonSelected() && diaEntrega.aceptaBolsones == 0) {
       $("#modalDiaEntregaSinBolson").modal("show");
   }
}

function isAnyBolsonSelected() {
    return ( (oBolson!=undefined && oBolson!=null) ||  isBolsonInExtras()) ? true : false;
}

function isBolsonInExtras() {
    var idBolsonExtra = 1;
    var bolsonIndex = aExtras.findIndex( oExtra => oExtra.idExtra == idBolsonExtra );
    return (bolsonIndex > -1) ? true : false;
}

function cambiarDiaEntrega() {
    $("#idDiaEntrega").val(-1);
    $("#idDiaEntrega").change();
    $("#modalDiaEntregaSinBolson").modal("hide");
}

function clearClienteForm() {
    $(".cart-btn-tipo-pedido").removeClass("buttonSelected");
    $("#bPuntosRetiro").show();
    $("#bDomicilio").show();
    $("#pErrorTipoPedido").html("");
    $("#errorBolsonIndividual").html("");
    $("#datosPuntoDeRetiro").html("");
    $(".infoAdicionalPdR").hide();
    $("#tipoPedidoOrden").html("Seleccioná un método de entrega.");
    clearPuntosDeRetiroForm();
    clearDomicilioForm();
    $(".input-datos-pedido-domicilio").css("display","none");
    $(".input-datos-pedido-puntoretiro").css("display","none");
}

function eliminarBolsonesDelPedido() {
    deleteBolsonFromCarrito(1);
    deleteProduct(1);
    $("#messageProductoEliminado").html("Los bolsones fueron eliminados del pedido. Para continuar toca Finalizar Compra");
    $("#messageProductoEliminado").show();
    $("#modalDiaEntregaSinBolson").modal("hide");
    scrollToTargetAdjusted('seccionResumenPedido');         
}

function diaAceptaBolsones() {
    let aceptaBolsones = true;
    if($("#idDiaEntrega").val()>0) {
        let diaEntrega = getDiaEntrega($("#idDiaEntrega").val());
        if(diaEntrega.aceptaBolsones == 0) {
            aceptaBolsones = false;
        }
    }
    return aceptaBolsones;
}

function rebootWeb(){
    window.location = baseURL;
}

function validateExtraRequestedCant(cantRequested, idExtra) {
    let res = {};
    let data = {
        'idExtra' : idExtra,
        'cantRequested': cantRequested
    };
    $.ajax({
        url: baseURL + 'validate_extra_requested_cant',
        data: data,
        method: 'post',
        async: false
    }).done(function(result) {
        if(result.have_stock!=null) {
            res['have_stock'] = result.have_stock;
            res['stock_disponible'] = result.stock_disponible;
        }
    });
    return res;
}

function setFueraDeHorarioMessage() {
    var message = getFueraDeHorarioMessage();
    $("#pFueraDeHorarioMessage").html(message);
}

function getFueraDeHorarioMessage() {
    $.ajax({
        url: baseURL + 'get_fuera_de_horario_message',
        method: 'get',
        async: false
    }).done(function(result) {
        message = result.message;
    });
    return message;
}