<form class="ui modal ui form large equal width" id="modalNuevoCuenta" action="{{route('guardarCuenta')}}" method="POST" enctype="multipart/form-data">
	<i class="close icon"></i>
	<div class="header">
		<i class="home outline icon"></i>
		Agregar una Cuenta
	</div>
	<div class="content">
		{{ csrf_field() }}
		<input type="hidden" value="{{Auth::user()->id}}" name="usuario_id">
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->cuentaStore->has('mensaje')?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
					    Mensaje
					</div>
				    <input type="text" name="mensaje" value="{{old('mensaje')}}" placeholder="Mensaje">
				</div>
				@if ($errors->cuentaStore->has('mensaje'))
					<div class="ui left pointing red basic label">
						{{$errors->cuentaStore->first('mensaje')}}		
				    </div>
				@endif
			</div>		
		</div>
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->cuentaStore->has('imagen')?'error':''}}">
				<div>
				    <label for="imagen" class="ui icon button">
				        <i class="file icon"></i>
				        Seleccione Imagen</label>
				    <input type="file" name="imagen" id="imagen" style="display:none">
				</div>
				@if ($errors->cuentaStore->has('imagen'))
					<div class="ui left pointing red basic label">
						{{$errors->cuentaStore->first('imagen')}}		
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
		$('.nuevoCuenta').click(function(arg) {
			$('#modalNuevoCuenta').modal('show');			
		});
		@if (count($errors->cuentaStore))
			$('#modalNuevoCuenta').modal('show');			
		@endif
	});
</script>
