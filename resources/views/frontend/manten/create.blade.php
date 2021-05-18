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
    <li class="breadcrumb-item active">Cronográma</li>
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

            <form class="form-horizontal" method="post" action="{{ route('frontend.manten.create')}}" id="frmMantenimiento" autocomplete="off">
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

                        <input type="hidden" name="id_maestra" id="id_maestra" value="0">

                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div id="" class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <div class="card">
                                            <div class="card-header">
                                                <div id="" class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <strong>
                                                            Datos del Cronográma
                                                        </strong>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-body" style="margin-top:15px;margin-bottom:15px">

												<div style="clear:both"></div>
                                                <div id="" class="row">

													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">Tipo</label>
														<input type="text" name="tipo" id="tipo"
															value="" placeholder="" class="form-control form-control-sm" />
                                                    </div>

													<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">Denominación</label>
														<input type="text" name="denominacion" id="denominacion"
															value="" placeholder=""  class="form-control form-control-sm" />
													</div>

													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">Acrónimo</label>
														<input type="text" name="acronimo" id="acronimo"
															value="" placeholder=""  class="form-control form-control-sm" />
													</div>
													<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">Orden</label>
														<input type="text" name="orden" id="orden"
															value="" placeholder="" class="form-control form-control-sm" />
                                                    </div>

                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Estado</label>
                                                            <select name="estado" id="estado"
                                                                class="form-control form-control-sm"
                                                                onchange="validaEstado()">
                                                                <option selected="selected"
                                                                    value="A">
                                                                    <?php echo "Activo"?></option>
                                                                <option
                                                                    value="C">
                                                                    <?php echo "Cesasdo"?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
												<div style="clear:both"></div>
												<div class="row">
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">Parent</label>
														<input type="text" name="id_parent" id="id_parent"
															value="" placeholder="" class="form-control form-control-sm" />
                                                    </div>
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">Var1</label>
														<input type="text" name="var1" id="var1"
															value="" placeholder=""  class="form-control form-control-sm" />
                                                    </div>
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">Var2</label>
														<input type="text" name="var2" id="var2"
															value="" placeholder=""  class="form-control form-control-sm" />
													</div>
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">Var3</label>
														<input type="text" name="var3" id="var3"
															value="" placeholder=""  class="form-control form-control-sm" />
													</div>
                                                </div>
												<div style="clear:both"></div>

                                            </div>
                                            <!--card-body-->
                                        </div>
                                        <!--card-->
                                    </div>
                                </div>
                                <br>
                                <div id="" class="row">

                                </div>


                            </div>
                        </div>


					<div class="row">

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

						<div class="card">

						<div class="card-header">
							<strong>Lista de Tabla Mestra</strong>
						</div>

						<div class="row" style="padding:10px 20px 10px 20px;">

							<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
								<input class="form-control form-control-sm" id="tipo_buscar" name="tipo_buscar" placeholder="Tipo">
							</div>

							<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
								<input class="form-control form-control-sm" id="denominacion_buscar" name="denominacion_buscar" placeholder="Denominación">
							</div>

                            <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <select name="estado_buscar" id="estado_buscar"
                                        class="form-control form-control-sm"
                                        onchange="validaEstado()">
                                        <option selected="selected"
                                            value="A">
                                            <?php echo "Activo"?></option>
                                        <option
                                            value="C">
                                            <?php echo "Cesasdo"?></option>
                                        <option
                                            value="">
                                            <?php echo "Todos"?></option>
                                    </select>
                                </div>
                            </div>

							<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
								<input class="btn btn-warning btn-sm pull-rigth" value="Buscar" type="button" id="btnBuscar" />
							</div>

						</div>

						<div class="card-body">

							<div class="table-responsive">
							<table id="tblMaestra" class="table table-hover table-sm">
							<thead>
							<tr style="font-size:13px">
                                <th>Id</th>
								<th>Tipo</th>
								<th>Denominación</th>
								<th>Acrónimo</th>
                                <th>Orden</th>
                                <th>Parent</th>
                                <th>Var1</th>
                                <th>Var2</th>
                                <th>Var3</th>
								<th>Estado</th>
							</tr>
							</thead>
							<tbody>
							</tbody>
							</table>

                            </div>
                            <a class='flotante' name="guardar" id="guardar" onclick="guardarTablaMaestra()" href='#' ><img src='/img/btn_save.png' border="0"/></a>
						</div>


                    </div>

                </div>



        </div>
        <!--col-->

        </form>



    </div>
    <!--row-->
    @endsection

    @push('after-scripts')
    {!! script(asset('js/mantenimiento.js')) !!}
    @endpush
