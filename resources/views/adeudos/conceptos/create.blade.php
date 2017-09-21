
<form class="ui modal ui form large equal width" id="modalNuevoConcepto" action="{{route('guardarConceptoAdeudo')}}" method="POST">
	<i class="close icon"></i>
	<div class="header">
		<i class="home outline icon"></i>
		Agregar un Concepto
	</div>
	<div class="content">
		{{ csrf_field() }}
		<input type="hidden" name="condominio_id" value="{{$condominio->id}}">
		<input type="hidden" name="form" value="modal">
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->conceptoStore->has('nombre')  && old('form') == 'modal'?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
					    Nombre
					</div>
				    <input type="text" name="nombre" value="{{old('nombre')}}" placeholder="Nombre Concepto">
				</div>
				@if ($errors->conceptoStore->has('nombre')  && old('form') == 'modal')
					<div class="ui left pointing red basic label">
						{{$errors->conceptoStore->first('nombre')}}		
				    </div>
				@endif
			</div>
		</div>
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->conceptoStore->has('tipo')  && old('form') == 'modal'?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
					    Tipo
					</div>
					<select name="tipo" class="ui fluid dropdown">
						<option value="" selected>Seleccione una opción</option>
						@foreach ($tipos as $tipo)
							<option value="{{$tipo['id']}}" {{old('tipo') == $tipo['id']?' selected ':''}}>{{$tipo['nombre']}}</option>
						@endforeach
					</select>
				</div>
				@if ($errors->conceptoStore->has('tipo')  && old('form') == 'modal')
					<div class="ui left pointing red basic label">
						{{$errors->conceptoStore->first('tipo')}}		
				    </div>
				@endif
			</div>			
		</div>
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->conceptoStore->has('deudor')  && old('form') == 'modal'?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
					    deudor
					</div>
					<select name="deudor" class="ui fluid dropdown">
						<option value="" selected>Seleccione una opción</option>
						@foreach ($deudores as $deudor)
							<option value="{{$deudor['id']}}" {{old('deudor') == $deudor['id']?' selected ':''}}>{{$deudor['nombre']}}</option>
						@endforeach
					</select>
				</div>
				@if ($errors->conceptoStore->has('deudor')  && old('form') == 'modal')
					<div class="ui left pointing red basic label">
						{{$errors->conceptoStore->first('deudor')}}		
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
		$('.nuevoConcepto').click(function(arg) {
			$('#modalNuevoConcepto').modal('show');			
		});
		@if (count($errors->conceptoStore) > 0  && old('form') == 'modal')
			$('#modalNuevoConcepto').modal('show');			
		@endif
	});
</script>
