<?php
session_start();
if(isset($_SESSION["Usuario"])){
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
<!DOCTYPE html>
<html>
<head>
    <title>Proyecto PrograWeb</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    <div class=login-wrap>
        <h2>Login</h2>
        <form action="_login.php" method="POST">
            <div class="container">
                <label for="nombre_login"><b>Nombre</b></label>
                <input type="text" name="nombre_login">
                <label for="contrasena_login"><b>Contraseña</b></label>
                <input type="password" name="contrasena_login">
                <input type="submit" name="submit_login" value="Login">
                <a href="NuevoUsuario.php">Registrarse</a>
            </div>
        </form>
    </div>
</body>
</html>
<?php
}
?>