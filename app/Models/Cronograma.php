<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Cronograma extends Model
{
    
	function getCronograma($tipo_documento,$persona_id){
        if($tipo_documento=="RUC"){
            $cad = "";
        }else{
            $cad = "select t2.id_cronograma,t2.nro_cuota,t1.id_solicitud,t1.fecha,t1.valor_prestamo,t2.nro_cuota,t2.fecha_pago,t2.cuota_pagar,t2.interes,t2.capital_amortizado,
			t2.capital_vivo,'PAGO CUOTA '||t2.nro_cuota smod_control,'' plancontable,
			round(cast(t2.cuota_pagar/1.18 as numeric),2) valor_unitario,
			round(cast(t2.cuota_pagar*1/1.18 as numeric),2) valor_venta_bruto,
			round(cast((t2.cuota_pagar*1/1.18) as numeric),2) valor_venta,
			round(cast(((t2.cuota_pagar*1/1.18))*0.18 as numeric),2) igv,
			round(cast((((t2.cuota_pagar*1/1.18))*0.18)+(t2.cuota_pagar*1/1.18) as numeric),2) total,
			0 descuento_item,0 descuento,
			t2.cuota_pagar precio_venta 
			from cronogramas t1
			inner join cronograma_detalles t2 on t1.id=t2.id_cronograma
			inner join solicitudes t3 on t1.id_solicitud=t3.id
			where t3.id_persona=".$persona_id."
			And t2.facturado='N'
			and t2.estado='A'
			order by t1.id_solicitud,t2.nro_cuota";
        }

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
	function getPago($tipo_documento,$persona_id){

        if($tipo_documento=="RUC"){
			$cad = "";
        }else{

			$cad = "select distinct t4.id id_factura,t4.fac_tipo,t4.fac_fecha,t4.fac_serie,t4.fac_numero,t4.fac_total,first_name||' '||last_name as usuario_registro, 
			(select string_agg(DISTINCT facd_descripcion, ',') from factura_detalles fac 
			where fac.facd_tipo=t4.fac_tipo And fac.facd_numero=t4.fac_numero And fac.facd_serie=t4.fac_serie) fact_descripcion,
			'TK' smod_tipo_factura 
			from cronogramas t1
			inner join cronograma_detalles t2 on t1.id=t2.id_cronograma
			inner join solicitudes t3 on t1.id_solicitud=t3.id
			inner join facturas t4 on t2.fac_tipo=t4.fac_tipo And t2.fac_serie=t4.fac_serie And t2.fac_numero=t4.fac_numero
			left join users t5 on t4.id_usuario = t5.id 
			Where t3.id_persona=".$persona_id."
			And t2.facturado='S'
			order by t4.fac_fecha desc";
			
        }
        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
	function getCronogramaFactura($id_factura){
/*
select R.*,
round(cast(vsm_precio/1.18 as numeric),2) valor_unitario,
round(cast(vsm_precio*1/1.18 as numeric),2) valor_venta_bruto,
round(cast((vsm_precio*1/1.18)-(((COALESCE(descuento,0)*vsm_precio)/100)/1.18) as numeric),2) valor_venta,
round(cast(((vsm_precio*1/1.18)-(((COALESCE(descuento,0)*vsm_precio)/100)/1.18))*0.18 as numeric),2) igv,
round(cast((((vsm_precio*1/1.18)-(((COALESCE(descuento,0)*vsm_precio)/100)/1.18))*0.18)+(vsm_precio*1/1.18)-(((COALESCE(descuento,0)*vsm_precio)/100)/1.18) as numeric),2) total,
round(cast((((COALESCE(descuento,0)*vsm_precio)/100)/1.18) as numeric),2) descuento_item
from(
select
t1.val_estab, t1.val_codigo,t3.vsm_modulo,
t3.vsm_smodulo,t1.val_fecha,t1.val_pac_nombre,t1.val_subtotal,t1.val_subtotal_plan,t1.val_total,
t1.val_moneda,t2.vm_modulod,t2.vm_descripcion,t2.vm_precio,t3.vsm_smodulo,t3.vsm_smodulod,t3.vsm_precio,
t3.vsm_costo_plan, t4.smod_plancontable plancontable,
t1.val_impuesto,
t3.vsm_precio precio_venta,
case when (select count(*) from valorizaciones t11
	inner join val_atencion_modulos t22 on t1.val_estab = t22.vm_vestab And t11.val_codigo = t22.vm_vnumero
	inner join val_atencion_smodulos t33 on t22.vm_vestab = t33.vsm_vestab And t22.vm_vnumero = t33.vsm_vnumero And t22.vm_modulo = t33.vsm_modulo
where t11.val_estab_i = t1.val_estab_i and t11.val_codigo_i = t1.val_codigo_i and t33.vsm_modulo = t3.vsm_modulo and t33.vsm_smodulo = t3.vsm_smodulo) > 1 then null else t4.smod_descuento end descuento,
COALESCE(plan_tipo_factura,smod_tipo_factura) smod_tipo_factura,
smod_control,
(case when t3.vsm_modulo=2 And t3.vsm_smodulo in (1,2,6,11,19,20) Then 0 else 1 end)flag_estado_cuenta
*/
        $cad = "select t2.id,t2.id_cronograma,t2.nro_cuota,t1.id_solicitud,t1.fecha,t1.valor_prestamo,t2.nro_cuota,t2.fecha_pago,t2.cuota_pagar,t2.interes,
			t2.capital_amortizado,t2.capital_vivo,
			t4.id id_factura,t4.fac_tipo,t4.fac_fecha,t4.fac_serie,t4.fac_numero,t4.fac_total, 
			(select string_agg(DISTINCT facd_descripcion, ',') from factura_detalles fac 
			where fac.facd_tipo=t4.fac_tipo And fac.facd_numero=t4.fac_numero And fac.facd_serie=t4.fac_serie) fact_descripcion,
			'TK' smod_tipo_factura 
			from cronogramas t1
			inner join cronograma_detalles t2 on t1.id=t2.id_cronograma
			inner join solicitudes t3 on t1.id_solicitud=t3.id
			inner join facturas t4 on t2.fac_tipo=t4.fac_tipo And t2.fac_serie=t4.fac_serie And t2.fac_numero=t4.fac_numero
			Where t4.id=".$id_factura."
			And t2.facturado='S'
			order by t4.fac_fecha desc";

		$data = DB::select($cad);
        return $data;
    }
	
	
}
