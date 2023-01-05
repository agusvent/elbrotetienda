<?php

require FCPATH.'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller
{
    const FAIL_VALUE = 'fail';
    const OK_VALUE   = 'ok';

    /**********************************************************
     * Sucursales
     **********************************************************/
    public function officeActiveToggle($id, $status)
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        if(!is_numeric($id) || !in_array($status, [0,1])) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Los valores no son validos ('.$id.' y '.$status.' recibidos).';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Office');
        $this->Office->setActive($id, $status);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function officeUpdate() 
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $id = $this->input->post('officeId', true);
        $name = $this->input->post('officeName', true);
        $address = $this->input->post('officeAddress', true);

        if(is_null($id) || is_null($name) || is_null($address)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Office');
        $this->Office->update(
            $id,
            $name,
            $address
        );

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function officeAdd()
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $name = $this->input->post('officeName', true);
        $address = $this->input->post('officeAddress', true);

        if(is_null($name) || is_null($address)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Office');
        $this->Office->add(
            $name,
            $address
        );

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function officeDelete($id) 
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Office');
        $this->Office->delete($id);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    /**********************************************************
     * Bolsones
     **********************************************************/
    public function pocketActiveToggle($id, $status)
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        if(!is_numeric($id) || !in_array($status, [0,1])) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Los valores no son validos ('.$id.' y '.$status.' recibidos).';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Pocket');
        $this->Pocket->setActive($id, $status);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function pocketUpdate() 
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $id = $this->input->post('pocketId', true);
        $name = $this->input->post('pocketName', true);
        $price = $this->input->post('pocketPrice', true);
        $deliverPrice = $this->input->post('pocketDeliverPrice', true);

        if(is_null($id) || is_null($name) || is_null($price) || is_null($deliverPrice)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Pocket');
        $this->Pocket->update(
            $id,
            $name,
            $price,
            $deliverPrice
        );

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function pocketAdd()
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $name = $this->input->post('pocketName', true);
        $price = $this->input->post('pocketPrice', true);
        $deliverPrice = $this->input->post('pocketDeliverPrice', true);

        if(is_null($name) || is_null($price) || is_null($deliverPrice)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Pocket');
        $this->Pocket->add(
            $name,
            $price,
            $deliverPrice
        );

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function pocketDelete($id) 
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Pocket');
        $this->Pocket->delete($id);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function getBolsonPriceById($id)
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        if(!is_numeric($id)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Id no valido: '.$id;
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Pocket');
        $bolson = $this->Pocket->getById($id);

        $return['status'] = self::OK_VALUE;
        $return['bolson'] = $bolson;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    /**********************************************************
     * Productos extras
     **********************************************************/
    public function extraUploadImage(){
        $idExtra = $_POST['idExtra'];
        $fileExtension = $_POST['fileExtension'];
        if ( 0 < $_FILES['file']['error'] ) {
            echo 'Error: ' . $_FILES['file']['error'] . '<br>';
        }else {
            move_uploaded_file($_FILES['file']['tmp_name'], '../assets/img/extras/' .$idExtra.'.'.$fileExtension);
            $this->load->model('Extra');
            $fileName = $idExtra.".".$fileExtension;
            $this->Extra->updateImage($idExtra, $fileName);
        }
        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }
        
     public function extraActiveToggle($id, $status)
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        if(!is_numeric($id) || !in_array($status, [0,1])) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Los valores no son validos ('.$id.' y '.$status.' recibidos).';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Extra');
        $this->Extra->setActive($id, $status);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function extraVisibleSucursalToggle($id, $status)
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        if(!is_numeric($id) || !in_array($status, [0,1])) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Los valores no son validos ('.$id.' y '.$status.' recibidos).';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Extra');
        $this->Extra->setVisibleSucursal($id, $status);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function extraVisibleDomicilioToggle($id, $status)
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        if(!is_numeric($id) || !in_array($status, [0,1])) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Los valores no son validos ('.$id.' y '.$status.' recibidos).';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Extra');
        $this->Extra->setVisibleDomicilio($id, $status);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function extraStockIlimitadoToggle($id, $status)
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        if(!is_numeric($id) || !in_array($status, [0,1])) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Los valores no son validos ('.$id.' y '.$status.' recibidos).';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Extra');
        $this->Extra->setStockIlimitado($id, $status);
        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function extraResetStockDisponible($id)
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        if(!is_numeric($id) || !in_array($status, [0,1])) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Los valores no son validos ('.$id.' y '.$status.' recibidos).';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Extra');
        $this->Extra->resetStockDisponible($id);
        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function extraUpdate() 
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $id = $this->input->post('extraId', true);
        $name = $this->input->post('extraName', true);
        $nombreCorto = $this->input->post('extraNombreCorto', true);
        $price = $this->input->post('extraPrice', true);
        $extraStockDisponible = $this->input->post('extraStockDisponible', true);
        $orden = $this->input->post('extraOrden', true);
        $ordenListados = $this->input->post('extraOrdenListados', true);

        if(is_null($id) || is_null($name) || is_null($price)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Extra');
        $this->Extra->update(
            $id,
            $name,
            $nombreCorto,
            $price,
            $extraStockDisponible,
            $orden,
            $ordenListados
        );

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function extraAdd()
    {
        $this->output->set_content_type('application/json');
        $idExtra = -1;

        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        

        $name = $this->input->post('extraName', true);
        $nombreCorto = $this->input->post('extraNombreCorto', true);
        $price = $this->input->post('extraPrice', true);
        
        if(is_null($name) || is_null($price)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('Extra');
        $idExtra = $this->Extra->add(
            $name,
            $nombreCorto,
            $price
        );

        $return['status'] = self::OK_VALUE;
        $return['idExtra'] = $idExtra; 
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function extraDelete($id) 
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Extra');
        $this->Extra->delete($id);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function getExtraById($idExtra){
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        $this->load->model('Extra');
        $oExtra = $this->Extra->getById($idExtra);

        $return['status'] = self::OK_VALUE;
        $return['extra'] = $oExtra;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));

    }

    public function getExtrasByIdPedido($idPedido){
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        $this->load->model('Order');
        $cExtras = [];
        //$cExtras = $this->Order->getExtras($idPedido);
        $cExtras = $this->Order->getDetailedExtras($idPedido);
        
        $return['status'] = self::OK_VALUE;
        $return['cExtras'] = $cExtras;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));

    }

    public function getExtrasByTipoPedido($idTipoPedido){
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Extra');
        $cExtras = [];
        if($idTipoPedido==1){
            //ID TIPO PEDIDO 1 ==> SUCURSAL
            $cExtras = $this->Extra->getAllVisiblesInSucursal();
        }else if($idTipoPedido==2){
            //ID TIPO PEDIDO 2 ==> DOMICILIO
            $cExtras = $this->Extra->getAllVisiblesInDomicilio();
        }
        
        $return['status'] = self::OK_VALUE;
        $return['cExtras'] = $cExtras;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function getExtrasByTipoPedidoForEditPedido($idTipoPedido){
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Extra');
        $cExtras = [];
        if($idTipoPedido==1){
            //ID TIPO PEDIDO 1 ==> SUCURSAL
            $cExtras = $this->Extra->getAllVisiblesInSucursalConSinStock();
        }else if($idTipoPedido==2){
            //ID TIPO PEDIDO 2 ==> DOMICILIO
            $cExtras = $this->Extra->getAllVisiblesInDomicilioConSinStock();
        }
        
        $return['status'] = self::OK_VALUE;
        $return['cExtras'] = $cExtras;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }    

    /**********************************************************
     * Tablas de órdenes
     **********************************************************/
    public function getOfficeOrders($id)
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Order');
        $tableContent = $this->Order->buildOfficeOrdersTable($id);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($tableContent));
    }

    public function getOrdersFromDate($dateFrom)
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Order');
        $tableContent = $this->Order->buildOfficeOrdersTable($id);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($tableContent));
    }

    /**********************************************************
     * Activar/desactivar formulario
     **********************************************************/
    public function changeFormStatus($status)
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Content');
        $this->Content->set('form_enabled', $status);
        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode(true));
    }

    public function changeDeliveryStatus($status)
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Content');
        $this->Content->set('delivery_enabled', $status);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode(true));
    }

    public function getBolsonDiaFormulario(){
        $this->load->model('Content');
        
        return $this->output->set_output($this->Content->getConfirmationLabel());

        
    }

    public function setDataFrom() 
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $_SESSION['dataFrom'] = $this->input->post('date', true);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode(true));
    }

    public function getOrdersInfoHomeFilter(){
        $this->load->model('DiasEntregaPedidos');
        $this->load->model('Pocket');
        $this->load->model('Order');

        $idDiaEntrega = $this->input->post('idDiaEntrega', true);
        $fechaDesde = $this->input->post('fechaDesde', true);
        $fechaHasta = $this->input->post('fechaHasta', true);
        if(isset($idDiaEntrega) && $idDiaEntrega>0) {
            $oDiaBolson = $this->DiasEntregaPedidos->getById($idDiaEntrega);
        }

        $idBolson = 1; //Se usa solo este bolson.
        
        $oBolson = $this->Pocket->getById($idBolson);        
        $auxSum = 0;
        $arrayInfoPedidosBox = [];
        $totalPedidos = 0;
        $totalBolsones = 0;
    
        $totalBolsonesSucursal = 0;
        $totalBolsonesDomicilio = 0;
        $subtotalBolsones = 0;


        $totalPedidosSucursal = 0;
        $totalPedidosDomicilio = 0;

        $totalPedidosSucursal = $this->Order->getTotalOrdersBetweenDatesAndDiaEntregaPuntoDeRetiro($idDiaEntrega,$fechaDesde,$fechaHasta);
        $totalPedidosDomicilio = $this->Order->getTotalOrdersBetweenDatesAndDiaEntregaBarrios($idDiaEntrega,$fechaDesde,$fechaHasta);

        $cPedidosConBolsonFamiliarSucursal = $this->Order->getTotalPedidosConBolsonesFamiliaresByDiaBolsonForSucursal($idDiaEntrega, $fechaDesde, $fechaHasta, $oBolson->id);
        
        $totalBolsonesSucursal = 0;
        if(count($cPedidosConBolsonFamiliarSucursal)>0) {
            foreach($cPedidosConBolsonFamiliarSucursal as $oPedido) {
                $totalBolsonesSucursal = $totalBolsonesSucursal + $oPedido->cant_bolson;
            }
        }

        $cPedidosConBolsonFamiliarDomicilio = $this->Order->getTotalPedidosConBolsonesFamiliaresByDiaBolsonForDomicilio($idDiaEntrega, $fechaDesde, $fechaHasta, $oBolson->id);
        
        $totalBolsonesDomicilio = 0;
        if(count($cPedidosConBolsonFamiliarDomicilio)>0) {
            foreach($cPedidosConBolsonFamiliarDomicilio as $oPedido) {
                $totalBolsonesDomicilio = $totalBolsonesDomicilio + $oPedido->cant_bolson;
            }
        }

        $subtotalBolsones = $totalBolsonesSucursal + $totalBolsonesDomicilio;
        
        array_push($arrayInfoPedidosBox,array(
            'tipoBolson' => $oBolson->name,
            'totalSucursal' => $totalBolsonesSucursal,
            'totalDomicilio' => $totalBolsonesDomicilio,
            'subtotalBolsones' => $subtotalBolsones,
        ));

        $totalBolsones = $totalBolsones + $subtotalBolsones;
        
        $this->load->model('Extra');
        $aExtras = $this->Extra->getActive();
        $arrayInfoExtrasPedidosBox = [];

        $subtotalExtrasSucursal = 0;
        $subtotalExtrasDomicilio = 0;

        foreach($aExtras as $oExtra){
            $this->load->model('Order');
            $totalSucursal = 0;
            $totalDomicilio = 0;
            $subtotalExtra = 0;
            $totalSucursal = $this->Order->getTotalExtraByDiaBolsonByExtra($idDiaEntrega,$fechaDesde,$fechaHasta,$oExtra->id);
            
            $totalDomicilio = $this->Order->getTotalExtraADomicilioByDiaBolsonByExtra($idDiaEntrega,$fechaDesde,$fechaHasta,$oExtra->id);
            $subtotalExtra = $totalSucursal + $totalDomicilio;            
            
                array_push($arrayInfoExtrasPedidosBox,array(
                    'idExtra' => $oExtra->id,
                    'extraName' => $oExtra->name,
                    'totalSucursal' => $totalSucursal,
                    'totalDomicilio' => $totalDomicilio,
                    'subtotalExtra' => $subtotalExtra
                ));
            if($oExtra->id > 1) {
                $subtotalExtrasSucursal = $subtotalExtrasSucursal + $totalSucursal;
                $subtotalExtrasDomicilio = $subtotalExtrasDomicilio + $totalDomicilio;
            }
        }        

        $arrayInfoExtrasTotalesBox = [];
        $totalExtras = $subtotalExtrasSucursal + $subtotalExtrasDomicilio;
        array_push($arrayInfoExtrasTotalesBox,array(
            'nombre' => "TOTAL EXTRAS",
            'totalSucursal' => $subtotalExtrasSucursal,
            'totalDomicilio' => $subtotalExtrasDomicilio,
            'totalExtras' => $totalExtras,
        ));

        $return[] = array(
            'status' => self::OK_VALUE,
            'totalPedidosSucursal' => $totalPedidosSucursal,
            'totalPedidosDomicilio' => $totalPedidosDomicilio,
            'aInfoPedidosByTipoBolson' => $arrayInfoPedidosBox,
            'aInfoExtrasPedidosBox' => $arrayInfoExtrasPedidosBox,
            'aInfoExtrasTotalesBox' => $arrayInfoExtrasTotalesBox,
            //'totalPedidos' => 0, //TODO: LO DEJO EN 0. DEPSUES LO BORRO BIEN. En mainHelper se usa bastante
            'totalBolsones' => $totalBolsones,
            'diaBolson' => $oDiaBolson ?? null
        );
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }
/*
    public function getOrdersInfoFromDiaBolson(){
        $this->load->model('DiasEntregaPedidos');
        $idDiaEntrega = $this->input->post('idDiaEntrega', true);
        $this->load->model('DiasEntregaPedidos');
        $oDiaBolson = $this->DiasEntregaPedidos->getById($idDiaEntrega);
        $idBolson = 1; //Se usa solo este bolson.
        $this->load->model('Pocket');

        $oBolson = $this->Pocket->getById($idBolson);        
        $auxSum = 0;
        $arrayInfoPedidosBox = [];
        $totalPedidos = 0;
        $totalBolsones = 0;
    
        $this->load->model('Order');
        $totalBolsonesSucursal = 0;
        $totalBolsonesDomicilio = 0;
        $subtotalBolsones = 0;


        $totalPedidosSucursal = 0;
        $totalPedidosDomicilio = 0;

        $totalPedidosSucursal = $this->Order->getTotalPedidosByDiaBolsonForPuntoDeRetiro($idDiaEntrega);
        $totalPedidosDomicilio = $this->Order->getTotalPedidosByDiaBolsonForDomicilio($idDiaEntrega);

        $cPedidosConBolsonFamiliarSucursal = $this->Order->getTotalPedidosConBolsonesFamiliaresByDiaBolsonForSucursal($idDiaEntrega, $oBolson->id);
        
        $totalBolsonesSucursal = 0;
        if(count($cPedidosConBolsonFamiliarSucursal)>0) {
            foreach($cPedidosConBolsonFamiliarSucursal as $oPedido) {
                $totalBolsonesSucursal = $totalBolsonesSucursal + $oPedido->cant_bolson;
            }
        }

        $cPedidosConBolsonFamiliarDomicilio = $this->Order->getTotalPedidosConBolsonesFamiliaresByDiaBolsonForDomicilio($idDiaEntrega, $oBolson->id);
        
        $totalBolsonesDomicilio = 0;
        if(count($cPedidosConBolsonFamiliarDomicilio)>0) {
            foreach($cPedidosConBolsonFamiliarDomicilio as $oPedido) {
                $totalBolsonesDomicilio = $totalBolsonesDomicilio + $oPedido->cant_bolson;
            }
        }

        $subtotalBolsones = $totalBolsonesSucursal + $totalBolsonesDomicilio;
        
        array_push($arrayInfoPedidosBox,array(
            'tipoBolson' => $oBolson->name,
            'totalSucursal' => $totalBolsonesSucursal,
            'totalDomicilio' => $totalBolsonesDomicilio,
            'subtotalBolsones' => $subtotalBolsones,
        ));

        $totalBolsones = $totalBolsones + $subtotalBolsones;
        
        $this->load->model('Extra');
        $aExtras = $this->Extra->getActive();
        $arrayInfoExtrasPedidosBox = [];
        
        foreach($aExtras as $oExtra){
            $this->load->model('Order');
            $totalSucursal = 0;
            $totalDomicilio = 0;
            $subtotalExtra = 0;
            $totalSucursal = $this->Order->getTotalExtraByDiaBolsonByExtra($idDiaEntrega,$oExtra->id);
            
            $totalDomicilio = $this->Order->getTotalExtraADomicilioByDiaBolsonByExtra($idDiaEntrega,$oExtra->id);
            
            $subtotalExtra = $totalSucursal + $totalDomicilio;
            array_push($arrayInfoExtrasPedidosBox,array(
                'extraName' => $oExtra->name,
                'totalSucursal' => $totalSucursal,
                'totalDomicilio' => $totalDomicilio,
                'subtotalExtra' => $subtotalExtra
            ));
        }        

        $return[] = array(
            'status' => self::OK_VALUE,
            'totalPedidosSucursal' => $totalPedidosSucursal,
            'totalPedidosDomicilio' => $totalPedidosDomicilio,
            'aInfoPedidosByTipoBolson' => $arrayInfoPedidosBox,
            'aInfoExtrasPedidosBox' => $arrayInfoExtrasPedidosBox,
            //'totalPedidos' => 0, //TODO: LO DEJO EN 0. DEPSUES LO BORRO BIEN. En mainHelper se usa bastante
            'totalBolsones' => $totalBolsones,
            'diaBolson' => $oDiaBolson
        );
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }
    */
    
    public function getOrdersInfoFromFechaDesdeHasta($fechaDesde,$fechaHasta){
        $this->output->set_content_type('application/json');
        $this->load->model('Content');
        $this->load->model('Pocket');
        $this->load->model('Order');
        $diaBolson = $this->Content->getConfirmationLabel();
        $idBolson = 1; //Se usa solo este.
        
        $oBolson = $this->Pocket->getById($idBolson);        
        
        $aTiposBolsones = $this->Pocket->getAll();
        
        $auxSum = 0;
        $arrayInfoPedidosBox = [];
        $totalPedidos = 0;
        $totalBolsones = 0;
    
        
        $totalSucursal = 0;
        $totalDomicilio = 0;
        $subtotalPedidos = 0;
        $subtotalBolsones = 0;
        $totalPedidosSucursal = 0;
        $totalPedidosDomicilio = 0;
        
        $totalPedidosSucursal = $this->Order->getTotalPedidosByFechaDesdeFechaHastaForPuntoDeRetiro($fechaDesde,$fechaHasta);
        $totalPedidosDomicilio = $this->Order->getTotalPedidosByFechaDesdeFechaHastaForDomicilio($fechaDesde,$fechaHasta);

        $cPedidosConBolsonFamiliarSucursal = $this->Order->getTotalPedidosConBolsonByFechaDesdeHastaForSucursal($fechaDesde,$fechaHasta,$oBolson->id);
        
        $totalBolsonesSucursal = 0;
        if(count($cPedidosConBolsonFamiliarSucursal)>0) {
            foreach($cPedidosConBolsonFamiliarSucursal as $oPedido) {
                $totalBolsonesSucursal = $totalBolsonesSucursal + $oPedido->cant_bolson;
            }
        }

        $cPedidosConBolsonFamiliarDomicilio = $this->Order->getTotalPedidosConBolsonByFechaDesdeHastaForDomicilio($fechaDesde,$fechaHasta,$oBolson->id);
        $totalBolsonesDomicilio = 0;

        if(count($cPedidosConBolsonFamiliarDomicilio)>0) {
            foreach($cPedidosConBolsonFamiliarDomicilio as $oPedido) {
                $totalBolsonesDomicilio = $totalBolsonesDomicilio + $oPedido->cant_bolson;
            }    
        }
        
        $subtotalBolsones = $totalBolsonesSucursal + $totalBolsonesDomicilio;
        array_push($arrayInfoPedidosBox,array(
            'tipoBolson' => $oBolson->name,
            'totalSucursal' => $totalBolsonesSucursal,
            'totalDomicilio' => $totalBolsonesDomicilio,
            'subtotalBolsones' => $subtotalBolsones,
        ));
        
        $totalBolsones = $totalBolsones + $subtotalBolsones;
        

        $this->load->model('Extra');
        $aExtras = $this->Extra->getActive();
        $arrayInfoExtrasPedidosBox = [];
        foreach($aExtras as $oExtra){
            $this->load->model('Order');
            $totalSucursal = 0;
            $totalDomicilio = 0;
            $subtotalExtra = 0;
            $totalSucursal = $this->Order->getTotalExtraBetweenDatesByExtra($fechaDesde,$fechaHasta,$oExtra->id);
            $totalDomicilio = $this->Order->getTotalExtraADomicilioBetweenDatesByExtra($fechaDesde,$fechaHasta,$oExtra->id);
            $subtotalExtra = $totalSucursal + $totalDomicilio;
            array_push($arrayInfoExtrasPedidosBox,array(
                'extraName' => $oExtra->name,
                'totalSucursal' => $totalSucursal,
                'totalDomicilio' => $totalDomicilio,
                'subtotalExtra' => $subtotalExtra
            ));
        }        
        
        $return[] = array(
            'status' => self::OK_VALUE,
            'totalPedidosSucursal' => $totalPedidosSucursal,
            'totalPedidosDomicilio' => $totalPedidosDomicilio,
            'aInfoPedidosByTipoBolson' => $arrayInfoPedidosBox,
            'aInfoExtrasPedidosBox' => $arrayInfoExtrasPedidosBox,
            'totalBolsones' => $totalBolsones,
        );
        $this->output->set_status_header(200);

        return $this->output->set_output(json_encode($return));
    }

    public function formatCelular($celular){
        $celularFormateado = $celular;
        $celularFormateado = str_replace(" ","",$celularFormateado);
        $celularFormateado = str_replace("-","",$celularFormateado);

        //PRIMERO VERIFICO SI HAY QUE REEMPLAZAR PREFIJOS
        if(substr($celularFormateado,0,5)=="+5415"){
            $celularFormateado = preg_replace("/\+5415/","11",$celularFormateado,1);
        }else if(substr($celularFormateado,0,5)=="+5411"){
            $celularFormateado = preg_replace("/\+5411/","11",$celularFormateado,1);
        }else if(substr($celularFormateado,0,5)=="54915"){
            $celularFormateado = preg_replace("/54915/","11",$celularFormateado,1);
        }else if(substr($celularFormateado,0,5)=="54911"){
            $celularFormateado = preg_replace("/54911/","11",$celularFormateado,1);
        }else if(substr($celularFormateado,0,6)=="+54915"){
            $celularFormateado = preg_replace("/\+54915/","11",$celularFormateado,1);
        }else if(substr($celularFormateado,0,6)=="+54911"){
            $celularFormateado = preg_replace("/\+54911/","11",$celularFormateado,1);
        }else if(substr($celularFormateado,0,4)=="5415"){
            $celularFormateado = preg_replace("/5415/","11",$celularFormateado,1);
        }else if(substr($celularFormateado,0,4)=="5411"){
            $celularFormateado = preg_replace("/5411/","11",$celularFormateado,1);
        }else if(substr($celularFormateado,0,3)=="915"){
            $celularFormateado = preg_replace("/915/","11",$celularFormateado,1);
        }else if(substr($celularFormateado,0,3)=="911"){
            $celularFormateado = preg_replace("/911/","11",$celularFormateado,1);
        }

        //DESPUES ME FIJO SI ARRANCA CON 15 
        if( substr($celularFormateado,0,2)=="15" ){
            $celularFormateado = preg_replace("/15/","11",$celularFormateado,1);
        }
        

        return $celularFormateado;
    }

    public function getOrdersFromDateToDateOld($fechaDesde,$fechaHasta,$idDiaEntrega) 
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        /***********************
         * 
         * HOJA SUCURSALES
         **********************/
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('SUCURSALES');

        $this->load->model('Extra');
        $cExtras = $this->Extra->getActive();
        $contPedidos = 1;
        $xlsCol = 'A';
        $xlsRow = 1;
        $sucursal = "";
        $firstTime = TRUE;
        $cantExtras = 0;
        $this->load->model('Order');
        $diaBolson = "";
        $arrayCeldasSubTotalesBolsonesSucursales = [];
        $arrayCeldasSubTotalesBolsonesDomicilios = [];

        $arrayCellsSubtotalExtrasSucursal = [];
        $arrayCellsTotalExtrasSucursal = [];
    
        $arrayCellsSubtotalExtrasDomicilio = [];
        $arrayCellsTotalExtrasDomicilio = [];

        $arrayRangosParaTotalFormula = [];
        $formulaSumStringBySucursal = '';
        $formulaSumStringByDomicilio = '';
        
        $arrayRangosExtrasBySucursal = [];
        $arrayRangosCountExtrasBySucursal = [];
        
        $arrayRangosExtrasByDomicilio = [];
        $arrayRangosCountExtrasByDomicilio = [];

        $arrayRangosParaTotalFormulaDomicilios = [];
        $colRowSubtotalSucursal = '';
        $cellTotalSucursales = '';
        $cellTotalDomicilios = '';

        //Se usan para saber cual es la ultima columna usada. 
        $sucursalesLastCol = 'BA';
        $domiciliosLastCol = 'BA';

        //Array de estilos para las celdas. Lo aplico por fila.
        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            ),
            'font'  => array(
                'size'  => 12
            )
        );

        if($idDiaEntrega>0){
            $cOrders = $this->Order->getOrdersSucursalWithExtrasByDiaDeBolson($idDiaEntrega);
        }else{
            $cOrders = $this->Order->getOrdersSucursalWithExtrasBetweenDates(
                $fechaDesde,
                $fechaHasta
            );    
        }

        foreach($cOrders as $oOrder){
            if($firstTime || ($sucursal != $oOrder['sucursal'])){
                if($sucursal != $oOrder['sucursal']){

                    if($formulaSumStringBySucursal!=''){
                        $arrayRowsForFormula = explode(",",$formulaSumStringBySucursal);
                        $firstRow = 0;
                        $lastRow = 0;
                        $firstRow = $arrayRowsForFormula[0];
                        $largo = count($arrayRowsForFormula);
                        $lastRow = $arrayRowsForFormula[$largo-1];
                        
                        $rango = $firstRow.":".$lastRow;
                        
                        array_push($arrayRangosParaTotalFormula,array(
                            'rango' => $rango
                        ));
                        
                        $formulaSumStringBySucursal = '=SUM('.$rango.')';
                        $sheet->setCellValue($colRowSubtotalSucursal, $formulaSumStringBySucursal);
                        $formulaSumStringBySucursal = '';

                        foreach ($arrayCellsSubtotalExtrasSucursal as $subtotalExtraCell){
                            $colExtra = $subtotalExtraCell['col'];
                            $firstCellExtra = $firstRow;
                            $firstCellExtra = ltrim($firstCellExtra,$firstCellExtra[0]);
                            $firstCellExtra = $colExtra.$firstCellExtra;

                            $lastCellExtra = $lastRow;
                            $lastCellExtra = ltrim($lastCellExtra,$lastCellExtra[0]);
                            $lastCellExtra = $colExtra.$lastCellExtra;
                            $rangoExtra = $firstCellExtra.":".$lastCellExtra;
                            
                            //$formulaCountExtrasStringBySucursal = '=COUNTIF('.$rangoExtra.',"*")';
                            $formulaCountExtrasStringBySucursal = '=COUNT('.$rangoExtra.')';
                            //$sheet->setCellValue($subtotalExtraCell['celda'], $formulaCountExtrasStringBySucursal);
                            
                            //PARA LA FORMULA DEL TOTAL EXTRAS
                            array_push($arrayCellsTotalExtrasSucursal,array(
                                'idExtra' => $subtotalExtraCell['idExtra'],
                                'celda' => $subtotalExtraCell['celda']
                            ));
                            
                            $formulaCountExtrasStringBySucursal = "";
                        }
                        $arrayCellsSubtotalExtrasSucursal = [];
                    }

                    $xlsRow++;

                    $sheet->getRowDimension($xlsRow)->setRowHeight(75);
                    $sheet->getStyle('A'.$xlsRow.':'.$sucursalesLastCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('A'.$xlsRow.':'.$sucursalesLastCol.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                                        
                    $sheet->setCellValue($xlsCol.$xlsRow, 'Cliente');
                    $xlsCol++;
                    $sheet->setCellValue($xlsCol.$xlsRow, 'Email');
                    $xlsCol++;
                    $sheet->setCellValue($xlsCol.$xlsRow, 'Celular');
                    $xlsCol++;
                    $sheet->setCellValue($xlsCol.$xlsRow, 'Bolsón Familiar (8kg)');
                    $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                    $xlsSubTotalCantBolsonesCol = $xlsCol;
                    $xlsCol++;
                    $sheet->setCellValue($xlsCol.$xlsRow, 'Precio Bolsón Familiar');
                    $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                    $xlsCol++;
                    //->setCellValue('A'.$xlsRow, 'Fecha')
                    foreach($cExtras as $oExtra){
                        $sheet->setCellValue($xlsCol.$xlsRow, $oExtra->nombre_corto);
                        //$sheet->getColumnDimension($xlsCol)->setAutoSize(true);
                        $sheet->getColumnDimension($xlsCol)->setWidth(10);
                        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                        $xlsCol++;
                    }            
                    $sheet->setCellValue($xlsCol.$xlsRow, 'Reserva Abonada');
                    $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                    //$sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
                    $xlsCol++;
                    $sheet->setCellValue($xlsCol.$xlsRow, 'Total a Cobrar');
                    $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                    $sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
                    $xlsCol++;
                    $sheet->setCellValue($xlsCol.$xlsRow, 'Observaciones');
                    $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                    $xlsCol++;
                    $sucursalesLastCol = $xlsCol;

                    $sheet->getStyle('A'.$xlsRow.':'.$sucursalesLastCol.$xlsRow)->applyFromArray($styleArray);

                    $xlsRow++;
                    $xlsCol = 'A';
                }
                $sheet->getRowDimension($xlsRow)->setRowHeight(26);
                $sheet->getStyle('A'.$xlsRow.':'.$sucursalesLastCol.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A'.$xlsRow.':'.$sucursalesLastCol.$xlsRow)->applyFromArray($styleArray);

                $sucursal = $oOrder['sucursal'];
                $domicilio_sucursal = $oOrder['domicilio_sucursal'];
                $idSucursal = $oOrder['id_sucursal'];
                $firstTime = FALSE;
                $sheet->setCellValue($xlsCol.$xlsRow, $sucursal." - ".$domicilio_sucursal);
                $sheet->mergeCells('A'.$xlsRow.':'.'C'.$xlsRow);
                $sheet->getStyle('A'.$xlsRow.':'.$sucursalesLastCol.$xlsRow)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $sheet->getStyle('A'.$xlsRow.':'.$sucursalesLastCol.$xlsRow)->getFont()->setBold(true);
                $sheet->getStyle('A'.$xlsRow.':'.$sucursalesLastCol.$xlsRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
                $sheet->getStyle('A'.$xlsRow.':'.$sucursalesLastCol.$xlsRow)->getAlignment()->setWrapText(true);
                $sheet->getRowDimension($xlsRow)->setRowHeight(60);
                

                //SUMO UNA POR EL MERGE DE COLUMNAS DE ARRIBA.
                $xlsCol++;
                
                //LO PONGO EN LA COLUMNA DE CANTIDAD BOLSONES
                $xlsCol++;
                $xlsCol++;

                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $colRowSubtotalSucursal = $xlsCol.$xlsRow;
                //$sheet->setCellValue($xlsCol.$xlsRow, $totalBolsonesSucursal);

                array_push($arrayCeldasSubTotalesBolsonesSucursales,array(
                    'celda' => $xlsCol.$xlsRow,
                    'col' => $xlsCol,
                    'row' => $xlsRow
                ));
            
                
                $xlsCol++;
                //FIN CANTIDAD BOLSONES x SUCURSAL

                //PASO LA COLUMNA DE PRECIO
                $xlsCol++;

                //CANTIDAD DE EXTRAS x TIPO
                $this->load->model('Extra');
                $cExtras = $this->Extra->getActive();
                $cantExtras = count($cExtras);
                foreach($cExtras as $oExtra){
                    if($soloBolsonDia=='true'){
                        $totalExtras = $this->Order->getTotalExtrasBySucursalByDiaBolsonByExtra(
                            $diaBolson,
                            $idSucursal,
                            $oExtra->id
                        );
                    }else{
                        $totalExtras = $this->Order->getTotalExtrasBySucursalBetweenDatesByExtra(
                            $fechaDesde,
                            $fechaHasta,
                            $idSucursal,
                            $oExtra->id
                        );
                    }

                    array_push($arrayCellsSubtotalExtrasSucursal,array(
                        'celda' => $xlsCol.$xlsRow,
                        'col' => $xlsCol,
                        'row' => $xlsRow,
                        'idExtra' => $oExtra->id
                        )
                    );
                    $sheet->setCellValue($xlsCol.$xlsRow, $totalExtras);
                    $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $xlsCol++;
                }                        
                //FIN CANTIDAD DE EXTRAS x TIPO
                
                $xlsRow++;
            }
            $sheet->getRowDimension($xlsRow)->setRowHeight(26);
            $sheet->getStyle('A'.$xlsRow.':'.$sucursalesLastCol.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A'.$xlsRow.':'.$sucursalesLastCol.$xlsRow)->applyFromArray($styleArray);

            $subTotalPedido = 0;
            // $sumarSubTotal => Esta booleana la uso para saber si el pedido ya viene desde la base con el monto total o si lo tengo que calcular aca.
            // Si queda en false, hay que calcularlo.
            $sumarSubTotal = false;
            $celularFormateado = $this->formatCelular($oOrder['celular']);
            $xlsCol = 'A';
            $sheet->setCellValue($xlsCol.$xlsRow, $oOrder['nro_orden']." - ".$oOrder['cliente']);
            
            $sheet->getColumnDimension($xlsCol)->setWidth(25);
            $xlsCol++;
            $sheet->setCellValue($xlsCol.$xlsRow, $oOrder['mail']);
            $sheet->getColumnDimension($xlsCol)->setWidth(30);
            
            $xlsCol++;
            $sheet->setCellValue($xlsCol.$xlsRow, " ".$celularFormateado);
            
            $sheet->getColumnDimension($xlsCol)->setWidth(15);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            $xlsCol++;

            $cantidadBolson = 0;
            $precioBolson = 0;

            if(!is_null($oOrder['cant_bolson']) && $oOrder['cant_bolson']!=""){
                $cantidadBolson = $oOrder['cant_bolson'];
                $precioBolson = $oOrder['total_bolson'];
            }

            if($precioBolson == 0) {
                $precioBolson = "-";
            }

            $sheet->setCellValue($xlsCol.$xlsRow, $cantidadBolson);            
            $sheet->getColumnDimension($xlsCol)->setWidth(10);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $xlsCol++;

            $sheet->setCellValue($xlsCol.$xlsRow, $precioBolson); 
            $sheet->getColumnDimension($xlsCol)->setWidth(8);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
            $xlsCol++;

            if(isset($oOrder['monto_total'])){
                $subTotalPedido = $oOrder['monto_debe'];
            }else{
                $subTotalPedido = $subTotalPedido + $oOrder['total_bolson'];
                $sumarSubTotal = true;
            }
            $extrasArray = $oOrder['extras'];
            foreach($cExtras as $oExtra){ //Array de extras activos en la base de datos (con esto identifico la columna)
                foreach($extrasArray as $ordenExtra){ //Array de extras en la orden (con esto pongo el precio en la columna correcta)
                    if($oExtra->id == $ordenExtra['id_extra']){
                        $cantExtra = $this->Order->getCantOrderExtraByPedidoAndExtra($oOrder['order_id'],$oExtra->id);
                        if(!isset($cantExtra)){
                            $cantExtra = 1;
                        }else{
                            $cantExtra = $cantExtra[0]->cant;
                        }
                        $precio = ($ordenExtra['extra_price'] * $cantExtra);                        
                        //print_r($precio."\n");
                        $sheet->setCellValue($xlsCol.$xlsRow, $precio);
                        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $sheet->getColumnDimension($xlsCol)->setWidth(18);
                        if($sumarSubTotal){
                            $subTotalPedido = $subTotalPedido + $precio;
                        }
                        array_push($arrayRangosExtrasBySucursal,array(
                            'idExtra' => $oExtra->id,
                            'col' => $xlsCol,
                            'row' => $xlsRow,
                            'celda' => $xlsCol.$xlsRow
                        ));
                    }
                    if(count($arrayRangosExtrasBySucursal)>0){
                        array_push($arrayRangosCountExtrasBySucursal,$arrayRangosExtrasBySucursal);
                    }
                    $arrayRangosExtrasBySucursal = [];
                }                
                //$sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
                $xlsCol++;
            }
            
            $valMontoPagado;
            if($oOrder['monto_pagado'] == 0) {
                $valMontoPagado = "-";
            }else{
                $valMontoPagado = $oOrder['monto_pagado'];
            }

            $sheet->setCellValue($xlsCol.$xlsRow, $valMontoPagado);
            $sheet->getColumnDimension($xlsCol)->setWidth(10);
            //$sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            if($oOrder['monto_pagado']>0){
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
            }else{
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
            }
            $xlsCol++;

            $valSubtotalPedido;
            if($subTotalPedido == 0){
                $valSubtotalPedido = "-";
            }else{
                $valSubtotalPedido = $subTotalPedido;
            }

            $sheet->setCellValue($xlsCol.$xlsRow, $valSubtotalPedido);
            $sheet->getColumnDimension($xlsCol)->setWidth(10);
            $sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            if($subTotalPedido>0){
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
            }else{
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
            }
            $xlsCol++;

            $obsConcat = "";
            
            if(isset($oOrder['id_estado_pedido']) && $oOrder['id_estado_pedido']>0){
                if($oOrder['id_estado_pedido']!=1){
                    //SI ES CONFIRMADO NO QUIERO QUE SALGA LA DESCRIPCION
                    $this->load->model('EstadosPedidos');
                    $estadoPedido = $this->EstadosPedidos->getById($oOrder['id_estado_pedido']);
                    $obsConcat = strtoupper($estadoPedido->descripcion);
                }
            }
            if($obsConcat==""){
                $obsConcat = $oOrder['observaciones'];
            }else{
                $obsConcat = $obsConcat." - ".$oOrder['observaciones'];
            }

            if($oOrder['id_cupon'] != null && $oOrder['id_cupon']>0) {
                if($obsConcat==""){
                    $obsConcat = "Cupón de Descuento aplicado.";
                }else{
                    $obsConcat = $obsConcat." - "."Cupón de Descuento aplicado.";
                }    
            }

            $sheet->setCellValue($xlsCol.$xlsRow, $obsConcat);
            //$sheet->getColumnDimension($xlsCol)->setAutoSize(true);
            $sheet->getColumnDimension($xlsCol)->setWidth(22);
            $xlsCol++;
            

            if($oOrder['id_estado_pedido']==2){
                //$sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                //$sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->getFont()->setBold(true);
                $sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E7B04A');
            }else if($oOrder['id_estado_pedido']==3 || $oOrder['id_estado_pedido']==5){
                //$sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                //$sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->getFont()->setBold(true);
                $sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('57BB5F');
            }
    
            
            if($formulaSumStringBySucursal == '' ){
                $formulaSumStringBySucursal = $xlsSubTotalCantBolsonesCol.$xlsRow;
            }else{
                $formulaSumStringBySucursal = $formulaSumStringBySucursal.','.$xlsSubTotalCantBolsonesCol.$xlsRow;
            }
            
            $xlsCol = 'A';
            $xlsRow++;
            $contPedidos++;
        }
        
        //print_r($arrayRangosCountExtrasBySucursal);
        //HAGO DE NUEVO ESTO FUERA DEL FOREACH PORQUE SINO LA ULTIMA SUCURSAL NO ME LA TIENE EN CUENTA
        $arrayRowsForFormula = explode(",",$formulaSumStringBySucursal);
        $firstRow = 0;
        $lastRow = 0;
        $firstRow = $arrayRowsForFormula[0];

        //$firstRow = ltrim($firstRow,$firstRow[0]);

        $largo = count($arrayRowsForFormula);

        $lastRow = $arrayRowsForFormula[$largo-1];
        
        //$lastRow = ltrim($lastRow,$lastRow[0]);
        
        //$rango = $xlsSubTotalCantBolsonesCol.$firstRow.":".$xlsSubTotalCantBolsonesCol.$lastRow;
        $rango = $firstRow.":".$lastRow;
        
        array_push($arrayRangosParaTotalFormula,array(
            'rango' => $rango
        ));
        
        $formulaSumStringBySucursal = '=SUM('.$rango.')';
        $sheet->setCellValue($colRowSubtotalSucursal, $formulaSumStringBySucursal);

        
        foreach ($arrayCellsSubtotalExtrasSucursal as $subtotalExtraCell){
            $colExtra = $subtotalExtraCell['col'];
            $firstCellExtra = $firstRow;
            $firstCellExtra = ltrim($firstCellExtra,$firstCellExtra[0]);
            $firstCellExtra = $colExtra.$firstCellExtra;

            $lastCellExtra = $lastRow;
            $lastCellExtra = ltrim($lastCellExtra,$lastCellExtra[0]);
            $lastCellExtra = $colExtra.$lastCellExtra;
            $rangoExtra = $firstCellExtra.":".$lastCellExtra;

            $idExtra = $subtotalExtraCell['idExtra'];
            
            //$formulaCountExtrasStringBySucursal = '=COUNTIF('.$rangoExtra.',"*")';
            $formulaCountExtrasStringBySucursal = '=COUNT('.$rangoExtra.')';
            $sheet->setCellValue($subtotalExtraCell['celda'], $formulaCountExtrasStringBySucursal);
            
            //PARA LA FORMULA DEL TOTAL EXTRAS
            array_push($arrayCellsTotalExtrasSucursal,array(
                'idExtra' => $subtotalExtraCell['idExtra'],
                'celda' => $subtotalExtraCell['celda']
            ));
            
            $formulaCountExtrasStringBySucursal = "";
        }



        $xlsRow++; //DEJO UNA FILA DE ESPACIO
        $xlsCol = 'A';
        $sheet->setCellValue($xlsCol.$xlsRow, "TOTAL");
        $sheet->getStyle('A'.$xlsRow.':'.$sucursalesLastCol.$xlsRow)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->getStyle('A'.$xlsRow.':'.$sucursalesLastCol.$xlsRow)->getFont()->setBold(true);
        $sheet->getStyle('A'.$xlsRow.':'.$sucursalesLastCol.$xlsRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $sheet->getRowDimension($xlsRow)->setRowHeight(50);
        $sheet->getStyle('A'.$xlsRow.':'.$sucursalesLastCol.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A'.$xlsRow.':'.$sucursalesLastCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $xlsCol++;
        $xlsCol++;
        $xlsCol++;
        

        $rangosFormula = '';
        
        //RANGO PARA LA FORMULA FORMADO POR TODOS LAS CELDAS DE SUBTOTALES DE LAS SUCURSALES.
        foreach($arrayCeldasSubTotalesBolsonesSucursales as $rango){
            if($rangosFormula==''){
                $rangosFormula = $rangosFormula.$rango['celda'];
            }else{
                $rangosFormula = $rangosFormula.','.$rango['celda'];
            }
        }

        $formula = '=SUM('.$rangosFormula.')';
        $sheet->setCellValue($xlsCol.$xlsRow, $formula);
        $cellTotalSucursales = $xlsCol.$xlsRow;
        $xlsCol++;
        //FIN CANTIDAD TOTAL DE BOLSONES

        //PASO LA COLUMNA DE PRECIO
        $xlsCol++;

        //CANTIDADES TOTALES EXTRAS
        $arrayTotalizadoExtrasASucursal = [];
        
        foreach($cExtras as $oExtra){ //Array de extras activos en la base de datos (con esto identifico la columna)
            
            $arrayAuxCellsTotalExtras = [];
            foreach($arrayCellsTotalExtrasSucursal as $cell){
                if($oExtra->id == $cell['idExtra']){
                    array_push($arrayAuxCellsTotalExtras,array(
                        'celda' => $cell['celda']
                    ));
                }
            }

            //print_r($arrayAuxCellsTotalExtras);
            $celdasSumaTotalExtra = "";
            foreach($arrayAuxCellsTotalExtras as $cell){
                if($celdasSumaTotalExtra==""){
                    $celdasSumaTotalExtra = $cell['celda'];
                }else{
                    $celdasSumaTotalExtra = $celdasSumaTotalExtra.",".$cell['celda'];
                }
            }

            
            $formulaTotalExtra = '=SUM('.$celdasSumaTotalExtra.')';
            
            array_push($arrayTotalizadoExtrasASucursal,array(
                'extraName' => $oExtra->name,
                //'extraTotal' => $totalExtra,
                'celda' => $xlsCol.$xlsRow,
                'extraId' => $oExtra->id
            ));
            
            $sheet->setCellValue($xlsCol.$xlsRow, $formulaTotalExtra);
            $xlsCol++;
        }
        //FIN CANTIDADES TOTALES EXTRAS

        $xlsRow++;        
        $xlsRow++;        
        $xlsCol = 'A';
        
        //Total de bolsones de SUCURSAL
        //$resumenTotalBolsonesSucursal = $totalBolsones;
        //borrar
        $resumenTotalBolsonesSucursal = 0;
        //Fila del excel donde debe ir el titulo Total Bolsones
        $resumenTotalBolsonesRow = $xlsRow;

        //CON ESTO OCULTO LA PRIMER COLUMNA QUE TIENE LA FECHA DEL BOLSON (Ej.: BOLSON DEL "MIERCOLES 14 DE OCTUBRE")
        //$sheet->getColumnDimension('A')->setVisible(false);


        /***********************
         * 
         * FIN HOJA SUCURSALES
         **********************/

         
        /***********************
         * 
         * HOJA DOMICILIOS
         **********************/
        $arrayRowsForFormulaDomicilios = [];
        $arrayRangosParaTotalFormulaDomicilios = [];
        $colRowSubtotalDomicilios = '';
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('DOMICILIO');
        $xlsRow = 1;
        $xlsCol = 'A';
        $barrio = "";
        $resumenTotalBolsonesDomicilio = 0;
        //CANTIDADES TOTALES EXTRAS
        $arrayTotalizadoExtrasDomicilio = [];
        $cExtras = $this->Extra->getActive();

        $this->load->model('Order');
        $diaBolson = "";
        if($idDiaEntrega>0){
            $cOrders = $this->Order->getOrdersADomicilioWithExtrasByDiaDeBolson($idDiaEntrega);
        }else{
            $cOrders = $this->Order->getOrdersADomicilioWithExtrasBetweenDates(
                $fechaDesde,
                $fechaHasta
            );    
        }
        if(!empty($cOrders)){
            foreach($cOrders as $oOrder){
                
                if($firstTime || ($barrio != $oOrder['barrio'])){
                    if($barrio != $oOrder['barrio']){

                        //asignar a la celda antes de limpiarla 
                        if($formulaSumStringByDomicilio!=''){
                            $arrayRowsForFormulaDomicilios = explode(",",$formulaSumStringByDomicilio);
                            $firstRow = 0;
                            $lastRow = 0;
                            $firstRow = $arrayRowsForFormulaDomicilios[0];
                            //$firstRow = ltrim($firstRow,$firstRow[0]);

                            $largo = count($arrayRowsForFormulaDomicilios);

                            $lastRow = $arrayRowsForFormulaDomicilios[$largo-1];
                            //$lastRow = ltrim($lastRow,$lastRow[0]);
                            
                            $rango = $firstRow.":".$lastRow;
                            
                            array_push($arrayRangosParaTotalFormulaDomicilios,array(
                                'rango' => $rango
                            ));
                            
                            $formulaSumStringByDomicilio = '=SUM('.$rango.')';
                            $sheet->setCellValue($colRowSubtotalDomicilios, $formulaSumStringByDomicilio);
                            $formulaSumStringByDomicilio = '';
                            
                            foreach ($arrayCellsSubtotalExtrasDomicilio as $subtotalExtraCell){
                                $colExtra = $subtotalExtraCell['col'];
                                $firstCellExtra = $firstRow;
                                $firstCellExtra = ltrim($firstCellExtra,$firstCellExtra[0]);
                                $firstCellExtra = $colExtra.$firstCellExtra;

                                $lastCellExtra = $lastRow;
                                $lastCellExtra = ltrim($lastCellExtra,$lastCellExtra[0]);
                                $lastCellExtra = $colExtra.$lastCellExtra;
                                $rangoExtra = $firstCellExtra.":".$lastCellExtra;
                                
                                //$formulaCountExtrasStringByDomicilio = '=COUNTIF('.$rangoExtra.',"*")';
                                $formulaCountExtrasStringByDomicilio = '=COUNT('.$rangoExtra.')';
                                /*****
                                 * comento la siguiente linea para que en las celdas de subtotal de extras, figure el nro fijo de total y no la formula que cuenta. La
                                 * formula servia para cuando no existia la posibilidad de poner más de 1 unidad de extra
                                 *****/ 
                                //$sheet->setCellValue($subtotalExtraCell['celda'], $formulaCountExtrasStringByDomicilio);
                                
                                //PARA LA FORMULA DEL TOTAL EXTRAS
                                array_push($arrayCellsTotalExtrasDomicilio,array(
                                    'idExtra' => $subtotalExtraCell['idExtra'],
                                    'celda' => $subtotalExtraCell['celda']
                                ));
                                
                                $formulaCountExtrasStringByDomicilio = "";
                            }
                            $arrayCellsSubtotalExtrasDomicilio = [];

                        }

                        $xlsRow++;
                        
                        $sheet->getRowDimension($xlsRow)->setRowHeight(75);                    
                        $sheet->getStyle('A'.$xlsRow.':'.$domiciliosLastCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $sheet->getStyle('A'.$xlsRow.':'.$domiciliosLastCol.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    
                        $sheet->setCellValue($xlsCol.$xlsRow, 'Cliente');
                        $xlsCol++;
                        $sheet->setCellValue($xlsCol.$xlsRow, 'Email');
                        $xlsCol++;
                        $sheet->setCellValue($xlsCol.$xlsRow, 'Celular');
                        $xlsCol++;
                        $sheet->setCellValue($xlsCol.$xlsRow, 'Direccion');
                        $xlsCol++;
                        $sheet->setCellValue($xlsCol.$xlsRow, 'Bolsón Familiar (8kg)');
                        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                        $xlsSubTotalCantBolsonesColDomicilios = $xlsCol;
                        $xlsCol++;
                        $sheet->setCellValue($xlsCol.$xlsRow, 'Precio Bolsón Familiar');
                        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                        $xlsCol++;

                        $extrasStartCol = $xlsCol;
                        $barrio = "";
                        $firstTime = TRUE;
                        foreach($cExtras as $oExtra){
                            $sheet->setCellValue($xlsCol.$xlsRow, $oExtra->nombre_corto);
                            $sheet->getColumnDimension($xlsCol)->setWidth(10);
                            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                            $xlsCol++;
                        }

                        $sheet->setCellValue($xlsCol.$xlsRow, 'Reserva Abonada');
                        //$sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
                        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                        $xlsCol++;

                        $sheet->setCellValue($xlsCol.$xlsRow, 'Total a Cobrar');
                        $sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
                        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                        $xlsCol++;

                        $sheet->setCellValue($xlsCol.$xlsRow, 'Observaciones');
                        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                        $xlsCol++;
                        $domiciliosLastCol = $xlsCol;

                        $sheet->getStyle('A'.$xlsRow.':'.$domiciliosLastCol.$xlsRow)->applyFromArray($styleArray);

                        $xlsRow++;
                                    
                    }
                    $xlsCol = 'A';

                    $sheet->getRowDimension($xlsRow)->setRowHeight(26);
                    $sheet->getStyle('A'.$xlsRow.':'.$domiciliosLastCol.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('A'.$xlsRow.':'.$domiciliosLastCol.$xlsRow)->applyFromArray($styleArray);

                    $barrio = $oOrder['barrio'];
                    $idBarrio = $oOrder['id_barrio'];
                    $firstTime = FALSE;
                    $sheet->setCellValue($xlsCol.$xlsRow, $barrio);
                    $sheet->mergeCells('A'.$xlsRow.':'.'C'.$xlsRow);
                    
                    $sheet->getStyle('A'.$xlsRow.':'.$domiciliosLastCol.$xlsRow)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                    $sheet->getStyle('A'.$xlsRow.':'.$domiciliosLastCol.$xlsRow)->getFont()->setBold(true);
                    $sheet->getStyle('A'.$xlsRow.':'.$domiciliosLastCol.$xlsRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
                    $sheet->getRowDimension($xlsRow)->setRowHeight(60);

                    //SUMO UNO POR EL MERGE DE COLUMNAS DE ARRIBA.
                    $xlsCol++;

                    //LO PONGO EN LA COLUMNA DE CANTIDAD BOLSONES
                    $xlsCol++;
                    $xlsCol++;
                    $xlsCol++;

                    $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                    $totalBolsonesBarrio = 0;
                    //CANTIDAD DE BOLSONES x SUCURSAL
                    if($soloBolsonDia=='true'){
                        $totalBolsonesBarrio = $this->Order->getTotalOrdersADomicilioByBarrioByDiaBolson(
                            $diaBolson,
                            $idBarrio
                        );
                    }else{
                        $totalBolsonesBarrio = $this->Order->getTotalOrdersADomicilioByBarrioBetweenDates(
                            $fechaDesde,
                            $fechaHasta,
                            $idBarrio
                        );
                    }
                    $colRowSubtotalDomicilios = $xlsCol.$xlsRow;
                    
                    $sheet->setCellValue($xlsCol.$xlsRow, $totalBolsonesBarrio);

                    array_push($arrayCeldasSubTotalesBolsonesDomicilios,array(
                        'celda' => $xlsCol.$xlsRow
                    ));
                    
                    $xlsCol++;
                    //FIN CANTIDAD BOLSONES x SUCURSAL
                    
                    //PASO LA COLUMNA DE PRECIO
                    $xlsCol++;

                    //CANTIDAD DE EXTRAS x TIPO

                    $this->load->model('Extra');
                    $cExtras = $this->Extra->getActive();
                    
                    foreach($cExtras as $oExtra){
                        if($soloBolsonDia=='true'){
                            $totalExtras = $this->Order->getTotalExtrasByBarrioByDiaBolsonByExtra(
                                $diaBolson,
                                $idBarrio,
                                $oExtra->id
                            );
                        }else{
                            $totalExtras = $this->Order->getTotalExtrasByBarrioBetweenDatesByExtra(
                                $fechaDesde,
                                $fechaHasta,
                                $idBarrio,
                                $oExtra->id
                            );
                        }    

                        array_push($arrayCellsSubtotalExtrasDomicilio,array(
                            'celda' => $xlsCol.$xlsRow,
                            'col' => $xlsCol,
                            'row' => $xlsRow,
                            'idExtra' => $oExtra->id
                            )
                        );

                        $sheet->setCellValue($xlsCol.$xlsRow, $totalExtras);
                        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $xlsCol++;
                    }                        
                    //FIN CANTIDAD DE EXTRAS x TIPO
                    
                    $xlsRow++;
                }

                $sheet->getRowDimension($xlsRow)->setRowHeight(26);
                $sheet->getStyle('A'.$xlsRow.':'.$domiciliosLastCol.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A'.$xlsRow.':'.$domiciliosLastCol.$xlsRow)->applyFromArray($styleArray);
    
                $subTotalPedido = 0;
                $sumarSubTotal = false;
                $celularFormateado = $this->formatCelular($oOrder['celular']);
                $xlsCol = 'A';
                $sheet->setCellValue($xlsCol.$xlsRow, $oOrder['nro_orden']." - ".$oOrder['cliente']);
                //$sheet->getColumnDimension($xlsCol)->setAutoSize(true);
                $sheet->getColumnDimension($xlsCol)->setWidth(25);
                $xlsCol++;
                $sheet->setCellValue($xlsCol.$xlsRow, $oOrder['mail']);
                //$sheet->getColumnDimension($xlsCol)->setAutoSize(true);
                $sheet->getColumnDimension($xlsCol)->setWidth(30);
                $xlsCol++;
                $sheet->setCellValue($xlsCol.$xlsRow, " ".$celularFormateado);
                //$sheet->getColumnDimension($xlsCol)->setAutoSize(true);
                $sheet->getColumnDimension($xlsCol)->setWidth(15);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);    
                $xlsCol++;
                $domicilio = $oOrder['cliente_domicilio']." ".$oOrder['cliente_domicilio_extra'];
                $sheet->setCellValue($xlsCol.$xlsRow, $domicilio);
                //$sheet->getColumnDimension($xlsCol)->setAutoSize(true);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                $sheet->getColumnDimension($xlsCol)->setWidth(50);
                $xlsCol++;

                $cantidadBolson = 0;
                $precioBolson = 0;
    
                if(!is_null($oOrder['cant_bolson']) && $oOrder['cant_bolson']!=""){
                    $cantidadBolson = $oOrder['cant_bolson'];
                    $precioBolson = $oOrder['total_bolson'];
                }

                if($precioBolson == 0) {
                    $precioBolson = "-";
                }
    
                $sheet->setCellValue($xlsCol.$xlsRow, $cantidadBolson);
                //$sheet->getColumnDimension($xlsCol)->setAutoSize(true);
                $sheet->getColumnDimension($xlsCol)->setWidth(10);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $xlsCol++;

                $sheet->setCellValue($xlsCol.$xlsRow, $precioBolson);
                //$sheet->getColumnDimension($xlsCol)->setAutoSize(true);
                $sheet->getColumnDimension($xlsCol)->setWidth(8);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);    
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
                $xlsCol++;

                if(isset($oOrder['monto_total'])){
                    $subTotalPedido = $oOrder['monto_debe'];
                }else{
                    $subTotalPedido = $subTotalPedido + $oOrder['total_bolson'];
                    $sumarSubTotal = true;
                }

                $extrasArray = $oOrder['extras'];
                foreach($cExtras as $oExtra){ //Array de extras activos en la base de datos (con esto identifico la columna)
                    foreach($extrasArray as $ordenExtra){ //Array de extras en la orden (con esto pongo el precio en la columna correcta)
                        if($oExtra->id == $ordenExtra['id_extra']){
                            $cantExtra = $this->Order->getCantOrderExtraByPedidoAndExtra($oOrder['order_id'],$oExtra->id);
                            if(!isset($cantExtra)){
                                $cantExtra = 1;
                            }else{
                                $cantExtra = $cantExtra[0]->cant;
                            }
                            //print_r($cantExtra."\n");
                            $precio = ($ordenExtra['extra_price'] * $cantExtra);                        
                            //print_r($precio."\n");    
                            $sheet->setCellValue($xlsCol.$xlsRow, $precio);
                            //$sheet->getColumnDimension($xlsCol)->setAutoSize(true);
                            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                            $sheet->getColumnDimension($xlsCol)->setWidth(18);    
                            if($sumarSubTotal){
                                $subTotalPedido = $subTotalPedido + $price;
                            }
                            array_push($arrayRangosExtrasByDomicilio,array(
                                'idExtra' => $oExtra->id,
                                'col' => $xlsCol,
                                'row' => $xlsRow,
                                'celda' => $xlsCol.$xlsRow
                            ));
                        }
                        if(count($arrayRangosExtrasByDomicilio)>0){
                            array_push($arrayRangosCountExtrasByDomicilio,$arrayRangosExtrasByDomicilio);
                        }
                        $arrayRangosExtrasByDomicilio = [];
                    }
                    //$sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                    $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
                    $xlsCol++;
                }

                $valMontoPagado;
                if($oOrder['monto_pagado'] == 0) {
                    $valMontoPagado = "-";
                }else{
                    $valMontoPagado = $oOrder['monto_pagado'];
                }

                $sheet->setCellValue($xlsCol.$xlsRow, $valMontoPagado);
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
                $sheet->getColumnDimension($xlsCol)->setWidth(10);
                //$sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
                $xlsCol++;

                $valSubtotalPedido;
                if($subTotalPedido == 0){
                    $valSubtotalPedido = "-";
                }else{
                    $valSubtotalPedido = $subTotalPedido;
                }

                $sheet->setCellValue($xlsCol.$xlsRow, $valSubtotalPedido);
                $sheet->getColumnDimension($xlsCol)->setWidth(10);
                $sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                if($subTotalPedido>=0){
                    $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
                }else{
                    $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
                }
    
                $xlsCol++;
                $obsConcat = "";
                if(isset($oOrder['id_estado_pedido']) && $oOrder['id_estado_pedido']>0){
                    if($oOrder['id_estado_pedido']!=1){
                        //SI ES CONFIRMADO NO QUIERO QUE SALGA LA DESCRIPCION
                        $this->load->model('EstadosPedidos');
                        $estadoPedido = $this->EstadosPedidos->getById($oOrder['id_estado_pedido']);
                        $obsConcat = strtoupper($estadoPedido->descripcion);
                    }
                }
                if($obsConcat==""){
                    $obsConcat = $oOrder['observaciones'];
                }else{
                    $obsConcat = $obsConcat." - ".$oOrder['observaciones'];
                }
    
                if($oOrder['id_cupon'] != null && $oOrder['id_cupon']>0) {
                    if($obsConcat==""){
                        $obsConcat = "Cupón de Descuento aplicado.";
                    }else{
                        $obsConcat = $obsConcat." - "."Cupón de Descuento aplicado.";
                    }    
                }
    
                $sheet->setCellValue($xlsCol.$xlsRow, $obsConcat);
                //$sheet->getColumnDimension($xlsCol)->setAutoSize(true);
                $sheet->getColumnDimension($xlsCol)->setWidth(22);
                $xlsCol++;

                if($oOrder['id_estado_pedido']==2){
                    //$sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                    //$sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->getFont()->setBold(true);
                    $sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E7B04A');
                }else if($oOrder['id_estado_pedido']==3 || $oOrder['id_estado_pedido']==5){
                    //$sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                    //$sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->getFont()->setBold(true);
                    $sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('57BB5F');
                }
    
                if($formulaSumStringByDomicilio == '' ){
                    $formulaSumStringByDomicilio = $xlsSubTotalCantBolsonesColDomicilios.$xlsRow;
                }else{
                    $formulaSumStringByDomicilio = $formulaSumStringByDomicilio.','.$xlsSubTotalCantBolsonesColDomicilios.$xlsRow;
                }
                
                $xlsCol = 'A';
                $xlsRow++;
                $contPedidos++;
            }
            //HAGO DE NUEVO ESTO FUERA DEL FOREACH PORQUE SINO EL ULTIMO BARRIO NO ME LA TIENE EN CUENTA
            $arrayRowsForFormulaDomicilios = explode(",",$formulaSumStringByDomicilio);
            $firstRow = 0;
            $lastRow = 0;
            $firstRow = $arrayRowsForFormulaDomicilios[0];
            //$firstRow = ltrim($firstRow,$firstRow[0]);

            $largo = count($arrayRowsForFormulaDomicilios);

            $lastRow = $arrayRowsForFormulaDomicilios[$largo-1];
            //$lastRow = ltrim($lastRow,$lastRow[0]);

            $rango = $firstRow.":".$lastRow;

            array_push($arrayRangosParaTotalFormulaDomicilios,array(
                'rango' => $rango
            ));

            $formulaSumStringByDomicilio = '=SUM('.$rango.')';
            $sheet->setCellValue($colRowSubtotalDomicilios, $formulaSumStringByDomicilio);


            foreach ($arrayCellsSubtotalExtrasDomicilio as $subtotalExtraCell){
                $colExtra = $subtotalExtraCell['col'];
                $firstCellExtra = $firstRow;
                $firstCellExtra = ltrim($firstCellExtra,$firstCellExtra[0]);
                $firstCellExtra = $colExtra.$firstCellExtra;

                $lastCellExtra = $lastRow;
                $lastCellExtra = ltrim($lastCellExtra,$lastCellExtra[0]);
                $lastCellExtra = $colExtra.$lastCellExtra;
                $rangoExtra = $firstCellExtra.":".$lastCellExtra;
                
                //$formulaCountExtrasStringByDomicilio = '=COUNTIF('.$rangoExtra.',"*")';
                $formulaCountExtrasStringByDomicilio = '=COUNT('.$rangoExtra.')';
                $sheet->setCellValue($subtotalExtraCell['celda'], $formulaCountExtrasStringByDomicilio);
                
                //PARA LA FORMULA DEL TOTAL EXTRAS
                array_push($arrayCellsTotalExtrasDomicilio,array(
                    'idExtra' => $subtotalExtraCell['idExtra'],
                    'celda' => $subtotalExtraCell['celda']
                ));
                
                $formulaCountExtrasStringBySucursal = "";
            }

            $xlsRow++; //DEJO UNA FILA DE ESPACIO
            $xlsCol = 'A';
            $sheet->setCellValue($xlsCol.$xlsRow, "TOTAL");
            $sheet->getStyle('A'.$xlsRow.':'.$domiciliosLastCol.$xlsRow)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $sheet->getStyle('A'.$xlsRow.':'.$domiciliosLastCol.$xlsRow)->getFont()->setBold(true);
            $sheet->getStyle('A'.$xlsRow.':'.$domiciliosLastCol.$xlsRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
            $sheet->getRowDimension($xlsRow)->setRowHeight(50);
            $sheet->getStyle('A'.$xlsRow.':'.$domiciliosLastCol.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A'.$xlsRow.':'.$domiciliosLastCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $xlsCol++;
            $xlsCol++;
            $xlsCol++;
            $xlsCol++;
            //CANTIDAD TOTAL DE BOLSONES

            $totalBolsones = 0;
            if($soloBolsonDia=='true'){
                $totalBolsones = $this->Order->getTotalBolsonesADomicilioByDiaBolson(
                    $diaBolson
                );
            }else{
                $totalBolsones = $this->Order->getTotalBolsonesADomicilioBetweenDates(
                    $fechaDesde,
                    $fechaHasta
                );
            }
            $rangosFormulaDomicilios = '';

            //RANGO PARA LA FORMULA FORMADO POR TODOS LOS RANGOS DE CADA SUCURSAL.
            /*foreach($arrayRangosParaTotalFormulaDomicilios as $rango){
                if($rangosFormulaDomicilios==''){
                    $rangosFormulaDomicilios = $rangosFormulaDomicilios.$rango['rango'];
                }else{
                    $rangosFormulaDomicilios = $rangosFormulaDomicilios.','.$rango['rango'];
                }
            }*/

            //RANGO PARA LA FORMULA FORMADO POR TODOS LAS CELDAS DE SUBTOTALES DE LAS SUCURSALES.
            foreach($arrayCeldasSubTotalesBolsonesDomicilios as $rango){
                if($rangosFormulaDomicilios==''){
                    $rangosFormulaDomicilios = $rangosFormulaDomicilios.$rango['celda'];
                }else{
                    $rangosFormulaDomicilios = $rangosFormulaDomicilios.','.$rango['celda'];
                }
            }

            $formulaDomicilios = '=SUM('.$rangosFormulaDomicilios.')';
            //$sheet->setCellValue($xlsCol.$xlsRow, $totalBolsones);
            $sheet->setCellValue($xlsCol.$xlsRow, $formulaDomicilios);
            $cellTotalDomicilios = $xlsCol.$xlsRow;

            $xlsCol++;
            //FIN CANTIDAD TOTAL DE BOLSONES

            //PASO LA COLUMNA DE PRECIO
            $xlsCol++;

            foreach($cExtras as $oExtra){ //Array de extras activos en la base de datos (con esto identifico la columna)

                $arrayAuxCellsTotalExtras = [];
                foreach($arrayCellsTotalExtrasDomicilio as $cell){
                    if($oExtra->id == $cell['idExtra']){
                        array_push($arrayAuxCellsTotalExtras,array(
                            'celda' => $cell['celda']
                        ));
                    }
                }

                //print_r($arrayAuxCellsTotalExtras);
                $celdasSumaTotalExtra = "";
                foreach($arrayAuxCellsTotalExtras as $cell){
                    if($celdasSumaTotalExtra==""){
                        $celdasSumaTotalExtra = $cell['celda'];
                    }else{
                        $celdasSumaTotalExtra = $celdasSumaTotalExtra.",".$cell['celda'];
                    }
                }

                $formulaTotalExtra = '=SUM('.$celdasSumaTotalExtra.')';

                array_push($arrayTotalizadoExtrasDomicilio,array(
                    'extraName' => $oExtra->name,
                    //'extraTotal' => $totalExtra,
                    'celda' => $xlsCol.$xlsRow,
                    'extraId' => $oExtra->id

                ));
                $sheet->setCellValue($xlsCol.$xlsRow, $formulaTotalExtra);
                $xlsCol++;
            }
            //FIN CANTIDADES TOTALES EXTRAS

            //Total de bolsones de DOMICILIO
            $resumenTotalBolsonesDomicilio = $totalBolsones;

        }
        
        //Total bolsones
        $resumenTotalBolsones = $resumenTotalBolsonesSucursal + $resumenTotalBolsonesDomicilio;

        $xlsRow++;        
        $xlsRow++;        
        $xlsCol = 'A';
        $sheet->setCellValue($xlsCol.$xlsRow, 'Bolsón Familiar (8kg)');
        $xlsCol++;
                
        //$sheet->setCellValue($xlsCol.$xlsRow, $resumenTotalBolsones);
        $formulaTotal = '=SUM('.'SUCURSALES!'.$cellTotalSucursales.','.$cellTotalDomicilios.')';
        $sheet->setCellValue($xlsCol.$xlsRow, $formulaTotal);
        $xlsRow++;

        //Total de extras (SUCURSAL + DOMICILIO)
        $arrayTotalizadoExtras = [];
        $extraName = "";
        $extraTotal = 0;
        $auxTotal = 0;          
        $rangoFormula = "";
        //echo "CANT EXTRAS:".$cantExtras;  
        
        //print_r($arrayTotalizadoExtrasASucursal);
        //print_r($arrayTotalizadoExtrasDomicilio);

        for($i = 0 ; $i < $cantExtras ; $i++ ){
            if(!empty($arrayTotalizadoExtrasASucursal) && !empty($arrayTotalizadoExtrasDomicilio)){
                $rangoFormula = 'SUCURSALES!'.$arrayTotalizadoExtrasASucursal[$i]['celda'].",".'DOMICILIO!'.$arrayTotalizadoExtrasDomicilio[$i]['celda'];
            }else{
                if(!empty($arrayTotalizadoExtrasASucursal)){
                    $rangoFormula = 'SUCURSALES!'.$arrayTotalizadoExtrasASucursal[$i]['celda'];
                }else{
                    $rangoFormula = 'DOMICILIO!'.$arrayTotalizadoExtrasDomicilio[$i]['celda'];
                }
            }
            //echo "AUX TOTAL = ".$auxTotal;
            $extraName = $arrayTotalizadoExtrasASucursal[$i]['extraName'];
            array_push($arrayTotalizadoExtras,array(
                'extraName' => $extraName,
                'rangoFormula' => $rangoFormula
            ));
        }

        
        foreach($arrayTotalizadoExtras as $extra){
            $xlsCol = 'A';
            $sheet->setCellValue($xlsCol.$xlsRow, $extra['extraName']);
            $xlsCol++;
            $formula = '=SUM('.$extra['rangoFormula'].')';
            $sheet->setCellValue($xlsCol.$xlsRow, $formula);
            $xlsRow++;

        }
        //$sheet->getColumnDimension('A')->setVisible(false);
        /***********************
         * FIN HOJA DOMICILIOS
         * *********************/
        //Con esto vuelvo a la hoja de SUCURSALES

        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getSheetByName("SUCURSALES");

        $xlsCol = 'A';
        $sheet->setCellValue($xlsCol.$resumenTotalBolsonesRow, 'Bolsón Familiar (8kg)');
        $xlsCol++;
        $formulaTotal = '=SUM('.$cellTotalSucursales.','.'DOMICILIO!'.$cellTotalDomicilios.')';
        $sheet->setCellValue($xlsCol.$resumenTotalBolsonesRow, $formulaTotal);

        //$sheet->setCellValue($xlsCol.$resumenTotalBolsonesRow, $resumenTotalBolsones);
        $resumenTotalBolsonesRow++;
        foreach($arrayTotalizadoExtras as $extra){
            $xlsCol = 'A';
            $sheet->setCellValue($xlsCol.$resumenTotalBolsonesRow, $extra['extraName']);
            $xlsCol++;
            $formula = '=SUM('.$extra['rangoFormula'].')';
            $sheet->setCellValue($xlsCol.$resumenTotalBolsonesRow, $formula);
            $resumenTotalBolsonesRow++;

        }

        $writer = new Xlsx($spreadsheet);
        
        $fileName = "";
        if($soloBolsonDia=='true'){
            $diaFile = str_replace(' ', '_', $diaBolson);
            $diaFile = str_replace('É', 'E', $diaFile);
            $fileName = "EBO_".$diaFile;
        }else{
            $fileName = "EBO_".$fechaDesde."_".$fechaHasta;
        }
        $fileName = $fileName.".xlsx";

        $writer->save($fileName);
        $return[] = array(
            'status' => self::OK_VALUE,
            'fileName' => $fileName
        );
        $this->output->set_status_header(200);

        return $this->output->set_output(json_encode($return));

    }

    public function pedidosPendientes() {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Order');
        $cPedidosPendientes = $this->Order->getPedidosPendientesInFechaGenerica();
        $return['status'] = self::OK_VALUE;
        $return['pedidos'] = $cPedidosPendientes;
        
        $this->output->set_status_header(200);

        return $this->output->set_output(json_encode($return));
    }

    public function pedidosPendientesSinVer() {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Order');
        $cPedidosPendientes = $this->Order->getPedidosPendientesSinVerInFechaGenerica();
        $return['status'] = self::OK_VALUE;
        $return['pedidos'] = $cPedidosPendientes;
        
        $this->output->set_status_header(200);

        return $this->output->set_output(json_encode($return));
    }

    public function consultaPedidos(){
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        $idDiaEntrega = $this->input->post('idDiaEntrega', true);
        $incluirCancelados = $this->input->post('incluirCancelados', true);
        $soloNoValidos = $this->input->post('soloNoValidos', true);
        $nombre = $this->input->post('nombre', true);
        $mail = $this->input->post('mail', true);
        $fechaDesde = $this->input->post('fechaDesde', true);
        $fechaHasta = $this->input->post('fechaHasta', true);
        $nroPedido = $this->input->post('nroPedido', true);

        $this->load->model('Order');
        
        $pedidos = $this->Order->getOrdersFromConsultaPedidos($idDiaEntrega,$incluirCancelados,$fechaDesde,$fechaHasta,$nombre,$mail,$nroPedido,$soloNoValidos);
        

        $return['status'] = self::OK_VALUE;
        $return['pedidos'] = $pedidos;
        
        $this->output->set_status_header(200);

        return $this->output->set_output(json_encode($return));
    }

    public function turnOffAlarmaPendiente() {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        $this->load->model('Order');

        $idPedido = $this->input->post('idPedido', true);
        $return['alarma_off'] = $this->Order->turnOffAlarmaPendiente($idPedido);
        
        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function despacharPedido() {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        $this->load->model('Order');

        $idPedido = $this->input->post('idPedido', true);
        $despachado = false;
        $despachado = $this->Order->despachado($idPedido);
        
        $return['despachado'] = $despachado;
        $return['status'] = self::OK_VALUE;
        $return['idPedido'] = $idPedido;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function entregarPedido() {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        $this->load->model('Order');

        $idPedido = $this->input->post('idPedido', true);
        $entregado = false;
        $entregado = $this->Order->entregado($idPedido);
        
        $return['entregado'] = $entregado;
        $return['status'] = self::OK_VALUE;
        $return['idPedido'] = $idPedido;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function getPedidoById() {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        $this->load->model('Order');

        $idPedido = $this->input->post('idPedido', true);
        $pedido = $this->Order->getOrderById($idPedido)[0];
        
        $return['status'] = self::OK_VALUE;
        $return['pedido'] = $pedido;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function crearPedido()
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        $idDiaBolson = $this->input->post('idDiaBolson', true);
        $nombre = $this->input->post('nombre', true);
        $telefono = $this->input->post('telefono', true);
        $mail = $this->input->post('mail', true);
        $direccion = $this->input->post('direccion', true);
        $direccionPisoDepto = $this->input->post('direccionPisoDepto', true);
        $idTipoPedido = $this->input->post('idTipoPedido', true);
        $idBarrio = $this->input->post('idBarrio', true);
        $idSucursal = $this->input->post('idSucursal', true);
        $idBolson = $this->input->post('idBolson', true);
        $cantBolson = $this->input->post('cantBolson', true);
        $montoTotal = $this->input->post('montoTotal', true);
        $montoPagado = $this->input->post('montoPagado', true);
        $idEstadoPedido = $this->input->post('idEstadoPedido', true);
        $observaciones = $this->input->post('observaciones', true);
        $idCupon = $this->input->post('idCupon', true);
        $montoDescuento = $this->input->post('montoDescuento', true);
        $idPedidoFijo = $this->input->post('idPedidoFijo', true);
        $idFormaPago = $this->input->post('idFormaPago', true);
        $cExtras = $this->input->post('extras', true);
        
        if(isset($idEstadoPedido) && ($idEstadoPedido==3 || $idEstadoPedido==5)){
            //SI ES BONIFICADO O ABONADO
            $montoPagado = $montoTotal;
        }

        $this->load->model('Order');
        $newOrderId = -1;
        $newOrderId = $this->Order->addOrder(
            $idDiaBolson,
            $nombre,
            $telefono,
            $mail,
            $direccion,
            $direccionPisoDepto,
            $idTipoPedido,
            $idBarrio,
            $idSucursal,
            $idBolson,
            $cantBolson,
            $montoTotal,
            $montoPagado,
            $idEstadoPedido,
            $observaciones,
            $idCupon,
            $montoDescuento,
            $idPedidoFijo,
            0,
            $idFormaPago
        );
        if(!empty($cExtras)){
            $this->load->model('Extra');
            foreach($cExtras as $oExtra){
                $this->Order->addExtra($newOrderId,$oExtra["idExtra"],$oExtra["cantidad"]);
                $this->Extra->reducirStockExtra($oExtra["idExtra"],$oExtra["cantidad"]);
            }
        }
        $newOrder = $this->Order->getById($newOrderId);
        $this->envioMail($newOrder);
        $return['status'] = self::OK_VALUE;
        $return['idPedido'] = $newOrderId;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }
    /**********************************************************
     * Zonas de entregas / barrios
     **********************************************************/
    public function barrioActiveToggle($id, $status)
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        if(!is_numeric($id) || !in_array($status, [0,1])) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Los valores no son validos ('.$id.' y '.$status.' recibidos).';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Barrio');
        $this->Barrio->setActive($id, $status);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function barrioUpdate() 
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $id = $this->input->post('barrioId', true);
        $name = $this->input->post('barrioName', true);
        $costoEnvio = $this->input->post('costoEnvio', true);
        $observaciones = $this->input->post('barrioObservaciones', true);

        if(is_null($id) || is_null($name)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Barrio');
        $this->Barrio->update(
            $id,
            $name,
            $observaciones,
            $costoEnvio
        );

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function barrioAdd()
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $name = $this->input->post('barrioName', true);
        $costoEnvio = $this->input->post('costoEnvio', true);
        $observaciones = $this->input->post('barrioObservaciones', true);

        if(is_null($name)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Barrio');
        $this->Barrio->add(
            $name,
            $observaciones,
            $costoEnvio
        );

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function barrioDelete($id) 
    {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Barrio');
        $this->Barrio->delete($id);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function sendConfirmationMail() {
        $this->load->model('Order');
        $idPedido = $this->input->post('idPedido', true);
        $order = $this->Order->getById($idPedido);
        $this->envioMail($order);
    }

    public function envioMail($order){
        $this->load->model('Order');
        $this->load->model('Pocket');
        $this->load->model('Barrio');
        $this->load->model('Office');
        $this->load->model('Extra');

        $bolson = null;
        if(isset($order->pocket_id) && $order->pocket_id>0){
            $bolson = $this->Pocket->getById($order->pocket_id);
        }
        $extras = $this->Order->getDetailedExtras($order->id);
        $montoDebe = $order->monto_total;
        if($order->monto_pagado!=null && $order->monto_pagado>0){
            $montoDebe = $order->monto_total - $order->monto_pagado;
        }

        $montoDescuento = 0;
        $hayDescuento = false;
        if( isset($order->monto_descuento) && $order->monto_descuento>0 ) {
            $montoDescuento = $order->monto_descuento;
            $hayDescuento = true;
        }

        if ($order->deliver_type == 'SUC') {
            $viewName = 'normal';
            $viewAltName = 'alt';
            $sucursal = $this->Office->getById($order->office_id);
            $mailingData = [
                'nombre'   => $order->client_name,
                'bolson'   => $bolson,
                'cantBolson' => $order->cant_bolson,
                'totalBolson' => $order->total_bolson,
                'sucursal' => $sucursal->name . ' > ' . $sucursal->address,
                'retiro'   => $order->deliver_date,
                'extras'   => $extras,
                'totalPrice' => $montoDebe,
                'montoDescuento'   => $montoDescuento,
                'montoPagado' => $order->monto_pagado,
                'hayDescuento' => $hayDescuento

            ];
        } else {
            $viewName = 'delivery';
            $viewAltName = 'delivery_alt';
            $costoEnvio = $this->getCostoEnvio();
            $barrio = $this->Barrio->getById($order->barrio_id);
            $mailingData = [
                'nombre' => $order->client_name,
                'bolson' => $bolson,
                'cantBolson' => $order->cant_bolson,
                'totalBolson' => $order->total_bolson,
                'extras' => $extras,
                'entrega' => $order->deliver_date,
                'direccion' => $order->deliver_address . ' ' . $order->deliver_extra . ' - ' . $barrio->nombre,
                'totalPrice' => $order->monto_total,
                'horarioEntrega' => $barrio->observaciones,
                'montoDescuento'   => $montoDescuento,
                'montoPagado' => $order->monto_pagado,
                'hayDescuento' => $hayDescuento
            ];
        }

        if(!isset($extras)) {
            unset($mailingData['extras']);
        }

        $this->load->library('phpmailer_lib');

        $this->load->model('Content');
        $mailServer = $this->Content->get("mail_server");
        $mailAccount = $this->Content->get("mail_account");
        $mailCopy = $this->Content->get("mail_copy");
        $mailPass = $this->Content->get("mail_pass");

        $mail = $this->phpmailer_lib->load();
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = $mailServer;
        $mail->Username = $mailAccount;
        $mail->Password = $mailPass;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom($mailAccount, "El Brote Tienda Natural");
        $mail->addAddress(str_replace(' ','',$order->email));
        $mail->addReplyTo($mailAccount, "El Brote Tienda Natural");
        $mail->addBCC($mailCopy);

        $mail->isHTML(true);
        $mail->Subject = 'Pedido confirmado en El Brote Tienda Natural.';
        $mail->Body = $this->load->view('mailing/'.$viewName, $mailingData, true);
        $mail->AltBody = $this->load->view('mailing/'.$viewAltName, $mailingData, true);

        try {
            $mail->send();
        } catch (Exception $e) {
            /*error_log(json_encode($e),3,"/home/c1510066/public_html/application/logs/debug.log");
            $this->load->model('Error');
            $extras = [
                'task' => 'Sending mail notification',
                'mailto' => str_replace(' ','',$order->email)
            ];
            $this->Error->add($e->getMessage(), $e->getFile(), $e->getLine(), json_encode($extras));*/
        }        
    }

    public function procesarPedidosFijos() {
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Order');
        $this->load->model('Pocket');
        $this->load->model('DiasEntregaBarrios');

        $idDiaEntrega = $this->input->post('idDiaEntrega', true);
        $pedidosCreados = "";
        $cPedidosFijos = $this->Order->getAllPedidosFijos();
        $cPedidosCreados = [];
        foreach($cPedidosFijos as $oPedidoFijo){
            $newOrderId = -1;
            $oBolson = $this->Pocket->getById(1);
            $precio = $oBolson->price;
            $cantBolson = 0;
            $montoPagado = 0;
            if($oPedidoFijo->cant_bolson > 0) {
                $cantBolson = $oPedidoFijo->cant_bolson;
                $precio = $precio * $cantBolson;
            }
            if($oPedidoFijo->id_estado_pedido==3){
                //SI ES BONIFICADO, MONTO PAGADO ES IGUAL AL VALOR DEL BOLSON, PARA QUE QUEDE DEBE = $0.
                $montoPagado = $precio;
            }else{
                $montoPagado = $oPedidoFijo->monto_pagado;
            }
            $newOrderId = $this->Order->addOrder(
                $idDiaEntrega,
                $oPedidoFijo->client_name,
                $oPedidoFijo->phone,
                $oPedidoFijo->email,
                $oPedidoFijo->deliver_address,
                $oPedidoFijo->deliver_extra,
                $oPedidoFijo->id_tipo_pedido,
                $oPedidoFijo->barrio_id,
                $oPedidoFijo->office_id,
                $oBolson->id,
                $cantBolson,
                $precio,
                $montoPagado,
                $oPedidoFijo->id_estado_pedido,
                $oPedidoFijo->observaciones,
                -1,
                -1,
                0, //ACA DEJO EL PEDIDO COMO NO FIJO PORQUE EL FIJO ES EL ORIGINAL
                $oPedidoFijo->id,
                $oPedidoFijo->id_forma_pago,
            );
            $pedidosCreados = $pedidosCreados."<p>".$oPedidoFijo->client_name;

            array_push($cPedidosCreados,array(
                $oPedidoFijo->client_name
            ));


            $cExtrasExistentes = $this->Order->getExtras($oPedidoFijo->id);
            $sumaTotalExtras = 0;
            $totalPedido = 0;
            if(!empty($cExtrasExistentes)){
                $this->load->model('Extra');
                foreach($cExtrasExistentes as $oExtra){
                    if( !is_null($oExtra->active) && $oExtra->active == 1) {
                        $cant = $this->Order->getCantExtraByPedidoAndExtra($oPedidoFijo->id, $oExtra->id);
                        if($oExtra->stock_ilimitado == 1 || ($oExtra->stock_ilimitado == 0 && $oExtra->stock_disponible >= $cant)) {    
                            $this->Order->addExtra($newOrderId,$oExtra->id,$cant);
                            $this->Extra->reducirStockExtra($oExtra->id,$cant);
                            $sumaTotalExtras = $sumaTotalExtras + ($oExtra->price * $cant);
                        }
                    }
                }
                $totalPedido = intval($precio) + intval($sumaTotalExtras);
                $this->Order->updateMontoTotal($newOrderId, $totalPedido);
                if($oPedidoFijo->id_estado_pedido==3){
                    $this->Order->updateMontoPagado($newOrderId, $totalPedido);
                }
            }
        }
        
        $return['pedidosCreados'] = $cPedidosCreados;
        $return['success'] = true;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($cPedidosCreados));
    }

    public function crearDiaEntrega(){
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Order');
        $this->load->model('Pocket');
        $this->load->model('DiasEntregaBarrios');

        $diaEntregaCreado = false;
        $diaEntregaFecha = $this->input->post('diaEntregaFecha', true);
        $diaEntregaLabelFinal = $this->input->post('diaEntregaLabelFinal', true);
        $aceptaBolsones = $this->input->post('aceptaBolsones', true);
        $puntoDeRetiroStatus = $this->input->post('puntoDeRetiroStatus', true);
        $deliveryStatus = $this->input->post('deliveryStatus', true);
        $cargaPedidosFijos = $this->input->post('cargaPedidosFijos', true);
        $preCollectionIdBarriosHabilitados = $this->input->post('arrayBarriosHabilitados', true);
        $cBarriosHabilitados = [];
        
        $idDiaEntrega = -1;
        $aceptaPedidos = 0;
        if($puntoDeRetiroStatus==1 || $deliveryStatus==1) {
            $aceptaPedidos = 1;
        }
        if(isset($diaEntregaFecha) && !empty($diaEntregaFecha)){
            $this->load->model('DiasEntregaPedidos');
        
            $idDiaEntrega = $this->DiasEntregaPedidos->add($diaEntregaFecha,$diaEntregaLabelFinal, $aceptaBolsones, $puntoDeRetiroStatus, $deliveryStatus, $aceptaPedidos);
            if($idDiaEntrega > 0){
                $diaEntregaCreado = true;
                if($deliveryStatus==1) {
                    if(isset($preCollectionIdBarriosHabilitados) && count($preCollectionIdBarriosHabilitados)>0) {
                        foreach($preCollectionIdBarriosHabilitados as $barrio){
                            array_push($cBarriosHabilitados,array(
                                'idBarrio' => $barrio['idBarrio']
                            ));
                        }
                        foreach($cBarriosHabilitados as $oIdBarrio) {
                            $this->DiasEntregaBarrios->add($idDiaEntrega, $oIdBarrio["idBarrio"]);
                        }                
                    }
                }
            }
        }
        //$this->load->model('Content');
        //$this->Content->set("confirmation_label",$diaEntregaLabelFinal);    

        $pedidosCreados = "";
        if($cargaPedidosFijos==1) {
            $cPedidosFijos = $this->Order->getAllPedidosFijos();
            foreach($cPedidosFijos as $oPedidoFijo){
                $newOrderId = -1;
                $oBolson = $this->Pocket->getById(1);
                $precio = $oBolson->price;
                $cantBolson = 0;
                $montoPagado = 0;
                if($oPedidoFijo->cant_bolson > 0) {
                    $cantBolson = $oPedidoFijo->cant_bolson;
                    $precio = $precio * $cantBolson;
                }
                if($oPedidoFijo->id_estado_pedido==3){
                    //SI ES BONIFICADO, MONTO PAGADO ES IGUAL AL VALOR DEL BOLSON, PARA QUE QUEDE DEBE = $0.
                    $montoPagado = $precio;
                }else{
                    $montoPagado = $oPedidoFijo->monto_pagado;
                }
                $newOrderId = $this->Order->addOrder(
                    $idDiaEntrega,
                    $oPedidoFijo->client_name,
                    $oPedidoFijo->phone,
                    $oPedidoFijo->email,
                    $oPedidoFijo->deliver_address,
                    $oPedidoFijo->deliver_extra,
                    $oPedidoFijo->id_tipo_pedido,
                    $oPedidoFijo->barrio_id,
                    $oPedidoFijo->office_id,
                    $oBolson->id,
                    $cantBolson,
                    $precio,
                    $montoPagado,
                    $oPedidoFijo->id_estado_pedido,
                    $oPedidoFijo->observaciones,
                    -1,
                    -1,
                    0, //ACA DEJO EL PEDIDO COMO NO FIJO PORQUE EL FIJO ES EL ORIGINAL
                    $oPedidoFijo->id
                );
                $pedidosCreados = $pedidosCreados."<p>".$oPedidoFijo->client_name.".</p>";

                $cExtrasExistentes = $this->Order->getExtras($oPedidoFijo->id);
                $sumaTotalExtras = 0;
                $totalPedido = 0;
                if(!empty($cExtrasExistentes)){
                    $this->load->model('Extra');
                    foreach($cExtrasExistentes as $oExtra){
                        if( !is_null($oExtra->active) && $oExtra->active == 1) {
                            $cant = $this->Order->getCantExtraByPedidoAndExtra($oPedidoFijo->id, $oExtra->id);
                            if($oExtra->stock_ilimitado == 1 || ($oExtra->stock_ilimitado == 0 && $oExtra->stock_disponible >= $cant)) {    
                                $this->Order->addExtra($newOrderId,$oExtra->id,$cant);
                                $this->Extra->reducirStockExtra($oExtra->id,$cant);
                                $sumaTotalExtras = $sumaTotalExtras + ($oExtra->price * $cant);
                            }
                        }
                    }
                    $totalPedido = intval($precio) + intval($sumaTotalExtras);
                    $this->Order->updateMontoTotal($newOrderId, $totalPedido);
                    if($oPedidoFijo->id_estado_pedido==3){
                        $this->Order->updateMontoPagado($newOrderId, $totalPedido);
                    }
                }
            }
        }
        $return[] = array(
            'status' => self::OK_VALUE,
            'pedidosCreados' => $pedidosCreados,
            'diaEntregaCreado' => $diaEntregaCreado,
            'idDiaEntrega' => $idDiaEntrega
        );
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));

    }

    public function editarPedido(){

        $this->output->set_content_type('application/json');

        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $idPedido = $this->input->post('idPedido', true);
        $idDiaEntrega = $this->input->post('idDiaEntrega', true);
        $nombre = $this->input->post('nombre', true);
        $telefono = $this->input->post('telefono', true);
        $mail = $this->input->post('mail', true);
        $direccion = $this->input->post('direccion', true);
        $direccionPisoDepto = $this->input->post('direccionPisoDepto', true);
        $idTipoPedido = $this->input->post('idTipoPedido', true);
        $idBarrio = $this->input->post('idBarrio', true);
        $idSucursal = $this->input->post('idSucursal', true);
        $idBolson = $this->input->post('idBolson', true);
        $cantBolson = $this->input->post('cantBolson', true);
        $montoTotal = $this->input->post('montoTotal', true);
        $montoPagado = $this->input->post('montoPagado', true);
        $idEstadoPedido = $this->input->post('idEstadoPedido', true);
        $observaciones = $this->input->post('observaciones', true);
        $idCupon = $this->input->post('idCupon', true);
        $montoDescuento = $this->input->post('montoDescuento', true);
        $idPedidoFijo = $this->input->post('idPedidoFijo', true);
        $idFormaPago = $this->input->post('idFormaPago', true);
        $cExtras = $this->input->post('extras', true);
        if(isset($idEstadoPedido) && ($idEstadoPedido==3 || $idEstadoPedido==5)){
            //SI ES BONIFICADO O ABONADO
            $montoPagado = $montoTotal;
        }

        $this->load->model('Order');
        
        $this->Order->updatePedido(
            $idPedido,
            $idDiaEntrega,
            $nombre,
            $telefono,
            $mail,
            $direccion,
            $direccionPisoDepto,
            $idTipoPedido,
            $idBarrio,
            $idSucursal,
            $idBolson,
            $cantBolson,
            $montoTotal,
            $montoPagado,
            $idEstadoPedido,
            $observaciones,
            $idCupon,
            $montoDescuento,
            $idPedidoFijo,
            $idFormaPago
        );

        //PRIMERO ELIMINO LOS EXTRAS QUE EXISTAN PARA DESPUES, SI CORRESPONDE, AGREGAR LOS SELECCIONADOS EN EDITAR
        //EN CADA EXTRA QUE ELIMINO, LE DEVUELVO STOCK SI NO ES ILIMITADO.
        
        $cExtrasExistentes = $this->Order->getExtras($idPedido);
        if(!empty($cExtrasExistentes)){
            $this->load->model('Extra');
            foreach($cExtrasExistentes as $oExtra){
                $this->Order->deleteExtraFromOrder($idPedido,$oExtra->id);
                $this->Extra->aumentarStockExtra($oExtra->id);
            }
        }
        
        //SI HAY, AGREGO LOS EXTRAS
        if(!empty($cExtras)){
            $this->load->model('Extra');
            foreach($cExtras as $oExtra){
                /*$this->Order->addExtra($idPedido,$idExtra);
                $this->Extra->reducirStockExtra($idExtra);*/
                $this->Order->addExtra($idPedido,$oExtra["idExtra"],$oExtra["cantidad"]);
                $this->Extra->reducirStockExtra($oExtra["idExtra"],$oExtra["cantidad"]);

            }
        }

        $return['status'] = self::OK_VALUE;
        $return['idPedido'] = $idPedido;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
        
    }

    public function crearCamionPreConfigurado(){
        $this->output->set_content_type('application/json');
        $idCamionPreConfigurado = -1;

        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        

        $nombre = $this->input->post('camionNombre', true);
        
        if(is_null($nombre)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('CamionesPreConfigurados');
        $idCamionPreConfigurado = $this->CamionesPreConfigurados->add(
            $nombre
        );

        $return['status'] = self::OK_VALUE;
        $return['idCamionPreConfigurado'] = $idCamionPreConfigurado; 
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));        
    }

    public function getCamionPreConfiguradoById($idCamionPreConfigurado){
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        $this->load->model('CamionesPreConfigurados');
        $oCamionPreConfigurado = $this->CamionesPreConfigurados->getById($idCamionPreConfigurado);

        $return['status'] = self::OK_VALUE;
        $return['camionPreConfigurado'] = $oCamionPreConfigurado;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function editarCamionPreConfigurado(){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $idCamionPreConfigurado = $this->input->post('idCamionPreConfigurado', true);
        $nombre = $this->input->post('camionNombre', true);
        
        if(is_null($nombre) || is_null($idCamionPreConfigurado)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('CamionesPreConfigurados');
        
        $this->CamionesPreConfigurados->update(
            $idCamionPreConfigurado,
            $nombre
        );

        $return['status'] = self::OK_VALUE;
        $return['idCamionPreConfigurado'] = $idCamionPreConfigurado; 
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));        
    }    

    public function getAllPuntosDeRetiro(){
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        $this->load->model('Office');
        $cPuntosDeRetiro = [];
        $cPuntosDeRetiro = $this->Office->getAllOrderesByNameASC();
        
        $return['status'] = self::OK_VALUE;
        $return['cPuntosDeRetiro'] = $cPuntosDeRetiro;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));

    }

    public function getAllBarrios(){
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        $this->load->model('Barrio');
        $cBarrios = [];
        $cBarrios = $this->Barrio->getAll();
        
        $return['status'] = self::OK_VALUE;
        $return['cBarrios'] = $cBarrios;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function getAllBarriosActivos(){
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        $this->load->model('Barrio');
        $cBarrios = [];
        $cBarrios = $this->Barrio->getActivos();
        
        $return['status'] = self::OK_VALUE;
        $return['cBarrios'] = $cBarrios;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function getBarriosByIdCamionPreConfigurado($idCamionPreConfigurado){
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $cBarrios = [];
        $this->load->model('CamionesPreConfiguradosPuntosBarrios');
        
        $cBarrios = $this->CamionesPreConfiguradosPuntosBarrios->getAllBarriosByIdCamionPreConfigurado($idCamionPreConfigurado);
        
        $return['status'] = self::OK_VALUE;
        $return['cBarrios'] = $cBarrios;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function getPuntosDeRetiroByIdCamionPreConfigurado($idCamionPreConfigurado){
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $cPuntosRetiro = [];
        $this->load->model('CamionesPreConfiguradosPuntosBarrios');
        
        $cPuntosRetiro = $this->CamionesPreConfiguradosPuntosBarrios->getAllPuntosRetiroByIdCamionPreConfigurado($idCamionPreConfigurado);
        
        $return['status'] = self::OK_VALUE;
        $return['cPuntosRetiro'] = $cPuntosRetiro;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function getPuntosDeRetiroYaAsociadosExcludingIdCamion($idCamionPreConfigurado){
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $cPuntosRetiro = [];
        $this->load->model('CamionesPreConfiguradosPuntosBarrios');
        
        $cPuntosRetiroYaAsociados = $this->CamionesPreConfiguradosPuntosBarrios->getAllPuntosRetiroExcludingIdCamionPreConfigurado($idCamionPreConfigurado);
        
        $return['status'] = self::OK_VALUE;
        $return['cPuntosRetiro'] = $cPuntosRetiroYaAsociados;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function getBarriosYaAsociadosExcludingIdCamion($idCamionPreConfigurado){
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $cBarriosYaAsociados = [];
        $this->load->model('CamionesPreConfiguradosPuntosBarrios');
        
        $cBarriosYaAsociados = $this->CamionesPreConfiguradosPuntosBarrios->getAllBarriosExcludingIdCamionPreConfigurado($idCamionPreConfigurado);
        
        $return['status'] = self::OK_VALUE;
        $return['cBarrios'] = $cBarriosYaAsociados;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function getPuntosRetiroPendientesAsociacion(){
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $cPuntosRetiroPendientesAsociacion = [];
        $this->load->model('Office');
        
        $cPuntosRetiroPendientesAsociacion = $this->Office->getAllPuntosDeRetiroSinAsociar();
        
        $return['status'] = self::OK_VALUE;
        $return['cPuntosRetiroPendientesAsociacion'] = $cPuntosRetiroPendientesAsociacion;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function getBarriosPendientesAsociacion(){
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $cBarriosPendientesAsociacion = [];
        $this->load->model('Barrio');
        
        $cBarriosPendientesAsociacion = $this->Barrio->getAllBarriosSinAsociar();
        
        $return['status'] = self::OK_VALUE;
        $return['cBarriosPendientesAsociacion'] = $cBarriosPendientesAsociacion;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function deletePuntoRetiroFromCamionPreConfigurado(){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $idCamionPreConfigurado = $this->input->post('idCamionPreConfigurado', true);
        $idPuntoRetiro = $this->input->post('idPuntoRetiro', true);
        
        if(is_null($idCamionPreConfigurado) || is_null($idPuntoRetiro)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('CamionesPreConfiguradosPuntosBarrios');
        
        $oCamionPreConfPuntosBarrios = $this->CamionesPreConfiguradosPuntosBarrios->getByIdCamionPreConfiguradoAndIdPuntoRetiro(
            $idCamionPreConfigurado,
            $idPuntoRetiro
        );

        $this->CamionesPreConfiguradosPuntosBarrios->delete($oCamionPreConfPuntosBarrios->id);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));              
    }

    public function addPuntoRetiroToCamionPreConfigurado(){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $idCamionPreConfigurado = $this->input->post('idCamionPreConfigurado', true);
        $idPuntoRetiro = $this->input->post('idPuntoRetiro', true);
        
        if(is_null($idCamionPreConfigurado) || is_null($idPuntoRetiro)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('CamionesPreConfiguradosPuntosBarrios');
        
        $this->CamionesPreConfiguradosPuntosBarrios->addPuntoRetiro(
            $idCamionPreConfigurado,
            $idPuntoRetiro
        );

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));            
    }

    public function deleteBarrioFromCamionPreConfigurado(){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $idCamionPreConfigurado = $this->input->post('idCamionPreConfigurado', true);
        $idBarrio = $this->input->post('idBarrio', true);
        
        if(is_null($idCamionPreConfigurado) || is_null($idBarrio)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('CamionesPreConfiguradosPuntosBarrios');
        
        $oCamionPreConfPuntosBarrios = $this->CamionesPreConfiguradosPuntosBarrios->getByIdCamionPreConfiguradoAndIdBarrio(
            $idCamionPreConfigurado,
            $idBarrio
        );

        $this->CamionesPreConfiguradosPuntosBarrios->delete($oCamionPreConfPuntosBarrios->id);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));              
    }

    public function addBarrioToCamionPreConfigurado(){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $idCamionPreConfigurado = $this->input->post('idCamionPreConfigurado', true);
        $idBarrio = $this->input->post('idBarrio', true);
        
        if(is_null($idCamionPreConfigurado) || is_null($idBarrio)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('CamionesPreConfiguradosPuntosBarrios');
        
        $this->CamionesPreConfiguradosPuntosBarrios->addBarrio(
            $idCamionPreConfigurado,
            $idBarrio
        );

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));            
    }    

    public function setEstadoEnPreparacionToDiaEntrega(){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $idDiaEntrega = $this->input->post('idDiaEntregaAPreparar', true);
        
        if(is_null($idDiaEntrega)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('DiasEntregaPedidos');
        
        $oDiaEntrega = $this->DiasEntregaPedidos->getById($idDiaEntrega);
        if($oDiaEntrega->id_estado_logistica==1){
            $this->DiasEntregaPedidos->setEstadoEnPreparacion(
                $idDiaEntrega
            );
        }

        $return['status'] = self::OK_VALUE;
        $return['idEstadoLogistica'] = $oDiaEntrega->id_estado_logistica;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));            
    }
    
    public function checkIfDiaEntregaHasLogisticaItems($idDiaEntrega){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        if(is_null($idDiaEntrega)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('Logistica');
        
        $cLogisticaItems = $this->Logistica->getByDiaEntrega(
            $idDiaEntrega
        );

        $diaEntregaHasItems = false;

        if(count($cLogisticaItems)>0){
            $diaEntregaHasItems = true;
        }
        
        $return['status'] = self::OK_VALUE;
        $return['diaEntregaHasItems'] = $diaEntregaHasItems;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));            
    }

    private function addRegistroLogistica($idDiaEntrega, $idPuntoRetiro, $idBarrio, $cantidad, $cantidadEspeciales, $cantidadBolsonesIndividuales, $cantidadBolsonesIndividualesEspeciales, $totalPedidosTienda, $totalPedidos){
        $this->Logistica->add(
            $idDiaEntrega,
            $idPuntoRetiro,
            $idBarrio,
            $cantidad,
            $cantidadEspeciales,
            $cantidadBolsonesIndividuales,
            $cantidadBolsonesIndividualesEspeciales,
            $totalPedidosTienda,
            $totalPedidos
        );
    }

    public function setNroOrdenForPedidosByDiaEntrega(){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $idDiaEntrega = $this->input->post('idDiaEntrega', true);
        
        if(is_null($idDiaEntrega)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('Order');
        $nroOrden = 1;

        $cOrders = $this->Order->getOrdersForEnumerationInDiaEntrega($idDiaEntrega);
        foreach($cOrders as $order){
            $this->Order->setNroOrden($order->id, $nroOrden);
            $nroOrden++;
        }
        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));            
    }

    public function crearRegistrosInicialesLogistica(){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $idDiaEntrega = $this->input->post('idDiaEntrega', true);
        
        if(is_null($idDiaEntrega)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('Order');
        $this->load->model('Logistica');
        $idExtraBolsonIndividual = 1; //Es el ID del bolson individual, cargado como extra.
        $oPuntoRetiroTotalBolsones = 0;
        $oPuntoRetiroTotalEspeciales = 0;
        $oPuntoRetiroTotalBolsonIndividual = 0;
        $oPuntoRetiroTotalBolsonIndividualEspecial = 0;
        $oPuntoRetiroTotalPedidosTienda = 0;
        $totalPedidosPdR = 0; 

        $oBarrioTotalBolsones = 0;
        $oBarrioTotalEspeciales = 0;
        $oBarrioTotalBolsonIndividual = 0;
        $oBarrioTotalBolsonIndividualEspecial = 0;
        $oBarrioTotalPedidosTienda = 0;
        $totalPedidosBarrios = 0;
        //TRAIGO TODOS LOS PUNTOS DE RETIRO QUE TENGAN PEDIDOS EL DIA DE ENTREGA PASADO POR PARAMETRO
        $cPuntosRetiro = $this->Order->getPuntosRetiroInDiaEntrega($idDiaEntrega);

        //ARRAY DONDE VOY A IR METIENDO PUNTO DE RETIRO Y SU TOTAL CALCULADO DE BOLSONES
        $aPuntosRetiroInfo = [];

        if( isset($cPuntosRetiro) && count($cPuntosRetiro)>0){

            foreach($cPuntosRetiro as $oPuntoRetiro){
                //TRAIGO EL TOTAL DE BOLSONES POR DIA DE ENTREGA Y PUNTO DE RETIRO
                $oPuntoRetiroTotalBolsones = $this->Order->getTotalOrdersByIdDiaEntregaAndIdPuntoRetiro(
                    $idDiaEntrega,
                    $oPuntoRetiro->id
                );        

                $oPuntoRetiroTotalEspeciales = $this->Order->getTotalOrdersEspecialesByIdDiaEntregaAndIdPuntoRetiro(
                    $idDiaEntrega,
                    $oPuntoRetiro->id
                );

                $oPuntoRetiroTotalBolsonIndividual =  $this->Order->getTotalExtrasByPuntoDeRetiroByIdDiaEntregaByIdExtra(
                    $oPuntoRetiro->id,
                    $idDiaEntrega,
                    $idExtraBolsonIndividual
                );

                $oPuntoRetiroTotalBolsonIndividualEspecial =  $this->Order->getTotalOrdersEspecialesConBolsonIndividualByPuntoDeRetiroByIdDiaEntrega(
                    $oPuntoRetiro->id,
                    $idDiaEntrega
                );

                //Pedidos Tienda => Pedidos sin bolson familiar/individual
                $oPuntoRetiroTotalPedidosTienda = $this->Order->getTotalPedidosTiendaByPuntoDeRetiroByIdDiaEntrega(
                    $oPuntoRetiro->id,
                    $idDiaEntrega
                );
                
                $totalPedidosPdR = $this->Order->getSumatoriaPedidosByIdDiaEntregaAndIdPuntoRetiro(
                    $idDiaEntrega,
                    $oPuntoRetiro->id
                );

                //METO EL PUNTO DE RETIRO Y SU CANTIDAD CALCULADA DE BOLSONES EN EL ARRAY

                array_push($aPuntosRetiroInfo,array(
                    'idPuntoRetiro' => $oPuntoRetiro->id,
                    'totalBolsones' => $oPuntoRetiroTotalBolsones,
                    'totalEspeciales' => $oPuntoRetiroTotalEspeciales,
                    'totalBolsonIndividual' => $oPuntoRetiroTotalBolsonIndividual,
                    'totalBolsonIndividualEspecial' => $oPuntoRetiroTotalBolsonIndividualEspecial,
                    'totalPedidosTienda' => $oPuntoRetiroTotalPedidosTienda,
                    'totalPedidosPdR' => $totalPedidosPdR
                ));                
            }
        }
        
        //RECORRO EL ARRAY DE PUNTOS DE RETIRO Y TOTALES Y POR CADA UNO GENERO UN REGISTRO EN LOGISTICA
        if(isset($aPuntosRetiroInfo) && count($aPuntosRetiroInfo)>0){
            foreach($aPuntosRetiroInfo as $oPuntoRetiroInfo){
                //EL PARAMETRO EN NULL ES EL ID_BARRIO
                $this->addRegistroLogistica($idDiaEntrega,$oPuntoRetiroInfo["idPuntoRetiro"],null,$oPuntoRetiroInfo["totalBolsones"],$oPuntoRetiroInfo["totalEspeciales"],$oPuntoRetiroInfo["totalBolsonIndividual"],$oPuntoRetiroInfo["totalBolsonIndividualEspecial"],$oPuntoRetiroInfo["totalPedidosTienda"],$oPuntoRetiroInfo["totalPedidosPdR"]);
            }
        }
        
        //TRAIGO TODOS LOS BARRIOS QUE TENGAN PEDIDOS EL DIA DE ENTREGA PASADO POR PARAMETRO
        $cBarrios = $this->Order->getBarriosInDiaEntrega($idDiaEntrega);

        //ARRAY DONDE VOY A IR METIENDO BARRIO Y SU TOTAL CALCULADO DE BOLSONES
        $aBarriosInfo = [];

        if( isset($cBarrios) && count($cBarrios)>0){

            foreach($cBarrios as $oBarrio){
                //TRAIGO EL TOTAL DE BOLSONES POR DIA DE ENTREGA Y BARRIO
                $oBarrioTotalBolsones = $this->Order->getTotalOrdersByIdDiaEntregaAndIdBarrio(
                    $idDiaEntrega,
                    $oBarrio->id
                );        

                $oBarrioTotalEspeciales = $this->Order->getTotalOrdersEspecialesByIdDiaEntregaAndIdBarrio(
                    $idDiaEntrega,
                    $oBarrio->id
                );

                $oBarrioTotalBolsonIndividual = $this->Order->getTotalExtrasByBarrioByIdDiaEntregaByIdExtra(
                    $oBarrio->id,
                    $idDiaEntrega,
                    $idExtraBolsonIndividual
                );

                $oBarrioTotalBolsonIndividualEspecial =  $this->Order->getTotalOrdersEspecialesConBolsonIndividualByBarrioByIdDiaEntrega(
                    $oBarrio->id,
                    $idDiaEntrega
                );

                if(is_null($oBarrioTotalEspeciales)){
                    $oBarrioTotalEspeciales = 0;
                }

                //Pedidos Tienda => Pedidos sin bolson familiar/individual
                $oBarrioTotalPedidosTienda = $this->Order->getTotalPedidosTiendaByBarrioByIdDiaEntrega(
                    $oBarrio->id,
                    $idDiaEntrega
                );

                $totalPedidosBarrio = $this->Order->getSumatoriaPedidosByIdDiaEntregaAndIdBarrio(
                    $idDiaEntrega,
                    $oBarrio->id
                );

                //METO EL BARRIO Y SU CANTIDAD CALCULADA DE BOLSONES EN EL ARRAY
                array_push($aBarriosInfo,array(
                    'idBarrio' => $oBarrio->id,
                    'totalBolsones' => $oBarrioTotalBolsones,
                    'totalEspeciales' => $oBarrioTotalEspeciales,
                    'totalBolsonIndividual' => $oBarrioTotalBolsonIndividual,
                    'totalBolsonIndividualEspeciales' => $oBarrioTotalBolsonIndividualEspecial,
                    'totalPedidosTienda' => $oBarrioTotalPedidosTienda,
                    'totalPedidosBarrio' => $totalPedidosBarrio
                ));                
            }
        }
        
        //RECORRO EL ARRAY DE BARRIOS Y TOTALES Y POR CADA UNO GENERO UN REGISTRO EN LOGISTICA
        if(isset($aBarriosInfo) && count($aBarriosInfo)>0){
            foreach($aBarriosInfo as $oBarrioInfo){
                //EL PARAMETRO EN NULL ES EL ID_PUNTO_RETIRO
                $this->addRegistroLogistica($idDiaEntrega,null,$oBarrioInfo["idBarrio"],$oBarrioInfo["totalBolsones"],$oBarrioInfo["totalEspeciales"],$oBarrioInfo["totalBolsonIndividual"],$oBarrioInfo["totalBolsonIndividualEspeciales"],$oBarrioInfo["totalPedidosTienda"],$oBarrioInfo["totalPedidosBarrio"]);
            }
        }

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));            
    }

    public function getLogisticaPuntosRetiroByDiaEntrega($idDiaEntrega){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        if(is_null($idDiaEntrega)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('Logistica');
        $this->load->model('DiasEntregaPedidos');
        
        $cLogisticaPuntosRetiro = $this->Logistica->getLogisticaPuntosRetiroByDiaEntrega(
            $idDiaEntrega
        );

        $oDiaEntrega = $this->DiasEntregaPedidos->getById($idDiaEntrega);
        $idEstadoLogistica = 1;
        if(!is_null($oDiaEntrega)){
            if(!is_null($oDiaEntrega->id_estado_logistica) && $oDiaEntrega->id_estado_logistica>0){
                $idEstadoLogistica = $oDiaEntrega->id_estado_logistica;
            }
        }
        $return['status'] = self::OK_VALUE;
        $return['cLogisticaPuntosRetiro'] = $cLogisticaPuntosRetiro;
        $return['idEstadoLogistica'] = $idEstadoLogistica;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));              
    }

    public function getLogisticaBarriosByDiaEntrega($idDiaEntrega){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        if(is_null($idDiaEntrega)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('Logistica');
        
        $cLogisticaBarrios = $this->Logistica->getLogisticaBarriosByDiaEntrega(
            $idDiaEntrega
        );

        $return['status'] = self::OK_VALUE;
        $return['cLogisticaBarrios'] = $cLogisticaBarrios;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));              
    }

    public function eliminarRegistrosLogistica(){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $idDiaEntrega = $this->input->post('idDiaEntrega', true);
        
        if(is_null($idDiaEntrega)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('Logistica');
        
        $this->Logistica->deleteRegistrosLogisticaByIdDiaEntrega(
            $idDiaEntrega
        );

        $this->load->model('DiasEntregaPedidos');
        $this->DiasEntregaPedidos->setEstadoSinPreparar($idDiaEntrega);

        $this->load->model('LogisticaDiasEntregaCamiones');
        $this->LogisticaDiasEntregaCamiones->deleteCamionesByDia($idDiaEntrega);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));                
    }

    public function getDiasEntregaAPreparar(){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('DiasEntregaPedidos');
        
        //$cDiasEntrega = $this->DiasEntregaPedidos->getAllDiasByEstadoLogisticaNotCerrados();
        $cDiasEntrega = $this->DiasEntregaPedidos->getAllActivosSinExcluidos();
        //print_r($cDiasEntrega);
        $return['status'] = self::OK_VALUE;
        $return['cDiasEntrega'] = $cDiasEntrega;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }

    public function getCantidadModificadaFromBolsonIndividualByLogistica($idLogistica) {
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('Logistica');
        
        $oLogistica = $this->Logistica->getById($idLogistica);

        $return['status'] = self::OK_VALUE;
        $return['cantidadModificadaBolsonIndividual'] = $oLogistica->cantidad_bolsones_individuales_modificado;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }

    public function getCantidadModificadaFromBolsonFamiliarByLogistica($idLogistica){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('Logistica');
        
        $oLogistica = $this->Logistica->getById($idLogistica);

        $return['status'] = self::OK_VALUE;
        $return['cantidadModificadaBolsonFamiliar'] = $oLogistica->cantidad_modificada;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }

    public function getNombrePuntoRetiroBarrioByLogistica($idLogistica){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('Logistica');
        
        $oLogistica = $this->Logistica->getById($idLogistica);
        $nombre = "";
        
        if(isset($oLogistica->id_punto_retiro) && $oLogistica->id_punto_retiro>0){
            $this->load->model('Office');
            $oPuntoRetiro = $this->Office->getById($oLogistica->id_punto_retiro);
            $nombre = $oPuntoRetiro->name;
        }else if(isset($oLogistica->id_barrio) && $oLogistica->id_barrio>0){
            $this->load->model('Barrio');
            $oBarrio = $this->Barrio->getById($oLogistica->id_barrio);
            $nombre = $oBarrio->nombre;
        }
        $return['status'] = self::OK_VALUE;
        $return['nombrePuntoRetiroBarrio'] = $nombre;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }

    public function modificarCantidadBolsonesPuntoRetiroBarrio(){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $idLogistica = $this->input->post('idLogistica', true);
        $cantModificadaBolsonFamiliar = $this->input->post('cantModificadaBolsonFamiliar', true);
        $cantModificadaBolsonIndividual = $this->input->post('cantModificadaBolsonIndividual', true);
        
        if(is_null($idLogistica) || is_null($cantModificadaBolsonFamiliar) || is_null($cantModificadaBolsonFamiliar)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('Logistica');
        
        $editOK = $this->Logistica->updateCantidadModificada(
            $idLogistica,
            $cantModificadaBolsonFamiliar,
            $cantModificadaBolsonIndividual
        );

        $return['status'] = self::OK_VALUE;
        $return['cantidadModificadaOK'] = $editOK;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));              
    }

    public function getCamionesPreConfiguradosDisponibles($idDiaEntrega){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('LogisticaDiasEntregaCamiones'); 
        $cCamionesPreConfigurados = $this->LogisticaDiasEntregaCamiones->getCamionesPreConfiguradosDisponibles($idDiaEntrega);
        
        $return['status'] = self::OK_VALUE;
        $return['cCamionesPreConfigurados'] = $cCamionesPreConfigurados;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function createLogisticaCamionDiaEntrega(){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $idDiaEntrega = $this->input->post('idDiaEntrega', true);
        $nombreCamion = $this->input->post('nombreCamion', true);
        $idCamionPreConfigurado = $this->input->post('idCamionPreConfigurado', true);
        
        if(is_null($idDiaEntrega) || is_null($nombreCamion)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('LogisticaDiasEntregaCamiones');
        
        $idLogisticaDiasEntregaCamion = $this->LogisticaDiasEntregaCamiones->addCamion(
            $idDiaEntrega,
            $nombreCamion,
            $idCamionPreConfigurado
        );

        $return['status'] = self::OK_VALUE;
        $return['idLogisticaDiasEntregaCamion'] = $idLogisticaDiasEntregaCamion;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));              
    }

    public function asociarPuntosRetiroBarriosACamion(){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $idDiaEntrega = $this->input->post('idDiaEntrega', true);
        $idLogisticaDiasEntregaCamion = $this->input->post('idLogisticaDiasEntregaCamion', true);
        
        
        if(is_null($idDiaEntrega) || is_null($idLogisticaDiasEntregaCamion)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('LogisticaDiasEntregaCamiones');
        
        $oLogisticaDiaEntregaCamion = $this->LogisticaDiasEntregaCamiones->getById(
            $idLogisticaDiasEntregaCamion
        );

        $this->load->model('CamionesPreConfiguradosPuntosBarrios');
        
        $cPuntosRetiroAAsociar = $this->CamionesPreConfiguradosPuntosBarrios->getAllPuntosRetiroByIdCamionPreConfigurado(
            $oLogisticaDiaEntregaCamion->id_camion_pre_configurado
        );

        $cBarriosAAsociar = $this->CamionesPreConfiguradosPuntosBarrios->getAllBarriosByIdCamionPreConfigurado(
            $oLogisticaDiaEntregaCamion->id_camion_pre_configurado
        );

        $this->load->model('Logistica');
        foreach($cPuntosRetiroAAsociar as $oPuntoRetiroAAsociar){
            $oLogistica = $this->Logistica->getLogisticaByDiaEntregaAndPuntoRetiro(
                $idDiaEntrega,
                $oPuntoRetiroAAsociar->idPuntoRetiro
            );
            $this->Logistica->setLogisticaCamion($oLogistica->id_logistica,$oLogisticaDiaEntregaCamion->id);
        }

        foreach($cBarriosAAsociar as $oBarrioAAsociar){
            $oLogistica = $this->Logistica->getLogisticaByDiaEntregaAndBarrio(
                $idDiaEntrega,
                $oBarrioAAsociar->idBarrio
            );
            $this->Logistica->setLogisticaCamion($oLogistica->id_logistica,$oLogisticaDiaEntregaCamion->id);
        }

        $return['status'] = self::OK_VALUE;
        $return['asociacionOK'] = true;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));              

    }

    public function getCamionesByDiaEntrega($idDiaEntrega){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('LogisticaDiasEntregaCamiones');
        $this->load->model('Logistica');        
        
        $cCamiones = $this->LogisticaDiasEntregaCamiones->getByDiaEntrega($idDiaEntrega);
        $arrayCamionesConCantidad = [];
        
        foreach($cCamiones as $oLogisticaCamion){
            $cLogisticas = $this->Logistica->getLogisticaByDiaEntregaAndCamion(
                $idDiaEntrega,
                $oLogisticaCamion->id
            );
            $cantBolsonesFamiliares = 0;
            $cantBolsonesFamiliaresEspeciales = 0;
            $cantBolsonesIndividuales = 0;
            $cantBolsonesIndividualesEspeciales = 0;
            $cantPedidosTienda = 0;
            $cantPedidosTotales = 0;

            foreach($cLogisticas as $oLogistica){
                $cantBolsonesFamiliares = $cantBolsonesFamiliares + $oLogistica->cantidad_modificada;
                $cantBolsonesFamiliaresEspeciales = $cantBolsonesFamiliaresEspeciales + $oLogistica->cantidad_especiales;
                $cantBolsonesIndividuales = $cantBolsonesIndividuales + $oLogistica->cantidad_bolsones_individuales_modificado;
                $cantBolsonesIndividualesEspeciales = $cantBolsonesIndividualesEspeciales + $oLogistica->cantidad_bolsones_individuales_especiales;
                $cantPedidosTienda = $cantPedidosTienda + $oLogistica->total_pedidos_tienda;
                $cantPedidosTotales = $cantPedidosTotales + $oLogistica->total_pedidos;
            }
        
            array_push($arrayCamionesConCantidad,array(
                'idLogisticaCamion' => $oLogisticaCamion->id,
                'nombreCamion' => $oLogisticaCamion->camion,
                'cantBolsonesFamiliares' => $cantBolsonesFamiliares,
                'cantBolsonesFamiliaresEspeciales' => $cantBolsonesFamiliaresEspeciales,
                'cantBolsonesIndividuales' => $cantBolsonesIndividuales,
                'cantBolsonesIndividualesEspeciales' => $cantBolsonesIndividualesEspeciales,
                'cantPedidosTienda' => $cantPedidosTienda,
                'cantPedidosTotales' => $cantPedidosTotales
            ));
        
        }
        
        $return['status'] = self::OK_VALUE;
        $return['cCamiones'] = $arrayCamionesConCantidad;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));        
    }

    public function getPuntosRetiroByCamion($idCamion){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('Logistica');        
        
        $cPuntosDeRetiro = $this->Logistica->getLogisticaPuntosDeRetiroByCamion($idCamion);

        $return['status'] = self::OK_VALUE;
        $return['cPuntosDeRetiro'] = $cPuntosDeRetiro;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));                
    }

    public function getBarriosByCamion($idCamion){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('Logistica');        
        
        $cBarrios = $this->Logistica->getLogisticaBarriosByCamion($idCamion);

        $return['status'] = self::OK_VALUE;
        $return['cBarrios'] = $cBarrios;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));                
    }

    public function getBarriosByDiaEntrega() {
        $this->output->set_content_type('application/json');
        $this->load->model('Barrio');

        $idDiaEntrega = $this->input->post('idDiaEntrega', true);

        $cBarriosHabilitados = $this->Barrio->getBarriosHabilitadosByDiaEntrega($idDiaEntrega);
        if(isset($cBarriosHabilitados) && count($cBarriosHabilitados)>0){
            $return['success'] = true;    
        }else{
            $return['success'] = false;    
        }
        $return['cBarriosHabilitados'] = $cBarriosHabilitados;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));

    }

    public function editBarriosHabilitadosByDiaEntrega() {
        $this->output->set_content_type('application/json');
        $this->load->model('DiasEntregaBarrios');

        $idDiaEntrega = $this->input->post('idDiaEntrega', true);
        $preCollectionIdBarriosHabilitados = $this->input->post('arrayBarriosHabilitados', true);
        $cBarriosHabilitados = [];
        $editOK = false;
        
        $this->DiasEntregaBarrios->deleteAllBarrios($idDiaEntrega);
        //print_r(gettype($preCollectionIdBarriosHabilitados));
        if(gettype($preCollectionIdBarriosHabilitados)=="array"){
            foreach($preCollectionIdBarriosHabilitados as $barrio){
                array_push($cBarriosHabilitados,array(
                    'idBarrio' => $barrio['idBarrio']
                )); 
            }
            foreach($cBarriosHabilitados as $oIdBarrio) {
                $this->DiasEntregaBarrios->add($idDiaEntrega, $oIdBarrio["idBarrio"]);
            }                
        }
        $editOK = true;

        $return['success'] = $editOK;    
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));

    }

    public function deleteLogisticaFromCamion(){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $idLogistica = $this->input->post('idLogistica', true);
        
        if(is_null($idLogistica)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('Logistica');
        
        $deleteOK = $this->Logistica->removeLogisticaCamion(
            $idLogistica
        );

        $return['status'] = self::OK_VALUE;
        $return['deleteOK'] = $deleteOK;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));     
    }

    public function setCamionToLogistica(){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $idLogistica = $this->input->post('idLogistica', true);
        $idCamion = $this->input->post('idCamion', true);
        
        if(is_null($idLogistica) || is_null($idCamion)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('Logistica');
        
        $camionAsociadoOK = $this->Logistica->setLogisticaCamion(
            $idLogistica, 
            $idCamion
        );

        $return['status'] = self::OK_VALUE;
        $return['camionAsociadoOK'] = $camionAsociadoOK;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }

    private function createSpreadsheetByLogisticaPuntoRetiro($idLogistica){
        $this->load->model('Logistica');
        $this->load->model('Extra');
        $this->load->model('Order');
        $this->load->model('Office');

        $oLogistica = $this->Logistica->getById($idLogistica);
        $cExtras = $this->Extra->getActive();

        $idDiaEntrega = $oLogistica->id_dia_entrega;
        $idPuntoRetiro = $oLogistica->id_punto_retiro;
        
        $pedidosCounter = 1;

        $oPuntoDeRetiro = $this->Office->getById($idPuntoRetiro);
        $cOrders = $this->Order->getOrdersPuntosRetiroWithExtrasByIdDiaEntregaAndIdPuntoRetiro($idDiaEntrega,$idPuntoRetiro);
        
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.1);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.1);

        $lastColumn = 'A';
        $xlsCol = 'A';
        $xlsRow = 1;

        $sheet->setCellValue($xlsCol.$xlsRow, 'Cliente');
        $sheet->getColumnDimension($xlsCol)->setWidth(27);
        $xlsCol++;
        $sheet->setCellValue($xlsCol.$xlsRow, 'Celular');
        $sheet->getColumnDimension($xlsCol)->setWidth(18);
        $xlsCol++;
        $sheet->setCellValue($xlsCol.$xlsRow, 'Bolsones');
        $sheet->getColumnDimension($xlsCol)->setWidth(10);
        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setTextRotation(90);
        $xlsCol++;
        $sheet->setCellValue($xlsCol.$xlsRow, 'Precio');
        $sheet->getColumnDimension($xlsCol)->setWidth(11);
        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setTextRotation(90);
        $xlsCol++;
        //->setCellValue('A'.$xlsRow, 'Fecha')

        
        foreach($cExtras as $oExtra){
            if(isset($oExtra->nombre_corto) && $oExtra->nombre_corto!=""){
                $sheet->setCellValue($xlsCol.$xlsRow, $oExtra->nombre_corto);
            }else{
                $sheet->setCellValue($xlsCol.$xlsRow, $oExtra->name);
            }
            $sheet->getColumnDimension($xlsCol)->setWidth(11);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setTextRotation(90);
            $xlsCol++;
        }            
        $sheet->setCellValue($xlsCol.$xlsRow, 'Total');
        $sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setTextRotation(90);
        $xlsCol++;

        $sheet->setCellValue($xlsCol.$xlsRow, 'Observaciones');
        $sheet->getColumnDimension($xlsCol)->setWidth(20);

        $lastColumn = $xlsCol;
        
        $sheet->getRowDimension($xlsRow)->setRowHeight(75);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        //Array de estilos para las celdas. Lo aplico por fila.
        $headerStyleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            ),
            'font'  => array(
                'size'  => 12
            )
        );

        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            ),
            'font'  => array(
                'size'  => 14
            )
        );        
        
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($headerStyleArray);

        $xlsRow++;



        /**LINEA DE NOMBRE DE PUNTO DE RETIRO Y SUBTOTALES */
        $xlsCol = 'A';
        $sheet->getRowDimension($xlsRow)->setRowHeight(26);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($headerStyleArray);
        
        $sheet->setCellValue($xlsCol.$xlsRow, $oPuntoDeRetiro->name." - ".$oPuntoDeRetiro->address);
        $sheet->mergeCells('A'.$xlsRow.':'.'B'.$xlsRow);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getFont()->setBold(true);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setWrapText(true);
        $sheet->getRowDimension($xlsRow)->setRowHeight(60);

        //POR EL COLSPAN DE ARRIBA, LA DEJO DIRECTO EN LA COLUMAN DE BOLSONES (LA "D").
        $xlsCol='C';
        $sheet->setCellValue($xlsCol.$xlsRow, $oLogistica->cantidad_modificada);
        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $xlsCol++;

        //LO DEJO EN LA PRIMER COLUMNA DE EXTRAS
        $xlsCol = 'E';

        foreach($cExtras as $oExtra){
            $totalExtras = $this->Order->getTotalExtrasByPuntoDeRetiroByIdDiaEntregaByIdExtra(
                $idPuntoRetiro,
                $idDiaEntrega,
                $oExtra->id
            );
            $sheet->setCellValue($xlsCol.$xlsRow, $totalExtras);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getColumnDimension($xlsCol)->setWidth(11);
            $xlsCol++;    
        }

        $xlsRow++;
        
        foreach($cOrders as $oOrder){
            $xlsCol = 'A';
            
            $sheet->setCellValue($xlsCol.$xlsRow, $oOrder['nro_orden']." - ".$oOrder['cliente']);            
            $sheet->getColumnDimension($xlsCol)->setWidth(27);
            $xlsCol++;
            
            $celularFormateado = $this->formatCelular($oOrder['celular']);
            $sheet->setCellValue($xlsCol.$xlsRow, " ".$celularFormateado);            
            $sheet->getColumnDimension($xlsCol)->setWidth(18);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            $xlsCol++;

            $cantidadBolson = 0;
            $precioBolson = 0;

            if(!is_null($oOrder['cant_bolson']) && $oOrder['cant_bolson']!=""){
                $cantidadBolson = $oOrder['cant_bolson'];
                $precioBolson = $oOrder['total_bolson'];
            }

            $sheet->setCellValue($xlsCol.$xlsRow, $cantidadBolson);
            $sheet->getColumnDimension($xlsCol)->setWidth(10);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $xlsCol++;

            $sheet->setCellValue($xlsCol.$xlsRow, $precioBolson); 
            $sheet->getColumnDimension($xlsCol)->setWidth(11);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
            $xlsCol++;

            $extrasArray = $oOrder['extras'];
            foreach($cExtras as $oExtra){ //Array de extras activos en la base de datos (con esto identifico la columna)
                foreach($extrasArray as $ordenExtra){ //Array de extras en la orden (con esto pongo el precio en la columna correcta)
                    if($oExtra->id == $ordenExtra['id_extra']){
                        $cantExtra = $this->Order->getCantOrderExtraByPedidoAndExtra($oOrder['order_id'],$oExtra->id);
                        if(!isset($cantExtra)){
                            $cantExtra = 1;
                        }else{
                            $cantExtra = $cantExtra[0]->cant;
                        }
                        //print_r($cantExtra);
                        $precio = ($ordenExtra['extra_price'] * $cantExtra);

                        $precioCant = "$".$precio;
                        $precioCant .= "\n(x".$cantExtra.")";

                        $sheet->setCellValue($xlsCol.$xlsRow, $precioCant);
                        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $sheet->getColumnDimension($xlsCol)->setWidth(11);
                    }
                }
                //$sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
                $xlsCol++;
            }
            
            $sheet->setCellValue($xlsCol.$xlsRow, $oOrder['monto_debe']);
            $sheet->getColumnDimension($xlsCol)->setWidth(10);
            $sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            if($oOrder['monto_debe']>0){
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
            }else{
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
            }

            $sheet->getRowDimension($xlsRow)->setRowHeight(32);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($styleArray);
            $xlsCol++;

            
            $obs = "";

            if($oOrder['id_estado_pedido']==2){
                $obs .= "ESPECIAL - ";
            }
            if($oOrder['id_estado_pedido']==3){
                $obs .= "BONIFICADO - ";
            }
            if($oOrder['observaciones']!=""){
                $obs .= $oOrder['observaciones'];
            }
            
            if($oOrder['id_cupon'] != null && $oOrder['id_cupon']>0) {
                if($obs==""){
                    $obs = "Cupón de Descuento aplicado.";
                }else{
                    $obs = $obs." - "."Cupón de Descuento aplicado.";
                }    
            }

            $sheet->setCellValue($xlsCol.$xlsRow,$obs);

            $sheet->getColumnDimension($xlsCol)->setWidth(20);    
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            
            if($oOrder['id_estado_pedido']==2 || $oOrder['id_estado_pedido']==3){
                $sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFb8b8b8');
            }
            
            $xlsRow++;
            $pedidosCounter++;
        }
        return $spreadsheet;
    }

    private function createSpreadsheetByLogisticaBarrio($idLogistica){
        $this->load->model('Logistica');
        $this->load->model('Extra');
        $this->load->model('Order');
        $this->load->model('Barrio');

        $oLogistica = $this->Logistica->getById($idLogistica);
        $cExtras = $this->Extra->getActive();

        $pedidosCounter = 1;

        $idDiaEntrega = $oLogistica->id_dia_entrega;
        $idBarrio = $oLogistica->id_barrio;
        
        $oBarrio = $this->Barrio->getById($idBarrio);
        $cOrders = $this->Order->getOrdersBarriosWithExtrasByIdDiaEntregaAndIdBarrio($idDiaEntrega,$idBarrio);
        
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.1);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.1);

        $lastColumn = 'A';
        $xlsCol = 'A';
        $xlsRow = 1;

        $sheet->setCellValue($xlsCol.$xlsRow, 'Cliente');
        $sheet->getColumnDimension($xlsCol)->setWidth(27);
        $xlsCol++;
        $sheet->setCellValue($xlsCol.$xlsRow, 'Celular');
        $sheet->getColumnDimension($xlsCol)->setWidth(18);
        $xlsCol++;
        $sheet->setCellValue($xlsCol.$xlsRow, 'Dirección');
        $sheet->getColumnDimension($xlsCol)->setWidth(40);
        $xlsCol++;
        $sheet->setCellValue($xlsCol.$xlsRow, 'Bolsones');
        $sheet->getColumnDimension($xlsCol)->setWidth(10);
        $xlsCol++;
        $sheet->setCellValue($xlsCol.$xlsRow, 'Precio');
        $sheet->getColumnDimension($xlsCol)->setWidth(11);
        $xlsCol++;
        //->setCellValue('A'.$xlsRow, 'Fecha')

        
        foreach($cExtras as $oExtra){
            if(isset($oExtra->nombre_corto) && $oExtra->nombre_corto!=""){
                $sheet->setCellValue($xlsCol.$xlsRow, $oExtra->nombre_corto);
            }else{
                $sheet->setCellValue($xlsCol.$xlsRow, $oExtra->name);
            }
            $sheet->getColumnDimension($xlsCol)->setWidth(11);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
            $xlsCol++;
        }            
        $sheet->setCellValue($xlsCol.$xlsRow, 'Total');
        $sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
        $xlsCol++;

        $sheet->setCellValue($xlsCol.$xlsRow, 'Observaciones');
        $sheet->getColumnDimension($xlsCol)->setWidth(20);

        $lastColumn = $xlsCol;

        $sheet->getRowDimension($xlsRow)->setRowHeight(75);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        //Array de estilos para las celdas. Lo aplico por fila.
        $headerStyleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            ),
            'font'  => array(
                'size'  => 12
            )
        );

        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            ),
            'font'  => array(
                'size'  => 14
            )
        );        
        
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($headerStyleArray);

        $xlsRow++;



        /**LINEA DE NOMBRE DE BARRIOS Y SUBTOTALES */
        $xlsCol = 'A';
        $sheet->getRowDimension($xlsRow)->setRowHeight(26);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($headerStyleArray);
        
        $sheet->setCellValue($xlsCol.$xlsRow, $oBarrio->nombre." - ".$oBarrio->observaciones);
        $sheet->mergeCells('A'.$xlsRow.':'.'C'.$xlsRow);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getFont()->setBold(true);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setWrapText(true);
        $sheet->getRowDimension($xlsRow)->setRowHeight(60);

        //POR EL COLSPAN DE ARRIBA, LA DEJO DIRECTO EN LA COLUMAN DE BOLSONES (LA "D").
        $xlsCol='D';
        $sheet->setCellValue($xlsCol.$xlsRow, $oLogistica->cantidad_modificada);
        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $xlsCol++;

        //E ES LA COLUMNA DE PRECIO QUE ACA NO LLEVA NADA

        //LO DEJO EN LA PRIMER COLUMNA DE EXTRAS
        $xlsCol = 'F';

        foreach($cExtras as $oExtra){
            $totalExtras = $this->Order->getTotalExtrasByBarrioByIdDiaEntregaByIdExtra(
                $idBarrio,
                $idDiaEntrega,
                $oExtra->id
            );
            $sheet->setCellValue($xlsCol.$xlsRow, $totalExtras);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getColumnDimension($xlsCol)->setWidth(11);
            $xlsCol++;    
        }

        $xlsRow++;
        
        foreach($cOrders as $oOrder){
            $xlsCol = 'A';
            
            $sheet->setCellValue($xlsCol.$xlsRow, $oOrder['nro_orden']." - ".$oOrder['cliente']);            
            $sheet->getColumnDimension($xlsCol)->setWidth(27);
            $xlsCol++;
            
            $celularFormateado = $this->formatCelular($oOrder['celular']);
            $sheet->setCellValue($xlsCol.$xlsRow, " ".$celularFormateado);            
            $sheet->getColumnDimension($xlsCol)->setWidth(18);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            $xlsCol++;

            $sheet->setCellValue($xlsCol.$xlsRow, " ".$oOrder['cliente_domicilio_full']);            
            $sheet->getColumnDimension($xlsCol)->setWidth(40);
            $xlsCol++;

            $cantidadBolson = 0;
            $precioBolson = 0;

            if(!is_null($oOrder['cant_bolson']) && $oOrder['cant_bolson']!=""){
                $cantidadBolson = $oOrder['cant_bolson'];
                $precioBolson = $oOrder['total_bolson'];
            }

            $sheet->setCellValue($xlsCol.$xlsRow, $cantidadBolson);
            $sheet->getColumnDimension($xlsCol)->setWidth(10);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $xlsCol++;

            $sheet->setCellValue($xlsCol.$xlsRow, $precioBolson); 
            $sheet->getColumnDimension($xlsCol)->setWidth(11);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
            $xlsCol++;

            $extrasArray = $oOrder['extras'];
            foreach($cExtras as $oExtra){ //Array de extras activos en la base de datos (con esto identifico la columna)
                foreach($extrasArray as $ordenExtra){ //Array de extras en la orden (con esto pongo el precio en la columna correcta)
                    if($oExtra->id == $ordenExtra['id_extra']){
                        $cantExtra = $this->Order->getCantOrderExtraByPedidoAndExtra($oOrder['order_id'],$oExtra->id);
                        if(!isset($cantExtra)){
                            $cantExtra = 1;
                        }else{
                            $cantExtra = $cantExtra[0]->cant;
                        }
                        //print_r($cantExtra);
                        $precio = ($ordenExtra['extra_price'] * $cantExtra);                        

                        $precioCant = "$".$precio;
                        $precioCant .= "\n(x".$cantExtra.")";

                        $sheet->setCellValue($xlsCol.$xlsRow, $precioCant);
                        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $sheet->getColumnDimension($xlsCol)->setWidth(11);
                    }
                }
                //$sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
                $xlsCol++;
            }

            $sheet->setCellValue($xlsCol.$xlsRow, $oOrder['monto_debe']);
            $sheet->getColumnDimension($xlsCol)->setWidth(10);
            $sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            if($oOrder['monto_debe']>0){
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
            }else{
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
            }

            $sheet->getRowDimension($xlsRow)->setRowHeight(32);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($styleArray);
            $xlsCol++;

            $obs = "";

            if($oOrder['id_estado_pedido']==2){
                $obs .= "ESPECIAL - ";
            }
            if($oOrder['id_estado_pedido']==3){
                $obs .= "BONIFICADO - ";
            }
            if($oOrder['observaciones']!=""){
                $obs .= $oOrder['observaciones'];
            }

            if($oOrder['id_cupon'] != null && $oOrder['id_cupon']>0) {
                if($obs==""){
                    $obs = "Cupón de Descuento aplicado.";
                }else{
                    $obs = $obs." - "."Cupón de Descuento aplicado.";
                }    
            }

            $sheet->setCellValue($xlsCol.$xlsRow,$obs);
            $sheet->getColumnDimension($xlsCol)->setWidth(20);    
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            if($oOrder['id_estado_pedido']==2 || $oOrder['id_estado_pedido']==3){
                $sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFb8b8b8');
            }

            $xlsRow++;
            $pedidosCounter++;
        }

        return $spreadsheet;
    }

    public function printLogisticaIndividual(){
        $this->output->set_content_type('application/json');

        $idLogistica = $this->input->post('idLogistica', true);
        //TIPO IMPRESION EN ESTE TIPO NO SIRVE PORQUE SE ESTA SELECCIONANDO SOLO UNO
        //$tipoImpresion = $this->input->post('tipoImpresion', true);
        $tipoExtension = $this->input->post('tipoExtension', true);
        $idTipoLogistica = $this->input->post('idTipoLogistica', true);

        if(is_null($idLogistica) || is_null($idTipoLogistica)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        if(isset($idTipoLogistica) && $idTipoLogistica==1){
            //SI ES PUNTO DE RETIRO
            $spreadsheet = $this->createSpreadsheetByLogisticaPuntoRetiro($idLogistica);
        }else{
            //SI ES BARRIO
            $spreadsheet = $this->createSpreadsheetByLogisticaBarrio($idLogistica);
        }
        
        $fileName = "";
        if($tipoExtension==1){
            //SI ES XLS
            $fileName = "Logistica.xls";
            $writer = new Xlsx($spreadsheet);        
            $writer->save($fileName);
        }else if($tipoExtension==2){
            //SI ES PDF
            $fileName = "Logistica.pdf";
    
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet);
            $writer->save($fileName);
        }


        $return['status'] = self::OK_VALUE;
        $return['fileName'] = $fileName;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           

    }    

    public function printLogisticaMultipleInCards() {
        $this->output->set_content_type('application/json');

        $preArrayLogistica = $this->input->post('arrayLogistica', true);
        $idTipoLogistica = $this->input->post('idTipoLogistica', true);

        if(is_null($preArrayLogistica) || is_null($idTipoLogistica)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        $fileName = "";
        $idsLogistica = "";
        foreach($preArrayLogistica as $logistica){
            if($idsLogistica!=""){
                $idsLogistica .= ",";
            }
            $idsLogistica .= $logistica['idLogistica'];
        }
        $this->load->model('Logistica');
        $cLogistica = $this->Logistica->getByIds($idsLogistica);
        $arrayLogistica = [];
        foreach($cLogistica as $oLogistica){
            array_push($arrayLogistica,array(
                'idLogistica' => $oLogistica->id_logistica
            ));
        }
        
        $fileName = "ComandasPedidos.pdf";

        if(isset($idTipoLogistica) && $idTipoLogistica==1){
            //PdR
            $this->createPDFComandasPedidosByLogisticaPuntosRetiro($arrayLogistica);
        } else {
            //Domicilio
            $this->createPDFComandasPedidosByLogisticaBarrios($arrayLogistica);
        }
        
        $return['status'] = self::OK_VALUE;
        $return['fileName'] = $fileName;
        //$this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }

    public function printLogisticaMultiple(){
        $this->output->set_content_type('application/json');

        $preArrayLogistica = $this->input->post('arrayLogistica', true);
        $tipoImpresion = $this->input->post('tipoImpresion', true);
        $tipoExtension = $this->input->post('tipoExtension', true);
        $idTipoLogistica = $this->input->post('idTipoLogistica', true);

        if(is_null($preArrayLogistica) || is_null($idTipoLogistica)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        $fileName = "";
        $idsLogistica = "";
        
        foreach($preArrayLogistica as $logistica){
            if($idsLogistica!=""){
                $idsLogistica .= ",";
            }
            $idsLogistica .= $logistica['idLogistica'];
        }
        $this->load->model('Logistica');
        $cLogistica = $this->Logistica->getByIds($idsLogistica);
        $arrayLogistica = [];
        foreach($cLogistica as $oLogistica){
            array_push($arrayLogistica,array(
                'idLogistica' => $oLogistica->id_logistica
            ));
        }

        if(isset($idTipoLogistica) && $idTipoLogistica==1){
            //SI ES PUNTO DE RETIRO
            if($tipoExtension==1){
                //SI ES XLS
                $spreadsheet = $this->createSpreadsheetMultipleLogisticaPuntoRetiro($arrayLogistica);    
                $fileName = "Logistica.xls";
                $writer = new Xlsx($spreadsheet);        
                $writer->save($fileName);    
            }else{
                if($tipoImpresion==1){
                    $this->createPDFMultipleLogisticaPuntosRetiroUnoPorHoja($arrayLogistica);    
                }else{
                    $this->createPDFMultipleLogisticaPuntosRetiroContinuado($arrayLogistica);    
                }
                $fileName = "Logistica.pdf";
            }
        }else{
            //SI ES BARRIO
            if($tipoExtension==1){
                //SI ES XLS
                $spreadsheet = $this->createSpreadsheetMultipleLogisticaBarrios($arrayLogistica);    
                $fileName = "Logistica.xls";
                $writer = new Xlsx($spreadsheet);        
                $writer->save($fileName);    
            }else{
                if($tipoImpresion==1){
                    $this->createPDFMultipleLogisticaBarriosUnoPorHoja($arrayLogistica);    
                }else{
                    $this->createPDFMultipleLogisticaBarriosContinuado($arrayLogistica);    
                }
                $fileName = "Logistica.pdf";
            }
        }
        
        $return['status'] = self::OK_VALUE;
        $return['fileName'] = $fileName;
        //$this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }        

    private function createSpreadsheetMultipleLogisticaPuntoRetiro($arrayLogistica){
        $this->load->model('Logistica');
        $this->load->model('Extra');
        $this->load->model('Order');
        $this->load->model('Office');

        //Array de estilos para las celdas. Lo aplico por fila.
        $headerStyleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            ),
            'font'  => array(
                'size'  => 12
            )
        );

        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            ),
            'font'  => array(
                'size'  => 14
            )
        );        

        $cExtras = $this->Extra->getActive();

        $spreadsheet = new Spreadsheet();

        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.1);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.1);

        $lastColumn = 'A';
        $xlsRow = 1;
        $xlsCol = 'A';

        $pedidosCounter = 1;

        $sheet->setCellValue($xlsCol.$xlsRow, 'Cliente');
        $sheet->getColumnDimension($xlsCol)->setWidth(27);
        $xlsCol++;
        $sheet->setCellValue($xlsCol.$xlsRow, 'Email');
        $sheet->getColumnDimension($xlsCol)->setWidth(30);        
        $xlsCol++;
        $sheet->setCellValue($xlsCol.$xlsRow, 'Celular');
        $sheet->getColumnDimension($xlsCol)->setWidth(18);
        $xlsCol++;
        $sheet->setCellValue($xlsCol.$xlsRow, 'Bolsón Familiar (8kg)');
        $sheet->getColumnDimension($xlsCol)->setWidth(10);
        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
        $xlsCol++;
        $sheet->setCellValue($xlsCol.$xlsRow, 'Precio Bolsón Familiar');
        $sheet->getColumnDimension($xlsCol)->setWidth(11);
        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
        $xlsCol++;
        //->setCellValue('A'.$xlsRow, 'Fecha')
        
        foreach($cExtras as $oExtra){
            if(isset($oExtra->nombre_corto) && $oExtra->nombre_corto!=""){
                $sheet->setCellValue($xlsCol.$xlsRow, $oExtra->nombre_corto);
            }else{
                $sheet->setCellValue($xlsCol.$xlsRow, $oExtra->name);
            }
            $sheet->getColumnDimension($xlsCol)->setWidth(11);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
            $xlsCol++;
        }            

        $sheet->setCellValue($xlsCol.$xlsRow, 'Reserva Abonada');
        //$sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
        $xlsCol++;

        $sheet->setCellValue($xlsCol.$xlsRow, 'Total a Cobrar');
        $sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
        $xlsCol++;

        $sheet->setCellValue($xlsCol.$xlsRow, 'Observaciones');
        $sheet->getColumnDimension($xlsCol)->setWidth(20);

        $lastColumn = $xlsCol;

        $sheet->getRowDimension($xlsRow)->setRowHeight(75);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($headerStyleArray);
        //$spreadsheet->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd($xlsRow, $xlsRow);

        $xlsRow++;

        $firstTime = true; /** Lo voy a usar para que la primera vez, dentro del for, no arme de nuevo la cabecera de titulos.*/
        foreach($arrayLogistica as $oLogistica){
            $oLogistica = $this->Logistica->getById($oLogistica['idLogistica']);
    
            $idDiaEntrega = $oLogistica->id_dia_entrega;
            $idPuntoRetiro = $oLogistica->id_punto_retiro;
            
            $oPuntoDeRetiro = $this->Office->getById($idPuntoRetiro);
            $cOrders = $this->Order->getOrdersPuntosRetiroWithExtrasByIdDiaEntregaAndIdPuntoRetiro($idDiaEntrega,$idPuntoRetiro);

            if(!$firstTime) {
                $xlsRow++; /** Sumo una row más para tener un espacio entre el ultimo pedido del PdR anterior y la cabecera nueva del siguiente PdR */
                $xlsCol = 'A';

                $sheet->setCellValue($xlsCol.$xlsRow, 'Cliente');
                $sheet->getColumnDimension($xlsCol)->setWidth(27);
                $xlsCol++;
                $sheet->setCellValue($xlsCol.$xlsRow, 'Email');
                $sheet->getColumnDimension($xlsCol)->setWidth(30);        
                $xlsCol++;
                $sheet->setCellValue($xlsCol.$xlsRow, 'Celular');
                $sheet->getColumnDimension($xlsCol)->setWidth(18);
                $xlsCol++;
                $sheet->setCellValue($xlsCol.$xlsRow, 'Bolsón Familiar (8kg)');
                $sheet->getColumnDimension($xlsCol)->setWidth(10);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                $xlsCol++;
                $sheet->setCellValue($xlsCol.$xlsRow, 'Precio Bolsón Familiar');
                $sheet->getColumnDimension($xlsCol)->setWidth(11);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                $xlsCol++;
                
                foreach($cExtras as $oExtra){
                    if(isset($oExtra->nombre_corto) && $oExtra->nombre_corto!=""){
                        $sheet->setCellValue($xlsCol.$xlsRow, $oExtra->nombre_corto);
                    }else{
                        $sheet->setCellValue($xlsCol.$xlsRow, $oExtra->name);
                    }
                    $sheet->getColumnDimension($xlsCol)->setWidth(11);
                    $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                    $xlsCol++;
                }            
        
                $sheet->setCellValue($xlsCol.$xlsRow, 'Reserva Abonada');
                //$sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                $xlsCol++;
        
                $sheet->setCellValue($xlsCol.$xlsRow, 'Total a Cobrar');
                $sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                $xlsCol++;
        
                $sheet->setCellValue($xlsCol.$xlsRow, 'Observaciones');
                $sheet->getColumnDimension($xlsCol)->setWidth(20);
        
                $sheet->getRowDimension($xlsRow)->setRowHeight(75);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($headerStyleArray);
        
                $xlsRow++;                        
            }else{
                $firstTime = false;
            }


            /**LINEA DE NOMBRE DE PUNTO DE RETIRO Y SUBTOTALES */
            $xlsCol = 'A';
            $sheet->getRowDimension($xlsRow)->setRowHeight(26);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($headerStyleArray);
            
            $sheet->setCellValue($xlsCol.$xlsRow, $oPuntoDeRetiro->name." - ".$oPuntoDeRetiro->address);
            $sheet->mergeCells('A'.$xlsRow.':'.'B'.$xlsRow);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getFont()->setBold(true);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setWrapText(true);
            $sheet->getRowDimension($xlsRow)->setRowHeight(60);

            //POR EL COLSPAN DE ARRIBA, LA DEJO DIRECTO EN LA COLUMAN DE BOLSONES (LA "D").
            $xlsCol='D';
            $sheet->setCellValue($xlsCol.$xlsRow, $oLogistica->cantidad_modificada);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $xlsCol++;

            //LO DEJO EN LA PRIMER COLUMNA DE EXTRAS (MENOS UNA COLUMNA, NO ENTIENDO PORQUE FUNCIONA ASI EL INDICE)
            $xlsCol = 'F';

            foreach($cExtras as $oExtra){
                $totalExtras = $this->Order->getTotalExtrasByPuntoDeRetiroByIdDiaEntregaByIdExtra(
                    $idPuntoRetiro,
                    $idDiaEntrega,
                    $oExtra->id
                );
                $sheet->setCellValue($xlsCol.$xlsRow, $totalExtras);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getColumnDimension($xlsCol)->setWidth(11);
                $xlsCol++;    
            }

            $xlsRow++;
            
            foreach($cOrders as $oOrder){
                $xlsCol = 'A';
                
                $sheet->setCellValue($xlsCol.$xlsRow, $oOrder['nro_orden']." - ".$oOrder['cliente']);            
                $sheet->getColumnDimension($xlsCol)->setWidth(27);
                $xlsCol++;

                $sheet->setCellValue($xlsCol.$xlsRow, $oOrder['mail']);
                $sheet->getColumnDimension($xlsCol)->setWidth(30);        
                $xlsCol++;
        
                $celularFormateado = $this->formatCelular($oOrder['celular']);
                $sheet->setCellValue($xlsCol.$xlsRow, " ".$celularFormateado);            
                $sheet->getColumnDimension($xlsCol)->setWidth(18);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                $xlsCol++;

                $cantidadBolson = 0;
                $precioBolson = 0;

                if(!is_null($oOrder['cant_bolson']) && $oOrder['cant_bolson']!=""){
                    $cantidadBolson = $oOrder['cant_bolson'];
                    $precioBolson = $oOrder['total_bolson'];
                }

                $sheet->setCellValue($xlsCol.$xlsRow, $cantidadBolson);
                $sheet->getColumnDimension($xlsCol)->setWidth(10);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $xlsCol++;
                
                $valorCeldaPrecioBolson = "";
                
                if($precioBolson==0) {
                    $valorCeldaPrecioBolson = "-";
                }else{
                    $valorCeldaPrecioBolson = $precioBolson;
                }

                $sheet->setCellValue($xlsCol.$xlsRow, $valorCeldaPrecioBolson); 
                $sheet->getColumnDimension($xlsCol)->setWidth(11);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
                $xlsCol++;

                $extrasArray = $oOrder['extras'];
                foreach($cExtras as $oExtra){ //Array de extras activos en la base de datos (con esto identifico la columna)
                    foreach($extrasArray as $ordenExtra){ //Array de extras en la orden (con esto pongo el precio en la columna correcta)
                        if($oExtra->id == $ordenExtra['id_extra']){
                            $cantExtra = $this->Order->getCantOrderExtraByPedidoAndExtra($oOrder['order_id'],$oExtra->id);
                            if(!isset($cantExtra)){
                                $cantExtra = 1;
                            }else{
                                $cantExtra = $cantExtra[0]->cant;
                            }
                            //print_r($cantExtra);
                            $precio = ($ordenExtra['extra_price'] * $cantExtra); 

                            $precioCant = "$".$precio;
                            $precioCant .= "\n(x".$cantExtra.")";
    
                            $sheet->setCellValue($xlsCol.$xlsRow, $precioCant);
                            $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                            $sheet->getColumnDimension($xlsCol)->setWidth(11);
                        }
                    }
                    //$sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
                    $xlsCol++;
                }

                $valorCeldaMontoPagado = "";
                
                if($oOrder['monto_pagado']==0) {
                    $valorCeldaMontoPagado = "-";
                }else{
                    $valorCeldaMontoPagado = $oOrder['monto_pagado'];
                }

                $sheet->setCellValue($xlsCol.$xlsRow, $valorCeldaMontoPagado);
                $sheet->getColumnDimension($xlsCol)->setWidth(10);
                //$sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');

                $sheet->getRowDimension($xlsRow)->setRowHeight(32);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($styleArray);
                $xlsCol++;

                $valorCeldaMontoDebe = "";
                
                if($oOrder['monto_debe']==0) {
                    $valorCeldaMontoDebe = "-";
                }else{
                    $valorCeldaMontoDebe = $oOrder['monto_debe'];
                }

                $sheet->setCellValue($xlsCol.$xlsRow, $valorCeldaMontoDebe);
                $sheet->getColumnDimension($xlsCol)->setWidth(10);
                $sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');

                $sheet->getRowDimension($xlsRow)->setRowHeight(32);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($styleArray);
                $xlsCol++;

                $obs = "";

                if($oOrder['id_estado_pedido']==2){
                    $obs .= "ESPECIAL - ";
                }
                if($oOrder['id_estado_pedido']==3){
                    $obs .= "BONIFICADO - ";
                }
                if($oOrder['observaciones']!=""){
                    $obs .= $oOrder['observaciones'];
                }

                if($oOrder['id_cupon'] != null && $oOrder['id_cupon']>0) {
                    if($obs==""){
                        $obs = "Cupón de Descuento aplicado.";
                    }else{
                        $obs = $obs." - "."Cupón de Descuento aplicado.";
                    }    
                }
    
                $sheet->setCellValue($xlsCol.$xlsRow, $obs);
                $sheet->getColumnDimension($xlsCol)->setWidth(20);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                if($oOrder['id_estado_pedido']==2 || $oOrder['id_estado_pedido']==3){
                    $sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFb8b8b8');
                }

                $xlsRow++;
                $pedidosCounter++;
            }     
        }
        return $spreadsheet;
    }    

    private function createPDFMultipleLogisticaPuntosRetiroContinuado($arrayLogistica){
        $this->load->model('Logistica');
        $this->load->model('Extra');
        $this->load->model('Order');
        $this->load->model('Office');

        $cExtras = $this->Extra->getActive();
        $cabeceraHTML = "";

        $pedidosCounter = 1;

        $cabeceraHTML .= "<table style='border-collapse:collapse;border:1px solid #000000;width:100%;font-family:Arial;font-size:10px;'><tbody><tr>";
        $cabeceraHTML .= "<td width='180' style='width:180px;max-width:180px;text-align:center;border:1px solid #000000;'>Cliente</td>";
        $cabeceraHTML .= "<td width='180' style='width:180px;max-width:180px;text-align:center;border:1px solid #000000;'>Email</td>";
        $cabeceraHTML .= "<td width='110' style='width:110px;max-width:110px;text-align:center;border:1px solid #000000;'>Celular</td>";
        $cabeceraHTML .= "<td text-rotate='90' style='width:30px;min-width:30px;max-width:30px;text-align:center;border:1px solid #000000;'>Bolsón Familiar (8kg)</td>";
        $cabeceraHTML .= "<td text-rotate='90' style='width:40px;min-width:40px;max-width:40px;text-align:center;border:1px solid #000000;'>Precio Bolsón Familiar</td>";

        $contExtra = 0;
        $pedidoResaltado = false;

        foreach($cExtras as $oExtra){
            $extraName = "";
            if(isset($oExtra->nombre_corto) && $oExtra->nombre_corto!=""){
                $extraName = $oExtra->nombre_corto;
            } else {
                $extraName = $oExtra->name;
            }
            $backgroundColor = "";
            if($contExtra % 2 == 0){
                $backgroundColor = "background-color:#dadada";
            } else {
                $backgroundColor = "background-color:#FFFFFF";
            }
            $cabeceraHTML .= "<td valign='middle' text-rotate='90' style='width:30px;max-width:30px;min-width:30px;text-align:center;border:1px solid #000000;".$backgroundColor."'>".$extraName."</td>";
            $contExtra++;
        }

        $cabeceraHTML .= "<td text-rotate='90' style='width:40px;min-width:40px;max-width:40px;text-align:center;border:1px solid #000000;'>Reserva Abonada</td>";
        $cabeceraHTML .= "<td text-rotate='90' style='width:40px;min-width:40px;max-width:40px;text-align:center;border:1px solid #000000;'>Total a Cobrar</td>";
        $cabeceraHTML .= "<td style='width:80px;min-width:80px;max-width:80px;text-align:center;border:1px solid #000000;'>Observaciones</td>";
        $cabeceraHTML .= "</tr></tbody></table>";
        
        $oPDF = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format'=> 'Legal',
            'orientation' => 'L',
            'margin_left' => '5',
            'margin_right' => '5',
            'margin_top' => '30'
        ]);
        $oPDF->SetHTMLHeader($cabeceraHTML);
        $oPDF->SetTitle('Logistica');
        $oPDF->setFooter('{PAGENO}');
        $html = "";

        $htmlInitTable = "<table style='border-collapse:collapse;border:0px solid #000000;width:100%;font-family:Arial;font-size:10px;'><thead style='border:none'>";
        $htmlInitTable .= "<tr>";
        $htmlInitTable .= "<td width='180' style='width:180px;max-width:180px;'>&nbsp;</td>";
        $htmlInitTable .= "<td width='180' style='width:180px;max-width:180px;'>&nbsp;</td>";
        $htmlInitTable .= "<td width='110' style='width:110px;max-width:110px;'>&nbsp;</td>";
        $htmlInitTable .= "<td text-rotate='90' style='width:30px;min-width:30px;max-width:30px;'>&nbsp;</td>";
        $htmlInitTable .= "<td text-rotate='90' style='width:40px;min-width:40px;max-width:40px;'>&nbsp;</td>";

        foreach($cExtras as $oExtra){
            if(isset($oExtra->nombre_corto) && $oExtra->nombre_corto!=""){
                $htmlInitTable .= "<td valign='middle' text-rotate='90' style='width:30px;max-width:30px;min-width:30px;'>&nbsp;</td>";
            }else{
                $htmlInitTable .= "<td valign='middle' text-rotate='90' style='width:30px;max-width:30px;min-width:30px;'>&nbsp;</td>";
            }
        }        

        $htmlInitTable .= "<td text-rotate='90' style='width:40px;min-width:40px;max-width:40px;'>&nbsp;</td>";
        $htmlInitTable .= "<td text-rotate='90' style='width:40px;min-width:40px;max-width:40px;'>&nbsp;</td>";
        $htmlInitTable .= "<td style='width:80px;min-width:80px;max-width:80px;'>&nbsp;</td>";
        $htmlInitTable .= "</tr>";
        $htmlInitTable .= "</thead>";
        $htmlInitTable .= "<tbody>";
        $html .= $htmlInitTable;

        foreach($arrayLogistica as $logistica){
            
            $oLogistica = $this->Logistica->getById($logistica['idLogistica']);
    
            $idDiaEntrega = $oLogistica->id_dia_entrega;
            $idPuntoRetiro = $oLogistica->id_punto_retiro;
            
            $oPuntoDeRetiro = $this->Office->getById($idPuntoRetiro);
            $cOrders = $this->Order->getOrdersPuntosRetiroWithExtrasByIdDiaEntregaAndIdPuntoRetiro($idDiaEntrega,$idPuntoRetiro);
            $html .= "<tr style='background-color:#000000;'>";
            $html .= "<td height='50' style='font-size:12px;color:#FFFFFF; text-align:left;border:1px solid #000000;' colspan='3'><b>".$oPuntoDeRetiro->name." - ".$oPuntoDeRetiro->address."</b></td>";
            $html .= "<td style='font-size:12px;color:#FFFFFF; text-align:center;border:1px solid #000000;' ><b>".$oLogistica->cantidad_modificada."</b></td>"; 
            $html .= "<td style='border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA PRECIO NO TIENE VALOR
            
            foreach($cExtras as $oExtra){
                $totalExtras = $this->Order->getTotalExtrasByPuntoDeRetiroByIdDiaEntregaByIdExtra(
                    $idPuntoRetiro,
                    $idDiaEntrega,
                    $oExtra->id
                );
                $html .= "<td style='font-size:12px;color:#FFFFFF;font-weight:600;text-align:center;border:1px solid #000000;'><b>".$totalExtras."</b></td>";
            }            
            $html .= "<td style='border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA TOTAL NO TIENE VALOR
            $html .= "<td style='border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA TOTAL NO TIENE VALOR
            $html .= "<td style='border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA OBSERVACIONES NO TIENE VALOR
            $html .= "</tr>";
            
            foreach($cOrders as $oOrder){
                $pedidoResaltado = false;
                if($oOrder['id_estado_pedido']==2 || $oOrder['id_estado_pedido']==3){
                    $html .= "<tr style='font-size:12px;background-color:#b8b8b8;'>";
                    $pedidoResaltado = true;
                }else{
                    $html .= "<tr style='font-size:12px;'>";
                }

                $html .= "<td height='35' style='border:1px solid #000000;'><p style='font-size:12px;'>".$oOrder['nro_orden']." - ".$oOrder['cliente']."</p></td>";
                
                $html .= "<td height='35' style='border:1px solid #000000;'><p style='font-size:10px;'>".$oOrder['mail']."</p></td>";

                $celularFormateado = $this->formatCelular($oOrder['celular']);
                $html .= "<td style='text-align:right;border:1px solid #000000;'><p style='font-size:12px;'>".$celularFormateado."</p></td>";

                $cantidadBolson = 0;
                $precioBolson = 0;

                if(!is_null($oOrder['cant_bolson']) && $oOrder['cant_bolson']!=""){
                    $cantidadBolson = $oOrder['cant_bolson'];
                    $precioBolson = $oOrder['total_bolson'];
                }

                if($precioBolson==0) {
                    $precioBolson = "-";
                }else{
                    $precioBolson = "$".intval($precioBolson);
                }

                $html .= "<td style='text-align:center;border:1px solid #000000;'><p style='font-size:12px;'>".$cantidadBolson."</p></td>";
                $html .= "<td style='text-align:center;border:1px solid #000000;'><p style='font-size:12px;'>".$precioBolson."</p></td>";

                $extrasArray = $oOrder['extras'];
                $contExtra = 0;
                foreach($cExtras as $oExtra){ //Array de extras activos en la base de datos (con esto identifico la columna)
                    $backgroundColor = "";
                    if(!$pedidoResaltado) {
                        if($contExtra % 2 == 0){
                            $backgroundColor = "background-color:#dadada";
                        } else {
                            $backgroundColor = "background-color:#ffffff";
                        }
                    }
                    $html .= "<td style='text-align:center;border:1px solid #000000;".$backgroundColor."'><p style='font-size:10px;'>";
                    $contExtra++;

                    foreach($extrasArray as $ordenExtra){ //Array de extras en la orden (con esto pongo el precio en la columna correcta)
                        if($oExtra->id == $ordenExtra['id_extra']){
                            $cantExtra = $this->Order->getCantOrderExtraByPedidoAndExtra($oOrder['order_id'],$oExtra->id);
                            if(!isset($cantExtra)){
                                $cantExtra = 1;
                            }else{
                                $cantExtra = $cantExtra[0]->cant;
                            }
                            //print_r($cantExtra);
                            $precio = ($ordenExtra['extra_price'] * $cantExtra); 

                            //$html .= "$".$oExtra->price;
                            $html .= "$ ".$precio;
                            $html .= "<br />(x".$cantExtra.")";
                        }
                        
                    }
                    $html .= "</p></td>";
                }

                $valMontoPagado;
                $valMontoDebe;

                if($oOrder['monto_pagado']==0) {
                    $valMontoPagado = "-";
                }else{
                    $valMontoPagado = "$".$oOrder['monto_pagado'];
                }

                if($oOrder['monto_debe']==0) {
                    $valMontoDebe = "-";
                }else{
                    $valMontoDebe = "$".$oOrder['monto_debe'];
                }

                $html .= "<td style='text-align:center;border:1px solid #000000;'><p style='font-size:12px;'>".$valMontoPagado."</p></td>";
                $html .= "<td style='text-align:center;border:1px solid #000000;'><p style='font-size:12px;'><b>".$valMontoDebe."</b></p></td>";

                $obs = "";

                if($oOrder['id_estado_pedido']==2){
                    $obs .= "ESPECIAL - ";
                }
                if($oOrder['id_estado_pedido']==3){
                    $obs .= "BONIFICADO - ";
                }
                if($oOrder['observaciones']!=""){
                    $obs .= $oOrder['observaciones'];
                }

                if($oOrder['id_cupon']!=null && $oOrder['id_cupon']>0) {
                    if($obs==""){
                        $obs = "Cupón de Descuento aplicado.";
                    }else{
                        $obs = $obs." - "."Cupón de Descuento aplicado.";
                    }    
                }
    
                $html .= "<td style='text-align:center;border:1px solid #000000;'><p style='font-size:12px;'>".$obs."</p></td>";

                $html .= "</tr>";
                $pedidosCounter++;
            }             

            
        }
        $html .= "</tbody></table>";
        $oPDF->WriteHTML($html);
        $oPDF->Output('Logistica.pdf', 'F');
        return 1;

    }

    public function printComandaPedido(){
        $this->output->set_content_type('application/json');
        $this->load->model('Order');
        $this->load->model('Office');
        $this->load->model('Barrio');

        $idPedido = $this->input->post('idPedido', true);

        $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        
        $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];        
        
        $fontDir = realpath(__DIR__ . '/../../assets/fonts');
        
        $oPDF = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format'=> 'Legal',
            'orientation' => 'P',
            'margin_left' => '5',
            'margin_right' => '5',
            'margin_top' => '30',
            'fontdata' => $fontData + [
                'helvetica-r' => [
                    'R' => 'HelveticaNeueLTCom-LtCn.ttf',
                    'B' => 'HelveticaNeueLTCom-LtCn.ttf',
                ],
                'helvetica-b' => [
                    'R' => 'HelveticaNeueLTCom-BdCn.ttf',
                    'B' => 'HelveticaNeueLTCom-BdCn.ttf',
                ]
            ]
        ]);

        $oPDF->SetTitle('Comanda Pedido');
        $html = "<div style='width:100%'>";
        $oOrder = $this->Order->getFullById($idPedido);
        $pdrBarrioName = '';
        if ($oOrder["id_tipo_pedido"]==1) {
            $oPuntoDeRetiro = $this->Office->getById($oOrder["id_sucursal"]);
            $pdrBarrioName = $oPuntoDeRetiro->name;
        } else {
            $oBarrio = $this->Barrio->getById($oOrder["id_barrio"]);
            $pdrBarrioName = $oBarrio->nombre;
        }
        $html .= $this->generateComandaPedidoHtml($oOrder, $oOrder["id_tipo_pedido"], $pdrBarrioName);
        $html .= "</div>";
        $oPDF->WriteHTML($html);
        $hash = strval(date('Hms'));
        $fileName = 'ComandaPedido'.$hash.'.pdf';
        $oPDF->Output($fileName, 'F');

        $return['status'] = self::OK_VALUE;
        $return['fileName'] = $fileName;
        return $this->output->set_output(json_encode($return));           
    }


    private function createPDFComandasPedidosByLogisticaBarrios($arrayLogistica) {
        $this->load->model('Logistica');
        $this->load->model('Extra');
        $this->load->model('Order');
        $this->load->model('Barrio');

        $cExtras = $this->Extra->getActive();
        
        $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        
        $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];        
        
        $fontDir = realpath(__DIR__ . '/../../assets/fonts');
        
        $oPDF = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format'=> 'Legal',
            'orientation' => 'P',
            'margin_left' => '5',
            'margin_right' => '5',
            'margin_top' => '30',
            'fontdata' => $fontData + [
                'helvetica-r' => [
                    'R' => 'HelveticaNeueLTCom-LtCn.ttf',
                    'B' => 'HelveticaNeueLTCom-LtCn.ttf',
                ],
                'helvetica-b' => [
                    'R' => 'HelveticaNeueLTCom-BdCn.ttf',
                    'B' => 'HelveticaNeueLTCom-BdCn.ttf',
                ]
            ]
        ]);

        $oPDF->SetTitle('ComandasPedidos');
        
        foreach($arrayLogistica as $logistica){
            $oLogistica = $this->Logistica->getById($logistica['idLogistica']);
            $idDiaEntrega = $oLogistica->id_dia_entrega;
            $idBarrio = $oLogistica->id_barrio;
            $oBarrio = $this->Barrio->getById($idBarrio);
            $cOrders = $this->Order->getOrdersBarriosWithExtrasByIdDiaEntregaAndIdBarrioOrderedByCantExtras($idDiaEntrega,$idBarrio);
            $headerHtml = "<div style='width:100%'>";
            $headerHtml .= "<h1 style='font-family: helvetica-r; padding-bottom:10px;border-bottom:4px solid #000000'>DOMICILIO - BARRIO: <span style='font-family:helvetica-b;'>".strtoupper($oBarrio->nombre)."</span></h1>";
            $headerHtml .= "</div>";
            $oPDF->SetHTMLHeader($headerHtml);
            $oPDF->setFooter('{PAGENO}');
            $oPDF->AddPage(); 
            $html = "<div style='width:100%'>";
            $maxOrdersByPage = 9;
            $contOrders = 0;
            foreach($cOrders as $oOrder) {
                $contOrders++;
                $html .= $this->generateComandaPedidoHtml($oOrder, 2, $oBarrio->nombre);
                if($contOrders == $maxOrdersByPage) {
                    $oPDF->WriteHTML($html."</div><div style='width:100%'>");
                    $html = "";
                    $oPDF->AddPage();
                    $contOrders = 0;
                }
            }
            $html .= "</div>";
            $oPDF->WriteHTML($html);
        }
        $oPDF->Output('ComandasPedidos.pdf', 'F');
        return 1;        
    }

    private function createPDFComandasPedidosByLogisticaPuntosRetiro($arrayLogistica) {
        $this->load->model('Logistica');
        $this->load->model('Extra');
        $this->load->model('Order');
        $this->load->model('Office');

        $cExtras = $this->Extra->getActive();
        
        $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        
        $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];        
        
        $fontDir = realpath(__DIR__ . '/../../assets/fonts');
        
        $oPDF = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format'=> 'Legal',
            'orientation' => 'P',
            'margin_left' => '5',
            'margin_right' => '5',
            'margin_top' => '30',
            'fontdata' => $fontData + [
                'helvetica-r' => [
                    'R' => 'HelveticaNeueLTCom-LtCn.ttf',
                    'B' => 'HelveticaNeueLTCom-LtCn.ttf',
                ],
                'helvetica-b' => [
                    'R' => 'HelveticaNeueLTCom-BdCn.ttf',
                    'B' => 'HelveticaNeueLTCom-BdCn.ttf',
                ]
            ]
        ]);

        $oPDF->SetTitle('ComandasPedidos');
        
        
        foreach($arrayLogistica as $logistica){
            $oLogistica = $this->Logistica->getById($logistica['idLogistica']);
            $idDiaEntrega = $oLogistica->id_dia_entrega;
            $idPuntoRetiro = $oLogistica->id_punto_retiro;
            $oPuntoDeRetiro = $this->Office->getById($idPuntoRetiro);
            $cOrders = $this->Order->getOrdersPuntosRetiroWithExtrasByIdDiaEntregaAndIdPuntoRetiroOrderedByCantExtras($idDiaEntrega,$idPuntoRetiro);
            $headerHtml = "<div style='width:100%'>";
            $headerHtml .= "<h1 style='font-family: helvetica-r; padding-bottom:10px;border-bottom:4px solid #000000'>PUNTO DE RETIRO - <span style='font-family:helvetica-b;'>".$oPuntoDeRetiro->name."</span></h1>";
            $headerHtml .= "</div>";
            $oPDF->SetHTMLHeader($headerHtml);
            $oPDF->setFooter('{PAGENO}');
            $oPDF->AddPage(); 
            $html = "<div style='width:100%'>";
            $maxOrdersByPage = 9;
            $contOrders = 0;
            foreach($cOrders as $oOrder) {
                $contOrders++;
                $html .= $this->generateComandaPedidoHtml($oOrder, 1, $oPuntoDeRetiro->name);
                if($contOrders == $maxOrdersByPage) {
                    $oPDF->WriteHTML($html."</div><div style='width:100%'>");
                    $html = "";
                    $oPDF->AddPage();
                    $contOrders = 0;
                }
            }
            $html .= "</div>";
            $oPDF->WriteHTML($html);
        }
        $oPDF->Output('ComandasPedidos.pdf', 'F');
        return 1;
    }

    private function createPDFMultipleLogisticaPuntosRetiroUnoPorHoja($arrayLogistica){
        $this->load->model('Logistica');
        $this->load->model('Extra');
        $this->load->model('Order');
        $this->load->model('Office');

        $cExtras = $this->Extra->getActive();
        
        $oPDF = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format'=> 'Legal',
            'orientation' => 'L',
            'margin_left' => '5',
            'margin_right' => '5',
            'margin_top' => '5'
        ]);

        $oPDF->SetTitle('Logistica');
        
        $html = "";

        $pedidosCounter = 1;

        foreach($arrayLogistica as $logistica){
            $oPDF->AddPage(); 
            $oPDF->setFooter('{PAGENO}');
            $html = "";
            $htmlInitTable = "<table style='border-collapse:collapse;border:1px solid #FF0000;width:100%;font-family:Arial;font-size:10px;'><tbody>";
            $html .= $htmlInitTable;
            $cabeceraHTML = "";

            $cabeceraHTML .= "<tr>";
            $cabeceraHTML .= "<td width='180' style='text-align:center;border:1px solid #000000;'>Cliente</td>";
            $cabeceraHTML .= "<td width='180' style='text-align:center;border:1px solid #000000;'>Email</td>";
            $cabeceraHTML .= "<td width='80' style='text-align:center;border:1px solid #000000;'>Celular</td>";
            $cabeceraHTML .= "<td text-rotate='90' style='width:30px;text-align:center;border:1px solid #000000;'>Bolsón Familiar (8kg)</td>";
            $cabeceraHTML .= "<td text-rotate='90' style='width:40px;text-align:center;border:1px solid #000000;'>Precio Bolsón Familiar</td>";

            $contExtra = 0;
            $pedidoResaltado = false;

            foreach($cExtras as $oExtra){
                $extraName = "";
                if(isset($oExtra->nombre_corto) && $oExtra->nombre_corto!=""){
                    $extraName = $oExtra->nombre_corto;
                } else {
                    $extraName = $oExtra->name;
                }
                $backgroundColor = "";
                if($contExtra % 2 == 0){
                    $backgroundColor = "background-color:#dadada";
                } else {
                    $backgroundColor = "background-color:#FFFFFF";
                }
                $cabeceraHTML .= "<td valign='middle' text-rotate='90' width='30' style='width:30px;max-width:30px;text-align:center;border:1px solid #000000;".$backgroundColor."'>".$extraName."</td>";
                $contExtra++;
            }        
            
            $cabeceraHTML .= "<td text-rotate='90' style='width:40px;text-align:center;border:1px solid #000000;'>Reserva Abonada</td>";
            $cabeceraHTML .= "<td text-rotate='90' style='width:40px;text-align:center;border:1px solid #000000;'>Total a Cobrar</td>";
            $cabeceraHTML .= "<td style='width:80px;text-align:center;border:1px solid #000000;'>Observaciones</td>";
            $cabeceraHTML .= "</tr>";
            $html .= $cabeceraHTML;
            
            $oLogistica = $this->Logistica->getById($logistica['idLogistica']);
    
            $idDiaEntrega = $oLogistica->id_dia_entrega;
            $idPuntoRetiro = $oLogistica->id_punto_retiro;
            
            $oPuntoDeRetiro = $this->Office->getById($idPuntoRetiro);
            $cOrders = $this->Order->getOrdersPuntosRetiroWithExtrasByIdDiaEntregaAndIdPuntoRetiro($idDiaEntrega,$idPuntoRetiro);
            $html .= "<tr style='background-color:#000000;'>";
            $html .= "<td height='50' style='font-size:12px;color:#FFFFFF; text-align:left;border:1px solid #000000;' colspan='3'><b>".$oPuntoDeRetiro->name." - ".$oPuntoDeRetiro->address."</b></td>";
            $html .= "<td style='font-size:12px;color:#FFFFFF; text-align:center;border:1px solid #000000;' ><b>".$oLogistica->cantidad_modificada."</b></td>"; 
            $html .= "<td style='border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA PRECIO NO TIENE VALOR
            
            foreach($cExtras as $oExtra){
                $totalExtras = $this->Order->getTotalExtrasByPuntoDeRetiroByIdDiaEntregaByIdExtra(
                    $idPuntoRetiro,
                    $idDiaEntrega,
                    $oExtra->id
                );
                $html .= "<td style='font-size:12px;color:#FFFFFF;font-weight:600;text-align:center;border:1px solid #000000;'><b>".$totalExtras."</b></td>";
            }            
            $html .= "<td style='border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA TOTAL NO TIENE VALOR
            $html .= "<td style='border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA OBSERVACIONES NO TIENE VALOR
            $html .= "</tr>";
            


            foreach($cOrders as $oOrder){
                $pedidoResaltado = false;
                if($oOrder['id_estado_pedido']==2 || $oOrder['id_estado_pedido']==3){
                    $html .= "<tr style='font-size:12px;background-color:#b8b8b8;'>";
                    $pedidoResaltado = true;
                }else{
                    $html .= "<tr style='font-size:12px;'>";
                }

                $html .= "<td height='35' style='border:1px solid #000000;'><p style='font-size:12px;'>".$oOrder['nro_orden']." - ".$oOrder['cliente']."</p></td>";
                $html .= "<td height='35' style='border:1px solid #000000;'><p style='font-size:12px;'>".$oOrder['mail']."</p></td>";
                $celularFormateado = $this->formatCelular($oOrder['celular']);
                $html .= "<td style='text-align:right;border:1px solid #000000;'><p style='font-size:12px;'>".$celularFormateado."</p></td>";
                
                $cantidadBolson = 0;
                $precioBolson = 0;

                if(!is_null($oOrder['cant_bolson']) && $oOrder['cant_bolson']!=""){
                    $cantidadBolson = $oOrder['cant_bolson'];
                    $precioBolson = $oOrder['total_bolson'];
                }


                if($precioBolson==0) {
                    $precioBolson = "-";
                }else{
                    $precioBolson = "$".intval($precioBolson);
                }

                $html .= "<td style='text-align:center;border:1px solid #000000;'><p style='font-size:12px;'>".$cantidadBolson."</p></td>";
                $html .= "<td style='text-align:center;border:1px solid #000000;'><p style='font-size:12px;'>".$precioBolson."</p></td>";


                $extrasArray = $oOrder['extras'];
                $contExtra = 0;
                foreach($cExtras as $oExtra){ //Array de extras activos en la base de datos (con esto identifico la columna)
                    $backgroundColor = "";
                    if(!$pedidoResaltado) {
                        if($contExtra % 2 == 0){
                            $backgroundColor = "background-color:#dadada";
                        } else {
                            $backgroundColor = "background-color:#ffffff";
                        }
                    }
                    $html .= "<td style='text-align:center;border:1px solid #000000;".$backgroundColor."'><p style='font-size:12px;'>";
                    $contExtra++;

                    foreach($extrasArray as $ordenExtra){ //Array de extras en la orden (con esto pongo el precio en la columna correcta)
                        if($oExtra->id == $ordenExtra['id_extra']){
                            $cantExtra = $this->Order->getCantOrderExtraByPedidoAndExtra($oOrder['order_id'],$oExtra->id);
                            if(!isset($cantExtra)){
                                $cantExtra = 1;
                            }else{
                                $cantExtra = $cantExtra[0]->cant;
                            }
                            //print_r($cantExtra);
                            $precio = ($ordenExtra['extra_price'] * $cantExtra); 

                            //$html .= "$".$oExtra->price;
                            $html .= "$ ".$precio;
                            $html .= "<br />(x".$cantExtra.")";
                        }
                        
                    }
                    $html .= "</p></td>";
                }
                
                $valMontoPagado;
                $valMontoDebe;

                if($oOrder['monto_pagado']==0) {
                    $valMontoPagado = "-";
                }else{
                    $valMontoPagado = "$".$oOrder['monto_pagado'];
                }

                if($oOrder['monto_debe']==0) {
                    $valMontoDebe = "-";
                }else{
                    $valMontoDebe = "$".$oOrder['monto_debe'];
                }

                $html .= "<td style='text-align:center;border:1px solid #000000;'><p style='font-size:12px;'>".$valMontoPagado."</p></td>";
                $html .= "<td style='text-align:center;border:1px solid #000000;'><p style='font-size:12px;'><b>".$valMontoDebe."</b></p></td>";

                $obs = "";

                if($oOrder['id_estado_pedido']==2){
                    $obs .= "ESPECIAL - ";
                }
                if($oOrder['id_estado_pedido']==3){
                    $obs .= "BONIFICADO - ";
                }
                if($oOrder['observaciones']!=""){
                    $obs .= $oOrder['observaciones'];
                }

                if($oOrder['id_cupon'] != null && $oOrder['id_cupon']>0) {
                    if($obs==""){
                        $obs = "Cupón de Descuento aplicado.";
                    }else{
                        $obs = $obs." - "."Cupón de Descuento aplicado.";
                    }    
                }
                    
                $html .= "<td style='text-align:center;border:1px solid #000000;'><p style='font-size:12px;'>".$obs."</p></td>";

                $html .= "</tr>";
                $pedidosCounter++;
            } 
            $html .= "</tbody></table>";

            $oPDF->WriteHTML($html);
        }
        
        $oPDF->Output('Logistica.pdf', 'F');
        return 1;

    }    

    private function createSpreadsheetMultipleLogisticaBarrios($arrayLogistica){
        $this->load->model('Logistica');
        $this->load->model('Extra');
        $this->load->model('Order');
        $this->load->model('Barrio');

        //Array de estilos para las celdas. Lo aplico por fila.
        $headerStyleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            ),
            'font'  => array(
                'size'  => 12
            )
        );

        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            ),
            'font'  => array(
                'size'  => 14
            )
        );        

        $cExtras = $this->Extra->getActive();

        $spreadsheet = new Spreadsheet();

        $pedidosCounter = 1;

        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.1);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.1);

        $lastColumn = 'A';
        $xlsRow = 1;
        $xlsCol = 'A';

        $sheet->setCellValue($xlsCol.$xlsRow, 'Cliente');
        $sheet->getColumnDimension($xlsCol)->setWidth(27);
        $xlsCol++;
        $sheet->setCellValue($xlsCol.$xlsRow, 'Email');
        $sheet->getColumnDimension($xlsCol)->setWidth(30);        
        $xlsCol++;
        $sheet->setCellValue($xlsCol.$xlsRow, 'Celular');
        $sheet->getColumnDimension($xlsCol)->setWidth(18);
        $xlsCol++;
        $sheet->setCellValue($xlsCol.$xlsRow, 'Dirección');
        $sheet->getColumnDimension($xlsCol)->setWidth(40);
        $xlsCol++;
        $sheet->setCellValue($xlsCol.$xlsRow, 'Bolsón Familiar (8kg)');
        $sheet->getColumnDimension($xlsCol)->setWidth(10);
        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
        $xlsCol++;
        $sheet->setCellValue($xlsCol.$xlsRow, 'Precio Bolsón Familiar');
        $sheet->getColumnDimension($xlsCol)->setWidth(11);
        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
        $xlsCol++;
        //->setCellValue('A'.$xlsRow, 'Fecha')

        
        foreach($cExtras as $oExtra){
            if(isset($oExtra->nombre_corto) && $oExtra->nombre_corto!=""){
                $sheet->setCellValue($xlsCol.$xlsRow, $oExtra->nombre_corto);
            }else{
                $sheet->setCellValue($xlsCol.$xlsRow, $oExtra->name);
            }
            $sheet->getColumnDimension($xlsCol)->setWidth(11);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
            $xlsCol++;
        }            
        $sheet->setCellValue($xlsCol.$xlsRow, 'Reserva Abonada');
        //$sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
        $xlsCol++;

        $sheet->setCellValue($xlsCol.$xlsRow, 'Total a Cobrar');
        $sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
        $xlsCol++;

        $sheet->setCellValue($xlsCol.$xlsRow, 'Observaciones');
        $sheet->getColumnDimension($xlsCol)->setWidth(20);

        $lastColumn = $xlsCol;

        $sheet->getRowDimension($xlsRow)->setRowHeight(75);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($headerStyleArray);
        $spreadsheet->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd($xlsRow, $xlsRow);

        $xlsRow++;

        $firstTime = true;
        foreach($arrayLogistica as $oLogistica){
            $oLogistica = $this->Logistica->getById($oLogistica['idLogistica']);
    
            $idDiaEntrega = $oLogistica->id_dia_entrega;
            $idBarrio = $oLogistica->id_barrio;
            
            $oBarrio = $this->Barrio->getById($idBarrio);
            $cOrders = $this->Order->getOrdersBarriosWithExtrasByIdDiaEntregaAndIdBarrio($idDiaEntrega,$idBarrio);

            if(!$firstTime) {
                $xlsRow++;
                $xlsCol = 'A';

                $sheet->setCellValue($xlsCol.$xlsRow, 'Cliente');
                $sheet->getColumnDimension($xlsCol)->setWidth(27);
                $xlsCol++;
                $sheet->setCellValue($xlsCol.$xlsRow, 'Email');
                $sheet->getColumnDimension($xlsCol)->setWidth(30);        
                $xlsCol++;
                $sheet->setCellValue($xlsCol.$xlsRow, 'Celular');
                $sheet->getColumnDimension($xlsCol)->setWidth(18);
                $xlsCol++;
                $sheet->setCellValue($xlsCol.$xlsRow, 'Dirección');
                $sheet->getColumnDimension($xlsCol)->setWidth(40);
                $xlsCol++;
                $sheet->setCellValue($xlsCol.$xlsRow, 'Bolsón Familiar (8kg)');
                $sheet->getColumnDimension($xlsCol)->setWidth(10);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                $xlsCol++;
                $sheet->setCellValue($xlsCol.$xlsRow, 'Precio Bolsón Familiar');
                $sheet->getColumnDimension($xlsCol)->setWidth(11);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                $xlsCol++;
                //->setCellValue('A'.$xlsRow, 'Fecha')
        
                
                foreach($cExtras as $oExtra){
                    if(isset($oExtra->nombre_corto) && $oExtra->nombre_corto!=""){
                        $sheet->setCellValue($xlsCol.$xlsRow, $oExtra->nombre_corto);
                    }else{
                        $sheet->setCellValue($xlsCol.$xlsRow, $oExtra->name);
                    }
                    $sheet->getColumnDimension($xlsCol)->setWidth(11);
                    $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                    $xlsCol++;
                }            
                $sheet->setCellValue($xlsCol.$xlsRow, 'Reserva Abonada');
                //$sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                $xlsCol++;
        
                $sheet->setCellValue($xlsCol.$xlsRow, 'Total a Cobrar');
                $sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                $xlsCol++;
        
                $sheet->setCellValue($xlsCol.$xlsRow, 'Observaciones');
                $sheet->getColumnDimension($xlsCol)->setWidth(20);
        
                $lastColumn = $xlsCol;
        
                $sheet->getRowDimension($xlsRow)->setRowHeight(75);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($headerStyleArray);
                $spreadsheet->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd($xlsRow, $xlsRow);
        
                $xlsRow++;
            } else {
                $firstTime = false;
            }

            /**LINEA DE NOMBRE DE PUNTO DE RETIRO Y SUBTOTALES */
            $xlsCol = 'A';
            $sheet->getRowDimension($xlsRow)->setRowHeight(26);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($headerStyleArray);
            
            $sheet->setCellValue($xlsCol.$xlsRow, $oBarrio->nombre." - ".$oBarrio->observaciones);
            $sheet->mergeCells('A'.$xlsRow.':'.'C'.$xlsRow);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getFont()->setBold(true);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setWrapText(true);
            $sheet->getRowDimension($xlsRow)->setRowHeight(60);

            //POR EL COLSPAN DE ARRIBA, LA DEJO DIRECTO EN LA COLUMAN DE BOLSONES (LA "D").
            $xlsCol='E';
            $sheet->setCellValue($xlsCol.$xlsRow, $oLogistica->cantidad_modificada);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $xlsCol++;

            //LO DEJO EN LA PRIMER COLUMNA DE EXTRAS
            $xlsCol = 'G';

            foreach($cExtras as $oExtra){
                $totalExtras = $this->Order->getTotalExtrasByBarrioByIdDiaEntregaByIdExtra(
                    $idBarrio,
                    $idDiaEntrega,
                    $oExtra->id
                );
                $sheet->setCellValue($xlsCol.$xlsRow, $totalExtras);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getColumnDimension($xlsCol)->setWidth(11);
                $xlsCol++;    
            }

            $xlsRow++;
            
            foreach($cOrders as $oOrder){
                $xlsCol = 'A';
                
                $sheet->setCellValue($xlsCol.$xlsRow, $oOrder['nro_orden']." - ".$oOrder['cliente']);            
                $sheet->getColumnDimension($xlsCol)->setWidth(27);
                $xlsCol++;
                $sheet->setCellValue($xlsCol.$xlsRow, $oOrder['mail']);
                $sheet->getColumnDimension($xlsCol)->setWidth(30);        
                $xlsCol++;
                        
                $celularFormateado = $this->formatCelular($oOrder['celular']);
                $sheet->setCellValue($xlsCol.$xlsRow, " ".$celularFormateado);            
                $sheet->getColumnDimension($xlsCol)->setWidth(18);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                $xlsCol++;

                $sheet->setCellValue($xlsCol.$xlsRow, " ".$oOrder['cliente_domicilio_full']);            
                $sheet->getColumnDimension($xlsCol)->setWidth(40);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                $xlsCol++;

                $cantidadBolson = 0;
                $precioBolson = 0;

                if(!is_null($oOrder['cant_bolson']) && $oOrder['cant_bolson']!=""){
                    $cantidadBolson = $oOrder['cant_bolson'];
                    $precioBolson = $oOrder['total_bolson'];
                }

                $valCeldaPrecioBolson = "-";
                if($precioBolson>0) {
                    $valCeldaPrecioBolson = $precioBolson;
                }

                $sheet->setCellValue($xlsCol.$xlsRow, $cantidadBolson);
                $sheet->getColumnDimension($xlsCol)->setWidth(10);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $xlsCol++;

                $sheet->setCellValue($xlsCol.$xlsRow, $valCeldaPrecioBolson); 
                $sheet->getColumnDimension($xlsCol)->setWidth(11);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
                $xlsCol++;

                $extrasArray = $oOrder['extras'];
                foreach($cExtras as $oExtra){ //Array de extras activos en la base de datos (con esto identifico la columna)
                    foreach($extrasArray as $ordenExtra){ //Array de extras en la orden (con esto pongo el precio en la columna correcta)
                        if($oExtra->id == $ordenExtra['id_extra']){
                            $cantExtra = $this->Order->getCantOrderExtraByPedidoAndExtra($oOrder['order_id'],$oExtra->id);
                            if(!isset($cantExtra)){
                                $cantExtra = 1;
                            }else{
                                $cantExtra = $cantExtra[0]->cant;
                            }
                            //print_r($cantExtra);
                            $precio = ($ordenExtra['extra_price'] * $cantExtra); 

                            $precioCant = "$".$precio;
                            $precioCant .= "\n(x".$cantExtra.")";
    
                            $sheet->setCellValue($xlsCol.$xlsRow, $precioCant);
                            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                            $sheet->getColumnDimension($xlsCol)->setWidth(11);
                        }
                    }
                    //$sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
                    $xlsCol++;
                }

                $valMontoPagado;
                $valMontoDebe;

                if($oOrder['monto_pagado'] > 0) {
                    $valMontoPagado = $oOrder['monto_pagado'];
                } else {
                    $valMontoPagado = "-";
                }

                if($oOrder['monto_debe'] > 0) {
                    $valMontoDebe = $oOrder['monto_debe'];
                } else {
                    $valMontoDebe = "-";
                }

                $sheet->setCellValue($xlsCol.$xlsRow, $valMontoPagado);
                $sheet->getColumnDimension($xlsCol)->setWidth(10);
                //$sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');

                $sheet->getRowDimension($xlsRow)->setRowHeight(32);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($styleArray);
                $xlsCol++;

                $sheet->setCellValue($xlsCol.$xlsRow, $valMontoDebe);
                $sheet->getColumnDimension($xlsCol)->setWidth(10);
                $sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');

                $sheet->getRowDimension($xlsRow)->setRowHeight(32);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($styleArray);
                $xlsCol++;

                $obs = "";

                if($oOrder['id_estado_pedido']==2){
                    $obs .= "ESPECIAL - ";
                }
                if($oOrder['id_estado_pedido']==3){
                    $obs .= "BONIFICADO - ";
                }
                if($oOrder['observaciones']!=""){
                    $obs .= $oOrder['observaciones'];
                }

                if($oOrder['id_cupon'] != null && $oOrder['id_cupon']>0) {
                    if($obs==""){
                        $obs = "Cupón de Descuento aplicado.";
                    }else{
                        $obs = $obs." - "."Cupón de Descuento aplicado.";
                    }    
                }
    
                $sheet->setCellValue($xlsCol.$xlsRow,$obs);
                $sheet->getColumnDimension($xlsCol)->setWidth(20);   
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true); 
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                if($oOrder['id_estado_pedido']==2 || $oOrder['id_estado_pedido']==3){
                    $sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFb8b8b8');
                }

                $xlsRow++;
                $pedidosCounter++;
            }     
        }
        return $spreadsheet;
    }    
    
    private function createPDFMultipleLogisticaBarriosUnoPorHoja($arrayLogistica){
        $this->load->model('Logistica');
        $this->load->model('Extra');
        $this->load->model('Order');
        $this->load->model('Barrio');

        $cExtras = $this->Extra->getActive();
        
        $oPDF = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format'=> 'Legal',
            'orientation' => 'L',
            'margin_left' => '5',
            'margin_right' => '5',
            'margin_top' => '5'
        ]);

        $oPDF->SetTitle('Logistica');

        $html = "";
        $pedidosCounter = 1;

        foreach($arrayLogistica as $logistica){
            $oPDF->AddPage(); 
            $oPDF->setFooter('{PAGENO}');

            $html = "";
            $htmlInitTable = "<table style='border-collapse:collapse;border:1px solid #FF0000;width:100%;font-family:Arial;font-size:10px;'><tbody>";
            $html .= $htmlInitTable;
            $cabeceraHTML = "";

            $cabeceraHTML .= "<tr>";
            $cabeceraHTML .= "<td width='180' style='text-align:center;border:1px solid #000000;'>Cliente</td>";
            $cabeceraHTML .= "<td width='180' style='text-align:center;border:1px solid #000000;'>Email</td>";
            $cabeceraHTML .= "<td width='80' style='text-align:center;border:1px solid #000000;'>Celular</td>";
            $cabeceraHTML .= "<td width='160' style='text-align:center;border:1px solid #000000;'>Dirección</td>";
            $cabeceraHTML .= "<td text-rotate='90' style='width:30px;text-align:center;border:1px solid #000000;'>Bolsón Familiar (8kg)</td>";
            $cabeceraHTML .= "<td text-rotate='90' style='width:40px;text-align:center;border:1px solid #000000;'>Precio Bolsón Familiar</td>";
    
            $contExtra = 0;
            $pedidoResaltado = false;

            foreach($cExtras as $oExtra){
                $extraName = "";
                if(isset($oExtra->nombre_corto) && $oExtra->nombre_corto!=""){
                    $extraName = $oExtra->nombre_corto;
                } else {
                    $extraName = $oExtra->name;
                }
                $backgroundColor = "";
                if($contExtra % 2 == 0){
                    $backgroundColor = "background-color:#dadada";
                } else {
                    $backgroundColor = "background-color:#FFFFFF";
                }
                $cabeceraHTML .= "<td valign='middle' text-rotate='90' style='width:30px;text-align:center;border:1px solid #000000;".$backgroundColor."'>".$extraName."</td>";
                $contExtra++;
            }        
    
            $cabeceraHTML .= "<td text-rotate='90' style='width:40px;text-align:center;border:1px solid #000000;'>Reserva Abonada</td>";
            $cabeceraHTML .= "<td text-rotate='90' style='width:40px;text-align:center;border:1px solid #000000;'>Total a Cobrar</td>";
            $cabeceraHTML .= "<td style='width:80px;text-align:center;border:1px solid #000000;'>Observaciones</td>";
            $cabeceraHTML .= "</tr>";
            $html .= $cabeceraHTML;
            
            $oLogistica = $this->Logistica->getById($logistica['idLogistica']);
    
            $idDiaEntrega = $oLogistica->id_dia_entrega;
            $idBarrio = $oLogistica->id_barrio;
            
            $oBarrio = $this->Barrio->getById($idBarrio);
            $cOrders = $this->Order->getOrdersBarriosWithExtrasByIdDiaEntregaAndIdBarrio($idDiaEntrega,$idBarrio);
            $html .= "<tr style='background-color:#000000;'>";
            $html .= "<td height='50' style='font-size:12px;color:#FFFFFF; text-align:left;border:1px solid #000000;' colspan='4'><b>".$oBarrio->nombre." - ".$oBarrio->observaciones."</b></td>";
            $html .= "<td style='font-size:12px;color:#FFFFFF; text-align:center;border:1px solid #000000;' ><b>".$oLogistica->cantidad_modificada."</b></td>"; 
            $html .= "<td style='border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA PRECIO NO TIENE VALOR
            
            foreach($cExtras as $oExtra){
                $totalExtras = $this->Order->getTotalExtrasByBarrioByIdDiaEntregaByIdExtra(
                    $idBarrio,
                    $idDiaEntrega,
                    $oExtra->id
                );
                $html .= "<td style='font-size:12px;color:#FFFFFF;font-weight:600;text-align:center;border:1px solid #000000;'><b>".$totalExtras."</b></td>";
            }            
            $html .= "<td style='border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA TOTAL NO TIENE VALOR
            $html .= "<td style='border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA OBSERVACIONES NO TIENE VALOR
            $html .= "</tr>";
            


            foreach($cOrders as $oOrder){
                $pedidoResaltado = false;
                if($oOrder['id_estado_pedido']==2 || $oOrder['id_estado_pedido']==3){
                    $pedidoResaltado = true;
                    $html .= "<tr style='font-size:12px;background-color:#b8b8b8;'>";
                }else{
                    $html .= "<tr style='font-size:12px;'>";
                }
                
                $html .= "<td height='35' style='border:1px solid #000000;'><p style='font-size:12px;'>".$oOrder['nro_orden']." - ".$oOrder['cliente']."</p></td>";
                
                $html .= "<td height='35' style='border:1px solid #000000;'><p style='font-size:12px;'>".$oOrder['mail']."</p></td>";

                $celularFormateado = $this->formatCelular($oOrder['celular']);
                $html .= "<td style='text-align:right;border:1px solid #000000;'><p style='font-size:12px;'>".$celularFormateado."</p></td>";

                $html .= "<td style='border:1px solid #000000;'><p style='font-size:12px;'>".$oOrder['cliente_domicilio_full']."</p></td>";

                $cantidadBolson = 0;
                $precioBolson = 0;

                if(!is_null($oOrder['cant_bolson']) && $oOrder['cant_bolson']!=""){
                    $cantidadBolson = $oOrder['cant_bolson'];
                    $precioBolson = $oOrder['total_bolson'];
                }

                if($precioBolson == 0) {
                    $precioBolson = "-";
                } else {
                    $precioBolson = "$".intval($precioBolson);
                }

                $html .= "<td style='text-align:center;border:1px solid #000000;'><p style='font-size:12px;'>".$cantidadBolson."</p></td>";
                $html .= "<td style='text-align:center;border:1px solid #000000;'><p style='font-size:12px;'>".$precioBolson."</p></td>";


                $extrasArray = $oOrder['extras'];
                $contExtra = 0;
                foreach($cExtras as $oExtra){ //Array de extras activos en la base de datos (con esto identifico la columna)
                    $backgroundColor = "";
                    if(!$pedidoResaltado) {
                        if($contExtra % 2 == 0){
                            $backgroundColor = "background-color:#dadada";
                        } else {
                            $backgroundColor = "background-color:#ffffff";
                        }
                    }
                    $html .= "<td style='text-align:center;border:1px solid #000000;".$backgroundColor."'><p style='font-size:12px;'>";
                    $contExtra++;
                    foreach($extrasArray as $ordenExtra){ //Array de extras en la orden (con esto pongo el precio en la columna correcta)
                        if($oExtra->id == $ordenExtra['id_extra']){
                            $cantExtra = $this->Order->getCantOrderExtraByPedidoAndExtra($oOrder['order_id'],$oExtra->id);
                            if(!isset($cantExtra)){
                                $cantExtra = 1;
                            }else{
                                $cantExtra = $cantExtra[0]->cant;
                            }
                            //print_r($cantExtra);
                            $precio = ($ordenExtra['extra_price'] * $cantExtra); 

                            $html .= "$ ".$precio;
                            $html .= "<br />(x".$cantExtra.")";
                        }
                        
                    }
                    $html .= "</p></td>";
                }

                $valMontoPagado;
                $valMontoDebe;

                if($oOrder['monto_pagado'] == 0) {
                    $valMontoPagado = "-";
                } else {
                    $valMontoPagado = "$".$oOrder['monto_pagado'];
                }

                if($oOrder['monto_debe'] == 0) {
                    $valMontoDebe = "-";
                } else {
                    $valMontoDebe = "$".$oOrder['monto_debe'];
                }

                $html .= "<td style='text-align:center;border:1px solid #000000;'><p style='font-size:12px;'>".$valMontoPagado."</p></td>";
                $html .= "<td style='text-align:center;border:1px solid #000000;'><p style='font-size:12px;'><b>".$valMontoDebe."</b></p></td>";

                $obs = "";

                if($oOrder['id_estado_pedido']==2){
                    $obs .= "ESPECIAL - ";
                }
                if($oOrder['id_estado_pedido']==3){
                    $obs .= "BONIFICADO - ";
                }
                if($oOrder['observaciones']!=""){
                    $obs .= $oOrder['observaciones'];
                }

                if($oOrder['id_cupon'] != null && $oOrder['id_cupon']>0) {
                    if($obs==""){
                        $obs = "Cupón de Descuento aplicado.";
                    }else{
                        $obs = $obs." - "."Cupón de Descuento aplicado.";
                    }    
                }

                $html .= "<td style='text-align:center;border:1px solid #000000;'><p style='font-size:12px;'>".$obs."</p></td>";

                $html .= "</tr>";
                $pedidosCounter++;
            } 
            $html .= "</tbody></table>";

            $oPDF->WriteHTML($html);
        }
        
        $oPDF->Output('Logistica.pdf', 'F');
        return 1;

    }    

    private function createPDFMultipleLogisticaBarriosContinuado($arrayLogistica){
        $this->load->model('Logistica');
        $this->load->model('Extra');
        $this->load->model('Order');
        $this->load->model('Barrio');

        $cExtras = $this->Extra->getActive();

        $cabeceraHTML = "";

        $pedidosCounter = 1;

        $cabeceraHTML .= "<table style='border-collapse:collapse;border:1px solid #FF0000;width:100%;font-family:Arial;font-size:10px;'><tbody><tr>";
        $cabeceraHTML .= "<td width='180' style='width:180px;max-width:180px;min-width:180px;text-align:center;border:1px solid #000000;'>Cliente</td>";
        $cabeceraHTML .= "<td width='180' style='width:180px;max-width:180px;min-width:180px;text-align:center;border:1px solid #000000;'>Email</td>";
        $cabeceraHTML .= "<td width='80' style='width:80px;max-width:80px;min-width:80px;text-align:center;border:1px solid #000000;'>Celular</td>";
        $cabeceraHTML .= "<td width='160' style='width:160px;max-width:160px;min-width:160px;text-align:center;border:1px solid #000000;'>Dirección</td>";
        $cabeceraHTML .= "<td text-rotate='90' style='width:30px;max-width:30px;min-width:30px;text-align:center;border:1px solid #000000;'>Bolsón Familiar (8kg)</td>";
        $cabeceraHTML .= "<td text-rotate='90' style='width:40px;max-width:40px;min-width:40px;text-align:center;border:1px solid #000000;'>Precio Bolsón Familiar</td>";
        $contExtra = 0;

        $pedidoResaltado = false;

        foreach($cExtras as $oExtra){
            $extraName = "";
            if(isset($oExtra->nombre_corto) && $oExtra->nombre_corto!=""){
                $extraName = $oExtra->nombre_corto;
            } else {
                $extraName = $oExtra->name;
            }
            $backgroundColor = "";
            if($contExtra % 2 == 0){
                $backgroundColor = "background-color:#dadada";
            } else {
                $backgroundColor = "background-color:#FFFFFF";
            }
            $cabeceraHTML .= "<td valign='middle' text-rotate='90' style='width:30px;max-width:30px;min-width:30px;text-align:center;border:1px solid #000000;".$backgroundColor."'>".$extraName."</td>";
            $contExtra++;
        }        

        $cabeceraHTML .= "<td text-rotate='90' style='width:40px;max-width:40px;min-width:40px;text-align:center;border:1px solid #000000;'>Reserva Abonada</td>";
        $cabeceraHTML .= "<td text-rotate='90' style='width:40px;max-width:40px;min-width:40px;text-align:center;border:1px solid #000000;'>Total a Cobrar</td>";
        $cabeceraHTML .= "<td style='width:80px;max-width:80px;min-width:80px;text-align:center;border:1px solid #000000;'>Observaciones</td>";
        $cabeceraHTML .= "</tr></tbody></table>";

        $oPDF = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format'=> 'Legal',
            'orientation' => 'L',
            'margin_left' => '5',
            'margin_right' => '5',
            'margin_top' => '29'
        ]);

        $oPDF->SetHTMLHeader($cabeceraHTML);
        $oPDF->SetTitle('Logistica');
        $oPDF->setFooter('{PAGENO}');
        $html = "";

        $htmlInitTable = "<table style='border-collapse:collapse;width:100%;font-family:Arial;font-size:10px;'>";
        $htmlInitTable .= "<thead>";
        $htmlInitTable .= "<tr>";
        $htmlInitTable .= "<td width='180' style='width:180px;max-width:180px;min-width:180px;'>&nbsp;</td>";
        $htmlInitTable .= "<td width='180' style='width:180px;max-width:180px;min-width:180px;'>&nbsp;</td>";
        $htmlInitTable .= "<td width='80' style='width:80px;max-width:80px;min-width:80px;'>&nbsp;</td>";
        $htmlInitTable .= "<td width='160' style='width:160px;max-width:160px;min-width:160px;'>&nbsp;</td>";
        $htmlInitTable .= "<td text-rotate='90' style='width:30px;max-width:30px;min-width:30px;'>&nbsp;</td>";
        $htmlInitTable .= "<td text-rotate='90' style='width:40px;max-width:40px;min-width:40px;'>&nbsp;</td>";

        foreach($cExtras as $oExtra){
            $htmlInitTable .= "<td valign='middle' text-rotate='90' style='width:30px;max-width:30px;min-width:30px;'>&nbsp;</td>";
        }        

        $htmlInitTable .= "<td text-rotate='90' style='width:40px;max-width:40px;min-width:40px;'>&nbsp;</td>";
        $htmlInitTable .= "<td text-rotate='90' style='width:40px;max-width:40px;min-width:40px;'>&nbsp;</td>";
        $htmlInitTable .= "<td style='width:80px;max-width:80px;min-width:80px;'>&nbsp;</td>";
        $htmlInitTable .= "</tr>";

        $htmlInitTable .= "</thead>";
        $htmlInitTable .= "<tbody>";
        $html .= $htmlInitTable;

        //$html .= $cabeceraHTML;

        foreach($arrayLogistica as $logistica){
            
            $oLogistica = $this->Logistica->getById($logistica['idLogistica']);
    
            $idDiaEntrega = $oLogistica->id_dia_entrega;
            $idBarrio = $oLogistica->id_barrio;
            
            $oBarrio = $this->Barrio->getById($idBarrio);
            $cOrders = $this->Order->getOrdersBarriosWithExtrasByIdDiaEntregaAndIdBarrio($idDiaEntrega,$idBarrio);
            $html .= "<tr style='background-color:#000000;'>";
            $html .= "<td height='50' style='font-size:12px;color:#FFFFFF; text-align:left;border:1px solid #000000;' colspan='4'><b>".$oBarrio->nombre." - ".$oBarrio->observaciones."</b></td>";
            $html .= "<td style='font-size:12px;color:#FFFFFF; text-align:center;border:1px solid #000000;' ><b>".$oLogistica->cantidad_modificada."</b></td>"; 
            $html .= "<td style='border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA PRECIO NO TIENE VALOR
            
            foreach($cExtras as $oExtra){
                $totalExtras = $this->Order->getTotalExtrasByBarrioByIdDiaEntregaByIdExtra(
                    $idBarrio,
                    $idDiaEntrega,
                    $oExtra->id
                );
                $html .= "<td style='font-size:12px;color:#FFFFFF;font-weight:600;text-align:center;border:1px solid #000000;'><b>".$totalExtras."</b></td>";
            }            
            $html .= "<td style='border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA TOTAL NO TIENE VALOR
            $html .= "<td style='border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA TOTAL NO TIENE VALOR
            $html .= "<td style='border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA OBSERVACIONES NO TIENE VALOR
            $html .= "</tr>";
            


            foreach($cOrders as $oOrder){
                $pedidoResaltado = false;
                if($oOrder['id_estado_pedido']==2 || $oOrder['id_estado_pedido']==3){
                    $pedidoResaltado = true;
                    $html .= "<tr style='font-size:12px;background-color:#b8b8b8;'>";
                }else{
                    $html .= "<tr style='font-size:12px;'>";
                }
                $html .= "<td height='35' style='border:1px solid #000000;'><p style='font-size:12px;'>".$oOrder['nro_orden']." - ".$oOrder['cliente']."</p></td>";
                
                $html .= "<td height='35' style='border:1px solid #000000;'><p style='font-size:12px;'>".$oOrder['mail']."</p></td>";
                
                $celularFormateado = $this->formatCelular($oOrder['celular']);
                $html .= "<td style='text-align:right;border:1px solid #000000;'><p style='font-size:10px;'>".$celularFormateado."</p></td>";

                $html .= "<td style='border:1px solid #000000;'><p style='font-size:12px;'>".$oOrder['cliente_domicilio_full']."</p></td>";
                
                $cantidadBolson = 0;
                $precioBolson = 0;

                if(!is_null($oOrder['cant_bolson']) && $oOrder['cant_bolson']!=""){
                    $cantidadBolson = $oOrder['cant_bolson'];
                    $precioBolson = $oOrder['total_bolson'];
                }

                if($precioBolson == 0) {
                    $precioBolson = "-";
                } else {
                    $precioBolson = "$ ".intval($precioBolson);
                }

                $html .= "<td style='text-align:center;border:1px solid #000000;'><p style='font-size:12px;'>".$cantidadBolson."</p></td>";
                $html .= "<td style='text-align:center;border:1px solid #000000;'><p style='font-size:12px;'>".$precioBolson."</p></td>";

                $extrasArray = $oOrder['extras'];
                $contExtra = 0;
                foreach($cExtras as $oExtra){ //Array de extras activos en la base de datos (con esto identifico la columna)
                    $backgroundColor = "";
                    if(!$pedidoResaltado) {
                        if($contExtra % 2 == 0){
                            $backgroundColor = "background-color:#dadada";
                        } else {
                            $backgroundColor = "background-color:#ffffff";
                        }
                    }
                    $html .= "<td style='text-align:center;border:1px solid #000000;".$backgroundColor."'><p style='font-size:12px;'>";
                    $contExtra++;
                    foreach($extrasArray as $ordenExtra){ //Array de extras en la orden (con esto pongo el precio en la columna correcta)
                        if($oExtra->id == $ordenExtra['id_extra']){
                            $cantExtra = $this->Order->getCantOrderExtraByPedidoAndExtra($oOrder['order_id'],$oExtra->id);
                            if(!isset($cantExtra)){
                                $cantExtra = 1;
                            }else{
                                $cantExtra = $cantExtra[0]->cant;
                            }
                            $precio = ($ordenExtra['extra_price'] * $cantExtra); 

                            $html .= "$ ".$precio;
                            $html .= "<br />(x".$cantExtra.")";
                        }
                        
                    }
                    $html .= "</p></td>";
                }

                $valMontoPagado;
                $valMontoDebe;

                if($oOrder['monto_pagado'] == 0) {
                    $valMontoPagado = "-";
                } else {
                    $valMontoPagado = "$".$oOrder['monto_pagado'];
                }

                if($oOrder['monto_debe'] == 0) {
                    $valMontoDebe = "-";
                } else {
                    $valMontoDebe = "$".$oOrder['monto_debe'];
                }

                $html .= "<td style='text-align:center;border:1px solid #000000;'><p style='font-size:12px;'>".$valMontoPagado."</p></td>";
                $html .= "<td style='text-align:center;border:1px solid #000000;'><p style='font-size:12px;'><b>".$valMontoDebe."</b></p></td>";

                $obs = "";

                if($oOrder['id_estado_pedido']==2){
                    $obs .= "ESPECIAL - ";
                }
                if($oOrder['id_estado_pedido']==3){
                    $obs .= "BONIFICADO - ";
                }
                if($oOrder['observaciones']!=""){
                    $obs .= $oOrder['observaciones'];
                }

                if($oOrder['id_cupon'] != null && $oOrder['id_cupon']>0) {
                    if($obs==""){
                        $obs = "Cupón de Descuento aplicado.";
                    }else{
                        $obs = $obs." - "."Cupón de Descuento aplicado.";
                    }    
                }
                    
                $html .= "<td style='text-align:center;border:1px solid #000000;'><p style='font-size:12px;'>".$obs."</p></td>";

                $html .= "</tr>";
                $pedidosCounter++;
            }             
        }

        $html .= "</tbody></table>";

        $oPDF->WriteHTML($html);
        $oPDF->Output('Logistica.pdf', 'F');
        return 1;

    }

    public function printCamionIndividual(){
        $this->output->set_content_type('application/json');

        $idLogisticaCamion = $this->input->post('idLogisticaCamion', true);
        $idDiaEntrega = $this->input->post('idDiaEntrega', true);

        if(is_null($idLogisticaCamion)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        $this->createPDFIndividualLogisticaCamion($idLogisticaCamion,$idDiaEntrega);    
        $fileName = "LogisticaCamiones.pdf";

        $return['status'] = self::OK_VALUE;
        $return['fileName'] = $fileName;
        //$this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));             
    }

    private function createHtmlForIndividualLogisticaCamion($oLogisticaCamion, $cLogisticaFromCamion, $idDiaEntrega) {
        $this->load->model('Logistica');
        $this->load->model('Extra');
        $this->load->model('LogisticaDiasEntregaCamiones');
        $this->load->model('Order');
        $this->load->model('Office');
        $this->load->model('Barrio');

        $hayPedidosPuntosDeRetiro = false;
        $itemCounter = 1;

        $cExtras = $this->Extra->getActive();
        $html = "";
            $cantTotalBolsones = 0;
            $cantTotalEspeciales = 0;
            $cantTotalEspecialesIndividuales = 0;
            $arrayTotalesExtrasPuntosRetiro = [];
            $arrayTotalesExtrasBarrios = [];
            $htmlInitTable = "<table style='border-collapse:collapse;border:1px solid #FF0000;width:100%;font-family:Arial;font-size:10px;'><tbody>";
            $html .= $htmlInitTable;

            $cabeceraHTML = "";

            $cabeceraHTML .= "<tr>";
            $cabeceraHTML .= "<td height='90' style='height:90px;width:130px;text-align:center;border:1px solid #000000;background-color:#000000;color:#FFFFFF;'><b>".$oLogisticaCamion->camion."</b></td>";
            $cabeceraHTML .= "<td text-rotate='90' style='width:40px;text-align:center;border:1px solid #000000;'>Bolson Familiar (8kg)</td>";
            $cabeceraHTML .= "<td text-rotate='90' style='width:40px;text-align:center;border:1px solid #000000;'>Esp. Familiares</td>";
            
            $contExtra = 0;            
            foreach($cExtras as $oExtra){
                $extraName = "";
                if(isset($oExtra->nombre_corto) && $oExtra->nombre_corto!=""){
                    $extraName = $oExtra->nombre_corto;
                } else {
                    $extraName = $oExtra->name;
                }
                $backgroundColor = "";
                if($contExtra % 2 == 0){
                    $backgroundColor = "background-color:#dadada";
                } else {
                    $backgroundColor = "background-color:#FFFFFF";
                }
                $cabeceraHTML .= "<td valign='middle' text-rotate='90' style='width:30px;max-width:30px;min-width:30px;text-align:center;border:1px solid #000000;".$backgroundColor."'>".$extraName."</td>";
                if($oExtra->id == 1) {
                    //SI ES EL BOLSON INDIVIDUAL, AL LADO VA LA CABECERA DE LA COLUMNA ESPCIALES INDIVIDUALES
                    $cabeceraHTML .= "<td valign='middle' text-rotate='90' width='30' style='width:30px;text-align:center;border:1px solid #000000;'>Esp. Individual</td>";
                }
                $contExtra++;
            }

            $cabeceraHTML .= "</tr>";
            $html .= $cabeceraHTML;
            foreach($cLogisticaFromCamion as $oLogistica){
                $html .= "<tr>";
                if(!is_null($oLogistica->id_punto_retiro) && $oLogistica->id_punto_retiro>0){
                    //SE TRATA DE UN PUNTO DE RETIRO
                    $oPuntoRetiro = $this->Office->getById($oLogistica->id_punto_retiro);
                    $hayPedidosPuntosDeRetiro = true;
                    $html .= "<td height='35' style='width:130px;text-align:left;border:1px solid #000000;'><b>&nbsp;".$itemCounter." - ".$oPuntoRetiro->name."</b></td>";
                    
                    $html .= "<td style='width:40px;text-align:center;border:1px solid #000000;'><b>".$oLogistica->cantidad_modificada."</b></td>";
                    $cantTotalBolsones = $cantTotalBolsones+$oLogistica->cantidad_modificada;
                    
                    $html .= "<td style='width:40px;text-align:center;border:1px solid #000000;'><b>".$oLogistica->cantidad_especiales."</b></td>";
                    $cantTotalEspeciales = $cantTotalEspeciales+$oLogistica->cantidad_especiales;
                    
                    $contExtra = 0;
                    foreach($cExtras as $oExtra){
                        $totalExtras = $this->Order->getTotalExtrasByPuntoDeRetiroByIdDiaEntregaByIdExtra(
                            $oLogistica->id_punto_retiro,
                            $idDiaEntrega,
                            $oExtra->id
                        );

                        array_push($arrayTotalesExtrasPuntosRetiro,array(
                            'idExtra' => $oExtra->id,
                            'cant' => $totalExtras
                        ));
                        
                        $backgroundColor = "";
                        if($contExtra % 2 == 0){
                            $backgroundColor = "background-color:#dadada";
                        } else {
                            $backgroundColor = "background-color:#FFFFFF";
                        }
                        $contExtra++;

                        $html .= "<td style='text-align:center;border:1px solid #000000;".$backgroundColor."'><b>".$totalExtras."</b></td>";
                        if($oExtra->id == 1) {
                            //SI ES EL BOLSON INDIVIDUAL, ACA PONGO LA CANTIDAD TOTAL DE ESPECIALES INDIVIDUALES
                            $cantTotalEspecialesIndividuales = $cantTotalEspecialesIndividuales + $oLogistica->cantidad_bolsones_individuales_especiales;
                            $html .= "<td style='text-align:center;border:1px solid #000000;'><b>".$oLogistica->cantidad_bolsones_individuales_especiales."</b></td>";
                        }
                    }     
                    $html .= "</tr>";
    
                }else if(!is_null($oLogistica->id_barrio) && $oLogistica->id_barrio>0){
                    //SE TRATA DE UN BARRIO
                    $oBarrio = $this->Barrio->getById($oLogistica->id_barrio);
                    $barrio = "";
                    if($hayPedidosPuntosDeRetiro){
                        $barrio = "[DOM] ";
                    }
                    $barrio .= $oBarrio->nombre;
                    $html .= "<td height='35' style='width:130px;text-align:left;border:1px solid #000000;'><b>&nbsp;".$itemCounter." - ".$barrio."</b></td>";

                    
                    $html .= "<td style='width:40px;text-align:center;border:1px solid #000000;'><b>".$oLogistica->cantidad_modificada."</b></td>";
                    $cantTotalBolsones = $cantTotalBolsones+$oLogistica->cantidad_modificada;

                    $html .= "<td style='width:40px;text-align:center;border:1px solid #000000;'><b>".$oLogistica->cantidad_especiales."</b></td>";
                    $cantTotalEspeciales = $cantTotalEspeciales+$oLogistica->cantidad_especiales;
                    
                    foreach($cExtras as $oExtra){
                        $totalExtras = $this->Order->getTotalExtrasByBarrioByIdDiaEntregaByIdExtra(
                            $oLogistica->id_barrio,
                            $idDiaEntrega,
                            $oExtra->id
                        );
                        
                        array_push($arrayTotalesExtrasBarrios,array(
                            'idExtra' => $oExtra->id,
                            'cant' => $totalExtras
                        ));
            
                        $html .= "<td style='text-align:center;border:1px solid #000000;'><b>".$totalExtras."</b></td>";
                        if($oExtra->id == 1) {
                            //SI ES EL BOLSON INDIVIDUAL, ACA PONGO LA CANTIDAD TOTAL DE ESPECIALES INDIVIDUALES
                            $cantTotalEspecialesIndividuales = $cantTotalEspecialesIndividuales + $oLogistica->cantidad_bolsones_individuales_especiales;
                            $html .= "<td style='text-align:center;border:1px solid #000000;'><b>".$oLogistica->cantidad_bolsones_individuales_especiales."</b></td>";
                        }
                    }     
                    $html .= "</tr>";
                }
                $itemCounter++;
            }
            //print_r($arrayTotalesExtrasPuntosRetiro);
            $html .= "<tr>";
            $html .= "<td height='35' style='width:130px;text-align:left;border:1px solid #000000;background-color:#000000;color:#FFFFFF;'><b>&nbsp;TOTALES</b></td>";
            $html .= "<td style='text-align:center;border:1px solid #000000;background-color:#000000;color:#FFFFFF;'><b>".$cantTotalBolsones."</b></td>";
            $html .= "<td style='text-align:center;border:1px solid #000000;background-color:#000000;color:#FFFFFF;'><b>".$cantTotalEspeciales."</b></td>";
            $cantExtras = count($cExtras);
            
            for($i=0;$i<count($cExtras);$i++){
                $total = 0;
                foreach($arrayTotalesExtrasPuntosRetiro as $totalExtrasPuntoRetiro){
                    if($totalExtrasPuntoRetiro['idExtra'] == $cExtras[$i]->id){
                        $total = $total + $totalExtrasPuntoRetiro['cant'];
                    }
                }
                foreach($arrayTotalesExtrasBarrios as $totalExtrasBarrio){
                    if($totalExtrasBarrio['idExtra'] == $cExtras[$i]->id){
                        $total = $total + $totalExtrasBarrio['cant'];
                    }
                }

                $html .= "<td style='text-align:center;border:1px solid #000000;background-color:#000000;color:#FFFFFF;'><b>".$total."</b></td>";
                if($cExtras[$i]->id == 1) {
                    $html .= "<td style='text-align:center;border:1px solid #000000;background-color:#000000;color:#FFFFFF;'><b>".$cantTotalEspecialesIndividuales."</b></td>";
                }
            }
            $html .= "</tr>";
            $html .= "</tbody></table>";
            return $html;
    }

    private function createPDFIndividualLogisticaCamion($idLogisticaCamion,$idDiaEntrega){
        $this->load->model('Logistica');
        $this->load->model('Extra');
        $this->load->model('LogisticaDiasEntregaCamiones');
        $this->load->model('Order');
        $this->load->model('Office');
        $this->load->model('Barrio');
        
        $oLogisticaCamion = $this->LogisticaDiasEntregaCamiones->getById($idLogisticaCamion);
        $cLogisticaFromCamion = $this->Logistica->getLogisticaByDiaEntregaAndCamion($idDiaEntrega,$idLogisticaCamion);
        if(!is_null($cLogisticaFromCamion) && count($cLogisticaFromCamion)>0){
            $oPDF = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format'=> 'Legal',
                'orientation' => 'L',
                'margin_left' => '5',
                'margin_right' => '5',
                'margin_top' => '5',
                'margin_bottom' => '0'
            ]);
    
            $oPDF->SetTitle('Logística Camiones');
            
            $html = $this->createHtmlForIndividualLogisticaCamion($oLogisticaCamion, $cLogisticaFromCamion, $idDiaEntrega);
            
            $oPDF->WriteHTML($html);
            $oPDF->Output('LogisticaCamiones.pdf', 'F');
        }
        
        return 1;
    }   

    public function printResumenPedido(){
        $this->output->set_content_type('application/json');

        $idDiaEntrega = $this->input->post('idDiaEntrega', true);

        if(is_null($idDiaEntrega)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->createXLSLogisticaResumenPedidos($idDiaEntrega);    
        $fileName = "ResumenPedidos.xls";

        $return['status'] = self::OK_VALUE;
        $return['fileName'] = $fileName;
        //$this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           

    }

    private function createXLSLogisticaResumenPedidos($idDiaEntrega){
        $this->load->model('Logistica');
        $this->load->model('Extra');
        $this->load->model('Order');
        $this->load->model('Barrio');
        
        $cLogisticaPuntosDeRetiro = $this->Logistica->getLogisticaPuntosRetiroByDiaEntregaOrderedByCantidadModificada($idDiaEntrega);
        $cLogisticaBarrios = $this->Logistica->getLogisticaBarriosByDiaEntregaOrderedByCantidadModificada($idDiaEntrega);

        $xlsCreado = false;

        $cExtrasPuntosDeRetiro = $this->Extra->getAllVisiblesInSucursalConSinStock();
        $cExtrasBarrios = $this->Extra->getAllVisiblesInDomicilioConSinStock();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Logistica Resumen Pedidos");
        $lastColumn = 'A';
        $xlsCol = 'A';
        $xlsRow = 1;

        $pedidosCounter = 1;

        $arrayTotalBolsonesPuntosDeRetiro = [];
        $arrayTotalBolsonesBarrios = [];
        $arrayTotalesExtrasPuntosDeRetiro = [];
        $arrayTotalesExtrasBarrios = [];

        //Array de estilos para las celdas. Lo aplico por fila.
        $headerStyleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            ),
            'font'  => array(
                'size'  => 12
            ),
            'fill' => array(
                'fillType' => Fill::FILL_SOLID,
                'startColor' => array('argb' => 'FFB8B8B8')
            )
        );

        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            ),
            'font'  => array(
                'size'  => 14
            )
        );        
        
        $styleCamionTitleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            ),
            'font'  => array(
                'size'  => 14
            )
        );        
        $firstTime = true;

        
        
        if(!is_null($cLogisticaPuntosDeRetiro) && count($cLogisticaPuntosDeRetiro)>0){
            $sheet->setTitle('SUCURSALES');
            $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
            $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL);
            $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.1);
            $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.1);

            $sheet->setCellValue($xlsCol.$xlsRow, 'SUCURSAL');
            $sheet->getColumnDimension($xlsCol)->setAutoSize(true);
            $xlsCol++;
            $sheet->setCellValue($xlsCol.$xlsRow, 'Bolsones');
            $sheet->getColumnDimension($xlsCol)->setWidth(10);
            $xlsCol++;
            
            $cantExtrasArr = count($cExtrasPuntosDeRetiro);
            $contExtras = 0;
            foreach($cExtrasPuntosDeRetiro as $oExtra){
                if(isset($oExtra->nombre_corto) && $oExtra->nombre_corto!=""){
                    $sheet->setCellValue($xlsCol.$xlsRow, $oExtra->nombre_corto);
                }else{
                    $sheet->setCellValue($xlsCol.$xlsRow, $oExtra->name);
                }
                $sheet->getColumnDimension($xlsCol)->setWidth(10);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                
                $contExtras++;

                if($contExtras<$cantExtrasArr){
                    $xlsCol++;
                }
                
            }         
            $lastColumn = $xlsCol;
    
            $sheet->getRowDimension($xlsRow)->setRowHeight(75);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                                    
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($headerStyleArray);
            $spreadsheet->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd($xlsRow, $xlsRow);
    
            $xlsRow++;
    
            foreach($cLogisticaPuntosDeRetiro as $oLogisticaPuntosDeRetiro){
                            
                $xlsCol = 'A';
                
                $sheet->setCellValue($xlsCol.$xlsRow, $oLogisticaPuntosDeRetiro->puntoRetiroNombre );            
                $sheet->getColumnDimension($xlsCol)->setAutoSize(true);
                $xlsCol++;
                
                $cantidadBolson = 0;

                if(!is_null($oLogisticaPuntosDeRetiro->cantidad_modificada) && $oLogisticaPuntosDeRetiro->cantidad_modificada!=""){
                    $cantidadBolson = $oLogisticaPuntosDeRetiro->cantidad_modificada;
                }

                array_push($arrayTotalBolsonesPuntosDeRetiro,array(
                    'cant' => $cantidadBolson
                ));

                $sheet->setCellValue($xlsCol.$xlsRow, $cantidadBolson);
                $sheet->getColumnDimension($xlsCol)->setWidth(10);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $xlsCol++;
                
                foreach($cExtrasPuntosDeRetiro as $oExtra){ //Array de extras activos en la base de datos (con esto identifico la columna)
                    $totalExtras = $this->Order->getTotalExtrasByPuntoDeRetiroByIdDiaEntregaByIdExtra(
                        $oLogisticaPuntosDeRetiro->id_punto_retiro,
                        $idDiaEntrega,
                        $oExtra->id
                    );

                    array_push($arrayTotalesExtrasPuntosDeRetiro,array(
                        'idExtra' => $oExtra->id,
                        'cant' => $totalExtras
                    ));

                    $sheet->setCellValue($xlsCol.$xlsRow, $totalExtras);
                    $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getColumnDimension($xlsCol)->setWidth(10);
                    $xlsCol++;
                }

                $sheet->getRowDimension($xlsRow)->setRowHeight(35);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($styleArray);
                
                $xlsRow++;
            }
        }

        $xlsCol = 'A';

        $sheet->setCellValue($xlsCol.$xlsRow, "TOTALES");
        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getColumnDimension($xlsCol)->setAutoSize(true);
        $xlsCol++;

        $totalBolsones = 0;
        foreach($arrayTotalBolsonesPuntosDeRetiro as $oTotalBolson){
                $totalBolsones = $totalBolsones + $oTotalBolson['cant'];
        }

        $sheet->setCellValue($xlsCol.$xlsRow, $totalBolsones);
        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getColumnDimension($xlsCol)->setWidth(10);
        $xlsCol++;

        for($i=0;$i<count($cExtrasPuntosDeRetiro);$i++){
            $total = 0;
            foreach($arrayTotalesExtrasPuntosDeRetiro as $totalExtrasPuntoDeRetiro){
                if($totalExtrasPuntoDeRetiro['idExtra'] == $cExtrasPuntosDeRetiro[$i]->id){
                    $total = $total + $totalExtrasPuntoDeRetiro['cant'];
                }
            }
            $sheet->setCellValue($xlsCol.$xlsRow, $total);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getColumnDimension($xlsCol)->setWidth(10);

            $xlsCol++;
            
        }

        $sheet->getRowDimension($xlsRow)->setRowHeight(35);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($headerStyleArray);

        $sheet = $spreadsheet->createSheet();
        $lastColumn = 'A';
        $xlsCol = 'A';
        $xlsRow = 1;
        
        if(!is_null($cLogisticaBarrios) && count($cLogisticaBarrios)>0){
            $sheet->setTitle('DOMICILIO');
            $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
            $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL);
            $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.1);
            $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.1);

            $sheet->setCellValue($xlsCol.$xlsRow, 'ENVÍO A DOMICILIO');
            $sheet->getColumnDimension($xlsCol)->setAutoSize(true);
            $xlsCol++;
            $sheet->setCellValue($xlsCol.$xlsRow, 'Bolsones');
            $sheet->getColumnDimension($xlsCol)->setWidth(10);
            $xlsCol++;
            
            $cantExtrasArr = count($cExtrasBarrios);
            $contExtras = 0;
            foreach($cExtrasBarrios as $oExtra){
                if(isset($oExtra->nombre_corto) && $oExtra->nombre_corto!=""){
                    $sheet->setCellValue($xlsCol.$xlsRow, $oExtra->nombre_corto);
                }else{
                    $sheet->setCellValue($xlsCol.$xlsRow, $oExtra->name);
                }
                $sheet->getColumnDimension($xlsCol)->setWidth(10);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                
                $contExtras++;

                if($contExtras<$cantExtrasArr){
                    $xlsCol++;
                }
                
            }         
            $lastColumn = $xlsCol;
    
            $sheet->getRowDimension($xlsRow)->setRowHeight(75);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                                    
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($headerStyleArray);
            $spreadsheet->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd($xlsRow, $xlsRow);
    
            $xlsRow++;
    
            foreach($cLogisticaBarrios as $oLogisticaBarrios){
                            
                $xlsCol = 'A';
                
                $sheet->setCellValue($xlsCol.$xlsRow, $oLogisticaBarrios->barrioNombre );            
                $sheet->getColumnDimension($xlsCol)->setAutoSize(true);
                $xlsCol++;
                
                $cantidadBolson = 0;

                if(!is_null($oLogisticaBarrios->cantidad_modificada) && $oLogisticaBarrios->cantidad_modificada!=""){
                    $cantidadBolson = $oLogisticaBarrios->cantidad_modificada;
                }

                array_push($arrayTotalBolsonesBarrios,array(
                    'cant' => $cantidadBolson
                ));

                $sheet->setCellValue($xlsCol.$xlsRow, $cantidadBolson);
                $sheet->getColumnDimension($xlsCol)->setWidth(10);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $xlsCol++;
        
                foreach($cExtrasBarrios as $oExtra){ 
                    $totalExtras = $this->Order->getTotalExtrasByBarrioByIdDiaEntregaByIdExtra(
                        $oLogisticaBarrios->id_barrio,
                        $idDiaEntrega,
                        $oExtra->id
                    );

                    array_push($arrayTotalesExtrasBarrios,array(
                        'idExtra' => $oExtra->id,
                        'cant' => $totalExtras
                    ));

                    //printf($oLogisticaBarrios->barrioNombre.": ".$oExtra->name." - ".$totalExtras);

                    $sheet->setCellValue($xlsCol.$xlsRow, $totalExtras);
                    $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getColumnDimension($xlsCol)->setWidth(10);
                    $xlsCol++;
                }

                $sheet->getRowDimension($xlsRow)->setRowHeight(35);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($styleArray);
                
                $xlsRow++;
            }
            $xlsCol = 'A';

            $sheet->setCellValue($xlsCol.$xlsRow, "TOTALES:");
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getColumnDimension($xlsCol)->setAutoSize(true);
            $xlsCol++;

            $totalBolsones = 0;
            foreach($arrayTotalBolsonesBarrios as $oTotalBolson){
                    $totalBolsones = $totalBolsones + $oTotalBolson['cant'];
            }

            $sheet->setCellValue($xlsCol.$xlsRow, $totalBolsones);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getColumnDimension($xlsCol)->setWidth(10);
            $xlsCol++;

            for($i=0;$i<count($cExtrasBarrios);$i++){
                $total = 0;
                foreach($arrayTotalesExtrasBarrios as $totalExtrasBarrio){
                    if($totalExtrasBarrio['idExtra'] == $cExtrasBarrios[$i]->id){
                        $total = $total + $totalExtrasBarrio['cant'];
                    }
                }
                $sheet->setCellValue($xlsCol.$xlsRow, $total);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getColumnDimension($xlsCol)->setWidth(10);

                $xlsCol++;
                
            }

            $sheet->getRowDimension($xlsRow)->setRowHeight(35);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                                    
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($headerStyleArray);


        }
        
        //$spreadsheet->setActiveSheetIndex(0);
        $fileName = "ResumenPedidos.xls";
        $writer = new Xlsx($spreadsheet);        
        $writer->save($fileName);    
        $xlsCreado = true;
        return $xlsCreado;
    }


    public function printAllCamiones(){
        $this->output->set_content_type('application/json');

        $idDiaEntrega = $this->input->post('idDiaEntrega', true);

        if(is_null($idDiaEntrega)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->createPDFLogisticaAllCamiones($idDiaEntrega);    
        $fileName = "LogisticaCamiones.pdf";

        $return['status'] = self::OK_VALUE;
        $return['fileName'] = $fileName;
        //$this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }

    private function createPDFLogisticaAllCamiones($idDiaEntrega){
        $this->load->model('Logistica');
        $this->load->model('Extra');
        $this->load->model('LogisticaDiasEntregaCamiones');
        $this->load->model('Order');
        $this->load->model('Office');
        $this->load->model('Barrio');
        
        $cLogisticaCamiones = $this->LogisticaDiasEntregaCamiones->getByDiaEntrega($idDiaEntrega);
        $cExtras = $this->Extra->getActive();

        $itemCounter = 1;

        if(!is_null($cLogisticaCamiones) && count($cLogisticaCamiones)>0){
            $oPDF = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format'=> 'Legal',
                'orientation' => 'L',
                'margin_left' => '5',
                'margin_right' => '5',
                'margin_top' => '5',
                'margin_bottom' => '0'
            ]);
    
            $oPDF->SetTitle('Logística Camiones');
            //HAY MIX CUANDO HAY PEDIDOS DE PUNTOS DE RETIRO Y DE BARRIOS EN UN MISMO CAMION
            $hayMixDePedidos = false;
            $hayPedidosPuntosDeRetiro = false;
            foreach($cLogisticaCamiones as $oLogisticaCamion){
                $cLogisticaFromCamion = $this->Logistica->getLogisticaByDiaEntregaAndCamion($idDiaEntrega,$oLogisticaCamion->id);
                if(!is_null($cLogisticaFromCamion) && count($cLogisticaFromCamion)>0){
                    $oPDF->AddPage();
            
                    $html = "";
                    $cantTotalBolsones = 0;
                    $cantTotalEspeciales = 0;
                    $cantTotalEspecialesIndividuales = 0;
                    $arrayTotalesExtrasPuntosRetiro = [];
                    $arrayTotalesExtrasBarrios = [];
                    $htmlInitTable = "<table style='border-collapse:collapse;border:1px solid #FF0000;width:100%;font-family:Arial;font-size:10px;'><tbody>";
                    $html .= $htmlInitTable;
        
                    $cabeceraHTML = "";
        
                    $cabeceraHTML .= "<tr>";
                    $cabeceraHTML .= "<td height='90' style='height:90px;width:130px;text-align:center;border:1px solid #000000;background-color:#000000;color:#FFFFFF;'><b>".$oLogisticaCamion->camion."</b></td>";
                    $cabeceraHTML .= "<td text-rotate='90' text style='width:40px;text-align:center;border:1px solid #000000;'>Bolson Familiar (8kg)</td>";
                    $cabeceraHTML .= "<td text-rotate='90' style='width:40px;text-align:center;border:1px solid #000000;'>Esp. Familiares</td>";

                    $contExtra = 0;            
                    foreach($cExtras as $oExtra){
                        $extraName = "";
                        if(isset($oExtra->nombre_corto) && $oExtra->nombre_corto!=""){
                            $extraName = $oExtra->nombre_corto;
                        } else {
                            $extraName = $oExtra->name;
                        }
                        $backgroundColor = "";
                        if($contExtra % 2 == 0){
                            $backgroundColor = "background-color:#dadada";
                        } else {
                            $backgroundColor = "background-color:#FFFFFF";
                        }
                        $cabeceraHTML .= "<td valign='middle' text-rotate='90' style='width:30px;max-width:30px;min-width:30px;text-align:center;border:1px solid #000000;".$backgroundColor."'>".$extraName."</td>";
                        if($oExtra->id == 1) {
                            //SI ES EL BOLSON INDIVIDUAL, AL LADO VA LA CABECERA DE LA COLUMNA ESPCIALES INDIVIDUALES
                            $cabeceraHTML .= "<td valign='middle' text-rotate='90' width='30' style='width:30px;text-align:center;border:1px solid #000000;'>Esp. Individual</td>";
                        }
                        $contExtra++;
                    }

                    $cabeceraHTML .= "</tr>";
                    $html .= $cabeceraHTML;
                    foreach($cLogisticaFromCamion as $oLogistica){
                        $html .= "<tr>";
                        if(!is_null($oLogistica->id_punto_retiro) && $oLogistica->id_punto_retiro>0){
                            //SE TRATA DE UN PUNTO DE RETIRO
                            $hayPedidosPuntosDeRetiro = true;
                            $oPuntoRetiro = $this->Office->getById($oLogistica->id_punto_retiro);
                            
                            $html .= "<td height='35' style='width:130px;text-align:left;border:1px solid #000000;'><b>&nbsp;".$itemCounter." - ".$oPuntoRetiro->name."</b></td>";
                            
                            $html .= "<td style='width:40px;text-align:center;border:1px solid #000000;'><b>".$oLogistica->cantidad_modificada."</b></td>";
                            $cantTotalBolsones = $cantTotalBolsones+$oLogistica->cantidad_modificada;
                            
                            $html .= "<td style='width:40px;text-align:center;border:1px solid #000000;'><b>".$oLogistica->cantidad_especiales."</b></td>";
                            $cantTotalEspeciales = $cantTotalEspeciales+$oLogistica->cantidad_especiales;
                            
                            $contExtra = 0;
                            foreach($cExtras as $oExtra){
                                $totalExtras = $this->Order->getTotalExtrasByPuntoDeRetiroByIdDiaEntregaByIdExtra(
                                    $oLogistica->id_punto_retiro,
                                    $idDiaEntrega,
                                    $oExtra->id
                                );
        
                                array_push($arrayTotalesExtrasPuntosRetiro,array(
                                    'idExtra' => $oExtra->id,
                                    'cant' => $totalExtras
                                ));

                                $backgroundColor = "";
                                if($contExtra % 2 == 0){
                                    $backgroundColor = "background-color:#dadada";
                                } else {
                                    $backgroundColor = "background-color:#FFFFFF";
                                }
                                $contExtra++;

                                $html .= "<td style='text-align:center;border:1px solid #000000;".$backgroundColor."'><b>".$totalExtras."</b></td>";
                                if($oExtra->id == 1) {
                                    //SI ES EL BOLSON INDIVIDUAL, ACA PONGO LA CANTIDAD TOTAL DE ESPECIALES INDIVIDUALES
                                    $cantTotalEspecialesIndividuales = $cantTotalEspecialesIndividuales + $oLogistica->cantidad_bolsones_individuales_especiales;
                                    $html .= "<td style='text-align:center;border:1px solid #000000;'><b>".$oLogistica->cantidad_bolsones_individuales_especiales."</b></td>";
                                }
        
                            }     
                            $html .= "</tr>";
            
                        }else if(!is_null($oLogistica->id_barrio) && $oLogistica->id_barrio>0){
                            //SE TRATA DE UN BARRIO
                            $oBarrio = $this->Barrio->getById($oLogistica->id_barrio);
                            $barrio = "";
                            if($hayPedidosPuntosDeRetiro){
                                $barrio = "[DOM] ";
                            }
                            $barrio .= $oBarrio->nombre;
                            $html .= "<td height='35' style='width:130px;text-align:left;border:1px solid #000000;'><b>&nbsp;".$itemCounter." - ".$barrio."</b></td>";
                            
                            $html .= "<td style='width:40px;text-align:center;border:1px solid #000000;'><b>".$oLogistica->cantidad_modificada."</b></td>";
                            $cantTotalBolsones = $cantTotalBolsones+$oLogistica->cantidad_modificada;
        
                            $html .= "<td style='width:40px;text-align:center;border:1px solid #000000;'><b>".$oLogistica->cantidad_especiales."</b></td>";
                            $cantTotalEspeciales = $cantTotalEspeciales+$oLogistica->cantidad_especiales;

                            $contExtra = 0;
                            foreach($cExtras as $oExtra){
                                $totalExtras = $this->Order->getTotalExtrasByBarrioByIdDiaEntregaByIdExtra(
                                    $oLogistica->id_barrio,
                                    $idDiaEntrega,
                                    $oExtra->id
                                );
                                
                                array_push($arrayTotalesExtrasBarrios,array(
                                    'idExtra' => $oExtra->id,
                                    'cant' => $totalExtras
                                ));

                                $backgroundColor = "";
                                if($contExtra % 2 == 0){
                                    $backgroundColor = "background-color:#dadada";
                                } else {
                                    $backgroundColor = "background-color:#FFFFFF";
                                }
                                $contExtra++;
                    
                                $html .= "<td style='text-align:center;border:1px solid #000000;".$backgroundColor."'><b>".$totalExtras."</b></td>";
                                if($oExtra->id == 1) {
                                    //SI ES EL BOLSON INDIVIDUAL, ACA PONGO LA CANTIDAD TOTAL DE ESPECIALES INDIVIDUALES
                                    $cantTotalEspecialesIndividuales = $cantTotalEspecialesIndividuales + $oLogistica->cantidad_bolsones_individuales_especiales;
                                    $html .= "<td style='text-align:center;border:1px solid #000000;'><b>".$oLogistica->cantidad_bolsones_individuales_especiales."</b></td>";
                                }

                            }     
                            $html .= "</tr>";
                        }
                        $itemCounter++;
                    }
                    //print_r($arrayTotalesExtrasPuntosRetiro);
                    $html .= "<tr>";
                    $html .= "<td height='35' style='width:130px;text-align:left;border:1px solid #000000;background-color:#000000;color:#FFFFFF;'><b>&nbsp;TOTALES</b></td>";
                    $html .= "<td style='text-align:center;border:1px solid #000000;background-color:#000000;color:#FFFFFF;'><b>".$cantTotalBolsones."</b></td>";
                    $html .= "<td style='text-align:center;border:1px solid #000000;background-color:#000000;color:#FFFFFF;'><b>".$cantTotalEspeciales."</b></td>";
                    $cantExtras = count($cExtras);
                    
                    for($i=0;$i<count($cExtras);$i++){
                        $total = 0;
                        foreach($arrayTotalesExtrasPuntosRetiro as $totalExtrasPuntoRetiro){
                            if($totalExtrasPuntoRetiro['idExtra'] == $cExtras[$i]->id){
                                $total = $total + $totalExtrasPuntoRetiro['cant'];
                            }
                        }
                        foreach($arrayTotalesExtrasBarrios as $totalExtrasBarrio){
                            if($totalExtrasBarrio['idExtra'] == $cExtras[$i]->id){
                                $total = $total + $totalExtrasBarrio['cant'];
                            }
                        }
        
                        $html .= "<td style='text-align:center;border:1px solid #000000;background-color:#000000;color:#FFFFFF;'><b>".$total."</b></td>";
                        if($cExtras[$i]->id == 1) {
                            $html .= "<td style='text-align:center;border:1px solid #000000;background-color:#000000;color:#FFFFFF;'><b>".$cantTotalEspecialesIndividuales."</b></td>";
                        }
                    }
                    $html .= "</tr>";
                    $html .= "</tbody></table>";
                    $oPDF->WriteHTML($html);
                    
                }
            }
            $oPDF->Output('LogisticaCamiones.pdf', 'F');
        }

        
        return 1;
    }    

    public function printAllCamionesConDetalles(){
        $this->output->set_content_type('application/json');
        
        $this->load->model('LogisticaDiasEntregaCamiones');
        
        $idDiaEntrega = $this->input->post('idDiaEntrega', true);

        if(is_null($idDiaEntrega)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        $cLogisticaCamiones = $this->LogisticaDiasEntregaCamiones->getByDiaEntrega($idDiaEntrega);
        
        $this->createXLSLogisticaAllCamionesConDetalles($cLogisticaCamiones);    
        $fileName = "LogisticaCamionesDetalles.xls";

        $return['status'] = self::OK_VALUE;
        $return['fileName'] = $fileName;
        //$this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));            
    }

    private function createXLSLogisticaAllCamionesConDetalles($cLogisticaCamiones){
        $this->load->model('Logistica');
        $this->load->model('Extra');
        $this->load->model('Order');
        $this->load->model('Barrio');
        
        $xlsCreado = false;

        $cExtras = $this->Extra->getActive();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Logistica Camiones Detalle");
        $lastColumn = 'A';
        $xlsCol = 'A';
        $xlsRow = 1;

        $pedidosCounter = 1;

        //Array de estilos para las celdas. Lo aplico por fila.
        $headerStyleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            ),
            'font'  => array(
                'size'  => 12
            )
        );

        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            ),
            'font'  => array(
                'size'  => 14
            )
        );        
        
        $styleCamionTitleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            ),
            'font'  => array(
                'size'  => 14
            )
        );        
        $firstTime = true;
        foreach($cLogisticaCamiones as $oLogisticaCamion){

            $cLogistica = $this->Logistica->getLogisticaBarriosByCamion($oLogisticaCamion->id);
            
            if(!is_null($cLogistica) && count($cLogistica)>0){
                /*if(!$firstTime){
                    $sheet = $spreadsheet->createSheet();
                }else{
                    $sheet = $spreadsheet->getActiveSheet();
                    $firstTime = false;
                }
                $xlsRow = 1;*/
                $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
                $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL);
                $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.1);
                $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.1);


                $sheet->setCellValue($xlsCol.$xlsRow, $oLogisticaCamion->camion);
                $sheet->mergeCells('A'.$xlsRow.':'.'C'.$xlsRow);
                $sheet->getColumnDimension($xlsCol)->setWidth(27);
                
                //ME PARO DIRECTO EN LA D PORQUE ANTES HAY UN COLSPAN DE A a C.
                $xlsCol = 'D';

                //col total bolsones
                $total = $this->Logistica->getTotalBolsonesByCamionBarrios($oLogisticaCamion->id);
                $sheet->setCellValue($xlsCol.$xlsRow, $total);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                //columna precio no va nada
                $xlsCol++;

                $sheet->getRowDimension($xlsRow)->setRowHeight(50);
                $sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->applyFromArray($styleCamionTitleArray);
                $sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                $sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->getFont()->setBold(true);
                $sheet->getStyle('A'.$xlsRow.':'.$xlsCol.$xlsRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFCFF28');
        
                $xlsCol++;
                $xlsRow++;

                $xlsCol = 'A';

                $sheet->setCellValue($xlsCol.$xlsRow, 'Cliente');
                $sheet->getColumnDimension($xlsCol)->setWidth(27);
                $xlsCol++;
                $sheet->setCellValue($xlsCol.$xlsRow, 'Celular');
                $sheet->getColumnDimension($xlsCol)->setWidth(18);
                $xlsCol++;
                $sheet->setCellValue($xlsCol.$xlsRow, 'Dirección');
                $sheet->getColumnDimension($xlsCol)->setWidth(40);
                $xlsCol++;
                $sheet->setCellValue($xlsCol.$xlsRow, 'Bolson Familiar (8kg)');
                $sheet->getColumnDimension($xlsCol)->setWidth(10);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                $xlsCol++;
                $sheet->setCellValue($xlsCol.$xlsRow, 'Precio Bolsón Familiar');
                $sheet->getColumnDimension($xlsCol)->setWidth(11);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                $xlsCol++;
                
                foreach($cExtras as $oExtra){
                    if(isset($oExtra->nombre_corto) && $oExtra->nombre_corto!=""){
                        $sheet->setCellValue($xlsCol.$xlsRow, $oExtra->nombre_corto);
                    }else{
                        $sheet->setCellValue($xlsCol.$xlsRow, $oExtra->name);
                    }
                    $sheet->getColumnDimension($xlsCol)->setWidth(11);
                    $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                    $xlsCol++;
                }            
                $sheet->setCellValue($xlsCol.$xlsRow, 'Reserva Abonada');
                //$sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                $xlsCol++;

                $sheet->setCellValue($xlsCol.$xlsRow, 'Total a Cobrar');
                $sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                $xlsCol++;

                $sheet->setCellValue($xlsCol.$xlsRow, 'Observaciones');
                $sheet->getColumnDimension($xlsCol)->setWidth(22);

                $lastColumn = $xlsCol;
        
                $sheet->getRowDimension($xlsRow)->setRowHeight(75);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                                        
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($headerStyleArray);
                $spreadsheet->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd($xlsRow, $xlsRow);
        
                $xlsRow++;
        
                foreach($cLogistica as $oLogistica){
                                
                    $idDiaEntrega = $oLogistica->id_dia_entrega;
                    $idBarrio = $oLogistica->id_barrio;
                    
                    $oBarrio = $this->Barrio->getById($idBarrio);
                    $cOrders = $this->Order->getOrdersBarriosWithExtrasByIdDiaEntregaAndIdBarrio($idDiaEntrega,$idBarrio);
        
                    /**LINEA DE NOMBRE DE PUNTO DE RETIRO Y SUBTOTALES */
                    $xlsCol = 'A';
                    $sheet->getRowDimension($xlsRow)->setRowHeight(26);
                    $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($headerStyleArray);
                    
                    $sheet->setCellValue($xlsCol.$xlsRow, $oBarrio->nombre." - ".$oBarrio->observaciones);
                    $sheet->mergeCells('A'.$xlsRow.':'.'C'.$xlsRow);
                    $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                    $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getFont()->setBold(true);
                    $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
                    $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setWrapText(true);
                    $sheet->getRowDimension($xlsRow)->setRowHeight(60);
        
                    //POR EL COLSPAN DE ARRIBA, LA DEJO DIRECTO EN LA COLUMAN DE BOLSONES (LA "D").
                    $xlsCol='D';
                    $sheet->setCellValue($xlsCol.$xlsRow, $oLogistica->cantidad_modificada);
                    $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $xlsCol++;
        
                    //LO DEJO EN LA PRIMER COLUMNA DE EXTRAS
                    $xlsCol = 'F';
        
                    foreach($cExtras as $oExtra){
                        $totalExtras = $this->Order->getTotalExtrasByBarrioByIdDiaEntregaByIdExtra(
                            $idBarrio,
                            $idDiaEntrega,
                            $oExtra->id
                        );
                        $sheet->setCellValue($xlsCol.$xlsRow, $totalExtras);
                        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $sheet->getColumnDimension($xlsCol)->setWidth(11);
                        $xlsCol++;    
                    }
        
                    $xlsRow++;
                    
                    foreach($cOrders as $oOrder){
                        $xlsCol = 'A';
                        
                        $sheet->setCellValue($xlsCol.$xlsRow, $oOrder['nro_orden']." - ".$oOrder['cliente']);            
                        $sheet->getColumnDimension($xlsCol)->setWidth(27);
                        $xlsCol++;
                        
                        $celularFormateado = $this->formatCelular($oOrder['celular']);
                        $sheet->setCellValue($xlsCol.$xlsRow, " ".$celularFormateado);            
                        $sheet->getColumnDimension($xlsCol)->setWidth(18);
                        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                        $xlsCol++;
        
                        $sheet->setCellValue($xlsCol.$xlsRow, " ".$oOrder['cliente_domicilio_full']);            
                        $sheet->getColumnDimension($xlsCol)->setWidth(40);
                        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                        $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                        $xlsCol++;

                        $cantidadBolson = 0;
                        $precioBolson = 0;
        
                        if(!is_null($oOrder['cant_bolson']) && $oOrder['cant_bolson']!=""){
                            $cantidadBolson = $oOrder['cant_bolson'];
                            $precioBolson = $oOrder['total_bolson'];
                        }
        
                        $sheet->setCellValue($xlsCol.$xlsRow, $cantidadBolson);
                        $sheet->getColumnDimension($xlsCol)->setWidth(10);
                        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $xlsCol++;
        
                        $sheet->setCellValue($xlsCol.$xlsRow, $precioBolson); 
                        $sheet->getColumnDimension($xlsCol)->setWidth(11);
                        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
                        $xlsCol++;
        
                        $extrasArray = $oOrder['extras'];
                        foreach($cExtras as $oExtra){ //Array de extras activos en la base de datos (con esto identifico la columna)
                            foreach($extrasArray as $ordenExtra){ //Array de extras en la orden (con esto pongo el precio en la columna correcta)
                                if($oExtra->id == $ordenExtra['id_extra']){
                                    $cantExtra = $this->Order->getCantOrderExtraByPedidoAndExtra($oOrder['order_id'],$oExtra->id);
                                    if(!isset($cantExtra)){
                                        $cantExtra = 1;
                                    }
                                    $cantExtra = $cantExtra[0]->cant;
                                    $precio = ($ordenExtra['extra_price'] * $cantExtra);

                                    $precioCant = "$".$precio;
                                    $precioCant .= "\n(x".$cantExtra.")";
            
                                    $sheet->setCellValue($xlsCol.$xlsRow, $precioCant);
                                    $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                                    $sheet->getColumnDimension($xlsCol)->setWidth(11);
                                }
                            }
                            $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
                            $xlsCol++;
                        }
        
                        $sheet->setCellValue($xlsCol.$xlsRow, $oOrder['monto_pagado']);
                        $sheet->getColumnDimension($xlsCol)->setWidth(10);
                        //$sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
                        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
                        $xlsCol++;

                        $sheet->setCellValue($xlsCol.$xlsRow, $oOrder['monto_debe']);
                        $sheet->getColumnDimension($xlsCol)->setWidth(10);
                        $sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);
                        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
                        $xlsCol++;

                        $obsConcat = "";
                        if(isset($oOrder['id_estado_pedido']) && $oOrder['id_estado_pedido']>0){
                            if($oOrder['id_estado_pedido']!=1){
                                //SI ES CONFIRMADO NO QUIERO QUE SALGA LA DESCRIPCION
                                $this->load->model('EstadosPedidos');
                                $estadoPedido = $this->EstadosPedidos->getById($oOrder['id_estado_pedido']);
                                $obsConcat = strtoupper($estadoPedido->descripcion);
                            }
                        }
                        if($obsConcat==""){
                            $obsConcat = $oOrder['observaciones'];
                        }else{
                            $obsConcat = $obsConcat." - ".$oOrder['observaciones'];
                        }

                        if($oOrder['id_cupon'] != null && $oOrder['id_cupon']>0) {
                            if($obsConcat==""){
                                $obsConcat = "Cupón de Descuento aplicado.";
                            }else{
                                $obsConcat = $obsConcat." - "."Cupón de Descuento aplicado.";
                            }    
                        }
            
                        $sheet->setCellValue($xlsCol.$xlsRow, $obsConcat);
                        $sheet->getColumnDimension($xlsCol)->setWidth(22);
                        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setWrapText(true);
                        $sheet->getRowDimension($xlsRow)->setRowHeight(35);
                        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($styleArray);
                        
                        $xlsRow++;
                        $pedidosCounter++;
                    }     
                }
            }
            $xlsCol = 'A';
        }
        //$spreadsheet->setActiveSheetIndex(0);
        $fileName = "LogisticaCamionesDetalles.xls";
        $writer = new Xlsx($spreadsheet);        
        $writer->save($fileName);    
        $xlsCreado = true;
        return $xlsCreado;
    }

    public function getCamionByIdCamion($idCamion){
        $this->output->set_content_type('application/json');
        
        $this->load->model('LogisticaDiasEntregaCamiones');
        
        if(is_null($idCamion)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        $oCamion = $this->LogisticaDiasEntregaCamiones->getById($idCamion);

        $return['status'] = self::OK_VALUE;
        $return['oCamion'] = $oCamion;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }

    public function deleteCamionDisponibilizado(){
        $this->output->set_content_type('application/json');
        
        $this->load->model('LogisticaDiasEntregaCamiones');
        $this->load->model('Logistica');

        $idLogisticaCamion = $this->input->post('idLogisticaCamion', true);

        if(is_null($idLogisticaCamion)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $cLogistica = $this->Logistica->getLogisticaByCamion($idLogisticaCamion);

        if(!is_null($cLogistica) && count($cLogistica)>0){
            foreach($cLogistica as $oLogistica){
                $this->Logistica->setLogisticaCamion($oLogistica->id_logistica,null);
            }
        }

        $this->LogisticaDiasEntregaCamiones->deleteCamionById($idLogisticaCamion);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }

    public function closeRegistroLogistica(){
        $this->output->set_content_type('application/json');
        
        $this->load->model('DiasEntregaPedidos');

        $idDiaEntrega = $this->input->post('idDiaEntrega', true);

        if(is_null($idDiaEntrega)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->DiasEntregaPedidos->setEstadoCerrado($idDiaEntrega);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }

    public function editMontoMinimoPedidosExtras(){
        $this->output->set_content_type('application/json');

        $montoMinimoPedidoExtras = (float)$this->input->post('montoMinimoPedidoExtras', true);

        if(is_null($montoMinimoPedidoExtras)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Content');
        $updateOK = $this->Content->set("montoMinimoPedidosExtras",$montoMinimoPedidoExtras);

        if($updateOK){
            $return['status'] = self::OK_VALUE;
            $return['updateOK'] = $updateOK;
            $this->output->set_status_header(200);
        }else{
            $return['status'] = "Error";
            $return['updateOK'] = false;
            $this->output->set_status_header(500);
        }
        return $this->output->set_output(json_encode($return));           
    }

    public function editCostoEnvioPedidosExtras(){
        $this->output->set_content_type('application/json');

        $costoEnvioPedidosExtras = (float)$this->input->post('costoEnvioPedidosExtras', true);

        if(is_null($costoEnvioPedidosExtras)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Content');
        $updateOK = $this->Content->set("costoEnvioPedidosExtras",$costoEnvioPedidosExtras);

        if($updateOK){
            $return['status'] = self::OK_VALUE;
            $return['updateOK'] = $updateOK;
            $this->output->set_status_header(200);
        }else{
            $return['status'] = "Error";
            $return['updateOK'] = false;
            $this->output->set_status_header(500);
        }
        return $this->output->set_output(json_encode($return));           
    }
    
    public function editCostoEnvioPedidos(){
        $this->output->set_content_type('application/json');

        $costoEnvioPedidos = (float)$this->input->post('costoEnvioPedidos', true);

        if(is_null($costoEnvioPedidos)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Content');
        $updateOK = $this->Content->set("costoEnvioPedidos",$costoEnvioPedidos);

        if($updateOK){
            $return['status'] = self::OK_VALUE;
            $return['updateOK'] = $updateOK;
            $this->output->set_status_header(200);
        }else{
            $return['status'] = "Error";
            $return['updateOK'] = false;
            $this->output->set_status_header(500);
        }
        return $this->output->set_output(json_encode($return));           
    }

    public function editMontoMinimoEnvioSinCargoPedidosExtras(){
        $this->output->set_content_type('application/json');

        $montoMinimoPedidoExtrasEnvioSinCargo = (float)$this->input->post('montoMinimoPedidoExtrasEnvioSinCargo', true);

        if(is_null($montoMinimoPedidoExtrasEnvioSinCargo)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Content');
        $updateOK = $this->Content->set("montoMinimoPedidosExtrasEnvioSinCargo",$montoMinimoPedidoExtrasEnvioSinCargo);

        if($updateOK){
            $return['status'] = self::OK_VALUE;
            $return['updateOK'] = $updateOK;
            $this->output->set_status_header(200);
        }else{
            $return['status'] = "Error";
            $return['updateOK'] = false;
            $this->output->set_status_header(500);
        }
        return $this->output->set_output(json_encode($return));           
    }

    public function uploadImagenDiaEntrega(){
        $idDiaEntrega = $_POST['idDiaEntrega'];
        $fileExtension = $_POST['fileExtension'];
        
        $fileName = "imagen_dia_".$idDiaEntrega.".".$fileExtension;

        if ( 0 < $_FILES['file']['error'] ) {
            echo 'Error: ' . $_FILES['file']['error'] . '<br>';
        }else {
            if(move_uploaded_file($_FILES['file']['tmp_name'], '../assets/img/dias-entrega-imagenes/'.$fileName)){
                $this->load->model('DiasEntregaPedidos');
                $this->DiasEntregaPedidos->setImagen($idDiaEntrega,$fileName);        
            }
        }
        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function editPedidoExtrasPuntoRetiroHabilitado(){
        $this->output->set_content_type('application/json');

        $pedidoExtrasPuntoDeRetiroHabilitado = $this->input->post('pedidoExtrasPuntoRetiropedidoExtrasPuntoRetiro', true);

        if(is_null($pedidoExtrasPuntoDeRetiroHabilitado)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Content');
        $updateOK = $this->Content->set("pedidoExtrasPuntoDeRetiroHabilitado",$pedidoExtrasPuntoDeRetiroHabilitado);

        if($updateOK){
            $return['status'] = self::OK_VALUE;
            $return['updateOK'] = $updateOK;
            $this->output->set_status_header(200);
        }else{
            $return['status'] = "Error";
            $return['updateOK'] = false;
            $this->output->set_status_header(500);
        }
        return $this->output->set_output(json_encode($return));                  
    }

    public function editPedidoExtrasDomicilioHabilitado(){
        $this->output->set_content_type('application/json');

        $pedidoExtrasDomicilioHabilitado = $this->input->post('pedidoExtrasDomicilioPedidoExtrasHabilitado', true);

        if(is_null($pedidoExtrasDomicilioHabilitado)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Content');
        $updateOK = $this->Content->set("pedidoExtrasDomicilioHabilitado",$pedidoExtrasDomicilioHabilitado);

        if($updateOK){
            $return['status'] = self::OK_VALUE;
            $return['updateOK'] = $updateOK;
            $this->output->set_status_header(200);
        }else{
            $return['status'] = "Error";
            $return['updateOK'] = false;
            $this->output->set_status_header(500);
        }
        return $this->output->set_output(json_encode($return));                  
    }

    public function editLimiteValorFormasPago(){
        $this->output->set_content_type('application/json');
        $updateOK = false;
        
        $valorFormasPago = $this->input->post('valorFormasPago', true);

        if(is_null($valorFormasPago)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        try{
            $this->load->model('Content');
            
            $this->Content->set("limite_pago_efectivo",$valorFormasPago);
            $updateOK = true;
            
        }catch(\Exception $ex){

        }
        
        if($updateOK){
            $return['status'] = self::OK_VALUE;
            $return['updateOK'] = $updateOK;
            $this->output->set_status_header(200);
        }else{
            $return['status'] = "Error";
            $return['updateOK'] = false;
            $this->output->set_status_header(500);
        }
        return $this->output->set_output(json_encode($return));           
    }

    public function getCostoEnvio(){
        $this->load->model('Content');
        
        $costoEnvioPedidos = (float)$this->Content->getCostoEnvio();

        if(is_null($costoEnvioPedidos)) {
            return 250;
        }

        return $costoEnvioPedidos;
    }

    public function setNewsletterStatus() {
        $this->output->set_content_type('application/json');

        $newsletterStatus = $this->input->post('newsletterStatus', true);

        if(!valid_session() || !isset($newsletterStatus)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Content');
        $this->Content->set('newsletterEnabled', $newsletterStatus);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode(true));
    }

    public function setRecetarioStatus() {
        $this->output->set_content_type('application/json');

        $recetarioStatus = $this->input->post('recetarioStatus', true);

        if(!valid_session() || !isset($recetarioStatus)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Content');
        $this->Content->set('recetarioStatus', $recetarioStatus);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode(true));
    }

    public function setNewsletterAdjuntoStatus() {
        $this->output->set_content_type('application/json');

        $adjuntoId = $this->input->post('adjuntoId', true);
        $adjuntoStatus = $this->input->post('adjuntoStatus', true);

        if(!valid_session() || !isset($adjuntoId) || !isset($adjuntoStatus)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('NewsletterAdjuntos');

        $this->NewsletterAdjuntos->setStatus($adjuntoId,$adjuntoStatus);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode(true));
    }

    public function addNewsletterAdjunto() {
        $this->output->set_content_type('application/json');
        $idAdjunto = -1;

        if ( 0 < $_FILES['file']['error'] ) {
            echo 'Error: ' . $_FILES['file']['error'] . '<br>';
        } else {
            $nombre = $_POST['nombre'];
            $nombreArchivo = $nombre;
            $nombreArchivo = str_replace(" ","_",$nombreArchivo);
            $nombreArchivo = strtolower($nombreArchivo);
            $fileExtension = $_POST['fileExtension'];
            $fileExtension = strtolower($fileExtension);
            $nombreArchivo = $nombreArchivo.'.'.$fileExtension;
            if(move_uploaded_file($_FILES['file']['tmp_name'], '../assets/resources/newsletter/adjuntos/'.$nombreArchivo)) {
                /* SI PUEDO CARGAR EL ARCHIVO, RECIEN AHI CARGO EL REGISTRO EN LA BASE YA QUE EL ARCHIVO ES LO MAS IMPORTANTE ACA*/
                $this->load->model('NewsletterAdjuntos');
                $idAdjunto = $this->NewsletterAdjuntos->add($nombre,$nombreArchivo);
            }
        }
        $return['idAdjunto'] = $idAdjunto;
        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    function getXlsNewsletterSuscriptions() {
        $this->output->set_content_type('application/json');
        
        $this->createXLSNewsletterSuscriptions();    
        $fileName = "NewsletterSuscripciones.xls";

        $return['status'] = self::OK_VALUE;
        $return['fileName'] = $fileName;
        //$this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));        
    }

    private function createXLSNewsletterSuscriptions(){
        $this->load->model('Newsletter');
        
        $cSuscripcionesNewsletter = $this->Newsletter->getAll();

        $xlsCreado = false;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Newsletter");
        $lastColumn = 'A';
        $xlsCol = 'A';
        $xlsRow = 1;

        
        //Array de estilos para las celdas. Lo aplico por fila.
        $headerStyleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            ),
            'font'  => array(
                'size'  => 14
            ),
            'fill' => array(
                'fillType' => Fill::FILL_SOLID,
                'startColor' => array('argb' => 'FFB8B8B8')
            )
        );

        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            ),
            'font'  => array(
                'size'  => 12
            )
        );        
    
        $sheet->setTitle('SUSCRIPCIONES');
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.1);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.1);

        $sheet->setCellValue($xlsCol.$xlsRow, 'Mail');
        $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

        $sheet->getRowDimension($xlsRow)->setRowHeight(35);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($headerStyleArray);

        $xlsRow++;
        
        foreach($cSuscripcionesNewsletter as $suscripcion){
            $sheet->setCellValue($xlsCol.$xlsRow, $suscripcion->mail);
            $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

            $sheet->getRowDimension($xlsRow)->setRowHeight(20);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($styleArray);
            $xlsRow++;
        }

        $fileName = "NewsletterSuscripciones.xls";
        $writer = new Xlsx($spreadsheet);        
        $writer->save($fileName);    
        $xlsCreado = true;
        return $xlsCreado;
    }

    public function deleteNewsletterAdjunto() {
        $this->output->set_content_type('application/json');

        $adjuntoId = $this->input->post('adjuntoId', true);

        if(!valid_session() || !isset($adjuntoId)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('NewsletterAdjuntos');

        $this->NewsletterAdjuntos->deleteAdjunto($adjuntoId);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode(true));
    }
    
    public function getNewsletterAdjunto() {
        $this->output->set_content_type('application/json');

        $adjuntoId = (float)$this->input->post('adjuntoId', true);

        if(is_null($adjuntoId)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('NewsletterAdjuntos');
        $adjunto = $this->NewsletterAdjuntos->getById($adjuntoId);

        $return['status'] = self::OK_VALUE;
        $return['adjunto'] = $adjunto;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));               
    }

    public function editRecetario() {
        $this->output->set_content_type('application/json');
        if ( 0 < $_FILES['file']['error'] ) {
            echo 'Error: ' . $_FILES['file']['error'] . '<br>';
        } else {
            $nombre = $_POST['nombre'];
            $nombreArchivo = $nombre;
            $nombreArchivo = strtolower($nombreArchivo);
            $fileExtension = $_POST['fileExtension'];
            $fileExtension = strtolower($fileExtension);
            $nombreArchivo = $nombreArchivo.'.'.$fileExtension;
            move_uploaded_file($_FILES['file']['tmp_name'], '../assets/resources/'.$nombreArchivo);
        }
        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));        
    }

    public function deleteCamionPreConfigurado() {
        $this->output->set_content_type('application/json');

        $camionId = (int)$this->input->post('idCamionPreConfigurado', true);
        
        if(is_null($camionId)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('CamionesPreConfigurados');
        if( $this->CamionesPreConfigurados->delete($camionId) ) {
            $this->load->model('CamionesPreConfiguradosPuntosBarrios');
            $cPuntosDeRetiroAsociadosACamion = $this->CamionesPreConfiguradosPuntosBarrios->getAllPuntosRetiroByIdCamionPreConfigurado($camionId);
            $cBarriosAsociadosACamion = $this->CamionesPreConfiguradosPuntosBarrios->getAllBarriosByIdCamionPreConfigurado($camionId);

            foreach($cPuntosDeRetiroAsociadosACamion as $oPdRAsociado){
                $this->CamionesPreConfiguradosPuntosBarrios->delete($oPdRAsociado->id);
            }
            foreach($cBarriosAsociadosACamion as $oBarrioAsociado){
                $this->CamionesPreConfiguradosPuntosBarrios->delete($oBarrioAsociado->id);
            }
        }

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));               
       
    }

    public function crearCupon(){
        $this->output->set_content_type('application/json');

        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $codigoCupon = $this->input->post('codigoCupon', true);
        $idTipoDescuento = $this->input->post('idTipoDescuento', true);
        $descuento = $this->input->post('descuento', true);
        
        if(is_null($codigoCupon) || is_null($idTipoDescuento) || is_null($descuento)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('Cupones');
        $idCupon = $this->Cupones->add(
            $codigoCupon,
            $idTipoDescuento,
            $descuento
        );

        $return['status'] = self::OK_VALUE;
        $return['idCupon'] = $idCupon; 
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));        
    }    

    public function getCupones() {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Cupones');
        $cCupones = [];
        $cCupones = $this->Cupones->getAll();
        
        $return['status'] = self::OK_VALUE;
        $return['cCupones'] = $cCupones;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function getCuponById($idCupon){
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('Cupones');
        
        $cupon = $this->Cupones->getById($idCupon);
        
        $return['status'] = self::OK_VALUE;
        $return['cupon'] = $cupon;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function editarCupon(){
        $this->output->set_content_type('application/json');
        
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
        
        $idCupon = $this->input->post('idCupon', true);
        $codigoCupon = $this->input->post('codigoCupon', true);
        $idTipoDescuento = $this->input->post('idTipoDescuento', true);
        $descuento = $this->input->post('descuento', true);
        
        if(is_null($idCupon)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }
        
        $this->load->model('Cupones');
        
        $this->Cupones->update(
            $idCupon,
            $codigoCupon,
            $idTipoDescuento,
            $descuento
        );

        $return['status'] = self::OK_VALUE;
        $return['idCupon'] = $idCupon; 
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));        
    }    

    public function setModuloCuponesStatus() {
        $this->output->set_content_type('application/json');

        $moduloCuponesStatus = $this->input->post('moduloCuponesStatus', true);

        if(!valid_session() || !isset($moduloCuponesStatus)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Content');
        $this->Content->set('moduloCuponesEnabled', $moduloCuponesStatus);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode(true));
    }

    public function deleteCupon() {
        $this->output->set_content_type('application/json');

        $idCupon = $this->input->post('idCupon', true);

        if(!valid_session() || !isset($idCupon)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Cupones');

        $this->Cupones->delete($idCupon);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function statusCupon() {
        $this->output->set_content_type('application/json');

        $idCupon = $this->input->post('idCupon', true);
        $cuponHabilitado = $this->input->post('cuponHabilitado', true);

        if(!valid_session() || !isset($idCupon) || !isset($cuponHabilitado)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('Cupones');

        $this->Cupones->updateStatus($idCupon, $cuponHabilitado);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function printCamionesSeleccionadosInCards() {
        $this->output->set_content_type('application/json');

        $preArrayCamiones = $this->input->post('arrayCamiones', true);
        $fileName = "";
        $arrayCamiones = [];

        if(is_null($preArrayCamiones)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        foreach($preArrayCamiones as $camiones){
            array_push($arrayCamiones,array(
                'idCamion' => $camiones['idCamion']
            ));
        }
        $this->createPDFForCamionesSeleccionadosInCards($arrayCamiones);
        $fileName = "CamionesComandas.pdf";

        $return['status'] = self::OK_VALUE;
        $return['fileName'] = $fileName;
        //$this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));                
    }

    private function createPDFForCamionesSeleccionadosInCards($arrayCamiones) {
        $this->load->model('Logistica');
        $this->load->model('LogisticaDiasEntregaCamiones');
        $this->load->model('Extra');
        $this->load->model('Order');
        $this->load->model('Office');
        $this->load->model('Barrio');

        $cExtras = $this->Extra->getActive();
        
        $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        
        $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];        
        
        $fontDir = realpath(__DIR__ . '/../../assets/fonts');
        
        $oPDF = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format'=> 'Legal',
            'orientation' => 'P',
            'margin_left' => '2',
            'margin_right' => '2',
            'margin_top' => '45',
            'fontdata' => $fontData + [
                'helvetica-r' => [
                    'R' => 'HelveticaNeueLTCom-LtCn.ttf',
                    'B' => 'HelveticaNeueLTCom-LtCn.ttf',
                ],
                'helvetica-b' => [
                    'R' => 'HelveticaNeueLTCom-BdCn.ttf',
                    'B' => 'HelveticaNeueLTCom-BdCn.ttf',
                ]
            ]
        ]);

        $oPDF->SetTitle('CamionesComandas');

        $maxOrdersByPage = 9;
        $maxExtrasByPage = 15;
        $firstTime = true;

        foreach($arrayCamiones as $camion){
            $cLogisticaPdR = $this->Logistica->getAllPuntosRetiroByIdCamion($camion['idCamion']);
            $cLogisticaBarrios = $this->Logistica->getAllBarriosByIdCamion($camion['idCamion']);
            $oCamion = $this->LogisticaDiasEntregaCamiones->getById($camion['idCamion']);
            $idDiaEntrega = -1;
            if (!is_null($cLogisticaPdR) && count($cLogisticaPdR)>0){
                $idDiaEntrega = $cLogisticaPdR[0]->id_dia_entrega;
            } else {
                $idDiaEntrega = $cLogisticaBarrios[0]->id_dia_entrega;
            }
            
            $cLogisticaFromCamion = $this->Logistica->getLogisticaByDiaEntregaAndCamion($idDiaEntrega,$oCamion->id);
            
            if(!$firstTime) {
                $oPDF->AddPage();                
            } else {
                $firstTime = false;
            }

            $oPDF->SetHTMLHeader("");
            $oPDF->setFooter('{PAGENO}');
            $oPDF->AddPageByArray(array(
                'orientation' => 'L',
                'mgt' => '2'));

            $html = $this->createHtmlForIndividualLogisticaCamion($oCamion, $cLogisticaFromCamion, $idDiaEntrega);                
            
            $oPDF->WriteHTML($html);
            $html = "";

            if (count($cLogisticaPdR)>0) {
                foreach($cLogisticaPdR as $oLogistica) {
                    $idPuntoRetiro = $oLogistica->id_punto_retiro;
                    $idDiaEntrega = $oLogistica->id_dia_entrega;
                    $oPuntoDeRetiro = $this->Office->getById($idPuntoRetiro);
                    $cOrders = $this->Order->getOrdersPuntosRetiroWithExtrasByIdDiaEntregaAndIdPuntoRetiroOrderedByCantExtras($idDiaEntrega,$idPuntoRetiro);
                    $oPDF->SetHTMLHeader("");
                    $oPDF->setFooter('{PAGENO}');
                    $oPDF->AddPageByArray(array(
                        'orientation' => 'L',
                        'mgt' => '2'));
                    $html = $this->generateResumenReducidoLogisticaPuntoDeRetiro($oCamion,$oLogistica,$cOrders);
                    $oPDF->WriteHTML($html);

                    $html = "";

                    $headerHtml = "<div style='width:100%'>";
                    $headerHtml .= "<h1 style='font-family: helvetica-r;margin-bottom:0px;padding-bottom:0px;'><span style='font-family:helvetica-b;'>"
                        .strtoupper($oCamion->camion)."</span></h1>";
                    $headerHtml .=  "<h3 style='font-family:helvetica-r; padding-bottom:10px;border-bottom:4px solid #000000'>PUNTO DE RETIRO: <span style='font-family:helvetica-b;'>"
                        .strtoupper($oPuntoDeRetiro->name)."</span> - ".strtoupper($oPuntoDeRetiro->address)."</h3>";
                    $headerHtml .= "</div>";
                    $oPDF->SetHTMLHeader($headerHtml);
                    $oPDF->setFooter('{PAGENO}');
                    $oPDF->AddPageByArray(array(
                        'mgt' => '45'));
        
                    $html = "<div style='width:100%'>";
                    $contOrders = 0;
                    $cantOrders = count($cOrders);
                    $contExtras = 0;
                    foreach ($cOrders as $oOrder) {
                        $contOrders++;
                        if($contOrders == 4 || $contOrders == 7) {
                            $contExtras = $contExtras + count($oOrder['extras']);
                        }

                        /*if($contOrders == 4 || $contOrders == 7) {
                            $futureExtrasCant = $contExtras + count($oOrder['extras']);
                            if( $futureExtrasCant > $maxExtrasByPage) {
                                $oPDF->WriteHTML($html."</div><div style='width:100%'>");
                                $html = "";
                                if($contOrders < $cantOrders) {
                                    $oPDF->AddPage();
                                    $contOrders = 0;
                                    $contExtras = 0;
                                }
                            }
                        }*/
        
                        $html .= $this->generateComandaPedidoHtml($oOrder, $oOrder["id_tipo_pedido"], $oPuntoDeRetiro->name);
                        if ($contOrders == $maxOrdersByPage) {
                            //printf($oPuntoDeRetiro->name." paso el limite de hojas");
                            $oPDF->WriteHTML($html."</div><div style='width:100%'>");
                            $html = "";
                            if($contOrders < $cantOrders) {
                                $oPDF->AddPage();
                                $contOrders = 0;
                                $contExtras = 0;
                            }
                        }
                    }
                    if ($html!="") {
                        $oPDF->SetHTMLHeader("");

                        $oPDF->WriteHTML($html."</div>");
                    }
                    $html = "";
                }
            }
            if (count($cLogisticaBarrios)>0) {
                $html = "";
                $oPDF->SetHTMLHeader("");
                $oPDF->setFooter('{PAGENO}');
                $oPDF->AddPageByArray(array(
                    'orientation' => 'L',
                    'mgt' => '2'));

                $html = "<table style='border-collapse:collapse;border:1px solid #000000;width:100%;font-family:Arial;font-size:14px;'>";
                $html .= "<thead>";
                $html .= "<tr><td colspan='9' style='text-align:left;border:1px solid #000000;'>".$oCamion->camion."</td></tr>";
                $html .= "</thead>";
                $html .= "<tbody>";
                $html .= "</tbody>";
                $html .= "</table>";

                foreach($cLogisticaBarrios as $oLogistica) {
                    $idBarrio = $oLogistica->id_barrio;
                    $idDiaEntrega = $oLogistica->id_dia_entrega;
                    $cOrders = $this->Order->getOrdersBarriosWithExtrasByIdDiaEntregaAndIdBarrioOrderedByCantExtras($idDiaEntrega,$idBarrio);
                    $html .= $this->generateResumenReducidoLogisticaBarrios($oLogistica,$cOrders);
                }
                $oPDF->WriteHTML($html);
                $html = "";
                foreach($cLogisticaBarrios as $oLogistica) {
                    $idBarrio = $oLogistica->id_barrio;
                    $idDiaEntrega = $oLogistica->id_dia_entrega;
                    $cOrders = $this->Order->getOrdersBarriosWithExtrasByIdDiaEntregaAndIdBarrioOrderedByCantExtras($idDiaEntrega,$idBarrio);
                    $oBarrio = $this->Barrio->getById($idBarrio);
                    $headerHtml = "<div style='width:100%'>";
                    $headerHtml .= "<h1 style='font-family: helvetica-r;margin-bottom:0px;padding-bottom:0px;'><span style='font-family:helvetica-b;'>"
                        .strtoupper($oCamion->camion)."</span></h1>";
                    $headerHtml .=  "<h3 style='font-family:helvetica-r; padding-bottom:10px;border-bottom:4px solid #000000'>DOMICILIO: <span style='font-family:helvetica-b;'>"
                        .strtoupper($oBarrio->nombre)."</span> - ".strtoupper($oBarrio->observaciones)."</h3>";

                    $headerHtml .= "</div>";
                    $oPDF->SetHTMLHeader($headerHtml);
                    $oPDF->setFooter('{PAGENO}');
                    $oPDF->AddPageByArray(array(
                        'mgt' => '45'));
                    
                    $html = "<div style='width:100%'>";
                    $contOrders = 0;
                    $cantOrders = count($cOrders);
                    $contExtras = 0;
                    foreach ($cOrders as $oOrder) {
                        $contOrders++;

                        if($contOrders == 1) {
                            $contExtras = $contExtras + count($oOrder['extras']);
                        }

                        if($contOrders == 4 || $contOrders == 7) {
                            $futureExtrasCant = $contExtras + count($oOrder['extras']);
                            if( $futureExtrasCant > $maxExtrasByPage) {
                                $oPDF->WriteHTML($html."</div><div style='width:100%'>");
                                $html = "";
                                $oPDF->AddPage();
                                $contOrders = 1;
                                $contExtras = 0;
                            } else {
                                $contExtras = $contExtras + count($oOrder['extras']);
                            }
                            
                        }

                        $html .= $this->generateComandaPedidoHtml($oOrder, $oOrder["id_tipo_pedido"], $oBarrio->nombre);
                        if ($contOrders == $maxOrdersByPage) {
                            $oPDF->WriteHTML($html."</div><div style='width:100%'>");
                            $html = "";
                            if($contOrders < $cantOrders) {
                                //printf("\n\nCORTA HOJA\n\n");
                                $oPDF->AddPage();
                                $contOrders = 0;
                                $contExtras = 0;
                            }
                        }
                    }
                    if ($html!="") {
                        $oPDF->WriteHTML($html."</div>");
                    }
                    $html = "";
                    $contOrders = 0;
                    $contExtras = 0;
                }
            }            
            $html .= "</div>";
            $oPDF->WriteHTML($html);
        }
        $oPDF->Output('CamionesComandas.pdf', 'F');
        return 1;        
    }    

    private function generateResumenReducidoLogisticaBarrios($oLogistica,$cOrders) {
        $html = "<table style='border-collapse:collapse;border:1px solid #000000;width:100%;font-family:Arial;font-size:14px;'>";
        $html .= "<thead style='height:20px;max-height:20px;'>";
        $html .= "<tr style='height:20px;max-height:20px;'>";
        $html .= "<th style='font-size:12px;width:22%;border:1px solid'>Cliente</th>";
        $html .= "<th style='font-size:12px;width:10%;border:1px solid'>Celular</th>";
        $html .= "<th style='font-size:12px;width:22%;border:1px solid'>Dirección</th>";
        $html .= "<th style='font-size:12px;width:7%;height:20px;max-height:20px;border:1px solid'>Bols. Fam. (8kg)</th>";
        $html .= "<th style='font-size:12px;width:7%;height:20px;max-height:20px;border:1px solid'>Bols. Ind. (5kg)</th>";
        $html .= "<th style='font-size:12px;width:7%;height:20px;max-height:20px;border:1px solid'>Bolsas de Friselina</th>";
        $html .= "<th style='font-size:12px;width:7%;height:20px;max-height:20px;border:1px solid'>Reserva Abonada</th>";
        $html .= "<th style='font-size:12px;width:7%;height:20px;max-height:20px;border:1px solid'>Total a Cobrar</th>";
        $html .= "<th style='font-size:12px;width:10%;border:1px solid'>Observaciones</th>";
        $html .= "</tr>";
        $html .= "</thead>";
        $html .= "<tbody style='font-size:16px'>";
        $html .= "<tr style='background-color:#d1d1d1;'>";
        $html .= "<td colspan='3' style='color:#000000;font-size:18px'><b>";
        $html .= $cOrders[0]['barrio']." - ".$cOrders[0]['barrio_observaciones'];
        $html .= "</b></td>";
        $html .= "<td style='font-size:20px;color:#000000; text-align:center;border:1px solid #000000;' ><b>".$oLogistica->cantidad_modificada."</b></td>"; 
        $html .= "<td style='font-size:20px;color:#000000; text-align:center;border:1px solid #000000;' ><b>".$oLogistica->cantidad_bolsones_individuales_modificado."</b></td>"; 
        $html .= "<td style='border:1px solid #000000;'></td>"; 
        $html .= "<td style='border:1px solid #000000;'></td>"; 
        $html .= "<td style='border:1px solid #000000;'></td>"; 
        $html .= "<td style='border:1px solid #000000;'></td>"; 
        $html .= "</tr>";
        foreach($cOrders as $oOrder) {
            if($oOrder['id_estado_pedido']==2 || $oOrder['id_estado_pedido']==3){
                $html .= "<tr style='background-color:#d1d1d1;'>";
            }else{
                $html .= "<tr>";
            }
            $html .= "<td style='font-size:16px;min-height:45px;height:45px;border:1px solid'>".$oOrder['nro_orden']." - ".$oOrder['cliente']."</td>";
            $html .= "<td style='font-size:16px;border:1px solid'>".$oOrder['celular']."</td>";
            $html .= "<td style='font-size:16px;border:1px solid'>".$oOrder['cliente_domicilio_full']."</td>";

            $cant_bolson = "-";
            if(!is_null($oOrder['cant_bolson']) && $oOrder['cant_bolson']!=""){
                $cant_bolson = intval($oOrder['cant_bolson']);
            }
            $html .= "<td style='font-size:20px;text-align:center;border:1px solid'>".$cant_bolson."</td>";
            $html .= "<td style='font-size:20px;text-align:center;border:1px solid'>".$oOrder['cant_bolsones_individuales']."</td>";
            $html .= "<td style='border:1px solid'></td>";
            $html .= "<td style='font-size:20px;text-align:center;border:1px solid'>$".$oOrder['monto_pagado']."</td>";
            $html .= "<td style='font-size:20px;text-align:center;border:1px solid'><b>$".$oOrder['monto_debe']."</b></td>";

            $obs = "";        
            if($oOrder['id_estado_pedido']==2){
                $obs .= "ESPECIAL - ";
            }
            if($oOrder['id_estado_pedido']==3){
                $obs .= "BONIFICADO - ";
            }

            if($oOrder['id_cupon'] != null && $oOrder['id_cupon']>0) {
                if($obs==""){
                    $obs = "Cupón de Descuento aplicado.";
                }else{
                    $obs = $obs." - "."Cupón de Descuento aplicado.";
                }    
            }
    
            if($oOrder['observaciones']!=""){
                $obs .= $oOrder['observaciones'];
            }
            $html .= "<td style='font-size:12px;border:1px solid'>".$obs."</td>";
            $html .= "</tr>";
        }
        $html .= "<tr><td colspan='9'>&nbsp;</td></tr>";
        $html .= "</tbody>";
        $html .= "</table>";
        return $html;
    }

    private function generateResumenReducidoLogisticaPuntoDeRetiro($oCamion,$oLogistica,$cOrders) {
        $html = "<table style='border-collapse:collapse;border:1px solid #000000;width:100%;font-family:Arial;'>";
        $html .= "<thead>";
        $html .= "<tr><td colspan='9' style='text-align:left;border:1px solid #000000;'>".$oCamion->camion."</td></tr>";
        $html .= "<tr>";
        $html .= "<th style='font-size:12px;width:30%;border:1px solid'>Cliente</th>";
        $html .= "<th style='font-size:12px;width:14%;border:1px solid'>Celular</th>";
        
        $html .= "<th style='font-size:12px;width:7%;word-wrap:break-word;max-height:30px;height:30px;border:1px solid'>Bolsón Familiar (8kg)</th>";
        $html .= "<th style='font-size:12px;width:8%;word-wrap:break-word;max-height:30px;height:30px;border:1px solid'>Bolsón Individual (5kg)</th>";
        $html .= "<th style='font-size:12px;width:5%;border:1px solid'>Bolsas de Friselina</th>";
        $html .= "<th style='font-size:12px;width:7%;border:1px solid'>Reserva Abonada</th>";
        $html .= "<th style='font-size:12px;width:7%;border:1px solid'>Total a Cobrar</th>";
        $html .= "<th style='font-size:12px;width:6%;border:1px solid'>Pedido Entregado</th>";
        $html .= "<th style='font-size:12px;width:16%;border:1px solid'>Observaciones</th>";
        $html .= "</tr>";
        $html .= "</thead>";
        $html .= "<tbody style='font-size:16px'>";
        $html .= "<tr style='background-color:#d1d1d1;'>";
        $html .= "<td colspan='2' style='color:#000000;font-size:18px;'><b>";
        $html .= $cOrders[0]['sucursal']." - ".$cOrders[0]['domicilio_sucursal'];
        $html .= "</b></td>";
        $html .= "<td style='font-size:20px;color:#000000; text-align:center;border:1px solid #000000;'><b>".$oLogistica->cantidad_modificada."</b></td>"; 
        $html .= "<td style='font-size:20px;color:#000000; text-align:center;border:1px solid #000000;'><b>".$oLogistica->cantidad_bolsones_individuales_modificado."</b></td>"; 
        $html .= "<td style='border:1px solid #000000;'></td>"; 
        $html .= "<td style='border:1px solid #000000;'></td>"; 
        $html .= "<td style='border:1px solid #000000;'></td>"; 
        $html .= "<td style='border:1px solid #000000;'></td>"; 
        $html .= "<td style='border:1px solid #000000;'></td>"; 
        $html .= "</tr>";
        foreach($cOrders as $oOrder) {
            if($oOrder['id_estado_pedido']==2 || $oOrder['id_estado_pedido']==3){
                $html .= "<tr style='background-color:#d1d1d1;'>";
            }else{
                $html .= "<tr>";
            }

            $html .= "<td style='font-size:16px;min-height:45px;height:45px;border:1px solid'>".$oOrder['nro_orden']." - ".$oOrder['cliente']."</td>";
            $html .= "<td style='font-size:16px;border:1px solid'>".$oOrder['celular']."</td>";

            $cant_bolson = "-";
            if(!is_null($oOrder['cant_bolson']) && $oOrder['cant_bolson']!=""){
                $cant_bolson = intval($oOrder['cant_bolson']);
            }
            $html .= "<td style='font-size:20px;text-align:center;border:1px solid'>".$cant_bolson."</td>";
            $html .= "<td style='font-size:20px;text-align:center;border:1px solid'>".$oOrder['cant_bolsones_individuales']."</td>";
            $html .= "<td style='font-size:16px;border:1px solid'></td>";
            $html .= "<td style='font-size:20px;text-align:center;border:1px solid'>$".$oOrder['monto_pagado']."</td>";
            $html .= "<td style='font-size:20px;text-align:center;border:1px solid'><b>$".$oOrder['monto_debe']."</b></td>";
            $html .= "<td style='font-size:16px;border:1px solid'></td>";

            $obs = "";        
            if($oOrder['id_estado_pedido']==2){
                $obs .= "ESPECIAL - ";
            }
            if($oOrder['id_estado_pedido']==3){
                $obs .= "BONIFICADO - ";
            }

            if($oOrder['id_cupon'] != null && $oOrder['id_cupon']>0) {
                if($obs==""){
                    $obs = "Cupón de Descuento aplicado.";
                }else{
                    $obs = $obs." - "."Cupón de Descuento aplicado.";
                }    
            }
    
            if($oOrder['observaciones']!=""){
                $obs .= $oOrder['observaciones'];
            }
            $html .= "<td style='font-size:16px;border:1px solid'>".$obs."</td>";
            $html .= "</tr>";
        }
        $html .= "</tbody>";
        $html .= "</table>";
        return $html;
    }

    private function generateComandaPedidoHtml($oOrder, $idTipoPedido, $tipoPedidoLugar) {
        $this->load->model('Order');
        $html = "";
        $tipoPedido = "";
        $direccion = "";
        $extrasArray = $this->Order->getExtrasWithCantidad($oOrder["order_id"]);
        if($idTipoPedido == 1) {
            $tipoPedido = "SUCURSAL";
        } else {
            $tipoPedido = "BARRIO";
            $direccion = $oOrder["cliente_domicilio_full"];
        }
        $html .= "<div style='width:30%; border:1px solid #000000; margin-right: 10px; margin-left: 10px; margin-bottom: 10px; padding:5px; float:left;'>";
        $html .= "<h5 style='letter-spacing:0.5px;line-height:20px;font-family: helvetica-b; margin-top:0px; margin-bottom:0px;font-size:14px;'>PEDIDO: ".$oOrder["nro_orden"]." - ".$oOrder["cliente"]."</h5>";
        $html .= "<h5 style='letter-spacing:0.5px;line-height:20px;border-bottom:1px solid #c3c3c3; font-family: helvetica-b; margin-top:0px; margin-bottom:5px;font-size:14px;'>TEL.: ".$oOrder["celular"]."</h5>";
        
        if($idTipoPedido == 2) {
            $html .= "<h5 style='letter-spacing:0.5px;line-height:20px;font-family: helvetica-r; margin-top:0px; margin-bottom:0px;'>".$tipoPedido.": ".$tipoPedidoLugar."</h5>";
            $html .= "<h5 style='letter-spacing:0.5px;line-height:20px;font-family: helvetica-r; margin-top:0px; margin-bottom:0px;'>DIRECCIÓN: <span style='font-family: helvetica-r'>".$direccion."</span></h5>";
            $html .= "<h5 style='letter-spacing:0.5px;line-height:20px;border-bottom:2px solid #000000;font-family: helvetica-r; margin-top:0px; margin-bottom:0px;'>FORMA DE PAGO: <span style='font-family: helvetica-r'>".$oOrder["forma_pago"]."</span></h5>";
        } else {
            $html .= "<h5 style='letter-spacing:0.5px;line-height:20px;font-family: helvetica-r; border-bottom:2px solid #000000; margin-top:0px; margin-bottom:0px;'>".$tipoPedido.": ".$tipoPedidoLugar."</h5>";
        }
        $html .= "<table style='width:100%;letter-spacing:0.5px;line-height:20px;font-family: helvetica-b; border-bottom:2px solid #000000;'>";
        $html .= "<thead><tr>";
        $html .= "<th align='left' style='letter-spacing:0.5px;line-height:20px;width:70%;font-size:10px;'>ARTÍCULO</th>";
        $html .= "<th align='center' style='letter-spacing:0.5px;line-height:20px;width:10%;font-size:10px;'>CANT.</th>";
        $html .= "<th align='right' style='letter-spacing:0.5px;line-height:20px;width:20%;font-size:10px;'>PRECIO</th>";
        $html .= "</tr></thead>";
        $html .= "<tbody style='letter-spacing:0.5px;line-height:20px;font-family: helvetica-r;'>";
        if(intval($oOrder["cant_bolson"])>0) {
            $html .= "<tr>";
            $html .= "<td align='left' style='letter-spacing:0.5px;line-height:20px;border-bottom:1px solid #c3c3c3;font-family: helvetica-r;font-size:14px;'>".$oOrder["nombre_bolson"]."</td>";
            $html .= "<td align='center' style='letter-spacing:0.5px;line-height:20px;border-bottom:1px solid #c3c3c3;font-family: helvetica-r;font-size:14px;'>".$oOrder["cant_bolson"]."</td>";
            $html .= "<td align='right' style='letter-spacing:0.5px;line-height:20px;border-bottom:1px solid #c3c3c3;font-family: helvetica-r;font-size:14px;'>$".intval($oOrder["total_bolson"])/intval($oOrder["cant_bolson"])."</td>";
            $html .= "</tr>";
        }
        if(count($extrasArray)>0) {
            foreach($extrasArray as $oExtra) {
                $html .= "<tr>";
                $html .= "<td align='left' style='letter-spacing:0.5px;line-height:20px;border-bottom:1px solid #c3c3c3;font-family: helvetica-r;font-size:14px;'>".$oExtra->nombre_corto."</td>";
                $html .= "<td align='center' style='letter-spacing:0.5px;line-height:20px;border-bottom:1px solid #c3c3c3;font-family: helvetica-r;font-size:14px;'>".$oExtra->cant."</td>";
                $html .= "<td align='right' style='letter-spacing:0.5px;line-height:20px;border-bottom:1px solid #c3c3c3;font-family: helvetica-r;font-size:14px;'><b>$".intval($oExtra->total)/intval($oExtra->cant)."</b></td>";
                $html .= "</tr>";
            }
        }
        if(intval($idTipoPedido) == 2) {
            $html .= "<tr>";
            $html .= "<td align='left' colspan='2' style='letter-spacing:0.5px;line-height:20px;font-family: helvetica-r;font-size:12px;'>ENVÍO</td>";
            $html .= "<td align='right' style='letter-spacing:0.5px;line-height:20px;font-family: helvetica-r;font-size:12px;'>$".intval($oOrder["costo_envio"])."</td>";
            $html .= "</tr>";
        }
        $html .= "</tbody>";
        $html .= "</tr></tbody>";
        $html .= "</table>";
        $html .= "<table style='width:100%;margin-top:0px; margin-bottom:0px;border-bottom:2px solid #000000;'>";
        $html .= "<thead><tr>";
        $html .= "<th align='right' style='width:70%;'></th>";
        $html .= "<th align='right' style='width:30%;'></th>";
        $html .= "</thead>";
        $html .= "<tbody>";
        $html .= "<tr>";
        $html .= "<td align='right' style='letter-spacing:0.5px;line-height:20px;font-family: helvetica-r;font-size:12px;'>MONTO ABONADO:</td>";
        $html .= "<td align='right' style='letter-spacing:0.5px;line-height:20px;font-family: helvetica-r;font-size:12px;'>$".$oOrder['monto_pagado']."</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td align='right' style='letter-spacing:0.5px;line-height:20px;font-family: helvetica-b;font-size:12px;'><h2>TOTAL A ABONAR:</h2></td>";
        $html .= "<td align='right' style='letter-spacing:0.5px;line-height:20px;font-family: helvetica-b;font-size:12px;'><h2>$".$oOrder['monto_debe']."</h2></td>";
        $html .= "</tr>";
        $html .= "</tbody>";
        $html .= "</table>";
        $html .= "<p style='min-height:50px;height:50px;letter-spacing:0.5px;margin-top:10px;font-family: helvetica-r; text-align: justify;font-size:10px;'>";
        $html .= "COMENTARIO: <br />";

        $obs = "";
        
        if($oOrder['id_estado_pedido']==2){
            $obs .= "ESPECIAL - ";
        }
        if($oOrder['id_estado_pedido']==3){
            $obs .= "BONIFICADO - ";
        }
        if($oOrder['observaciones']!=""){
            $obs .= $oOrder['observaciones'];
        }

        if($oOrder['id_cupon'] != null && $oOrder['id_cupon']>0) {
            if($obs==""){
                $obs = "Cupón de Descuento aplicado.";
            }else{
                $obs = $obs." - "."Cupón de Descuento aplicado.";
            }    
        }

        $html .= $obs;
        $html .= "</p>";
        $html .= "</div>";
        return $html;
    }

    public function printCamionesSeleccionados(){
        $this->output->set_content_type('application/json');

        $preArrayCamiones = $this->input->post('arrayCamiones', true);
        $fileName = "";
        $arrayCamiones = [];

        if(is_null($preArrayCamiones)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'No se recibieron los parámetros necesarios.';
            $this->output->set_status_header(403);
            return $this->output->set_output(json_encode($return));
        }

        foreach($preArrayCamiones as $camiones){
            array_push($arrayCamiones,array(
                'idCamion' => $camiones['idCamion']
            ));
        }
        $this->createPDFForCamionesSeleccionados($arrayCamiones);
        $fileName = "CamionesLogistica.pdf";

        $return['status'] = self::OK_VALUE;
        $return['fileName'] = $fileName;
        //$this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));            
    }        
    
    public function createPDFForCamionesSeleccionados($arrayCamiones) {
        $this->load->model('Logistica');
        $this->load->model('LogisticaDiasEntregaCamiones');
        $this->load->model('Extra');
        $this->load->model('Order');
        $this->load->model('Office');
        $this->load->model('Barrio');

        $cExtras = $this->Extra->getActive();
        
        $oPDF = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format'=> 'Legal',
            'orientation' => 'L',
            'margin_left' => '5',
            'margin_right' => '5',
            'margin_top' => '32'
        ]);

        $oPDF->SetTitle('Camiones Logistica');
        
        $html = "";

        $pedidosCounter = 1;
        $cLogisticaPdR = [];
        $cLogisticaBarrios = [];
        $counter = 0;
        foreach($arrayCamiones as $camion){
            $html = "";
            $cLogisticaPdR = $this->Logistica->getAllPuntosRetiroByIdCamion($camion['idCamion']);
            $cLogisticaBarrios = $this->Logistica->getAllBarriosByIdCamion($camion['idCamion']);
            $oCamion = $this->LogisticaDiasEntregaCamiones->getById($camion['idCamion']);

            if(count($cLogisticaBarrios)>0) {
                $cabeceraHTML = "";

                $pedidosCounter = 1;
        
                $cabeceraHTML .= "<table style='border-collapse:collapse;border:1px solid #FF0000;width:100%;font-family:Arial;font-size:10px;'><tbody>";
                $cabeceraHTML .= "<tr><td style='width:180px;max-width:180px;min-width:180px;text-align:center;border:1px solid #000000;'>".$oCamion->camion."</td></tr>";
                $cabeceraHTML .= "<tr><td width='180' style='width:180px;max-width:180px;min-width:180px;text-align:center;border:1px solid #000000;'>Cliente</td>";
                $cabeceraHTML .= "<td width='180' style='width:180px;max-width:180px;min-width:180px;text-align:center;border:1px solid #000000;'>Email</td>";
                $cabeceraHTML .= "<td width='80' style='width:80px;max-width:80px;min-width:80px;text-align:center;border:1px solid #000000;'>Celular</td>";
                $cabeceraHTML .= "<td width='160' style='width:160px;max-width:160px;min-width:160px;text-align:center;border:1px solid #000000;'>Dirección</td>";
                $cabeceraHTML .= "<td text-rotate='90' style='width:30px;max-width:30px;min-width:30px;text-align:center;border:1px solid #000000;'>Bolsón Familiar (8kg)</td>";
                $cabeceraHTML .= "<td text-rotate='90' style='width:40px;max-width:40px;min-width:40px;text-align:center;border:1px solid #000000;'>Precio Bolsón Familiar</td>";

                $contExtra = 0;
                $pedidoResaltado = false;
        
                foreach($cExtras as $oExtra){
                    $extraName = "";
                    if(isset($oExtra->nombre_corto) && $oExtra->nombre_corto!=""){
                        $extraName = $oExtra->nombre_corto;
                    } else {
                        $extraName = $oExtra->name;
                    }
                    $backgroundColor = "";
                    if($contExtra % 2 == 0){
                        $backgroundColor = "background-color:#dadada";
                    } else {
                        $backgroundColor = "background-color:#FFFFFF";
                    }
                    $cabeceraHTML .= "<td valign='middle' text-rotate='90' style='width:30px;max-width:30px;min-width:30px;text-align:center;border:1px solid #000000;".$backgroundColor."'>".$extraName."</td>";
                    $contExtra++;
                }
        
                $cabeceraHTML .= "<td text-rotate='90' style='width:40px;max-width:40px;min-width:40px;text-align:center;border:1px solid #000000;'>Reserva Abonada</td>";
                $cabeceraHTML .= "<td text-rotate='90' style='width:40px;max-width:40px;min-width:40px;text-align:center;border:1px solid #000000;'>Total a Cobrar</td>";
                $cabeceraHTML .= "<td style='width:80px;max-width:80px;min-width:80px;text-align:center;border:1px solid #000000;'>Observaciones</td>";
                $cabeceraHTML .= "</tr></tbody></table>";
        
                if($counter>0) {
                    $oPDF->SetHTMLHeader(""); 
                    $oPDF->SetHTMLHeader($cabeceraHTML);
                    $oPDF->SetMargins(5,5,32,5);
                    $oPDF->AddPage();
                } else {
                    $oPDF->SetHTMLHeader($cabeceraHTML);
                }

                $htmlInitTable = "<table style='border-collapse:collapse;width:100%;font-family:Arial;font-size:10px;'>";
                $htmlInitTable .= "<thead>";
                $htmlInitTable .= "<tr>";
                $htmlInitTable .= "<td width='180' style='width:180px;max-width:180px;min-width:180px;'>&nbsp;</td>";
                $htmlInitTable .= "<td width='180' style='width:180px;max-width:180px;min-width:180px;'>&nbsp;</td>";
                $htmlInitTable .= "<td width='80' style='width:80px;max-width:80px;min-width:80px;'>&nbsp;</td>";
                $htmlInitTable .= "<td width='160' style='width:160px;max-width:160px;min-width:160px;'>&nbsp;</td>";
                $htmlInitTable .= "<td text-rotate='90' style='width:30px;max-width:30px;min-width:30px;'>&nbsp;</td>";
                $htmlInitTable .= "<td text-rotate='90' style='width:40px;max-width:40px;min-width:40px;'>&nbsp;</td>";
        
                foreach($cExtras as $oExtra){
                    $htmlInitTable .= "<td valign='middle' text-rotate='90' style='width:30px;max-width:30px;min-width:30px;'>&nbsp;</td>";
                }        
        
                $htmlInitTable .= "<td text-rotate='90' style='width:40px;max-width:40px;min-width:40px;'>&nbsp;</td>";
                $htmlInitTable .= "<td text-rotate='90' style='width:40px;max-width:40px;min-width:40px;'>&nbsp;</td>";
                $htmlInitTable .= "<td style='width:80px;word-wrap: break-word!important;max-width:80px!important;min-width:80px;'>&nbsp;</td>";
                $htmlInitTable .= "</tr>";
        
                $htmlInitTable .= "</thead>";
                $htmlInitTable .= "<tbody>";
                $html .= $htmlInitTable;
        
                //$html .= $cabeceraHTML;
                foreach($cLogisticaBarrios as $oLogistica) {
                    $idDiaEntrega = $oLogistica->id_dia_entrega;
                    $idBarrio = $oLogistica->id_barrio;
                    
                    $oBarrio = $this->Barrio->getById($idBarrio);
                    $cOrders = $this->Order->getOrdersBarriosWithExtrasByIdDiaEntregaAndIdBarrio($idDiaEntrega,$idBarrio);
                    $html .= "<tr style='background-color:#000000;'>";
                    $html .= "<td height='50' style='font-size:12px;color:#FFFFFF; text-align:left;border:1px solid #000000;' colspan='4'><b>".$oBarrio->nombre." - ".$oBarrio->observaciones."</b></td>";
                    $html .= "<td style='font-size:12px;color:#FFFFFF; text-align:center;border:1px solid #000000;' ><b>".$oLogistica->cantidad_modificada."</b></td>"; 
                    $html .= "<td style='border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA PRECIO NO TIENE VALOR
                    
                    foreach($cExtras as $oExtra){
                        $totalExtras = $this->Order->getTotalExtrasByBarrioByIdDiaEntregaByIdExtra(
                            $idBarrio,
                            $idDiaEntrega,
                            $oExtra->id
                        );
                        $html .= "<td style='font-size:12px;color:#FFFFFF;font-weight:600;text-align:center;border:1px solid #000000;'><b>".$totalExtras."</b></td>";
                    }            
                    $html .= "<td style='border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA TOTAL NO TIENE VALOR
                    $html .= "<td style='border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA TOTAL NO TIENE VALOR
                    $html .= "<td style='word-wrap: break-word!important;max-width:80px!important;border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA OBSERVACIONES NO TIENE VALOR
                    $html .= "</tr>";
        
                    foreach($cOrders as $oOrder){
                        $pedidoResaltado = false;
                        if($oOrder['id_estado_pedido']==2 || $oOrder['id_estado_pedido']==3){
                            $html .= "<tr style='font-size:12px;background-color:#b8b8b8;'>";
                            $pedidoResaltado = true;
                        }else{
                            $html .= "<tr style='font-size:12px;'>";
                        }
                        $html .= "<td height='35' style='border:1px solid #000000;'>".$oOrder['nro_orden']." - ".$oOrder['cliente']."</td>";
                        
                        $html .= "<td height='35' style='border:1px solid #000000;'>".$oOrder['mail']."</td>";
                        
                        $celularFormateado = $this->formatCelular($oOrder['celular']);
                        $html .= "<td style='text-align:right;border:1px solid #000000;'>".$celularFormateado."</td>";
        
                        $html .= "<td style='border:1px solid #000000;'>".$oOrder['cliente_domicilio_full']."</td>";
                        
                        $cantidadBolson = 0;
                        $precioBolson = 0;
        
                        if(!is_null($oOrder['cant_bolson']) && $oOrder['cant_bolson']!=""){
                            $cantidadBolson = $oOrder['cant_bolson'];
                            $precioBolson = $oOrder['total_bolson'];
                        }
        
                        if($precioBolson == 0) {
                            $precioBolson = "-";
                        } else {
                            $precioBolson = "$ ".intval($precioBolson);
                        }
        
                        $html .= "<td style='text-align:center;border:1px solid #000000;'>".$cantidadBolson."</td>";
                        $html .= "<td style='text-align:center;border:1px solid #000000;'>".$precioBolson."</td>";
        
                        $extrasArray = $oOrder['extras'];

                        $contExtra = 0;
                        foreach($cExtras as $oExtra){ //Array de extras activos en la base de datos (con esto identifico la columna)
                            $backgroundColor = "";
                            if(!$pedidoResaltado) {
                                if($contExtra % 2 == 0){
                                    $backgroundColor = "background-color:#dadada";
                                } else {
                                    $backgroundColor = "background-color:#ffffff";
                                }
                            }
                            $html .= "<td style='text-align:center;border:1px solid #000000;".$backgroundColor."'><p style='font-size:10px;'>";
                            $contExtra++;

                            foreach($extrasArray as $ordenExtra){ //Array de extras en la orden (con esto pongo el precio en la columna correcta)
                                if($oExtra->id == $ordenExtra['id_extra']){
                                    $cantExtra = $this->Order->getCantOrderExtraByPedidoAndExtra($oOrder['order_id'],$oExtra->id);
                                    if(!isset($cantExtra)){
                                        $cantExtra = 1;
                                    }else{
                                        $cantExtra = $cantExtra[0]->cant;
                                    }
                                    $precio = ($ordenExtra['extra_price'] * $cantExtra); 
        
                                    $html .= "$ ".$precio;
                                    $html .= "<br />(x".$cantExtra.")";
                                }
                                
                            }
                            $html .= "</td>";
                        }
        
                        $valMontoPagado;
                        $valMontoDebe;
        
                        if($oOrder['monto_pagado'] == 0) {
                            $valMontoPagado = "-";
                        } else {
                            $valMontoPagado = "$".$oOrder['monto_pagado'];
                        }
        
                        if($oOrder['monto_debe'] == 0) {
                            $valMontoDebe = "-";
                        } else {
                            $valMontoDebe = "$".$oOrder['monto_debe'];
                        }
        
                        $html .= "<td style='text-align:center;border:1px solid #000000;'>".$valMontoPagado."</td>";
                        $html .= "<td style='text-align:center;border:1px solid #000000;'><b>".$valMontoDebe."</b></td>";
        
                        $obs = "";
        
                        if($oOrder['id_estado_pedido']==2){
                            $obs .= "ESPECIAL - ";
                        }
                        if($oOrder['id_estado_pedido']==3){
                            $obs .= "BONIFICADO - ";
                        }
                        if($oOrder['observaciones']!=""){
                            $obs .= $oOrder['observaciones'];
                        }
        
                        if($oOrder['id_cupon'] != null && $oOrder['id_cupon']>0) {
                            if($obs==""){
                                $obs = "Cupón de Descuento aplicado.";
                            }else{
                                $obs = $obs." - "."Cupón de Descuento aplicado.";
                            }    
                        }
                            
                        $html .= "<td style='word-wrap:break-word!important;max-width:80px!important;width:80px;text-align:center;border:1px solid #000000;'>".$obs."</td>";
        
                        $html .= "</tr>";
                        $pedidosCounter++;
                    }             
                }
                $html .= "</tbody></table>";
                $oPDF->WriteHTML($html);
            }

            if (count($cLogisticaPdR)>0) {
                $oPDF->SetHTMLHeader("");
                $oPDF->SetMargins(5,5,5,5);
                foreach($cLogisticaPdR as $oLogistica){
                    $oPDF->AddPage();
                    $oPDF->setFooter('{PAGENO}');
                    $html = "";
                    $htmlInitTable = "<table style='border-collapse:collapse;border:1px solid #FF0000;width:100%;font-family:Arial;font-size:10px;'><tbody>";
                    $html .= $htmlInitTable;
                    $cabeceraHTML = "";

                    $cabeceraHTML .= "<tr>";
                    $cabeceraHTML .= "<td width='180' style='text-align:center;border:1px solid #000000;'>".$oCamion->camion."</td>";
                    $cabeceraHTML .= "</tr>";

                    $cabeceraHTML .= "<tr>";
                    $cabeceraHTML .= "<td width='180' style='text-align:center;border:1px solid #000000;'>Cliente</td>";
                    $cabeceraHTML .= "<td width='180' style='text-align:center;border:1px solid #000000;'>Email</td>";
                    $cabeceraHTML .= "<td width='80' style='text-align:center;border:1px solid #000000;'>Celular</td>";
                    $cabeceraHTML .= "<td text-rotate='90' style='width:30px;text-align:center;border:1px solid #000000;'>Bolsón Familiar (8kg)</td>";
                    $cabeceraHTML .= "<td text-rotate='90' style='width:40px;text-align:center;border:1px solid #000000;'>Precio Bolsón Familiar</td>";

                    $contExtra = 0;
                    $pedidoResaltado = false;
            
                    foreach($cExtras as $oExtra){
                        $extraName = "";
                        if(isset($oExtra->nombre_corto) && $oExtra->nombre_corto!=""){
                            $extraName = $oExtra->nombre_corto;
                        } else {
                            $extraName = $oExtra->name;
                        }
                        $backgroundColor = "";
                        if($contExtra % 2 == 0){
                            $backgroundColor = "background-color:#dadada";
                        } else {
                            $backgroundColor = "background-color:#FFFFFF";
                        }
                        $cabeceraHTML .= "<td valign='middle' text-rotate='90' style='width:30px;max-width:30px;min-width:30px;text-align:center;border:1px solid #000000;".$backgroundColor."'>".$extraName."</td>";
                        $contExtra++;
                    }
                    
                    $cabeceraHTML .= "<td text-rotate='90' style='width:40px;text-align:center;border:1px solid #000000;'>Reserva Abonada</td>";
                    $cabeceraHTML .= "<td text-rotate='90' style='width:40px;text-align:center;border:1px solid #000000;'>Total a Cobrar</td>";
                    $cabeceraHTML .= "<td style='width:80px;text-align:center;border:1px solid #000000;'>Observaciones</td>";
                    $cabeceraHTML .= "</tr>";
                    $html .= $cabeceraHTML;
                            
                    $idDiaEntrega = $oLogistica->id_dia_entrega;
                    $idPuntoRetiro = $oLogistica->id_punto_retiro;
                    
                    $oPuntoDeRetiro = $this->Office->getById($idPuntoRetiro);
                    $cOrders = $this->Order->getOrdersPuntosRetiroWithExtrasByIdDiaEntregaAndIdPuntoRetiro($idDiaEntrega,$idPuntoRetiro);
                    $html .= "<tr style='background-color:#000000;'>";
                    $html .= "<td height='50' style='font-size:12px;color:#FFFFFF; text-align:left;border:1px solid #000000;' colspan='3'><b>".$oPuntoDeRetiro->name." - ".$oPuntoDeRetiro->address."</b></td>";
                    $html .= "<td style='font-size:12px;color:#FFFFFF; text-align:center;border:1px solid #000000;' ><b>".$oLogistica->cantidad_modificada."</b></td>"; 
                    $html .= "<td style='border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA PRECIO NO TIENE VALOR
                    
                    foreach($cExtras as $oExtra){
                        $totalExtras = $this->Order->getTotalExtrasByPuntoDeRetiroByIdDiaEntregaByIdExtra(
                            $idPuntoRetiro,
                            $idDiaEntrega,
                            $oExtra->id
                        );
                        $html .= "<td style='font-size:12px;color:#FFFFFF;font-weight:600;text-align:center;border:1px solid #000000;'><b>".$totalExtras."</b></td>";
                    }            
                    $html .= "<td style='border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA TOTAL NO TIENE VALOR
                    $html .= "<td style='border:1px solid #000000;'></td>"; //TD VACIO PORQUE ACA OBSERVACIONES NO TIENE VALOR
                    $html .= "</tr>";
                    
                    foreach($cOrders as $oOrder){
                        $pedidoResaltado = false;
                        if($oOrder['id_estado_pedido']==2 || $oOrder['id_estado_pedido']==3){
                            $html .= "<tr style='font-size:12px;background-color:#b8b8b8;'>";
                            $pedidoResaltado = true;
                        }else{
                            $html .= "<tr style='font-size:12px;'>";
                        }

                        $html .= "<td height='35' style='border:1px solid #000000;'>".$oOrder['nro_orden']." - ".$oOrder['cliente']."</td>";
                        $html .= "<td height='35' style='border:1px solid #000000;'>".$oOrder['mail']."</td>";
                        $celularFormateado = $this->formatCelular($oOrder['celular']);
                        $html .= "<td style='text-align:right;border:1px solid #000000;'>".$celularFormateado."</td>";
                        
                        $cantidadBolson = 0;
                        $precioBolson = 0;

                        if(!is_null($oOrder['cant_bolson']) && $oOrder['cant_bolson']!=""){
                            $cantidadBolson = $oOrder['cant_bolson'];
                            $precioBolson = $oOrder['total_bolson'];
                        }


                        if($precioBolson==0) {
                            $precioBolson = "-";
                        }else{
                            $precioBolson = "$".$precioBolson;
                        }

                        $html .= "<td style='text-align:center;border:1px solid #000000;'>".$cantidadBolson."</td>";
                        $html .= "<td style='text-align:center;border:1px solid #000000;'>".$precioBolson."</td>";


                        $extrasArray = $oOrder['extras'];
                        $contExtra = 0;
                        foreach($cExtras as $oExtra){ //Array de extras activos en la base de datos (con esto identifico la columna)
                            $backgroundColor = "";
                            if(!$pedidoResaltado) {
                                if($contExtra % 2 == 0){
                                    $backgroundColor = "background-color:#dadada";
                                } else {
                                    $backgroundColor = "background-color:#ffffff";
                                }
                            }
                            $html .= "<td style='text-align:center;border:1px solid #000000;".$backgroundColor."'><p style='font-size:10px;'>";
                            $contExtra++;
                            foreach($extrasArray as $ordenExtra){ //Array de extras en la orden (con esto pongo el precio en la columna correcta)
                                if($oExtra->id == $ordenExtra['id_extra']){
                                    $cantExtra = $this->Order->getCantOrderExtraByPedidoAndExtra($oOrder['order_id'],$oExtra->id);
                                    if(!isset($cantExtra)){
                                        $cantExtra = 1;
                                    }else{
                                        $cantExtra = $cantExtra[0]->cant;
                                    }
                                    //print_r($cantExtra);
                                    $precio = ($ordenExtra['extra_price'] * $cantExtra); 

                                    //$html .= "$".$oExtra->price;
                                    $html .= "$ ".$precio;
                                    $html .= "<br />(x".$cantExtra.")";
                                }
                                
                            }
                            $html .= "</td>";
                        }
                        
                        $valMontoPagado;
                        $valMontoDebe;

                        if($oOrder['monto_pagado']==0) {
                            $valMontoPagado = "-";
                        }else{
                            $valMontoPagado = "$".$oOrder['monto_pagado'];
                        }

                        if($oOrder['monto_debe']==0) {
                            $valMontoDebe = "-";
                        }else{
                            $valMontoDebe = "$".$oOrder['monto_debe'];
                        }

                        $html .= "<td style='text-align:center;border:1px solid #000000;'>".$valMontoPagado."</td>";
                        $html .= "<td style='text-align:center;border:1px solid #000000;'><b>".$valMontoDebe."</b></td>";

                        $obs = "";

                        if($oOrder['id_estado_pedido']==2){
                            $obs .= "ESPECIAL - ";
                        }
                        if($oOrder['id_estado_pedido']==3){
                            $obs .= "BONIFICADO - ";
                        }
                        if($oOrder['observaciones']!=""){
                            $obs .= $oOrder['observaciones'];
                        }

                        if($oOrder['id_cupon'] != null && $oOrder['id_cupon']>0) {
                            if($obs==""){
                                $obs = "Cupón de Descuento aplicado.";
                            }else{
                                $obs = $obs." - "."Cupón de Descuento aplicado.";
                            }    
                        }
                            
                        $html .= "<td style='text-align:center;border:1px solid #000000;'>".$obs."</td>";

                        $html .= "</tr>";
                        $pedidosCounter++;
                    } 
                    $html .= "</tbody></table>";

                    $oPDF->WriteHTML($html);
                }
            }       
            $counter++;
        }
        
        $oPDF->Output('CamionesLogistica.pdf', 'F');
        return 1;        
    }

    public function getDiasEntregaActivos() {
        $this->output->set_content_type('application/json');
        if(!valid_session()) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('DiasEntregaPedidos');
        $cDiasEntrega = [];
        $cDiasEntrega = $this->DiasEntregaPedidos->getAllActivos();
        
        $return['status'] = self::OK_VALUE;
        $return['cDiasEntrega'] = $cDiasEntrega;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function aceptaBolsonesStatus() {
        $this->output->set_content_type('application/json');

        $idDiaEntrega = $this->input->post('idDiaEntrega', true);
        $aceptaBolsones = $this->input->post('aceptaBolsones', true);

        if(!valid_session() || !isset($idDiaEntrega) || !isset($aceptaBolsones)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('DiasEntregaPedidos');

        $this->DiasEntregaPedidos->updateAceptaBolsonStatus($idDiaEntrega, $aceptaBolsones);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function updateDiaEntregaAceptaPedidosFrontend() {
        $this->output->set_content_type('application/json');

        $idDiaEntrega = $this->input->post('idDiaEntrega', true);
        $aceptaPedidosFrontend = $this->input->post('aceptaPedidosFrontend', true);

        if(!valid_session() || !isset($idDiaEntrega) || !isset($aceptaPedidosFrontend)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Sesión no válida.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('DiasEntregaPedidos');

        $this->DiasEntregaPedidos->updateAceptaPedidosStatus($idDiaEntrega, $aceptaPedidosFrontend);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function diaEntregaPuntoRetiroStatus() {
        $this->output->set_content_type('application/json');

        $idDiaEntrega = $this->input->post('idDiaEntrega', true);
        $puntoDeRetiroHabilitado = $this->input->post('puntoDeRetiroHabilitado', true);

        if(!valid_session() || !isset($idDiaEntrega) || !isset($puntoDeRetiroHabilitado)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Error en diaEntregaPuntoRetiroStatus.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('DiasEntregaPedidos');

        $this->DiasEntregaPedidos->updatePuntosDeRetiroEnabled($idDiaEntrega, $puntoDeRetiroHabilitado);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }    

    public function diaEntregaDeliveryStatus() {
        $this->output->set_content_type('application/json');

        $idDiaEntrega = $this->input->post('idDiaEntrega', true);
        $deliveryHabilitado = $this->input->post('deliveryHabilitado', true);

        if(!valid_session() || !isset($idDiaEntrega) || !isset($deliveryHabilitado)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Error en diaEntregaDeliveryStatus.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('DiasEntregaPedidos');

        $this->DiasEntregaPedidos->updateDeliveryEnabled($idDiaEntrega, $deliveryHabilitado);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }    

    public function diaEntregaUpdateStatus() {
        $this->output->set_content_type('application/json');

        $idDiaEntrega = $this->input->post('idDiaEntrega', true);

        if(!valid_session() || !isset($idDiaEntrega)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Error en diaEntregaUpdateStatus.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }

        $this->load->model('DiasEntregaPedidos');
        $oDiaEntrega = $this->DiasEntregaPedidos->getById($idDiaEntrega);
        $hasAtLeastOneTipoPedidoEnabled = false;
        if(!is_null($oDiaEntrega)) {
            if($oDiaEntrega->puntoDeRetiroEnabled == 1 || $oDiaEntrega->deliveryEnabled == 1 ) {
                $hasAtLeastOneTipoPedidoEnabled = true;
            }
        }        
        $status = 0;
        if($hasAtLeastOneTipoPedidoEnabled) {
            $status = 1;
        }
        $this->DiasEntregaPedidos->updateAceptaPedidosStatus($idDiaEntrega, $status);

        $return['status'] = self::OK_VALUE;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    function getConfigDiaEntrega() {
        $this->output->set_content_type('application/json');
        
        $idDiaEntrega = $this->input->post('idDiaEntrega', true);

        if(!valid_session() || !isset($idDiaEntrega)) {
            $return['status'] = self::FAIL_VALUE;
            $return['message'] = 'Error en diaEntregaUpdateStatus.';
            $this->output->set_status_header(401);
            return $this->output->set_output(json_encode($return));
        }
    
        $this->load->model('DiasEntregaPedidos');
        $oDiaEntrega = $this->DiasEntregaPedidos->getById($idDiaEntrega);
        $puntoRetiroEnabled = $oDiaEntrega->puntoDeRetiroEnabled;
        $deliveryEnabled = $oDiaEntrega->deliveryEnabled;
        $bolsonEnabled = $oDiaEntrega->aceptaBolsones;
        $return['status'] = self::OK_VALUE;
        $return['puntoRetiroEnabled'] = $puntoRetiroEnabled;
        $return['deliveryEnabled'] = $deliveryEnabled;
        $return['bolsonEnabled'] = $bolsonEnabled;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function getOrdersFromDateToDate($fechaDesde,$fechaHasta,$idDiaEntrega) {
        $this->output->set_content_type('application/json');

        $this->load->model('Order');
        
        $cOrders = $this->Order->getOrdersBetweenDatesAndDiaEntrega($fechaDesde,$fechaHasta,$idDiaEntrega);
        
        /*if($idDiaEntrega>0){
            $cOrders = $this->Order->getOrdersInDiaEntrega($idDiaEntrega);
        }else{
            $cOrders = $this->Order->getOrdersBetweenDates(
                $fechaDesde,
                $fechaHasta
            );    
        }*/

        $this->createXlsClientsPhoneAndMail($cOrders);
        $fileName = "ClientesOrdenes.xls";
        $return['status'] = self::OK_VALUE;
        $return['fileName'] = $fileName;
        return $this->output->set_output(json_encode($return));        
    }

    private function createXlsClientsPhoneAndMail($cOrders){
        $xlsCreado = false;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Clientes");
        $lastColumn = 'A';
        $xlsCol = 'A';
        $xlsRow = 1;

        //Array de estilos para las celdas. Lo aplico por fila.
        $headerStyleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            ),
            'font'  => array(
                'size'  => 14
            ),
            'fill' => array(
                'fillType' => Fill::FILL_SOLID,
                'startColor' => array('argb' => 'FFB8B8B8')
            )
        );

        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            ),
            'font'  => array(
                'size'  => 12
            )
        );        
        /*
        $sheet->setTitle('PUNTOS DE RETIRO');
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.1);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.1);

        $sheet->setCellValue($xlsCol.$xlsRow, 'Cliente');
        $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

        $xlsCol++;

        $sheet->setCellValue($xlsCol.$xlsRow, 'Teléfono');
        $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

        $xlsCol++;
        
        $sheet->setCellValue($xlsCol.$xlsRow, 'Mail');
        $sheet->getColumnDimension($xlsCol)->setAutoSize(true);
        
        $xlsCol++;
        
        $sheet->setCellValue($xlsCol.$xlsRow, 'Fecha Pedido');
        $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

        $xlsCol++;
        
        $sheet->setCellValue($xlsCol.$xlsRow, 'Dia de Entrega');
        $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

        $xlsCol++;
        
        $sheet->setCellValue($xlsCol.$xlsRow, 'Monto Total');
        $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

        $lastColumn = $xlsCol;
        
        $sheet->getRowDimension($xlsRow)->setRowHeight(35);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($headerStyleArray);

        $xlsRow++;

        $xlsCol = 'A';
        foreach($cOrders as $oOrder){
            if($oOrder->id_tipo_pedido==1) {
                $sheet->setCellValue($xlsCol.$xlsRow, $oOrder->client_name);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

                $xlsCol++;

                $sheet->setCellValue($xlsCol.$xlsRow, $oOrder->phone);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

                $xlsCol++;

                $sheet->setCellValue($xlsCol.$xlsRow, $oOrder->email);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

                $xlsCol++;

                $sheet->setCellValue($xlsCol.$xlsRow, $oOrder->fechaPedido);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

                $xlsCol++;

                $sheet->setCellValue($xlsCol.$xlsRow, $oOrder->diaEntrega);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

                $xlsCol++;

                $sheet->setCellValue($xlsCol.$xlsRow, $oOrder->montoTotal);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

                $sheet->getRowDimension($xlsRow)->setRowHeight(20);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($styleArray);
                $xlsRow++;
                $xlsCol = 'A';
            }
        }

        $lastColumn = 'A';
        $xlsCol = 'A';
        $xlsRow = 1;
        
        $sheet = $spreadsheet->createSheet();
        */
        $sheet->setTitle('DOMICILIO');

        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.1);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.1);

        $sheet->setCellValue($xlsCol.$xlsRow, 'Cliente');
        $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

        $xlsCol++;

        $sheet->setCellValue($xlsCol.$xlsRow, 'Teléfono');
        $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

        $xlsCol++;
        
        $sheet->setCellValue($xlsCol.$xlsRow, 'Mail');
        $sheet->getColumnDimension($xlsCol)->setAutoSize(true);
        
        $xlsCol++;
        
        $sheet->setCellValue($xlsCol.$xlsRow, 'Fecha Pedido');
        $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

        $xlsCol++;
        
        $sheet->setCellValue($xlsCol.$xlsRow, 'Dia de Entrega');
        $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

        $xlsCol++;
        
        $sheet->setCellValue($xlsCol.$xlsRow, 'Monto Total');
        $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

        $lastColumn = $xlsCol;
        
        $sheet->getRowDimension($xlsRow)->setRowHeight(35);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($headerStyleArray);

        $xlsRow++;

        $xlsCol = 'A';
        $firstRow = 2;
        $xlsColMontoTotal = 'F';
        
        foreach($cOrders as $oOrder){
            if($oOrder->id_tipo_pedido==2) {
                $sheet->setCellValue($xlsCol.$xlsRow, $oOrder->client_name);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

                $xlsCol++;

                $sheet->setCellValue($xlsCol.$xlsRow, $oOrder->phone);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

                $xlsCol++;

                $sheet->setCellValue($xlsCol.$xlsRow, $oOrder->email);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

                $xlsCol++;

                $sheet->setCellValue($xlsCol.$xlsRow, $oOrder->fechaPedido);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

                $xlsCol++;

                $sheet->setCellValue($xlsCol.$xlsRow, $oOrder->diaEntrega);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

                $xlsCol++;

                $sheet->setCellValue($xlsCol.$xlsRow, $oOrder->montoTotal);
                $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
    
                $sheet->getColumnDimension($xlsCol)->setAutoSize(true);

                $sheet->getRowDimension($xlsRow)->setRowHeight(20);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($styleArray);
                $xlsRow++;
                $xlsCol = 'A';
            }
        }
        $lastRow = $xlsRow-1;
        $xlsRow++;
        $rango = $xlsColMontoTotal.$firstRow.":".$xlsColMontoTotal.($xlsRow-1);
        
        $sumMontoTotal = '=SUM('.$rango.')';
        $xlsCol++;
        $xlsCol++;
        $xlsCol++;
        $xlsCol++;
        $xlsCol++;

        $sheet->setCellValue($xlsCol.$xlsRow, $sumMontoTotal);
        $sheet->getStyle($xlsCol.$xlsRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle($xlsCol.$xlsRow)->getNumberFormat()->setFormatCode('"$"#');
        $sheet->getStyle($xlsCol.$xlsRow)->getFont()->setBold(true);

        $sheet->getRowDimension($xlsRow)->setRowHeight(20);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A'.$xlsRow.':'.$lastColumn.$xlsRow)->applyFromArray($styleArray);

        $fileName = "ClientesOrdenes.xls";
        $writer = new Xlsx($spreadsheet);        
        $writer->save($fileName);    
        $xlsCreado = true;
        return $xlsCreado;
    }    
}