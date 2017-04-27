<form class="basic modal ui form" id="modalEliminarCondominio" action="{{route('eliminarCondominio')}}" method="POST">
	<i class="close icon"></i>
	<div class="ui icon header">
		<i class="trash red active icon"></i>
		Precaución. El condominio <strong class="ui label yellow" id="nombreCondominio"></strong> se borrara de la lista de condominios.
	</div>
	<div class=" content">
		{{ csrf_field() }}
		{{method_field('DELETE')}}
		<input type="hidden" name="id">
		<div class="inline fields">
			<div class="sixteen  wide field $errors->has('passoword')?'error':''">
				<input type="text" name="passoword" placeholder="Ingrese su contraseña para confirmar borrado">
			</div>
		</div>
		@if ($errors->has('passoword'))
		<div class="ui negative message">
			<i class="close icon"></i>
			<div class="header">
				No se realizo el guardado
			</div>
			<p>
				{{$errors->first('passoword')}}
			</p>
		</div>
		@endif
	</div>
	<div class="actions">
		<div class="ui red deny button">
			Cancelar
		</div>
		<button type="submit" class="ui positive right labeled icon button">
			Eliminar
			<i class="checkmark icon"></i>
		</button>
	</div>
</form>

@section('scripts')
	@parent
	<script>
 	$(document).ready(function() {
		$('.removerCondominio').click(function(arg) {
			$('#modalEliminarCondominio').modal('show');			
			$("input[name=id]").val($(this).data('id'));
			$("#nombreCondominio").text($(this).data('name'));
		});
		@if ($errors->has('passoword'))
			$('#modalEliminarCondominio').modal('show');			
		@endif
	});
</script>
@stop