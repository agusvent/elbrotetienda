<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?=$title ?? "";?></title>
    <link rel="stylesheet" href="<?=assets();?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=assets();?>dt/datatables.min.css">
    <link rel="stylesheet" href="<?=assets();?>css/backoffice.css?v=5123">
    <script type="text/javascript" src="<?=assets();?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body>
<div class="topbar"><img src="<?=assets();?>img/logo.png" class="topbar-logo"></div>
<div class="container-fluid">
<div class="container content-wrapper">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="<?=base_url();?>overview">Home</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Contenidos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="<?=base_url();?>contenidos/formulario">Texto del formulario</a>
            <a class="dropdown-item" href="<?=base_url();?>contenidos/sucursales">Puntos de Retiro</a>
            <a class="dropdown-item" href="<?=base_url();?>contenidos/barrios">Barrios</a>
            <a class="dropdown-item" href="<?=base_url();?>contenidos/newsletter">Newsletter</a>
            <a class="dropdown-item" href="<?=base_url();?>contenidos/cupones">Cupones</a>
            <a class="dropdown-item" href="<?=base_url();?>contenidos/diasEntrega">Días de Entrega</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Productos y precios
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?=base_url();?>productos/bolsones">Bolsones</a>
          <a class="dropdown-item" href="<?=base_url();?>productos/extras">Productos Extras</a>
          <a class="dropdown-item" href="<?=base_url();?>ordenes/preciosPedidosExtras">Config. de Pedidos</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Pedidos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <!--<a class="dropdown-item" href="<?=base_url();?>ordenes/sucursal">Pedidos a sucursal</a>-->
          <!--<a class="dropdown-item" href="<?=base_url();?>ordenes/delivery">Pedidos a domicilio</a>-->
          <a class="dropdown-item" href="<?=base_url();?>ordenes/altaPedidos">Alta de Pedidos</a>
          <a class="dropdown-item" href="<?=base_url();?>ordenes/listadoPedidos">Listado de Pedidos</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Log&iacute;stica
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?=base_url();?>logistica/camiones-preconfigurados">Camiones PreConfigurados</a>
          <a class="dropdown-item" href="<?=base_url();?>logistica/logistica">Armado Log&iacute;stica</a>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="<?=base_url();?>logout">Cerrar sesión</a>
      </li>
    </ul>
  </div>
</nav>
<?php if($formEnabled == 0 || $deliveryEnabled == 0): ?>
<div class="alert alert-warning"><strong>¡Importante!</strong> El sistema está en modo "no aceptar pedidos" para uno o todos los métodos posibles (sucursal/domicilio).</div>
<?php endif; ?>
