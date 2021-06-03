<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class TablaMaestra extends Model
{
    public function listar_maestra_ajax($p){
        return $this->readFunctionPostgres('sp_listar_tabla_maestra_paginado',$p);
    }

    function getMaestro(){

        $cad = "select id, tipo, denominacion, acronimo, orden, codigo, tipo_nombre,
        estado,id_parent from tabla_maestras order by tipo, orden";

		$data = DB::select($cad);
        return $data;
    }

	function getMaestroByTipoCodigo($tipo, $codigo){

        $cad = "select id,denominacion 
                from tabla_maestras 
                where tipo='".$tipo."' 
                and codigo like '".$codigo."%'
                order by orden ";
    
		$data = DB::select($cad);
        return $data;
    }

    function getMaestroByTipo($tipo){

        $cad = "select id,denominacion,codigo 
                from tabla_maestras
                where tipo='".$tipo."' and estado = 'A'
                order by orden ";

		$data = DB::select($cad);
        return $data;

    }
	
	function getCss($id_user){
		
        $cad = "select id,codigo,denominacion,tipo_nombre
                from tabla_maestras
                where tipo='CSS' and estado = 'A'
                order by orden ";
		
		$data = DB::select($cad);
		
		//print_r($data);
		
		$contents = ".navbar-nav .nav-link{color:#ffffff!important}";
		$contents .= ".breadcrumb{border-radius:initial!important}";
		
		foreach($data as $row){
			switch ($row->codigo) {
				case 1:
					//Fondo Principal
					$contents .= "body{background-color:".$row->tipo_nombre."!important}";
					break;
				case 2:
					//Fondo Secundario
					$contents .= ".card .card-body{background-color:".$row->tipo_nombre."!important}";
					break;
				case 3:
					//barra de titulos
					$contents .= ".navbar{background-color:".$row->tipo_nombre."!important}";
					break;
				case 4:
					//barra de subtitulos
					$contents .= ".breadcrumb{background-color:".$row->tipo_nombre."!important}";
					$contents .= ".breadcrumb li{color:#161C2D!important;font-weight:bold}";
					$contents .= ".table-hover tbody tr.row_selected td{background-color:".$row->tipo_nombre."!important;color:#ffffff!important}";
					break;
				case 5:
					//Card titulos
					$contents .= ".card-header{background-color:".$row->tipo_nombre."!important}";
					$contents .= ".card-header .row div{background-color:".$row->tipo_nombre."!important}";
					$contents .= ".card-header{color:#ffffff!important}";
					break;
				case 6:
					//Card Cuerpo
					$contents .= ".form-horizontal .card .card-body{background-color:".$row->tipo_nombre."!important}";
					$contents .= ".form-horizontal .card .card-body .row{background-color:".$row->tipo_nombre."!important}";
					$contents .= ".form-horizontal .card{background-color:".$row->tipo_nombre."!important}";
					break;
				case 7:
					//tabla Titulo
					$contents .= ".table th{background-color:".$row->tipo_nombre."!important}";
					$contents .= ".table th{color:#161C2D!important;font-weight:bold}";
					$contents .= ".table-hover tbody tr:hover td, .table-hover tbody tr:hover th {background-color:".$row->tipo_nombre."!important;color:#ffffff!important}";
					
					$contents .= ".table-hover-grid tbody tr.odd:hover td{background-color:".$row->tipo_nombre."!important;color:#ffffff!important}";
					$contents .= ".table-hover-grid tbody tr.even:hover td{background-color:".$row->tipo_nombre."!important;color:#ffffff!important}";
					
					//$contents .= ".table-hover tbody tr.row_selected td{background-color:".$row->tipo_nombre."!important;color:#ffffff!important}";
					break;
				case 8:
					//tabla Cuerpo
					$contents .= ".table td{background-color:".$row->tipo_nombre."!important}";
					break;
				default:
					//echo "esta regla es por defecto";
				}
		}
		
		/*
		$contents = ".navbar-nav .nav-link{color:#ffffff!important}";
		$contents .= ".breadcrumb{border-radius:initial!important}";
		
		//Fondo Principal
		$contents .= "body{background-color:blue!important}";
		//Fondo Secundario
		$contents .= ".card .card-body{background-color:#00acee!important}";
		
		//barra de titulos
		$contents .= ".navbar{background-color:red!important}";
		//barra de subtitulos
		$contents .= ".breadcrumb{background-color:yellow!important}";
		
		//Card titulos
		$contents .= ".card-header{background-color:green!important}";
		$contents .= ".card-header .row div{background-color:green!important}";
		$contents .= ".card-header{color:#ffffff!important}";
		//Card Cuerpo
		$contents .= ".form-horizontal .card .card-body{background-color:orange!important}";
		$contents .= ".form-horizontal .card .card-body .row{background-color:orange!important}";
		$contents .= ".form-horizontal .card{background-color:orange!important}";
		
		//tabla Titulo
		$contents .= ".table th{background-color:red!important}";
		//tabla Cuerpo
		$contents .= ".table td{background-color:#00acee!important}";
		//table table-hover table-sm dataTable no-footer
		*/
        return $contents;

    }



	function getMaestroByTipoAndParent($tipo,$id_parent){

        $cad = "select id,denominacion
                from tabla_maestras
                where tipo='".$tipo."'
				And estado = 'A'
				And id_parent=".$id_parent."
                order by orden ";

		$data = DB::select($cad);
        return $data;

    }



    function getMaestroById($id){

        $cad = "select id, tipo, denominacion, acronimo, orden, id_parent, estado, variable1, variable2, variable3
                from tabla_maestras
                Where id=".$id;

		$data = DB::select($cad);
        return $data[0];
    }

	function getFechaHoraServidor(){

        $cad = "select to_char(now(),'YYYY-mm-dd HH24:mi:ss') as fecha_servidor";

		$data = DB::select($cad);
        return $data[0]->fecha_servidor;
    }

	function getFechaServidor(){

        $cad = "select to_char(now(),'dd-mm-YYYY') as fecha_servidor";

		$data = DB::select($cad);
        return $data[0]->fecha_servidor;
    }

	function getTipo(){

        $cad = "select distinct tipo,(case when tipo='CSS' then tipo else tipo_nombre end)tipo_nombre 
				from tabla_maestras 
				order by 1";

		$data = DB::select($cad);
        return $data;
    }

	

    public function readFunctionPostgres($function, $parameters = null){

        $_parameters = '';
        if (count($parameters) > 0) {
            $_parameters = implode("','", $parameters);
            $_parameters = "'" . $_parameters . "',";
        }
        $data = DB::select("BEGIN;");
        $cad = "select " . $function . "(" . $_parameters . "'ref_cursor');";
        //echo $cad;
        $data = DB::select($cad);
        $cad = "FETCH ALL IN ref_cursor;";
        $data = DB::select($cad);
        return $data;
     }

     public function readFunctionPostgresTransaction($function, $parameters = null){

        $_parameters = '';
        if (count($parameters) > 0) {

              foreach($parameters as $par){
                  if(is_string($par))$_parameters .= "'" . $par . "',";
                  else $_parameters .= "" . $par . ",";
                }
              if(strlen($_parameters)>1)$_parameters= substr($_parameters,0,-1);

        }

        $cad = "select " . $function . "(" . $_parameters . ");";
        $data = DB::select($cad);
        return $data[0]->$function;
     }

}
