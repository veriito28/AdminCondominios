@extends('template')
@section('contenido')
<div class=" stretched column">
	<div class="html">
		<div class="ui  column centered grid">
			<div class="column">
				<div class="ui segments">
					<div class="ui green segment"> 
						<h2 class="ui center aligned icon header">
							<i class="circular building icon"></i>
							{{$casa->condominio->nombre}}
						</h2>
						<form class="ui form large equal width" id="modalNuevaCasa" action="{{route('actualizarCasa',['id'=>$casa->id])}}" method="POST">
							{{ method_field('PUT') }}
							{{ csrf_field() }}
							<input type="hidden" value="{{ old('condominio_id') ?old('condominio_id'):$casa->condominio_id }}" name="condominio_id">
							<div class="inline fields">
								<div class="twelve wide field  {{$errors->casaUpdate->has('nombre')?'error':''}}">
									<div class="ui labeled input">
										<div class="ui label">
											Nombre
										</div>
										<input type="text" name="nombre" value=" {{old('nombre')?old('nombre'):$casa->nombre}}" placeholder="Nombre Casa">
									</div>
									@if ($errors->casaUpdate->has('nombre'))
									<div class="ui left pointing red basic label">
										{{$errors->casaUpdate->first('nombre')}}		
									</div>
									@endif
								</div>		
							</div>
							<div class="inline fields">
								<div class="twelve wide field  {{$errors->casaUpdate->has('contacto')?'error':''}}">
									<div class="ui labeled input">
										<div class="ui label">
											Contacto
										</div>
										<input type="text" name="contacto" value="{{old('contacto') ?old('contacto'):$casa->contacto }}" placeholder="Contacto">
									</div>
									@if ($errors->casaUpdate->has('contacto'))
									<div class="ui left pointing red basic label">
										{{$errors->casaUpdate->first('contacto')}}		
									</div>
									@endif
								</div>
							</div>
							<div class="inline fields">
								<div class="twelve wide field  {{$errors->casaUpdate->has('email')?'error':''}}">
									<div class="ui labeled input">
										<div class="ui label">
											Correo Electronico
										</div>
										<input type="email" name="email" value="{{old('email') ?old('email'):$casa->email }}" placeholder="Correo Electronico">
									</div>
									@if ($errors->casaUpdate->has('email'))
									<div class="ui left pointing red basic label">
										{{$errors->casaUpdate->first('email')}}		
									</div>
									@endif
								</div>
							</div>
							<div class="inline fields">
								<div class="twelve wide field  {{$errors->casaUpdate->has('telefono')?'error':''}}">
									<div class="ui labeled input">
										<div class="ui label">
											Teléfono
										</div>
										<input type="tel" name="telefono" value="{{old('telefono') ?old('telefono'):$casa->telefono }}" placeholder="Telefono">
									</div>
									@if ($errors->casaUpdate->has('telefono'))
									<div class="ui left left pointing red basic label">
										{{$errors->casaUpdate->first('telefono')}}		
									</div>
									@endif
								</div>
							</div>
							<div class="inline fields">
								<div class="twelve wide field  {{$errors->casaUpdate->has('celular')?'error':''}}">
									<div class="ui labeled input">
										<div class="ui label">
											Celular
										</div>
										<input type="tel" name="celular" value="{{old('celular') ?old('celular'):$casa->celular }}" placeholder="Celular">
									</div>
									@if ($errors->casaUpdate->has('celular'))
									<div class="ui left pointing red basic label">
										{{$errors->casaUpdate->first('celular')}}		
									</div>
									@endif
								</div>
							</div>
							<a href="{{ route('mostrarCondominio',['id'=>$casa->condominio_id]) }}" class="ui black deny button">
								Cancelar
							</a>
							<button type="submit" class="ui positive right labeled icon button">
								Guardar
								<i class="checkmark icon"></i>
							</button>
						</form>
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

