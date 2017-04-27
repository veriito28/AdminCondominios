@extends('template')
@section('contenido')
<div class=" stretched column">
	<div class="html">
		<div class="ui  column centered grid">
			<div class="column">
				<div class="ui segments">
					<div class="ui green segment">
						<h2 class="ui center aligned icon header">
							<i class="circular user icon"></i>
							Bienvenido
						</h2>
						<h2 class="ui horizontal divider header">Sistema Smart</h2>
						<div class="ui four cards grid">
								@foreach (Auth::user()->condominios as $condominio)
									<div class="ui column card">											
											@if ($condominio->pivot->seleccionado)
												<div class="ui black ribbon label">
													<i class="building icon"></i> Seleccionado
												</div>
											@else
												<div class="ui blue ribbon label">
												        <i class="building icon"></i> Condominio
											      </div>
											@endif
											<div class="content">
												<div class="header">
													{{$condominio->nombre}}
												</div>
												<div class="meta">
													Casas: {{$condominio->casas->count()}}
												</div>
											</div>
											@if (!$condominio->pivot->seleccionado)
												<a href="{{ route('seleccionarCondominio',['id_condominio'=>$condominio->id]) }}" class="ui bottom attached green button">
													Administrar
											      	<i class="arrow circle right icon"></i>
											    </a>
											@else
											    <a href="{{ route('mostrarCondominio',[ 'id' => $condominio->id]) }}" class="ui bottom attached green button">
													Configurar
											      	<i class="configure  right icon"></i>
											    </a>
											@endif

									</div>
								@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
	@parent
	$(document).ready(function() {

	});
</script>
@stop