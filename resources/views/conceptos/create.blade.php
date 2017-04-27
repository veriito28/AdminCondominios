<form class="ui modal ui form large equal width" id="modalNuevoConcepto" action="{{route('guardarConcepto')}}" method="POST">
	<i class="close icon"></i>
	<div class="header">
		<i class="home outline icon"></i>
		Agregar una Concepto
	</div>
	<div class="content">
		{{ csrf_field() }}
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->conceptoStore->has('nombre')?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
					    Nombre
					</div>
				    <input type="text" name="nombre" value="{{old('nombre')}}" placeholder="Nombre Concepto">
				</div>
				@if ($errors->conceptoStore->has('nombre'))
					<div class="ui left pointing red basic label">
						{{$errors->conceptoStore->first('nombre')}}		
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
		@if (count($errors->conceptoStore))
			$('#modalNuevoConcepto').modal('show');			
		@endif
	});
</script>
