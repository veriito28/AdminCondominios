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
							 <i class="circular folder open icon"></i>
								Cuentas 
						</h2>
						<table class="ui green celled table">
							<thead >
								<tr>
									<th colspan="3">
										<h3>Todas las Cuentas
											<a href="#!" class="nuevoCuenta ui right floated small black icon button">
												<i class="large icons">
												    <i class="home icon"></i>
												    <i class="inverted corner add icon"></i>
												</i>
												Agregar Cuenta
											</a>
										</h3>
									</th>
								</tr>
								<tr>
									<th>
										Imagen	
									</th>
									<th>
										Mensaje
									</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($cuentas as $cuenta)
								<tr>
									<td class="cell-action">
										<img src="{{$cuenta->imagen}}" alt="Imagen Cuenta" width="70px">
									</td>
									<td class="cell-action">
										{{$cuenta->mensaje}}							
										<div class="options">
											<div class="ui small basic icon buttons">
											    <a href="{{ route('editarCuenta',['id'=>$cuenta->id]) }}" class="ui button basic green"><i class="edit icon"></i></a>
											    <a id="removerElemento{{$cuenta->id}}"  class="ui button basic red"><i class="trash icon"></i></a>
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
@include('cuentas.create',['errors' => $errors])
@endsection
@section('scripts')
	@parent
	@include('removeOption',['elementos'=>$cuentas,'ruta'=>'eliminarCuenta'])
@endsection