<!DOCTYPE html>
<html>
<head>
	<title>Proyecto PrograWeb</title>
</head>
<body>
	<h1>Ingresar al Sistema</h1>
	<form action="_login.php" method="POST">
		<fieldset>
			<input type="text" name="nombre_login">
			<input type="text" name="contrasena_login">
            <input type="submit" name="submit_login" value="Login">
            <a href="NuevoUsuario.php">Registrarse</a>
		</fieldset>
	</form>
</body>
</html>