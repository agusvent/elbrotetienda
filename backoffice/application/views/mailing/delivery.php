<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: Arial, Helvetica, sans-serif;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Pedido confirmado en El Brote Tienda Natural.</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif;">
<table align="center" width="650" style="border: 1px solid #000000;padding: 0;">
    <tbody>
    <tr style="padding: 0;"><td style="padding: 0;">
            <img src="https://elbrotetienda.com/mailing/EBT_mail_confirm_banner.jpg" alt="El Brote Tienda Natural">
        </td></tr>
    <tr style="padding: 0;"><td style="padding:20px;">
            <h2 align="center">¡Pedido confirmado!</h2>
            <p>¡Hola <strong><?=$nombre;?></strong>! Muchas gracias por tu compra. </p>
            <p>Tu pedido ya está confirmado y será enviado a domicilio para el día de entrega seleccionado.
            </p>
            <p>Recordá que tu compra se abona solo en efectivo, al momento de la entrega.</p>
            <p>
                Reserva abonada: $<?=$montoPagado?>
            </p>
            <p>
                <b>Total a abonar en efectivo: $<?=$totalPrice?></b>
            </p>
            <p>
                <strong>Pedido: </strong><br>
                <?php if (isset($bolson)){?>
                    <strong><?=$cantBolson;?> x <?=$bolson->name;?> ($<?=$totalBolson;?>)</strong><br>
                <?php } ?>
                <?php if(isset($extras)): ?>
                    <?php foreach($extras as $extra): ?>
                        <strong><?=$extra->cant;?> x <?=$extra->name;?>:</strong> $<?=$extra->total;?><br>
                    <?php endforeach; ?>
                <?php endif; ?>
            </p>
            <?php if($hayDescuento): ?>
                <p>
                    <strong>Cupón de Descuento aplicado</strong>: -$<?=$montoDescuento;?><br>
                </p>
            <?php endif; ?>
            <p>
                <strong>Dirección: <?=$direccion;?><br /></strong>
            </p>
            <p>
                <strong>Franja Horaria: <?=$horarioEntrega;?><br /></strong>
            </p>
            <p>PD: Si ya hiciste un pedido previo de bolsón, te pedimos que lleves la bolsa vacía para que podamos reciclarlas y ayudar con el medio ambiente!</p>
            <p>Te esperamos,
                <br>
                El equipo de El Brote Tienda Natural. </p>
            <p>&nbsp;</p>
            <p style="margin-top:20px;font-size:9px;">
                * Cuestiones climáticas o inconvenientes vinculados con las cosechas pueden dificultar la disponibilidad de algunos cultivos publicados. En esos casos, nos veremos obligados a reemplazar dichos productos por otros que estén disponibles (según cantidad y calidad). Muchas gracias por comprender!
            </p>
        </td></tr>
    <tr style="border-top: 1px solid #000;padding: 0;"><td style="padding: 0;">
            <img src="https://elbrotetienda.com/mailing/EBT_mail_confirm_footer.jpg" alt="https://www.elbrotetienda.com/">
        </td></tr>
    </tbody>
</table>
</body>
</html>
