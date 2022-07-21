¡Pedido confirmado!

¡Hola <?=$nombre;?>! Muchas gracias por tu compra.

Tu pedido ya está confirmado y será enviado a domicilio para el día de entrega seleccionado.
Recordá que tu compra se abona solo en efectivo, al momento de la entrega.

Reserva abonada: $<?=$montoPagado?>
Total a abonar en efectivo: $<?=$totalPrice?>

<?php if(isset($bolson)){?>
    Tu bolsón: <?=$bolson->name;?> ($<?=$bolson->price;?>)
<?php } ?>
<?php if(isset($extras)): ?>
    <?php foreach($extras as $extra): ?>
        Productos extras:
        <?=$extra->cant;?> x <?=$extra->name;?>: $<?=($extra->cant*$extra->price);?>
    <?php endforeach; ?>
<?php endif; ?>
<?php if($hayDescuento): ?>
    Cupón de Descuento aplicado: -$<?=$montoDescuento;?><br>
<?php endif; ?>

Te recordamos la dirección a la que entregaremos: <?=$entrega;?>.

Te esperamos,
El equipo del Brote Orgánico.
