<?php
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
</head>
<body>
	<h1>Index</h1>
	<form action="_Principal.php" method="POST" enctype="multipart/form-data">
    <h2>Bienvenido: <?php echo $_SESSION["Usuario"]; ?></h2>
    <a href="_Principal.php?cerrar_sesion=cerrar">Cerrar Sesion</a>
    <br>
    <label for="filename"><b>Nombre del Archivo</b></label>
    <br>
    <input type="text" name="filename" size="20" maxlength="100">
    <input type="hidden" name="MAX_FILE_SIZE" value="100000">
    <br>
    <label for="author"><b>Autor</b></label>
    <br>
    <input type="text" name="author" size="20" maxlength="100">
    <br>
    <label for="date"><b>Fecha</b></label>
    <br>
    <input type="date" name="date">
    <br>
    <label for="size"><b>Tamaño</b></label>
    <br>
    <input type="text" name="size" maxlength="100">
    <br>
    <label for="type"><b>Clasificacion</b></label>
    <br>
    <input type="text" name="type" maxlength="100">
    <br>
    <label for="description"><b>Descripcion</b></label>
    <br>
    <textarea name="description" maxlength="350" rows="4" cols="30"></textarea> 
    <br>
    <label for="userfile"><b>Enviar un nuevo archivo: </b></label>
    <br>
    <input name="userfile" type="file">
    <br>
    <input type="submit" value="Enviar">
</form>
</body>
</html>
<?php
}
?>