<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona;

class PersonaController extends Controller
{
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
}
