CREATE OR REPLACE FUNCTION public.sp_listar_tabla_maestra_paginado(
    p_tipo character varying,
    p_denominacion character varying,
    p_estado character varying,
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

	v_campos=' id, tipo, denominacion, acronimo, orden, codigo, tipo_nombre, id_parent, estado, variable1, variable2, variable3 ';

	v_tabla='from tabla_maestras';

	v_where = ' Where 1=1 ';


	If p_tipo<>'' Then
	 v_where:=v_where||' And tipo like ''%'||p_tipo||'%'' ';
	End If;

	If p_denominacion<>'' Then
	 v_where:=v_where||' And denominacion like ''%'||p_denominacion||'%'' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||' And estado = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By tipo, orden LIMIT '||p_limit||' OFFSET '||p_pagina||';';
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By tipo, orden Desc;';
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
