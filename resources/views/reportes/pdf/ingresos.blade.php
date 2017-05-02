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
						<th colspan="5" ><span class="vertical_Text">Ingreso ordinarios</span></th>
					</tr>
					<tr>
						<th width="30%">CASA</th>
						<th width="40%">CONDOMINIO</th>
						<th width="40%">ADEUDO A {{$fecha->format('F - Y')}}</th>
						<th width="30%">PAGO DEL MES</th>
						<th width="30%">TOTAL DE ADEUDO</th>
					</tr>
				</thead>    	
				<tbody>
						@foreach ($condominio->casas as $casa)
							<tr>
								<td>	
									{{$casa->nombre}}
								</td>
								<td>	
									{{$casa->contacto}}
								</td>
								<td class="{{0 < 0?'danger':''}}">
									{{$casa->pagos()->mensuales()->hasta($fecha)->get()->sum('cantidad')}}	
								</td>
								<td class="{{0 < 0?'danger':''}}">
									{{$casa->pagos()->mensuales()->fecha($fecha)->get()->sum('cantidad')}}	
								</td>
							</tr>
						@endforeach
				</tbody>
			</table>
				</div>
		<div id="footer">
			<p>{{isset($mensaje)?$mensaje:''}}</p>
		</div>
	</body>
</html>