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
            <p>¡Hola <strong><?=$nombre;?></strong>!</p>
            <p>Queríamos avisarte que tu compra se realizó con éxito.
            </p>
            <p>Ya estamos preparando tu pedido! Y será enviado a tu domicilio hoy mismo!</p>
            <p>
                Valor del Pedido: $<?=$totalPrice?>
            </p>
            <p>
                <strong>Pedido: </strong><br>
                <?php if (isset($bolson)){?>
                    <strong><?=$cantBolson;?> x <?=$bolson->name;?>: $<?=$totalBolson;?></strong><br>
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
                <strong>Dirección de Entrega: <?=$direccion;?><br /></strong>
            </p>
            <p>
                <strong>Por cualquier consulta o comentario, estamos a disposición por este medio, en nuestras redes sociales o por whatsapp al 11-3181-6011<br /></strong>
            </p>
            <p>¡Muchas gracias por tu compra!</p>
            <p>El equipo de El Brote Tienda Natural. </p>
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
