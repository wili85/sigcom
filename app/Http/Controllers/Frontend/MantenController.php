<?php

namespace App\Http\Controllers\Frontend;

use DB;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\TablaMaestra;
use Config;

class MantenController extends Controller
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
	
    public function create()
    {

        $id_user = Auth::user()->id;
		//$persona = new Persona;
		$maestra_model = new TablaMaestra;
		$tipo = $maestra_model->getTipo();
		//$moneda = $maestra_model->getMaestroByTipo("MONEDA");
        //$tipo = $maestra_model->getMaestroByTipo("TIPO_G");

        return view('frontend.manten.create', compact('id_user','tipo'));
    }
	
	public function create_color()
    {
        $id_user = Auth::user()->id;
        return view('frontend.manten.create_color', compact('id_user'));
    }

    public function listar_maestra_ajax(Request $request){

		$maestra_model = new TablaMaestra;
		$p[]=$request->tipo;
		$p[]=$request->denominacion;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $maestra_model->listar_maestra_ajax($p);
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
	public function obtener_maestra($id){
		$maestra_model = new TablaMaestra;
		$maestra = $maestra_model->getMaestroById($id);
		//echo $id;
		$array["maestra"] = $maestra;
		//echo $array;
		echo json_encode($array);
    }


    /*
    public function obtener_solicitud($id){
		$solicitud_model = new Solicitude;
		$solicitud = $solicitud_model->getSolicitudById($id);
		$garantia = $solicitud_model->getGarantiaByIdSolicitud($id);
		$array["solicitud"] = $solicitud;
		$array["garantia"] = $garantia;
		echo json_encode($array);
    }
    */

	public function send(Request $request){

		//  print "Guardar";
  /*
		  if(isset($request->id_servicio)):
			  foreach ($request->id_servicio as $key => $value):
				  if($request->id_servicio[$key]!=""){
					  $id_servicio = $request->id_servicio[$key];
					  $id_usuario_servicio = (isset($request->id_usuario_servicio[$key]) && $request->id_usuario_servicio[$key] > 0)?$request->id_usuario_servicio[$key]:"0";
  
					  if($id_usuario_servicio > 0){
						  $userServicio = UserServicio::find($id_usuario_servicio);
						  $userServicio->id_usuario = $request->id_usuario;
						  $userServicio->id_servicio = $id_servicio;
						  $userServicio->id_punto_acceso = 0;
						  $userServicio->estado = 1;
						  $userServicio->save();
					  }else{
						  $userServicio = new UserServicio;
						  $userServicio->id_usuario = $request->id_usuario;
						  $userServicio->id_servicio = $id_servicio;
						  $userServicio->id_punto_acceso = 0;
						  $userServicio->estado = 1;
						  $userServicio->save();
					  }
				  }
  
				  if($request->id_servicio[$key]==""){
					  $id_usuario_servicio = (isset($request->id_usuario_servicio[$key]) && $request->id_usuario_servicio[$key] > 0)?$request->id_usuario_servicio[$key]:"0";
					  if($id_usuario_servicio > 0){
						  $userServicio = UserServicio::find($id_usuario_servicio);
						  $userServicio->estado = 0;
						  $userServicio->save();
					  }
				  }
  
			  endforeach;
		  endif;
		  */
  
  
  
		  //$id_user = Auth::user()->id;
  
		  //$id_tablaMaestra =  UserServicio::find($id_usuario_servicio);
		  if($request->id_maestra > 0){
			  print "Existe";
  
			  $tablaMaestra = TablaMaestra::find($request->id_maestra );
			  //$tablaMaestra->id = $request->id_maestra;
			  $tablaMaestra->tipo = $request->tipo;
			  $tablaMaestra->denominacion = $request->denominacion;
			  $tablaMaestra->acronimo = $request->acronimo;
			  $tablaMaestra->orden = $request->orden;
			  $tablaMaestra->id_parent = $request->id_parent;
			  //$tablaMaestra->tipo_nombre = $request->tipo;
			  $tablaMaestra->estado = $request->estado;
			  $tablaMaestra->variable1 = $request->var1;
			  $tablaMaestra->variable2 = $request->var2;
			  $tablaMaestra->variable3 = $request->var3;
  
			  $tablaMaestra->save();
  
		  }
		  else{
			  print "Nuevo";
			  $tablaMaestra = new TablaMaestra;
  
			  //$tablaMaestra->id = $request->id_maestra;
			  $tablaMaestra->tipo = $request->tipo;
			  $tablaMaestra->denominacion = $request->denominacion;
			  $tablaMaestra->acronimo = $request->acronimo;
			  $tablaMaestra->orden = $request->orden;
			  $tablaMaestra->id_parent = $request->id_parent;
			  //$tablaMaestra->tipo_nombre = $request->tipo;
			  $tablaMaestra->estado = 'A';
			  $tablaMaestra->variable1 = $request->var1;
			  $tablaMaestra->variable2 = $request->var2;
			  $tablaMaestra->variable3 = $request->var3;
  
			  $tablaMaestra->save();
			  //print $tablaMaestra;
  
		  }
  
		  //$tablaMaestra->save();
		  //$idtablamaestra= $tablaMaestra->id;
  
		  //id, tipo, denominacion, acronimo, orden, codigo, tipo_nombre, estado
		  /*
		  echo $solicitud->id;
		  */
  
  
  
	  }
	
	public function send_color(Request $request){
		
		$codigo = $request->change_color;
		$tipo_nombre = $request->background;
		$tablaMaestra = TablaMaestra::where('tipo','CSS')->where('codigo',$codigo)->first();
		$tablaMaestra->tipo_nombre = $tipo_nombre;
		$tablaMaestra->save();
		
	}
	
	public function send_restablecer_color(Request $request){
		
		$tablaMaestra = TablaMaestra::where('tipo','CSS')->where('codigo',1)->first();
		$tablaMaestra->tipo_nombre = "rgba(146,130,130,0.73)";
		$tablaMaestra->save();
		
		$tablaMaestra = TablaMaestra::where('tipo','CSS')->where('codigo',2)->first();
		$tablaMaestra->tipo_nombre = "rgba(236,241,235,0.12)";
		$tablaMaestra->save();
		
		$tablaMaestra = TablaMaestra::where('tipo','CSS')->where('codigo',3)->first();
		$tablaMaestra->tipo_nombre = "#46d46e";
		$tablaMaestra->save();
		
		$tablaMaestra = TablaMaestra::where('tipo','CSS')->where('codigo',4)->first();
		$tablaMaestra->tipo_nombre = "#239244";
		$tablaMaestra->save();
		
		$tablaMaestra = TablaMaestra::where('tipo','CSS')->where('codigo',5)->first();
		$tablaMaestra->tipo_nombre = "#4cb954";
		$tablaMaestra->save();
		
		$tablaMaestra = TablaMaestra::where('tipo','CSS')->where('codigo',6)->first();
		$tablaMaestra->tipo_nombre = "#F2F2F2";
		$tablaMaestra->save();
		
		$tablaMaestra = TablaMaestra::where('tipo','CSS')->where('codigo',7)->first();
		$tablaMaestra->tipo_nombre = "#30b73c";
		$tablaMaestra->save();
		
		$tablaMaestra = TablaMaestra::where('tipo','CSS')->where('codigo',8)->first();
		$tablaMaestra->tipo_nombre = "#e7e7e7";
		$tablaMaestra->save();
		
		return redirect('/manten/create_color');
		
	}
	
	
	
	
}
