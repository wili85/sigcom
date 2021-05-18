<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Solicitude extends Model
{
    public function listar_solicitud_ajax($p){
		return $this->readFunctionPostgres('sp_listar_solicitud_paginado',$p);
    }
	
	public function listar_consolidado_ajax($p){
		return $this->readFunctionPostgres('sp_listar_consolidado_paginado',$p);
    }
	
	public function listar_vencidos_ajax($p){
		return $this->readFunctionPostgres('sp_listar_vencidos_paginado',$p);
    }
	
	function getSolicitudById($id){

        $cad = "select t1.id,t1.fecha_solicitud,t2.numero_documento,t2.telefono,t2.email,t2.nombres,t2.apellido_paterno,t2.apellido_materno,t1.monto_solicitado,
t3.denominacion motivo,t4.denominacion moneda,t1.tiempo_pago,t1.id_motivo,t1.id_moneda,t1.monto_solicitado,t1.monto_valorizado,t1.monto_aprobado,
t1.tna,t1.freecuencia_pago,t1.nro_cuota,coalesce(t1.periodo_gracia,0)periodo_gracia 
from solicitudes t1
inner join personas t2 on t1.id_persona=t2.id
inner join tabla_maestras t3 on t1.id_motivo=t3.id
inner join tabla_maestras t4 on t1.id_moneda=t4.id
Where t1.eliminado='N' 
and t1.id=".$id;
    
		$data = DB::select($cad);
        return $data[0];
    }
	
	function getSolicitudConsolidado($id){

        $cad = "select t1.id,t2.numero_documento,t2.apellido_paterno||' '||t2.apellido_materno||' '||t2.nombres as persona,
to_char(t3.fecha,'dd-mm-yyyy') fecha_desembolso,t3.valor_prestamo,
sum(t4.cuota_pagar)deuda_total_con_interes,
sum(case when t4.facturado='N' then t4.cuota_pagar else 0 end)deuda_pendiente_con_interes,
sum(t4.capital_amortizado)deuda_total_sin_interes,
sum(case when t4.facturado='N' then t4.capital_amortizado else 0 end)deuda_pendiente_sin_interes,
sum(t5.facd_importe)monto_pagado,
case 
	when sum(t5.facd_importe)>=sum(t4.cuota_pagar) and sum(t5.facd_importe)>0 Then 'Finalizado'
	when sum(t5.facd_importe)<sum(t4.cuota_pagar) and sum(t5.facd_importe)>0 Then 'En proceso'
	when sum(t5.facd_importe)=0 Then 'Pendiente'						
end estado
from solicitudes t1
inner join personas t2 on t1.id_persona=t2.id
inner join cronogramas t3 on t1.id=t3.id_solicitud
inner join cronograma_detalles t4 on t3.id = t4.id_cronograma
left join factura_detalles t5 on t4.fac_tipo=t5.facd_tipo and t4.fac_serie=t5.facd_serie and t4.fac_numero=t5.facd_numero and t4.nro_cuota=t5.facd_item
Where t1.eliminado='N'
and t1.id=".$id." 
group by t1.id,t2.id,t3.id"; 
    
		$data = DB::select($cad);
        return $data[0];
    }
	
	function getGarantiaByIdSolicitud($id){

        $cad = "select t1.id,t1.id_tipo,t2.denominacion,t1.cantidad,t1.descripcion,t1.valor_actual,t1.valor_garantia 
from garantia_detalles t1
inner join tabla_maestras t2 on t1.id_tipo=t2.id
where t1.estado='A'
And t1.id_solicitud=".$id;
    
		$data = DB::select($cad);
        return $data;
    }
	
	function getSolicitudCronograma($id){

        $cad = "select 
t1.id,t2.numero_documento,t2.apellido_paterno||' '||t2.apellido_materno||' '||t2.nombres as persona,
t3.valor_prestamo,
to_char(t4.fecha_pago,'dd-mm-yyyy') fecha_pago,
t4.nro_cuota,t4.cuota_pagar,t4.interes,t4.capital_amortizado,t4.capital_vivo,t5.facd_importe,
t4.facturado
from solicitudes t1
inner join personas t2 on t1.id_persona=t2.id
inner join cronogramas t3 on t1.id=t3.id_solicitud
inner join cronograma_detalles t4 on t3.id = t4.id_cronograma
left join factura_detalles t5 on t4.fac_tipo=t5.facd_tipo and t4.fac_serie=t5.facd_serie and t4.fac_numero=t5.facd_numero and t4.nro_cuota=t5.facd_item
Where t1.eliminado='N'
and t1.id=".$id."
and t4.id not in (select id from cronograma_detalles where facturado='N' and cuota_pagar=0) 
order by t4.nro_cuota";

		$data = DB::select($cad);
        return $data;
    }
	
	function getSolicitudCronogramaVencidos($id){

        $cad = "select 
t1.id,t2.numero_documento,t2.apellido_paterno||' '||t2.apellido_materno||' '||t2.nombres as persona,
t3.valor_prestamo,
to_char(t4.fecha_pago,'dd-mm-yyyy') fecha_pago,
t4.nro_cuota,t4.cuota_pagar,t4.interes,t4.capital_amortizado,t4.capital_vivo,t5.facd_importe,
t4.facturado
from solicitudes t1
inner join personas t2 on t1.id_persona=t2.id
inner join cronogramas t3 on t1.id=t3.id_solicitud
inner join cronograma_detalles t4 on t3.id = t4.id_cronograma
left join factura_detalles t5 on t4.fac_tipo=t5.facd_tipo and t4.fac_serie=t5.facd_serie and t4.fac_numero=t5.facd_numero and t4.nro_cuota=t5.facd_item
Where t1.eliminado='N'
And t4.facturado='N'
And t4.fecha_pago<now() 
and t1.id=".$id."
and t4.id not in (select id from cronograma_detalles where facturado='N' and cuota_pagar=0) 
order by t4.nro_cuota";

		$data = DB::select($cad);
        return $data;
    }
	
	
	
	public function readFunctionPostgres($function, $parameters = null){

      $_parameters = '';
      if (count($parameters) > 0) {
          $_parameters = implode("','", $parameters);
          $_parameters = "'" . $_parameters . "',";
      }
	  $data = DB::select("BEGIN;");
	  $cad = "select " . $function . "(" . $_parameters . "'ref_cursor');";
	  //echo $cad;
	  $data = DB::select($cad);
	  $cad = "FETCH ALL IN ref_cursor;";
	  $data = DB::select($cad);
      return $data;
   }
   
   public function readFunctionPostgresTransaction($function, $parameters = null){
	
      $_parameters = '';
      if (count($parameters) > 0) {
	  		
			foreach($parameters as $par){
				if(is_string($par))$_parameters .= "'" . $par . "',";
				else $_parameters .= "" . $par . ",";
		  	}
			if(strlen($_parameters)>1)$_parameters= substr($_parameters,0,-1);
			
      }

	  $cad = "select " . $function . "(" . $_parameters . ");";
	  $data = DB::select($cad);
	  return $data[0]->$function;
   }
   
}
