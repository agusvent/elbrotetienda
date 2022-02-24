¡Pedido confirmado!

¡Hola <?=$nombre;?>! Muchas gracias por tu compra. 

Tu pedido ya está confirmado y te va a estar esperando en el Punto de Retiro el día de entrega, que se indica a continuación.
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

Te recordamos la dirección y el horario de entrega: <?=$sucursal;?>.

Día de retiro: <?=$retiro;?>.

PD: Si ya hiciste un pedido previo de bolsón, te pedimos que lleves la bolsa vacía para que podamos reciclarlas y ayudar con el medio ambiente!

Te esperamos,
El equipo de El Brote Tienda Natural.
* Cuestiones climáticas o inconvenientes vinculados con las cosechas pueden dificultar la disponibilidad de algunos cultivos publicados. En esos casos, nos veremos obligados a reemplazar dichos productos por otros que estén disponibles (según cantidad y calidad). Muchas gracias por comprender!
