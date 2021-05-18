<?php 

namespace App\Http\Controllers\Frontend;

use DB;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Solicitude;
use App\Models\TablaMaestra;
use App\Models\Persona;
use App\Models\GarantiaDetalle;
use App\Models\Auth\User;
//use Response;
use Config;
//use View;

class SolicitudController extends Controller
{
	protected $response;

    public function create()
    {
		$id_user = Auth::user()->id;
		$persona = new Persona;
		$maestra_model = new TablaMaestra;
		$motivo = $maestra_model->getMaestroByTipo("MOTIVO_S");
		$moneda = $maestra_model->getMaestroByTipo("MONEDA");
		$tipo = $maestra_model->getMaestroByTipo("TIPO_G");
		$periodo = $maestra_model->getMaestroByTipo("PERIODO");
        return view('frontend.solicitud.create', compact('motivo','moneda','persona','tipo','periodo'));
    }
	
	public function create_desembolso()
    {
		$id_user = Auth::user()->id;
		$persona = new Persona;
		$maestra_model = new TablaMaestra;
		$motivo = $maestra_model->getMaestroByTipo("MOTIVO_S");
		$moneda = $maestra_model->getMaestroByTipo("MONEDA");
		$tipo = $maestra_model->getMaestroByTipo("TIPO_G");
        return view('frontend.solicitud.create_desembolso', compact('motivo','moneda','persona','tipo'));
    }
	
	public function listar_solicitud_ajax(Request $request){

		$solicitud_model = new Solicitude;
		$p[]="0";
		$p[]=$request->numero_documento;
		$p[]=$request->nombre;
		$p[]=$request->fecha_desde;
		$p[]=$request->fecha_hasta;
		$p[]=$request->id_estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $solicitud_model->listar_solicitud_ajax($p);
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
	
	public function listar_desembolso_ajax(Request $request){

		$solicitud_model = new Solicitude;
		$p[]="0";
		$p[]=$request->numero_documento;
		$p[]=$request->nombre;
		$p[]=$request->fecha_desde;
		$p[]=$request->fecha_hasta;
		$p[]=$request->id_estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $solicitud_model->listar_solicitud_ajax($p);
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
	
	public function obtener_solicitud($id){
		$solicitud_model = new Solicitude;
		$solicitud = $solicitud_model->getSolicitudById($id);
		$garantia = $solicitud_model->getGarantiaByIdSolicitud($id);
		$array["solicitud"] = $solicitud;
		$array["garantia"] = $garantia;
		echo json_encode($array);
	}
	
	public function modal_solicitud($id){
		$id_user = Auth::user()->id;
		$solicitud_model = new Solicitude;
		$maestra_model = new TablaMaestra;
		$fecha_actual = Carbon::now()->timezone('America/Lima')->format('Y-m-d H:i:s');
		$solicitud = $solicitud_model->getSolicitudById($id);
		$usuario = User::find($id_user);
		$periodo = $maestra_model->getMaestroByTipo("PERIODO");
		return view('frontend.solicitud.modal_solicitud',compact('id','fecha_actual','solicitud','usuario','periodo'));
	
	}
	
	public function send_solicitud_aprobar(Request $request){
	
		$id_user = Auth::user()->id;
		$tna = round(($request->tna)/100,2);
		
		$solicitud = Solicitude::find($request->id_solicitud);
		$solicitud->monto_aprobado = $request->monto_aprobado;
		$solicitud->fecha_aprobacion = Carbon::now()->timezone('America/Lima')->format('Y-m-d H:i:s');
		$solicitud->id_aprobador = $id_user;
		$solicitud->tna = $tna;
		$solicitud->tiempo_pago = $request->tiempo_pago;
		$solicitud->nro_cuota = $request->nro_cuota;
		$solicitud->freecuencia_pago = $request->freecuencia_pago;
		$solicitud->periodo_gracia = $request->periodo_gracia;
		$solicitud->id_estado = $request->id_estado;//3;
		$solicitud->save();
		//echo $solicitud->id;
    }
	
	public function send(Request $request){
		
		$id_user = Auth::user()->id;
		$persona_model = new Persona;
		$id_solicitud = $request->id_solicitud;
		
		if(auth()->user()->hasAnyRole("valorizador")){
			$monto_valorizado=0;
			//if(isset($request->id_tipo)):
			if(isset($request->valor_garantia)):
				//foreach ($request->id_tipo as $key => $value):
				foreach ($request->valor_garantia as $key => $value):
					//if($request->id_tipo[$key]!=""){
					if($request->valor_garantia[$key]!=""){
						$valor_garantia = (isset($request->valor_garantia[$key]) && $request->valor_garantia[$key] > 0)?$request->valor_garantia[$key]:"0";
						$id_garantia_detalle = (isset($request->id_garantia_detalle[$key]) && $request->id_garantia_detalle[$key] > 0)?$request->id_garantia_detalle[$key]:"0";
						
						if($id_garantia_detalle > 0){
							$garantiaDetalle = GarantiaDetalle::find($id_garantia_detalle);
							$garantiaDetalle->valor_garantia = $valor_garantia;
							$garantiaDetalle->save();
							$monto_valorizado+=$valor_garantia;
						}
						
					}
				endforeach;
			endif;	
			
			$solicitud = Solicitude::find($id_solicitud);
			$solicitud->monto_valorizado = $monto_valorizado;
			$solicitud->fecha_valoriza = Carbon::now()->timezone('America/Lima')->format('Y-m-d H:i:s');
			$solicitud->id_valorizador = $id_user;
			$solicitud->id_estado_valoriza = 1;
			$solicitud->id_estado = 2;
			$solicitud->save();
				
		}else{
		
			if($id_solicitud == 0){
			
				$persona = Persona::where('tipo_documento',$request->tipo_documento)->where('numero_documento',$request->numero_documento)->where('estado','A')->first();
				if($persona){
					$idPersona = $persona->id;
				}else{
					$personaFelmo = $persona_model->getPersona($request->tipo_documento,$request->numero_documento);
					
					if($personaFelmo){
						$persona = new Persona;
						$persona->codigo = $personaFelmo->codigo;
						$persona->tipo_documento = $personaFelmo->tipo_documento;
						$persona->numero_documento = $personaFelmo->numero_documento;
						$persona->nombres = $personaFelmo->nombres;
						$persona->apellido_paterno = $personaFelmo->apellido_paterno;
						$persona->apellido_materno = $personaFelmo->apellido_materno;
						$persona->fecha_nacimiento = $personaFelmo->fecha_nacimiento;
						$persona->sexo = $personaFelmo->sexo;
						$persona->telefono = $personaFelmo->telefono;
						$persona->email = $personaFelmo->email;
						$persona->foto = $personaFelmo->foto;
						$persona->estado = $personaFelmo->estado;
						$persona->save();
						$idPersona = $persona->id;
						
					}else{
						$arrContextOptions=array(
							"ssl"=>array(
								"verify_peer"=>false,
								"verify_peer_name"=>false,
							),
						);
						$url ='https://api.reniec.cloud/dni/'.$request->numero_documento;
						$json = file_get_contents($url,false, stream_context_create($arrContextOptions));
						$datos = json_decode($json,true);
						
						if(sizeof($datos)>1){
						
							$telefono = $request->telefono;
							$email = $request->email;
							$array_tipo_documento = array('DNI' => 'DNI','CARNET_EXTRANJERIA' => 'CE','PASAPORTE' => 'PAS','RUC' => 'RUC','CEDULA' => 'CED','PTP/PTEP' => 'PTP/PTEP');
							$codigo = $array_tipo_documento[$request->tipo_documento]."-".$request->numero_documento;
							if($telefono=="")$telefono="999999999";
							if($email=="")$email="mail@mail.com";
							
							$persona = new Persona;
							$persona->codigo = $codigo;
							$persona->tipo_documento = $request->tipo_documento;
							$persona->numero_documento = $datos['dni'];
							$persona->nombres = $datos['nombres'];
							$persona->apellido_paterno = $datos['apellido_paterno'];
							$persona->apellido_materno = $datos['apellido_materno'];
							$persona->fecha_nacimiento = "1990-01-01";
							$persona->sexo = "M";
							$persona->telefono = $telefono;
							$persona->email = $email;
							$persona->foto = "mail@mail.com";
							$persona->estado = "A";
							$persona->save();
							$idPersona = $persona->id;
						}
					}
				}
				
				$solicitud = new Solicitude;
				$solicitud->fecha_solicitud = Carbon::now()->timezone('America/Lima')->format('Y-m-d H:i:s');
				$solicitud->id_persona = $idPersona;
				
				$solicitud->monto_solicitado = $request->monto_solicitado;
				$solicitud->id_motivo = $request->id_motivo;
				$solicitud->id_moneda = $request->id_moneda;
				$solicitud->tiempo_pago = $request->tiempo_pago;
				$solicitud->nro_cuota = $request->nro_cuota;
				$solicitud->freecuencia_pago = $request->freecuencia_pago;
				$solicitud->requiere_garantia = 'S';
				$solicitud->id_usuario = $id_user;
				$solicitud->id_evaluador = $id_user;
				$solicitud->id_estado = 1;
				$solicitud->eliminado = 'N';
				$solicitud->save();
				$idSolicitud = $solicitud->id;
			
				if(isset($request->id_tipo)):
					foreach ($request->id_tipo as $key => $value):
						if($request->id_tipo[$key]!=""){
							$id_tipo = $request->id_tipo[$key];
							$descripcion = (isset($request->descripcion[$key]))?$request->descripcion[$key]:"";
							$valor_actual = (isset($request->valor_actual[$key]) && $request->valor_actual[$key] > 0)?$request->valor_actual[$key]:"0";
							
							$garantiaDetalle = new GarantiaDetalle;
							$garantiaDetalle->id_solicitud = $idSolicitud;
							$garantiaDetalle->id_tipo = $id_tipo;
							$garantiaDetalle->cantidad = 1;
							$garantiaDetalle->descripcion = $descripcion;
							$garantiaDetalle->valor_actual = $valor_actual;
							$garantiaDetalle->estado = "A";
							$garantiaDetalle->save();
						}
					endforeach;
				endif;
			
			}else{
				
				$solicitud = Solicitude::find($id_solicitud);
				$solicitud->monto_solicitado = $request->monto_solicitado;
				$solicitud->id_motivo = $request->id_motivo;
				$solicitud->id_moneda = $request->id_moneda;
				$solicitud->tiempo_pago = $request->tiempo_pago;
				$solicitud->nro_cuota = $request->nro_cuota;
				$solicitud->freecuencia_pago = $request->freecuencia_pago;
				$solicitud->save(); 
				
				if(isset($request->id_tipo)):
					foreach ($request->id_tipo as $key => $value):
						if($request->id_tipo[$key]!=""){
							$id_tipo = $request->id_tipo[$key];
							$descripcion = (isset($request->descripcion[$key]))?$request->descripcion[$key]:"";
							$valor_actual = (isset($request->valor_actual[$key]) && $request->valor_actual[$key] > 0)?$request->valor_actual[$key]:"0";
							$id_garantia_detalle = (isset($request->id_garantia_detalle[$key]) && $request->id_garantia_detalle[$key] > 0)?$request->id_garantia_detalle[$key]:"0";
							
							if($id_garantia_detalle > 0){
								$garantiaDetalle = GarantiaDetalle::find($id_garantia_detalle);
								$garantiaDetalle->id_tipo = $id_tipo;
								$garantiaDetalle->cantidad = 1;
								$garantiaDetalle->descripcion = $descripcion;
								$garantiaDetalle->valor_actual = $valor_actual;
								$garantiaDetalle->estado = "A";
								$garantiaDetalle->save();
							}else{
								$garantiaDetalle = new GarantiaDetalle;
								$garantiaDetalle->id_solicitud = $id_solicitud;
								$garantiaDetalle->id_tipo = $id_tipo;
								$garantiaDetalle->cantidad = 1;
								$garantiaDetalle->descripcion = $descripcion;
								$garantiaDetalle->valor_actual = $valor_actual;
								$garantiaDetalle->estado = "A";
								$garantiaDetalle->save();
							}
						}
					endforeach;
				endif;
				
			}
		
		}
			
	}
	
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
	
	public function create_test()
    {
		/*$response = ".navbar-nav .nav-link{color:#ffffff!important}
				.breadcrumb{border-radius:initial!important}";*/
    	//$response = Response::make($contents);
    	//$response->header('Content-Type', 'text/css');
		//$response = $this->response;
		//$id_user = Auth::user()->id;
		//echo $id_user;
		//exit();
		$persona = new Persona;
		$maestra_model = new TablaMaestra;
		$motivo = $maestra_model->getMaestroByTipo("MOTIVO_S");
		$moneda = $maestra_model->getMaestroByTipo("MONEDA");
		$tipo = $maestra_model->getMaestroByTipo("TIPO_G");
        return view('frontend.solicitud.create', compact('motivo','moneda','persona','tipo'));
    }	
	
	
}
