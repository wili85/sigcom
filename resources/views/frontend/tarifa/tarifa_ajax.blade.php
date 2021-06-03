<?php 
$total = 0;
if($tarifa):
foreach($tarifa as $row):?>
<tr style="font-size:13px" class="test" data-toggle="tooltip" data-placement="top">
	<td class="text-left"><?php echo $row->producto?></td>
	<td class="text-left"><?php echo $row->unidad?></td>
	<td class="text-right"><?php echo round($row->precio,2)?></td>
</tr>
<?php
endforeach;
endif;
?>