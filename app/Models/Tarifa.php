<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tarifa extends Model
{
    function getTarifaByIdPersona($idPersona){

        $cad = "select t2.id,t1.denominacion tarifa,t3.nombres||' '||t3.apellido_paterno||' '||t3.apellido_materno persona,
t4.denominacion producto,t2.precio,t5.denominacion unidad
from tarifas t1
inner join tarifa_productos t2 on t1.id=t2.id_tarifa
inner join personas t3 on t1.id_persona=t3.id
inner join productos t4 on t2.id_producto=t4.id
inner join tabla_maestras t5 on t2.id_unidad=t5.id
where t1.estado='1'
And t2.estado='1'
And t1.id_persona='".$idPersona."' ";
    
        $data = DB::select($cad);
        return $data;
    }
}
