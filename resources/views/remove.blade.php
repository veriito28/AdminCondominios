<form class="modal small ui form " id="modalEliminarElemento{{$elemento->id}}" action="{{route($ruta,['id'=>$elemento->id])}}" method="POST">
	<i class="close icon"></i>
	<h2 class="ui left header ">
		<i class="circular trash red active icon"></i>
		Precaución. 
	</h2>
	<h4 class="ui  header centered">
		Esta a punto de eliminar <strong class="ui header green">{{isset($elemento->nombre)?$elemento->nombre:isset($elemento->concepto)?$elemento->concepto:$elemento->mensaje}}</strong>.
	</h4>
	<p>
	</p>
	<div class=" content">
		{{ csrf_field() }}
		{{method_field('DELETE')}}
		<input type="hidden" value="{{$elemento->id}}" name="id">
		<div class="inline fields">
			<div class="twelve wide field  {{ $errors->eliminarElemento->has('password')?'error':''}}">
				<div class="ui labeled input">
					<div class="ui label">
					    Contraseña
					</div>
				    <input type="password" name="password" value="{{old('password')}}" placeholder="Contraseña">
				</div>
				@if ($errors->eliminarElemento->has('password'))
					<div class="ui left pointing red basic label">
						{{$errors->eliminarElemento->first('password')}}		
				    </div>
				@endif
			</div>		
		</div>
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
