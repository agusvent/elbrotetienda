<div class="card">
    <div class="card-body">
        <?php
        if($submited == true) {
            if($success == true) {
                echo '<div class="alert alert-success">¡Cambios guardados con éxito!</div>';
            }else{
                echo '<div class="alert alert-danger">No se pudieron guardar los cambios.</div>';
            }
        }
        ?>
        <form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
            <h4>Título del formulario</h4>
            <div class="form-group">
                <input class="form-control" name="form_title" value="<?=$formTitle ?? '';?>">
            </div>

            
            <h4>Texto Sección NUESTROS BOLSONES</h4>
            <p>Edita el contenido que se muestra en la sección Nuestros Bolsones</p>
            <div class="form-group">
                <textarea class="form-control" name="descripcionBolson" rows="10"><?=$descripcionBolson ?? '';?></textarea>
            </div>

            <h4>Texto Sección NUESTROS BOLSONES (con el formulario CERRADO)</h4>
            <p>Edita el contenido que se muestra en la sección Nuestros Bolsones con el formulario cerrado</p>
            <div class="form-group">
                <textarea class="form-control" name="descripcionBolsonesFormCerrado" rows="10"><?=$descripcionBolsonesFormCerrado ?? '';?></textarea>
            </div>

            <h4>Texto Sección TIENDA</h4>
            <p>Edita el contenido que se muestra en la sección Tienda</p>
            <div class="form-group">
                <textarea class="form-control" name="descripcionTienda" rows="10"><?=$descripcionTienda ?? '';?></textarea>
            </div>

            <h4>Texto Sección TIENDA (con el formulario CERRADO)</h4>
            <p>Edita el contenido que se muestra en la sección Tienda con el formulario cerrado</p>
            <div class="form-group">
                <textarea class="form-control" name="descripcionTiendaFormCerrado" rows="10"><?=$descripcionTiendaFormCerrado ?? '';?></textarea>
            </div>

            <h4>Texto Pedidos Fuera de Horario</h4>
            <p>Edita el contenido que se muestra en la cartel de aviso cuando un pedido se realiza fuera de horario (TIENDA CERRADA)</p>
            <div class="form-group">
                <textarea class="form-control" name="descripcionPedidoFueraDeHorario" rows="10"><?=$descripcionPedidoFueraDeHorario ?? '';?></textarea>
            </div>
            
            <h4>Texto del formulario</h4>
            <p>Edita el contenido que se muestra antes de que empiece el formulario del pedido. Emojis permitidos 😎</p>
            <div class="form-group">
                <input type="hidden" name="<?=$csrf_name;?>" value="<?=$csrf_hash;?>">
                <textarea class="form-control" name="form_text" rows="10"><?=$formText ?? '';?></textarea>
            </div>
            
            <!--
                <h4>Fecha de entrega</h4>
                <p>Ingresa texto con la fecha de entrega que confirma el cliente.</p>
                <div class="form-group">
                    <input type="text" class="form-control" name="confirmation_label" value="<?=$confirmationLabel ?? '';?>">
                </div>
            -->
            
            <h4>Texto de orden exitosa</h4>
            <p>El usuario verá el texto que escribas cuando complete correctamente el formulario.</p>
            <div class="form-group">
                <textarea class="form-control" name="order_success" rows="10"><?=$orderSuccess ?? '';?></textarea>
            </div>

            <h4>Texto de formulario desactivado</h4>
            <p>Cuando no esté habilitado el formulario de órdenes, el usuario verá lo que escribas.</p>
            <div class="form-group">
                <textarea class="form-control" name="form_disabled_text" rows="10"><?=$formDisabledText ?? '';?></textarea>
            </div>

            <h4>Texto de la página principal</h4>
            <p>Se muestra siempre y es el texto que aparece abajo de los dos botones para elegir el tipo de pedido.</p>
            <div class="form-group">
                <textarea class="form-control" name="main_text" rows="10"><?=$mainText ?? '';?></textarea>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary float-right" value="Guardar cambios" name="subm">
            </div>
        </form>
    </div>
</div>