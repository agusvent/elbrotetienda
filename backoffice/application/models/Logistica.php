<?php

class Logistica extends CI_Model
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function getById($idLogistica) 
    {
        $this->db->select('id_logistica, id_dia_entrega, id_punto_retiro, id_barrio, cantidad_original, cantidad_modificada, cantidad_especiales, id_logistica_camion, cantidad_bolsones_individuales_original, cantidad_bolsones_individuales_modificado, cantidad_bolsones_individuales_especiales, total_pedidos, total_pedidos_tienda');
        $this->db->from('logistica');
        $this->db->where('id_logistica', $idLogistica);

        $result = $this->db->get();
        return $result->result()[0];
    }

    public function getByIds($idsLogistica) 
    {
        $this->db->select('id_logistica, id_dia_entrega, id_punto_retiro, id_barrio, cantidad_original, cantidad_modificada, cantidad_especiales, id_logistica_camion, cantidad_bolsones_individuales_original, cantidad_bolsones_individuales_modificado, cantidad_bolsones_individuales_especiales, total_pedidos, total_pedidos_tienda');
        $this->db->from('logistica');
        $where = "id_logistica in (".$idsLogistica.")";
        $this->db->where($where);
        $this->db->order_by('id_logistica', 'ASC');
        $result = $this->db->get();
        return $result->result();
    }

    public function getByDiaEntrega($idDiaEntrega) 
    {
        $this->db->select('id_logistica, id_dia_entrega, id_punto_retiro, id_barrio, cantidad_original, cantidad_modificada, cantidad_especiales, id_logistica_camion, cantidad_bolsones_individuales_original, cantidad_bolsones_individuales_modificado, cantidad_bolsones_individuales_especiales, total_pedidos, total_pedidos_tienda');
        $this->db->from('logistica');
        $this->db->where('id_dia_entrega', $idDiaEntrega);

        $result = $this->db->get();
        return $result->result();
    }

    public function add($idDiaEntrega, $idPuntoRetiro, $idBarrio, $cantidad,$cantidadEspeciales, $cantidadBolsonesIndividuales, $cantidadBolsonesIndividualesEspeciales, $totalPedidosTienda, $totalPedidos)
    {
        $this->db->set('id_dia_entrega', $idDiaEntrega);
        if(isset($idPuntoRetiro) && $idPuntoRetiro > 0){
            $this->db->set('id_punto_retiro', $idPuntoRetiro);
        }
        if(isset($idBarrio) && $idBarrio > 0){
            $this->db->set('id_barrio', $idBarrio);
        }
        $this->db->set('cantidad_original', $cantidad);
        //COMO ESTAMOS CREANDO EL REGISTRO DE LOGISTICA, LA CANTIDAD MODIFICADA = CANTIDAD ORIGINAL
        $this->db->set('cantidad_modificada', $cantidad);

        if(isset($cantidadEspeciales)){
            $this->db->set('cantidad_especiales', $cantidadEspeciales);
        }
        if(isset($cantidadBolsonesIndividuales)){
            $this->db->set('cantidad_bolsones_individuales_original',$cantidadBolsonesIndividuales);
            $this->db->set('cantidad_bolsones_individuales_modificado',$cantidadBolsonesIndividuales);
        }
        if(isset($cantidadBolsonesIndividualesEspeciales)) {
            $this->db->set('cantidad_bolsones_individuales_especiales',$cantidadBolsonesIndividualesEspeciales);
        }

        if(isset($totalPedidos)){
            $this->db->set('total_pedidos', $totalPedidos);
        }

        if(isset($totalPedidosTienda)){
            $this->db->set('total_pedidos_tienda', $totalPedidosTienda);
        }

        $this->db->insert('logistica');
        
        return $this->db->insert_id();
    }

    public function getLogisticaPuntosRetiroByDiaEntrega($idDiaEntrega) 
    {
        $this->db->select('l.id_logistica, l.id_dia_entrega, l.id_punto_retiro, pretiro.name as puntoRetiroNombre, l.cantidad_original, l.cantidad_modificada, l.cantidad_especiales, l.id_logistica_camion, ldec.camion as nombreCamion, l.cantidad_bolsones_individuales_original, l.cantidad_bolsones_individuales_modificado, l.cantidad_bolsones_individuales_especiales, l.total_pedidos, l.total_pedidos_tienda');
        $this->db->from('logistica as l');
        $this->db->join('offices as pretiro', 'pretiro.id = l.id_punto_retiro', 'left');
        $this->db->join('logistica_dias_entrega_camiones as ldec', 'ldec.id = l.id_logistica_camion', 'left');
        $where = "l.id_dia_entrega = '$idDiaEntrega' AND l.id_punto_retiro is not null AND l.id_barrio is null";
        $this->db->where($where);
        $this->db->order_by('pretiro.name', 'ASC');
        $result = $this->db->get();
        return $result->result();
    }

    public function getLogisticaBarriosByDiaEntrega($idDiaEntrega) 
    {
        $this->db->select('l.id_logistica, l.id_dia_entrega, l.id_barrio, b.nombre as barrioNombre, l.cantidad_original, l.cantidad_modificada, l.cantidad_especiales, l.id_logistica_camion, ldec.camion as nombreCamion, l.cantidad_bolsones_individuales_original, l.cantidad_bolsones_individuales_modificado, l.cantidad_bolsones_individuales_especiales, l.total_pedidos, l.total_pedidos_tienda');
        $this->db->from('logistica as l');
        $this->db->join('barrios as b', 'b.id = l.id_barrio', 'left');
        $this->db->join('logistica_dias_entrega_camiones as ldec', 'ldec.id = l.id_logistica_camion', 'left');
        $where = "l.id_dia_entrega = '$idDiaEntrega' AND l.id_barrio is not null AND l.id_punto_retiro is null";
        $this->db->where($where);
        $this->db->order_by('b.nombre', 'ASC');
        $result = $this->db->get();
        return $result->result();
    }

    public function deleteRegistrosLogisticaByIdDiaEntrega($idDiaEntrega){
        $this->db->where('id_dia_entrega', $idDiaEntrega);
        $this->db->delete('logistica');

        return true;        
    }

    public function updateCantidadModificada($idLogistica, $cantModificadaBolsonFamiliar,$cantModificadaBolsonIndividual)
    {
        $this->db->set('cantidad_modificada', $cantModificadaBolsonFamiliar);
        $this->db->set('cantidad_bolsones_individuales_modificado', $cantModificadaBolsonIndividual);
        $this->db->where('id_logistica', $idLogistica);
        $this->db->update('logistica');

        return true;
    }

    public function setLogisticaCamion($idLogistica, $idLogisticaCamion)
    {
        $this->db->set('id_logistica_camion', $idLogisticaCamion);
        $this->db->where('id_logistica', $idLogistica);
        $this->db->update('logistica');

        return true;
    }

    public function removeLogisticaCamion($idLogistica)
    {
        $this->db->set('id_logistica_camion', null);
        $this->db->where('id_logistica', $idLogistica);
        $this->db->update('logistica');

        return true;
    }

    public function getLogisticaByDiaEntregaAndPuntoRetiro($idDiaEntrega, $idPuntoRetiro) 
    {
        $this->db->select('id_logistica, id_dia_entrega, id_punto_retiro, id_barrio, cantidad_original, cantidad_modificada, cantidad_especiales, id_logistica_camion, cantidad_bolsones_individuales_original, cantidad_bolsones_individuales_modificado, cantidad_bolsones_individuales_especiales, total_pedidos, total_pedidos_tienda');
        $this->db->from('logistica');
        $where = "id_dia_entrega = '$idDiaEntrega' AND id_punto_retiro = '$idPuntoRetiro' AND id_barrio is null";
        $this->db->where($where);
        $result = $this->db->get();
        return $result->result()[0];
    }

    public function getLogisticaByDiaEntregaAndBarrio($idDiaEntrega, $idBarrio) 
    {
        $this->db->select('id_logistica, id_dia_entrega, id_punto_retiro, id_barrio, cantidad_original, cantidad_modificada, cantidad_especiales, id_logistica_camion, cantidad_bolsones_individuales_original, cantidad_bolsones_individuales_modificado, cantidad_bolsones_individuales_especiales, total_pedidos, total_pedidos_tienda');
        $this->db->from('logistica');
        $where = "id_dia_entrega = '$idDiaEntrega' AND id_barrio = '$idBarrio' AND id_punto_retiro is null";
        $this->db->where($where);
        $result = $this->db->get();
        return $result->result()[0];
    }

    public function getLogisticaByDiaEntregaAndCamion($idDiaEntrega,$idLogisticaCamion) 
    {
        $this->db->select('id_logistica, id_dia_entrega, id_punto_retiro, id_barrio, cantidad_original, cantidad_modificada, cantidad_especiales, id_logistica_camion, cantidad_bolsones_individuales_original, cantidad_bolsones_individuales_modificado, cantidad_bolsones_individuales_especiales, total_pedidos, total_pedidos_tienda');
        $this->db->from('logistica');
        $this->db->where('id_dia_entrega', $idDiaEntrega);
        $this->db->where('id_logistica_camion', $idLogisticaCamion);

        $result = $this->db->get();
        return $result->result();
    }

    public function getLogisticaPuntosDeRetiroByCamion($idCamion) 
    {
        $this->db->select('l.id_logistica, l.id_dia_entrega, l.id_punto_retiro, pretiro.name as puntoRetiro, l.cantidad_original, l.cantidad_modificada, l.cantidad_especiales, l.id_logistica_camion, l.cantidad_bolsones_individuales_original, l.cantidad_bolsones_individuales_modificado, l.cantidad_bolsones_individuales_especiales, l.total_pedidos, l.total_pedidos_tienda');
        $this->db->from('logistica as l');
        $this->db->join('offices as pretiro', 'pretiro.id = l.id_punto_retiro', 'left');
        $where = "l.id_logistica_camion = '$idCamion' AND l.id_punto_retiro is not null AND l.id_barrio is null";
        $this->db->where($where);
        $result = $this->db->get();
        return $result->result();
    }    

    public function getLogisticaBarriosByCamion($idCamion){
        $this->db->select('l.id_logistica, l.id_dia_entrega, l.id_barrio, b.nombre as barrio, l.cantidad_original, l.cantidad_modificada, l.cantidad_especiales, l.id_logistica_camion, l.cantidad_bolsones_individuales_original, l.cantidad_bolsones_individuales_modificado, l.cantidad_bolsones_individuales_especiales, l.total_pedidos, l.total_pedidos_tienda');
        $this->db->from('logistica as l');
        $this->db->join('barrios as b', 'b.id = l.id_barrio', 'left');
        $where = "l.id_logistica_camion = '$idCamion' AND l.id_barrio is not null AND l.id_punto_retiro is null";
        $this->db->where($where);
        $result = $this->db->get();
        return $result->result();
    }

    public function getTotalBolsonesByCamionBarrios($idCamion){
        $this->db->select('l.id_logistica,l.cantidad_modificada');
        $this->db->from('logistica as l');
        $where = "l.id_logistica_camion = '$idCamion' AND l.id_barrio is not null AND l.id_punto_retiro is null";
        $this->db->where($where);
        $result = $this->db->get();
        $cLogistica = $result->result();
        $total = $this->sumTotalesBolsonesByCamion($cLogistica);
        return $total;
    }

    public function sumTotalesBolsonesByCamion($cLogistica){
        $total = 0;
        foreach($cLogistica as $oLogistica){
            if(!is_null($oLogistica->cantidad_modificada) && $oLogistica->cantidad_modificada>0){
                $total = $total + $oLogistica->cantidad_modificada;
            }
        }
        return $total;
    }

    public function getLogisticaByCamion($idCamion) 
    {
        $this->db->select('l.id_logistica, l.id_dia_entrega, l.id_punto_retiro, l.cantidad_original, l.cantidad_modificada, l.cantidad_especiales, l.id_logistica_camion, l.total_pedidos, l.total_pedidos_tienda');
        $this->db->from('logistica as l');
        $this->db->where('l.id_logistica_camion', $idCamion);
        $result = $this->db->get();
        return $result->result();
    }    

    public function getLogisticaPuntosRetiroByDiaEntregaOrderedByCantidadModificada($idDiaEntrega) 
    {
        $this->db->select('l.id_logistica, l.id_dia_entrega, l.id_punto_retiro, pretiro.name as puntoRetiroNombre, l.cantidad_original, l.cantidad_modificada, l.cantidad_especiales, l.id_logistica_camion, ldec.camion as nombreCamion, l.cantidad_bolsones_individuales_original, l.cantidad_bolsones_individuales_modificado,l.cantidad_bolsones_individuales_especiales, l.total_pedidos, l.total_pedidos_tienda');
        $this->db->from('logistica as l');
        $this->db->join('offices as pretiro', 'pretiro.id = l.id_punto_retiro', 'left');
        $this->db->join('logistica_dias_entrega_camiones as ldec', 'ldec.id = l.id_logistica_camion', 'left');
        $where = "l.id_dia_entrega = '$idDiaEntrega' AND l.id_punto_retiro is not null AND l.id_barrio is null";
        $this->db->where($where);
        $this->db->order_by('l.cantidad_modificada', 'DESC');
        $this->db->order_by('puntoRetiroNombre', 'ASC');
        $result = $this->db->get();
        return $result->result();
    }

    public function getLogisticaBarriosByDiaEntregaOrderedByCantidadModificada($idDiaEntrega) 
    {
        $this->db->select('l.id_logistica, l.id_dia_entrega, l.id_barrio, b.nombre as barrioNombre, l.cantidad_original, l.cantidad_modificada, l.cantidad_especiales, l.id_logistica_camion, ldec.camion as nombreCamion, l.cantidad_bolsones_individuales_original, l.cantidad_bolsones_individuales_modificado,l.cantidad_bolsones_individuales_especiales, l.total_pedidos, l.total_pedidos_tienda');
        $this->db->from('logistica as l');
        $this->db->join('barrios as b', 'b.id = l.id_barrio', 'left');
        $this->db->join('logistica_dias_entrega_camiones as ldec', 'ldec.id = l.id_logistica_camion', 'left');
        $where = "l.id_dia_entrega = '$idDiaEntrega' AND l.id_barrio is not null AND l.id_punto_retiro is null";
        $this->db->where($where);
        $this->db->order_by('l.cantidad_modificada', 'DESC');
        $this->db->order_by('barrioNombre', 'ASC');
        $result = $this->db->get();
        return $result->result();
    }    

    public function getAllPuntosRetiroByIdCamion($idCamion) 
    {
        $this->db->select('id_logistica, id_dia_entrega, id_punto_retiro, id_barrio, cantidad_original, cantidad_modificada, cantidad_especiales, id_logistica_camion, cantidad_bolsones_individuales_original, cantidad_bolsones_individuales_modificado, cantidad_bolsones_individuales_especiales, total_pedidos, total_pedidos_tienda');
        $this->db->from('logistica');
        $where = "id_punto_retiro > 0 and id_barrio is null and id_logistica_camion in (".$idCamion.")";
        $this->db->where($where);
        $this->db->order_by('id_logistica', 'ASC');
        $result = $this->db->get();
        return $result->result();
    }

    public function getAllBarriosByIdCamion($idCamion) 
    {
        $this->db->select('id_logistica, id_dia_entrega, id_punto_retiro, id_barrio, cantidad_original, cantidad_modificada, cantidad_especiales, id_logistica_camion, cantidad_bolsones_individuales_original, cantidad_bolsones_individuales_modificado, cantidad_bolsones_individuales_especiales, total_pedidos, total_pedidos_tienda');
        $this->db->from('logistica');
        $where = "id_punto_retiro is null and id_barrio > 0 and id_logistica_camion in (".$idCamion.")";
        $this->db->where($where);
        $this->db->order_by('id_logistica', 'ASC');
        $result = $this->db->get();
        return $result->result();
    }

}