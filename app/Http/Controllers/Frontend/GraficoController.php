<?php

namespace App\Http\Controllers\Frontend;

use Arcanedev\LogViewer\Contracts\LogViewer as LogViewerContract;
use Arcanedev\LogViewer\Entities\LogEntry;
use Arcanedev\LogViewer\Entities\LogEntryCollection;
use Arcanedev\LogViewer\Exceptions\LogNotFoundException;
use Arcanedev\LogViewer\Tables\StatsTable;

use Illuminate\Http\Request;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

use App\Models\Grafico;
use App\Models\TablaMaestra;
use Config;
use Auth;

class GraficoController extends Controller
{

	protected $logViewer;
	
	public function __construct(LogViewerContract $logViewer)
    {	
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
		
        $this->logViewer = $logViewer;
    }

    public function all($anio=0){

		if($anio==0)$anio=date('Y');

		$grafico_model = new Grafico;
		
		$pagosFacMes = $grafico_model->getFacturadosPorMes($anio);
		$pagosFacDia = $grafico_model->getFacturadosPorDia($anio);		
		
		$pagosCapitalInteresMes = $grafico_model->getPagadoCapitalInteresPorMes($anio);
		$pagosCapitalInteresDia = $grafico_model->getPagadoCapitalInteresPorDia($anio);
		
		$capitalPrestadoInteresGenerado = $grafico_model->getCapitalPrestadoInteresGenerado($anio);
		$capitalPendienteInteresPendiente = $grafico_model->getCapitalPendienteInteresPendiente($anio);
		
		$capitalPrestadoInteresGeneradoMes = $grafico_model->getCapitalPrestadoInteresGeneradoPorMes($anio);
		$capitalPendienteInteresPendienteMes = $grafico_model->getCapitalPendienteInteresPendientePorMes($anio);
		
		$coleccion = $this->coleccion($pagosFacMes);
		$chartDataFacMes = json_encode([
            'labels'   => Arr::pluck($coleccion, 'label'),
            'datasets' => [
                [
                    'data'                 => Arr::pluck($coleccion, 'value'),
                    'backgroundColor'      => ["#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50"],
                    'hoverBackgroundColor' => ["#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50","#4CAF50"],
                ],
            ],
        ]);

		$coleccion = $this->coleccion($pagosFacDia);
		$chartDataFacDia = json_encode([
            'labels'   => Arr::pluck($coleccion, 'label'),
            'datasets' => [
                [
                    'data'                 => Arr::pluck($coleccion, 'value'),
                    'backgroundColor'      => ["#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff"],
                    'hoverBackgroundColor' => ["#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff","#5f9aff"],
                ],
            ],
        ]);

		$coleccion_dinamico = $this->coleccionDinamico($pagosCapitalInteresMes);
		$chartDataPagosCapitalInteresMes = json_encode($coleccion_dinamico);
		
		$coleccion_dinamico = $this->coleccionDinamico($pagosCapitalInteresDia);
		$chartDataPagosCapitalInteresDia = json_encode($coleccion_dinamico);
		
		$coleccion = $this->coleccion($capitalPrestadoInteresGenerado);
		$chartDataCapitalPrestadoInteresGenerado = json_encode([
            'labels'   => Arr::pluck($coleccion, 'label'),
            'datasets' => [
                [
                    'data'                 => Arr::pluck($coleccion, 'value'),
                    'backgroundColor'      => ["#B71C1C","#FF9100","#4CAF50","#1976D2","#90CAF9","#D32F2F","#F44336","#FF5722","#91F766","#63012F","#F6F600","#BD1049","#06007D"],
                    'hoverBackgroundColor' => ["#B71C1C","#FF9100","#4CAF50","#1976D2","#90CAF9","#D32F2F","#F44336","#FF5722","#91F766","#63012F","#F6F600","#BD1049","#06007D"],
                ],
            ],
        ]);
		
		$coleccion = $this->coleccion($capitalPendienteInteresPendiente);
		$chartDataCapitalPendienteInteresPendiente = json_encode([
            'labels'   => Arr::pluck($coleccion, 'label'),
            'datasets' => [
                [
                    'data'                 => Arr::pluck($coleccion, 'value'),
                    'backgroundColor'      => ["#B71C1C","#FF9100","#4CAF50","#1976D2","#90CAF9","#D32F2F","#F44336","#FF5722","#91F766","#63012F","#F6F600","#BD1049","#06007D"],
                    'hoverBackgroundColor' => ["#B71C1C","#FF9100","#4CAF50","#1976D2","#90CAF9","#D32F2F","#F44336","#FF5722","#91F766","#63012F","#F6F600","#BD1049","#06007D"],
                ],
            ],
        ]);
		
		
		$coleccion_dinamico = $this->coleccionDinamico($capitalPrestadoInteresGeneradoMes);
		$chartDataCapitalPrestadoInteresGeneradoMes = json_encode($coleccion_dinamico);
		
		$coleccion_dinamico = $this->coleccionDinamico($capitalPendienteInteresPendienteMes);
		$chartDataCapitalPendienteInteresPendienteMes = json_encode($coleccion_dinamico);
		
		return view('frontend.grafico.all',compact('chartDataFacMes','chartDataFacDia','chartDataPagosCapitalInteresMes','chartDataPagosCapitalInteresDia','chartDataCapitalPrestadoInteresGenerado','chartDataCapitalPendienteInteresPendiente','chartDataCapitalPrestadoInteresGeneradoMes','chartDataCapitalPendienteInteresPendienteMes','anio'));

	}

	public function coleccionSetAvanzado($area,$color){

		$totalsF = Collection::make();
		$c = 0;
		foreach($area as $level => $row){
			$totalsF->push([
				'label'     		=> $row->denominacion,
				'data'     			=> [$row->value],
				'backgroundColor' 	=> $this->color($color,$c),
			]);
			$c++;
        }
		
        return $totalsF;
    }

	public function color($color,$i){

		if($color == "verde"){
			$color_data = array("#007723","#007f2a",
			"#007527","#037624","#047725","#0A742B","#0C762D","#0E782F"/*,"#107A31"*/,"#127C33",
			"#0D903E","#119442","#169947",/*"#008732",*/"#179740","#31a84f","#4EBD56","#5BC263","#63CA6B","#70CE78","#83D18B","#90D698","#A0DAA0","#ADDEAD","#B3E4B3","#BCE5BC","#BCE5BC","#E3F3E3","#E3F3E3","#E3F3E3","#E3F3E3");
		}

		if($color == "rojo"){
			$color_data = array("#b40000","#bc0000","#c40000","#cc0000","#d41406","#dc210e","#e52b15",/*"#dd492d","#eb7154",*/"#DE1D00","#E2250C","#E52C17","#E63921","#E64131","#E74E3A","#E85B43","#EA6656","#E8715C","#EA7766","#EB8470","#ED8A7A","#F09185","#F19E8E","#F3A599","#F1B3A7","#F7BDB5","#F2C9C1","#F6D1CD","#F4DBD3");
		}
		return $color_data[$i];
	}

	public function coleccionDinamico($area){

		$totalf = Collection::make();
        $totals = Collection::make();
		$c = 0;
		$m = 0;
		$denominacion = array();
		$meses = array();
		$color = array("#B71C1C","#FF9100","#4CAF50","#1976D2","#90CAF9","#D32F2F","#F44336","#FF5722","#91F766","#63012F","#F6F600","#BD1049","#06007D","#06007D","#06007D","#06007D");
		$d = 0;
		foreach($area as $level => $row){
			if(!in_array($row->denominacion, $denominacion)){
				$denominacion[$row->denominacion] = $row->denominacion;
				$colorden[$row->denominacion] = $color[$d];
				$d++;
			}
		}

		foreach($area as $level => $row){
			if(!in_array($row->label, $meses))$meses[] = $row->label;
		}

		$c = 0;
		//print_r($denominacion);
		foreach($denominacion as $den){//areas de los planes
			$m=0;
			foreach($meses as $k=>$mes){//meses
				foreach($area as $level => $row){//recorre la data
					if($den == $row->denominacion && $mes == $row->label){
						$row->color = $color[$c];
						$dataDenominacion[$den][$k] = $row;
					}
				}

				if(!isset($dataDenominacion[$den][$k])){
					$row_ = new \stdClass();
					$row_->color = $color[$c];
					$row_->value = "0";
					$dataDenominacion[$den][$k] = $row_;
				}

				$m++;
			}
			$c++;
		}

		foreach($denominacion as $den){
			$totals->push([
				'label'     		=> $den,
				'data'     			=> Arr::pluck($dataDenominacion[$den], 'value'),
				'backgroundColor'   => Arr::pluck($dataDenominacion[$den], 'color'),
			]);
		}

		$totalf->put("labels", $meses);
		$totalf->put("datasets", $totals->toArray());

        return $totalf;
    }

	public function coleccion($area){
        $totals = Collection::make();

		foreach($area as $level => $row){
            $totals->put($level, [
				'label'     => $row->label,
                'value'     => $row->value,
            ]);
        }

        return $totals;
    }

	public function coleccionSet($area,$denominacion){
        $totals = Collection::make();

		foreach($area as $level => $row){
			if($denominacion == $row->denominacion){
				$totals->put($level, [
					'label'     => $row->label,
					'value'     => $row->value,
				]);
			}
        }

		$meses = array("06","07","08","09","10","11","12");
		foreach($meses as $m){
			if(!in_array($m, $totals->toArray())){
				$totals->put($m, [
					'label'     => $m,
					'value'     => 0,
				]);
			}
		}

        return $totals;
    }


}
