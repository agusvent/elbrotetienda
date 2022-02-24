¡Pedido confirmado!

¡Hola <?=$nombre;?>! Muchas gracias por tu compra.

Tu pedido ya está confirmado y será enviado a tu domicilio este Miércoles. 
Recordá que tu compra se abona solo en efectivo, al momento de la entrega.

Reserva abonada: $<?=$montoPagado?>
Total a abonar en efectivo: $<?=$totalPrice?>

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

Te recordamos la dirección a la que entregaremos: <?=$direccion;?>.

Te esperamos,
El equipo del Brote Orgánico.
* Cuestiones climáticas o inconvenientes vinculados con las cosechas pueden dificultar la disponibilidad de algunos cultivos publicados. En esos casos, nos veremos obligados a reemplazar dichos productos por otros que estén disponibles (según cantidad y calidad). Muchas gracias por comprender!
