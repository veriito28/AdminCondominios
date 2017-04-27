<form class="ui modal ui form" id="modalNuevoCondominio" action="{{route('guardarCondominio')}}" method="POST">
	<i class="close icon"></i>
	<div class="header">
		<i class="building outline icon"></i>
		Agregar un condominio 
	</div>
	<div class=" content">
		{{ csrf_field() }}
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->condominioStore->has('nombre')?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
						Nombre
					</div>
				    <input type="tel" name="nombre" placeholder="Nombre" value="{{old('nombre')}}">
				</div>
				@if ($errors->condominioStore->has('nombre'))
					<div class="ui left pointing red basic label">
						{{$errors->condominioStore->first('nombre')}}		
				    </div>
				@endif
			</div>
		</div>
		<div class="inline fields">
			<div class="eleven wide field {{$errors->condominioStore->has('seleccionado')?'error':''}}">
				<div class="ui checkbox">
					 <input type="checkbox" name="seleccionado" checked value="true">
					 <label>Seleccionar por default al entrar a plataforma</label>
				</div>
			</div>
		</div>
		@if ($errors->condominioStore->has('seleccionado'))
			<div class="ui negative message">
				<div class="header">
					{{$errors->first('seleccionado')}}
				</div>
				<p>
				</p>
			</div>
		@endif
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
		$('.nuevoCondominio').click(function(arg) {
			$('#modalNuevoCondominio').modal('show');			
		});
		@if (count($errors->condominioStore))
			$('#modalNuevoCondominio').modal('show');			
		@endif
	});
</script>
