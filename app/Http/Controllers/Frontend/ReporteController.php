<?php

namespace App\Http\Controllers\Frontend;

use DB;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use App\Models\Solicitude;
use App\Models\Factura;
use Config;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;

class ReporteController extends Controller
{
    public function __construct(){
		
		$this->middleware(function ($request, $next) {
		
			if(!Auth::check()) {
                return redirect('login');
            }
			
			$id_user = Auth::user()->id;
			$maestra_model = new TablaMaestra;
			$css = $maestra_model->getCss($id_user);
			Config::set('css', $css);
        	return $next($request);
    	});
	}
	
	public function consulta_consolidado()
    {
		$id_user = Auth::user()->id;

        return view('frontend.reporte.all_consolidado',compact('id_user'));
    }
	
	public function consulta_individual()
    {
		$id_user = Auth::user()->id;

        return view('frontend.reporte.all_individual',compact('id_user'));
    }
	
	public function consulta_vencidos()
    {
		$id_user = Auth::user()->id;

        return view('frontend.reporte.all_vencidos',compact('id_user'));
    }
	
	public function resumen_ingreso()
    {
		$id_user = Auth::user()->id;

        return view('frontend.reporte.all_resumen_ingreso',compact('id_user'));
    }
	
	public function listar_consolidado_ajax(Request $request){
		
		$solicitud_model = new Solicitude;
		$p[]=$request->numero_documento;
		$p[]=$request->afiliado;
		$p[]=$request->fecha_desde;
		$p[]=$request->fecha_hasta;
		$p[]=$request->id_estado;
		$p[]=config('values.dblink_dbname');
		$p[]=config('values.dblink_port');
		$p[]=config('values.dblink_host');
		$p[]=config('values.dblink_user');
		$p[]=config('values.dblink_password');
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $solicitud_model->listar_consolidado_ajax($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;
		
		$result["PageStart"] = $request->NumeroPagina;
		$result["pageSize"] = $request->NumeroRegistros;
		$result["SearchText"] = "";
		$result["ShowChildren"] = true;
		$result["iTotalRecords"] = $iTotalDisplayRecords;
		$result["iTotalDisplayRecords"] = $iTotalDisplayRecords;
		$result["aaData"] = $data;
		
		echo json_encode($result);
		
	}
	
	public function listar_vencidos_ajax(Request $request){
		
		$solicitud_model = new Solicitude;
		$p[]=$request->numero_documento;
		$p[]=$request->afiliado;
		$p[]=$request->fecha_desde;
		$p[]=$request->fecha_hasta;
		$p[]=config('values.dblink_dbname');
		$p[]=config('values.dblink_port');
		$p[]=config('values.dblink_host');
		$p[]=config('values.dblink_user');
		$p[]=config('values.dblink_password');
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $solicitud_model->listar_vencidos_ajax($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;
		
		$result["PageStart"] = $request->NumeroPagina;
		$result["pageSize"] = $request->NumeroRegistros;
		$result["SearchText"] = "";
		$result["ShowChildren"] = true;
		$result["iTotalRecords"] = $iTotalDisplayRecords;
		$result["iTotalDisplayRecords"] = $iTotalDisplayRecords;
		$result["aaData"] = $data;
		
		echo json_encode($result);
		
	}
	
	public function listar_resumen_ingreso_ajax(Request $request){
		
		$factura_model = new Factura;
		$p[]=$request->fecha_desde;
		$p[]=$request->fecha_hasta;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $factura_model->listar_resumen_ingreso_ajax($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;
		
		$result["PageStart"] = $request->NumeroPagina;
		$result["pageSize"] = $request->NumeroRegistros;
		$result["SearchText"] = "";
		$result["ShowChildren"] = true;
		$result["iTotalRecords"] = $iTotalDisplayRecords;
		$result["iTotalDisplayRecords"] = $iTotalDisplayRecords;
		$result["aaData"] = $data;
		
		echo json_encode($result);
		
	}
	
	public function exportar_consolidado($numero_documento,$afiliado,$fecha_desde,$fecha_hasta,$id_estado) {
		
		$solicitud_model = new Solicitude;
		if($afiliado=="0")$afiliado = "";
		if($numero_documento=="0")$numero_documento = "";
		if($fecha_desde!=0)$fecha_desde = str_replace("-","/",$fecha_desde); else $fecha_desde = "";
		if($fecha_hasta!=0)$fecha_hasta = str_replace("-","/",$fecha_hasta); else $fecha_hasta = "";
		$p[]=$numero_documento;
		$p[]=$afiliado;
		$p[]=$fecha_desde;
		$p[]=$fecha_hasta;
		$p[]=$id_estado;
		$p[]=config('values.dblink_dbname');
		$p[]=config('values.dblink_port');
		$p[]=config('values.dblink_host');
		$p[]=config('values.dblink_user');
		$p[]=config('values.dblink_password');
		$p[]=1;
		$p[]=10000;
		$data = $solicitud_model->listar_consolidado_ajax($p);
		
		$variable = [];
		$n = 1;
		array_push($variable, array("N","Apellidos y Nombres", "Documento", "Area", "Puesto", "Cargo", "Fecha Desembolso", "Valor Prestamo", "Deuda Total con Interes", "Deuda Pendiente con Interes", "Deuda Total sin Interes","Deuda Pendiente sin Interes","Monto Pagado","Estado"));
		foreach ($data as $r) {
			$monto_pagado = ($r->monto_pagado!="")?round($r->monto_pagado,2):"0";
			
			$deuda_total_con_interes = ($r->deuda_total_con_interes!="")?round($r->deuda_total_con_interes,2):"0";
			$deuda_pendiente_con_interes = ($r->deuda_pendiente_con_interes!="" && $r->deuda_pendiente_con_interes>0)?round($r->deuda_pendiente_con_interes,2):"0";
			$deuda_total_sin_interes = ($r->deuda_total_sin_interes!="" && $r->deuda_total_sin_interes>0)?round($r->deuda_total_sin_interes,2):"0";
			$deuda_pendiente_sin_interes = ($r->deuda_pendiente_sin_interes!="" && $r->deuda_pendiente_sin_interes>0)?round($r->deuda_pendiente_sin_interes,2):"0";
			if($deuda_total_con_interes=="")$deuda_total_con_interes="0";
			if($deuda_pendiente_con_interes=="")$deuda_pendiente_con_interes="0";
			if($deuda_total_sin_interes=="")$deuda_total_sin_interes="0";
			if($deuda_pendiente_sin_interes=="")$deuda_pendiente_sin_interes="0";
			
			array_push($variable, array($n++,$r->persona, $r->numero_documento, $r->area, $r->puesto, $r->cargo, $r->fecha_desembolso,round($r->valor_prestamo,2),$deuda_total_con_interes,$deuda_pendiente_con_interes,$deuda_total_sin_interes,$deuda_pendiente_sin_interes,$monto_pagado,$r->estado));
		}
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'consolidado_estado_situacional.xlsx');
    }
	
	public function exportar_individual($id) {
		
		$solicitud_model = new Solicitude;
		$solicitud = $solicitud_model->getSolicitudConsolidado($id);
		$data = $solicitud_model->getSolicitudCronograma($id);
		
		$variable = [];
		$monto_pagado = ($solicitud->monto_pagado!="")?round($solicitud->monto_pagado,2):"0";
		array_push($variable, array("Apellidos y Nombres",$solicitud->persona));
		array_push($variable, array("Documento",$solicitud->numero_documento));
		array_push($variable, array("Fecha Desembolso",$solicitud->fecha_desembolso));
		array_push($variable, array("Valor Prestamo",round($solicitud->valor_prestamo,2)));
		array_push($variable, array("Deuda Total con Interes",round($solicitud->deuda_total_con_interes,2)));
		array_push($variable, array("Deuda Pendiente con Interes",round($solicitud->deuda_pendiente_con_interes,2)));
		array_push($variable, array("Deuda Total sin Interes",round($solicitud->deuda_total_sin_interes,2)));
		array_push($variable, array("Deuda Pendiente sin Interes",round($solicitud->deuda_pendiente_sin_interes,2)));
		array_push($variable, array("Monto Pagado",$monto_pagado));
		array_push($variable, array("Estado",$solicitud->estado));
		array_push($variable, array("",""));
		
		$n = 10;
		array_push($variable, array("Cuota","Fecha Pago", "Cuota Pagar", "Interes", "Capital Amortizado", "Capital Vivo", "Monto Pagado", "Estado"));
		foreach ($data as $r) {
		
			$facturado="PENDIENTE";
			if($r->facturado=='S')$facturado = "PAGADO";
			$facd_importe = ($r->facd_importe!="")?round($r->facd_importe,2):"0";
			$interes = ($r->interes!="" && $r->interes>0)?round($r->interes,2):"0";
			$capital_amortizado = ($r->capital_amortizado!="" && $r->capital_amortizado>0)?round($r->capital_amortizado,2):"0";
			$capital_vivo = ($r->capital_vivo!="" && $r->capital_vivo>0)?round($r->capital_vivo,2):"0";
			if($interes=="")$interes="0";
			if($capital_amortizado=="")$capital_amortizado="0";
			if($capital_vivo=="")$capital_vivo="0";
			
			array_push($variable, array($r->nro_cuota, $r->fecha_pago, $r->cuota_pagar,$interes,$capital_amortizado,$capital_vivo,$facd_importe,$facturado));
		}
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'individual_estado_situacional.xlsx');
    }
	
	public function exportar_individual_vencidos($id) {
		
		$solicitud_model = new Solicitude;
		$solicitud = $solicitud_model->getSolicitudConsolidado($id);
		$data = $solicitud_model->getSolicitudCronogramaVencidos($id);
		
		$variable = [];
		$monto_pagado = ($solicitud->monto_pagado!="")?round($solicitud->monto_pagado,2):"0";
		array_push($variable, array("Apellidos y Nombres",$solicitud->persona));
		array_push($variable, array("Documento",$solicitud->numero_documento));
		array_push($variable, array("Fecha Desembolso",$solicitud->fecha_desembolso));
		array_push($variable, array("Valor Prestamo",round($solicitud->valor_prestamo,2)));
		array_push($variable, array("Deuda Total con Interes",round($solicitud->deuda_total_con_interes,2)));
		array_push($variable, array("Deuda Pendiente con Interes",round($solicitud->deuda_pendiente_con_interes,2)));
		array_push($variable, array("Deuda Total sin Interes",round($solicitud->deuda_total_sin_interes,2)));
		array_push($variable, array("Deuda Pendiente sin Interes",round($solicitud->deuda_pendiente_sin_interes,2)));
		array_push($variable, array("Monto Pagado",$monto_pagado));
		array_push($variable, array("Estado",$solicitud->estado));
		array_push($variable, array("",""));
		
		$n = 10;
		array_push($variable, array("Cuota","Fecha Pago", "Cuota Pagar", "Interes", "Capital Amortizado", "Capital Vivo", "Monto Pagado", "Estado"));
		foreach ($data as $r) {
		
			$facturado="PENDIENTE";
			if($r->facturado=='S')$facturado = "PAGADO";
			$facd_importe = ($r->facd_importe!="")?round($r->facd_importe,2):"0";
			$interes = ($r->interes!="" && $r->interes>0)?round($r->interes,2):"0";
			$capital_amortizado = ($r->capital_amortizado!="" && $r->capital_amortizado>0)?round($r->capital_amortizado,2):"0";
			$capital_vivo = ($r->capital_vivo!="" && $r->capital_vivo>0)?round($r->capital_vivo,2):"0";
			if($interes=="")$interes="0";
			if($capital_amortizado=="")$capital_amortizado="0";
			if($capital_vivo=="")$capital_vivo="0";
			
			array_push($variable, array($r->nro_cuota, $r->fecha_pago, $r->cuota_pagar,$interes,$capital_amortizado,$capital_vivo,$facd_importe,$facturado));
		}
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'individual_estado_situacional.xlsx');
    }
	
	public function exportar_individual_resumen_ingreso($fecha) {
		
		$factura_model = new Factura;
		$factura = $factura_model->getResumenIngresoByFecha($fecha);
		$data = $factura_model->getDetalleResumenIngresoByFecha($fecha);
		
		$variable = [];
		$facd_importe = ($factura->facd_importe!="" && $factura->facd_importe>0)?round($factura->facd_importe,2):"0";
		$interes = ($factura->interes!="" && $factura->interes>0)?round($factura->interes,2):"0";
		$capital_amortizado = ($factura->capital_amortizado!="" && $factura->capital_amortizado>0)?round($factura->capital_amortizado,2):"0";
		$capital_vivo = ($factura->capital_vivo!="" && $factura->capital_vivo>0)?round($factura->capital_vivo,2):"0";
		
		if($facd_importe=="")$facd_importe="0";
		if($interes=="")$interes="0";
		if($capital_amortizado=="")$capital_amortizado="0";
		if($capital_vivo=="")$capital_vivo="0";
		array_push($variable, array("Fecha Registro Pago",$factura->fac_fecha));
		array_push($variable, array("Interes",$interes));
		array_push($variable, array("Capital Amortizado",$capital_amortizado));
		//array_push($variable, array("Capital Vivo",$capital_vivo));
		array_push($variable, array("Monto Pagado",$facd_importe));
		array_push($variable, array("",""));
		
		$n = 10;
		array_push($variable, array("Fecha Cuota","Nro Cuota", "Apellidos y Nombres", "Documento", "Interes", "Capital Amortizado", /*"Capital Vivo",*/"Monto Pagado"));
		foreach ($data as $r) {
		
			$facd_importe = ($r->facd_importe!="" && $r->facd_importe>0)?round($r->facd_importe,2):"0";
			$interes = ($r->interes!="" && $r->interes>0)?round($r->interes,2):"0";
			$capital_amortizado = ($r->capital_amortizado!="" && $r->capital_amortizado>0)?round($r->capital_amortizado,2):"0";
			//$capital_vivo = ($r->capital_vivo!="" && $r->capital_vivo>0)?round($r->capital_vivo,2):"0";
			
			if($facd_importe=="")$facd_importe="0";
			if($interes=="")$interes="0";
			if($capital_amortizado=="")$capital_amortizado="0";
			//if($capital_vivo=="")$capital_vivo="0";
			
			array_push($variable, array($r->fecha_pago, $r->nro_cuota, $r->fac_destinatario,$r->fac_cod_tributario,$interes,$capital_amortizado,/*$capital_vivo,*/$facd_importe));
		}
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'individual_resumen_ingreso.xlsx');
    }
	
	public function exportar_vencidos($numero_documento,$afiliado,$fecha_desde,$fecha_hasta) {
		
		$solicitud_model = new Solicitude;
		if($afiliado=="0")$afiliado = "";
		if($numero_documento=="0")$numero_documento = "";
		if($fecha_desde!=0)$fecha_desde = str_replace("-","/",$fecha_desde); else $fecha_desde = "";
		if($fecha_hasta!=0)$fecha_hasta = str_replace("-","/",$fecha_hasta); else $fecha_hasta = "";
		$p[]=$numero_documento;
		$p[]=$afiliado;
		$p[]=$fecha_desde;
		$p[]=$fecha_hasta;
		$p[]=config('values.dblink_dbname');
		$p[]=config('values.dblink_port');
		$p[]=config('values.dblink_host');
		$p[]=config('values.dblink_user');
		$p[]=config('values.dblink_password');
		$p[]=1;
		$p[]=10000;
		$data = $solicitud_model->listar_vencidos_ajax($p);
		
		$variable = [];
		$n = 1;
		array_push($variable, array("N","Apellidos y Nombres", "Documento", "Area", "Puesto", "Cargo", "Fecha Desembolso", "Valor Prestamo", "Deuda Pendiente con Interes", "Deuda Pendiente sin Interes","Interes Pendiente"));
		foreach ($data as $r) {
			$interes_pendiente = ($r->interes_pendiente!="")?round($r->interes_pendiente,2):"0";
			
			//$deuda_total_con_interes = ($r->deuda_total_con_interes!="")?round($r->deuda_total_con_interes,2):"0";
			$deuda_pendiente_con_interes = ($r->deuda_pendiente_con_interes!="" && $r->deuda_pendiente_con_interes>0)?round($r->deuda_pendiente_con_interes,2):"0";
			//$deuda_total_sin_interes = ($r->deuda_total_sin_interes!="" && $r->deuda_total_sin_interes>0)?round($r->deuda_total_sin_interes,2):"0";
			$deuda_pendiente_sin_interes = ($r->deuda_pendiente_sin_interes!="" && $r->deuda_pendiente_sin_interes>0)?round($r->deuda_pendiente_sin_interes,2):"0";
			//if($deuda_total_con_interes=="")$deuda_total_con_interes="0";
			if($deuda_pendiente_con_interes=="")$deuda_pendiente_con_interes="0";
			//if($deuda_total_sin_interes=="")$deuda_total_sin_interes="0";
			if($deuda_pendiente_sin_interes=="")$deuda_pendiente_sin_interes="0";
			
			array_push($variable, array($n++,$r->persona, $r->numero_documento, $r->area, $r->puesto, $r->cargo, $r->fecha_desembolso,round($r->valor_prestamo,2),$deuda_pendiente_con_interes,$deuda_pendiente_sin_interes,$interes_pendiente));
		}
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'consolidado_estado_situacional.xlsx');
    }
	
	public function exportar_resumen_ingreso($fecha_desde,$fecha_hasta) {
		
		$factura_model = new Factura;
		if($fecha_desde!=0)$fecha_desde = str_replace("-","/",$fecha_desde); else $fecha_desde = "";
		if($fecha_hasta!=0)$fecha_hasta = str_replace("-","/",$fecha_hasta); else $fecha_hasta = "";
		$p[]=$fecha_desde;
		$p[]=$fecha_hasta;
		$p[]=1;
		$p[]=10000;
		$data = $factura_model->listar_resumen_ingreso_ajax($p);
		
		$variable = [];
		$n = 1;
		array_push($variable, array("N","Fecha Registro Pago", "Interes", "Capital Amortizado", /*"Capital Vivo",*/"Monto Pagado"));
		foreach ($data as $r) {
		
			$facd_importe = ($r->facd_importe!="" && $r->facd_importe>0)?round($r->facd_importe,2):"0";
			$interes = ($r->interes!="" && $r->interes>0)?round($r->interes,2):"0";
			$capital_amortizado = ($r->capital_amortizado!="" && $r->capital_amortizado>0)?round($r->capital_amortizado,2):"0";
			//$capital_vivo = ($r->capital_vivo!="" && $r->capital_vivo>0)?round($r->capital_vivo,2):"0";
			
			if($facd_importe=="")$facd_importe="0";
			if($interes=="")$interes="0";
			if($capital_amortizado=="")$capital_amortizado="0";
			//if($capital_vivo=="")$capital_vivo="0";
			
			array_push($variable, array($n++,$r->fac_fecha, $interes, $capital_amortizado, /*$capital_vivo,*/$facd_importe));
		}
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'resumen_ingreso.xlsx');
    }
	
	public function obtener_solicitud_cronograma($id){
		$solicitud_model = new Solicitude;
		$solicitud = $solicitud_model->getSolicitudCronograma($id);
		echo json_encode($solicitud);
	}
	
	public function obtener_solicitud_cronograma_vencidos($id){
		$solicitud_model = new Solicitude;
		$solicitud = $solicitud_model->getSolicitudCronogramaVencidos($id);
		echo json_encode($solicitud);
	}
	
	public function obtener_resumen_ingreso_fecha($fecha){
		$factura_model = new Factura;
		$factura = $factura_model->getDetalleResumenIngresoByFecha($fecha);
		echo json_encode($factura);
	}
	
}

class InvoicesExport implements FromArray
	{
    	protected $invoices;

    	public function __construct(array $invoices)
    	{
        	$this->invoices = $invoices;
    	}

    	public function array(): array
    	{
        	return $this->invoices;
    	}
}
