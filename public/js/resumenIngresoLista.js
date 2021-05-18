
$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
	
	//var datepicker = $.fn.datepicker.noConflict(); // return $.fn.datepicker to previously assigned value
	//$.fn.bootstrapDP = datepicker;
	$('#fecha_desde').datepicker({
        autoclose: true,
		//dateFormat: 'dd-mm-yy',
		format: 'dd-mm-yyyy',
		changeMonth: true,
		changeYear: true,
    });
	
	$('#fecha_hasta').datepicker({
        autoclose: true,
		//dateFormat: 'dd-mm-yy',
		format: 'dd-mm-yyyy',
		changeMonth: true,
		changeYear: true,
    });
	
	datatablenew();
	
});

function formato_miles(numero){
	
	return parseFloat(numero).toFixed(2).replace(/\D/g, "").replace(/([0-9])([0-9]{2})$/, '$1.$2').replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
}

function datatablenew(){
    var oTable1 = $('#tblAfiliado').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/reporte/listar_resumen_ingreso_ajax",
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
                       var strHtml = "<img id='" + strNameIdImg + "' src='/img/details_open.png' style='cursor:pointer;' title='Editar' onclick=fn_AbrirDetalle(" + rowIndex + ",'" + row.fac_fecha +"') />";
                       return strHtml;
                   },
                "bSortable": false,
                "aTargets": [0],
				"className": "dt-center",
                },
				{
                "mRender": function (data, type, row) {
                	var fac_fecha = "";
					if(row.fac_fecha!= null)fac_fecha = row.fac_fecha;
					return fac_fecha;
                },
                "bSortable": false,
                "aTargets": [1],
				"className": "dt-center",
                },
				{
                "mRender": function (data, type, row) {
                	var interes = "";
					if(row.interes!= null)interes = row.interes;
					//return parseFloat(interes).toFixed(2);
					return formato_miles(interes);
                },
                "bSortable": false,
                "aTargets": [2],
				"className": "text-right",
                },
				{
                "mRender": function (data, type, row) {
                	var capital_amortizado = "";
					if(row.capital_amortizado!= null)capital_amortizado = row.capital_amortizado;
					//return parseFloat(capital_amortizado).toFixed(2);
					return formato_miles(capital_amortizado);
                },
                "bSortable": false,
                "aTargets": [3],
				"className": "text-right",
                },
				/*{
                "mRender": function (data, type, row) {
                	var capital_vivo = "";
					if(row.capital_vivo!= null)capital_vivo = row.capital_vivo;
					return parseFloat(capital_vivo).toFixed(2);
                },
                "bSortable": false,
                "aTargets": [4],
				"className": "dt-center",
                },*/
				{
                "mRender": function (data, type, row) {
                	var facd_importe = "";
					if(row.facd_importe!= null)facd_importe = row.facd_importe;
					//return parseFloat(facd_importe).toFixed(2);
					return formato_miles(facd_importe);
                },
                "bSortable": false,
                "aTargets": [4],
				"className": "text-right",
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
		url: "/reporte/obtener_resumen_ingreso_fecha/"+piIdMovimientoCompra,
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		async :  "false",
		success: function (result) {
			
			//var sInicio = '<div style="float:left;width:50%"><div class="css_tituloInterno" style="margin:0px 0px 0px 30px">Cronograma</div>';
			var sInicio = ''; 
			sInicio += '<div class="col-lg-11 col-md-11 col-sm-12 col-xs-12" style="padding: 8px 8px 15px 30px;float:left"><table width="100%" id="' + vNombreSubDataTable + '" class="table table-hover table-sm">';
        	sInicio += '<thead>';
            sInicio += '<tr style="font-size:13px">';
            sInicio += '<th style="text-align: center;">Fecha Cuota</th>';
			sInicio += '<th style="text-align: center;">Nro Cuota</th>';
			sInicio += '<th style="text-align: center;">Apellidos y Nombres</th>';
			sInicio += '<th style="text-align: center;">Documento</th>';
            sInicio += '<th style="text-align: right;">Interes</th>';
			sInicio += '<th style="text-align: right;">Capital Amortizado</th>';
			//sInicio += '<th style="text-align: right;">Capital Vivo</th>';
			sInicio += '<th style="text-align: right;">Monto Pagado</th>';
            sInicio += '</tr>';
        	sInicio += '</thead>';
		
			var sIntermedio = '';
			var vImagen = "";
			$.each(result, function (index , value) {
				sIntermedio += '<tr style="font-size:13px">';
				sIntermedio +='<td>' + value.fecha_pago + '</td>';
				sIntermedio +='<td style="text-align: center;">' + value.nro_cuota + '</td>';
				sIntermedio +='<td>' + value.fac_destinatario + '</td>';
				sIntermedio +='<td>' + value.fac_cod_tributario + '</td>';
				//sIntermedio +='<td style="text-align: right;">' + parseFloat(value.interes).toFixed(2) + '</td>';
				sIntermedio +='<td style="text-align: right;">' + formato_miles(value.interes) + '</td>';
				//sIntermedio +='<td style="text-align: right;">' + parseFloat(value.capital_amortizado).toFixed(2) + '</td>';
				sIntermedio +='<td style="text-align: right;">' + formato_miles(value.capital_amortizado) + '</td>';
				//sIntermedio +='<td style="text-align: right;">' + parseFloat(value.capital_vivo).toFixed(2) + '</td>';
				//sIntermedio +='<td style="text-align: right;">' + (value.facd_importe!=null?parseFloat(value.facd_importe).toFixed(2):0) + '</td>';
				sIntermedio +='<td style="text-align: right;">' + (value.facd_importe!=null?formato_miles(value.facd_importe):0) + '</td>';
				sIntermedio +='</tr>';
			});
			
			var sFinal = '</table></div><div style="float:rigth"><input class="btn btn-success pull-rigth" value="Excel" type="button" onclick=reporteIndividualResumenIngreso("'+piIdMovimientoCompra+'") /></div></div>';
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

function reporteResumenIngreso(){
	
	var fecha_desde = $('#fecha_desde').val();
	var fecha_hasta = $('#fecha_hasta').val();
	
	if (fecha_desde == "")fecha_desde = 0;
	if (fecha_hasta == "")fecha_hasta = 0;
	
	location.href = '/reporte/exportar_resumen_ingreso/' + fecha_desde + '/' + fecha_hasta;
	
}

function reporteIndividualResumenIngreso(fecha){
	
	location.href = '/reporte/exportar_individual_resumen_ingreso/' + fecha;
	
}

