@extends('template')
@section('contenido')
	<div class="ui stretched column">
		<div class="ui html">
			<div class="ui  column centered grid">
				<div class="ui column">
					<div class="ui segments">
						<div class="ui green segment">
							<h2 class="ui center aligned icon header">
								<i class="circular user icon"></i>
								Bienvenido
							</h2>
							<h2 class="ui horizontal divider header">Sistema Smart</h2>
							<div class="ui four cards grid">
								@foreach ($condominios as $condominio)
									<div class="ui column card">
											@if ($condominio->pivot->seleccionado)
												<div class="ui green ribbon label">
													<i class="building icon"></i> Seleccionado
												</div>
											@else
												<div class="ui black ribbon label">
												        <i class="building icon"></i> Condominio
											      </div>
											@endif
											<div class="content">
												<div class="header">
													{{$condominio->nombre}}
													{{-- <img src="{{$condominio->imagen}}"  class="ui  image mini" alt="Imagen Condominio" > --}}
												</div>
												<div class="meta">
													Casas: {{$condominio->casas->count()}}
												</div>
											</div>
											@if (!$condominio->pivot->seleccionado)
												<a href="{{ route('seleccionarCondominio',['id_condominio'=>$condominio->id]) }}" class="ui bottom attached blue button">
													Seleccionar
											      	<i class="sign in right icon"></i>
											    </a>
											@else
											    <a href="{{ route('mostrarCondominio',[ 'id' => $condominio->id]) }}" class="ui bottom attached green button">
													Administrar
											      	<i class="configure right icon"></i>
											    </a>
											@endif
											 <a id="removerElemento{{$condominio->id}}" class="ui bottom attached red button">
												Eliminar
										      	<i class="trash  right icon"></i>
										    </a>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	@parent
	@php
		$ruta  = 'eliminarCondominio';
	@endphp
	@foreach ($condominios as $condominio)
		@php
			$elemento  = $condominio;
		@endphp

		@include('remove',compact('elemento','ruta'))
		<script>
			$(document).ready(function() {
				$('#removerElemento{{$condominio->id}}').click(function(arg) {
					$('#modalEliminarElemento{{$condominio->id}}').modal('show');
				});
			});
		</script>
	@endforeach
	@if ($errors->eliminarElemento->has('password'))
		<script>
			$(document).ready(function() {
				$('#modalEliminarElemento{{old('id')}}').modal('show');
			});
		</script>
	@endif
@endsection