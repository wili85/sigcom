<?php

namespace App\Http\Controllers\Frontend;

use DB;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produccione;
use App\Models\ProduccionDetalle;
use Session;
use App\Models\TablaMaestra;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\Empresa;
use Config;

class ProduccionController extends Controller
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
		
		return view('frontend.produccion.all', compact('id_user'));
    }
	
	public function listar_produccion_ajax(Request $request){

		$produccion_model = new Produccione;
		$p[]=$request->numero_documento;
		$p[]=$request->nombre;
		$p[]=$request->id_estado;
		$p[]=$request->id_estado;
		$p[]=$request->nombre;
		$p[]=$request->nombre;
		$p[]=$request->id_estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $produccion_model->listar_produccion_ajax($p);
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
		$producto = $producto_model->getProductoByIdCategoria(134);
		return view('frontend.produccion.create', compact('persona','producto'));
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
		$maestra_model = new TablaMaestra;
		$tipo="UNIDAD_MEDIDA";
		//$tarifa = TablaMaestra::where('tipo','TARIFARIO ESPECIE')->where('codigo','1')->where('estado','A')->first();
		$unidad = $producto_model->getProductoUnidadByIdProducto($id_persona,$id_empresa,$id_producto);
		if(count($unidad)==0)$unidad = $maestra_model->getMaestroByTipo($tipo);
		
		echo json_encode($unidad);
	}
	
	public function obtener_precio_producto_medida($id_persona,$id_empresa,$id_producto,$id_unidad){
		$producto_model = new Producto;
		$precio = $producto_model->obtener_precio_producto_medida($id_persona,$id_empresa,$id_producto,$id_unidad);
		echo json_encode($precio);
	}
	
	public function send_produccion(Request $request)
    {
		$produccion = new Produccione;
		$produccion->fecha = Carbon::now()->timezone('America/Lima')->format('Y-m-d H:i:s');
		$produccion->id_persona = $request->persona_id;
		$produccion->id_empresa = 1;
		$produccion->estado = "1";
		$produccion->save();
		$id_produccion = $produccion->id;
		
		if(isset($request->id_especie)):
			foreach ($request->id_especie as $key => $value):
				if($request->id_especie[$key]!=""){
					$id_especie = $request->id_especie[$key];
					$id_unidad = (isset($request->id_unidad[$key]) && $request->id_unidad[$key] > 0)?$request->id_unidad[$key]:"0";
					$precio_especie = (isset($request->precio_especie[$key]) && $request->precio_especie[$key] > 0)?$request->precio_especie[$key]:"0";
					$cantidad_especie = (isset($request->cantidad_especie[$key]) && $request->cantidad_especie[$key] > 0)?$request->cantidad_especie[$key]:"0";
					$importe_especie = (isset($request->importe_especie[$key]) && $request->importe_especie[$key] > 0)?$request->importe_especie[$key]:"0";
					
					$produccionDetalle = new ProduccionDetalle;
					$produccionDetalle->id_produccion = $id_produccion;
					$produccionDetalle->id_producto = $id_especie;
					$produccionDetalle->id_unidad = $id_unidad;
					$produccionDetalle->precio = $precio_especie;
					$produccionDetalle->cantidad = $cantidad_especie;
					$produccionDetalle->estado = "1";
					$produccionDetalle->save();
				}
			endforeach;
		endif;
		
		Session::flash('flash_message', 'Produccion registrado exitosamente');
		
        echo $id_produccion;
		
    }
	
}
