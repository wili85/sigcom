<?php 
$total = 0;
if($chofer):
foreach($chofer as $row):?>
<tr style="font-size:13px" class="test" data-toggle="tooltip" data-placement="top">
	<td class="text-left"><?php echo $row->persona?></td>
	<td class="text-left"><?php echo $row->nro_brevete?></td>
	<td class="text-left"><?php echo $row->observaciones?></td>
</tr>
<?php
endforeach;
endif;
?>