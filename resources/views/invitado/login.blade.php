@extends('template')
@section('contenido')
	<div class=" stretched column">
		<div class="html">
			<div class="ui two column centered grid">
				<div class="row">
					<div class="column">&nbsp;</div>
				</div>
				<div class="row">
					<div class="column">&nbsp;</div>
				</div>
				<div class="row">	
					<div class="column">
						<div class="ui">
							<div class="ui segment inverted black">
								<h1 class="ui horizontal divider header">
									<img src="{{ asset('img/logo.png') }}" alt="" class="icon">
									CONDOMINIOS
								</h1>
								<form class="ui form" action="{{route('login')}}" method="POST">
									{{csrf_field()}}
									<div class="field {{$errors->has('username')?'error':''}}">
										<div class="ui icon input">
											<input type="text" name="username" placeholder="Usuario" value="{{old('username')}}">
											<i class="user icon"></i>
										</div>
									</div>
									<div class="field {{$errors->has('password')?'error':''}}">
										<div class="ui icon input">
											<input type="password" name="password" placeholder="Contraseña">
											<i class="privacy icon"></i>
										</div>
									</div>
									@if ($errors->has('username'))
									<div class="ui negative message">
										<i class="close icon"></i>
										<div class="header">
											{{$errors->first('username')}}
										</div>
									</div>
									@endif
									<button class="ui button green" type="submit">Iniciar Sesión</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('scripts')
<script>
	@parent
	$(document).ready(function() {

	});
</script>
@stop