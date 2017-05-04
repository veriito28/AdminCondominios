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
							Reporte de Ingresos <span class="ui header green">"{{$condominio->nombre}}"</span> - {{$fecha->format('F Y')}}
						</h2>
						<div class="ui divider"></div>
						<form class="ui form large equal width" action="{{route('reporteIngresos',['anio'=> $fecha->year,'mes'=>$fecha->month])}}" methodp="post">
							{{csrf_field()}}
							<div class="inline fields">
								<div class="eight wide field  {{$errors->reporteGeneral->has('encabezado')?'error':''}}">
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
									 @php
									  	$anio =$fecha->year;
									  	$mes = $fecha->month;									  	
									  @endphp
									<a target="_blank" href="{{ route('mostrarReporteIngresos',compact('encabezado','anio','mes')) }}" type="submit" class="ui black button">
										Imprimir
									</a>
								</div>
									 
							</div>	
						</form>
						<div class="ui divider">
						</div>
						<div class="ui two column centered grid">
							<div class="ui eight column centered row">
							<table class="ui table single line table-ingresos" >
								<thead>
									<tr>
										<th colspan="5">Ingreso</th>
									</tr>
									<tr>
										<th >CASA</th>
										<th  >CONDOMINIO</th>
										<th class="center aligned ui">ADEUDO A {{$fecha->format('F - Y')}}</th>
										<th class="center aligned ui">PAGO DEL MES</th>
										<th class="center aligned ui" >TOTAL DE ADEUDO</th>
									</tr>
								</thead>    	
								<tbody>
										@php
											$sumaHastaTotal = 0;
											$sumaDelTotal = 0;
											$sumaTodoTotal = 0;
										@endphp
										@foreach ($condominio->casas as $casa)
											<tr>
												<td>	
													{{$casa->nombre}}
												</td>
												<td>	
													{{$casa->contacto}}
												</td>
												<td class="center aligned ui">
													$ {{$hasta = \App\Adeudo::casaHasta($casa->id,$fecha)->get()->sum('adeudado')}}
												</td>
												<td class="center aligned ui">
													$ {{$del = \App\Adeudo::casaDelMes($casa->id,$fecha)->get()->sum('adeudado')}}
												</td>
												<td class="center aligned ui">
													$ {{$todos = \App\Adeudo::casaTodos($casa->id)->get()->sum('adeudado')}}
												</td>
												@php
													$sumaHastaTotal += $hasta;
													$sumaDelTotal += $del;
													$sumaTodoTotal += $todos;
												@endphp
											</tr>
										@endforeach
										<tr>
											<td class="right aligned " colspan="2">
												TOTAL
											</td>
											<td class="ui center aligned total">
												$ {{$sumaHastaTotal}}
											</td>
											<td class="ui center aligned total">
												$ {{$sumaDelTotal}}
											</td>
											<td class="ui center aligned total">
												$ {{$sumaTodoTotal}}
											</td>
										</tr>
								</tbody>
							</table>
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

