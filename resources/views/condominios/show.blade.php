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
						</h2>
						<table class="ui green compact celled table">
							<thead >
								<tr>
									<th colspan="3">
										<h3>Casas
											<a href="#!" class="nuevaCasa ui right floated small black icon button">
												<i class="large icons">
												    <i class="home icon"></i>
												    <i class="inverted corner add icon"></i>
												</i>
												Agregar Casa
											</a>
										</h3>
{{-- 										<div class="ui small button">
											Approve
										</div>
										<div class="ui small  disabled button">
											Approve All
										</div> --}}
									</th>
								</tr>
								<tr>
									<th>
										Casa	
									</th>
									<th>
										E-mail
									</th>
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
									<td class="cell-action">
										<h4 class="ui image header">
											<i class="ui mini phone icon"></i>
											<div class="content">
												Tel: {{$casa->telefono}}								
												<div class="sub header">
													Cel: {{$casa->celular}}								
												</div>
											</div>
										</h4>
										<div class="options">
											<div class="ui small basic icon buttons">
											    <a href="{{ route('editarCasa',['id'=>$casa->id]) }}" class="ui button basic green"><i class="edit icon"></i></a>
											    <form action="{{ route('eliminarCasa',['id'=>$casa->id]) }}" method="post">										    	
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
@include('casas.create',['errors' => $errors])
@endsection

@section('scripts')
	<script>
		@parent
		$(document).ready(function() {

		});
	</script>
@stop


