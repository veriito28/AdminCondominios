@extends('template')
@section('contenido')
<div class=" stretched column">
	<div class="html">
		<div class="ui  column centered grid">
			<div class="column">
				<div class="ui segments">
					<div class="ui green segment"> 
						<h2 class="ui center aligned icon header">
							<i class="circular building icon"></i>
							{{$condominio->nombre}}
							{{-- {{$condominio->imagen}} --}}
						</h2>
						<table class="ui green compact celled table">
							<thead >
								<tr>
									<th colspan="5">
										<h3>
											Casas
											<span>
												<form action="{{route('cargarCasas')}}" method="POST" novalidate enctype="multipart/form-data" >
													{{ csrf_field() }}
													<input type="hidden" name="condominio_id" value="{{$condominio->id}}">
													<label for="file" class="ui right floated  green icon button">
												        <i class=" ui icons">
															<i class="file excel outline icon"></i><i class="corner inverted reply icon"></i>
												        </i>
												     	Importar
													    <input type="file" id="file" name="file" style="display:none"  accept=".xls, .xlsx" onchange="this.form.submit();">
												    </label>					
												</form>
												<a href="{{ route('exportarCasas') }}" class="ui right floated  green icon button">
												        <i class=" ui icons">
															<i class="file excel outline icon"></i><i class="corner inverted share icon"></i>
												        </i>
											     	Exportar
												</a>
											</span>
										</h3>
									</th>
								</tr>
								<tr>
									<th>
										Casa	
									</th>
									<th>
										E-mail
									</th>
									<th>Ubicación</th>
									<th>Contacto</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($condominio->casas as $casa)
								<tr>
									<td class="cell-action">
										<h4 class="ui image header">
											<i class="ui mini home icon"></i>
											<div class="content">
												{{$casa->nombre}}
												<div class="sub header">
													{{$casa->contacto}}
												</div>
											</div>
										</h4>
									</td>
									<td>
										{{$casa->email}}										
									</td>
									<td>
										<h4 class="ui image header">
											<i class="ui mini map icon"></i>
											<div class="content">
												Manzana: {{$casa->manzana}}								
												<div class="sub header">
													Lote: {{$casa->lote}}								
												</div>
											</div>
										</h4>
									</td>
									<td class="cell-action">
										<h4 class="ui image header">
											<i class="ui mini phone icon"></i>
											<div class="content">
												Interfon: {{$casa->interfon}}								
												<div class="sub header">
													Tel: {{$casa->telefono}} Cel: {{$casa->celular}}								
												</div>
											</div>
										</h4>
										<div class="options">
											<div class="ui small basic icon buttons">
											    <a href="{{ route('editarCasa',['id'=>$casa->id]) }}" class="ui button basic green"><i class="edit icon"></i></a>
											    <a id="removerElemento{{$casa->id}}"  class="ui button basic red"><i class="trash icon"></i></a>
											</div>
										</div>
									</td>
								</tr>
								@endforeach
								<form action="{{route('guardarCasa')}}" method="POST" novalidate class="form-inline">
									{{ csrf_field() }}
									<input type="hidden" name="condominio_id" value="{{$condominio->id}}">
									<input type="hidden" name="form" value="table">
									<tr class="agregar active">
										<td>
											<div class="ui grid">
												<div class="eight wide column">
													<div class="ui input mini {{$errors->casaStore->has('nombre') && old('form') == 'table'?' error':''}}">
														<input 	type="text" 
																autocomplete="off" 
																class="input-table" 
																name="nombre" 
																placeholder="Nombre" 
																value="{{old('nombre')? old('nombre'):''}}">
													</div>		
												</div>		
												<div class="eight wide column">
													<div class="ui input mini {{$errors->casaStore->has('contacto') && old('form') == 'table'?' error':''}}">
														<input 	type="text" 
																autocomplete="off" 
																class="input-table" 
																name="contacto" 
																placeholder="Contacto" 
																value="{{old('contacto')? old('contacto'):''}}">
													</div>		
												</div>
										</td>		
										<td>
											<div class="ui input mini {{$errors->casaStore->has('email') && old('form') == 'table'?' error':''}}">
												<input 	type="email" 
														autocomplete="off" 
														class="input-table" 
														name="email" 
														placeholder="Correo" 
														value="{{old('email')}}">
											</div>											
										</td>
										<td >
											<div class="ui grid">
												<div class="eight wide column">
													<div class="ui input mini {{$errors->casaStore->has('manzana') && old('form') == 'table'?' error':''}}">
														<input 	type="text" 
																autocomplete="off" 
																class="input-table" 
																name="manzana" 
																placeholder="Manzana" 
																value="{{old('manzana')}}">
													</div>		
												</div>
												<div class="eight wide column">
													<div class="ui input mini {{$errors->casaStore->has('lote') && old('form') == 'table'?' error':''}}">
														<input 	type="text" 
																autocomplete="off" 
																class="input-table" 
																name="lote" 
																placeholder="Lote" 
																value="{{old('lote')}}">
													</div>		
												</div>		
											</div>
										</td>
										<td class="cell-action">
											<div class="ui grid">
												<div class="five wide column">
													<div class="ui input mini {{$errors->casaStore->has('telefono') && old('form') == 'table'?' error':''}}">
														<input 	type="tel" 
																autocomplete="off" 
																class="input-table" 
																name="telefono" 
																placeholder="Telefono" 
																value="{{old('telefono')}}">
													</div>		
												</div>
												<div class="five wide column">
													<div class="ui input mini {{$errors->casaStore->has('celular') && old('form') == 'table'?' error':''}}">
														<input 	type="tel" 
																autocomplete="off" 
																class="input-table" 
																name="celular" 
																placeholder="Celular" 
																value="{{old('celular')}}">
													</div>		
												</div>
												<div class="five wide column">
													<div class="ui input mini {{$errors->casaStore->has('interfon') && old('form') == 'table'?' error':''}}">
														<input 	type="text" 
																autocomplete="off" 
																class="input-table" 
																name="interfon" 
																placeholder="Interfon" 
																value="{{old('interfon')? old('interfon'):''}}">
													</div>		
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
@include('casas.create',['errors' => $errors])
@endsection
@section('scripts')
	@parent
	@include('removeOption',['elementos'=>$condominio->casas,'ruta'=>'eliminarCasa'])
@stop
