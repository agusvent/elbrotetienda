$(document).ready(function() {
    $('body').on('change', "input[id*='newsletterHabilitado']", function(e) {
        e.preventDefault();
        //let officeId = $(this).attr('data-office-id');
        let newsletterStatus = $(this).is(':checked') ? 1 : 0;
        setNewsletterStatus(newsletterStatus);
    });

    $('body').on('change', "input[id*='recetarioStatus']", function(e) {
        e.preventDefault();
        //let officeId = $(this).attr('data-office-id');
        let recetarioStatus = $(this).is(':checked') ? 1 : 0;
        setRecetarioStatus(recetarioStatus);
    });

    $('body').on('change', "input[id*='active_']", function(e) {
        e.preventDefault();
        let adjuntoId = $(this).attr('data-adjunto-id');
        let adjuntoStatus = $(this).is(':checked') ? 1 : 0;
        setAdjuntoStatus(adjuntoId,adjuntoStatus);
    });

    $('#modalAdjuntos').on('hidden.bs.modal', function (e) {
        $("#nombreAdjuntos").prop("disabled",false);
        $("#nombreAdjuntos").val("");
        $("#bGrabarAdjuntos").show();
        $("#bGrabarRecetario").hide();
        $("#esRecetario").val(0);
    });

    $("#bGrabarAdjuntos").on("click",function(e){
        e.preventDefault();
        if(checkAdjuntoForm()) {
            var nombre = $("#nombreAdjuntos").val();
            var adjunto = $('#archivoAdjuntos').prop('files')[0];  
            var adjuntoExtension = $('#archivoAdjuntos').val().substr(($('#archivoAdjuntos').val().lastIndexOf('.') + 1));

            var form_data = new FormData();         
            form_data.append('nombre', nombre);
            form_data.append('file', adjunto);
            form_data.append('fileExtension', adjuntoExtension);

            $.ajax({
                url: ajaxURL + 'newsletter/addAdjunto', // point to server-side PHP script 
                dataType: 'text', // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,             
                type: 'post',
                success: function(res){
                    //console.log("HOLA",res);
                    //extrasHelper.cleanAddExtraForm();
                    window.location.reload(true); 
                }
            });
        }
    });

    $("#bGrabarRecetario").on("click",function(e){
        e.preventDefault();
        if(checkAdjuntoForm()) {
            var nombre = $("#nombreAdjuntos").val();
            var adjunto = $('#archivoAdjuntos').prop('files')[0];  
            var adjuntoExtension = $('#archivoAdjuntos').val().substr(($('#archivoAdjuntos').val().lastIndexOf('.') + 1));
            $("#nombreAdjuntos").prop("disabled",false);
            var form_data = new FormData();         
            form_data.append('nombre', nombre);
            form_data.append('file', adjunto);
            form_data.append('fileExtension', adjuntoExtension);

            $.ajax({
                url: ajaxURL + 'newsletter/editRecetario', // point to server-side PHP script 
                dataType: 'text', // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,             
                type: 'post',
        success: function(res){
                    //console.log("HOLA",res);
                    //extrasHelper.cleanAddExtraForm();
                    window.location.reload(true); 
                }
            });  
        }
    });

    $("#aDescargarNewsletter").on("click",function(e) {
        e.preventDefault();
        var dt = new Date();
        var time = dt.getHours() + dt.getMinutes() + dt.getSeconds();
    
        $.ajax({
            url: ajaxURL + 'newsletter/descargarSuscriptos/',
            method: 'post',
            async: false
        }).done(function(result) {
            window.open(baseURL+result.fileName+"?v="+time, "popupWindow", "width=600, height=400, scrollbars=yes");
        });        
    });

    $(".newsletter-adjunto-delete").on("click",function(e) {
        e.preventDefault();
        var idAdjunto = $(this).attr("data-id-adjunto");
        eliminarNewsletterAdjunto(idAdjunto);
    });
    
    $(".newsletter-adjunto-edit").on("click",function(e) {
        e.preventDefault();
        var idAdjunto = $(this).attr("data-id-adjunto");
        var adjunto = getNewsletterAdjunto(idAdjunto);
        setAdjuntoForm(adjunto);
        showAdjuntos();
    });

    $(".recetario-edit").on("click",function(e) {
        e.preventDefault();
        setRecetarioForm();
        $("#esRecetario").val(1);
        showAdjuntos();
    });

});

function setNewsletterStatus(newsletterStatus) {
    let data = {
        'newsletterStatus' : newsletterStatus
    };
    $.ajax({
        url: ajaxURL + 'newsletter/setNewsletterStatus',
        data: data,
        method: 'post',
        async: true
    });
}

function setRecetarioStatus(recetarioStatus) {
    let data = {
        'recetarioStatus' : recetarioStatus
    };
    $.ajax({
        url: ajaxURL + 'newsletter/setRecetarioStatus',
        data: data,
        method: 'post',
        async: true
    });
}

function setAdjuntoStatus(adjuntoId,adjuntoStatus) {
    let data = {
        'adjuntoId' : adjuntoId,
        'adjuntoStatus' : adjuntoStatus
    };
    $.ajax({
        url: ajaxURL + 'newsletter/setAdjuntoStatus',
        data: data,
        method: 'post',
        async: true
    });
}

function showAdjuntos() {
    if( $("#esRecetario").val()==1 ) {
        $("#bGrabarAdjuntos").hide();
        $("#bGrabarRecetario").show();
    }else{
        $("#bGrabarAdjuntos").show();
        $("#bGrabarRecetario").hide();
    }
    $("#modalAdjuntos").modal("show");
}

function checkAdjuntoForm() {
    var formOK = true;
    if($("#nombreAdjuntos").val() == "") {
        formOK = false;
    }
    if($("#archivoAdjuntos").val() == "") {
        formOK = false;
    }else{
        var extensionDocumento = $('#archivoAdjuntos').val().substr(($('#archivoAdjuntos').val().lastIndexOf('.') + 1));
        extensionDocumento = extensionDocumento.toLowerCase();
        if(extensionDocumento!="pdf" && extensionDocumento!="jpg" && extensionDocumento!="jpeg" && extensionDocumento!="png") {
            formOK = false;
        }
    }
    return formOK;
}

function eliminarNewsletterAdjunto(idAdjunto) {
    let data = {
        'adjuntoId' : idAdjunto
    };
    $.ajax({
        url: ajaxURL + 'newsletter/eliminarNewsletterAdjunto',
        data: data,
        method: 'post',
        async: true,
    success: function(res){
            //console.log("HOLA",res);
            //extrasHelper.cleanAddExtraForm();
            window.location.reload(true); 
        }

    });
}

function getNewsletterAdjunto(idAdjunto) {
    let adjunto;
    var data = {
        "adjuntoId": idAdjunto
    };
    $.ajax({
        url: ajaxURL + 'newsletter/getNewsletterAdjunto',
        data: data,
        method: 'post',
        async: false
    }).done(function(result) {
        adjunto = result.adjunto;
    });
    return adjunto;
}

function setRecetarioForm() {
    $("#nombreAdjuntos").val("Recetario");
    $("#nombreAdjuntos").prop("disabled",true);
}

function setAdjuntoForm(adjunto) {
    if(adjunto!=null) {
        if(adjunto.nombre!=null) {
            $("#nombreAdjuntos").val(adjunto.nombre);
        }
    }
}

function verAdjuntoRecetario() {
    window.open(baseURL+"../assets/resources/recetario.pdf","_blank");
}

function verAdjunto(idAdjunto) {
    var dt = new Date();
    var time = dt.getHours() + dt.getMinutes() + dt.getSeconds();

    var adjunto = getNewsletterAdjunto(idAdjunto);
    window.open(baseURL+"../assets/resources/newsletter/adjuntos/"+adjunto.archivo+"?v="+time,"_blank");
}