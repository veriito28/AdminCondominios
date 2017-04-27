@extends('template')
@section('contenido')
<div class=" stretched column">
	<div class="html">
		<div class="ui  column centered grid">
			<div class="column">
				<div class="ui segments">
					<div class="ui green segment content-pull"> 
						<div class="ui center aligned header">
							<h2>
								<img src="{{ asset('img/logo.png') }}" alt="" width="150px">
								<br>
								Smart Condominios
							</h2>
						</div>
						<h2 class="ui left header pull-left">
							<i class="circular building icon"></i>
							Pagos Mensuales 
						</h2>
						<form action="{{ route('guardarPagos') }}" method="POST">
							{{ csrf_field() }}
							<table class="ui green compact very line table table-pagos">
								<thead >
									<tr>
										<th colspan="13">
											<h3>Pagos Mensuales</h3>
											<div class="ui form">
												<div class="fields inline">
													<div class="field">
														<div class="ui labeled input">
														  	<div class="ui label">
														  	  	Año
														  	</div>
													    	<select name="year" class="ui search dropdown">
													    		@for ($i = 2012; $i <= \Carbon\Carbon::now()->year ; $i++)
														    		<option value="{{$i}}" {{$i == $year?'selected':''}}>{{$i}}</option>
													    		@endfor
												    		</select>
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
														  	<input type="text" placeholder="Del">
														</div>
														<div class="ui labeled input">
															<div class="ui label">
														    	Al
															</div>
														  	<input type="text" placeholder="Al">
														</div>
												   	</div>
													<button  type="submit" class="ui black button">
														ATRASADAS
													</button>
													<button  type="submit" class="ui orange button">
														ADELANTADAS
													</button>

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
								</thead>
								<tbody>
									@foreach ($condominio->casas as $casa)
									<tr>
										<td class="cell-action">
											{{$casa->nombre}}
										</td>
										@foreach ($meses as $mes => $index)
											<td>
												<div class="ui input">
													<input 	type="text" 
															autocomplete="off" 
															name="{{$mes}}[{{$casa->id}}]" 
															placeholder="0.00" 
															value="{{$casa->pagos->first(function ($value, $key) use ($index) {return \Carbon\Carbon::parse($value->fecha)->month == $index;})['cantidad']}}">
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
		
		$( "input[type=text]" ).keydown(function(event ) {
			var index = $(this).prop('name').match(/\[(.*?)\]/)[1];
			var nombre = $(this).prop('name').match(/([a-z])\w+/)[0];
			var x = meses.indexOf(nombre);
			var maxIndex = {{$condominio->casas->max('id')}};

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
					// x = x >= 11 ? 0 : x + 1;
					break;
			}
			$('input[name="'+meses[x]+'['+index+']"]').focus();			
		});
	});
</script>
@stop


