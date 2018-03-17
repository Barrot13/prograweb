<?php
function VerificaUsuario($nombreUsuario){
	$ruta = "usuarios.txt";
	if(file_exists($ruta)){
		$datos = file_get_contents($ruta);
		$array = explode("#", $datos);
		foreach ($array as $key => $value) {
			$arrayDatos[$key] = explode("@", $value);
			if($arrayDatos[$key][0] == $nombreUsuario){
				return TRUE;
			}
		}
		return FALSE;
	}
	else{
		return FALSE;
	}
}

if((isset($_POST['nombre_nuevo']) && !empty($_POST['nombre_nuevo'])) && 
	(isset($_POST['contrasena_nuevo']) && !empty($_POST['contrasena_nuevo'])) && 
	isset($_POST['submit_nuevo'])){

	if(!VerificaUsuario($_POST['nombre_nuevo'])){
		$ruta = "usuarios.txt";
		$nombreU = $_POST['nombre_nuevo'];
		$contrasenaU = $_POST['contrasena_nuevo'];
		$archivo = fopen($ruta, 'a+');
		$registro = $nombreU."@".$contrasenaU."#";
		fwrite($archivo, $registro);
		fclose($archivo);
		mkdir($nombreU);
		$indice = fopen($nombreU."/indice.txt", 'a+');
		fclose($indice);
		$datos = fopen($nombreU."/datos.txt", 'a+');
		fclose($datos);
	}
}
?>
<html>
	<head>
		<meta http-equiv="refresh" content="0; url=login.php">
	</head>
</html>
