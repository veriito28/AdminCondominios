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
							Reporte Personal  <span class="ui header green">"{{$casa->nombre}}"</span> - {{$fecha->format('F Y')}}
						</h2>
						<div class="ui divider"></div>
						 @php
						  	$anio =$fecha->year;
						  	$mes = $fecha->month;
						  	$casa_id = $casa->id;
						  @endphp
						<form class="ui form large equal width" action="{{route('reportePersonal',compact('casa_id','anio','mes','encabezado','mensaje'))}}" method="post">
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
								<div class="four wide field  {{$errors->reporteGeneral->has('cuentas_seleccionadas')?'error':''}}">
									<div class="ui labeled input mini">
										<div class="ui label">
										    Agregar Cuenta
										</div>
										<div class="ui fluid multiple search selection dropdown">
											<input type="hidden" name="cuentas_seleccionadas" value="{{isset($cuentas_seleccionadas)?$cuentas_seleccionadas:(old('cuentas_seleccionadas')?old('cuentas_seleccionadas'):'')}}">
											<i class="dropdown icon"></i>
											<div class="default text"></div>
											<div class="menu">
												@foreach ($cuentas as $cuenta)
													<div class="item" data-value="{{$cuenta->id}}"><img src="{{$cuenta->imagen}}" alt="Imagen Cuenta">{{$cuenta->mensaje}}</div>
												@endforeach
											</div>
										</div>
									</div>
									@if ($errors->ingresoExtraUpdate->has('cuentas_seleccionadas'))
										<div class="ui left pointing red basic label">
											{{$errors->reporteGeneral->first('cuentas_seleccionadas')}}		
									    </div>
									@endif
								</div>
								
							</div>		
						</form>
						<div class="ui divider"></div>
						<div class="ui two column centered grid">
						  <div class="four column centered row">
							   @php
							  	$mes = $fecha->month;
							  @endphp
								<iframe src="{{ route('mostrarReportePersonal',compact('casa_id','anio','mes','encabezado','mensaje','cuentas_seleccionadas')) }}" frameborder="0" width="850"  scrolling="auto" height="1100"></iframe>
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

