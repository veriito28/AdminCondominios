@extends('template')
@section('contenido')
<div class=" stretched column">
	<div class="html">
		<div class="ui  column centered grid">
			<div class="column">
				<div class="ui segments">
					<div class="ui green segment"> 
						<div class="ui right aligned header">
							<h2>
								<img src="{{ asset('img/logo.png') }}" alt="" width="150px">
								<br>
								Smart Condominios
							</h2>
						</div>
						<h2 class="ui left header pull-left">
							<i class="circular building icon"></i>
							Reporte General de <span class="ui header green">"{{$condominio->nombre}}"</span> - {{$fecha->format('F Y')}}
						</h2>
						<div class="ui divider"></div>
						<form class="ui form large equal width" action="{{route('reporteGeneral',['anio'=> $fecha->year,'mes'=>$fecha->month])}}" method="post">
							{{csrf_field()}}
							<div class="inline fields">
								<div class="four wide field  {{$errors->reporteGeneral->has('encabezado')?'error':''}}">
									<div class="ui labeled input mini">
										<div class="ui label">
										    Encabezado
										</div>
									    <input type="text" name="encabezado" value="{{isset($encabezado)?$encabezado:old('encabezado')}}" placeholder="Encabezado">
									</div>
									@if ($errors->ingresoExtraUpdate->has('encabezado'))
										<div class="ui left pointing red basic label">
											{{$errors->reporteGeneral->first('encabezado')}}		
									    </div>
									@endif
								</div>		
								<div class="four wide field  {{$errors->reporteGeneral->has('mensaje')?'error':''}}">
									<div class="ui labeled input mini">
										<div class="ui label">
										    Mensaje
										</div>
									    <input type="text" name="mensaje" value="{{isset($mensaje)?$mensaje:old('mensaje')}}" placeholder="Mensaje">
									</div>
									@if ($errors->ingresoExtraUpdate->has('mensaje'))
										<div class="ui left pointing red basic label">
											{{$errors->reporteGeneral->first('mensaje')}}		
									    </div>
									@endif
								</div>		
								<div class="two wide field  {{$errors->reporteGeneral->has('mes')?'error':''}}">
									<div class="ui labeled input mini">
										<div class="ui label">
										    Mes
										</div>
										<select name="mes" class="ui dropdown date">
											@foreach (config('helper.meses') as $mes => $codigo)
											  <option value="{{$codigo}}" {{($codigo === $fecha->month)?'selected':''}}>{{ ucfirst($mes) }}</option>
											@endforeach
										</select>
									</div>
									@if ($errors->ingresoExtraUpdate->has('mes'))
										<div class="ui left pointing red basic label">
											{{$errors->reporteGeneral->first('mes')}}		
									    </div>
									@endif
								</div>
								<div class="two wide field  {{$errors->reporteGeneral->has('anio')?'error':''}}">
									<div class="ui labeled input mini">
										<div class="ui label">
										    Año
										</div>
										<select name="anio" class="ui dropdown date">
										  @for ($i = 2012; $i <= Date::now()->year; $i++)
											  <option value="{{$i}}" {{($i === $fecha->year)?'selected':''}}>{{$i}}</option>
										  @endfor
										</select>
									</div>
									@if ($errors->ingresoExtraUpdate->has('anio'))
										<div class="ui left pointing red basic label">
											{{$errors->reporteGeneral->first('anio')}}		
									    </div>
									@endif
								</div>
								<div class="ui buttons">
									<input type="submit" name="mostrar" value="Mostrar" class="ui positive button">
									<div class="or" data-text="O"></div>
									<input type="submit" name="guardar" value="Guardar" class="ui black button">
								</div>
							</div>	
							<div class="inline fields">
								<div class="four wide field  {{$errors->reporteGeneral->has('presupuesto_atrazadas')?'error':''}}">
									<div class="ui labeled input mini">
										<div class="ui label">
										    Presupuesto Atrazadas
										</div>
									    <input type="text" name="presupuesto_atrazadas" value="{{isset($presupuesto_atrazadas)?$presupuesto_atrazadas:old('presupuesto_atrazadas')}}" placeholder="Presupuesto Atrazadas">
									</div>
									@if ($errors->ingresoExtraUpdate->has('presupuesto_atrazadas'))
										<div class="ui left pointing red basic label">
											{{$errors->reporteGeneral->first('presupuesto_atrazadas')}}		
									    </div>
									@endif
								</div>		
								<div class="four wide field  {{$errors->reporteGeneral->has('diferencia')?'error':''}}">
									<div class="ui labeled input mini">
										<div class="ui label">
										    Diferencia Vecinales Autorizado	
										</div>
									    <input type="text" name="diferencia" value="{{isset($diferencia)?$diferencia:old('diferencia')}}" placeholder="Diferencia Vecinales Autorizado">
									</div>
									@if ($errors->ingresoExtraUpdate->has('diferencia'))
										<div class="ui left pointing red basic label">
											{{$errors->reporteGeneral->first('diferencia')}}		
									    </div>
									@endif
								</div>		
							</div>		
						</form>
						<div class="ui divider"></div>
						<div class="ui two column centered grid">
						  <div class="four column centered row">
						  @php
						  	$anio =$fecha->year;
						  	$mes = $fecha->month;
						  @endphp
								<iframe src="{{ route('mostrarReporteGeneral',compact('anio','mes','encabezado','mensaje','presupuesto_atrazadas','diferencia')) }}" frameborder="0" width="850"  scrolling="auto" height="1100"></iframe>
						  </div>
						</div>
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

