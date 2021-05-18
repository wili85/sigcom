<!--<link rel="stylesheet" href="<?php //echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">-->
<!--<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>-->
<!--
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
-->

<style type="text/css">
body {
    background-color: #bdc3c7;
}

.table-fixed {
    width: 100%;
    background-color: #f3f3f3;
}

.table-fixed tbody {
    height: 200px;
    overflow-y: auto;
    width: 100%;
}

.table-fixed thead,
.table-fixed tbody,
.table-fixed tr,
.table-fixed td,
.table-fixed th {
    display: block;
}

.table-fixed tbody td {
    float: left;
}

.table-fixed thead tr th {
    float: left;
    background-color: #f39c12;
    border-color: #e67e22;
}

/* Begin - Overriding styles for this page */
.card-body {
    padding: 0 1.25rem !important;
}

.form-control-sm {
    line-height: 1.1 !important;
    margin: 0 !important;
}

.form-group {
    margin-bottom: 0.5rem !important;
}

.breadcrumb {
    padding: 0.2rem 2rem !important;
    margin-bottom: 0 !important;
}

.card-header {
    padding: 0.2rem 1.25rem !important;
}

.pesajeIngreso {
    line-height: 2.8;
}

.fecha_ingreso_salida {
    color: blue;
    font-size: 14px;
    font-style: italic;
	float:left
}

br {
    line-height: 30px;
}

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type=number] {
    -moz-appearance: textfield;
}

ul.ui-autocomplete {
    z-index: 1100;
}

.btn-xsm {
    font-size: 11px !important;
}

/* End - Overriding styles for this page */
/*********************************************************/
.switch {
  position: relative;
  display: inline-block;
  width: 42px;
  height: 24px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 0px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.no {padding-right:3px;padding-left:0px;display:block;width:20px;float:left;font-size:11px;text-align:right;padding-top:5px}
.si {padding-right:0px;padding-left:3px;display:block;width:20px;float:left;font-size:11px;text-align:left;padding-top:5px}

.flotante {
    display:inline;
        position:fixed;
        bottom:0px;
        right:0px;
		z-index:1000
}
.flotanteC {
    display:inline;
        position:fixed;
        bottom:65px;
        right:0px;
}

label.form-control-sm{
	padding-left:0px!important;
	padding-right:0px;
	padding-top:5px!important;
	height:25px!important;
	/*line-height:10px!important*/
}
</style>

@stack('before-scripts')
@stack('after-scripts')

@extends('frontend.layouts.app2')

@section('title', app_name() . ' | ' . __('labels.frontend.afiliacion.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
    <!--<li class="breadcrumb-item text-primary">Inicio</li>-->
    <!--<li class="breadcrumb-item active">Configuraci&oacute;n de Colores</li>-->
	<li>
	<a class="btn btn-default" id="change-color-4">Barra SubTitulo</a>
    </li>
</ol>
@endsection

@section('content')
<!--
    <ol class="breadcrumb" style="padding-left:120px;margin-top:0px;background-color:#355C9D">
        <li class="breadcrumb-item text-primary">Inicio</li>
            <li class="breadcrumb-item active">Nueva Asistencia</li>
        </li>
    </ol>
    -->

<div class="justify-content-center">
    <!--<div class="container-fluid">-->
	<a class="btn btn-default" id="change-color-1" style="padding-left:30px;color:#FFFFFF">Fondo Principal</a>
    <div class="card">

        <div class="card-body" id="cardSecundario">
			
            <form class="form-horizontal" method="post" action="{{ route('frontend.solicitud.create')}}" id="frmSolicitud" autocomplete="off">
			
			<a class="btn btn-default" id="change-color-2">Fondo Secundario</a>
			
				<!--
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" style="margin-top:15px">
                        <h4 class="card-title mb-0 text-primary" style="font-size:22px">
                            Registro Solicitudes
                        </h4>
                    </div>
                </div>
				-->
                <div class="row justify-content-center" style="margin-top:15px">

                    <div class="col col-sm-12 align-self-center">


                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                        <input type="hidden" name="id_solicitud" id="id_solicitud" value="0">
						
					<div class="row">

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

						<div class="card">
						
						<div class="card-header" id="card-header">
							<strong><a class="btn btn-default" id="change-color-5">Card Titulo</a> </strong>
							<!--
							<div class="row">
								<div class="col-md-4 col-md-offset-2 well">
									<a class="btn btn-default" id="change-color">Actualizar Color Fondo</a> 
								</div>
							</div>	
							-->
						</div>
						
						<div class="card-body" id="card-body">
							<a class="btn btn-default" id="change-color-6">Card Cuerpo</a>
							
							<div class="table-responsive">
							<table id="tblSolicitud" class="table table-hover table-sm">
							<thead>
							<tr style="font-size:13px">
								<th><a class="btn btn-default" id="change-color-7">Tabla Titulo</a></th>
								<th>Titulo 2</th>
								<th>Titulo 3</th>
							</tr>
							</thead>
							<tbody>
								<tr>
									<td><a class="btn btn-default" id="change-color-8">Tabla Cuerpo</a></td>
									<td>Columna 2</td>
									<td>Columna 3</td>
								</tr>
								<tr>
									<td><a class="btn">Columna 1</a></td>
									<td>Columna 2</td>
									<td>Columna 3</td>
								</tr>
								<tr>
									<td><a class="btn">Columna 1</a></td>
									<td>Columna 2</td>
									<td>Columna 3</td>
								</tr>
							</tbody>
							</table>
							
							</div>
						</div>
						
						
						<!--
                        <div id="" class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">


                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                <br>

                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>

                        </div>
						-->
                    </div>

                </div>



        </div>
        <!--col-->

        </form>

        

    </div>
    <!--row-->
    @endsection

	<div id="openOverlayOpc" class="modal fade" role="dialog">
	  <div class="modal-dialog" >
	
		<div id="id_content_OverlayoneOpc" class="modal-content" style="padding: 0px;margin: 0px">
		
		  <div class="modal-body" style="padding: 0px;margin: 0px">
	
				<div id="diveditpregOpc"></div>
	
		  </div>
		
		</div>
	
	  </div>
		
	</div>

    @push('after-scripts')
	<script src="<?php echo URL::to('/') ?>/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js"></script>
	<link href="<?php echo URL::to('/') ?>/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css" rel="stylesheet">
	<script type="text/javascript">
	$(document).ready(function(){
		
		$('#change-color-1').colorpicker().on('changeColor', function(e) {
			console.log( e.color.toString('rgba'));
			var background_color = e.color.toString('rgba');
			
			$("body").attr("style","background-color:"+background_color+" !important");
			
			var _token = $('#_token').val();
			$.ajax({
				method: "POST",
				url: "/manten/send_color",
				data: { change_color:1, background: background_color,_token:_token},
				success: function(result){
				}
			})
			.done(function(response) {
			});		
		});
		
		$('#change-color-2').colorpicker().on('changeColor', function(e) {
			console.log( e.color.toString('rgba'));
			var background_color = e.color.toString('rgba');
			
			$("#cardSecundario").attr("style","background-color:"+background_color+" !important");
			
			var _token = $('#_token').val();
			$.ajax({
				method: "POST",
				url: "/manten/send_color",
				data: { change_color:2, background: background_color,_token:_token},
				success: function(result){
				}
			})
			.done(function(response) {
			});		
		});
		
		$('#change-color-3').colorpicker().on('changeColor', function(e) {
			console.log( e.color.toString('rgba'));
			var background_color = e.color.toString('rgba');
			
			$(".navbar").attr("style","background-color:"+background_color+" !important");
			
			var _token = $('#_token').val();
			$.ajax({
				method: "POST",
				url: "/manten/send_color",
				data: { change_color:3, background: background_color,_token:_token},
				success: function(result){
				}
			})
			.done(function(response) {
			});		
		});
		
		$('#change-color-4').colorpicker().on('changeColor', function(e) {
			console.log( e.color.toString('rgba'));
			var background_color = e.color.toString('rgba');
			
			$(".breadcrumb").attr("style","background-color:"+background_color+" !important");
			
			var _token = $('#_token').val();
			$.ajax({
				method: "POST",
				url: "/manten/send_color",
				data: { change_color:4, background: background_color,_token:_token},
				success: function(result){
				}
			})
			.done(function(response) {
			});		
		});
		
		$('#change-color-5').colorpicker().on('changeColor', function(e) {
			console.log( e.color.toString('rgba'));
			var background_color = e.color.toString('rgba');
			
			$("#card-header").attr("style","background-color:"+background_color+" !important");
			$("#card-header .row div").attr("style","background-color:"+background_color+" !important");
			
			var _token = $('#_token').val();
			$.ajax({
				method: "POST",
				url: "/manten/send_color",
				data: { change_color:5, background: background_color,_token:_token},
				success: function(result){
				}
			})
			.done(function(response) {
			});		
		});
		
		$('#change-color-6').colorpicker().on('changeColor', function(e) {
			console.log( e.color.toString('rgba'));
			var background_color = e.color.toString('rgba');
			
			$("#card-body").attr("style","background-color:"+background_color+" !important");
			$("#card-body .row").attr("style","background-color:"+background_color+" !important");
			
			var _token = $('#_token').val();
			$.ajax({
				method: "POST",
				url: "/manten/send_color",
				data: { change_color:6, background: background_color,_token:_token},
				success: function(result){
				}
			})
			.done(function(response) {
			});		
		});
		
		$('#change-color-7').colorpicker().on('changeColor', function(e) {
			console.log( e.color.toString('rgba'));
			var background_color = e.color.toString('rgba');
			
			$("#tblSolicitud th").attr("style","background-color:"+background_color+" !important");
			
			var _token = $('#_token').val();
			$.ajax({
				method: "POST",
				url: "/manten/send_color",
				data: { change_color:7, background: background_color,_token:_token},
				success: function(result){
				}
			})
			.done(function(response) {
			});		
		});
		
		$('#change-color-8').colorpicker().on('changeColor', function(e) {
			console.log( e.color.toString('rgba'));
			var background_color = e.color.toString('rgba');
			
			$("#tblSolicitud td").attr("style","background-color:"+background_color+" !important");
			
			var _token = $('#_token').val();
			$.ajax({
				method: "POST",
				url: "/manten/send_color",
				data: { change_color:8, background: background_color,_token:_token},
				success: function(result){
				}
			})
			.done(function(response) {
			});		
		});
		
	});
	</script>
    @endpush