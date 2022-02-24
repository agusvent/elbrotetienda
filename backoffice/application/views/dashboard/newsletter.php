<div class="card">
    <div class="card-body">
        <h4 style="border-bottom:2px solid #FF0000;">
            Newsletter
            <a id="aDescargarNewsletter" href="#" style="margin-top:5px;width:49px;height:49px;float:right;border: solid 2px #000000;border-radius: 50px;background-color: #b1b3b7;text-align:center;">
                <img src="<?=assets();?>img/excel.png" style="width:38px;margin-top: 3px;margin-left: 1px;" alt="Descargar Newsletter" title="Descargar Newsletter"/>
            </a>
        </h4>
        <div class="extras-wrapper" style="text-align:center">
            <div class="extras-caja">
                <div class="extras-caja-titulo">PopUp Newsletter Habilitado</div>
                <div style="padding:5px;">
                    <div class="extras-caja-info" style="margin-bottom:20px;"> 
                        El popUp del Newsletter aparece cada vez que carga la web. Si este item lo inhabilitan, el popUp no va a aparecer más.
                    </div>
                    <div class="extras-caja-info" style="text-align:center"> 
                        <span>Habilitado: &nbsp;
                        <input id="newsletterHabilitado" type="checkbox" <?=($newsletterEnabled == 1) ? 'checked' : ''; ?> data-toggle="toggle" data-onstyle="success" data-size="xs" style="float:left;">    </span>
                    </div>
                </div>
            </div>
        </div>
        <h4 style="border-bottom:2px solid #FF0000;margin-top:50px;">
            Adjuntos del Mail de Newsletter
            <a href="javascript:showAdjuntos();" style="margin-top:5px;width:50px;height:50px;float:right;border: solid 2px #000000;border-radius: 50px;background-color: #FFFFFF;text-align:center;">
                <img src="<?=assets();?>img/add.png" style="width:40px;margin-top: 3px;margin-left: 1px;"/>
            </a>
            <!--<button type="button" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#newExtraModal"> Agregar </button>-->
        </h4>
        <p>Agrega, elimina y modifica adjuntos.</p>
        <p style="font-size:12px;">
            * El adjunto "Recetario" no puede ser eliminado ya que existe una url "https://elbrotetienda.com/recetario" que abre este archivo.<br />
        </p>
        <div class="table-responsive">
            <table class="table table-striped table-sm offices-table">
                <thead>
                    <tr>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                <tr data-adjunto="recetario">
                    <td data-adjunto="recetario">Recetario</td>
                    <td>
                        <input id="recetarioStatus" type="checkbox" <?=($recetarioStatus == 1) ? 'checked' : ''; ?> data-toggle="toggle" data-onstyle="success" data-size="xs" style="float:left;">    
                    </td>
                    <td>
                        <a href="javascript:verAdjuntoRecetario()">
                            <img src="<?=assets();?>img/eye.png" width="30px"/>
                        </a>
                    </td>
                    <td data-adjunto-actions>
                        <!--<button type="button" class="btn btn-danger btn-sm float-right office-delete" data-adjunto="recetario" disabled>Eliminar</button>-->
                        <button type="button" class="btn btn-secondary btn-sm float-right recetario-edit" data-adjunto="recetario">Editar</button>
                    </td>
                </tr>

                <?php foreach($cNewsletterAdjuntos ?? [] as $adjunto) : ?>
                    <tr data-adjunto-id="<?=$adjunto->id_adjunto;?>">
                        <td data-adjunto-name="<?=$adjunto->nombre;?>"><?=$adjunto->nombre;?></td>
                        <td data-adjunto-active="<?=$adjunto->estado;?>">
                            <input id="active_<?=$adjunto->id_adjunto;?>" data-adjunto-id="<?=$adjunto->id_adjunto;?>" type="checkbox" <?=($adjunto->estado == 1) ? 'checked' : ''; ?> data-toggle="toggle" data-onstyle="success" data-size="xs">
                        </td>
                        <td>
                            <a href="javascript:verAdjunto(<?=$adjunto->id_adjunto;?>)">
                                <img src="<?=assets();?>img/eye.png" width="30px"/>
                            </a>
                        </td>

                        <td data-adjunto-actions>
                            <button type="button" class="btn btn-danger btn-sm float-right newsletter-adjunto-delete" data-id-adjunto="<?=$adjunto->id_adjunto;?>">Eliminar</button>
                            <!--<button type="button" class="btn btn-secondary btn-sm float-right newsletter-adjunto-edit" data-id-adjunto="<?=$adjunto->id_adjunto;?>">Editar</button>-->
                        </td>
                    </tr>
                <?php endforeach; ?>


                </tbody>
            </table>
        </div>
    </div>
    <input type="hidden" id="esRecetario" name="esRecetario" value="0"/>
</div>

<!-- Modal Adjuntos-->
<div class="modal fade" id="modalAdjuntos" tabindex="-1" role="dialog" aria-labelledby="modalAdjuntos" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adjuntos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row rowFiltroPedidos">
                    <div class="col-xs-12 col-sm-12">
                        Nombre:
                        <input type="text" class="form-control form-control-sm" name="nombreAdjuntos" id="nombreAdjuntos" value=""/>
                    </div>
                </div>
                <div class="row rowFiltroPedidos">
                    <div class="col-xs-12 col-sm-12">
                        <label>Documento:</label>
                        <input type="file" class="form-control form-control-sm" name="archivoAdjuntos" id="archivoAdjuntos">
                        <p style="font-size:10px">* Extensiones v&aacute;lidas: PDF, JPEG, JPG y PNG.</p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" id="bGrabarAdjuntos" class="btn btn-primary btn-sm">Grabar</button>
                <button type="submit" id="bGrabarRecetario" class="btn btn-primary btn-sm">Grabar</button>
                <button type="button" id="bCancelarAdjuntos" data-dismiss="modal" class="btn btn-danger btn-sm">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Crear Dia de Entrega-->
<script type="text/javascript">const baseURL = "<?=base_url();?>";</script>
<script type="text/javascript" src="<?=assets();?>js/newsletter.js?v=713546"></script>