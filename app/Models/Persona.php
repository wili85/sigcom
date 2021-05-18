<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Persona extends Model
{
    // contantes SEXO
    const SEXO_FEMENINO = 'F';
    const SEXO_MASCULINO = 'M';
    // contantes TIPO DOCUMENTO
    const TIPO_DOCUMENTO_DNI = 'DNI';
    const TIPO_DOCUMENTO_CARNET_EXTRANJERIA = 'CARNET_EXTRANJERIA';
    const TIPO_DOCUMENTO_PASAPORTE = 'PASAPORTE';
    const TIPO_DOCUMENTO_RUC = 'RUC';
    const TIPO_DOCUMENTO_CEDULA = 'CEDULA';
    const TIPO_DOCUMENTO_PTP = 'PTP/PTEP';

	function getPersona($tipo_documento,$numero_documento){

        if($tipo_documento=="RUC"){
            /*$cad = "select t1.id,razon_social,t1.direccion,t1.representante,t2.id id_ubicacion
                    from empresas t1
                    inner join ubicacion_trabajos t2 on t1.id=t2.ubicacion_empresa_id
                    Where t1.ruc='".$numero_documento."'";*/

        }else{
            $cad = "Select codigo,tipo_documento,numero_documento,nombres,apellido_paterno,apellido_materno,fecha_nacimiento::date,sexo,telefono,email,foto,'A' estado From dblink ('dbname=".config('values.dblink_dbname')." port=".config('values.dblink_port')." host=".config('values.dblink_host')." user=".config('values.dblink_user')." password=".config('values.dblink_password')."','select codigo,tipo_documento,numero_documento,nombres,apellido_paterno,apellido_materno,fecha_nacimiento,sexo,telefono,email,foto,estado from personas where numero_documento=''".$numero_documento."''')ret
(codigo varchar,tipo_documento varchar,numero_documento varchar,nombres varchar,apellido_paterno varchar,apellido_materno varchar,fecha_nacimiento varchar,sexo varchar,telefono varchar,email varchar,foto varchar,estado varchar)";
        }
		//echo $cad;
		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
    }
	
	function getPersonaId($id){

        $cad = "select numero_documento ruc, apellido_paterno||' '||apellido_materno||' '||nombres nombre_comercial, apellido_paterno||' '||apellido_materno||' '||nombres razon_social, '' direccion, email
        from personas
        Where id='".$id."' ";
    
        $data = DB::select($cad);
        if($data)return $data[0];
    }

}
