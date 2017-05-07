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
							Gastos Extraordinarios <span class="ui header green">"{{$condominio->nombre}}"</span> - {{$anio}}
						</h2>
						<table class="ui green celled table">
							<thead >
								<tr>
									<th colspan="3">
										<div class="ui form form-inline pull-left">
												<div class="fields inline">													
													<div class="ui floating labeled icon dropdown button">
														<i class="calendar  icon"></i>
														<span class="text">{{$anio}}</span>
														<div class="menu">
														
															@for ($i = 2012; $i <= \Carbon\Carbon::now()->year ; $i++)
																@if ($i != $anio)
																	<a href="{{  route('gastosExtraordinarios',['anio'=> $i]) }}" class="item">
																		{{$i}}
																	</a>
																@endif
															@endfor
														</div>
													</div>
												</div>
											</div>	
											<a href="#!" class="nuevoGastoExtra ui right floated small black icon button">
												<i class="large icons">
													<i class="dollar icon"></i>
													<i class="inverted corner add icon"></i>
												</i>
												Agregar Gasto Extraordinario
											</a>
									</th>
								</tr>
								<tr>
									<th>
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
								@foreach ($gastosExtraordinarios as $gastoExt)
								<tr>
									<td >
										{{$gastoExt->concepto}}
									</td>
									<td >
										$ {{$gastoExt->cantidad}}
									</td>
									<td class="cell-action">
										{{$gastoExt->fecha->format('j \\d\\e F Y ')}}
										<div class="options">
											<div class="ui small basic icon buttons">
												<a href="{{ route('editarGastoExtraordinario',['anio'=>$anio,'id'=>$gastoExt->id]) }}" class="ui button basic green"><i class="edit icon"></i></a>
												<a id="removerElemento{{$gastoExt->id}}"  class="ui button basic red"><i class="trash icon"></i></a>
											</div>
										</div>
									</td>
								</tr>
								@endforeach
								<form action="{{route('guardarGastoExtraordinario',compact('anio'))}}" method="POST" class="form-inline">
									{{ csrf_field() }}
									<input type="hidden" name="condominio_id" value="{{$condominio->id}}">
									<input type="hidden" name="form" value="table">
									<tr class="agregar active">
										<td>
											<div class="ui input mini {{$errors->gastoExtraStore->has('concepto') && old('form') == 'table'?' error':''}}">
												<input 	type="text" 
														autocomplete="off" 
														class="input-table" 
														name="concepto" 
														placeholder="Concepto" 
														value="{{old('concepto')? old('concepto'):''}}">
											</div>										
										</td>
										<td>
											<div class="ui input mini {{$errors->gastoExtraStore->has('cantidad') && old('form') == 'table'?' error':''}}">
												<input 	type="number" 
														autocomplete="off" 
														class="input-table" 
														name="cantidad" 
														placeholder="Cantidad" 
														value="{{old('cantidad')? old('cantidad'):''}}">
											</div>										
										</td>
										<td class="cell-action">
											<div class="ui input mini {{$errors->gastoExtraStore->has('cantidad') && old('form') == 'table'?' error':''}}">
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
@include('gastos.extraordinarios.create',compact('errors','anio','condominio'))
@endsection

@section('scripts')
	@parent
	@include('removeOption',['elementos'=>$gastosExtraordinarios,'ruta'=>'eliminarGastoExtraordinario'])
@endsection

