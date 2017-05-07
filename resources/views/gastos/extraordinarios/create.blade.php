<form class="ui modal ui form large equal width" id="modalNuevoGastoExtra" action="{{route('guardarGastoExtraordinario',compact('anio'))}}" method="POST">
	<i class="close icon"></i>
	<div class="header">
		<i class="home outline icon"></i>
		Agregar Gasto Extraordinario
	</div>
	<div class="content">
		{{ csrf_field() }}
		<input type="hidden" name="form" value="modal">
		<input type="hidden" name="condominio_id" value="{{$condominio->id}}">
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->gastoExtraStore->has('concepto') && old('form') == 'modal'?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
					    Concepto
					</div>
				    <input type="text" name="concepto" value="{{old('concepto')}}" placeholder="Concepto">
				</div>
				@if ($errors->gastoExtraStore->has('concepto') && old('form') == 'modal')
					<div class="ui left pointing red basic label">
						{{$errors->gastoExtraStore->first('concepto')}}		
				    </div>
				@endif
			</div>		
		</div>		
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->gastoExtraStore->has('cantidad') && old('form') == 'modal'?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
					    Cantidad
					</div>
				    <input type="text" name="cantidad" value="{{old('cantidad')}}" placeholder="Cantidad">
				</div>
				@if ($errors->gastoExtraStore->has('cantidad') && old('form') == 'modal')
					<div class="ui left pointing red basic label">
						{{$errors->gastoExtraStore->first('cantidad')}}		
				    </div>
				@endif
			</div>		
		</div>		
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->gastoExtraStore->has('fecha') && old('form') == 'modal'?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
					    Fecha
					</div>
				    <input type="date" name="fecha" value="{{old('fecha')?old('fecha'): \Date::now()->year($anio)->toDateString()}}" placeholder="Fecha">
				</div>
				@if ($errors->gastoExtraStore->has('fecha') && old('form') == 'modal')
					<div class="ui left pointing red basic label">
						{{$errors->gastoExtraStore->first('fecha')}}		
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
		$('.nuevoGastoExtra').click(function(arg) {
			$('#modalNuevoGastoExtra').modal('show');			
		});
		@if (count($errors->gastoExtraStore) > 0 && old('form') == 'modal')
			$('#modalNuevoGastoExtra').modal('show');			
		@endif
	});
</script>
