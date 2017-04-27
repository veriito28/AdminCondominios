@extends('template')
@section('contenido')
<div class="html">
	<div class="ui top attached  menu">
		<h3 class="item active">
			Todos mis Condominios
		</h3>
		<div class="right menu">
			<a class="nuevoCondominio item active green ui button">
				<i class="add icon"></i> Nuevo Condominio
			</a>
		</div>
	</div>
	<div class="ui bottom attached segment">
		<table class="ui striped green table">
			<thead>
				<tr>
					<th>#ID</th>
					<th>Nombre</th>
					<th>Opciones</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($condominios as $condominio)
				<tr>
					<td>{{$condominio->id}}</td>
					<td>{{$condominio->nombre}}</td>
					<td class="right aligned">
						<a class="removerCondominio" data-id="{{$condominio->id}}" data-name="{{$condominio->nombre}}"><i class="icon remove"></i></a>
						<a href="{{ route('editarCondominio',['id'=>$condominio->id]) }}"><i class="icon edit"></i></a>
					</td>
				</tr>			
				@endforeach
			</tbody>
		</table>  
	</div>
</div>
@include('condominios.create',['errors' => $errors])
@include('condominios.remove')
@endsection
@section('scripts')
 	@parent
<script>
	$(document).ready(function() {
		$('#nuevoCondominio').click(function(arg) {
			$('#modalNuevoCondominio').modal('show');			
		});
		$('.removerCondominio').click(function(arg) {
			$('#modalEliminarCondominio').modal('show');			
			$("input[name=id]").val($(this).data('id'));
			console.log("$(this).data('name')", $(this).data('name'));
			$("#nombreCondominio").text($(this).data('name'));
		});
		@if ($errors->has('nombre'))
			$('#modalNuevoCondominio').modal('show');			
		@endif
		@if ($errors->has('passoword'))
			$('#modalEliminarCondominio').modal('show');			
		@endif
	});
</script>
@stop