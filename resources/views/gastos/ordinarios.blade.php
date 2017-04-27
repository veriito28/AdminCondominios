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
							Gastos Ordinarios Mensuales 
						</h2>
						<form action="{{ route('guardarGastosOrdinarios') }}" method="POST">
							{{ csrf_field() }}
							<input type="hidden" value="{{$condominio->id}}" name="condominio_id">
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
												<div class="ui input">
													<input 	type="text" 
															autocomplete="off" 
															name="{{$mes}}[{{$concepto->id}}]" 
															placeholder="0.00" 
															value="{{$concepto->gastos->first(function ($value, $key) use ($index, $condominio) {return \Carbon\Carbon::parse($value->fecha)->month == $index && $condominio->id == $value->condominio_id;})['cantidad']}}">
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
		var keys = [];

		$(document).keydown(function (e) {
		    keys[e.which] = true;
		});

		$(document).keyup(function (e) {
		    delete keys[e.which];
		});
		
		$( "input[type=text]" ).keydown(function(event ) {
			var index = $(this).prop('name').match(/\[(.*?)\]/)[1];
			var nombre = $(this).prop('name').match(/([a-z])\w+/)[0];
			var x = meses.indexOf(nombre);
			var maxIndex = {{$conceptos->max('id')}};

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
		});
	});
</script>
@stop


