<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Smart Condominios</title>

	<!-- Fonts -->

	<!-- Styles -->
	<link rel="stylesheet" href="{{ asset('semantic/semantic.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/css.css') }}"/>

	<!-- Scripts -->

	<script src="{{ asset('js/jquery.js') }}"></script>

</head>
<body>
	<div class="puntitos"></div>
	<div class="ui attached inverted stackable menu">
		<div class="ui container">
			<a href="{{ route('principal') }}" class="item">
				<img src="{{ asset('img/logo.png') }}" class="ui" width="50px" alt="">&nbsp; Condominios
			</a>
			{{-- <a class="item">
				<i class="grid layout icon"></i> Browse
			</a>
			<a class="item">
				<i class="mail icon"></i> Messages
			</a> --}}
			@if (!Auth::guest())
				@php
					$seleccionado = session()->get('condominio');
				@endphp
				<div class="ui simple dropdown item">
					<i class="icons">
						<i class="building outline icon"></i>
						<i class="inverted corner building icon"></i>
					</i>
						Mis Condominios
					<i class="dropdown icon"></i>
					<div class="menu">
						@foreach (Auth::user()->condominios as $condominio)
							@if (!$condominio->pivot->seleccionado)
								<a href="{{ route('seleccionarCondominio',['id_condominio'=>$condominio->id]) }}" class="item">
									<i class="building outline icon"></i>
									{{$condominio->nombre}}
								</a>
							@endif
						@endforeach
						<a class="item nuevoCondominio">
							<i class=" add icon "></i>
							Nuevo Condominio
						</a>
					</div>
				</div>
				@if ($seleccionado)
					<a href="{{ route('mostrarCondominio',['id_condominio'=>$seleccionado->id]) }}" class="item seleccionado">
						<i class="building outline icon"></i>{{$seleccionado->nombre}}
					</a>
				@endif
			@endif
			<div class="menu right">
				@if (!Auth::guest())
					<!--
					<a href="{{ route('mostrarCuentas') }}" class="item item-hover">
						<i class="credit card alternative icon"></i>
						<span class="btn-title">
							Cuentas
						</span>
					</a>

					<a href="{{ route('mostrarConceptos') }}" class="item item-hover">
						<i class="book icon"></i>
						<span class="btn-title">
							Conceptos
						</span>
					</a>
					<a  class="cambiarContrasenia item item-hover">
						<i class="privacy  icon"></i>
						<span class="btn-title">
							Cambiar Contraseña
						</span>
					</a>
					<a href="{{ route('logout') }}" class="item item-hover">
						<i class="reply icon"></i>
						<span class="btn-title">
							Cerrar Sesíon
						</span>
					</a>
					<p class="item">
						<i class="user icon"></i>
						{{Auth::user()->nombre}}
					</p>
					-->
					<div class="ui right dropdown item">
						<i class="user icon"></i>
						{{Auth::user()->nombre}}
						<i class="dropdown icon"></i>
						<div class="menu">
							<<a href="{{ route('mostrarCuentas') }}" class="item">
						<i class="credit card alternative icon"></i>
						<span class="btn-title">
							Cuentas para depósito
						</span>
					</a>

					<a href="{{ route('mostrarConceptos') }}" class="item">
						<i class="book icon"></i>
						<span class="btn-title">
							Conceptos
						</span>
					</a>
					<a  class="cambiarContrasenia item">
						<i class="unlock icon"></i>
						<span class="btn-title">
							Cambiar Contraseña
						</span>
					</a>
					<a href="{{ route('logout') }}" class="item">
						<i class="sign out icon"></i>
						<span class="btn-title">
							Cerrar Sesíon
						</span>
					</a>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>
	@php
	if (!Auth::guest()){
		function isOpcionActiva($opciones)
		{
			foreach ($opciones as $opcion)
				if (isset($opcion['ruta']))
					return isUrlActiva($opcion['ruta']);
			return false;
		}

		function isUrlActiva($ruta)
		{
			return Request::is(str_replace(url('/').'/','',$ruta));
		}
		$opcionesIngresos = [];
		if(session()->has('condominio'))
		{
		$conceptos = session()->get('condominio')->conceptosAdeudos;
		
		foreach ($conceptos as $concepto){
			if ($concepto->tipo == 'M'){
				array_push($opcionesIngresos, ['nombre'=> $concepto->nombre,'ruta' => route('pagos',['tipo'=>$concepto->slug_nombre])]);
			}
		}
		
		array_push($opcionesIngresos,['nombre'=> 'Otros Pagos','ruta' => route('otrosPagos')]);
		array_push($opcionesIngresos,['nombre'=> 'Ingresos Ext.','ruta' => route('ingresosExtraordinarios')]);
		}

		$menus = [
			[
				'nombre' => 'Condominios',
				'icono'  => 'building outline',
				'opciones' => [
					['nombre' => 'Mis Condominios', 'ruta' => route('bienvenido')],
					['nombre' => 'Casas', 'ruta' => route('mostrarCondominio',['id_condominio'=>$seleccionado['id']])],
					['nombre' => 'Editar', 'ruta' => route('editarCondominio',['id_condominio'=>$seleccionado['id']])]
				]
			],
			[
				'nombre' => 'Ingresos',
				'icono'  => 'icons',
				'iconoComplemento'=> '<i class="dollar icon"></i><i class="corner inverted reply icon"></i>',
				'opciones' => $opcionesIngresos
			],
			[
				'nombre' => 'Egresos',
				'icono'  => 'icons',
				'iconoComplemento'=> '<i class="dollar icon"></i><i class="corner inverted share icon"></i>',
				'opciones' => [
					['nombre' => 'Ordinarios', 'ruta' => route('gastosOrdinarios')],
					['nombre' => 'Extraordinarios', 'ruta' => route('gastosExtraordinarios')],
					['nombre' => 'Conceptos', 'ruta' => route('mostrarConceptosGastos')],
				]
			],
			[
				'nombre' => 'ADEUDOS',
				'icono'  => 'icons',
				'iconoComplemento'=> '<i class="dollar icon"></i><i class="corner inverted alarm icon"></i>',
				'opciones' => [
					['nombre' => 'Mensuales', 'ruta' => route('adeudosMensuales')],
					['nombre' => 'Otros', 'ruta' => route('otrosAdeudos')],
					['nombre' => 'Conceptos', 'ruta' => route('mostrarConceptosAdeudos')],
				]
			],
			[
				'nombre' => 'Reportes',
				'icono'  => 'file pdf outline',
				'opciones' => [
					['nombre' => 'General', 'ruta' => route('reporteGeneral')],
					['nombre' => 'Ingresos', 'ruta' => route('reporteIngresos')],
				]
			]
		];
	}
	@endphp
	<div class="ui ">
		<div class="ui grid paddingLeft centered container">
			@if (!Auth::guest())
				@if ($seleccionado)
					<div sixss="wide column column-menu">
						<div class="ui vertical accordion side-bar inverted menu left floated">
							@foreach ($menus as $menu)
								<div class="item active {{isOpcionActiva($menu['opciones'])?' orange':'green'}}">
									<a class="title {{isOpcionActiva($menu['opciones'])?' active':''}}">
										<i class="{{$menu['icono']}} icon">
											@isset ($menu['iconoComplemento'])
												{!!$menu['iconoComplemento']!!}
											@endisset
										</i>
										<span class="text">
											{{strtoupper($menu['nombre'])}}
											<i class="icon dropdown"></i>
										</span>
									</a>
									<div class="content {{isOpcionActiva($menu['opciones'])?' active':''}}">
										@foreach ($menu['opciones'] as $opcion)
											<a href="{{isset($opcion['ruta'])?$opcion['ruta']:''}}" class="item {{isset($opcion['clase'])?$opcion['clase']:''}} {{isset($opcion['ruta'])?isUrlActiva($opcion['ruta']):''}}">
												{{$opcion['nombre']}}
											</a>
										@endforeach
									</div>
								</div>
							@endforeach
						</div>
					</div>
				@endif
				<div class="sixteen wide column">
					<div class="ui grid  centered">
						<div class="sixteen wide column">
							@if(session()->has('message'))
								<div class="ui  icon floating {{session()->get('type') == 'success'?'green':'red'}} message">
									<i class="{{session()->get('type') == 'success'?'info':'warning '}} circle icon"></i>
										<div class="header">
											{{session()->get('message')}}
										</div>
								</div>
							@endif
							@if($errors->count() > 0)
								<div class="ui  icon floating red message">
									<i class="warning circle icon"></i>
										<div class="header">
											{{$errors->first()}}
										</div>
								</div>
							@endif
							@include('condominios.create',['errors' => $errors])
							@include('usuario.password',['errors' => $errors])
							@section('contenido')
							@show
						</div>
					</div>
				</div>


			@else
				@section('contenido')
				@show
			@endif
		</div>
	</div>
	<script src="{{ asset('semantic/semantic.min.js') }}"></script>
	<script>
		$(document).ready(function() {
//			$('.fixed-action-btn').openFAB();
			$('.ui.dropdown').dropdown();
			$("input").focus(function() {
				var vm = this;
				setTimeout(function() {
					$(vm).select();
				},1);
			});
			$('.accordion').accordion({
				selector:{
					tigger:'.title .icon'
				}
			});
		});
	</script>
	@section('scripts')
	@show
</body>
</html>
