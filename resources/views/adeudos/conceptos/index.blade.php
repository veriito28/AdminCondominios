@extends('template')
@section('contenido')
<div class=" stretched column">
	<div class="html">
		<div class="ui  column centered grid">
			<div class="column">
				<div class="ui segments">
					<div class="ui green segment"> 
						<h2 class="ui right aligned header">
							<img src="{{ asset('img/logo.png') }}" alt="" width="150px">
							<br>
							Condominios
						</h2>
						<h3 class="ui left header pull-left">
							<i class="circular folder open icon"></i>
							Conceptos de Adeudos 
						</h3>
						<table class="ui green celled table">
							<thead >
								<tr>
									<th colspan="4">
										<h3>Todos los Conceptos
											<a href="#!" class="nuevoConcepto ui right floated small black icon button">
												<i class=" icons">
												    <i class="home icon"></i>
												    <i class="inverted corner add icon"></i>
												</i>
												Agregar Concepto
											</a>
										</h3>
									</th>
								</tr>
								<tr>
									<th>
										#	
									</th>
									<th>
										Tipo	
									</th>
									<th>
										Deudor	
									</th>
									<th>
										Nombre
									</th>
								</tr>
							</thead>
							<tbody>
							@php
								$tipo = [
									'M'=>'Mensual',
									'F'=>'Fijo',
								];

								$deudor = [
									'G'=>'General',
									'P'=>'Personal',
								];

							@endphp
								@foreach ($conceptos as $concepto)
								<tr>
									<td class="cell-action">
										{{$concepto->id}}
									</td>
									<td class="cell-action">
										{{$tipo[$concepto->tipo]}}
									</td>
									<td class="cell-action">
										{{$deudor[$concepto->deudor]}}
									</td>
									<td class="cell-action">
										{{$concepto->nombre}}							
										<div class="options">
											<div class="ui small basic icon buttons">
											    <a href="{{ route('editarConceptoAdeudo',['id'=>$concepto->id]) }}" class="ui button basic green"><i class="edit icon"></i></a>
											    <a id="removerElemento{{$concepto->id}}"  class="ui button basic red"><i class="trash icon"></i></a>
											   
											</div>
										</div>

									</td>
								</tr>
								@endforeach
								<form name="formTable" action="{{route('guardarConceptoAdeudo')}}" method="POST" class="form-inline">
									{{ csrf_field() }}
									<input type="hidden" name="form" value="table">
									<input type="hidden" name="condominio_id" value="{{$condominio->id}}">
									<tr class="agregar active">
										<td>
											
										</td>
										<td>
											<div class="ui input mini ">
												<div class="ui selection dropdown {{$errors->conceptoStore->has('tipo') && old('form') == 'table'?' error':''}}">
													<input type="hidden" name="tipo" value="{{old('tipo')}}">
													<i class="dropdown icon"></i>
													<div class="default text">Seleccione una opción</div>
													<div class="menu">
														@foreach ($tipos as $tipo)
															<div class="item" data-value="{{$tipo['id']}}">{{$tipo['nombre']}}</div>
														@endforeach
													</div>
												</div>
											</div>	
										</td>
										<td>
											<div class="ui input mini ">
												<div class="ui selection dropdown {{$errors->conceptoStore->has('deudor') && old('form') == 'table'?' error':''}}">
													<input type="hidden" name="deudor" value="{{old('deudor')}}">
													<i class="dropdown icon"></i>
													<div class="default text">Seleccione una opción</div>
													<div class="menu">
														@foreach ($deudores as $deudor)
															<div class="item" data-value="{{$deudor['id']}}">{{$deudor['nombre']}}</div>
														@endforeach
													</div>
												</div>
											</div>	
										</td>
										<td class="cell-action">
											<div class="ui input mini {{$errors->casaStore->has('nombre') && old('form') == 'table'?' error':''}}">
												<input 	type="text" 
														autocomplete="off" 
														class="input-table" 
														name="nombre" 
														placeholder="Nombre" 
														value="{{old('nombre')}}">
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
@include('adeudos.conceptos.create',compact('errores','tipos','deudores','condominio'))
@endsection

@section('scripts')
	@parent
	@include('removeOption',['elementos'=>$conceptos,'ruta'=>'eliminarConceptoAdeudo'])
@endsection