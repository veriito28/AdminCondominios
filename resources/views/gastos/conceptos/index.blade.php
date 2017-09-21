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
									<th colspan="3">
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
										Nombre
									</th>
								</tr>
							</thead>
							<tbody>
							@php
								$tipo = [
									'G'=>'General',
									'C'=>'Condominio',
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
										{{$concepto->nombre}}							
										<div class="options">
											<div class="ui small basic icon buttons">
											    <a href="{{ route('editarConceptoGasto',['id'=>$concepto->id]) }}" class="ui button basic green"><i class="edit icon"></i></a>
											    <a id="removerElemento{{$concepto->id}}"  class="ui button basic red"><i class="trash icon"></i></a>
											   
											</div>
										</div>

									</td>
								</tr>
								@endforeach
								<form name="formTable" action="{{route('guardarConceptoGasto')}}" method="POST" class="form-inline">
									{{ csrf_field() }}
									<input type="hidden" name="form" value="table">
									<input type="hidden" name="condominio_id" value="{{$condominio->id}}">
									<tr class="agregar active">
										<td>
											
										</td>
										<td>
											<div class="ui input mini ">
												<input type="text" 
												readonly=""
												class="input-table" 
												value="Condominio">	
												<input type="hidden" value="C" name="tipo">	
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
@include('gastos.conceptos.create',compact('errores','tipos','condominio'))
@endsection

@section('scripts')
	@parent
	@include('removeOption',['elementos'=>$conceptos,'ruta'=>'eliminarConceptoGasto'])
@endsection