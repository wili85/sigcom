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

@stack('before-scripts')
@stack('after-scripts')

@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.afiliacion.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
    <li class="breadcrumb-item text-primary">Inicio</li>
    <li class="breadcrumb-item active">Ingreso de Vehículos</li>
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

    <div class="card">

        <div class="card-body">

            <form class="form-horizontal" method="post" action="{{ route('frontend.solicitud.create_cronograma')}}" id="frmSolicitud" autocomplete="off">
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
                                <div id="" class="row">
                                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">

                                        <div class="card">
                                            <div class="card-header">
                                                <div id="" class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <strong>
                                                            <!--@lang('labels.frontend.asistencia.box_asistencia')-->
                                                            Datos Coronográma
                                                        </strong>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-body" style="margin-top:15px;margin-bottom:15px">
											
												<div style="clear:both"></div>
                                                <div id="" class="row">
													
													<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">Valor Préstamo</label>
														<input type="text" name="valor_prestamo" id="valor_prestamo"
															value="" placeholder="" class="form-control form-control-sm" onblur="obtenerBeneficiario()">
													</div>
													
													<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">TNA (30/360)</label>
														<input type="text" name="tna" id="tna"
															value="" placeholder="" class="form-control form-control-sm" onblur="obtenerBeneficiario()">
													</div>
													
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">Años</label>
														<input type="text" name="anios" id="anios"
															value="" placeholder="" class="form-control form-control-sm" onblur="obtenerBeneficiario()">
													</div>                                                    
													
													<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">Frecuencia Pago</label>
														<select name="frecuencia_pago" id="frecuencia_pago" class="form-control form-control-sm">
                                                        <?php foreach($periodo as $row):?>
															<option value="<?php echo $row->id?>"><?php echo $row->denominacion?></option>
															<?php endforeach;?>
														</select>
													</div>
				
                                                </div>
												<div style="clear:both"></div>

                                                <div class="row">

													<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">Interés equivalente</label>
														<input type="text" name="interes" id="interes"
															value="" placeholder="" class="form-control form-control-sm" disabled="disabled" />
													</div>
													
													<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">N° de pagos por año</label>
														<input type="text" name="nro_pagos_anio" id="nro_pagos_anio" value="" placeholder=""
															class="form-control form-control-sm" readonly="readonly" >
													</div>
													
													<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">N° Total de Cuotas</label>
														<input type="text" name="total_couta" id="total_couta"
															value="" placeholder="" class="form-control form-control-sm" disabled="disabled" />
													</div>

                                                </div>
												
												<div style="clear:both"></div>

                                            </div>
                                            <!--card-body-->
                                        </div>
                                        <!--card-->
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">

                                        <div class="card">
                                            <div class="card-header">
                                                <div id="" class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <strong>
                                                            <!--@lang('labels.frontend.asistencia.box_asistencia')-->
                                                            Datos Coronográma
                                                        </strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body" style="margin-top:15px;margin-bottom:15px">
											
                                            <div style="clear:both"></div>
                                            <div id="" class="row">
                                                                                                   
                                                
                                                    <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">Interés equivalente</label>
														<input type="text" name="interes" id="interes"
															value="" placeholder="" class="form-control form-control-sm" disabled="disabled" />
													</div>
													
													<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">N° de pagos por año</label>
														<input type="text" name="nro_pagos_anio" id="nro_pagos_anio" value="" placeholder=""
															class="form-control form-control-sm" readonly="readonly" >
													</div>
            
                                            </div>
                                            <div style="clear:both"></div>

                                            <div class="row">

                                                    <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">N° Total de Cuotas</label>
														<input type="text" name="total_couta" id="total_couta"
															value="" placeholder="" class="form-control form-control-sm" disabled="disabled" />
													</div>
                                                

                                            </div>
                                            
                                            <div style="clear:both"></div>

                                        </div>
                                            <!--card-body-->
                                        </div>
                                        <!--card-->
                                    </div>

                                </div>
                            </div>
                        </div>						
					<div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                    
                            <div class="card">
                                <div class="card-header">
                                    <strong>
                                        <!--@lang('labels.frontend.asistencia.box_asistencia')-->
                                        Resumen
                                    </strong>
                                </div>

                                <div class="card-body">

                                    <div class="table-responsive overflow-auto" style="max-height: 500px;">
                                    
                                        <div style="display:none">
                                            <select class="form-control" id="idTipoGarantiaTemp">
                                                <?php foreach($tipo as $row):?>
                                                <option value="<?php echo $row->id?>"><?php echo $row->denominacion?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <!--
                                            <select class="form-control" id="idMedidaTemp" tabindex="16" style="width: 500px">
                                                <option value="">Seleccionar</option>
                                                <?php //foreach($medida as $row):?>
                                                <option value="<?php //echo $row->id?>"><?php //echo $row->denominacion?></option>
                                                <?php //endforeach;?>
                                            </select>
                                            -->
                                        </div>
                                        
                                        @hasanyrole('evaluador')
                                            <button type="button" id="addRow" style="margin-left:10px" class="btn btn-info btn-sm btn-xs"><i class="fa fa-plus"></i> Agregar garantia(s)</button>
                                        @else
                                        @endhasanyrole

                                        <table id="tblProductos" class="table table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th width="15%">Tipo</th>
                                                    <th width="35%">Descripcion</th>
                                                    <!--<th width="15%">Moneda</th>-->
                                                    <th width="15%">Valor</th>
                                                    @hasanyrole('valorizador')
                                                    <th width="15%">Valorizar</th>
                                                    @endhasanyrole
                                                    <!--<th width="10%">Eliminar</th>-->
                                                    <!--
                                                    <th>Producto</th>
                                                    <th>Medida</th>
                                                    <th>%</th>
                                                    <th>Peso Aprox.</th>
                                                    <th>Eliminar</th>
                                                    -->
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                   
                                    <a class='flotante' name="guardar" id="guardar" onclick="guardarSolicitud()" href='#' ><img src='/img/btn_save.png' border="0"/></a>

                                </div>
                                <!--card-body-->
                            </div>
                            <!--card-->
                        </div>
                        <!--card-->
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
    {!! script(asset('js/solicitud.js')) !!}
    @endpush