¡Pedido confirmado!

¡Hola <?=$nombre;?>!.
Queríamos avisarte que tu compra se realizó con éxito.
Ya estamos preparando tu pedido! Y será enviado a tu domicilio hoy mismo!

Valor del Pedido: $<?=$totalPrice?>

Pedido:
<?php if (isset($bolson)){?>
    <?=$cantBolson;?> x <?=$bolson->name;?>: $<?=$totalBolson;?>
<?php } ?>
<?php if(isset($extras)): ?>
    <?php foreach($extras as $extra): ?>
        <?=$extra->cant;?> x <?=$extra->name;?>: $<?=$extra->total;?>
    <?php endforeach; ?>
<?php endif; ?>
<?php if($hayDescuento): ?>
    Cupón de Descuento aplicado: -$<?=$montoDescuento;?><br>
<?php endif; ?>

Dirección de Entrega: <?=$direccion;?>

Por cualquier consulta o comentario, estamos a disposición por este medio, en nuestras redes sociales o por whatsapp al 11-3181-6011
¡Muchas gracias por tu compra!
El equipo de El Brote Tienda Natural.