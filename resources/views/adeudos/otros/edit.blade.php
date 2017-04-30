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
							Editar Adeudo de {{$otroAdeudo->casa->nombre}}
						</h2>
						<form class="ui form large equal width" action="{{route('actualizarOtroAdeudo',['anio'=> $anio,'id'=>$otroAdeudo->id])}}" method="POST">
							{{ method_field('PUT') }}
							{{ csrf_field() }}
							<div class="inline fields">
								<div class="twelve wide field  {{$errors->gastoExtraUpdate->has('concepto')?'error':''}}">
									<div class="ui labeled input">
										<div class="ui label">
										    Concepto
										</div>
									    <input type="text" name="concepto" value="{{$otroAdeudo->concepto?$otroAdeudo->concepto:old('concepto')}}" placeholder="Concepto">
									</div>
									@if ($errors->gastoExtraUpdate->has('concepto'))
										<div class="ui left pointing red basic label">
											{{$errors->gastoExtraUpdate->first('concepto')}}		
									    </div>
									@endif
								</div>		
							</div>		
							<div class="inline fields">
								<div class="twelve wide field  {{$errors->gastoExtraUpdate->has('cantidad')?'error':''}}">
									<div class="ui labeled input">
										<div class="ui label">
										    Cantidad
										</div>
									    <input type="text" name="cantidad" value="{{$otroAdeudo->cantidad?$otroAdeudo->cantidad:old('cantidad')}}" placeholder="Cantidad">
									</div>
									@if ($errors->gastoExtraUpdate->has('cantidad'))
										<div class="ui left pointing red basic label">
											{{$errors->gastoExtraUpdate->first('cantidad')}}		
									    </div>
									@endif
								</div>		
							</div>		
							<div class="inline fields">
								<div class="twelve wide field  {{$errors->gastoExtraUpdate->has('fecha')?'error':''}}">
									<div class="ui labeled input">
										<div class="ui label">
										    Fecha
										</div>
									    <input type="date" name="fecha" value="{{$otroAdeudo->fecha?(\Carbon\Carbon::parse($otroAdeudo->fecha)->toDateString()):(old('fecha')?old('fecha'): \Carbon\Carbon::now()->year($anio)->toDateString())}}" placeholder="Fecha">
									</div>
									@if ($errors->gastoExtraUpdate->has('fecha'))
										<div class="ui left pointing red basic label">
											{{$errors->gastoExtraUpdate->first('fecha')}}		
									    </div>
									@endif
								</div>		
							</div>		
							<a href="{{ route('otrosAdeudos',compact('anio')) }}" class="ui black deny button">
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
