<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<!--<script src="<?php echo URL::to('/') ?>/js/manifest.js"></script>
<script src="<?php echo URL::to('/') ?>/js/vendor.js"></script>
<script src="<?php echo URL::to('/') ?>/js/frontend.js"></script>-->
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
            <li class="breadcrumb-item active">Nuevo Ingreso</li>
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

            <form class="form-horizontal" method="post" action="{{ route('frontend.factura.create')}}" id="frmValorizacion" name="frmValorizacion" autocomplete="off" >
                <!--
                <div class="row">
                    <div class="col-sm-12">
					
						<div class="row">
                        	<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top:15px">
								<h4 class="card-title mb-0 text-primary">
									Estado de cuenta
								</h4>
							</div>
							
						</div>
						
                    </div>
                </div>
				-->
        <div class="row justify-content-center" style="margin-top:15px">
        
        <div class="col col-sm-12 align-self-center">

        <!--<form class="form-horizontal" method="post" action="{{ route('frontend.factura.create')}}" id="frmValorizacion" name="frmValorizacion" autocomplete="off" >-->
            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
            
            <div class="row">

            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">

            <div class="card">
                <div class="card-header">
                    <strong>
                        Datos de la Persona
                    </strong>
                </div>
               
                <div class="card-body">
                    <input type='hidden' name='txt_IdEmpresa' id="txt_IdEmpresa" value='{{Auth::user()->IdEmpresa}}'>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <?php ?>
                                <label class="form-control-sm">Tipo Documento</label> 
                                <select name="tipo_documento" id="tipo_documento" class="form-control form-control-sm" onchange="validaTipoDocumento()">
                                    <option value="<?php echo $persona::TIPO_DOCUMENTO_DNI?>"><?php echo $persona::TIPO_DOCUMENTO_DNI?></option>
                                    <option value="<?php echo $persona::TIPO_DOCUMENTO_CARNET_EXTRANJERIA?>"><?php echo $persona::TIPO_DOCUMENTO_CARNET_EXTRANJERIA?></option>
                                    <option value="<?php echo $persona::TIPO_DOCUMENTO_PASAPORTE?>"><?php echo $persona::TIPO_DOCUMENTO_PASAPORTE?></option>
                                    <option value="<?php echo $persona::TIPO_DOCUMENTO_RUC?>"><?php echo $persona::TIPO_DOCUMENTO_RUC?></option>
									<option value="<?php echo $persona::TIPO_DOCUMENTO_CEDULA?>"><?php echo $persona::TIPO_DOCUMENTO_CEDULA?></option>
									<option value="<?php echo $persona::TIPO_DOCUMENTO_PTP?>"><?php echo $persona::TIPO_DOCUMENTO_PTP?></option>
                                </select>

                                <input type="hidden" readonly name="empresa_id" id="empresa_id" value="" class="form-control form-control-sm">
								<input type="hidden" readonly name="id_ubicacion" id="id_ubicacion" value="" class="form-control form-control-sm">
								<input type="hidden" readonly name="persona_id" id="persona_id" value="" class="form-control form-control-sm">

                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-control-sm">N° Documento</label>
                                <input type="text" name="numero_documento" id="numero_documento" onblur="obtenerBeneficiario()" value="{{old('clinum')}}"  placeholder="" class="form-control form-control-sm" />
                            </div>
                        </div>
                    </div>

                    <div class="row" id="divNombreApellido">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-control-sm">Nombres y Apellidos</label>
                                <input type="text" readonly name="nombre_afiliado" id="nombre_afiliado" value="{{old('clinom')}}" class="form-control form-control-sm" />
                            </div>
                        </div>
                    </div>

                    <div class="row" id="divCodigoAfliado">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-control-sm">Afiliado</label>
                                <input type="text" readonly name="codigo_afiliado" id="codigo_afiliado" value="{{old('clinom')}}" class="form-control form-control-sm" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-control-sm">Empresa</label>
                                <input type="text" readonly name="empresa_afiliado" id="empresa_afiliado" value="{{old('clinom')}}" class="form-control form-control-sm" />
                        </div>
                        </div>
                    </div>

                    <div class="row" id="divDireccionEmpresa" style="display:none">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-control-sm">Direcci&oacute;n</label>
                                <input type="text" readonly name="empresa_direccion" id="empresa_direccion" value="{{old('clinom')}}" class="form-control form-control-sm">
								
                        </div>
                        </div>
                    </div>

                    <div class="row" id="divRepresentanteEmpresa" style="display:none">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-control-sm">Representante</label>
                                <input type="text" readonly name="empresa_representante" id="empresa_representante" value="{{old('clinom')}}" class="form-control form-control-sm">
                        </div>
                        </div>
                    </div>

                    <div class="row" id="divFechaAfliado">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-control-sm">Fecha Afiliacion</label>
                                <input type="text" readonly name="fecha_afiliado" id="fecha_afiliado" value="{{old('clinom')}}" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>

                    <!--</div>-->
                    
                

                </div>
           
            </div>
            </div>

                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" style="padding:0px">

                    <div class="card">
                        <div class="card-header">
                            <strong>
                                <!--@lang('labels.frontend.asistencia.box_asistencia')-->
                                Registro de Estado de Cuenta
								@hasanyrole('administrator')
								<!--<input class="btn btn-warning btn-sm pull-right" value="DUDOSO" type="button" id="btnEstado" onclick="guardarEstado('D')" style="margin-left:20px" />-->
								@endhasanyrole
                            </strong>
                        </div>

                        <div class="card-body">
                
                            <!--
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group form-group-sm">
                                        <label>Area</label>
                                        <select name="tdicod" id="tdicod" class="form-control">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                            -->

                            <div class="table-responsive" style="padding-top:15px;">
                                <table id="tblValorizacion" class="table table-hover table-sm">
                                    <thead>
                                    <tr style="font-size:13px">
										<!--<th class="text-right" width="5%">-->
										<th style="text-align: center; padding-bottom:0px;padding-right:5px;margin-bottom: 0px; vertical-align: middle">
                                        	<input type="checkbox" name="select_all" value="1" id="example-select-all" style="display:none">
										</th>
										<!--<th>Prestamo</th>-->
										<th>Num Cuota</th>
										<th>Cod. Sol.</th>
                                        <th>Fecha Pago</th>
										<th>Interes</th>
										<th>Capital Amortizado</th>
                                        <th>Capital Vivo</th>
										<th class="text-right">Cuota Pagar</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                            
                                        <!--<tr>
                                            <td colspan="11" class="text-center">
                                                <span class="badge badge-default">{{ __('log-viewer::general.empty-logs') }}</span>
                                            </td>
                                        </tr>
                                        -->
                                    </tbody>
									<tfoot>
										<tr>
											<!--<td colspan="7" style="text-align:right;padding-right:55px!important;padding-bottom:0px;margin-bottom:0px">Pago a Cuenta</td>-->
											<td colspan="4">&nbsp;</td>
											<th colspan="3" style="text-align:right;padding-right:55px!important;padding-bottom:0px;margin-bottom:0px;font-size:13px">Pago a Cuenta</th>
											<td style="padding-bottom:0px;margin-bottom:0px">
												<input type="text" readonly name="MonAd" id="MonAd" value="0" class="form-control form-control-sm text-right" onkeyup="validarMonAd()"/>
											</td>
										</tr>
										<tr>
											<!--<td colspan="7" style="text-align:right;padding-right:55px!important;padding-bottom:0px;margin-bottom:0px">Total a Pagar</td>-->
											<td colspan="4">&nbsp;</td>
											<th colspan="3" style="text-align:right;padding-right:55px!important;padding-bottom:0px;margin-bottom:0px;font-size:13px">Total a Pagar</th>
											<td style="padding-bottom:0px;margin-bottom:0px">
												<input type="text" readonly name="total" id="total" value="0" class="form-control form-control-sm text-right">
											</td>
										</tr>
									</tfoot>
                                </table>
                            </div><!--table-responsive-->

                            <div class="row" style="padding-bottom:15px;">
                                <div class="col">
                                    <div class="form-group mb-0 clearfix">
                                    
								<input type="hidden" name="TipoF" id="TipoF" value="" />
								<input type="hidden" name="Trans" id="Trans" value="FA" />
								<!--<input class="btn btn-success pull-rigth" value="FACTURA" type="button" id="btnFactura" disabled="disabled" onclick="enviarTipo(1)" />-->
								<input class="btn btn-info pull-rigth" value="TICKET" type="button" id="btnBoleta" disabled="disabled" onclick="enviarTipo(2)" />
								<input class="btn btn-info pull-rigth" value="TICKET" type="button" id="btnTicket" disabled="disabled" onclick="enviarTipo(3)" style="display:none" />
						
						
                                    <!--<input class="btn btn-primary pull-right" value="BOLETA" name="crea" type="button" form="prestacionescrea" id="btnGuardar" onclick="guardarValorizacion()" />-->
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->
						
						
                        </div><!--card-body-->
                    </div><!--card-->
					
					
					<br />
					<div class="card" style="display:none">
                        <div class="card-header">
                            <strong>
                                Estado de Cuenta Dudoso
								@hasanyrole('administrator')
								<input class="btn btn-warning btn-sm pull-right" value="ACTIVAR" type="button" id="btnEstado" onclick="guardarEstado('A')" style="margin-left:20px" />
								@endhasanyrole
                            </strong>
                        </div>

                        <div class="card-body">
							
							<!--
							<div class="row">
                                <div class="col">
                                    <div class="form-group mb-0 clearfix">
									<input class="btn btn-success pull-rigth" value="ACTIVAR" type="button" id="btnEstado" onclick="guardarEstado()" />
                                    </div>
                                </div>
                            </div>
							-->
							
							<div class="table-responsive" style="padding-top:15px">
                                <table id="tblDudoso" class="table table-hover table-sm">
                                    <thead>
                                    <tr style="font-size:13px">
										<th style="text-align: center; padding-bottom:0px;padding-right:5px;margin-bottom: 0px; vertical-align: middle">
                                        	<input type="checkbox" name="select_all" value="1" id="example-select-all" style="display:none">
										</th>
										<th>Fecha</th>
                                        <th>Concepto</th>
                                        <th class="text-right">Monto</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
									<tfoot>
										<tr>
											<td colspan="3" style="text-align:right;padding-right:55px!important;padding-bottom:0px;margin-bottom:0px">Deuda Total</td>
											<td style="padding-bottom:0px;margin-bottom:0px">
												<input type="text" readonly name="total_dudoso" id="total_dudoso" value="0" class="form-control form-control-sm text-right">
											</td>
										</tr>
									</tfoot>
                                </table>
                            </div><!--table-responsive-->
							
						</div>
						
					</div>
					
					

                </div>

                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">

                    <div class="card">
                        <div class="card-header">
                            <strong>
                                <!--@lang('labels.frontend.asistencia.box_asistencia')-->
                                Registro de Pagos
                            </strong>
                        </div>

                        <div class="card-body">
                
                            <!--<div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group form-group-sm">
                                        <label>Area</label>
                                        <select name="tdicod" id="tdicod" class="form-control">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                            -->
                            <div class="table-responsive" style="padding-top:15px">
                                <table id="tblPago" class="table table-hover table-sm">
                                    <thead>
                                    <tr style="font-size:13px">
										<th>Fecha</th>
										<!--<th>Tipo</th>-->
										<th>Serie</th>
										<th>Numero</th>
										<th>Concepto</th>
                                        <th class="sum">Monto</th>
										<th>Pago</th>
										<th>Deuda</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div><!--table-responsive-->
                            

                            
                        
                        </div><!--card-body-->
                    </div><!--card-->

                </div>

            </div>

            

        </div><!--col-->

        </form>

    </div><!--row-->
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
<script type="text/javascript">
//var id_caja_usuario = "<?php //echo ($caja_usuario)?$caja_usuario->id_caja:0?>";
//alert(id_caja_usuario);
</script>
{!! script(asset('js/ingreso.js')) !!}
    @if(config('access.captcha.contact'))
        @captchaScripts
    @endif
@endpush