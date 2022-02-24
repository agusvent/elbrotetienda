<div class="container-fluid">
    <div class="container login-wrapper">
        <div class="card login-card">
            <div class="card-body">
                <!--<h3>Iniciar sesión</h3>-->
                <form method="post" action="<?=base_url();?>process">
                <?php
                if(isset($error)) {
                ?>
                <div class="alert alert-danger">
                    <?=$error;?>
                </div>
                <?php } ?>
                <div class="form-group">
                        <label>Nombre de usuario:</label>
                        <input type="hidden" name="<?=$csrf_name;?>" value="<?=$csrf_hash;?>">
                        <input type="text" class="form-control" name="username" placeholder="Nombre de usuario" required>
                    </div>
                    <div class="form-group">
                        <label>Contraseña:</label>
                        <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Acceder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>