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
					<a href="{{ route('mostrarCondominio',['id_condominio'=>$seleccionado->id]) }}" class="item">
						<i class="building outline icon"></i>{{$seleccionado->nombre}}
					</a>
				@endif
			@endif
			<div class="menu right">
				@if (!Auth::guest())
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
				@endif
			</div>
		</div>
	</div>
	<div class="ui ">
		<div class="ui grid centered">
			@if (!Auth::guest())
				@if ($seleccionado)
					<div class="two wide column column-menu">
						<div class="ui vertical accordion side-bar inverted menu left floated">
							<div class="item active {{Request::is('usuario/condominio/ingresos/*')?' orange':'green'}}">
								<a class="title {{Request::is('usuario/condominio/ingresos/*')?' active':''}}">
									<i class="icons icon">
										<i class="dollar icon"></i>
										<i class="corner inverted reply icon"></i>
									</i>
									<span class="text">	INGRESOS</span>
									<i class="icon dropdown"></i>
								</a>
								<div class="content {{Request::is('usuario/condominio/ingresos/*')?' active':''}}">
									@php
										$conceptos = session()->get('condominio')->conceptos;
									@endphp
									@foreach ($conceptos as $concepto)
										<a href="{{route('pagos',['tipo'=>$concepto->slug_nombre])}}" class="item  {{Request::is('usuario/condominio/ingresos/pagos/'.$concepto->slug_nombre)?'active yellow':''}}">
											{{$concepto->nombre}}
										</a>
									@endforeach
									<a href="{{route('otrosPagos')}}" class="item {{Request::is('usuario/condominio/ingresos/otros*')?'active yellow':''}}">
										Otros Pagos
									</a>
									<a href="{{route('ingresosExtraordinarios')}}" class="item {{Request::is('usuario/condominio/ingresos/extraordinarios*')?'active yellow':''}}">
										Ingresos Ext.
									</a>	
								</div>
							</div>
							<div class="item active {{Request::is('usuario/condominio/gastos/*')?' orange':'green'}}">
								<a  class="title {{Request::is('usuario/condominio/gastos/*')?' active':''}}">
									<i class="icons icon">
										<i class=" dollar icon"></i>
										<i class="corner inverted share icon"></i>
									</i>
									<span class="text">	EGRESOS</span>
									<i class="icon dropdown"></i>
								</a>
								<div class="content {{Request::is('usuario/condominio/gastos/*')?' active':''}}">	
									<a href="{{route('gastosOrdinarios')}}" class="item {{Request::is('usuario/condominio/gastos/ordinarios*')?'active yellow':''}}">
										Ordinarios
									</a>
									<a href="{{route('gastosExtraordinarios')}}" class="item {{Request::is('usuario/condominio/gastos/extraordinarios*')?'active yellow':''}}">
										Extraordinarios
									</a>
								</div>
							</div>
							
							<div class="item active {{Request::is('usuario/condominio/adeudos/*')?' orange':'green'}}">
								<a  class="title {{Request::is('usuario/condominio/adeudos/*')?' active':''}}">
									<i class="icons icon ">
										<i class=" dollar icon"></i>
										<i class="corner alarm  inverted  icon"></i>
									</i>
									<span class="text">	ADEUDOS</span>
									<i class="icon dropdown"></i>
								</a>
								<div class="content {{Request::is('usuario/condominio/adeudos/*')?' active':''}}">	
									<a href="{{route('adeudosMensuales')}}" class="item {{Request::is('usuario/condominio/adeudos/mensualidades*')?'active yellow':''}}">
										Mensuales
									</a>
									<a href="{{route('otrosAdeudos')}}" class="item {{Request::is('usuario/condominio/adeudos/otros*')?'active yellow':''}}">
										Otros
									</a>
								</div>
							</div>
							
							<div class="item active {{Request::is('usuario/condominio/reportes/*')?' orange':'green'}}">
								<a  class="title {{Request::is('usuario/condominio/reportes/*')?' active':''}}">
									<i class="file pdf outline icon"></i>
									<span class="text">	REPORTES</span>
									<i class="icon dropdown"></i>
								</a>
								<div class="content {{Request::is('usuario/condominio/reportes/*')?' active':''}}">	
									<a href="{{route('reporteGeneral')}}" class="item {{Request::is('usuario/condominio/reportes/general*')?'active yellow':''}}">
										General
									</a>
									<a href="{{route('reporteIngresos')}}" class="item {{Request::is('usuario/condominio/reportes/ingresos*')?'active yellow':''}}">
										Ingresos
									</a>
								</div>
							</div>
							
						</div>
					</div>
				@endif
				<div class="fourteen wide column">
					<div class="ui grid container centered">
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
