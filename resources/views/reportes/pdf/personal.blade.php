<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Reporte Personal</title>
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
				left: 20px;
				width: 100px;
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
				padding: 3px 5px;
				font-weight: 300;
				/*border: 1px solid #fff;*/
			}
			.table tbody{
				/*border: 2px solid #000;*/
			}
			.text-right{
				text-align: right;
			}
			.text-left{
				text-align: left;
			}
			.text-center{
				text-align: center;
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
				background: rgb(255, 192, 0);
				font-size: 13px;
			}
			.table tbody th strong,.table tbody td strong{
				text-transform: uppercase;
			}
			.table, .table td,.table tbody th{
				white-space: nowrap;
				/*border: 0.5px solid #333;*/
			}
			.table thead tr:first-child th{
                font-size: 16px;
                font-weight: 700;
				text-align: center;
			} 
			.danger{
				color: rgb(192, 0, 0)!important;

			}
			.table > tbody > tr:nth-of-type(odd) {
			  	background-color: #e4e4e4;
			}
			.table thead tr{
				background: rgb(0, 176, 80);
			}
			.table thead tr:first-child{
				background: rgb(0, 32, 96)!important;
				/*border-left: 1px solid #000;*/
			}

	        /*.vertical_Text {
	        	text-transform: uppercase;
                display: block;
                font-size: 14px;
                -webkit-transform: rotate(-90deg); 
                -moz-transform: rotate(-90deg);                 
            }*/
/*            #table-ingresos-ordinarios th{
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
*/			#table-final{
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
			.table-pagos{
				width: 40%;
				margin: 0 auto;
			}			 
	</style>
	</head>
	<body>
		<div id="header">
			<img src="{{ base_path('public/img/logo.png') }}" alt="">
			<p>ADMINISTRACION DE CONDOMINIOS</p>
			<h2 style="text-align: center;">CONDOMINIO RESIDENCIAL {{$condominio->nombre}}</h2>
			<h4 style="text-align: center;">REPORTE DE INGRESOS  {{$fecha->format('F \\d\\e\\ Y')}}</h4>
			<h5 style="text-align: center;">{{isset($encabezado)?$encabezado:''}}</h5>
		</div>
		<div id="content">
			<table class="table" id="table-ingresos-ordinarios">
				<thead>
					<tr>
						<th colspan="3" ><span class="vertical_Text">Ingreso de {{$casa->nombre}} </span></th>
						<th colspan="3" ><span class="vertical_Text">Condomino: {{$casa->contacto}} </span></th>
					</tr>
					<tr>
						<th width="30%">CONCEPTO</th>
						<th width="40%">FECHA</th>
						<th width="30%">TOTAL ADEUDO</th>
						<th width="30%">MONTO PAGADO</th>
						<th width="30%">MONTO ADEUDADO</th>
						<th width="30%">PAGAR ANTES DE</th>
					</tr>
				</thead>    	
				<tbody>
						@php
							$sumaCantidad = 0;
							$sumaPagado = 0;
							$sumaAdeudo = 0;
						@endphp
						@foreach (\App\Adeudo::casaTodos($casa->id)->get() as $adeudo)
							<tr>
								<td>	
									{{$adeudo->concepto=='mensualidad'?'Mantenimiento':$adeudo->concepto}}
								</td>
								<td>	
									{{$adeudo->fecha->format('F \\d\\e\\ Y')}}
								</td>
								<td class="text-center">
									$ {{$cantidad = round($adeudo->cantidad ,2)}}
								</td>
								<td class="text-center">
									$ {{$pagado = round($adeudo->pagado ,2)}}
								</td>
								<td class="text-center">
									$ {{$adeudo = round($adeudo->adeudado ,2)}}
								</td>
								<td class="text-center">
									Inmediato
								</td>
								@php
									$sumaCantidad += $cantidad;
									$sumaPagado += $pagado;
									$sumaAdeudo += $adeudo;
								@endphp
							</tr>
						@endforeach
						<tr>
							<td class="text-right" colspan="2">
								SUBTOTALES:
							</td>
							<td class="text-center">
								<strong>$ {{round($sumaCantidad ,2)}}</strong>
							</td>
							<td class="text-center">
								<strong>$ {{round($sumaPagado ,2)}}</strong>
							</td>
							<td class="text-center">
								<strong>$ {{round($sumaAdeudo ,2)}}</strong>
							</td>
							<td>
								
							</td>
						</tr>
						<tr>
							<td class="text-center" colspan="4">
								<h2>MONTO DEL AVISO:</h2>
							</td>
							<th  colspan="4">
								<h2>$ {{$sumaAdeudo}}</h2>
							</th>
						</tr>
				</tbody>
			</table>
			@if (isset($cuentas_seleccionadas ))
				<table class="table table-pagos">
					<thead>
						<tr>
							<th colspan="2">
								ALTERNATIVAS DE PAGO
							</th>
						</tr>
					</thead>
					<tbody>
							@foreach ($cuentas_seleccionadas as $cuenta)
								<tr>
									<td><img src="{{ $cuenta->imagen_url }}" width="100px" alt="Imagen Cuenta"></td>
									<td>{{$cuenta->mensaje}}</td>
								</tr>
							@endforeach
					</tbody>
				</table>
			@endif
		</div>

		<div id="footer">
			<p>{{isset($mensaje)?$mensaje:''}}</p>
			<h3 style="color: green;text-transform: none;">smartdemexico@hotmail.com</h3>
		</div>
	</body>
</html>