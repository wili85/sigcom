<!--<link rel="stylesheet" href="<?php //echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">-->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>

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

@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.contact.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
        <li class="breadcrumb-item text-primary">Producci&oacute;n</li>
            <li class="breadcrumb-item active">Consulta de Producci&oacute;nes</li>
        </li>
    </ol>
@endsection

@section('content')

    <!--<ol class="breadcrumb" style="padding-left:120px;margin-top:0px">
        <li class="breadcrumb-item text-primary">Inicio</li>
            <li class="breadcrumb-item active">Consulta de Afiliados</li>
        </li>
    </ol>
    -->
    <div class="justify-content-center">
        
        <div class="card">

        <div class="card-body">

        <div class="row justify-content-center" style="margin-top:15px">
        
        <div class="col col-sm-12 align-self-center">
			
            <div class="card">
                <div class="card-header">
                    <strong>
                        Lista de Producci&oacute;nes
                    </strong>
                </div><!--card-header-->
				
				<form class="form-horizontal" method="post" action="{{ route('frontend.contact.send')}}" id="frmAfiliacion" autocomplete="off">
				<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
				
				<div class="row" style="padding:10px 20px 10px 20px;">
					
					<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
						<input class="form-control form-control-sm" id="numero_documento" name="numero_documento" placeholder="Doc. Identidad">
					</div>
					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<input class="form-control form-control-sm" id="afiliado" name="afiliado" placeholder="Apellidos y Nombres">
					</div>
					
					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
						<input class="form-control form-control-sm" id="fecha_desde" name="fecha_desde" placeholder="Fecha Desde">
					</div>
					
					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
						<input class="form-control form-control-sm" id="fecha_hasta" name="fecha_hasta" placeholder="Fecha Hasta">
					</div>
					
					<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
						<select name="id_estado" id="id_estado" class="form-control form-control-sm">
							<option value="0">Todos los estados</option>
							<option value="1">Pendiente</option>
							<option value="2">En Proceso</option>
							<option value="3">Finalizado</option>
						</select>
					</div>
					
					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
						<input class="btn btn-warning pull-rigth" value="Buscar" type="button" id="btnBuscar" />
					</div>
					
					
					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
						<input class="btn btn-success pull-rigth" value="Excel" type="button" id="btnExcel" onclick="reporteConsolidado()"/>
					</div>
					
				</div>
				
                <div class="card-body">		

                    <div class="table-responsive">
                    <table id="tblAfiliado" class="table table-hover-grid table-sm">
                        <thead>
                        <tr style="font-size:13px">
							<th>Cod</th>
							<th>Fecha</th>
							<th>Apellidos y Nombres</th>
							<th>Documento</th>
							<th>Producto</th>
							<th>Unnidad</th>
							<th style="width:50px" class="text-right">Cantidad</th>
							<th class="text-right">Precio</th>
							<th class="text-right">Total</th>
                            <th class="text-center">Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div><!--table-responsive-->
                </form>



                </div><!--card-body-->
            </div><!--card-->
        <!--</div>--><!--col-->
    <!--</div>--><!--row-->

@endsection

@push('after-scripts')
{!! script(asset('js/produccionLista.js')) !!}
@endpush
