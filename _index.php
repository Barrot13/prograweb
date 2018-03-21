<?php 
//tomo el valor de un elemento de tipo texto del formulario
include '_metodos.php';
if(isset($_GET["cerrar_sesion"])){
	session_start();
	unset($_SESSION["Usuario"]);
	unset($_SESSION["meta_data"]);
	unset($_SESSION["accion"]);
	?>
    <html>
        <head>
            <meta http-equiv="refresh" content="0; url=login.php">
        </head>
    </html>
    <?php
}
else{
	if (isset($_POST["btn_guardar"])) {
		if ($_POST["btn_guardar"]=="Nuevo") {
			SubirArchivo();
		}
	}
	elseif (isset($_GET["descargar"])) {
		# code...
	}
	elseif (isset($_POST["btn_editar"])) {
		# code...
	}
	elseif (isset($_POST["btn_eliminar"])) {
		# code...
	}
	?>
    <html>
        <head>
            <meta http-equiv="refresh" content="0; url=index.php">
        </head>
    </html>
    <?php
}
?>