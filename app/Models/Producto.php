<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Producto extends Model
{
    function getProductoByIdCategoria($id){

        $cad = "select t1.id,t1.denominacion 
from productos t1
where t1.estado='1'
and t1.id_categoria=".$id;
    
		$data = DB::select($cad);
        return $data;
    }
	
	function getProductoUnidadByIdProducto(/*$id_tarifa,*/$id_persona,$id_empresa,$id_producto){

        $cad = "select distinct t3.id,t3.denominacion
from tarifas t1
inner join tarifa_productos t2 on t1.id=t2.id_tarifa
inner join tabla_maestras t3 on t2.id_unidad=t3.id
where t1.estado='1'
And t2.estado='1' 
And t1.id_persona=".$id_persona."
And t2.id_producto=".$id_producto;

		$data = DB::select($cad);
        return $data;
    }
	
	function obtener_precio_producto_medida($id_persona,$id_empresa,$id_producto,$id_unidad){

        $cad = "select distinct t2.precio
from tarifas t1
inner join tarifa_productos t2 on t1.id=t2.id_tarifa
where t1.estado='1'
And t2.estado='1'
And t1.id_persona=".$id_persona."
And t2.id_producto=".$id_producto."
And t2.id_unidad=".$id_unidad;

		$data = DB::select($cad);
        return $data;
    }
	
}
