<!--<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">-->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-0">
    <!--<a href="{{ route('frontend.index') }}" class="navbar-brand">{{ app_name() }}</a>-->
	<a href="{{ route('frontend.index') }}" class="navbar-brand">
        <img src="<?php echo URL::to('/') ?>/img/logo_mmp.png" alt="" width="50" height="50" style="padding:0px;margin:0px">
    </a>
	<br>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="@lang('labels.general.toggle_navigation')">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!--<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">-->
	<div class="collapse navbar-collapse justify-content" id="navbarSupportedContent">
        <!--<ul class="navbar-nav">-->
		<ul class="navbar-nav col-lg-9 col-md-9 col-sm-12 col-xs-12">
            
            @auth
                <li class="nav-item"><a href="{{route('frontend.user.dashboard')}}" class="nav-link {{ active_class(Route::is('frontend.user.dashboard')) }}">Inicio</a></li>
            @endauth

            @guest
                <li class="nav-item"><a href="{{route('frontend.auth.login')}}" class="nav-link {{ active_class(Route::is('frontend.auth.login')) }}">Iniciar Sessi&oacute;n</a></li>
				<!--
				@if(config('access.registration'))
                    <li class="nav-item"><a href="{{route('frontend.auth.register')}}" class="nav-link {{ active_class(Route::is('frontend.auth.register')) }}">@lang('navs.frontend.register')</a></li>
                @endif
				-->
            @else
				<!--
				<li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Solicitud</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
                            <a href="{{route('frontend.solicitud.create')}}" class="dropdown-item">Nueva Solicitud</a>
							<a href="{{route('frontend.solicitud.create_desembolso')}}" class="dropdown-item">Desembolso</a>
                    </div>
                </li>
				-->
				
				<li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Compra</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
							<a href="{{route('frontend.compra.listar')}}" class="dropdown-item">Consulta de Compras</a>
							<a href="{{route('frontend.compra.create')}}" class="dropdown-item">Nueva Compra</a>
							<a href="{{route('frontend.compra.create_desembolso')}}" class="dropdown-item">Desembolso</a>
                    </div>
                </li>
				
				<li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Producci&oacute;n</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
							<a href="{{route('frontend.produccion.listar')}}" class="dropdown-item">Consulta de Producci&oacute;nes</a>
							<a href="{{route('frontend.produccion.create')}}" class="dropdown-item">Nueva Producci&oacute;n</a>
                    </div>
                </li>
				
				<li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Venta</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
							<a href="{{route('frontend.venta.listar')}}" class="dropdown-item">Consulta de Ventas</a>
							<a href="{{route('frontend.venta.create')}}" class="dropdown-item">Nueva Venta</a>
							<a href="{{route('frontend.venta.create_desembolso')}}" class="dropdown-item">Desembolso</a>
                    </div>
                </li>
				
				<li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Estado de Cuenta</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
                            <a href="{{route('frontend.cronograma.create_ingreso')}}" class="dropdown-item">Nuevo Ingreso</a>
                    </div>
                </li>
				
				<li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Mantenimiento</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
                            <a href="{{route('frontend.manten.create')}}" class="dropdown-item">Tabla Maestra</a>
							<a href="{{route('frontend.persona.listar')}}" class="dropdown-item">Persona</a>
							<a href="{{route('frontend.empresa.listar')}}" class="dropdown-item">Empresa</a>
							
                    </div>
                </li>
				
				<li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Configuraci&oacute;n</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
                            <a href="{{route('frontend.manten.create_color')}}" class="dropdown-item">Configuraci&oacute;n Colores</a>
							<a href="{{route('frontend.manten.send_restablecer_color')}}" class="dropdown-item">Reestablecer Colores</a>
                    </div>
                </li>
				
				<li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Reporte</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
                            <a href="{{route('frontend.reporte.consulta_consolidado')}}" class="dropdown-item">Consolidado Estado Situacional</a>
							<a href="{{route('frontend.reporte.consulta_vencidos')}}" class="dropdown-item">Consulta de Prestamos Vencidos</a>
							<!--<a href="{{route('frontend.reporte.consulta_individual')}}" class="dropdown-item">Individula Estado Situacional</a>-->
							<a href="{{route('frontend.reporte.resumen_ingreso')}}" class="dropdown-item">Resumen de Ingreso Diario</a>
                    </div>
                </li>
				
				<li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Gerencial</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
						<a href="{{route('frontend.grafico.all')}}" class="dropdown-item">Informe de Gesti&oacute;n</a>
					</div>
                </li>

                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuUser" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">{{ $logged_in_user->name }}</a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuUser">
                        @can('view backend')
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item">@lang('navs.frontend.user.administration')</a>
                        @endcan

                        <a href="{{ route('frontend.user.account') }}" class="dropdown-item {{ active_class(Route::is('frontend.user.account')) }}">Mi Perfil</a>
                        <a href="{{ route('frontend.auth.logout') }}" class="dropdown-item">Cerrar Sessi&oacute;n</a>
                    </div>
                </li>
            @endguest

            <!--<li class="nav-item"><a href="{{route('frontend.contact')}}" class="nav-link {{ active_class(Route::is('frontend.contact')) }}">@lang('navs.frontend.contact')</a></li>-->
        </ul>
    </div>
</nav>
