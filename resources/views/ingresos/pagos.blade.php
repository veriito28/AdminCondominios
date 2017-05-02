@extends('template')
@section('contenido')

<div class=" stretched column">
	<div class="html">
		<div class="ui  column centered grid">
			<div class="column">
				<div class="ui segments">
					<div class="ui green segment content-pull"> 
						<div class="ui right aligned header">
							<h2>
								<img src="{{ asset('img/logo.png') }}" alt="" width="150px">
								<br>
								Smart Condominios
							</h2>
						</div>
						<h2 class="ui left header pull-left">
							<i class="circular building icon"></i>
							Pagos Mensuales <span class="ui header green">"{{$condominio->nombre}}"</span>- {{$anio}}
						</h2>
						<form action="{{ route('guardarPagos',['tipo'=>$tipo,'anio'=> $anio]) }}" method="POST">
							{{ csrf_field() }}
							<table class="ui green compact very line table table-pagos">
								<thead >
									<tr>
										<th colspan="13">
											<h3>Pagos Mensuales</h3>
											<div class="ui form">
												<div class="fields inline">
													<div class="ui floating labeled icon dropdown button">
														<i class="calendar  icon"></i>
														<span class="text">{{$anio}}</span>
														<div class="menu">
															@for ($i = 2012; $i <= \Carbon\Carbon::now()->year ; $i++)
													    		@if ($i != $anio)
																	<a href="{{  route('pagos',['tipo'=>$tipo,'anio'=> $i]) }}" class="item">
														    			{{$i}}
																	</a>
													    		@endif
												    		@endfor
														</div>
													</div>
													<button  type="submit" class="ui green button">
														GUARDAR
													</button>
													<div class="field">
														<div class="ui labeled input">
														  	<div class="ui label">
														  	  	Del
														  	</div>
														  	<input type="text" placeholder="Del" readonly="" value="1">
														</div>
														<div class="ui labeled input">
															<div class="ui label">
														    	Al
															</div>
														  	<input type="text" placeholder="Al" readonly="" value="{{$condominio->casas->max('id')}}">
														</div>
												   	</div>
													<a href="{{ route('pagos',['tipo'=>'mensualidad','anio'=> $anio])}}" type="submit" class="ui primary button  {{Request::is('usuario/condominio/ingresos/pagos/mensualidad*')?'hide':''}}">
														NORMALES
													</a>
													<a href="{{ route('pagos',['tipo'=>'atradasas','anio'=> $anio])}}" type="submit" class="ui black button  {{Request::is('usuario/condominio/ingresos/pagos/atradasas*')?'hide':''}}">
														ATRASADAS
													</a>
													<a href="{{ route('pagos',['tipo'=>'adelantadas','anio'=> $anio])}}" type="submit" class="ui orange button {{Request::is('usuario/condominio/ingresos/pagos/adelantadas*')?'hide':''}}">
														ADELANTADAS
													</a>

												</div>
											</div>	
										</th>
									</tr>
									<tr>
										<th>
											Casa	
										</th>
										@foreach ($meses as $mes => $index)
											<th>
												{{strtoupper($mes)}}										
											</th>
										@endforeach
									</tr>
									<tr class="tr-adeudo">
										<th>Mensualidad</th>
										@foreach ($meses as $mes => $index)
											<th>
												$ {{doubleval($adeudosMensuales->first(function ($value, $key) use ($anio,$index) {return $value->fecha->month == $index && $value->fecha->year == $anio && $value->tipo == 'M';})['cantidad'])}}
											</th>
										@endforeach
									</tr>
								</thead>
								<tbody>
									@foreach ($condominio->casas as $casa)
									<tr>
										<td class="cell-action">
											{{$casa->nombre}}
										</td>
										@foreach ($meses as $mes => $index)
											<td>
												<div class="ui input {{$errors->has($mes.'.'.$casa->id)?'error':''}}">
													<input 	type="text" 
															class="input-table" 
															autocomplete="off" 
															name="{{$mes}}[{{$casa->id}}]" 
															placeholder="0.00" 
															value="{{old($mes.'.'.$casa->id)? old($mes.'.'.$casa->id): (($val = doubleval($casa->pagos->first(function ($value, $key) use ($anio,$index,$tipo) {return $value->fecha->month == $index && $value->fecha->year == $anio && $value->concepto == $tipo;})['cantidad']))!=0?$val:'')}}">
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
@include('casas.create',['errors' => $errors])
@endsection

@section('scripts')
<script>
	@parent
	$(document).ready(function() {
    	var meses = [	"enero", 
    					"febrero", 
    					"marzo", 
    					"abril" , 
    					"mayo" , 
    					"junio", 
    					"julio", 
    					"agosto", 
    					"septiembre", 
    					"octubre", 
    					"noviembre", 
    					"diciembre"];
		$(".input-table").focus(function() {
			var vm = this;
			setTimeout(function() {
				$(vm).select();
			},1);			
		});

		$(".input-table").keydown(function(event ) {
			var index = $(this).prop('name').match(/\[(.*?)\]/)[1];
			var nombre = $(this).prop('name').match(/([a-z])\w+/)[0];
			var x = meses.indexOf(nombre);
			var maxIndex = {{$condominio->casas->max('id')}};
			if (event.keyCode >=37 && event.keyCode <=40) {
				switch(event.keyCode){
					case 38: //arriba
						index = index <= 1 ? maxIndex : index - 1;			
						break;
					case 37://izquierda
						x = x <= 0 ? 11 : x - 1;
						break;
					case 40://abajo
						index ++;
						index = index > maxIndex ? 1 : index;
						break;
					case 39://deracha
						x = x >= 11 ? 0 : x + 1;
						break;
				}
				$('input[name="'+meses[x]+'['+index+']"]').focus();
			}
		});
	});
</script>
@stop
		

