<?php

namespace App\Http\Controllers\Frontend;

use DB;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use App\Models\Empresa;
use App\Models\Vehiculo;
use App\Models\Chofere;
use Session;
use Config;

class EmpresaController extends Controller
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
		//$persona = new Persona;
		$maestra_model = new TablaMaestra;
		$motivo = $maestra_model->getMaestroByTipo("MOTIVO_S");
		$moneda = $maestra_model->getMaestroByTipo("MONEDA");
		$tipo = $maestra_model->getMaestroByTipo("TIPO_G");
        return view('frontend.empresa.all', compact('motivo','moneda','tipo'));
    }
	
	public function listar_empresa_ajax(Request $request){

		$epresa_model = new Empresa;
		$p[]=$request->numero_documento;
		$p[]=$request->nombre;
		$p[]=$request->id_estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $epresa_model->listar_empresa_ajax($p);
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
	
	public function obtener_vehiculo($idEmpresa){
		
		$vehiculo_model = new Vehiculo;
		$vehiculo = $vehiculo_model->getVehiculoByIdEmpresa($idEmpresa);
		
        return view('frontend.vehiculo.vehiculo_ajax',compact('vehiculo'));

    }
	
	public function obtener_chofer($idVehiculo){
		
		$chofer_model = new Chofere;
		$chofer = $chofer_model->getChoferByIdVehiculo($idVehiculo);
		
        return view('frontend.chofer.chofer_ajax',compact('chofer'));

    }
	
	
}
