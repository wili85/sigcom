<?php

namespace App\Http\Controllers\Frontend;

use DB;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\CompraPago;
use Session;
use App\Models\TablaMaestra;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\Empresa;
use Config;

class CompraController extends Controller
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
		
		return view('frontend.compra.all', compact('id_user'));
    }
	
	public function listar_compra_ajax(Request $request){

		$compra_model = new Compra;
		$p[]=$request->numero_documento;
		$p[]=$request->nombre;
		$p[]=$request->id_estado;
		$p[]=$request->id_estado;
		$p[]=$request->nombre;
		$p[]=$request->nombre;
		$p[]=$request->id_estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $compra_model->listar_compra_ajax($p);
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
		return view('frontend.compra.create', compact('persona','producto'));
    }
	
	public function create_desembolso()
    {
        $id_user = Auth::user()->id;
		
		return view('frontend.compra.create_desembolso', compact('id_user'));
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
	
	public function send_compra(Request $request)
    {
		$compra = new Compra;
		$compra->fecha = Carbon::now()->timezone('America/Lima')->format('Y-m-d H:i:s');
		$compra->id_persona = $request->persona_id;
		$compra->id_empresa = 1;
		$compra->estado = "1";
		$compra->save();
		$id_compra = $compra->id;
		
		if(isset($request->id_especie)):
			foreach ($request->id_especie as $key => $value):
				if($request->id_especie[$key]!=""){
					$id_especie = $request->id_especie[$key];
					$id_unidad = (isset($request->id_unidad[$key]) && $request->id_unidad[$key] > 0)?$request->id_unidad[$key]:"0";
					$precio_especie = (isset($request->precio_especie[$key]) && $request->precio_especie[$key] > 0)?$request->precio_especie[$key]:"0";
					$cantidad_especie = (isset($request->cantidad_especie[$key]) && $request->cantidad_especie[$key] > 0)?$request->cantidad_especie[$key]:"0";
					$importe_especie = (isset($request->importe_especie[$key]) && $request->importe_especie[$key] > 0)?$request->importe_especie[$key]:"0";
					
					$compraDetalle = new CompraDetalle;
					$compraDetalle->id_compra = $id_compra;
					$compraDetalle->id_producto = $id_especie;
					$compraDetalle->id_unidad = $id_unidad;
					$compraDetalle->precio = $precio_especie;
					$compraDetalle->cantidad = $cantidad_especie;
					$compraDetalle->estado = "1";
					$compraDetalle->save();
				}
			endforeach;
		endif;
		
		Session::flash('flash_message', 'Compra registrado exitosamente');
		
        echo $id_compra;
		
    }
	
	public function obtener_desembolso($idSolicitud){
		
		//$prestamoDesembolso_model = new PrestamoDesembolso();
		//$desembolso = $prestamoDesembolso_model->getDesembolsoByIdSolicitud($idSolicitud);
        $maestra_model = new TablaMaestra;
		$forma_pagos = $maestra_model->getMaestroByTipo("FPAGO");
        return view('frontend.compra.desembolso_ajax',compact('forma_pagos'/*,'desembolso'*/));

    }
	
	public function obtener_cronograma($idCompra){
		
		//$cronogramaDetalle="";
		//$crompraPago = CompraPago::where('id_compra',$idCompra)->get();
		$compra_pago_model = new CompraPago;
		$crompraPago = $compra_pago_model->getCompraPagoByIdCompra($idCompra);
		//if($cronograma)$cronogramaDetalle = CronogramaDetalle::where('id_cronograma',$cronograma->id)->get();
		return view('frontend.compra.cronograma_ajax',compact('crompraPago'));

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
			copy($filepath.$ruta_desembolso, public_path('img/frontend/compra/pago/').$new_ruta_desembolso);
		}
		
		$compraPago = new CompraPago;
		$compraPago->id_compra = $request->id_solicitud;
		$compraPago->fecha = Carbon::now()->timezone('America/Lima')->format('Y-m-d H:i:s');
		$compraPago->id_forma_pago = $request->id_tipodesembolso;
		//$compraPago->ruta_pago = $new_ruta_desembolso;
		$compraPago->estado = "1";
		$compraPago->save();
		
	}
	
	
}
