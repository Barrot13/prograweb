<?php 
if(isset($_POST["filename"])){
	$filename = $_POST["filename"];
	$author = $_POST["author"];
	$date = $_POST["date"];
	$size = $_POST["size"];
	$type = $_POST["type"];
	$description = $_POST["description"];
}
if(isset($_POST["search"])){
	$search = $_POST["search"];
}

include '_metodos.php';
if(isset($_GET["cerrar_sesion"])){
	session_start();
	unset($_SESSION["Usuario"]);
	unset($_SESSION["meta_data"]);
	unset($_SESSION["accion"]);
	unset($_SESSION["Buscar"]);
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
		else{
			EditarArchivo($_POST["btn_guardar"]);
		}
	}
	elseif (isset($_POST["btn_editar"])) {
		PrepararEditar($_POST["btn_editar"]);
	}
	elseif (isset($_POST["btn_eliminar"])) {
		Eliminar($_POST["btn_eliminar"]);
	}
	elseif (isset($_POST["btn_buscar"])) {
		Buscar($search);
	}
	elseif (isset($_POST["btn_cancelar"])) {
		session_start();
		Cancelar();
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