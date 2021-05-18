$(function () {
    
    //obtenerlista('iniciar');
    (function a() {
        a();
    })();
   
    var fn = function(){}
    fn = function(){ fn(); adjuntar(); }
    
});

function adjuntar(){
    //$('#icodtipo').val('2');
    //var icodtipo = "2";
    //$('#fileupload').fileupload('option', 'formData').icodtipo = '2';
    
    
    $('#fileupload').fileupload({
    dataType: 'json',
    formData: {icodtipo: "2" },
    done: function (e, data) {
       // $("tr:has(td)").remove();
       $("#uploaded-files").find("tr:gt(0)").remove();
        recargarlistaarchivos(data.result);

        document.getElementById("pregoresotexto").innerHTML = 'Progreso: Subido.';
        $("#fileupload").prop("disabled",false);
        $(".eliminar").prop("disabled",false).css("background","url(../resources/dist/img/del.png)");
        $('#btnGuardar').prop("disabled",false);
    },

    progressall: function (e, data) {

        var progress = parseInt(data.loaded / data.total * 100, 10);

        $('#progress').css(
            'width',
            progress + '%'
        );

        document.getElementById("progress").innerHTML = progress + '%';
        document.getElementById("pregoresotexto").innerHTML = 'Progreso: Subiendo...';
        $("#fileupload").prop("disabled",true);
        $(".eliminar").prop("disabled",true).css("background","url(../resources/dist/img/del_.png)");
        $('#btnGuardar').prop("disabled",true);
    },

    dropZone: $('#dropzone')
});

    $('#fileupload').trigger('click');
}

function obtenericodtipo()
{
    console.log("con aa "+$('#icodtipo').val());
    return $('#icodtipo').val();
}
function obtenerlista(tipo)
{
    console.log('x');
    //alert("okkkk");
    try {
        
    $.ajax({
    type:'GET',
    url: "listararchivosinternooficina",
    dataType: 'json',
    success:function(data, status){
        
        console.log(data);
        
        recargarlistaarchivos(data);
        
        if(tipo=='eliminar')
        {
            document.getElementById("pregoresotexto").innerHTML = 'Progreso: Eliminado.';
        }
        
        },
    error:function(xhr, status, errorThrown){

        console.log(xhr);
        console.log(status);
        console.log(errorThrown);
    }

    });
    }     catch(err) {
        console.log(err.message);
    }
    

}

function recargarlistaarchivos(archivos)
{
    $("#uploaded-files").find("tr:gt(0)").remove();
    
    var icodtramite = $('#icodtramite').val();
    var icodtipo = $('#icodtipo').val();
    
    console.log("icodtipo "+icodtipo);
    
    if(icodtramite>0 && (null == icodtipo || icodtipo=='')){
        console.log('1');
        var tipoadjunto = "";
        $.each(archivos, function (index, file) {
            
            if(file.icodtipo=='1')tipoadjunto="Word llenado"
            if(file.icodtipo=='2')tipoadjunto="Pdf firmado"
            if(file.icodtipo=='3')tipoadjunto="Anexo"
            
            $("#uploaded-files").append(
                    $('<tr style="word-break: break-all;" />')
                    .append($('<td/>').text(file.fileName))
                    //.append($('<td/>').html("<a href='/app_std/verarchivosinternooficina/"+index+"'>Descargar Documento</a>"))
                    .append($('<td/>').text(tipoadjunto))
                    //.append($('<td/>').html("<a target='_blank' href='verdigital/"+index+"'>Click</a>"))
                    //.append($('<td/>').html("<a target='_blank' href='verdigital/"+file.fileName+"'>Click</a>"))
                    .append($('<td/>').html("<a target='_blank' href='verdigital/"+file.identificador+"/0/0'>Click</a>"))
                    )
        }); 
    }else if(icodtramite>=0  ){
        console.log('_2');
        var cont = 0;
        $.each(archivos, function (index, file) {
            
            console.log('asd');
            var icodtipo = 3;
            var tipoadjunto = file.fileType;
            //si existe word
            //alert(file.icodtipo);
            if(file.icodtipo=='1')
            {
                     $("#btnSubirformato").prop("disabled",true);
                     $("#continuar").prop("disabled",false);
                     tipoadjunto="Word llenado"
                     icodtipo = 1;
                     cont++;
            }
            
            if(file.icodtipo=='2')
            {
                     $("#btnSubirPdf").prop("disabled",true);
                     tipoadjunto="Pdf firmado"
                     icodtipo = 2;
                     cont++;
            }
            //alert(file.icodtipo);
            filename="0";
            extension="0";
            if(file.icodtipo!=null){
                filename=file.fileName;
                extension=file.fileName.split('.').pop();
            }
            //alert(extension);
            //else identificador=file.identificador
            rutaImg = "D://digitales/temp/"+file.identificador+"/"+filename;
            //alert(file.fileName);
            //alert(file.identificador);
            //alert(file.ruta);
            $("#uploaded-files").append(
                    $('<tr style="word-break: break-all;" />')
                    .append($('<td/>').text(file.fileName))
                    //.append($('<td/>').text(file.fileSize))
                    //.append($('<td/>').text(tipoadjunto))
                    //.append($('<td/>').html("<a href='/app_std/verarchivosinternooficina/"+index+"'>Click</a>"))
                    //.append($('<td/>').html("<a target='_blank' href='"+file.link+"'>Click</a>"))
                    //.append($('<td style="text-align:center" />').html("<a target='_blank' href='"+file.link+"'><i class='fa fa-download' aria-hidden='true'></i></a>"))
                    //.append($('<td style="text-align:center" />').html("<a target='_blank' href='verdigital/"+index+"'><i class='fa fa-download' aria-hidden='true'></i></a>"))
                    .append($('<td style="text-align:center" />').html("<a target='_blank' href='verdigital/"+file.identificador+"/"+filename+"/"+extension+"'><i class='fa fa-download' aria-hidden='true'></i></a>"))
                    //.append($('<td style="text-align:center" />').html("<img width='20' src='"+rutaImg+"' />"))
                     //.append($('<td/>').html("<a target='_blank' onclick='eliminararchivo("+index+","+icodtipo+")'>Click</a>"))
                     .append($('<td style="text-align:center"/>').html("<input type='button' class='eliminar icon_del' value='' onclick='eliminararchivo("+index+","+icodtipo+")' />"))
                    )
            
        });
        
        if(cont > 0){
            $("#continuar").prop("disabled",false);
        }
        

    }
   
}

function eliminararchivo(id,icodtipo)
{
     
    document.getElementById("pregoresotexto").innerHTML = 'Progreso: Eliminando...';
    
    try {
        
    $.ajax({
    type:'POST',
    url: "eliminararchivosinternooficina",
    data: { 
        'id': id, 
    },
    //dataType: 'json',
    success:function(data, status){

        obtenerlista('eliminar');
        
        if(icodtipo==1 )
        {
            $("#btnSubirformato").prop("disabled",false);
            $("#continuar").prop("disabled",true);
        }
        
        if(icodtipo==2)
        {
            $("#btnSubirPdf").prop("disabled",false);
        }        
        
        },
    error:function(xhr, status, errorThrown){
        document.getElementById("pregoresotexto").innerHTML = 'Progreso: Error al eliminar.';
        console.log(xhr);
        console.log(status);
        console.log(errorThrown);
    }

    });
    
    }     catch(err) {
        console.log(err.message);
        document.getElementById("pregoresotexto").innerHTML = 'Progreso: Error al eliminar.';
    }
}

obtenerlista('iniciar');