<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Reporte General</title>
		<style>
			@page{
				margin: 3cm 0.5cm;
				margin-bottom: 1cm;
			}
			#header{
				/*border-top: 15px solid #555;*/
				position: fixed;
				top: -2cm;
				left: 0;
				width: 100%;
				height: 130px;
				/*background: green;*/
			}
			#footer{
				/*border-top: 15px solid #555;*/
				position: fixed;
				bottom: -2cm;
				left: 0;
				width: 100%;
				height: 130px;
				text-align: center;
				/*background: green;*/
			}
			#header img{
				position: absolute;
				top: -10px;
				width: 100px;
			}

			#header img.logo-app{
				left: 20px;
			}
			#header img.logo-condominio{
				right: 20px;
			}
			
			body{
				font-family:  sans-serif;
				font-size: 12px;
			}
			#header p{
				position: absolute;
				top: 40px;
				font-size: 8px;
			}
			.table{
				width: 100%;
			    border-spacing: 0px;
				/*border:2px solid #000;*/
			    border-collapse: separate;
			    margin: 10px 0;
			}
			
			.table td, .table th{
				padding: 3px 15px;
				font-weight: 300;
				/*border: 1px solid #fff;*/
			}
			.table tbody{
				/*border: 2px solid #000;*/
			}
			
			.table thead th,.table tbody th{
	        	text-transform: uppercase;
				color: #fff;
				font-weight: 600;
				/*border-bottom: 1px solid #000;*/
			}
			.table thead th{
				font-size: 11px;
			}
			.table tbody th{
				font-size: 13px;
			}
			.table tbody th strong,.table tbody td strong{
				text-transform: uppercase;
			}
			.table thead tr:first-child th{
                font-size: 16px;
                font-weight: 700;
				text-align: center;
			} 
			.danger{
				color: rgb(192, 0, 0)!important;

			}
			/*.table tbody tr td:first-child{
				border-left: 1px solid #000;
			}*/
			
	        /*.vertical_Text {
	        	text-transform: uppercase;
                display: block;
                font-size: 14px;
                -webkit-transform: rotate(-90deg); 
                -moz-transform: rotate(-90deg);                 
            }*/
            #table-ingresos-ordinarios th{
				background: rgb(0, 176, 80);
			}
			#table-gastos-ordinarios th{
				background: rgb(255, 192, 0);
			}
			#table-ingresos-extraodinarios th{
				background: rgb(0, 32, 96);
			}		
			#table-gastos-extraordinarios th{
				background: rgb(192, 0, 0);
			}
			#table-final{
				padding: 15px;
				width: 60%;
			}
			#table-final th{
				background: rgb(255, 255, 102);
				color: #000;
			}
			h2,h3,h4,h5{
				padding: 1px;
				margin: 1px;
				text-transform: uppercase;
			}
	</style>
	</head>
	<body>
		<div id="header">
			<img src="{{ base_path('public/img/logo.png') }}" alt="" class="logo-app">
			<img src="{{ $condominio->imagen_url }}" alt="" class="logo-condominio">

			<p>ADMINISTRACION DE CONDOMINIOS</p>
			<h2 style="text-align: center;">CONDOMINIO RESIDENCIAL {{$condominio->nombre}}</h2>
			<h4 style="text-align: center;">REPORTE DE {{$fecha->format('F \\d\\e\\ Y')}}</h4>
			<h5 style="text-align: center;">{{isset($encabezado)?$encabezado:''}}</h5>
		</div>
		<div id="content">
			<table class="table" id="table-ingresos-ordinarios">
				<thead>
					<tr>
						<th colspan="5" ><span class="vertical_Text">Ingreso ordinarios</span></th>
					</tr>
					<tr>
						<th width="70%">DESCRIPCION DEL CONCEPTO</th>
						<th width="30%"></th>
						<th width="30%">Real Ejercido</th>
						<th width="30%">Real Presupuestado</th>
						<th width="30%">Diferencia</th>
					</tr>
				</thead>    	
				<tbody>
						<tr>
							<td>
								Pago de Cuotas vecinales del mes  
							</td>
							<td>
								{{$numeroCuotasMensuales = $pagosMensuales->count()}} 
							</td>
							<td>
								$ {{$sumaPagosNormales = round($pagosMensuales->sum('cantidad'),2)}}
							</td>
							<td>
								$ {{$sumaAdeudo = round((isset($adeudoMensual)?$adeudoMensual->cantidad:0) * $condominio->casas->count(),2)}}
							</td>
							<td class="{{$sumaPagosNormales - $sumaAdeudo < 0?'danger':''}}">
								$ {{$diferenciaNormal = isset($diferencia) && $diferencia !== 0 ? $diferencia : $sumaPagosNormales - $sumaAdeudo}}
							</td>
						</tr>
						<tr>
							<td>
								Pago de Cuotas vecinales atrasadas	
							</td>
							<td>
								{{$numeroCuotasAtrasados = $pagosAtrasados->count()}} 
							</td>
							<td>
								$ {{$sumaPagosAtrasados = round($pagosAtrasados->sum('cantidad'),2)}}
							</td>
							<td>
								$ {{$sumaAdeudoAtrasado = round(isset($presupuesto_atrazadas)?$presupuesto_atrazadas:0,2)}}
							</td>
							<td class="{{$sumaAdeudoAtrasado - $sumaPagosAtrasados < 0?'danger':''}}">
								$ {{ $diferenciaAtrasada = round($sumaAdeudoAtrasado - $sumaPagosAtrasados ,2)}}
							</td>
						</tr>
						<tr>
							<td>
								Pago de Cuotas vecinales adelantadas	
							</td>
							<td>
								{{$numeroCuotasAdelantados = $pagosAdelantados->count()}} 
							</td>
							<td>
								$ {{$sumaPagosAdelantado = round($pagosAdelantados->sum('cantidad'),2)}}
							</td>
							<td>
							</td>
							<td>
							</td>
						</tr>
						<tr>
							<td>
								<strong>TOTAL DE CUOTAS:	</strong>
							</td>
							<td>
								{{round($numeroCuotasMensuales + $numeroCuotasAtrasados + $numeroCuotasAdelantados,2)}}
							</td>
							<td>
								$ {{$sumaRealEjercido = round($sumaPagosAdelantado + $sumaPagosNormales+ $sumaPagosAtrasados,2)}}
							</td>
							<td>
							</td>
							<td class="{{$diferenciaNormal + $diferenciaAtrasada < 0?'danger':''}}">
								${{$totalIngresosOrdinarios = round($diferenciaNormal + $diferenciaAtrasada,2)}}
							</td>
						</tr>
						
						<tr>
							<td>
								<strong>TOTAL INGRESOS ORDINARIOS:	</strong>
							</td>
							<td>
							</td>
							<th>
								$ {{$sumaRealEjercido = round($sumaPagosAdelantado + $sumaPagosNormales+ $sumaPagosAtrasados,2)}}
							</th>
							<th>
								$ {{$sumaRealPresupuestado = round($sumaAdeudo + $sumaAdeudoAtrasado ,2)}}
							</th>
							<th class="{{$sumaRealEjercido - $sumaRealPresupuestado < 0?'danger':''}}">
								${{$totalIngresosOrdinarios = round($diferenciaNormal + $diferenciaAtrasada,2)}}
							</th>
						</tr>
				</tbody>
			</table>
			<table class="table" id="table-gastos-ordinarios">
				<thead>
					<tr>
						<th colspan="2" ><span class="vertical_Text">Gastos ordinarios</span></th>
					</tr>
					<tr>
						<th width="80%">DESCRIPCION DEL CONCEPTO</th>
						<th width="40%">Total</th>
					</tr>
				</thead>
				<tbody>
				@php
					$totalGastosOrdinarios = 0;
				@endphp
					@foreach ($gastosOrdinarios as $gastoOrdinario)
						<tr>
							<td>
								{{$gastoOrdinario->concepto()->first()->nombre}}
							</td>
							<td>
								$ {{$totalGastosOrdinarios += round($gastoOrdinario->cantidad,2)}}
							</td>
						</tr>
					@endforeach
					<td>
						<strong>TOTAL GASTOS ORDINARIOS:	</strong>
					</td>
					<th>
						$ {{$totalGastosOrdinarios}}
					</th>
				</tbody>
			</table>
			<table class="table" id="table-ingresos-extraodinarios">
				<thead>
					<tr>
						<th colspan="2" ><span class="vertical_Text">Ingresos extraordinarios</span></th>
					</tr>
					<tr>
						<th width="80%">DESCRIPCION DEL CONCEPTO</th>
						<th width="40%">Total</th>
					</tr>
				</thead>
				<tbody>
				@php
					$totalIngresosExtraudinarios = 0;
				@endphp
						<tr>
							<td>
								Otros Pagos
							</td>
							<td>
								$ {{$totalIngresosExtraudinarios += round($otrosPagos->sum('cantidad'),2)}}
							</td>
						</tr>
					<td>
						<strong>TOTAL INGRESOS EXTRAORDINARIOS:	</strong>
					</td>
					<th>
						$ {{$totalIngresosExtraudinarios}}
					</th>
				</tbody>
			</table>

			<table class="table" id="table-gastos-extraordinarios">
				<thead>
					<tr>
						<th colspan="2" ><span class="vertical_Text">gastos extraordinarios</span></th>
					</tr>
					<tr>
						<th width="80%">DESCRIPCION DEL CONCEPTO</th>
						<th width="40%">Total</th>
					</tr>
				</thead>
				<tbody>
				@php
					$totalGastosExtraudinarios = 0;
				@endphp
					@foreach ($gastosExtraordinarios as $gastoExtraordinario)
						<tr>
							<td>
								{{$gastoExtraordinario->concepto}}
							</td>
							<td>
								$ {{$totalGastosExtraudinarios += round($gastoExtraordinario->cantidad,2)}}
							</td>
						</tr>
					@endforeach
						
					<td>
						<strong>TOTAL GASTOS EXTRAORDINARIOS:	</strong>
					</td>
					<th>
						$ {{$totalGastosExtraudinarios}}
					</th>
				</tbody>
			</table>
			<table class="table" id=" table-final">
				<tbody>
					<tr>
						<td>
							<strong>TOTAL DE INGRESOS DE {{$fecha->format('F \\d\\e\\ Y')}}:	</strong>
						</td>
						<td>
							$ {{$totalIngresos = round($totalIngresosExtraudinarios + $sumaRealEjercido,2) }}
						</td>
					</tr>

					<tr>
						<td>
							<strong>TOTAL DE EGRESOS DE {{$fecha->format('F \\d\\e\\ Y')}}:	</strong>
						</td>
						<td>
							$ {{$totalGastos = round($totalGastosExtraudinarios + $totalGastosOrdinarios,2) }}
						</td>
					</tr>
					<tr>
						<th>Deficit: </th>
						<th class="{{($totalIngresos - $totalGastos) < 0?'danger':''}}"> $ {{round($totalIngresos-$totalGastos,2)}}</th>
					</tr>

				</tbody>
			</table>
		</div>
		<div id="footer">
			<p>{{isset($mensaje)?$mensaje:''}}</p>
		</div>
	</body>
</html>