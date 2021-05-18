<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Grafico extends Model
{

    function getFacturadosPorMes($anio){

		$cad = "select to_char(t1.fac_fecha,'MM'),to_char(t1.fac_fecha,'TMMonth') as label,round(sum(t1.fac_total)::numeric,2)as value
from facturas t1
Where t1.fac_anulado='N'
And to_char(t1.fac_fecha,'YYYY')='".$anio."'
group by to_char(t1.fac_fecha,'MM'),to_char(fac_fecha,'TMMonth')
order by to_char(fac_fecha,'MM')";

		$data = DB::select($cad);
		return $data;
    }

	function getFacturadosPorDia($anio){

		$cad = "select to_char(t1.fac_fecha,'dd') as label,round(sum(t1.fac_total)::numeric,2)as value
from facturas t1
Where t1.fac_anulado='N'
And to_char(fac_fecha,'MM')=to_char(now(),'MM')
And to_char(t1.fac_fecha,'YYYY')='".$anio."'
--And to_char(fac_fecha,'MM')='06'
group by to_char(t1.fac_fecha,'dd')
order by to_char(fac_fecha,'dd')";

		$data = DB::select($cad);
		return $data;
    }
	
	function getPagadoCapitalInteresPorMes($anio){
		
		$cad = "select label,sum(fac_total) as value,denominacion from (
select t1.id id_factura,to_char(t1.fac_fecha,'MM')fac_fecha,to_char(t1.fac_fecha,'TMMonth') as label,t3.interes fac_total
,'Interes' denominacion
from facturas t1
inner join factura_detalles t2 on t1.fac_tipo=t2.facd_tipo and t1.fac_serie=t2.facd_serie and t1.fac_numero=t2.facd_numero
inner join cronograma_detalles t3 on t3.fac_tipo=t2.facd_tipo and t3.fac_serie=t2.facd_serie and t3.fac_numero=t2.facd_numero and t3.nro_cuota=t2.facd_item 
Where t1.fac_anulado='N'
And to_char(t1.fac_fecha,'YYYY')='".$anio."'
union all
select t1.id id_factura,to_char(t1.fac_fecha,'MM')fac_fecha,to_char(t1.fac_fecha,'TMMonth') as label,t3.capital_amortizado fac_total
,'Capital' denominacion
from facturas t1
inner join factura_detalles t2 on t1.fac_tipo=t2.facd_tipo and t1.fac_serie=t2.facd_serie and t1.fac_numero=t2.facd_numero
inner join cronograma_detalles t3 on t3.fac_tipo=t2.facd_tipo and t3.fac_serie=t2.facd_serie and t3.fac_numero=t2.facd_numero and t3.nro_cuota=t2.facd_item 
Where t1.fac_anulado='N'
And to_char(t1.fac_fecha,'YYYY')='".$anio."'
)R
group by fac_fecha,label,denominacion
order by fac_fecha,label,denominacion";

		$data = DB::select($cad);
		return $data;
    }
	
	function getPagadoCapitalInteresPorDia($anio){
		
		$cad = "select label,sum(fac_total) as value,denominacion  from (
select distinct t2.id id_factura,to_char(t1.fac_fecha,'dd') as label,t3.interes fac_total
,'Interes' denominacion
from facturas t1
inner join factura_detalles t2 on t1.fac_tipo=t2.facd_tipo and t1.fac_serie=t2.facd_serie and t1.fac_numero=t2.facd_numero
inner join cronograma_detalles t3 on t3.fac_tipo=t2.facd_tipo and t3.fac_serie=t2.facd_serie and t3.fac_numero=t2.facd_numero and t3.nro_cuota=t2.facd_item 
Where t1.fac_anulado='N'
And to_char(t1.fac_fecha,'MM')=to_char(now(),'MM')
And to_char(t1.fac_fecha,'YYYY')='".$anio."'
union all
select distinct t2.id id_factura,to_char(t1.fac_fecha,'dd') as label,t3.capital_amortizado fac_total
,'Capital' denominacion
from facturas t1
inner join factura_detalles t2 on t1.fac_tipo=t2.facd_tipo and t1.fac_serie=t2.facd_serie and t1.fac_numero=t2.facd_numero
inner join cronograma_detalles t3 on t3.fac_tipo=t2.facd_tipo and t3.fac_serie=t2.facd_serie and t3.fac_numero=t2.facd_numero and t3.nro_cuota=t2.facd_item 
Where t1.fac_anulado='N'
And to_char(t1.fac_fecha,'MM')=to_char(now(),'MM')
And to_char(t1.fac_fecha,'YYYY')='".$anio."'
)R
group by label,denominacion
order by label,denominacion";

		$data = DB::select($cad);
		return $data;
    }
	
	function getCapitalPrestadoInteresGenerado($anio){

		$cad = "select denominacion as label,round(sum(fac_total)::numeric,2) as value from(
select distinct t1.id id_factura
,'Capital Prestado' denominacion
,t3.valor_prestamo fac_total
from solicitudes t1
inner join cronogramas t3 on t1.id=t3.id_solicitud
Where t1.eliminado='N'
And to_char(t1.fecha_solicitud,'YYYY')='".$anio."'
union all
select t1.id id_factura
,'Interes Generado' denominacion
,sum(t4.interes) fac_total
from solicitudes t1
inner join cronogramas t3 on t1.id=t3.id_solicitud
inner join cronograma_detalles t4 on t3.id = t4.id_cronograma
Where t1.eliminado='N'
And to_char(t1.fecha_solicitud,'YYYY')='".$anio."'
And t4.interes>0
group by t1.id
)R group by denominacion";

		$data = DB::select($cad);
		return $data;
    }
	
	function getCapitalPendienteInteresPendiente($anio){

		$cad = "select denominacion as label,round(sum(fac_total)::numeric,2) as value from(
select t1.id id_factura
,'Capital Prestado' denominacion
,(case when t4.facturado='N' then t4.capital_amortizado else 0 end)fac_total
from solicitudes t1
inner join cronogramas t3 on t1.id=t3.id_solicitud
inner join cronograma_detalles t4 on t3.id = t4.id_cronograma
Where t1.eliminado='N'
And t4.cuota_pagar>0
And to_char(t3.fecha,'YYYY')='".$anio."'
union all
select t1.id id_factura
,'Interes Generado' denominacion
,sum(case when t4.facturado='N' then t4.interes else 0 end) fac_total
from solicitudes t1
inner join cronogramas t3 on t1.id=t3.id_solicitud
inner join cronograma_detalles t4 on t3.id = t4.id_cronograma
Where t1.eliminado='N'
And t4.interes>0
And to_char(t3.fecha,'YYYY')='".$anio."'
group by t1.id
)R group by denominacion";

		$data = DB::select($cad);
		return $data;
    }
	
	function getCapitalPrestadoInteresGeneradoPorMes($anio){
		
		$cad = "select fac_fecha,label,round(sum(fac_total)::numeric,2) as value,denominacion from(
select distinct t1.id id_factura
,'Capital Prestado' denominacion
,to_char(t4.fecha_pago,'MM')fac_fecha,to_char(t4.fecha_pago,'TMMonth') as label
,t3.valor_prestamo fac_total
from solicitudes t1
inner join cronogramas t3 on t1.id=t3.id_solicitud
inner join cronograma_detalles t4 on t3.id = t4.id_cronograma
Where t1.eliminado='N'
And to_char(t4.fecha_pago,'YYYY')='".$anio."'
union all
select t1.id id_factura
,'Interes Generado' denominacion
,to_char(t4.fecha_pago,'MM')fac_fecha,to_char(t4.fecha_pago,'TMMonth') as label
,sum(t4.interes) fac_total
from solicitudes t1
inner join cronogramas t3 on t1.id=t3.id_solicitud
inner join cronograma_detalles t4 on t3.id = t4.id_cronograma
Where t1.eliminado='N'
And to_char(t4.fecha_pago,'YYYY')='".$anio."'
And t4.interes>0
group by t1.id,t4.id
)R group by fac_fecha,label,denominacion
order by fac_fecha,denominacion";

		$data = DB::select($cad);
		return $data;

    }
	
	function getCapitalPendienteInteresPendientePorMes($anio){
		
		$cad = "select val_fecha,label,round(sum(fac_total)::numeric,2) as value,denominacion from(
select t1.id id_factura
,'Capital Prestado' denominacion
,to_char(t4.fecha_pago,'MM')val_fecha,to_char(t4.fecha_pago,'TMMonth') as label
,(case when t4.facturado='N' then t4.capital_amortizado else 0 end)fac_total
from solicitudes t1
inner join cronogramas t3 on t1.id=t3.id_solicitud
inner join cronograma_detalles t4 on t3.id = t4.id_cronograma
Where t1.eliminado='N'
And t4.cuota_pagar>0
And to_char(t4.fecha_pago,'YYYY')='".$anio."'
union all
select distinct t1.id id_factura
,'Interes Generado' denominacion
,to_char(t4.fecha_pago,'MM')val_fecha,to_char(t4.fecha_pago,'TMMonth') as label
,(case when t4.facturado='N' then t4.interes else 0 end) fac_total
from solicitudes t1
inner join cronogramas t3 on t1.id=t3.id_solicitud
inner join cronograma_detalles t4 on t3.id = t4.id_cronograma
Where t1.eliminado='N'
And t4.interes>0
And to_char(t4.fecha_pago,'YYYY')='".$anio."'
)R
group by val_fecha,label,denominacion
order by val_fecha,denominacion";

		$data = DB::select($cad);
		return $data;
    }
	
	
	
}
