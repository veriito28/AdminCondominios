<form class="ui modal ui form" id="modalNuevoCondominio" action="{{route('guardarCondominio')}}" method="POST" enctype="multipart/form-data">
	<i class="close icon"></i>
	<div class="header">
		<i class="building outline icon"></i>
		Agregar un condominio
	</div>
	<div class=" content">
		{{ csrf_field() }}
		<div class="inline fields">
			<div class="twelve wide field {{$errors->condominioStore->has('nombre')?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
						Nombre
					</div>
				    <input type="text" name="nombre" placeholder="Nombre" value="{{old('nombre')}}">
				</div>
				@if ($errors->condominioStore->has('nombre'))
					<div class="ui left pointing red basic label">
						{{$errors->condominioStore->first('nombre')}}
				    </div>
				@endif
			</div>
		</div>
		<div class="inline fields">
			<div class="twelve wide field {{$errors->condominioStore->has('direccion')?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
						Dirección
					</div>
				    <input type="text" name="direccion" placeholder="Dirección" value="{{old('direccion')}}">
				</div>
				@if ($errors->condominioStore->has('direccion'))
					<div class="ui left pointing red basic label">
						{{$errors->condominioStore->first('direccion')}}
				    </div>
				@endif
			</div>
		</div>
		<div class="inline fields">
			<div class="twelve wide field {{$errors->condominioStore->has('imagen')?'error':''}}">
				<label for="image" class="ui icon button">
			        <i class="file  image outline icon"></i>
				        Logo
				    <input type="file" id="image" accept="image/*" name="imagen" style="display:none">
		        </label>
				@if ($errors->condominioStore->has('imagen'))
					<div class="ui left pointing red basic label">
						{{$errors->condominioStore->first('imagen')}}
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
