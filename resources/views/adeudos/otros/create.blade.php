<form name="formModal" class="ui modal ui form large equal width" id="modalNuevoOtroAdeudo" action="{{route('guardarOtroAdeudo',compact('anio'))}}" method="POST">
	<i class="close icon"></i>
	<div class="header">
		<i class="home outline icon"></i>
		Agregar Adeudo
	</div>
	<div class="content">
		{{ csrf_field() }}
		<input type="hidden" name="form" value="modal">
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->otroAdeudoStore->has('casa_id') && old('form') == 'modal'?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
						Casa
					</div>
					<select name="casa_id" class="ui fluid dropdown">
							<option value="" selected>Seleccione una opción</option>
						@foreach ($condominio->casas as $casa)
							<option value="{{$casa->id}}" {{old('casa_id') == $casa->id?' selected ':''}}>{{$casa->nombre}}</option>
						@endforeach
					</select>
				</div>
				@if ($errors->otroAdeudoStore->has('casa_id') && old('form') == 'modal')
					<div class="ui left pointing red basic label">
						{{$errors->otroAdeudoStore->first('casa_id')}}		
				    </div>
				@endif
			</div>		
		</div>		
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->otroAdeudoStore->has('concepto') && old('form') == 'modal'?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
					    Concepto
					</div>
				    <input type="text" name="concepto" value="{{old('concepto')}}" placeholder="Concepto">
				</div>
				@if ($errors->otroAdeudoStore->has('concepto') && old('form') == 'modal')
					<div class="ui left pointing red basic label">
						{{$errors->otroAdeudoStore->first('concepto')}}		
				    </div>
				@endif
			</div>		
		</div>		
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->otroAdeudoStore->has('cantidad') && old('form') == 'modal'?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
					    Cantidad
					</div>
				    <input type="text" name="cantidad" value="{{old('cantidad')}}" placeholder="Cantidad">
				</div>
				@if ($errors->otroAdeudoStore->has('cantidad') && old('form') == 'modal')
					<div class="ui left pointing red basic label">
						{{$errors->otroAdeudoStore->first('cantidad')}}		
				    </div>
				@endif
			</div>		
		</div>		
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->otroAdeudoStore->has('fecha') && old('form') == 'modal'? 'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
					    Fecha
					</div>
				    <input type="date" name="fecha" value="{{old('fecha')?old('fecha'): \Carbon\Carbon::now()->year($anio)->toDateString()}}" placeholder="Fecha">
				</div>
				@if ($errors->otroAdeudoStore->has('fecha') && old('form') == 'modal')
					<div class="ui left pointing red basic label">
						{{$errors->otroAdeudoStore->first('fecha')}}		
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
		$('.nuevoOtroAdeudo').click(function(arg) {
			$('#modalNuevoOtroAdeudo').modal('show');			
		});
		@if (count($errors->otroAdeudoStore) > 0 && old('form') == 'modal')
			$('#modalNuevoOtroAdeudo').modal('show');			
		@endif
	});
</script>
