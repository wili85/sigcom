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
			
			<a class="btn btn-default" id="change-color-3" style="color:#FFFFFF">Barra Titulo</a>
		
            @if(config('locale.status') && count(config('locale.languages')) > 1)
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownLanguageLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">@lang('menus.language-picker.language') ({{ strtoupper(app()->getLocale()) }})</a>

                    @include('includes.partials.lang')
                </li>
            @endif

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

				<li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Solicitud</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
                            <a href="{{route('frontend.solicitud.create')}}" class="dropdown-item">Nueva Solicitud</a>
							<a href="{{route('frontend.solicitud.create_desembolso')}}" class="dropdown-item">Desembolso</a>
                    </div>
                </li>
				<li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Mantenimiento</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
                            <a href="{{route('frontend.manten.create')}}" class="dropdown-item">Tabla Maestra</a>
							<a href="{{route('frontend.manten.create_color')}}" class="dropdown-item">Configuraci&oacute;n Colores</a>
							<a href="{{route('frontend.manten.send_restablecer_color')}}" class="dropdown-item">Reestablecer Colores</a>
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
