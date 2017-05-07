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
							Otros Adeudos <span class="ui header green">"{{$condominio->nombre}}"</span> - {{$anio}}
						</h2>
						<table class="ui green celled table">
							<thead >
								<tr>
									<th colspan="4">
										<div class="ui form form-inline pull-left">
												<div class="fields inline">													
													<div class="ui floating labeled icon dropdown button">
														<i class="calendar  icon"></i>
														<span class="text">{{$anio}}</span>
														<div class="menu">
															@for ($i = 2012; $i <= \Carbon\Carbon::now()->year ; $i++)
																@if ($i != $anio)
																	<a href="{{  route('otrosAdeudos',['anio'=> $i]) }}" class="item">
																		{{$i}}
																	</a>
																@endif
															@endfor
														</div>
													</div>
												</div>
											</div>	
											<a href="#!" class="nuevoOtroAdeudo ui right floated small black icon button">
												<i class="large icons">
													<i class="dollar icon"></i>
													<i class="inverted corner add icon"></i>
												</i>
												Agregar Adeudo
											</a>
									</th>
								</tr>
								<tr>
									<th>
										Casa	
									</th>
									
									<th width="40%">
										Concepto	
									</th>
									<th>
										Cantidad
									</th>
									<th>
										Fecha
									</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($otrosAdeudos as $otroAdeudo)
								<tr>
									<td>
										<h4 class="ui image header">
											<i class="ui mini home icon"></i>
											<div class="content">
												{{$otroAdeudo->casa->nombre}}
												<div class="sub header">
													{{$otroAdeudo->casa->contacto}}
												</div>
											</div>
										</h4>
									</td>
									<td >
										{{$otroAdeudo->concepto}}
									</td>
									<td >
										$ {{$otroAdeudo->cantidad}}
									</td>
									<td class="cell-action">
										{{$otroAdeudo->fecha->format('j \\d\\e F Y ')}}
										<div class="options">
											<div class="ui small basic icon buttons">
												<a href="{{ route('editarOtroAdeudo',['anio'=>$anio,'id'=>$otroAdeudo->id]) }}" class="ui button basic green"><i class="edit icon"></i></a>
												<a id="removerElemento{{$otroAdeudo->id}}"  class="ui button basic red"><i class="trash icon"></i></a>
											</div>
										</div>
									</td>
								</tr>
								@endforeach
								<form name="formTable" action="{{route('guardarOtroAdeudo',compact('anio'))}}" method="POST" class="form-inline">
									{{ csrf_field() }}
									<input type="hidden" name="condominio_id" value="{{$condominio->id}}">
									<input type="hidden" name="form" value="table">
									<tr class="agregar active">
										<td>
											<div class="ui input mini ">
												<div class="ui selection dropdown {{$errors->otroAdeudoStore->has('casa_id') && old('form') == 'table'?' error':''}}">
													<input type="hidden" name="casa_id" value="{{old('casa_id')}}">
													<i class="dropdown icon"></i>
													<div class="default text">Seleccione una opción</div>
													<div class="menu">
														@foreach ($condominio->casas as $casa)
														<div class="item" data-value="{{$casa->id}}">{{$casa->nombre}}</div>
														@endforeach
													</div>
												</div>
											</div>	
										</td>
										<td>
											<div class="ui input mini {{$errors->otroAdeudoStore->has('concepto') && old('form') == 'table'?' error':''}}">
												<input 	type="text" 
														autocomplete="off" 
														class="input-table" 
														name="concepto" 
														placeholder="Concepto" 
														value="{{old('concepto')? old('concepto'):''}}">
											</div>										
										</td>
										<td>
											<div class="ui input mini {{$errors->otroAdeudoStore->has('cantidad') && old('form') == 'table'?' error':''}}">
												<input 	type="number" 
														autocomplete="off" 
														class="input-table" 
														name="cantidad" 
														placeholder="Cantidad" 
														value="{{old('cantidad')? old('cantidad'):''}}">
											</div>										
										</td>
										<td class="cell-action">
											<div class="ui input mini {{$errors->otroAdeudoStore->has('cantidad') && old('form') == 'table'?' error':''}}">
												<input 	type="date" 
														autocomplete="off" 
														class="input-table" 
														name="fecha" 
														placeholder="Fecha" 
														value="{{old('fecha')? old('fecha'):\Date::now()->year($anio)->toDateString()}}">
											</div>	
											<div class="options">
												<div class="ui icon buttons">
													<button class="ui button green"><i class="plus icon"></i></button>
												</div>
											</div>
										</td>
									</tr>
								</form>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@include('adeudos.otros.create',compact('errors','anio','condominio'))
@endsection

@section('scripts')
	@parent
	@include('removeOption',['elementos'=>$otrosAdeudos,'ruta'=>'eliminarOtroAdeudo'])
@endsection

