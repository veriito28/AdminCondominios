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
							Gastos Ordinarios Mensuales <span class="ui header green">"{{$condominio->nombre}}"</span> - {{$anio}}
						</h2>
						<form action="{{ route('guardarGastosOrdinarios',['anio'=> $anio]) }}" method="POST">
							{{ csrf_field() }}
							<input type="hidden" value="{{$condominio->id}}" name="condominio_id">
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
															{{-- <div class="header">
																<i class="tags icon"></i>
																Años
															</div> --}}
															@for ($i = 2012; $i <= \Carbon\Carbon::now()->year ; $i++)
																@if ($i != $anio)
																	<a href="{{  route('gastosOrdinarios',['anio'=> $i]) }}" class="item">
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
										</th>
									</tr>
									<tr>
										<th>
											CONCEPTO	
										</th>
										@foreach ($meses as $mes => $index)
											<th>
												{{strtoupper($mes)}}										
											</th>
										@endforeach
									</tr>
								</thead>
								<tbody>
									@foreach ($conceptos as $concepto)
									<tr>
										<td class="cell-action">
											{{$concepto->nombre}}
										</td>
										@foreach ($meses as $mes => $index)
											<td>
												<div class="ui input {{$errors->has($mes.'.'.$concepto->id)?'error':''}}">
													<input 	type="text"
															class="input-table" 
															autocomplete="off" 
															name="{{$mes}}[{{$concepto->id}}]" 
															placeholder="0.00" 
															value="{{old($mes.'.'.$concepto->id)?old($mes.'.'.$concepto->id):(($val = doubleval($concepto->gastos->first(function ($value, $key) use ($index, $condominio,$anio) {return $value->fecha->month == $index && $value->fecha->year == $anio && $condominio->id == $value->condominio_id;})['cantidad']))!=0?$val:'')}}">
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
		$( "#target" ).focus(function() {
		  alert( "Handler for .focus() called." );
		
		});
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
			},0);			
		});

		$(".input-table").keydown(function(event ) {
			var index = $(this).prop('name').match(/\[(.*?)\]/)[1];
			var nombre = $(this).prop('name').match(/([a-z])\w+/)[0];
			var x = meses.indexOf(nombre);
			var maxIndex = {{$conceptos->max('id')}};
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


