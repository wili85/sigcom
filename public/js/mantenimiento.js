
$(document).ready(function () {

	datatablenew();

	$('#addRow').on('click', function () {
		AddFila();
	});

	$('#tblProductos tbody').on('click', 'button.deleteFila', function () {
		var obj = $(this);
		obj.parent().parent().remove();
	});

	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#fecha_desde').datepicker({
        autoclose: true,
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
    });

	$('#fecha_hasta').datepicker({
        autoclose: true,
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
    });
	
	$("#tipo_buscar").select2();
});


function datatablenew(){
    var oTable = $('#tblMaestra').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/manten/listar_maestra_ajax",
        "bProcessing": true,
        "sPaginationType": "full_numbers",
        "bFilter": false,
        "bSort": false,
        "info": true,
        "language": {"url": "/js/Spanish.json"},
        "autoWidth": false,
        "bLengthChange": true,
        "destroy": true,
        "lengthMenu": [[10, 50, 100, 200, 60000], [10, 50, 100, 200, "Todos"]],
        "aoColumns": [
                        {},
        ],
		"dom": '<"top">rt<"bottom"flpi><"clear">',
        "fnDrawCallback": function(json) {
            $('[data-toggle="tooltip"]').tooltip();
        },

        "fnServerData": function (sSource, aoData, fnCallback, oSettings) {

            var sEcho           = aoData[0].value;
            var iNroPagina 	= parseFloat(fn_util_obtieneNroPagina(aoData[3].value, aoData[4].value)).toFixed();
            var iCantMostrar 	= aoData[4].value;

            //alert(iNroPagina);

			var tipo = $('#tipo_buscar').val();
			var denominacion = $('#denominacion_buscar').val();
			var estado = $('#estado_buscar').val();

			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
                        tipo:tipo, denominacion:denominacion, estado:estado,
						_token:_token
                       },
                "success": function (result) {
                    fnCallback(result);
                },
                "error": function (msg, textStatus, errorThrown) {
                }
            });
        },

        "aoColumnDefs":
            [
			 	{
                    "mRender": function (data, type, row) {
                        var id = "";
                        if(row.id!= null)id = row.id;
                        return id;
                    },
                    "bSortable": false,
                    "aTargets": [0]
                },
				{
                    "mRender": function (data, type, row) {
                        var tipo = "";
                        if(row.tipo!= null)tipo = row.tipo;
                        return tipo;
                    },
                    "bSortable": false,
                    "aTargets": [1],
                    //"className": "dt-center",
                    //"className": 'control'
                },

				{
                    "mRender": function (data, type, row) {
                        var denominacion = "";
                        if(row.denominacion!= null)denominacion = row.denominacion;
                        return denominacion;
                    },
                    "bSortable": false,
                    "aTargets": [2]
                },
                {
                    "mRender": function (data, type, row) {
                        var acronimo = "";
                        if(row.acronimo!= null)acronimo = row.acronimo;
                        return acronimo;
                    },
                    "bSortable": false,
                    //"className": "dt-center",
                    "aTargets": [3],
                },
                {
                    "mRender": function (data, type, row) {
                        var orden = "";
                        if(row.orden!= null)orden = row.orden;
                        return orden;
                    },
                    "bSortable": false,
                    "aTargets": [4]
                },
				{
                    "mRender": function (data, type, row) {
                        var id_parent = "";
                        if(row.id_parent!= null)id_parent = row.id_parent;
                        return id_parent;
                    },
                    "bSortable": false,
                    "aTargets": [5]
                },
                {
                    "mRender": function (data, type, row) {
                        var variable1 = "";
                        if(row.variable1!= null)variable1 = row.variable1;
                        return variable1;
                    },
                    "bSortable": false,
                    "aTargets": [6]
                },
                {
                    "mRender": function (data, type, row) {
                        var variable2 = "";
                        if(row.variable2!= null)variable2 = row.variable2;
                        return variable2;
                    },
                    "bSortable": false,
                    "aTargets": [7]
                },
                {
                    "mRender": function (data, type, row) {
                        var variable3 = "";
                        if(row.variable3!= null)variable3 = row.variable3;
                        return variable3;
                    },
                    "bSortable": false,
                    "aTargets": [8]
                },
				{
                    "mRender": function (data, type, row) {
                        var estado = "";
                        if(row.estado!= null)estado = row.estado;
                        return estado;
                    },
                    "bSortable": false,
                    "aTargets": [9],
                    "className": 'control'
                },

            ]


    });


	fn_util_LineaDatatable("#tblMaestra");

    //$('#tblSolicitud tbody').on('dblclick', 'tr', function () {
	$('#tblMaestra tbody').on('click', 'tr', function () {
        var anSelected = fn_util_ObtenerNumeroFila(oTable);
        if (anSelected.length != 0) {
			var odtable = $("#tblMaestra").DataTable();
			var idMaestra = odtable.row(this).data().id;
			//alert(idMaestra);
			obtenerMaestra(idMaestra);

			//var iIdProducto = odtable.row(this).data().iIdProducto;
			//AsignarDatosProductoCompra(iIdProveedor,iIdProducto)
        }
	});



}

function fn_ListarBusqueda() {
    //datatablenew();
	$('#tblMaestra').DataTable().ajax.reload();
	
};

function obtenerMaestra(id){

	//$('#tblProductos tbody').html("");

	$.ajax({
		url: '/manten/obtener_maestra/'+id,
		dataType: "json",
		success: function(result){
			var maestra = result.maestra;

			//alert(id);
            $('#id_maestra').val(id);
			$('#id_parent').val(maestra.id_parent);
			$('#tipo').val(maestra.tipo);
			$('#denominacion').val(maestra.denominacion);
			$('#acronimo').val(maestra.acronimo);
			$('#orden').val(maestra.orden);
            $('#estado').val(maestra.estado);
            $('#var1').val(maestra.variable1);
            $('#var2').val(maestra.variable2);
            $('#var3').val(maestra.variable3);

		}

	});

}

function guardarTablaMaestra(){
   // alert("Guardar");
    var msg = "";

    //var id_parent  = $('#id_parent').val();
    var tipo = $('#tipo').val();
    var denominacion = $('#denominacion').val();
    //var acronimo = $('#acronimo').val();
    var orden = $('#orden').val();
    //var estado = $('#estado').val();

    if(tipo == "")msg += "Debe ingresar el tipo <br>";
    if(denominacion == "")msg += "Debe la denominación <br>";
    if(orden == "")msg += "Debe ingresar el orden <br>";

    if(msg!=""){
        bootbox.alert(msg);
        return false;
    }
    else{
        fn_save_tabla_maestra();
    }

}

function fn_save_tabla_maestra(){

   // alert("Guardar");

    $.ajax({
            url: "/manten/send",
            type: "POST",
            //data : $("#frmCita").serialize()+"&id_medico="+id_medico+"&fecha_cita="+fecha_cita,
            data : $("#frmMantenimiento").serialize(),
            success: function (result) {
                    datatablenew();

                    $('#id_maestra').val("");
                    $('#id_parent').val("");
                    $('#tipo').val("");
                    $('#denominacion').val("");
                    $('#acronimo').val("");
                    $('#orden').val("");
                    $('#estado').val("A");
                    $('#var1').val("");
                    $('#var2').val("");
                    $('#var3').val("");
            }
    });

}

function obtenerBeneficiario(){

	var tipo_documento = $("#tipo_documento").val();
	var numero_documento = $("#numero_documento").val();
	var msg = "";

	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}

	$.ajax({
		url: '/persona/obtener_persona/' + tipo_documento + '/' + numero_documento,
		dataType: "json",
		success: function(result){
			var persona = result.persona;

			var nombre = persona.apellido_paterno+" "+persona.apellido_materno+", "+persona.nombres;
			$('#nombres').val(nombre);
			$('#telefono').val(persona.telefono);
			$('#email').val(persona.email);


		}

    });
}

