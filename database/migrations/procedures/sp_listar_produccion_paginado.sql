CREATE OR REPLACE FUNCTION public.sp_listar_produccion_paginado(
    p_numero_documento character varying,
    p_nombre character varying,
    p_id_producto character varying,
    p_id_unidad character varying,
    p_fecha_desde character varying,
    p_fecha_hasta character varying,
    p_id_estado character varying,
    p_pagina character varying,
    p_limit character varying,
    p_ref refcursor)
  RETURNS refcursor AS
$BODY$

Declare

v_scad varchar;
v_campos varchar;
v_tabla varchar;
v_where varchar;
v_count varchar;
v_col_count varchar;

Begin

	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;
	
	v_campos=' t1.id,to_char(t1.fecha,''dd-mm-yyyy'')fecha
,case when t1.id_persona=33 then t4.ruc else t3.numero_documento end numero_documento
,case when t1.id_persona=33 then t4.razon_social else t3.nombres||'' ''||t3.apellido_paterno||'' ''||t3.apellido_materno end persona
,t5.denominacion producto,t6.denominacion unidad,t2.cantidad,t2.precio,t1.total,
case 
	when t1.estado=''1'' Then ''Registrado''
	when t1.estado=''2'' Then ''Anulado''
	when t1.estado=''3'' Then ''Pagado''
end estado
';

	v_tabla='from producciones t1
inner join produccion_detalles t2 on t1.id=t2.id_produccion
inner join personas t3 on t1.id_persona=t3.id
inner join empresas t4 on t1.id_empresa=t4.id
inner join productos t5 on t2.id_producto=t5.id
inner join tabla_maestras t6 on t2.id_unidad=t6.id ';
	
	v_where = ' Where 1=1 ';

	
	If p_id_estado<>'0' Then
	 v_where:=v_where||' And t1.estado = '''|| p_id_estado||''' ';
	End If;
	
	If p_numero_documento<>'' Then
	 v_where:=v_where||' And t3.numero_documento like ''%'||p_numero_documento||'%'' ';
	End If;

	If p_nombre<>'' Then
	 v_where:=v_where||' And trim(t3.nombres)||'' ''||trim(t3.apellido_paterno)||'' ''||trim(t3.apellido_materno) ilike ''%'||p_nombre||'%'' '; 
	End If;	

	If p_id_producto<>'0' Then
	 v_where:=v_where||' And t2.id_producto = '''|| p_id_producto||''' ';
	End If;

	If p_id_unidad<>'0' Then
	 v_where:=v_where||' And t2.id_unidad = '''|| p_id_unidad||''' ';
	End If;

	If p_fecha_desde<>'' Then
	 v_where:=v_where||'And t1.fecha >= '''||p_fecha_desde||' :00:00'' ';
	End If;
	If p_fecha_hasta<>'' Then
	 v_where:=v_where||'And t1.fecha <= '''||p_fecha_hasta||' :23:59'' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By t1.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By t1.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

