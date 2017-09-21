@extends('template')
@section('contenido')
@php
	$fecha = Date::parse($anio.'/'.$meses[$mes].'/1');
	$fecha_limite = Date::parse($anio.'/'.$meses[$mes].'/1');
	$mespasado = Date::parse($anio.'/'.$meses[$mes].'/1');

@endphp
<div class=" stretched column">
	<div class="html">
		<div class="ui  column centered grid">
			<div class="column">
				<div class="ui segments">
					<div class="ui green segment "> 
						<div class="ui right aligned header">
							<h2>
								<img src="{{ asset('img/logo.png') }}" alt="" width="150px">
								Smart Condominios
							</h2>
						</div>
						<h3 class="ui left header pull-left">
							<i class="circular icon">
								<img src="{{$condominio->imagen}}" class="ui circular large image" alt="">								
							</i>
							Control de Ingresos de <span class="ui header green">"{{$condominio->nombre}}"</span> al {{$fecha_limite->subDay()->format('d \\d\\e\\ F Y')}}
						</h3>
					</div>
					<div class="ui green segment  segment-sin-padding"> 
						<form action="{{route('guardarPagosMensuales',['mes'=>$mes,'anio'=>$anio])}}" method="POST">
							{{ csrf_field() }}
							<div class="ui top attached white tabular menu">
								@foreach ($meses as $m => $index)
									<a href="{{route('pagosMensuales',['mes'=>$m,'anio'=>$anio])}}" class="item {{($mes == $m)?'active':''}}">
										{{strtoupper($m)}} {{-- &nbsp;<b>{{$anio}}</b> --}}
									</a>
								@endforeach
								<div class="right menu">
									<div class="item">
										<div class="ui form">
											<div class="fields inline">
												<div class="ui floating labeled icon dropdown button">
													<i class="calendar  icon"></i>
													<span class="text">{{$anio}}</span>
													<div class="menu">
														@for ($i = 2012; $i <= \Carbon\Carbon::now()->year ; $i++)
												    		@if ($i != $anio)
																<a href="" class="item">
													    			{{$i}}
																</a>
												    		@endif
											    		@endfor
													</div>
												</div>
												
												<button  type="submit" class="ui green button">
													GUARDAR
												</button>

											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="ui buttom secondary attached active tab ">
								<table class="ui table table-pagos">
									<thead >
										<tr>
											<th>
												Casa	
											</th>
											<th>Adeudo  al {{ $fecha_limite->format('d \\d\\e\\ F Y')}}</th>
											<th>Adeudo  al {{ $fecha->format('d \\d\\e\\ F Y')}}</th>
											<th>
												TOTAL PAGADO EN {{strtoupper($mes)}}
											</th>
											<th>
												Comentario
											</th>
										</tr>
									</thead>
									<tbody>
									@php
										$mespasado->subMonth();
									@endphp
										@foreach ($condominio->casas as $casa)
										<tr>
											<td class="cell-action" title="{{$casa->contacto}}">
												{{$casa->nombre}}
											</td>
											<td >
												{{$casa->adeudosHasta($mespasado)->first()['adeudado'] - $casa->pagadoHasta($mespasado)->first()['pagado']}}
											</td>
											<td>
												{{$casa->adeudosHasta($fecha)->first()['adeudado'] - $casa->pagadoHasta($fecha)->first()['pagado']}}
											</td>
											<td>
												<div class="ui input">
													<input 	type="text" 
													class="input-table" 
													autocomplete="off" 
													name="{{$mes}}[{{$casa->id}}]" 
													placeholder="0.00" 
													value="{{$casa->pagoDe($fecha)->first()['cantidad']}}">
												</div>
											</td>
											<td>
												<div class="ui input">
													<input 	type="text" 
													class="input-table" 
													autocomplete="off" 
													name="comentario_{{$mes}}[{{$casa->id}}]" 
													placeholder="Comentario" 
													value="">
												</div>
											</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')

@stop