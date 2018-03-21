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

    	<div>
    		<h2>Subir un Libro Electrónico</h2>
    		
    		<p style="float: right;"> <img style="float: right;" src="images/formcompleted.png">
    			<b>1. Complete el Formulario</b><br><br>
    			El sistema posee este fomrulario, el cual el usuario debera llenar con la siguiente información: <br><br>
    			Nombre del libro<br><br>
    			Nombre del autor del libro<br><br>
    			Fecha de Lanzamiento<br><br>
    			Número de Páginas que posee el libro<br><br>
    			La clasificación o Género al que pertenece el escrito<br><br>
    			Por último una breve descrpción del libro<br><br>
    			<b>2. Ajunte el Archivo</b><br><br>
    			Una vez completado el formulario, el usuario debera ajuntar el archivo que desea subir, para esto debera hacer click en el boton "browse" el cual le permitira buscar el libro desde su computadora<br><br>
    			<b>3. Guarde la información</b><br><br>
    			Al haber realizado los anteriores pasos, ya puede completar la subida del archivo. Dele click  al boton "guardar", si todo salió bien, el nombre del archivo debera aparecer en la lista de archivos que se despliega del lado derecho de su pantalla.<br><br>
    			<b>NOTA</b><br><br>
    			Lo invitamos a seguir el ejemplo proporcionado en esta página.
    		</p>
    	</div>

    	<div>
    	<br>
    	<br>
    	<br>
    	<br>
    		<h2>Manejo de los Archivos</h2>
    		<p><img style="float: left; padding-right: 30px;" src="images/table.png">
    			<b>1. Descargar el Libro</b><br><br>
    			Para poder descargar el libro, haga click sobre el nombre del archivo. De esta manera el archivo se guardara en su computadora.<br><br>
    			<b>2. Editar lo datos del Libro</b><br><br>
    			Al darle click al boton de editar, los datos que se escribieron, al momento de subir el archivo, apareceran de nuevo en el formulario. De esta manera el usuario podra modificar los datos que en ese momento proporcionó.<br><br>
    			<b>3. Eliminar el Libro</b><br><br>
    			Para poder eliminar el lirbo, dele click al boton eliminar del respectivo libro en la lista, una vez hecho esto el libro debera desaparecer de la lista de sus Libros Electrónicos. 

    		</p>
    	</div>
    	
    	
    </div>
</body>
</html>
<?php
}
?>
