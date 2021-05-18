<input type="hidden" name="tipo_factura" id="tipo_factura" value="" />
<?php 
$total = 0;
$descuento = 0;
$valor_venta_bruto = 0;
$valor_venta = 0;
$igv = 0;
foreach($cronograma as $key=>$row):?>
<tr style="font-size:13px">
	<td class="text-center">
        <div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
			
            <input type="hidden" name="factura_detalle[<?php echo $key?>][idcronograma]" value="<?php echo $row->id_cronograma?>" />
            <input type="hidden" name="factura_detalle[<?php echo $key?>][nrocuota]" value="<?php echo $row->nro_cuota?>" />
            <input type="hidden" name="factura_detalle[<?php echo $key?>][denominacion]" value="<?php echo $row->smod_control?>" />
            <input type="checkbox" class="mov" name="factura_detalles[<?php echo $key?>][nrocuota]" value="<?php echo $row->nro_cuota?>" onchange="calcular_total(this)" />

            <input type="hidden" name="factura_detalle[<?php echo $key?>][cantidad]" value="1" />            
            <input type="hidden" name="factura_detalle[<?php echo $key?>][precio_venta]" value="<?php echo $row->precio_venta?>" />
            <input type="hidden" name="factura_detalle[<?php echo $key?>][valor_unitario]" value="<?php echo $row->valor_unitario?>" />
            <input type="hidden" name="factura_detalle[<?php echo $key?>][valor_venta_bruto]" value="<?php echo $row->valor_venta_bruto?>" />
            <input type="hidden" name="factura_detalle[<?php echo $key?>][valor_venta]" value="<?php echo $row->valor_venta?>" />            
            <input type="hidden" name="factura_detalle[<?php echo $key?>][igv]" value="<?php echo $row->igv?>" />
            <input type="hidden" name="factura_detalle[<?php echo $key?>][total]" value="<?php echo $row->total?>" />
            <input type="hidden" name="factura_detalle[<?php echo $key?>][descuento_item]" value="<?php echo $row->descuento_item?>" />
            <input type="hidden" name="factura_detalle[<?php echo $key?>][descuento]" value="<?php echo $row->descuento?>" />
            <input type="hidden" name="factura_detalle[<?php echo $key?>][plancontable]" value="<?php echo $row->plancontable?>" />
			
        </div>
    </td>
	<td class="text-center"><?php echo $row->nro_cuota?></td>
	<td class="text-center"><?php echo $row->id_solicitud?></td>
	<!--<td class="text-center"><?php //echo $row->valor_prestamo?></td>-->
	<td class="text-left"><?php echo date("d/m/Y", strtotime($row->fecha_pago))?></td>
	<td class="text-right"><?php echo round($row->interes,2)?></td>
    <td class="text-right"><?php echo round($row->capital_amortizado,2)?></td>
	<td class="text-right"><?php echo round($row->capital_vivo,2)?></td>
	<td class="text-right">
	<?php //echo round($row->cuota_pagar,2)?>
	<span class="val_total"><?php echo round($row->cuota_pagar,2)?></span>
	<span class="val_descuento" style="float:left"></span>
	<input type="hidden" class="tipo_factura" value="TK" />
	</td>
</tr>
<?php 
	$total += $row->cuota_pagar;
endforeach;
?>

<tr>
	<!--<td colspan="7" style="text-align:right;padding-right:55px!important;padding-bottom:0px;margin-bottom:0px">Deuda Total</td>-->
	<td colspan="4">&nbsp;</td>
	<th colspan="3" style="text-align:right;padding-right:55px!important;padding-bottom:0px;margin-bottom:0px;font-size:13px">Deuda Total</th>
	<td style="padding-bottom:0px;margin-bottom:0px">
		<input type="text" readonly name="deudaTotal" id="deudaTotal" value="<?php echo round($total,2)?>" class="form-control form-control-sm text-right"/>
	</td>
</tr>
