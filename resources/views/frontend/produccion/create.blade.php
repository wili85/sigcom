<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<link rel="stylesheet" type="text/css"
    href="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<script src="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

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
</style>

@stack('before-scripts')
@stack('after-scripts')

@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.afiliacion.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
    <li class="breadcrumb-item text-primary">Producci&oacute;n</li>
    <li class="breadcrumb-item active">Nueva Producci&oacute;n</li>
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
		
			<form class="form-horizontal" method="post" action="{{ route('frontend.factura.create')}}" id="frmPesajeCarreta" name="frmPesajeCarreta" autocomplete="off" >

            <div class="row" style="margin-top:15px">
                <!--<div class="col-sm-5">-->
				<!--
				<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top:15px">
                    <h4 class="card-title mb-0 text-primary" style="font-size:22px">
                        Registro Carreta
                    </h4>
                </div>
				-->
				<?php
				$readonly='';
				$saldo_inicial = "";
				$total_recaudado = "";
				$saldo_total = "";
				$disabled="";
				?>
				
				
            </div>

            <div class="row justify-content-center">

                <div class="col col-sm-12 align-self-center">
					
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        <!--
            <div class="card">
                <div class="card-header">
                    <strong>
                        @lang('labels.frontend.asistencia.box_title')
                    </strong>
                </div>
               
                <div class="card-body">
                    <input type='hidden' name='txt_IdEmpresa' id="txt_IdEmpresa" value='{{Auth::user()->IdEmpresa}}'>
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group form-group-sm">
                                <label>Tipo Documento</label>
                                <select name="tdicod" id="tdicod" class="form-control">
                                    <option></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group form-group-sm">
                                <label for="clinum">N° Documento</label>
                                <input type="text"  name="clinum" id="clinum" value="{{old('clinum')}}"  placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group form-group-sm">
                                <label>Nombres y Apellidos</label>
                                <input type="text" name="clinom" id="clinom" value="{{old('clinom')}}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group form-group-sm">
                                <label>Empresa</label>
                                <input name="clidir" id="clidir" value="{{old('clidir')}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group form-group-sm">
                                <label>Afiliado</label>
                                <input name="clidir" id="clidir" value="{{old('clidir')}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group form-group-sm">
                                <label>Fecha Afiliaci&oacute;n</label>
                                <input name="clicor" id="clicor" value="{{old('clicor')}}" class="form-control">
                            </div>
                        </div>
                        
                    </div>

                </div>
           
            </div>

            <br>
            -->
                        <div class="row">



                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div id="" class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <div class="card">
                                            <div class="card-header">
                                                <div id="" class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <strong>
                                                            <!--@lang('labels.frontend.asistencia.box_asistencia')-->
                                                            Datos del Cliente
                                                        </strong>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-body">

                                                <div id="" class="row">

                                                    <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">

                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-lg-5">
                                                                    <div class="form-group">
                                                                        <label class="form-control-sm">
                                                                            <span id="badge_particular" class="badge">PARTICULAR</span><span id="badge_empresa"
                                                                                class="badge badge-success">EMPRESA</span></label>
                                                                        <input type="text" name="numero_documento" <?php echo $disabled?>
                                                                            id="numero_documento"
                                                                            value="{{old('numerodoc')}}" placeholder=""
                                                                            class="form-control form-control-sm"
                                                                            onkeypress="return isNumber(event)">
                                                                        <button type="button" data-toggle="modal" <?php echo $disabled?>
                                                                            data-target="#duenoCargaModal" id=""
                                                                            class="btn btn-link btn-xsm">CAMBIAR DUEÑO DE
                                                                            CARGA</button>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label class="form-control-sm">Nombres / Razón
                                                                            social</label>
                                                                        <input type="text" name="nombres_razon_social"
                                                                            id="nombres_razon_social"
                                                                            value="{{old('nombres')}}" placeholder=""
                                                                            class="form-control form-control-sm">
                                                                        <input id="empresa_direccion"
                                                                            name="empresa_direccion" type="hidden">
																			
																			
								<input type="hidden" readonly name="id_ubicacion" id="id_ubicacion" value="" class="form-control form-control-sm">
								<input type="hidden" readonly name="persona_id" id="persona_id" value="" class="form-control form-control-sm">
								
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>


                                                    </div>

                                                    <!--
													<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Servicio</label>
                                                            <select name="tipo_comercio" id="tipo_comercio"
                                                                class="form-control form-control-sm">
                                                                <option value="pescado">
                                                                    <?php echo "Venta de Pescado"?></option>
                                                                <option value="marisco">
                                                                    <?php echo "Venta Mariscos"?></option>
                                                                <option value="moluscos">
                                                                    <?php echo "Venta Moluscos"?></option>
                                                                <option value="hielo">
                                                                    <?php echo "Venta Hielo"?></option>
                                                            </select>
                                                        </div>
                                                    </div>
													-->

                                                </div>

                                            </div>
                                            <!--card-body-->
                                        </div>
                                        <!--card-->
                                    </div>
                                </div>
								
								<br>
								
								<div id="" class="row">
                                    
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <div class="card">
                                            <div class="card-header">
                                                <strong>
                                                    <!--@lang('labels.frontend.asistencia.box_asistencia')-->
                                                    Información de Productos
                                                </strong>
                                            </div>

                                            <div class="card-body">
                                                <div class="table-responsive">
												
													<div style="display:none">
														<select class="form-control" id="idEspecieTemp" tabindex="16" style="width: 500px">
															<option value="">Seleccionar Producto</option>
															<?php foreach($producto as $row):?>
															<option value="<?php echo $row->id?>"><?php echo $row->denominacion?></option>
															<?php endforeach;?>
														</select>  
													</div>
													
													<button type="button" id="addRow" style="margin-left:10px" class="btn btn-info btn-xs"><i class="fa fa-plus"></i> Agregar producto(s)</button>
													
                                                    <table id="tblProducto" class="table table-hover table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>Producto</th>
																<th>Medida</th>
																<th>Precio</th>
																<th>Cantidad</th>
                                                                <th>Importe</th>
																<th>Eliminar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								
                                <br>

                                <div id="" class="row">
                                    
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <div class="card">
                                            <div class="card-header">
                                                <strong>
                                                    Información de Pago
                                                </strong>
                                            </div>

                                            <div class="card-body">

                                                <div class="table-responsive">
                                                    <table id="tblDevolucion" class="table table-hover">
														<!--
                                                        <thead>
                                                            <tr>
                                                                <th>Concepto</th>
                                                                <th class="text-right">Importe</th>
                                                            </tr>
                                                        </thead>
														-->
                                                        <tbody>
															<!--
                                                            <tr>
                                                                <td>INGRESO DE OTROS PRODUCTOS HIDROBIOLOGICOS</td>
                                                                <td class="text-right">
																<input type="text" name="mov[0][importe]" id="precio_peso" class="form-control form-control-sm col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right" onkeypress="return isNumber(event)" style="float:right" readonly="readonly" >
																<input type="hidden" name="mov[0][modulo]" value="2" />
																<input type="hidden" name="mov[0][smodulo]" value="2" />
                                                                </td>
                                                            </tr>
                                                            -->
																<input type="hidden" name="mov[0][importe]" id="precio_peso" onkeypress="return isNumber(event)">
                                                            <tr>
                                                                <th>Sub-Total</th>
                                                                <th class="text-right"><span
                                                                        id="precio_subtotal"></span> S/</th>
                                                            </tr>
                                                            <tr>
                                                                <th>I.G.V.</th>
                                                                <th class="text-right"><span id="precio_igv"></span> S/
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th>Total</th>
                                                                <th class="text-right"><span id="precio_total"></span>
                                                                    S/</th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!--table-responsive-->

                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group mb-0 float-right">
                                                            
															<input class="btn btn-danger pull-rigth" value="GUARDAR" <?php echo $disabled?>
                                                                name="crea" type="button" form="prestacionescrea"
                                                                id="btnGuardar" onclick="guardarProduccion()" />
                                                        </div>
                                                        <!--form-group-->
                                                    </div>
                                                    <!--col-->
                                                </div>
                                                <!--row-->



                                            </div>
                                            <!--card-body-->
                                        </div>
                                        <!--card-->
                                    </div>
                                </div>


                            </div>
                        </div>

                        <br>

                        <div id="" class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">


                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                <br>

                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>

                        </div>
                </div>

            </div>



        </div>
        <!--col-->

        </form>

        <!-- Modal -->
        <div class="modal fade" id="personaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {!! Form::open(['id' => 'modalPersonaForm','url' => route('frontend.produccion.listar'), 'autocomplete' =>
                    'off'] )
                    !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ingrese los datos de la nueva persona
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card-body">
                                <div id="" class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <div class="form-group">
                                            {{ Form::hidden('empresa_id', '3070', old('empresa_id'),  ['id' => 'empresa_id']) }}
                                            {{ Form::hidden('nro_brevete', old('nro_brevete'), ['maxlength' => '10', 'id' => 'nro_brevete', 'class' => 'form-control form-control-sm '.($errors->has('nro_brevete') ? 'is-danger' : ''), 'placeholder' => 'Nro. Brevete']) }}
                                            <p class="help is-danger">{{ $errors->first('numero_brevete') }}</p>
                                        </div>

                                        <div class="form-group">
                                            {{ Form::select('tipo_documento', ['DNI' => 'DNI', 'CARNET_EXTRANJERIA' => 'Carnet Extranjeria', 'PASAPORTE' => 'Pasaporte', 'CEDULA' => 'Cedula', 'PTP/PTEP' => 'PTP'], ['class' => 'form-control form-control-sm']) }}
                                        </div>

                                        <div class="form-group">
                                            {{ Form::number('numero_documento', old('numdoc'), ['oninput' => 'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);', 'maxlength' => '11', 'class' => 'form-control form-control-sm', 'placeholder' => 'N° Documento']) }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::text('apellido_paterno', old('apepat'), ['id' => 'apellido_paterno', 'class' => 'form-control form-control-sm', 'placeholder' => 'Apellido Paterno']) }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::text('apellido_materno', old('apemat'), ['id' => 'apellido_materno', 'class' => 'form-control form-control-sm', 'placeholder' => 'Apellido Materno']) }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::text('nombres', old('nombresold'), ['id' => 'nombres_chofer', 'class' => 'form-control form-control-sm', 'placeholder' => 'Nombres']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        {!! Form::button('Cancelar', ['id' => 'modalPersonaCancelBtn','class' => 'btn btn-secondary',
                        'data-dismiss' => 'modal']) !!}
                        {!! Form::button('Grabar', ['id' => 'modalPersonaCarretaSaveBtn','class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="vehiculoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {!! Form::open(['id' => 'modalVehiculoForm','url' => route('frontend.produccion.listar'), 'autocomplete' =>
                    'off'] )
                    !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">Registre Nuevo Vehículo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card-body">

                                <div id="" class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

                                        <div class="form-group">
                                            {{ Form::hidden('vehiculo_empresa_id', old('vehiculo_empresa_id'),  ['id' => 'vehiculo_empresa_id']) }}
                                            {{ Form::text('vehiculo_numero_placa', old('vehiculo_numero_placa'), ['id' => 'vehiculo_numero_placa', 'maxlength' => '8', 'class' => 'form-control form-control-sm w-75 '.($errors->has('nro_brevete') ? 'is-danger' : ''), 'placeholder' => 'Nro. Placa']) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="d-inline-flex">
                                            {{ Form::label('Ejes&nbsp;&nbsp;&nbsp;', null, ['class' => 'd-inline-block']) }}
                                            {{ Form::select('vehiculo_numero_ejes', ['2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6'], '2', ['id' => 'vehiculo_numero_ejes',  'class' => 'form-control form-control-sm d-inline-block' ]) }}
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div id="custom-search-input">
                                                <div class="input-group">
                                                    {{ Form::text('vehiculo_empresa', old('vehiculo_empresa'), ['id' => 'vehiculo_empresa', 'class' => 'form-control form-control-sm '.($errors->has('nro_brevete') ? 'is-danger' : ''), 'placeholder' => 'Empresa']) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        {!! Form::button('Cancelar', ['id' => 'modalVehiculoCancelBtn','class' => 'btn btn-secondary',
                        'data-dismiss' => 'modal']) !!}
                        {!! Form::button('Grabar', ['id' => 'modalVehiculoSaveBtn','class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <!--ModalEnd-->

        <!-- Modal -->
        <div class="modal fade" id="empresaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {!! Form::open(['id' => 'modalEmpresaForm','url' => route('frontend.produccion.listar'), 'autocomplete' =>
                    'off'] )
                    !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3">Registre Nueva Empresa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card-body">
                                <div id="" class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <div class="form-group">
                                            {{ Form::number('empresa_numero_ruc', old('empresa_numero_ruc') , ['id' => 'empresa_numero_ruc', 'oninput' => 'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);', 'maxlength' => 11, 'class' => 'form-control form-control-sm', 'placeholder' => 'Nro. RUC']) }}
                                        </div>

                                        <div class="form-group">
                                            {{ Form::text('empresa_razon_social', old('empresa_razon_social'), ['id' => 'empresa_razon_social', 'class' => 'form-control form-control-sm', 'placeholder' => 'Razon Social']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        {!! Form::button('Cancelar', ['id' => 'modalEmpresaCancelBtn','class' => 'btn
                        btn-secondary', 'data-dismiss' => 'modal']) !!}
                        {!! Form::button('Grabar', ['id' => 'modalEmpresaSaveBtn','class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <!--ModalEnd-->


        <!-- Modal -->
        <div class="modal fade" id="duenoCargaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {!! Form::open(['id' => 'modalNuevoDuenoCargaForm','url' => route('frontend.produccion.listar'), 'autocomplete'
                    =>
                    'off'] )
                    !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3">Buscar al Propietario de la Carga</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card-body">
                                <div id="" class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <div class="form-group">
                                            <!-- Option: EMPRESA -->
                                            {{ Form::label('empresa', 'EMPRESA', ['class' => 'control-label']) }}

                                            {{ Form::radio('empresa_particular', 'empresa', 1, ['id' => 'empresa', 'onclick' => 'javascript:$("#modalNuevoDuenoCargaSaveBtn").removeClass("btn-success").addClass("btn-primary");$("#modalNuevoDuenoCargaSaveBtn").html("Buscar");$("#numero_ruc_dni").val("");$("#persona_nuevo_dueno_carga").val("");$("#numero_ruc_dni").attr("placeholder", "Escriba el RUC");$("#empresa_nuevo_dueno_carga").attr("style", "display:block");$("#persona_nuevo_dueno_carga").attr("style", "display:none")']) }}
                                            
                                            <!-- Option: PARTICULAR -->
                                            {{ Form::label('particular', 'PARTICULAR', ['class' => 'control-label']) }}

                                            {{ Form::radio('empresa_particular', 'particular', 0, ['id' => 'particular', 'onclick' => 'javascript:$("#modalNuevoDuenoCargaSaveBtn").removeClass("btn-success").addClass("btn-primary");$("#modalNuevoDuenoCargaSaveBtn").html("Buscar");$("#numero_ruc_dni").val("");$("#empresa_nuevo_dueno_carga").val("");$("#numero_ruc_dni").attr("placeholder", "Escriba el DNI/PTP/PASAPORTE/CEDULA");$("#persona_nuevo_dueno_carga").attr("style", "display:block");$("#empresa_nuevo_dueno_carga").attr("style", "display:none")']) }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::number('numero_ruc_dni', old('numero_ruc_dni') , ['id' => 'numero_ruc_dni', 'oninput' => 'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);', 'maxlength' => 11, 'class' => 'form-control form-control-sm', 'placeholder' => 'Escriba el RUC']) }}
                                        </div>
                                        <p>o</p>
                                        <div class="form-group">
                                            {{ Form::text('empresa_nuevo_dueno_carga', old('empresa_nuevo_dueno_carga'), ['id' => 'empresa_nuevo_dueno_carga', 'class' => 'form-control form-control-sm', 'placeholder' => 'Escriba la Razón Social']) }}
                                            {{ Form::text('persona_nuevo_dueno_carga', old('persona_nuevo_dueno_carga'), ['id' => 'persona_nuevo_dueno_carga', 'class' => 'form-control form-control-sm', 'style' => 'display:none', 'placeholder' => 'Escriba los Apellidos de la persona']) }}
                                        </div>
										<div class="input-group" id="empresa_nuevo_dueno_carga_busqueda"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        {!! Form::button('Cancelar', ['id' => 'modalNuevoDuenoCargaCancelBtn','class' => 'btn
                        btn-secondary', 'data-dismiss' => 'modal']) !!}
                        {!! Form::button('Buscar', ['id' => 'modalNuevoDuenoCargaSaveBtn','class' => 'btn btn-primary'])
                        !!}
                        {!! Form::button('Nueva ', ['id' => 'modalNuevoEmpresaPersonaBtn', 'class' => 'btn btn-warning',
                        'style' => 'display:none'])
                        !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <!--ModalEnd-->

        <!-- Modal -->
        <div class="modal fade" id="empresaNuevaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {!! Form::open(['id' => 'modalNuevaEmpresaForm','url' => route('frontend.produccion.listar'), 'autocomplete' =>
                    'off'] )
                    !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3">Registre Nueva Empresa Dueña de Carga</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card-body">
                                <div id="" class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <div class="form-group">
                                            {{ Form::number('empresa_numero_ruc', old('empresa_numero_ruc') , ['id' => 'empresa_numero_ruc', 'oninput' => 'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);', 'maxlength' => 11, 'class' => 'form-control form-control-sm', 'placeholder' => 'Nro. RUC']) }}
                                        </div>

                                        <div class="form-group">
                                            {{ Form::text('empresa_razon_social', old('empresa_razon_social'), ['id' => 'empresa_razon_social', 'class' => 'form-control form-control-sm', 'placeholder' => 'Razon Social']) }}
                                        </div>

                                        <div class="form-group">
                                            {{ Form::text('empresa_direccion', old('empresa_direccion') , ['id' => 'empresa_direccion', 'oninput' => 'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);', 'maxlength' => 255, 'class' => 'form-control form-control-sm', 'placeholder' => 'Direccion']) }}
                                        </div>

                                        <div class="form-group">
                                            {{ Form::email('empresa_email', old('empresa_email') , ['id' => 'empresa_email', 'oninput' => 'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);', 'maxlength' => 120, 'class' => 'form-control form-control-sm', 'placeholder' => 'Email']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        {!! Form::button('Cancelar', ['id' => 'modalNuevaEmpresaCancelBtn','class' => 'btn
                        btn-secondary', 'data-dismiss' => 'modal']) !!}
                        {!! Form::button('Grabar', ['id' => 'modalNuevaEmpresaSaveBtn','class' => 'btn btn-primary'])
                        !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <!--ModalEnd-->

    </div>
    <!--row-->
    @endsection

    @push('after-scripts')
	{!! script(asset('js/produccion.js')) !!}
    @if(config('access.captcha.contact'))
    @captchaScripts
    @endif
    @endpush