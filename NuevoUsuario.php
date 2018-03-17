<!DOCTYPE html>
<html>
<head>
	<title>Proyecto PrograWeb</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

<body>
    <div class=login-wrap>
        <h2>Nuevo Usuario</h2>
        <form action="_NuevoUsuario.php" method="POST">
            <div class="container">
                <label for="nombre_nuevo"><b>Nombre</b></label>
                <input type="text" name="nombre_nuevo">
                <label for="contrasena_nuevo"><b>Contraseña</b></label>
                <input type="password" name="contrasena_nuevo">
                <input type="submit" name="submit_nuevo" value="Nuevo">
                <a href="login.php">Regresar</a>
            </div>
        </form>
    </div>
</body>
</html>