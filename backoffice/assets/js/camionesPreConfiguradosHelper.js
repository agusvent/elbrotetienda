$(document).ready(function() {
    camionesPreConfiguradosHelper.init();
});

const camionesPreConfiguradosHelper = {
    asignoEventos: function() {

        $("#newCamionPreConfiguradoModal").on("hide.bs.modal",function(e){
            camionesPreConfiguradosHelper.limpiarFormNuevoCamion();
        });

        $("#bEditarCamion").on("click",function(e) {
            e.preventDefault();
            mostrarLoader();
            var msj = "";
            msj = checkFormEditarCamionPreConfigurado();
            if(msj==""){
                let camionNombre = $("#editarCamionPreConfiguradoNombre").val();
                let idCamionPreConfigurado = $("#idCamionPreConfigurado").val();
                $("#bGrabarNuevoCamion").prop("disabled",true);
                let data = {
                    'camionNombre' : camionNombre,
                    'idCamionPreConfigurado': idCamionPreConfigurado
                };
                $.ajax({
                    url: ajaxURL + 'camionesPreConfigurados/editar',
                    data: data, 
                    method: 'post',
                    async: false
                }).done(function(result) {
                    //$("#idNuevoCamionPreConfigurado").val(result.idCamionPreConfigurado);
                    if(result.status == 'ok') {
                        ocultarLoader();
                        window.location.reload(true); 
                        return Swal.fire('Éxito', 'Se ha editado el Camión Pre Configurado con éxito.', 'success');
                    }
                    return Swal.fire('Error', 'No se pudo editar el camión. Intenta de nuevo.', 'error');
                }).fail( function( jqXHR, textStatus, errorThrown ) {
                    console.log(jqXHR );
                });
            }else{
                ocultarLoader();
                return Swal.fire('Error', msj, 'error');
            }            
        });

        $("#bGrabarNuevoCamion").on("click",function(e) {
            e.preventDefault();
            mostrarLoader();
            var msj = "";
            msj = checkFormNuevoCamionPreConfigurado();
            if(msj==""){
                let camionNombre = $("#newCamionPreConfiguradoNombre").val();
                $("#bGrabarNuevoCamion").prop("disabled",true);
                let data = {
                    'camionNombre' : camionNombre
                };
                $.ajax({
                    url: ajaxURL + 'crearCamionPreConfigurado',
                    data: data,
                    method: 'post',
                    async: false
                }).done(function(result) {
                    //$("#idNuevoCamionPreConfigurado").val(result.idCamionPreConfigurado);
                    if(result.status == 'ok') {
                        ocultarLoader();
                        window.location.reload(true); 
                        return Swal.fire('Éxito', 'Se ha creado el Camión Pre Configurado con éxito.', 'success');
                    }
                    return Swal.fire('Error', 'No se pudo crear el camión. Intenta de nuevo.', 'error');
                }).fail( function( jqXHR, textStatus, errorThrown ) {
                    console.log(jqXHR );
                });
            }else{
                ocultarLoader();
                return Swal.fire('Error', msj, 'error');
            }
        });

        $('#confirmEliminarCamionModal').on('hidden.bs.modal', function (e) {
            $("#idEliminarCamion").val(0);
            $("#eliminarCamionBody").html("");
        });

        $("#bGrabarEliminarCamion").on("click",function(e) {
            var idCamion = $("#idEliminarCamion").val();
            deleteCamion(idCamion);
        });
        
    },
    init: function(){
        this.asignoEventos();
        getPuntosYBarriosPendientesAsociacion();
    },
    limpiarFormNuevoCamion: function(){
        $("#newCamionPreConfiguradoNombre").val("");
    }
}

function checkFormNuevoCamionPreConfigurado(){
    var msj = "";
    if($("#newCamionPreConfiguradoNombre").val()==""){
        msj += "<p>Debe cargar un nombre para el Camión.</p>";
    }
    return msj;
}

function checkFormEditarCamionPreConfigurado(){
    var msj = "";
    if($("#editarCamionPreConfiguradoNombre").val()==""){
        msj += "<p>Debe cargar un nombre para el Camión.</p>";
    }
    return msj;
}

function completarFormularioEdicionCamionPreConfigurado(camion){
    if(camion.nombre!=null && camion.nombre!=""){
        $("#editarCamionPreConfiguradoNombre").val(camion.nombre);
    }
}

function openEditarCamionPreConfigurado(idCamionPreConfigurado){
    $.ajax({
        url: ajaxURL + 'camionesPreConfigurados/getById/' + idCamionPreConfigurado,
        method: 'get',
        async: false
    }).done(function(result) {
        if(result.status == 'ok') {
            completarFormularioEdicionCamionPreConfigurado(result.camionPreConfigurado);
            $('#idCamionPreConfigurado').val(idCamionPreConfigurado);
        }
    });

    $('#editarCamionPreConfiguradoModal').modal('show');
}

function openEditarPuntosRetiroBarrios(idCamionPreConfigurado){
    mostrarLoader();
    setTimeout(function(){
        $('#idCamionPreConfigurado').val(idCamionPreConfigurado);
        $.ajax({
            url: ajaxURL + 'camionesPreConfigurados/getById/' + idCamionPreConfigurado,
            method: 'get',
            async: false
        }).done(function(result) {
            if(result.status == 'ok') {
                $("#spanNombreCamionPreConfigurado").html(result.camionPreConfigurado.nombre);
            }
        });    
        $.ajax({
            url: ajaxURL + 'offices/getAllPuntosDeRetiro',
            method: 'get',
            async: false
        }).done(function(result) {
            if(result.status == 'ok') {
                if(result.cPuntosDeRetiro!=null){
                    var htmlListado = "";
                    htmlListado = crearListadoPuntosDeRetiro(result.cPuntosDeRetiro);
                    $("#divPuntosDeRetiro").html(htmlListado);
                }
            }
        });
        $.ajax({
            url: ajaxURL + 'barrios/getAllBarrios',
            method: 'get',
            async: false
        }).done(function(result) {
            if(result.status == 'ok') {
                if(result.cBarrios!=null){
                    var htmlListado = "";
                    htmlListado = crearListadoBarrios(result.cBarrios);
                    $("#divBarrios").html(htmlListado);
                }
            }
        });
        getPuntosRetiroFromCamionPreConfigurado(idCamionPreConfigurado);
        getBarriosFromCamionPreConfigurado(idCamionPreConfigurado);
        getPuntosRetiroYaAsociadosExcludingIdCamion(idCamionPreConfigurado);
        getBarriosYaAsociadosExcludingIdCamion(idCamionPreConfigurado);
        initializeChecboxesListeners();
        ocultarLoader();
        $('#editarPuntosRetiroBarriosModal').modal('show');
    },300);
}

function capitalizeTheFirstLetterOfEachWord(words) {
    var separateWord = words.toLowerCase().split(' ');
    for (var i = 0; i < separateWord.length; i++) {
       separateWord[i] = separateWord[i].charAt(0).toUpperCase() +
       separateWord[i].substring(1);
    }
    return separateWord.join(' ');
 }

function crearListadoPuntosDeRetiro(cPuntosDeRetiro){
    var html = '<div class="row">';
    var nom = "";
    for(var i=0;i<cPuntosDeRetiro.length;i++){
        nom = cPuntosDeRetiro[i].name;
        /*nom = nom.toLowerCase();*/
        html += '<div class="col-sm-2" style="margin-bottom: 10px;padding-left:5px;padding-right:5px;">';
        html += '<div class="caja-camion-preConfigurado">';
        html += '<input type="checkbox" name="checkPuntoRetiro'+cPuntosDeRetiro[i].id+'" id="checkPuntoRetiro'+cPuntosDeRetiro[i].id+'" value="'+cPuntosDeRetiro[i].id+'">';
        //html += '<label for="checkPuntoRetiro'+cPuntosDeRetiro[i].id+'">'+capitalizeTheFirstLetterOfEachWord(nom)+'</label>';
        html += '<label for="checkPuntoRetiro'+cPuntosDeRetiro[i].id+'">'+nom+'</label>';
        html += '<p style="font-size:12px;color:#ff0000;" id="pCamionAsociadoPuntoRetiro'+cPuntosDeRetiro[i].id+'">&nbsp;</p>';
        html += "</div>";
        html += "</div>";
    }
    html += "</div>";
    return html;
}

function crearListadoBarrios(cBarrios){
    var html = '<div class="row">';
    //si hago uppercase el nombre ya se ve feo con col-sm-2
    for(var i=0;i<cBarrios.length;i++){
        html += '<div class="col-sm-2" style="margin-bottom: 10px;padding-left:10px;padding-right:10px;">';
        html += '<div class="caja-camion-preConfigurado">';
        html += '<input type="checkbox" name="checkBarrio'+cBarrios[i].id+'" id="checkBarrio'+cBarrios[i].id+'" value="'+cBarrios[i].id+'">';
        html += '<label for="checkBarrio'+cBarrios[i].id+'">'+cBarrios[i].nombre+'</label>';
        html += '<p style="font-size:12px;color:#ff0000;" id="pCamionAsociadoBarrio'+cBarrios[i].id+'">&nbsp;</p>';
        html += "</div>";
        html += "</div>";
    }
    html += "</div>";
    return html;
}

function getPuntosRetiroYaAsociadosExcludingIdCamion(idCamionPreConfigurado){
    $.ajax({
        url: ajaxURL + 'camionesPreConfigurados/getPuntosDeRetiroYaAsociadosExcludingIdCamion/'+idCamionPreConfigurado,
        method: 'get',
        async: false
    }).done(function(result) {
        if(result.status == 'ok') {
            if(result.cPuntosRetiro!=null){
                marcarYaAsociadosEnListadoDePuntosDeRetiro(result.cPuntosRetiro);
            }
        }
    });
}

function getPuntosRetiroFromCamionPreConfigurado(idCamionPreConfigurado){
    $.ajax({
        url: ajaxURL + 'camionesPreConfigurados/getPuntosDeRetiro/'+idCamionPreConfigurado,
        method: 'get',
        async: false
    }).done(function(result) {
        if(result.status == 'ok') {
            if(result.cPuntosRetiro!=null){
                marcarEnListadoDePuntosDeRetiro(result.cPuntosRetiro);
            }
        }
    });
}

function getBarriosYaAsociadosExcludingIdCamion(idCamionPreConfigurado){
    $.ajax({
        url: ajaxURL + 'camionesPreConfigurados/getBarriosYaAsociadosExcludingIdCamion/'+idCamionPreConfigurado,
        method: 'get',
        async: false
    }).done(function(result) {
        if(result.status == 'ok') {
            if(result.cBarrios!=null){
                marcarYaAsociadosEnListadoDeBarrios(result.cBarrios);
            }
        }
    });
}

function getBarriosFromCamionPreConfigurado(idCamionPreConfigurado){
    $.ajax({
        url: ajaxURL + 'camionesPreConfigurados/getBarrios/'+idCamionPreConfigurado,
        method: 'get',
        async: false
    }).done(function(result) {
        if(result.status == 'ok') {
            if(result.cBarrios!=null){
                marcarEnListadoDeBarrios(result.cBarrios);
            }
        }
    });
}

function marcarEnListadoDePuntosDeRetiro(cPuntosRetiro){
    for(var i=0;i<cPuntosRetiro.length;i++){
        $("#checkPuntoRetiro"+cPuntosRetiro[i].idPuntoRetiro).prop("checked",true);
    }
}

function marcarYaAsociadosEnListadoDePuntosDeRetiro(cPuntosRetiro){
    for(var i=0;i<cPuntosRetiro.length;i++){
        $("#checkPuntoRetiro"+cPuntosRetiro[i].idPuntoRetiro).prop("disabled",true);
        $("#pCamionAsociadoPuntoRetiro"+cPuntosRetiro[i].idPuntoRetiro).html(cPuntosRetiro[i].camionAsociado);
    }
}

function marcarEnListadoDeBarrios(cBarrios){
    for(var i=0;i<cBarrios.length;i++){
        $("#checkBarrio"+cBarrios[i].idBarrio).prop("checked",true);
    }
}

function marcarYaAsociadosEnListadoDeBarrios(cBarrios){
    for(var i=0;i<cBarrios.length;i++){
        $("#checkBarrio"+cBarrios[i].idBarrio).prop("disabled",true);
        $("#pCamionAsociadoBarrio"+cBarrios[i].idBarrio).html(cBarrios[i].camionAsociado);
    }
}

function initializeChecboxesListeners(){
    initializeCheckboxesPuntosRetiroListeners();
    initializeCheckboxesBarriosListeners();
}

function initializeCheckboxesPuntosRetiroListeners(){
    $("input[name^='checkPuntoRetiro']").on("click",function(e){
        let idPuntoRetiro = $(this).val();
        let puntoRetiroText = $('label[for="checkPuntoRetiro'+idPuntoRetiro+'"]').html();
        let idCamion = $("#idCamionPreConfigurado").val();
        let checked = $(this).prop("checked");
        let data = {
            'idCamionPreConfigurado' : idCamion,
            'idPuntoRetiro' : idPuntoRetiro
        };
        mostrarLoader();
        setTimeout(function(){
            if(checked){
                //AGREGO
                $.ajax({
                    url: ajaxURL + 'camionesPreConfigurados/addPuntoRetiro',
                    data: data,
                    method: 'post',
                    async: true
                }).done(function(result) {
                    if(result.status == 'ok') {
                        $("#mensajeGrabadoPuntosRetiro").html("Se grabo correctamente: "+puntoRetiroText);
                        setTimeout(function(){
                            $("#mensajeGrabadoPuntosRetiro").html("");
                        },3000)
                    }else{
                        $("#mensajeGrabadoPuntosRetiro").html("No se pudo grabar: "+puntoRetiroText);
                        setTimeout(function(){
                            $("#mensajeGrabadoPuntosRetiro").html("");
                        },3000)
                    }
                });            
            }else{
                //ELIMINO
                $.ajax({
                    url: ajaxURL + 'camionesPreConfigurados/deletePuntoRetiro',
                    data: data,
                    method: 'post',
                    async: true
                }).done(function(result) {
                    if(result.status == 'ok') {
                        $("#mensajeGrabadoPuntosRetiro").html("Se eliminó correctamente: "+puntoRetiroText);
                        setTimeout(function(){
                            $("#mensajeGrabadoPuntosRetiro").html("");
                        },3000)
                    }else{
                        $("#mensajeGrabadoPuntosRetiro").html("No se pudo eliminar: "+puntoRetiroText);
                        setTimeout(function(){
                            $("#mensajeGrabadoPuntosRetiro").html("");
                        },3000)
                    }
                });                        
            }
            getPuntosYBarriosPendientesAsociacion();
            ocultarLoader();
        },600);
    });
}

function initializeCheckboxesBarriosListeners(){
    $("input[name^='checkBarrio']").on("click",function(e){
        let idBarrio = $(this).val();
        let barrioText = $('label[for="checkBarrio'+idBarrio+'"]').html();
        let idCamion = $("#idCamionPreConfigurado").val();
        let checked = $(this).prop("checked");
        let data = {
            'idCamionPreConfigurado' : idCamion,
            'idBarrio' : idBarrio
        };
        mostrarLoader();
        setTimeout(function(){
            if(checked){
                //AGREGO
                $.ajax({
                    url: ajaxURL + 'camionesPreConfigurados/addBarrio',
                    data: data,
                    method: 'post',
                    async: false
                }).done(function(result) {
                    if(result.status == 'ok') {
                        $("#mensajeGrabadoBarrios").html("Se grabo correctamente: "+barrioText);
                        setTimeout(function(){
                            $("#mensajeGrabadoBarrios").html("");
                        },3000)
                    }else{
                        $("#mensajeGrabadoBarrios").html("No se pudo grabar: "+barrioText);
                        setTimeout(function(){
                            $("#mensajeGrabadoBarrios").html("");
                        },3000)
                    }
                });            
            }else{
                //ELIMINO
                $.ajax({
                    url: ajaxURL + 'camionesPreConfigurados/deleteBarrio',
                    data: data,
                    method: 'post',
                    async: false
                }).done(function(result) {
                    if(result.status == 'ok') {
                        $("#mensajeGrabadoBarrios").html("Se eliminó correctamente: "+barrioText);
                        setTimeout(function(){
                            $("#mensajeGrabadoBarrios").html("");
                        },3000)
                    }else{
                        $("#mensajeGrabadoBarrios").html("No se pudo eliminar: "+barrioText);
                        setTimeout(function(){
                            $("#mensajeGrabadoBarrios").html("");
                        },3000)
                    }
                });                        
            }
            getPuntosYBarriosPendientesAsociacion();
            ocultarLoader();
        },600);
    });
}

function openPuntosRetioBarriosPendientesDeAsociar(){
    $("#puntosRetiroBarriosPendientesAsociacion").modal('show');
}

function getPuntosYBarriosPendientesAsociacion(){
    var cPuntosRetiro = getPuntosRetiroPendientesAsociacion();
    var cBarrios = getBarriosPendientesAsociacion();
    var html = "";
    if(cPuntosRetiro!=null && cPuntosRetiro.length>0){
        html += "<h5>Puntos de Retiro Sin Asociar:</h5>"
        html += "<ul>";
        for(var i=0;i<cPuntosRetiro.length;i++){
            html += "<li>"+cPuntosRetiro[i].name+"</li>";
        }
        html += "</ul>";
    }
    if(cBarrios!=null && cBarrios.length>0){
        html += "<h5>Barrios Sin Asociar:</h5>"
        html += "<ul>";
        for(var i=0;i<cBarrios.length;i++){
            html += "<li>"+cBarrios[i].nombre+"</li>";
        }
        html += "</ul>";
    }
    
    $("#puntosRetiroBarriosPendientesAsociacionBody").html(html);

    if(html!=""){
        $("#aIconAlertPuntosBarriosPendientesAsociacion").addClass("animate__animated animate__heartBeat");
        $("#imgIconAlertPuntosBarriosPendientesAsociacion").prop("src","../assets/img/alert.png");
    }else{
        $("#aIconAlertPuntosBarriosPendientesAsociacion").removeClass("animate__animated animate__heartBeat");
        $("#imgIconAlertPuntosBarriosPendientesAsociacion").prop("src","../assets/img/alertOff.png");
    }
}

function getPuntosRetiroPendientesAsociacion(){
    var cPuntosRetiro;
    $.ajax({
        url: ajaxURL + 'camionesPreConfigurados/getPuntosRetiroPendientesAsociacion',
        method: 'get',
        async: false
    }).done(function(result) {
        if(result.status == 'ok') {
            if(result.cPuntosRetiroPendientesAsociacion!=null){
                cPuntosRetiro = result.cPuntosRetiroPendientesAsociacion;
            }
        }
    });  
    return cPuntosRetiro; 
}

function getBarriosPendientesAsociacion(){
    var cBarrios;
    $.ajax({
        url: ajaxURL + 'camionesPreConfigurados/getBarriosPendientesAsociacion',
        method: 'get',
        async: false
    }).done(function(result) {
        if(result.status == 'ok') {
            if(result.cBarriosPendientesAsociacion!=null){
                cBarrios = result.cBarriosPendientesAsociacion;
            }
        }
    });   
    return cBarrios;
}

function preDeleteCamion(idCamion, nombre) {
    $("#confirmEliminarCamionModal").modal("show");
    $("#idEliminarCamion").val(idCamion);
    $("#eliminarCamionBody").html("<p>Estas seguro que queres eliminar el camión '"+nombre+"'?</p><p>Los Puntos de Retiro o Barrios que tenga asociados quedaran sin camión asignado.");
}

function deleteCamion(idCamion) {
    let data = {
        'idCamionPreConfigurado': idCamion
    };
    $.ajax({
        url: ajaxURL + 'camionesPreConfigurados/eliminar',
        data: data, 
        method: 'post',
        async: false
    }).done(function(result) {
        window.location.reload(true); 
    });

}