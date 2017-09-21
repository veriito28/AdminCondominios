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
							Conceptos
						</h2>
						<form class="ui form large equal width" action="{{route('actualizarConceptoGasto',['id'=>$concepto->id])}}" method="POST">
							{{ method_field('PUT') }}
							{{ csrf_field() }}
							<div class="inline fields">
								<div class="twelve wide field  {{$errors->conceptoUpdate->has('nombre')?'error':''}}">
									<div class="ui labeled input">
										<div class="ui label">
											Nombre
										</div>
										<input type="text" name="nombre" value=" {{old('nombre')?old('nombre'):$concepto->nombre}}" placeholder="Nombre Casa">
									</div>
									@if ($errors->conceptoUpdate->has('nombre'))
									<div class="ui left pointing red basic label">
										{{$errors->conceptoUpdate->first('nombre')}}		
									</div>
									@endif
								</div>		
							</div>
							<a href="{{ route('mostrarConceptosGastos') }}" class="ui black deny button">
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

