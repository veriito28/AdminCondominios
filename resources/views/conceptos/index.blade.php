@extends('template')
@section('contenido')
<div class=" stretched column">
	<div class="html">
		<div class="ui  column centered grid">
			<div class="column">
				<div class="ui segments">
					<div class="ui green segment"> 
						<h2 class="ui center aligned icon header">
							 <i class="folder open icon"></i>
							Conceptos Generales
						</h2>
						<table class="ui green celled table">
							<thead >
								<tr>
									<th colspan="3">
										<h3>Todos los Conceptos
											<a href="#!" class="nuevoConcepto ui right floated small black icon button">
												<i class="large icons">
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
										Nombre
									</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($conceptos as $concepto)
								<tr>
									<td class="cell-action">
										{{$concepto->id}}
									</td>
									<td class="cell-action">
										{{$concepto->nombre}}							
										<div class="options">
											<div class="ui small basic icon buttons">
											    <a href="{{ route('editarConcepto',['id'=>$concepto->id]) }}" class="ui button basic green"><i class="edit icon"></i></a>
											    <form action="{{ route('eliminarConcepto',['id'=>$concepto->id]) }}" method="post">										    	
												    {{method_field('DELETE')}}	
												    {{csrf_field()}}	
												    <button type="submit" class="ui button basic red"><i class="trash icon"></i></button>
											    </form>
											</div>
										</div>

									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@include('conceptos.create',['errors' => $errors])
@endsection

