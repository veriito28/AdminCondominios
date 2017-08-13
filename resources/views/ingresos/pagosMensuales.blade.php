@extends('template')
@section('contenido')
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
							Control de Ingresos de <span class="ui header green">"{{$condominio->nombre}}"</span> al {{\Date::parse($anio.'/'.$meses[$mes].'/1')->subDay()->format('d \\d\\e\\ F Y')}}
						</h3>
					</div>
					<div class="ui green segment  segment-sin-padding"> 
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
							<form action="" method="POST">
								{{ csrf_field() }}
								<table class="ui green compact very line table table-pagos">
									<thead >
										<tr>
											<th>
												Casa	
											</th>
											<th>Adeudo  al {{\Date::parse($anio.'/'.$meses[$mes].'/1')->subDay()->format('d \\d\\e\\ F Y')}}</th>
											<th>Adeudo  al {{\Date::parse($anio.'/'.$meses[$mes].'/1')->format('d \\d\\e\\ F Y')}}</th>
											@foreach ($conceptos as $concepto)
												<th>
													Pago de {{$concepto->nombre}}
												</th>
											@endforeach 
										</tr>
									</thead>
									<tbody>
										@foreach ($condominio->casas as $casa)
										<tr>
											<td class="cell-action" title="{{$casa->contacto}}">
												{{$casa->nombre}}
											</td>
											<td >
												<span id="buttom{{$casa->id}}">
													100.11
												</span>
												<div id="popup{{$casa->id}}" class="ui flowing popup buttom left transition hidden">
													<div class="ui one column divided center aling grid">
														<div class="column">
															<div class="header">
																asdasdasd
															</div>
															<div>
																sdasdasd
															</div>
														</div>
													</div>
												</div>
												<script>
													$(document).ready(function () {
														$('#buttom{{$casa->id}}').popup({
															'popup':'#popup{{$casa->id}}',
															on:'hover'
														});	
													});
												</script>
											</td>
											<td>100.11</td>
											@foreach ($conceptos as $concepto)
												<td>
														@php
															$pago = $casa->pagos->first(function ($value, $key) use ($anio,$index,$concepto) {
																return $value->fecha->month == $index 
																		&& $value->fecha->year == $anio
																		&& $value->adeudo->concepto_id == $concepto->id;
															});
															$valor = null;
															$dif = null;
															if(isset($pago)){
																$valor =  $pago->cantidad;
																$fecha_pago = \Carbon\Carbon::createFromDate($pago->fecha_pago->year,$pago->fecha_pago->month,1);
																$dif = $fecha_pago->diffInDays($pago->fecha,false);
															} 
														@endphp
														<div class="ui input">
															<input 	type="text" 
															class="input-table" 
															autocomplete="off" 
															name="{{$mes}}[{{$casa->id}}]" 
															placeholder="0.00" 
															value="{{old($mes.'.'.$casa->id)? old($mes.'.'.$casa->id): (doubleval($valor)!=0?$valor:'')}}">
														</div>

													</td>
												@endforeach
		
											</tr>
										@endforeach
									</tbody>
								</table>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')

@stop