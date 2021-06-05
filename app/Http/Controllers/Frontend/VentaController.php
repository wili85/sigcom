<?php

namespace App\Http\Controllers\Frontend;

use DB;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\VentaPago;
use Session;
use App\Models\TablaMaestra;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\Empresa;
use Config;

class VentaController extends Controller
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
	
	public function listar()
    {
		$id_user = Auth::user()->id;
		
		return view('frontend.venta.all', compact('id_user'));
    }
	
	public function listar_venta_ajax(Request $request){

		$venta_model = new Venta;
		$p[]=$request->numero_documento;
		$p[]=$request->nombre;
		$p[]=$request->id_estado;
		$p[]=$request->id_estado;
		$p[]=$request->nombre;
		$p[]=$request->nombre;
		$p[]=$request->id_estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $venta_model->listar_venta_ajax($p);
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
	
	public function create()
    {
        $persona = new Persona;
		$id_user = Auth::user()->id;
		$producto_model = new Producto;
		$producto = $producto_model->getProductoByIdCategoria(136);
		return view('frontend.venta.create', compact('persona','producto'));
    }
	
	public function create_desembolso()
    {
        $id_user = Auth::user()->id;
		
		return view('frontend.venta.create_desembolso', compact('id_user'));
    }
	
	public function listar_empresas($term)
    {
		$empresas = Empresa::whereRaw('upper(razon_social) like ?', strtoupper($term).'%')->get(["id", "razon_social", "nombre_comercial", "ruc", "direccion"]);
		
        return response()->json($empresas);
    }
	
	public function listar_personas($term)
    {
		 $empresas = Persona::whereRaw('upper(apellido_paterno) like ?', strtoupper($term).'%')->orwhereRaw('upper(apellido_materno) like ?', strtoupper($term).'%')->orwhereRaw('upper(nombres) like ?', strtoupper($term).'%')->get(["id", "numero_documento", "apellido_paterno", "apellido_materno", "nombres"]);
		 
        return response()->json($empresas);
    }
	
	public function obtener_producto_medida($id_persona,$id_empresa,$id_producto){
		$producto_model = new Producto;
		//$tarifa = TablaMaestra::where('tipo','TARIFARIO ESPECIE')->where('codigo','1')->where('estado','A')->first();
		$unidad = $producto_model->getProductoUnidadByIdProducto($id_persona,$id_empresa,$id_producto);
		echo json_encode($unidad);
	}
	
	public function obtener_precio_producto_medida($id_persona,$id_empresa,$id_producto,$id_unidad){
		$producto_model = new Producto;
		$precio = $producto_model->obtener_precio_producto_medida($id_persona,$id_empresa,$id_producto,$id_unidad);
		echo json_encode($precio);
	}
	
	public function send_venta(Request $request)
    {
		$venta = new Venta;
		$venta->fecha = Carbon::now()->timezone('America/Lima')->format('Y-m-d H:i:s');
		if($request->persona_id>0){
			$venta->id_persona = $request->persona_id;
			$venta->id_empresa = 1;
		}else{
			$venta->id_persona = 33;
			$venta->id_empresa = $request->id_ubicacion;
		}
		$venta->estado = "1";
		$venta->save();
		$id_venta = $venta->id;
		
		$total = 0;
		if(isset($request->id_especie)):
			foreach ($request->id_especie as $key => $value):
				if($request->id_especie[$key]!=""){
					$id_especie = $request->id_especie[$key];
					$id_unidad = (isset($request->id_unidad[$key]) && $request->id_unidad[$key] > 0)?$request->id_unidad[$key]:"0";
					$precio_especie = (isset($request->precio_especie[$key]) && $request->precio_especie[$key] > 0)?$request->precio_especie[$key]:"0";
					$cantidad_especie = (isset($request->cantidad_especie[$key]) && $request->cantidad_especie[$key] > 0)?$request->cantidad_especie[$key]:"0";
					$importe_especie = (isset($request->importe_especie[$key]) && $request->importe_especie[$key] > 0)?$request->importe_especie[$key]:"0";
					
					$ventaDetalle = new VentaDetalle;
					$ventaDetalle->id_venta = $id_venta;
					$ventaDetalle->id_producto = $id_especie;
					$ventaDetalle->id_unidad = $id_unidad;
					$ventaDetalle->precio = $precio_especie;
					$ventaDetalle->cantidad = $cantidad_especie;
					$ventaDetalle->estado = "1";
					$ventaDetalle->save();
					
					$total+=$precio_especie * $cantidad_especie;
				}
			endforeach;
		endif;
		
		$venta_act = Venta::find($id_venta);
		$venta_act->total = $total;
		$venta_act->save();
		
		Session::flash('flash_message', 'Venta registrado exitosamente');
		
        echo $id_venta;
		
    }
	
	public function obtener_desembolso($idSolicitud){
		
		//$prestamoDesembolso_model = new PrestamoDesembolso();
		//$desembolso = $prestamoDesembolso_model->getDesembolsoByIdSolicitud($idSolicitud);
        $maestra_model = new TablaMaestra;
		$forma_pagos = $maestra_model->getMaestroByTipo("FPAGO");
        return view('frontend.venta.desembolso_ajax',compact('forma_pagos'/*,'desembolso'*/));

    }
	
	public function obtener_cronograma($idVenta){
		
		//$cronogramaDetalle="";
		//$crompraPago = CompraPago::where('id_compra',$idCompra)->get();
		$venta_pago_model = new VentaPago;
		$ventaPago = $venta_pago_model->getVentaPagoByIdVenta($idVenta);
		//if($cronograma)$cronogramaDetalle = CronogramaDetalle::where('id_cronograma',$cronograma->id)->get();
		return view('frontend.venta.cronograma_ajax',compact('ventaPago'));

    }
	
	public function upload(Request $request){
	
    	$filepath = public_path('img/frontend/tmp/');
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath.$_FILES["file"]["name"]);
		echo "success";
		
	}
	
	public function send_pago(Request $request){
		
		$new_ruta_desembolso =  "";
		if(isset($request->ruta_desembolso) && $request->ruta_desembolso!=""){
			$ruta_desembolso=$request->ruta_desembolso;
			$new_ruta_desembolso =  time() . '.jpg';
			$filepath = public_path('img/frontend/tmp/');
			copy($filepath.$ruta_desembolso, public_path('img/frontend/venta/pago/').$new_ruta_desembolso);
		}
		
		$ventaPago = new VentaPago;
		$ventaPago->id_venta = $request->id_solicitud;
		$ventaPago->fecha = Carbon::now()->timezone('America/Lima')->format('Y-m-d H:i:s');
		$ventaPago->id_forma_pago = $request->id_tipodesembolso;
		$ventaPago->importe = $request->importe;
		//$compraPago->ruta_pago = $new_ruta_desembolso;
		$ventaPago->estado = "1";
		$ventaPago->save();
		
	}
	
	
}
