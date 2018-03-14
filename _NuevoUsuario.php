<?php
if((isset($_POST['nombre_nuevo']) && !empty($_POST['nombre_nuevo'])) && 
	(isset($_POST['contrasena_nuevo']) && !empty($_POST['contrasena_nuevo'])) && 
	isset($_POST['submit_nuevo'])){
	$ruta = "usuarios.txt";
	$nombreU = $_POST['nombre_nuevo'];
	$contrasenaU = $_POST['contrasena_nuevo'];
	$archivo = fopen($ruta, 'a+');
	$registro = $nombreU."@".$contrasenaU."#";
	fwrite($archivo, $registro);
	fclose($archivo);
	mkdir("/".$nombreU);
}
?>
<html>
	<head>
		<meta http-equiv="refresh" content="0; url=NuevoUsuario.php">
	</head>
</html>
