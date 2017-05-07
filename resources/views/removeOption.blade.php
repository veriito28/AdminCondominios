@foreach ($elementos as $elemento)
	@include('remove',compact('elemento','ruta'))
	<script>	
		$(document).ready(function() {
			$('#removerElemento{{$elemento->id}}').click(function(arg) {
				$('#modalEliminarElemento{{$elemento->id}}').modal('show');			
			});
		});
	</script>
@endforeach
@if ($errors->eliminarElemento->has('password'))
<script>
	$(document).ready(function() {
		$('#modalEliminarElemento{{old('id')}}').modal('show');			
	});
</script>
@endif