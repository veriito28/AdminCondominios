@extends('template')
@section('contenido')
<div class=" stretched column">
	<div class="html">
		<div class="ui  column centered grid">
			<div class="column">
				<div class="ui segments">
					<div class="ui green segment"> 
						<h2 class="ui center aligned icon header">
							<i class="dollar icon"></i>
							Editar Ingreso Extraordinario
						</h2>
						<form class="ui form large equal width" action="{{route('actualizarIngresoExtraordinario',['anio'=> $anio,'id'=>$ingresoExtraordinario->id])}}" method="POST">
							{{ method_field('PUT') }}
							{{ csrf_field() }}
							<input type="hidden" name="condominio_id" value="{{$ingresoExtraordinario->condominio_id}}">
							<div class="inline fields">
								<div class="twelve wide field  {{$errors->ingresoExtraUpdate->has('concepto')?'error':''}}">
									<div class="ui labeled input">
										<div class="ui label">
										    Concepto
										</div>
									    <input type="text" name="concepto" value="{{$ingresoExtraordinario->concepto?$ingresoExtraordinario->concepto:old('concepto')}}" placeholder="Concepto">
									</div>
									@if ($errors->ingresoExtraUpdate->has('concepto'))
										<div class="ui left pointing red basic label">
											{{$errors->ingresoExtraUpdate->first('concepto')}}		
									    </div>
									@endif
								</div>		
							</div>		
							<div class="inline fields">
								<div class="twelve wide field  {{$errors->ingresoExtraUpdate->has('cantidad')?'error':''}}">
									<div class="ui labeled input">
										<div class="ui label">
										    Cantidad
										</div>
									    <input type="text" name="cantidad" value="{{$ingresoExtraordinario->cantidad?$ingresoExtraordinario->cantidad:old('cantidad')}}" placeholder="Cantidad">
									</div>
									@if ($errors->ingresoExtraUpdate->has('cantidad'))
										<div class="ui left pointing red basic label">
											{{$errors->ingresoExtraUpdate->first('cantidad')}}		
									    </div>
									@endif
								</div>		
							</div>		
							<div class="inline fields">
								<div class="twelve wide field  {{$errors->ingresoExtraUpdate->has('fecha')?'error':''}}">
									<div class="ui labeled input">
										<div class="ui label">
										    Fecha
										</div>
									    <input type="date" name="fecha" value="{{$ingresoExtraordinario->fecha?($ingresoExtraordinario->fecha->toDateString()):(old('fecha')?old('fecha'): \Carbon\Carbon::now()->year($anio)->toDateString())}}" placeholder="Fecha">
									</div>
									@if ($errors->ingresoExtraUpdate->has('fecha'))
										<div class="ui left pointing red basic label">
											{{$errors->ingresoExtraUpdate->first('fecha')}}		
									    </div>
									@endif
								</div>		
							</div>		
							<a href="{{ route('ingresosExtraordinarios',compact('anio')) }}" class="ui black deny button">
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

