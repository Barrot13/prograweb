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
            <li><a>Bienvenido: <?php echo $_SESSION["Usuario"]; ?></a></li>
            <li><a class="active" href="index.php">Index</a></li>
        </ul>
    </nav>

    <div class="main">
        <div class="form-wrap">
            <form action="_index.php" method="POST" enctype="multipart/form-data">
                <br>
                <label for="filename"><b>Nombre del Archivo</b></label>
                <br>
                <input title="Ejemplo: El señor de los anillos" type="text" name="filename" value="<?php echo $_SESSION["meta_data"]["filename"]; ?>" size="20" maxlength="100">
                <input type="hidden" name="MAX_FILE_SIZE" value="100000">
                <br>
                <label for="author"><b>Autor</b></label>
                <br>
                <input title="Ejemplo: J.R.R Tolkien" type="text" name="author" value="<?php echo $_SESSION["meta_data"]["author"]; ?>" size="20" maxlength="100">
                <br>
                <label for="date"><b>Fecha</b></label>
                <br>
                <input type="date" name="date" value="<?php echo $_SESSION["meta_data"]["date"]; ?>">
                <br>
                <label for="size"><b>Número de Páginas</b></label>
                <br>
                <input title="Ejemplo: 800 " type="text" name="size" value="<?php echo $_SESSION["meta_data"]["size"]; ?>" maxlength="100">
                <br>
                <label for="type"><b>Clasificacion</b></label>
                <br>
                <input title="Ejemplo: Fantasia/Aventura" type="text" name="type" value="<?php echo $_SESSION["meta_data"]["type"]; ?>" maxlength="100">
                <br>
                <label for="description"><b>Descripcion</b></label>
                <br>
                <textarea title="Ejemplo: Breve descripcion del libro " name="description" value="<?php echo $_SESSION["meta_data"]["description"]; ?>" maxlength="350" rows="2" cols="30"></textarea> 
                <br>
                <label for="userfile"><b>Enviar un nuevo archivo: </b></label>
                <br>
                <input name="userfile" type="file" value="Agregar">
                <br>
                <button name="btn_guardar" type="submit" value="<?php echo $_SESSION["accion"]; ?>">Guardar</button>
            </form>
            <?php
            if (isset($_SESSION["Mensaje"])) {
                echo "<p>".$_SESSION["Mensaje"]."</p>";
                unset($_SESSION["Mensaje"]);
            }
            ?>
        </div>
        <div class="table-wrap">
            <form action="_index.php" method="POST">
                <?php DibujarTabla($_SESSION["Usuario"]); ?>
            </form>
        </div>
    </div>
</body>
</html>
<?php
}
?>
