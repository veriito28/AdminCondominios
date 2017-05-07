<form class="ui modal ui form large equal width" id="modalNuevaCasa" action="{{route('guardarCasa')}}" method="POST" novalidate>
	<i class="close icon"></i>
	<div class="header">
		<i class="home outline icon"></i>
		Agregar una Casa a <span class="ui header green">"{{$condominio->nombre}}"</span>
	</div>
	<div class="content">
		{{ csrf_field() }}
		<input type="hidden" value="{{session()->get('condominio.id')}}" name="condominio_id">
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->casaStore->has('nombre')?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
					    Nombre
					</div>
				    <input type="text" name="nombre" value="{{old('nombre')}}" placeholder="Nombre Casa">
				</div>
				@if ($errors->casaStore->has('nombre'))
					<div class="ui left pointing red basic label">
						{{$errors->casaStore->first('nombre')}}		
				    </div>
				@endif
			</div>		
		</div>
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->casaStore->has('contacto')?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
					    Contacto
					</div>
					<input type="text" name="contacto" value="{{old('contacto')}}" placeholder="Contacto">
				</div>
				@if ($errors->casaStore->has('contacto'))
					<div class="ui left pointing red basic label">
						{{$errors->casaStore->first('contacto')}}		
				    </div>
				@endif
			</div>
		</div>
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->casaStore->has('email')?'error':''}}">
				<div class="ui labeled input">
				  <div class="ui label">
				    Correo Electronico
				  </div>
				    <input type="email" name="email" value="{{old('email')}}" placeholder="Correo Electronico">
				</div>
				@if ($errors->casaStore->has('email'))
					<div class="ui left pointing red basic label">
						{{$errors->casaStore->first('email')}}		
				    </div>
				@endif
			</div>
		</div>
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->casaStore->has('telefono')?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
						Teléfono
					</div>
				    <input type="tel" name="telefono" value="{{old('telefono')}}" placeholder="Telefono">
				</div>
				@if ($errors->casaStore->has('telefono'))
					<div class="ui left left pointing red basic label">
						{{$errors->casaStore->first('telefono')}}		
				    </div>
				@endif
			</div>
		</div>
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->casaStore->has('celular')?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
						Celular
					</div>
				    <input type="tel" name="celular" value="{{old('celular')}}" placeholder="Celular">
				</div>
				@if ($errors->casaStore->has('celular'))
					<div class="ui left pointing red basic label">
						{{$errors->casaStore->first('celular')}}		
				    </div>
				@endif
			</div>
		</div>
	</div>
	<div class="actions">
		<div class="ui black deny button">
			Cancelar
		</div>
		<button type="submit" class="ui positive right labeled icon button">
			Guardar
			<i class="checkmark icon"></i>
		</button>
	</div>
</form>
<script>
 	$(document).ready(function() {
		$('.nuevaCasa').click(function(arg) {
			$('#modalNuevaCasa').modal('show');			
		});
		@if (count($errors->casaStore))
			$('#modalNuevaCasa').modal('show');			
		@endif
	});
</script>
