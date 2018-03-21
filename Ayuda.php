<?php
include '_metodos.php';
session_start();
if(!isset($_SESSION["Usuario"])){
    ?>
    <html>
        <head>
            <meta http-equiv="refresh" content="0; url=login.php">
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
    <nav>
        <ul>
            <li style="float: right; "><a href="_index.php?cerrar_sesion=cerrar">Cerrar Sesion</a></li>
            <li style="float: right; "><a class="active" href="Ayuda.php">Ayuda</a></li>
            <li><a>Bienvenido: <?php echo $_SESSION["Usuario"]; ?></a></li>
            <li><a href="index.php">Index</a></li>
        </ul>
    </nav>

    <div class="container-fluid">
    	<h1>Sistema de Administración de Libros Electrónicos</h1>
    	<br>
    	<p>Esta apliación le permite al usuario gestionar sus libros electróncios, de tal manera que el usuario es capaz de subir, descargar estos libros. Al mismo tiempo el sistema es capaz de manejar datos del archivo tales como: Nombre, Autor, Número de Páginas, etc. Estos datos serán proporcionados por el usuario al momento de subir sus Libros Electrónicos</p>
    	<p>Además el usuario es capaz de editar, borrar los datos proporcionados al momento de subir el Libro</p>
    	<br>
    	<h2>Subir un Libro Electrónico</h2>
    	<p>Para que el usuario pueda subir un libro al sistema</p>
    	
    </div>
</body>
</html>
<?php
}
?>
