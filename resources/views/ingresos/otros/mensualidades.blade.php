@extends('template')
@section('contenido')

<div class=" stretched column">
	<div class="html">
		<div class="ui  column centered grid">
			<div class="column">
				<div class="ui compact segments">
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
							Pagos de <span class="ui header green">"{{$otroAdeudo->casa->nombre}}"</span> - {{$otroAdeudo->concepto}}
						</h2>
						<div class="ui   segment">
								<p>Total Adeudo: <strong>$ {{$otroAdeudo->cantidad}}</strong></p>
								<p>Pagado: <strong>$ {{$otroAdeudo->pagos()->sum('cantidad')}}</strong></p>

						    <div>
								Adeudo Actual: <strong>$ {{$otroAdeudo->cantidad - $otroAdeudo->pagos()->sum('cantidad')}}</strong>
						    </div>
						</div>
						
					<form action="{{route('guardarOtrosPagos',compact('anio'))}}" method="POST">
							{{ csrf_field() }}
							<table class="ui compact very line table table-pagos">
								<thead >
									<th colspan="12">
										<div class="ui form">
											<div class="fields inline">
												<div class="ui floating labeled icon dropdown button">
													<i class="calendar  icon"></i>
													<span class="text">{{$anio}}</span>
													<div class="menu">
														@for ($i = $otroAdeudo->fecha->year; $i <= \Carbon\Carbon::now()->year ; $i++)
												    		@if ($i != $anio)
																<a href="{{  route('pagosDeAduedo',['id'=>$otroAdeudo->id,'anio' => $i]) }}" class="item">
													    			{{$i}}
																</a>
												    		@endif
											    		@endfor
													</div>
												</div>
												<button  type="submit" class="ui green button">
													GUARDAR
												</button>
												<a class="ui orange button" href="{{ route('otrosPagos',['anio'=>$otroAdeudo->fecha->year]) }}">ATRAS</a>
											</div>
										</div>
									</th>
									<tr>
										@foreach (config('helper.meses') as $mes => $index)
											<th>
												{{strtoupper($mes)}}										
											</th>
										@endforeach
									</tr>
								</thead>
								<tbody>
									<tr>
										@foreach (config('helper.meses') as $mes => $index)
											<td>
												<div class="ui input {{$errors->has($mes.'.'.$otroAdeudo->id)?'error':''}}">
													<input 	type="text" 
															class="input-table" 
															autocomplete="off" 
															name="{{$mes}}[{{$otroAdeudo->id}}]" 
															placeholder="0.00" 
															value="{{old($mes.'.'.$otroAdeudo->id)? old($mes.'.'.$otroAdeudo->id): (($val = doubleval($otroAdeudo->pagos->first(function ($value, $key) use ($anio,$index) {return $value->fecha->month == $index && $value->fecha->year == $anio && $value->tipo == 'O';})['cantidad']))!=0?$val:'')}}">
												</div>										
											</td>
										@endforeach
									</tr>
								</tbody>
							</table>
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
			var maxIndex = 1;
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






	<div class="content">
		{{ csrf_field() }}
		
</form>
