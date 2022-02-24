<?php

function getParsed($input) {
    $output = [];
    $output['fecha'] = ((isset($input[0])) ? $input[0] : 'n/d');
    $output['nombre'] = ((isset($input[1])) ? $input[1] : 'n/d');
    $output['email'] = ((isset($input[2])) ? $input[2] : 'n/d');
    $output['telefono'] = ((isset($input[3])) ? $input[3] : 'n/d');
    $output['bolson'] = ((isset($input[4])) ? parseCantidadBolsones($input[4]) : 'n/d');
    $output['miel'] = ((isset($input[5])) ? parseMiel($input[5]) : 'n/d');
    $output['sucursal'] = ((isset($input[6])) ? parseSucursal($input[6]) : 'n/d');
    $output['confirmacion'] = ((isset($input[7])) ? $input[7] : 'n/d');
    return $output;
}

function parseCantidadBolsones($input) {
    $partes = explode(' > ', $input);
    return [
        'tipo' => $partes[0],
        'precio' => $partes[1]
    ];
}

function parseMiel($input) {
    if($input == "" || empty($input)) {
        return "No incluída.";
    }else{
        return $input;
    }
}

function parseSucursal($input) {
    $partes = explode(' > ', $input);
    if(isset($partes[1])) {
        $partes_suc = explode(' - ', $partes[1]);
    }
    if(isset($partes_suc)) {
        return [
            'nombre_sucursal' => $partes[0],
            'direccion' => $partes_suc[0],
            'horario' => $partes_suc[1],
            'nombre' => $partes_suc[2]
        ];
    }
    return [
        'nombre_sucursal' => $partes[0],
        'info' => $partes[1]
    ];
}

function priceToDouble($price) {
    return (double) str_replace('$','',$price);
}