<?php 
$total = 0;
if($vehiculo):
foreach($vehiculo as $row):?>
<tr style="font-size:13px" class="test" data-toggle="tooltip" data-placement="top" onclick="cargarChofer(<?php echo $row->id?>)">
	<td class="text-left"><?php echo $row->placa?></td>
	<td class="text-left"><?php echo $row->tipo_vehiculo?></td>
	<td class="text-right"><?php echo $row->ejes?></td>
	<td class="text-right"><?php echo $row->peso_seco?></td>
</tr>
<?php
endforeach;
endif;
?>