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
							<i class="circular building icon"></i>
							Ingresos Extraordinarios <span class="ui header green">"{{$condominio->nombre}}"</span> - {{$anio}}
						</h2>
						<table class="ui green celled table">
							<thead >
								<tr>
									<th colspan="3">
										<div class="ui form form-inline pull-left">
												<div class="fields inline">													
													<div class="ui floating labeled icon dropdown button">
														<i class="calendar  icon"></i>
														<span class="text">{{$anio}}</span>
														<div class="menu">
														
															@for ($i = 2012; $i <= \Carbon\Carbon::now()->year ; $i++)
																@if ($i != $anio)
																	<a href="{{  route('ingresosExtraordinarios',['anio'=> $i]) }}" class="item">
																		{{$i}}
																	</a>
																@endif
															@endfor
														</div>
													</div>
												</div>
											</div>	
											<a href="#!" class="nuevoIngresoExtra ui right floated small black icon button">
												<i class="large icons">
													<i class="dollar icon"></i>
													<i class="inverted corner add icon"></i>
												</i>
												Agregar Ingreso Extraordinario
											</a>
									</th>
								</tr>
								<tr>
									<th>
										Concepto	
									</th>
									<th>
										Cantidad
									</th>
									<th>
										Fecha
									</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($ingresosExtraordinarios as $ingresoExt)
								<tr>
									<td >
										{{$ingresoExt->concepto}}
									</td>
									<td >
										$ {{$ingresoExt->cantidad}}
									</td>
									<td class="cell-action">
										{{$ingresoExt->fecha->format('j \\d\\e F Y ')}}
										<div class="options">
											<div class="ui small basic icon buttons">
												<a href="{{ route('editarIngresoExtraordinario',['anio'=>$anio,'id'=>$ingresoExt->id]) }}" class="ui button basic green"><i class="edit icon"></i></a>
												<form action="{{ route('eliminarIngresoExtraordinario',['anio'=>$anio,'id'=>$ingresoExt->id]) }}" method="post">										    	
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
@include('ingresos.extraordinarios.create',compact('errors','anio','condominio'))
@endsection

