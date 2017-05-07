@extends('template')
@section('contenido')
<div class=" stretched column">
	<div class="html">
		<div class="ui  column centered grid">
			<div class="column">
				<div class="ui segments">
					<div class="ui green segment"> 
						<h2 class="ui center aligned icon header">
							<i class="folder open icon"></i>
							Cuentas
						</h2>
						<form class="ui form large equal width" action="{{route('actualizarCuenta',['id'=> $cuenta->id])}}" method="POST">
							{{ method_field('PUT') }}
							{{ csrf_field() }}
							<input type="hidden" value="{{$cuenta->usuario_id}}" name="usuario_id">
							<div class="inline fields">
								<div class="twelve wide field  {{$errors->cuentaUpdate->has('mensaje')?'error':''}}">
									<div class="ui labeled input">
										<div class="ui label">
										    Mensaje
										</div>
									    <input type="text" name="mensaje" value="{{old('mensaje')?old('mensaje'):$cuenta->mensaje}}" placeholder="Mensaje">
									</div>
									@if ($errors->cuentaUpdate->has('mensaje'))
										<div class="ui left pointing red basic label">
											{{$errors->cuentaUpdate->first('mensaje')}}		
									    </div>
									@endif
								</div>		
							</div>
							<div class="inline fields">
								<div class="ten wide field">
									<img src="{{$cuenta->imagen}}" width="300px" alt="Imagen de cuenta">
								</div>
								<div class="ten wide field  {{$errors->cuentaUpdate->has('imagen')?'error':''}}">
									<div>
									    <label for="imagen" class="ui icon button">
									        <i class="file icon"></i>
									        Seleccione Imagen</label>
									    <input type="file" name="imagen" id="imagen" style="display:none">
									</div>
									@if ($errors->cuentaUpdate->has('imagen'))
										<div class="ui left pointing red basic label">
											{{$errors->cuentaUpdate->first('imagen')}}		
									    </div>
									@endif
								</div>		
							</div>
							<a href="{{ route('mostrarCuentas') }}" class="ui black deny button">
								Cancelar
							</a>
							<button type="submit" class="ui positive right labeled icon button">
								Guardar
								<i class="checkmark icon"></i>
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script>
	@parent
	$(document).ready(function() {

	});
</script>
@stop

