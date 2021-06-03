<?php

namespace App\Http\Controllers\Frontend;

use DB;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona;
use Session;
use App\Models\TablaMaestra;
use App\Models\Tarifa;
use Config;

class PersonaController extends Controller
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
	
    public function obtener_persona($tipo_documento,$numero_documento){
		
		$sw = 1;//encontrado en Felmo
		$persona = Persona::where('tipo_documento',$tipo_documento)->where('numero_documento',$numero_documento)->where('estado','A')->first();
		
		if(!$persona){
		
			$persona_model = new Persona;
			$persona = $persona_model->getPersona($tipo_documento,$numero_documento);
				
			if(!$persona){
				$sw = 3;//no existe
				
				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);
				$url ='https://api.reniec.cloud/dni/'.$numero_documento;			
				$json = file_get_contents($url,false, stream_context_create($arrContextOptions));
				$datos = json_decode($json,true);
				
				if(sizeof($datos)>1){
					$persona = new Persona;
					$persona->numero_documento = $datos['dni'];
					$persona->apellido_paterno = $datos['apellido_paterno'];
					$persona->apellido_materno = $datos['apellido_materno'];
					$persona->nombres = $datos['nombres'];
					$sw = 2;//encontrado en Reniec
				}
				
			}
		}
		
		//$sw = true;
        $array["sw"] = $sw;
        $array["persona"] = $persona;
        echo json_encode($array);

    }
	
	public function listar()
    {
		$id_user = Auth::user()->id;
		//$persona = new Persona;
		$maestra_model = new TablaMaestra;
		$motivo = $maestra_model->getMaestroByTipo("MOTIVO_S");
		$moneda = $maestra_model->getMaestroByTipo("MONEDA");
		$tipo = $maestra_model->getMaestroByTipo("TIPO_G");
        return view('frontend.persona.all', compact('motivo','moneda','tipo'));
    }
	
	public function listar_persona_ajax(Request $request){

		$persona_model = new Persona;
		$p[]=$request->numero_documento;
		$p[]=$request->nombre;
		$p[]=$request->id_estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $persona_model->listar_persona_ajax($p);
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
	
	public function obtener_tarifa($idPersona){
		
		$tarifa_model = new Tarifa;
		$tarifa = $tarifa_model->getTarifaByIdPersona($idPersona);
		
        return view('frontend.tarifa.tarifa_ajax',compact('tarifa'));

    }
		
}
