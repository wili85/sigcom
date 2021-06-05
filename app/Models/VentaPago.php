<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class VentaPago extends Model
{
    function getVentaPagoByIdVenta($id){

        $cad = "select t1.id,t1.fecha,t1.importe,t1.numero_operacion,t2.denominacion forma_pago 
from venta_pagos t1
inner join tabla_maestras t2 on t1.id_forma_pago=t2.id
where t1.estado='1'
and t1.id_venta=".$id;

		$data = DB::select($cad);
        return $data;
    }
}
