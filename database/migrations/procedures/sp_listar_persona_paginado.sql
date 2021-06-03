--select sp_listar_persona_paginado('','','1','1','10','ref');fetch all in ref;

CREATE OR REPLACE FUNCTION public.sp_listar_persona_paginado(
    p_numero_documento character varying,
    p_nombre character varying,
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
	
	v_campos=' t1.id,t1.tipo_documento,t1.numero_documento,t1.nombres||'' ''||t1.apellido_paterno||'' ''||t1.apellido_materno persona,t1.telefono,t1.estado ';

	v_tabla='from personas t1 ';
	
	v_where = ' Where 1=1 and t1.id!=33 ';

	
	If p_id_estado<>'0' Then
	 v_where:=v_where||' And t1.estado = '''|| p_id_estado||''' ';
	End If;
	
	If p_numero_documento<>'' Then
	 v_where:=v_where||' And t1.numero_documento like ''%'||p_numero_documento||'%'' ';
	End If;

	If p_nombre<>'' Then
	 v_where:=v_where||' And trim(t1.nombres)||'' ''||trim(t1.apellido_paterno)||'' ''||trim(t1.apellido_materno) ilike ''%'||p_nombre||'%'' '; 
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
