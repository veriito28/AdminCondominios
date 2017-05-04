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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

</head>
<body>
	<div class="ui attached inverted stackable menu">
		<div class="ui container">
			<a class="item">
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
					<a href="{{ route('mostrarConceptos') }}" class="item item-hover">
						<i class="book icon"></i>
						<span class="btn-title">
							Conceptos
						</span>
					</a>
					<a  class="item item-hover">
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
		<div class="ui grid container centered">
			@if (!Auth::guest())
				@if ($seleccionado)
					<div class="two wide column column-menu">
						<div class="ui vertical side-bar inverted menu left floated">
							<p class="item active green">
								<i class="icons icon">
									<i class="dollar icon"></i>
									<i class="corner inverted reply icon"></i>
								</i>
								INGRESOS
							</p>
							<a href="{{route('pagos',['tipo'=>'mensualidad'])}}" class="item  {{Request::is('usuario/condominio/ingresos/pagos/*')?'active orange':''}}">
								Pagos
							</a>
							<a href="{{route('otrosPagos')}}" class="item {{Request::is('usuario/condominio/ingresos/otros*')?'active orange':''}}">							
								Otros Pagos
							</a>
							<a href="{{route('ingresosExtraordinarios')}}" class="item {{Request::is('usuario/condominio/ingresos/extraordinarios*')?'active orange':''}}">
								Ingresos Ext.
							</a>
							<p class="item active green">
								<i class="icons icon">
									<i class=" dollar icon"></i>
									<i class="corner inverted share icon"></i>
								</i>
								GASTOS
							</p>
							<a href="{{route('gastosOrdinarios')}}" class="item {{Request::is('usuario/condominio/gastos/ordinarios*')?'active orange':''}}">
								Ordinarios
							</a>
							<a href="{{route('gastosExtraordinarios')}}" class="item {{Request::is('usuario/condominio/gastos/extraordinarios*')?'active orange':''}}">
								Extraordinarios
							</a>
							<p class="item active green">
								<i class="icons icon ">
									<i class=" dollar icon"></i>
									<i class="corner alarm  inverted  icon"></i>
								</i>
								ADEUDOS
							</p>
							<a href="{{route('adeudosMensuales')}}" class="item {{Request::is('usuario/condominio/adeudos/mensualidades*')?'active orange':''}}">							
								Mensualidades
							</a>
							<a href="{{route('otrosAdeudos')}}" class="item {{Request::is('usuario/condominio/adeudos/otros*')?'active orange':''}}">							
								Otros
							</a>

							<p class="item active green">
								<i class="file pdf outline icon"></i>
								REPORTES
							</p>
							<a href="{{route('reporteGeneral')}}" class="item {{Request::is('usuario/condominio/reportes/general*')?'active orange':''}}">							
								General
							</a>
							<a href="{{route('reporteIngresos')}}" class="item {{Request::is('usuario/condominio/reportes/ingresos*')?'active orange':''}}">							
								Ingresos
							</a>
						</div>
					</div>
				@endif
				<div class="fourteen wide column">
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
					@section('contenido')
					@show
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
			$('.ui.dropdown').dropdown();
			$("input").focus(function() {
				var vm = this;
				setTimeout(function() {
					$(vm).select();
				},1);			
			});

		});
	</script>
	@section('scripts')				
	@show
</body>
</html>

