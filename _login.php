<?php
function VerificaInicio($nombre, $contrasena){
	$ruta = "usuarios.txt";
	if(file_exists($ruta)){
		$datos = file_get_contents($ruta);
		$array = explode("#", $datos);
		foreach ($array as $key => $value) {
			$arrayDatos[$key] = explode("@", $value);
			if($arrayDatos[$key][0] == $nombre && $arrayDatos[$key][1] == $contrasena){
				return TRUE;
			}
		}
		return FALSE;
	}
	else{
		return FALSE;
	}
}

if((isset($_POST['nombre_login']) && !empty($_POST['nombre_login'])) && 
	(isset($_POST['contrasena_login']) && !empty($_POST['contrasena_login'])) && 
	isset($_POST['submit_login'])){

	if(VerificaInicio($_POST['nombre_login'], $_POST['contrasena_login'])){
		session_start();
		$_SESSION["Usuario"] = $_POST['nombre_login'];
		?>
		<html>
			<head>
				<meta http-equiv="refresh" content="0; url=index.php">
			</head>
		</html>
		<?php
	}
	else{
		?>
		<html>
			<head>
				<meta http-equiv="refresh" content="0; url=login.php">
			</head>
		</html>
		<?php
	}
}
else{
	?>
	<html>
		<head>
			<meta http-equiv="refresh" content="0; url=login.php">
		</head>
	</html>
	<?php
}
?>