<?php 
//print_r($cronogramaDetalle);
$total = 0;
if($ventaPago):
foreach($ventaPago as $key=>$row):?>
<tr style="font-size:13px" class="test" data-toggle="tooltip" data-placement="top">
	<td class="text-center"><?php echo $key+1?></td>
	<td class="text-left"><?php echo date("d-m-Y", strtotime($row->fecha))?></td>
	<td class="text-right"><?php echo round($row->importe,2)?></td>
	<td class="text-left"><?php echo $row->forma_pago?></td>
    <td class="text-left"><?php echo $row->numero_operacion?></td>
	<!--<td class="text-left">
		<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
			<button style="font-size:12px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalValorizacionFactura(<?php echo $row->id?>)" >
				<i class="fa fa-search" style="font-size:9px!important"></i>
			</button>
		</div>
	</td>-->
</tr>
<?php
	$total += $row->importe;
endforeach;
endif;
?>
<!--
</tbody>
<tfoot>
<tr>
	<th colspan="3" style="text-align:right;padding-right:55px!important;padding-bottom:0px;margin-bottom:0px">Pago Total</th>
	<td colspan="2" style="padding-bottom:0px;margin-bottom:0px">
		<input type="text" readonly name="pagoTotal" id="pagoTotal" value="<?php //echo $total?>" class="form-control form-control-sm text-right"/>
	</td>
	<td colspan="2" style="padding-bottom:0px;margin-bottom:0px">&nbsp;
		
	</td>
</tr>
</tfoot>
-->