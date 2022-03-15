<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Auth';
$route['translate_uri_dashes'] = FALSE;

// Misc
$route['/'] = 'Auth/index';
$route['process'] = 'Auth/process';
$route['overview'] = 'Dashboard/index';
$route['logout'] = 'Auth/logout';
$route['404_override'] = '';

// Contenidos
$route['contenidos/formulario'] = 'Dashboard/formtexts';
$route['contenidos/sucursales'] = 'Dashboard/offices';
$route['contenidos/barrios'] = 'Dashboard/barrios';
$route['contenidos/newsletter'] = 'Dashboard/newsletter';
$route['contenidos/cupones'] = 'Dashboard/cupones';
$route['contenidos/diasEntrega'] = 'Dashboard/diasEntrega';
// Api
$route['api/offices/status/(:num)/(:num)'] = 'Api/officeActiveToggle/$1/$2';
$route['api/offices/update'] = 'Api/officeUpdate';
$route['api/offices/add'] = 'Api/officeAdd';
$route['api/offices/delete/(:num)'] = 'Api/officeDelete/$1';
$route['api/offices/getAllPuntosDeRetiro'] = 'Api/getAllPuntosDeRetiro';

$route['api/barrios/status/(:num)/(:num)'] = 'Api/barrioActiveToggle/$1/$2';
$route['api/barrios/update'] = 'Api/barrioUpdate';
$route['api/barrios/add'] = 'Api/barrioAdd';
$route['api/barrios/delete/(:num)'] = 'Api/barrioDelete/$1';
$route['api/barrios/getAllBarrios'] = 'Api/getAllBarrios';

$route['api/pockets/status/(:num)/(:num)'] = 'Api/pocketActiveToggle/$1/$2';
$route['api/pockets/update'] = 'Api/pocketUpdate';
$route['api/pockets/add'] = 'Api/pocketAdd';
$route['api/pockets/getBolsonPriceById/(:num)'] = 'Api/getBolsonPriceById/$1';

$route['api/extras/delete/(:num)'] = 'Api/extraDelete/$1';
$route['api/extras/status/(:num)/(:num)'] = 'Api/extraActiveToggle/$1/$2';
$route['api/extras/update'] = 'Api/extraUpdate';
$route['api/extras/add'] = 'Api/extraAdd';
$route['api/extras/uploadExtraImage'] = 'Api/extraUploadImage';
$route['api/extras/delete/(:num)'] = 'Api/extraDelete/$1';
$route['api/extras/visibleSucursal/(:num)/(:num)'] = 'Api/extraVisibleSucursalToggle/$1/$2';
$route['api/extras/visibleDomicilio/(:num)/(:num)'] = 'Api/extraVisibleDomicilioToggle/$1/$2';
$route['api/extras/getExtrasByTipoPedido/(:num)'] = 'Api/getExtrasByTipoPedido/$1';
$route['api/extras/getExtrasByTipoPedidoForEditPedido/(:num)'] = 'Api/getExtrasByTipoPedidoForEditPedido/$1';
$route['api/extras/getExtrasByIdPedido/(:num)'] = 'Api/getExtrasByIdPedido/$1';
$route['api/extras/getExtraById/(:num)'] = 'Api/getExtraById/$1';
$route['api/extras/stockIlimitado/(:num)/(:num)'] = 'Api/extraStockIlimitadoToggle/$1/$2';
$route['api/extras/resetStockDisponible/(:num)/(:num)'] = 'Api/extraResetStockDisponible/$1/$2';
$route['api/orders/build/(:num)'] = 'Api/getOfficeOrders/$1';
$route['api/orders/crearPedido'] = 'Api/crearPedido';
$route['api/orders/consultaPedidos'] = 'Api/consultaPedidos';
$route['api/orders/editarPedido'] = 'Api/editarPedido';
$route['api/crearDiaEntrega'] = 'Api/crearDiaEntrega';
$route['api/diaEntrega/uploadImagenBolson'] = 'Api/uploadImagenBolson';
$route['api/diasEntrega/getDiasEntrega'] = 'Api/getDiasEntregaActivos';
$route['api/crearCamionPreConfigurado'] = 'Api/crearCamionPreConfigurado';
$route['api/camionesPreConfigurados/getById/(:num)'] = 'Api/getCamionPreConfiguradoById/$1';
$route['api/camionesPreConfigurados/editar'] = 'Api/editarCamionPreConfigurado';
$route['api/camionesPreConfigurados/eliminar'] = 'Api/deleteCamionPreConfigurado';
$route['api/camionesPreConfigurados/getPuntosDeRetiro/(:num)'] = 'Api/getPuntosDeRetiroByIdCamionPreConfigurado/$1';
$route['api/camionesPreConfigurados/getBarrios/(:num)'] = 'Api/getBarriosByIdCamionPreConfigurado/$1';
$route['api/camionesPreConfigurados/addPuntoRetiro'] = 'Api/addPuntoRetiroToCamionPreConfigurado';
$route['api/camionesPreConfigurados/deletePuntoRetiro'] = 'Api/deletePuntoRetiroFromCamionPreConfigurado';
$route['api/camionesPreConfigurados/addBarrio'] = 'Api/addBarrioToCamionPreConfigurado';
$route['api/camionesPreConfigurados/deleteBarrio'] = 'Api/deleteBarrioFromCamionPreConfigurado';
$route['api/camionesPreConfigurados/getPuntosDeRetiroYaAsociadosExcludingIdCamion/(:num)'] = 'Api/getPuntosDeRetiroYaAsociadosExcludingIdCamion/$1';
$route['api/camionesPreConfigurados/getBarriosYaAsociadosExcludingIdCamion/(:num)'] = 'Api/getBarriosYaAsociadosExcludingIdCamion/$1';
$route['api/camionesPreConfigurados/getPuntosRetiroPendientesAsociacion'] = 'Api/getPuntosRetiroPendientesAsociacion';
$route['api/camionesPreConfigurados/getBarriosPendientesAsociacion'] = 'Api/getBarriosPendientesAsociacion';

$route['api/formStatus/(:num)'] = 'Api/changeFormStatus/$1';
$route['api/deliveryStatus/(:num)'] = 'Api/changeDeliveryStatus/$1';

$route['api/dataFrom'] = 'Api/setDataFrom';
$route['api/getOrdersFromDateToDate'] = 'Api/getOrdersFromDateToDate';
$route['api/getBolsonDiaFormulario'] = 'Api/getBolsonDiaFormulario';

//Para infoPedidosBox
$route['api/getOrdersInfoFromDiaBolson'] = 'Api/getOrdersInfoFromDiaBolson';
$route['api/getOrdersInfoFromFechaDesdeHasta'] = 'Api/getOrdersInfoFromFechaDesdeHasta';

// Bolsones y extras
$route['productos/bolsones'] = 'Dashboard/pockets';
$route['productos/extras'] = 'Dashboard/extras';

// Ordenes
$route['ordenes/sucursal'] = 'Dashboard/ordersSucursal';
$route['ordenes/delivery'] = 'Dashboard/ordersDelivery';
$route['ordenes/altaPedidos'] = 'Dashboard/altaPedidos';
$route['ordenes/listadoPedidos'] = 'Dashboard/listadoPedidos';
$route['ordenes/preciosPedidosExtras'] = 'Dashboard/preciosPedidosExtras';
$route['ordenes/getCostoEnvioPedidosExtras'] = 'Dashboard/getCostoEnvioPedidosExtras';
$route['ordenes/getCostoEnvioPedidos'] = 'Dashboard/getCostoEnvioPedidos';
$route['ordenes/goToEditarPedido'] = 'Dashboard/goToEditarPedido';
$route['ordenes/volverListadoPedidos'] = 'Dashboard/volverListadoPedidos';
$route['logistica/camiones-preconfigurados'] = 'Dashboard/goToCamionesPreConfigurados';
$route['logistica/logistica'] = 'Dashboard/goToLogistica';

$route['api/logistica/prepararDiaEntrega'] = 'Api/setEstadoEnPreparacionToDiaEntrega';
$route['api/logistica/checkIfDiaEntregaHasLogisticaItems/(:num)'] = 'Api/checkIfDiaEntregaHasLogisticaItems/$1';
$route['api/logistica/crearRegistrosInicialesLogistica'] = 'Api/crearRegistrosInicialesLogistica';
$route['api/logistica/getLogisticaPuntosRetiroByDiaEntrega/(:num)'] = 'Api/getLogisticaPuntosRetiroByDiaEntrega/$1';
$route['api/logistica/getLogisticaBarriosByDiaEntrega/(:num)'] = 'Api/getLogisticaBarriosByDiaEntrega/$1';
$route['api/logistica/eliminarRegistrosLogistica'] = 'Api/eliminarRegistrosLogistica';
$route['api/logistica/getDiasEntregaAPreparar'] = 'Api/getDiasEntregaAPreparar';
$route['api/logistica/getCantidadModificadaFromBolsonFamiliarByLogistica/(:num)'] = 'Api/getCantidadModificadaFromBolsonFamiliarByLogistica/$1';
$route['api/logistica/getCantidadModificadaFromBolsonIndividualByLogistica/(:num)'] = 'Api/getCantidadModificadaFromBolsonIndividualByLogistica/$1';
$route['api/logistica/getNombrePuntoRetiroBarrioByLogistica/(:num)'] = 'Api/getNombrePuntoRetiroBarrioByLogistica/$1';
$route['api/logistica/modificarCantidadBolsonesPuntoRetiroBarrio'] = 'Api/modificarCantidadBolsonesPuntoRetiroBarrio';
$route['api/logistica/getCamionesPreConfiguradosDisponibles/(:num)'] = 'Api/getCamionesPreConfiguradosDisponibles/$1';
$route['api/logistica/createLogisticaCamionDiaEntrega'] = 'Api/createLogisticaCamionDiaEntrega';
$route['api/logistica/asociarPuntosRetiroBarriosACamion'] = 'Api/asociarPuntosRetiroBarriosACamion';
$route['api/logistica/getCamionesByDiaEntrega/(:num)'] = 'Api/getCamionesByDiaEntrega/$1';
$route['api/logistica/getPuntosRetiroByCamion/(:num)'] = 'Api/getPuntosRetiroByCamion/$1';
$route['api/logistica/getBarriosByCamion/(:num)'] = 'Api/getBarriosByCamion/$1';
$route['api/logistica/deleteLogisticaFromCamion'] = 'Api/deleteLogisticaFromCamion';
$route['api/logistica/setCamionToLogistica'] = 'Api/setCamionToLogistica';
$route['api/logistica/setNroOrdenForPedidosByDiaEntrega'] = 'Api/setNroOrdenForPedidosByDiaEntrega';

$route['api/logistica/printLogisticaIndividual'] = 'Api/printLogisticaIndividual';
$route['api/logistica/printLogisticaMultiple'] = 'Api/printLogisticaMultiple';
$route['api/logistica/printCamionIndividual'] = 'Api/printCamionIndividual';
$route['api/logistica/printAllCamiones'] = 'Api/printAllCamiones';
$route['api/logistica/printAllCamionesConDetalles'] = 'Api/printAllCamionesConDetalles';
$route['api/logistica/printCamionesSeleccionados'] = 'Api/printCamionesSeleccionados';
$route['api/logistica/getCamionByIdCamion/(:num)'] = 'Api/getCamionByIdCamion/$1';
$route['api/logistica/deleteCamionDisponibilizado'] = 'Api/deleteCamionDisponibilizado';
$route['api/logistica/closeRegistroLogistica'] = 'Api/closeRegistroLogistica';
$route['api/logistica/printResumenPedido'] = 'Api/printResumenPedido';

$route['api/preciosPedidosExtra/editMontoMinimoPedidosExtras'] = 'Api/editMontoMinimoPedidosExtras';
$route['api/preciosPedidosExtra/editCostoEnvioPedidosExtras'] = 'Api/editCostoEnvioPedidosExtras';
$route['api/preciosPedidosExtra/editMontoMinimoEnvioSinCargoPedidosExtras'] = 'Api/editMontoMinimoEnvioSinCargoPedidosExtras';
$route['api/preciosPedidosExtra/puntoRetiroHabilitado'] = 'Api/editPedidoExtrasPuntoRetiroHabilitado';
$route['api/preciosPedidosExtra/domicilioHabilitado'] = 'Api/editPedidoExtrasDomicilioHabilitado';
$route['api/configuradorPedidos/editCostoEnvioPedidos'] = 'Api/editCostoEnvioPedidos';
$route['api/configuradorPedidos/editSenasRangos'] = 'Api/editSenasRangos';

$route['api/newsletter/setRecetarioStatus'] = 'Api/setRecetarioStatus';
$route['api/newsletter/editRecetario'] = 'Api/editRecetario';
$route['api/newsletter/setNewsletterStatus'] = 'Api/setNewsletterStatus';
$route['api/newsletter/addAdjunto'] = 'Api/addNewsletterAdjunto';
$route['api/newsletter/setAdjuntoStatus'] = 'Api/setNewsletterAdjuntoStatus';
$route['api/newsletter/descargarSuscriptos'] = 'Api/getXlsNewsletterSuscriptions';
$route['api/newsletter/eliminarNewsletterAdjunto'] = 'Api/deleteNewsletterAdjunto';
$route['api/newsletter/getNewsletterAdjunto'] = 'Api/getNewsletterAdjunto';

$route['api/cupones/crearCupon'] = 'Api/crearCupon';
$route['api/cupones/editarCupon'] = 'Api/editarCupon';
$route['api/cupones/getCupones'] = 'Api/getCupones';
$route['api/cupones/getCuponById/(:num)'] = 'Api/getCuponById/$1';
$route['api/cupones/setModuloCuponesStatus'] = 'Api/setModuloCuponesStatus';
$route['api/cupones/eliminarCupon'] = 'Api/deleteCupon';
$route['api/cupones/status'] = 'Api/statusCupon';