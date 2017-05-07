<form class="ui modal ui form" id="modalCambiarContrasenia" action="{{route('cambiarContrasenia')}}" method="POST">
	<i class="close icon"></i>
	<div class="header">
		<i class="privacy outline icon"></i>
		Cambiar Contraseña
	</div>
	<div class=" content">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->contraseniaUpdate->has('password')?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
						Contraseña actual
					</div>
				    <input type="password" name="password" placeholder="Nombre" value="{{old('password')}}">
				</div>
				@if ($errors->contraseniaUpdate->has('password'))
					<div class="ui left pointing red basic label">
						{{$errors->contraseniaUpdate->first('password')}}		
				    </div>
				@endif
			</div>
		</div>
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->contraseniaUpdate->has('new_password')?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
						Nueva contraseña
					</div>
				    <input type="password" name="new_password" placeholder="Nombre" value="{{old('new_password')}}">
				</div>
				@if ($errors->contraseniaUpdate->has('new_password'))
					<div class="ui left pointing red basic label">
						{{$errors->contraseniaUpdate->first('new_password')}}		
				    </div>
				@endif
			</div>
		</div>
		<div class="inline fields">
			<div class="twelve wide field  {{$errors->contraseniaUpdate->has('new_password_confirmation')?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
						Confirmar nueva contraseña
					</div>
				    <input type="password" name="new_password_confirmation" placeholder="Nombre" value="{{old('new_password_confirmation')}}">
				</div>
				@if ($errors->contraseniaUpdate->has('new_password_confirmation'))
					<div class="ui left pointing red basic label">
						{{$errors->contraseniaUpdate->first('new_password_confirmation')}}		
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
		$('.cambiarContrasenia').click(function(arg) {
			$('#modalCambiarContrasenia').modal('show');			
		});
		@if (count($errors->contraseniaUpdate))
			$('#modalCambiarContrasenia').modal('show');			
		@endif
	});
</script>
