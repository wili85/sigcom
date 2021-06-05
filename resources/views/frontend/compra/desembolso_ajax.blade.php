<script type="text/javascript">
var _token = $('#_token').val();
new AjaxUpload($('#link_ruta_desembolso'), {
	action: "/compra/upload",
	data:  {_token : _token},
	name: 'file',
	autoSubmit: true,
	onSubmit: function(file, extension) {
	  //$('div.preview').addClass('loading');
	},
	onComplete: function(file, response) {//alert(response);
		$('#img_ruta_desembolso').attr('src',url+"/img/frontend/tmp/"+file);
		$('#ruta_desembolso').val("")
		$('#ruta_desembolso').val(file);
	}
});
</script>
<?php if(isset($desembolso)):?>
<div class="row">
	<div class="form-group form-group-sm col-sm-12">
		<div class="row">
			<label for="first_name" class="col-sm-3 col-form-label">Forma de Pago</label>
			<div class="col-sm-9">
				<div id="first_name" name="first_name" class="form-control alert alert-warning" role="alert"><?php //echo $desembolso->tipo_desembolso?></div>
			</div>
		</div>
	</div>
	<div class="form-group form-group-sm col-sm-12">
		<div class="row">
			<label for="Street" class="col-sm-3 col-form-label">Imagen</label>
			<div class="col-sm-9">
				<img src="<?php //echo ($desembolso->ruta_desembolso!="")?URL::to('/')."/img/frontend/solicitud/desembolso/".$desembolso->ruta_desembolso:$logged_in_user->picture?>" id="img_ruta_desembolso" width="330" height="260" alt="" />
			</div>
		</div>
	</div>
		
</div>
<?php else:?>
<div class="row">
	<div class="form-group form-group-sm col-sm-12">
		<div class="row">
			<label for="first_name" class="col-sm-3 col-form-label">Forma de Pago</label>
			<div class="col-sm-9">
				<select name="id_tipodesembolso" id="id_tipodesembolso" class="form-control form-control-sm" onchange="">
					<?php foreach($forma_pagos as $row):?>
					<option value="<?php echo $row->id?>"><?php echo $row->denominacion?></option>
					<?php endforeach;?>
				</select>	
			</div>
		</div>
	</div>
	<div class="form-group form-group-sm col-sm-12">
		<div class="row">
			<label for="first_name" class="col-sm-3 col-form-label">Importe</label>
			<div class="col-sm-9">
				<input class="form-control form-control-sm" id="importe" name="importe" placeholder="Ingresar el importe">
			</div>
		</div>
	</div>
	<div class="form-group form-group-sm col-sm-12">
		<div class="row">
			<label for="Street" class="col-sm-3 col-form-label">
				<strong><a class="edicion mt_20 mb_10" id="link_ruta_desembolso" href="javascript:void(0)">Adjuntar Imagen</a></strong>
			</label>
			<div class="col-sm-9">
				<input type="hidden" id="ruta_desembolso" name="ruta_desembolso" value="" />
				<img src="<?php echo $logged_in_user->picture?>" id="img_ruta_desembolso" width="330" height="260" alt="" />
			</div>
		</div>
	</div>
	
	
	<div class="form-group form-group-sm col-sm-12" style="float:right">
		<button class="btn float-right btn-success" type="button" onclick="fn_save_desembolso(5)">Desembolsar</button>
		<button class="btn float-left btn-danger" type="button" onclick="fn_save_desembolso(4)">Rechazar</button>
	</div>
	
</div>

<?php endif;?>