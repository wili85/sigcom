<?php

namespace App\Http\Controllers\Frontend;

use DB;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Mail;
use Config;
use App\Models\TablaMaestra;
use App\Models\Persona;
use App\Models\Cronograma;

class CronogramaController extends Controller
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
	
	public function create_ingreso(){
		$id_user = Auth::user()->id;
        $persona = new Persona;
        //$caja_model = new TablaMaestra;
        //$valorizaciones_model = new Valorizacione;
        //$caja = $caja_model->getCaja('CAJA');
        //$caja_usuario = $valorizaciones_model->getCajaIngresoByusuario($id_user,'CAJA');
        return view('frontend.cronograma.create_ingreso',compact('persona'/*,'caja','caja_usuario'*/));

    }
	
	public function obtener_cronograma($tipo_documento,$persona_id){

        $cronograma_model = new Cronograma;
        $sw = true;
        $cronograma = $cronograma_model->getCronograma($tipo_documento,$persona_id);
        return view('frontend.cronograma.lista_cronograma_ajax',compact('cronograma'));

    }
	
	public function obtener_pago($tipo_documento,$persona_id){

        $cronograma_model = new Cronograma;
        $sw = true;
        $pago = $cronograma_model->getPago($tipo_documento,$persona_id);
        return view('frontend.cronograma.lista_pago_ajax',compact('pago'));

    }
	
	public function modal_cronograma_factura($id){
		
		$cronograma_model = new Cronograma;
		$cronograma = $cronograma_model->getCronogramaFactura($id);
		return view('frontend.cronograma.modal_cronograma_factura',compact('cronograma'));
	
	}
	
	
}
