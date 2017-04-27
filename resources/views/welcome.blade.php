<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Smart Condominios</title>

	<!-- Fonts -->

	<!-- Styles -->
	<link rel="stylesheet" href="{{ asset('semantic/semantic.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/css.css') }}"/>
</head>
<body>
	<div class="ui attached inverted stackable menu">
		<div class="ui container">
			<a class="item">
				<img src="img/logo.png" class="ui" width="50px" alt="">&nbsp; Condominios
			</a>
			{{-- <a class="item">
				<i class="grid layout icon"></i> Browse
			</a>
			<a class="item">
				<i class="mail icon"></i> Messages
			</a> --}}
			<div class="ui simple dropdown item">
				<i class="icons">
					<i class="building outline icon"></i>
					<i class="inverted corner building icon"></i>
				</i>
				Mis Condominios
				<i class="dropdown icon"></i>
				<div class="menu">
					<a class="item">
						<i class="building outline icon"></i>
						Condominios
					</a>
				</div>
			</div>
			<div class="menu right">
				<a class="item">
					<i class="privacy   icon"></i>
					Cambiar Contraseña
				</a>
				<a class="item">
					<i class="reply  icon"></i>
					Cerrar Sesíon
				</a>

			</div>
			
			{{-- <div class="right item">
				<div class="ui input"><input type="text" placeholder="Search..."></div>
			</div> --}}
		</div>
	</div>
	<div class="ui attached segment">
		<div class="ui grid">
			<div class="three wide column">
				<div class="ui vertical menu">
					<p class="item active teal">
						<i class="icons icon">
							<i class="  dollar icon"></i>
							<i class="corner reply icon"></i>
						</i>
						Ingresos
					</p>
					<a class="item">
						Pagos
					</a>
					<a class="item">
						Otros Pagos
					</a>
					<a class="item">
						Ingresos Ext.
					</a>
					<p class="item active teal">
						<i class="icons icon">
							<i class="  dollar icon"></i>
							<i class="corner share icon"></i>
						</i>
						Gastos
					</p>
					<a class="item">
						Ordinarios
					</a>
					<a class="item">
						Extraudinarios
					</a>
					<p class="item active teal">
						<i class="icons icon">
							<i class="  dollar icon"></i>
							 <i class="corner alarm outline icon"></i>
						</i>
						Adeudos
					</p>
					<a class="item">
						Mensualidades
					</a>
					<a class="item">
						Otros
					</a>

					<p class="item active teal">
						<i class="file pdf outline icon"></i>Reportes
					</p>
					<a class="item">
						General
					</a>
					<a class="item">
						Ingresos
					</a>

				</div>
			</div>
			<div class="thirteen wide stretched column">
				<table class="ui striped green table">
					<thead>
						<tr>
							<th>Name</th>
							<th>Date Joined</th>
							<th>E-mail</th>
							<th>Called</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>John Lilki</td>
							<td>September 14, 2013</td>
							<td>jhlilk22@yahoo.com</td>
							<td>No</td>
						</tr>
						<tr>
							<td>Jamie Harington</td>
							<td>January 11, 2014</td>
							<td>jamieharingonton@yahoo.com</td>
							<td>Yes</td>
						</tr>
						<tr>
							<td>Jill Lewis</td>
							<td>May 11, 2014</td>
							<td>jilsewris22@yahoo.com</td>
							<td>Yes</td>
						</tr>
						<tr>
							<td>John Lilki</td>
							<td>September 14, 2013</td>
							<td>jhlilk22@yahoo.com</td>
							<td>No</td>
						</tr>
						<tr>
							<td>John Lilki</td>
							<td>September 14, 2013</td>
							<td>jhlilk22@yahoo.com</td>
							<td>No</td>
						</tr>
						<tr>
							<td>Jamie Harington</td>
							<td>January 11, 2014</td>
							<td>jamieharingonton@yahoo.com</td>
							<td>Yes</td>
						</tr>
						<tr>
							<td>Jill Lewis</td>
							<td>May 11, 2014</td>
							<td>jilsewris22@yahoo.com</td>
							<td>Yes</td>
						</tr>
						<tr>
							<td>John Lilki</td>
							<td>September 14, 2013</td>
							<td>jhlilk22@yahoo.com</td>
							<td>No</td>
						</tr>
					</tbody>
				</table>

			</div>
		</div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="{{ asset('semantic/semantic.min.js') }}"></script>
	<script>
		$(document).ready(function() {
			$('.ui.dropdown').dropdown();	
		});
	</script>
</body>
</html>
