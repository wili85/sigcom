<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Vehiculo extends Model
{
    function getVehiculoByIdEmpresa($idEmpresa){

        $cad = "select t1.id,t2.denominacion tipo_vehiculo,t1.placa,t1.ejes,t1.peso_seco
from vehiculos t1
inner join tabla_maestras t2 on t1.id_tipo_vehiculo=t2.id
where t1.estado='1'
And t2.estado='A'
And t1.id_empresa='".$idEmpresa."' ";
    
        $data = DB::select($cad);
        return $data;
    }
}
