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
$route['default_controller'] = 'Main/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['process'] = 'Main/processForm';
$route['success/(:any)'] = 'Main/success/$1';
$route['success/(:any)/delivery'] = 'Main/success/$1';
$route['failure/(:any)'] = 'Main/failure/$1';
$route['about'] = 'Main/about';
$route['payment_confirmation/(:any)'] = 'Main/paymentConfirmation/$1';

$route['searchOrdersByDiaActualBolsonAndMailAndPhone'] = 'OrdersManager/searchOrdersByDiaActualBolsonAndMailAndPhone';
$route['getMontoMinimoPedidoExtras'] = 'ParametersManager/getMontoMinimoPedidoExtras';
$route['getMontoMinimoEnvioSinCargoPedidoExtras'] = 'ParametersManager/getMontoMinimoEnvioSinCargoPedidoExtras';
$route['getCostoEnvioPedidoExtras'] = 'ParametersManager/getCostoEnvioPedidoExtras';
$route['getCostoDeEnvioPedidoConBolson'] = 'ParametersManager/getCostoDeEnvioPedidoConBolson';
$route['getCostoDeEnvioByBarrio'] = 'MultiHelper/getCostoDeEnvioByBarrio';
$route['getTipoPedidoHasPedidosExtrasHabilitado'] = 'ParametersManager/getTipoPedidoHasPedidosExtrasHabilitado';
$route['getExtrasByTipoPedido'] = 'ExtrasManager/getExtrasByTipoPedido';
$route['getPuntosDeRetiro'] = 'MultiHelper/getPuntosDeRetiro';
$route['getBarrios'] = 'MultiHelper/getBarrios';
$route['getBarriosHabilitados'] = 'MultiHelper/getBarriosHabilitados';
$route['getExtras'] = 'ExtrasManager/getExtrasActivos';
$route['getValorReservaByValorInRango'] = 'ParametersManager/getValorReservaByValorInRango';
$route['getBolson'] = 'MultiHelper/getBolson';
$route['getFormStatus'] = 'ParametersManager/getFormStatus';
$route['getNewsletterEnabled'] = 'ParametersManager/getNewsletterEnabled';
$route['recetario'] = 'Main/recetario';
$route['newsletterSuscribe'] = 'Main/newsletterSuscribe';
$route['getIsMailSuscribedToNewsletter'] = 'Main/getIsMailSuscribedToNewsletter';
$route['getCuponByCodigo'] = 'Main/getCuponByCodigo';
$route['getModuloCuponesEnabled'] = 'ParametersManager/getModuloCuponesEnabled';
$route['getDiaEntrega'] = 'MultiHelper/getDiaEntrega';
$route['getDiaEntregaHabilitado'] = 'MultiHelper/getDiaEntregaEnabled';