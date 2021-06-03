<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Chofere extends Model
{
    function getChoferByIdVehiculo($idVehiculo){

        $cad = "select t1.id,t1.nro_brevete,t1.observaciones,t2.nombres||' '||t2.apellido_paterno||' '||t2.apellido_materno persona
from choferes t1
inner join personas t2 on t1.id_persona=t2.id
where t1.estado='1'
And t1.id_vehiculo='".$idVehiculo."' ";
    
        $data = DB::select($cad);
        return $data;
    }
}
