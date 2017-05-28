<?php
	session_start();
	$error_bd=isset($_SESSION['error_bd'])? $_SESSION['error_bd']: false;

	if($error_bd){?>
		<script type="text/javascript">alert("Error al conectar base de datos")</script>
	<?php ;
		$_SESSION['error_bd']=false;
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Principal Guaunder</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="img/icono.png">
	<link rel="stylesheet" type="text/css" href="css/cssPrincipal.css"/>
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
	<script src="js/jquery-3.2.0.min.js"></script>
	<script>
		$(document).ready(function(){
			$( "#header" ).load('loginHome.html');
		});
	</script>
</head>
<body>

	<div id="header"></div>

	<div class="center-block" id="principalBlock">

		<div class="usuario-vista">
			<div id="carousel-usuario" class="carousel slide" data-interval="false">
				<div class="carousel-inner" role="listbox">

					<div class="item active">
						<div class="usuario-foto">
							<img src="img/Rodolfo.jpg" class="img-responsive img-rounded centro" alt="Perro Rodolfo">
						</div>
						<div class="carousel-caption">
							<a href="perfil.php"><span class="nombre-edad">Rodolfo, 4 años</span></a>
							<span class="localizacion">
								<i class="fa fa-map-marker">
								Lavapiés
								</i>
							</span>
						</div>
					</div>
					<div class="item">
						<div class="usuario-foto">
							<img src="img/perro2.png" class="img-responsive img-rounded centro" alt="Perro Pierre">
						</div>
						<div class="carousel-caption">
							<a href="perfil.php"><span class="nombre-edad">Pierre, 10 años</span></a>
							<span class="localizacion">
								<i class="fa fa-map-marker">
								Serrano
								</i>
							</span>
						</div>
					</div>
					<div class="item">
						<div class="usuario-foto">
							<img src="img/perro3.jpg" class="img-responsive img-rounded centro" alt="Perro Django">
						</div>
						<div class="carousel-caption">
							<a href="perfil.php"><span class="nombre-edad">Django, 3 años</span></a>
							<span class="localizacion">
								<i class="fa fa-map-marker">
								Móstoles
								</i>
							</span>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div id="barra-boton-bottom">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<a title="No me gusta" class="btn btn-1" role="button" id="cross-btn">
					<span class="fa fa-remove"></span>
				</a>
				<a title="Me gusta" class="btn btn-1" role="button" id="heart-btn">
					<span class="fa fa-heart"></span>
				</a>
			</div>
		</div>
	</div>

	<div id="footer"></div>

	<script>
		$(document).ready(function(){
			$( "#footer" ).load('footer.html');
		});
	</script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/pagPrincipal.js"></script>

</body>
</html>