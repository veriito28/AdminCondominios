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
						<form action="{{route('guardarCasas')}}" method="POST" novalidate>
						{{ csrf_field() }}
						<input type="hidden" name="condominio_id" value="{{$condominio->id}}">
						<table class="ui green compact celled table">
							<thead >
								<tr>
									<th colspan="5">
										<h3>
											Casas a importar
											<span>
												<button type="submit" class=" ui right floated black icon button ui positive  labeled">
													Guardar
													<i class="checkmark icon"></i>
												</button>					
											</span>
										</h3>
									</th>
								</tr>
								<tr>
									<th>Interfon</th>
									<th>
										Casa	
									</th>
									<th>
										E-mail
									</th>
									<th>Contacto</th>
									<th># Cliente</th>
								</tr>
							</thead>
							<tbody>
								@php
									$i = 0;
								@endphp
								@foreach ($casas as $casa)
									<tr >
										<td>
											{{$casa->interfon}}
											<input type="hidden" name="interfon[{{$i}}]" value="{{$casa->interfon}}">
										</td>
										<td class="cell-action">
											<h4 class="ui image header">
												<i class="ui mini home icon"></i>
												<div class="content">
													{{$casa->nombre}}
													<input type="hidden" name="nombre[{{$i}}]" value="{{$casa->nombre}}">
													<div class="sub header">
														<input type="hidden" name="contacto[{{$i}}]" value="{{$casa->contacto}}">
														{{$casa->contacto}}
													</div>
												</div>
											</h4>
										</td>
										<td>
											{{$casa->email}}
											<input type="hidden" name="email[{{$i}}]" value="{{$casa->email}}">
										</td>
										<td>
											<h4 class="ui image header">
												<i class="ui mini phone icon"></i>
												<div class="content">
													Tel: {{$casa->telefono}}								
													<input type="hidden" name="telefono[{{$i}}]" value="{{$casa->telefono}}">
													<div class="sub header">
													<input type="hidden" name="celular[{{$i}}]" value="{{$casa->celular}}">
														Cel: {{$casa->celular}}								
													</div>
												</div>
											</h4>
										</td>
										<input type="hidden" name="manzana[{{$i}}]" value="{{$casa->manzana}}">
										<input type="hidden" name="lote[{{$i}}]" value="{{$casa->lote}}">
										<input type="hidden" name="fecha_ent[{{$i}}]" value="{{$casa->fecha_ent}}">
										<td class="cell-action">
											<input type="hidden" name="no_cliente[{{$i}}]" value="{{$casa->no_cliente}}">
											{{$casa->no_cliente}}		
											<div class="options">
												<div class="ui small basic icon buttons">
												    <a href="#" data-id="{{$i}}" class="removerElementoExcel ui button basic red"><i class="trash icon"></i></a>
												</div>
											</div>								
										</td>
									</tr>
									@php
										$i++;
									@endphp
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
	@parent
	<script>
		$(document).ready(function() {
			$('.removerElementoExcel').click(function(e) {
				e.preventDefault();
				$(this).parents('tr').remove();
			});
		});
	</script>
@stop
