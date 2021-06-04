
$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
	
	$('#fecha_desde').datepicker({
        autoclose: true,
		//dateFormat: 'dd-mm-yy',
		format: 'dd/mm/yyyy',
		changeMonth: true,
		changeYear: true,
    });
	
	$('#fecha_hasta').datepicker({
        autoclose: true,
		//dateFormat: 'dd-mm-yy',
		format: 'dd/mm/yyyy',
		changeMonth: true,
		changeYear: true,
    });
	
	datatablenew();
	
});

function datatablenew(){
    var oTable1 = $('#tblAfiliado').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/venta/listar_venta_ajax",
        "bProcessing": true,
        "sPaginationType": "full_numbers",
        //"paging":false,
        "bFilter": false,
        "bSort": false,
        "info": true,
		//"responsive": true,
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
			
			var afiliado = $('#afiliado').val();
            var numero_documento = $('#numero_documento').val();
            var fecha_desde = $('#fecha_desde').val();
			var fecha_hasta = $('#fecha_hasta').val();
			var id_estado = $('#id_estado').val();
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						afiliado:afiliado,numero_documento:numero_documento,fecha_desde:fecha_desde,fecha_hasta:fecha_hasta,id_estado:id_estado,
						_token:_token
                       },
                "success": function (result) {
                    fnCallback(result);
                },
                "error": function (msg, textStatus, errorThrown) {
                    //location.href="login";
                }
            });
        },

        "aoColumnDefs":
            [	
			 	{
                "mRender": function (data, type, row) {
                       var rowIndex = oTable1.fnGetData().length - 1;
                       var strNameIdImg = 'ima_1_' + rowIndex;
                       var strHtml = "<img id='" + strNameIdImg + "' src='/img/details_open.png' style='cursor:pointer;' title='Editar' onclick='javascript:fn_AbrirDetalle(" + rowIndex + "," + row.id +")'/>";
                       return strHtml;
                   },
                "bSortable": false,
                "aTargets": [0],
				"className": "dt-center",
                },
				{
                "mRender": function (data, type, row) {
                	var fecha = "";
					if(row.fecha!= null)fecha = row.fecha;
					return fecha;
                },
                "bSortable": false,
                "aTargets": [1],
				"className": "dt-center",
                },
				{
                "mRender": function (data, type, row) {
                	var persona = "";
					if(row.persona!= null)persona = row.persona;
					return persona;
                },
                "bSortable": false,
                "aTargets": [2],
				"className": "dt-center",
                },
				{
                "mRender": function (data, type, row) {
                	var numero_documento = "";
					if(row.numero_documento!= null)numero_documento = row.numero_documento;
					return numero_documento;
                },
                "bSortable": false,
                "aTargets": [3],
				"className": "dt-center",
                },
				{
                "mRender": function (data, type, row) {
                	var destino = "";
					if(row.destino!= null)destino = row.destino;
					return destino;
                },
                "bSortable": false,
                "aTargets": [4],
				"className": "dt-center",
                },
				{
                "mRender": function (data, type, row) {
                	var producto = "";
					if(row.producto!= null)producto = row.producto;
					return producto;
                },
                "bSortable": false,
                "aTargets": [5],
				"className": "dt-center",
                },
				{
                "mRender": function (data, type, row) {
                	var unidad = "";
					if(row.unidad!= null)unidad = row.unidad;
					return unidad;
                },
                "bSortable": false,
                "aTargets": [6],
				"className": "dt-center",
                },
                {
                "mRender": function (data, type, row) {
					var cantidad = "";
					if(row.cantidad!= null)cantidad = row.cantidad;
					return cantidad;
                },
                "bSortable": false,
                "className": "text-right",
                "aTargets": [7],
                },
                {
                "mRender": function (data, type, row) {
                	var precio = "";
					if(row.precio!= null)precio = row.precio;
					return parseFloat(precio).toFixed(2);
                },
                "bSortable": false,
                "aTargets": [8],
				"className": 'text-right',
                },
				{
                "mRender": function (data, type, row) {
                	var total = "";
					if(row.total!= null)total = row.total;
					return parseFloat(total).toFixed(2);
                },
                "bSortable": false,
                "aTargets": [9],
				"className": 'text-right',
                },
				{
                "mRender": function (data, type, row) {
                    var estado = "";
					if(row.estado!= null)estado = row.estado;
					return estado;
                },
                "bSortable": false,
                "aTargets": [10],
				"className": 'text-center',
                },
				
            ]


    });

}

function fn_ListarBusqueda() {
    datatablenew();
};

function fn_AbrirDetalle(pValor, piIdMovimientoCompra) {
    //fn_util_bloquearPantalla("Buscando");
    setTimeout(function () { fn_CargaSuGrilla(pValor, piIdMovimientoCompra) }, 500);
}

function fn_CargaSuGrilla(pValor, piIdMovimientoCompra) {

    var iRow = pValor;


    var tr = $("#ima_1_" + iRow).closest('tr');
    var row = $("#tblAfiliado").DataTable().row(tr);

    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');


        $("#ima_1_" + iRow).attr("src", "/img/details_open.png");
    } else {
        $("#ima_1_" + iRow).attr("src", "/img/details_close.png");

        var iNumeroLinea = $("#lbl_0_" + pValor).text();
        var iCodigoOficina = $("#lbl_1_" + pValor).text();

        var vNombreSubGrilla = "SubGrd" + iRow;
		//var vNombreSubGrilla2 = "SubGrd2" + iRow;
        fn_DevuelveSubGrilla(piIdMovimientoCompra, vNombreSubGrilla,row,tr);
        
    }

    //fn_util_desbloquearPantalla();
}

function fn_DevuelveSubGrilla(piIdMovimientoCompra, vNombreSubDataTable,row,tr) {
	
	$.ajax({
		type: "GET",
		url: "/reporte/obtener_solicitud_cronograma/"+piIdMovimientoCompra,
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		async :  "false",
		success: function (result) {
			
			//var sInicio = '<div style="float:left;width:50%"><div class="css_tituloInterno" style="margin:0px 0px 0px 30px">Cronograma</div>';
			var sInicio = ''; 
			sInicio += '<div class="col-lg-11 col-md-11 col-sm-12 col-xs-12" style="padding: 8px 8px 15px 30px;float:left"><table width="100%" id="' + vNombreSubDataTable + '" class="table table-hover table-sm">';
        	sInicio += '<thead>';
            sInicio += '<tr style="font-size:13px">';
            sInicio += '<th style="text-align: center;">Cuota</th>';
            sInicio += '<th style="text-align: center;">Fecha Pago</th>';
            sInicio += '<th style="text-align: right;">Cuota Pagar</th>';
			sInicio += '<th style="text-align: right;">Interes</th>';
			sInicio += '<th style="text-align: right;">Capital Amortizado</th>';
			sInicio += '<th style="text-align: right;">Capital Vivo</th>';
			sInicio += '<th style="text-align: right;">Monto Pagado</th>';
			sInicio += '<th style="text-align: center;">Estado</th>';
            sInicio += '</tr>';
        	sInicio += '</thead>';
		
			var sIntermedio = '';
			var vImagen = "";
			$.each(result, function (index , value) {
				var facturado = "PENDIENTE";
				if(value.facturado=='S')facturado = "PAGADO";
				sIntermedio += '<tr style="font-size:13px">';
				sIntermedio +='<td style="text-align: center;">' + value.nro_cuota + '</td>';
				sIntermedio +='<td>' + value.fecha_pago + '</td>';
				sIntermedio +='<td style="text-align: right;">' + parseFloat(value.cuota_pagar).toFixed(2) + '</td>';
				sIntermedio +='<td style="text-align: right;">' + parseFloat(value.interes).toFixed(2) + '</td>';
				sIntermedio +='<td style="text-align: right;">' + parseFloat(value.capital_amortizado).toFixed(2) + '</td>';
				sIntermedio +='<td style="text-align: right;">' + parseFloat(value.capital_vivo).toFixed(2) + '</td>';
				sIntermedio +='<td style="text-align: right;">' + (value.facd_importe!=null?parseFloat(value.facd_importe).toFixed(2):0) + '</td>';
				sIntermedio +='<td style="text-align: center;">' + facturado + '</td>';
				sIntermedio +='</tr>';
			});
			
			var sFinal = '</table></div><div style="float:rigth"><input class="btn btn-success pull-rigth" value="Excel" type="button" onclick="reporteIndividual('+piIdMovimientoCompra+')"/></div></div>';
			var sResultado = sInicio + sIntermedio + sFinal;
			
			row.child(sResultado).show();
        	fn_Datatable_Cast(vNombreSubDataTable);
        	tr.addClass('shown');
	
		},
		error: function (resultado) {
			var error = "Ocurrio un Error";
			//parent.fn_util_MuestraMensaje(error, "E");
		
		}
	});
	    
}

function fn_Datatable_Cast(vNombreSubGrilla) {

    $("#" + vNombreSubGrilla).dataTable({
        bDestroy: true,
        bFilter: false,
        bSort: false,
        bLengthChange: false,
        bPaginate: false,
        bInfo: false,
        aoColumnDefs: [
            {
                "sWidth": "80px",
                "aTargets": [0]
            },
			{
				"sClass": "center",
                "sWidth": "150px",
                "aTargets": [1]
            },
			/*
			{
				"sClass": "right",
                "sWidth": "100px",
                "aTargets": [3]
            },
			{
				"sClass": "right",
                "sWidth": "100px",
                "aTargets": [4]
            },
			{
				"sClass": "right",
                "sWidth": "100px",
                "aTargets": [5]
            }
		*/
        ]
		
    });

    //fn_util_LineaDatatable("#tbaDetalleSolicitud");
}

function reporteConsolidado(){
	
	var afiliado = $('#afiliado').val();
	var numero_documento = $('#numero_documento').val();
	var fecha_desde = $('#fecha_desde').val();
	var fecha_hasta = $('#fecha_hasta').val();
	var id_estado = $('#id_estado').val();
	
	if (afiliado == "")afiliado = 0;
	if (numero_documento == "")numero_documento = 0;
	if (fecha_desde == "")fecha_desde = 0;
	if (fecha_hasta == "")fecha_hasta = 0;
	if (id_estado == "")id_estado = 0;
	
	location.href = '/reporte/exportar_consolidado/' + numero_documento + '/' + afiliado + '/' + fecha_desde + '/' + fecha_hasta + '/' + id_estado;
	
}

function reporteIndividual(id){
	
	location.href = '/reporte/exportar_individual/' + id;
	
}

