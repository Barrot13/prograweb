<?php 
//tomo el valor de un elemento de tipo texto del formulario

if(isset($_GET["cerrar_sesion"])){
	session_start();
	unset($_SESSION["Usuario"]);
	?>
    <html>
        <head>
            <meta http-equiv="refresh" content="0; url=login.php">
        </head>
    </html>
    <?php
}
else{

	session_start();
	$filename = $_POST["filename"];

	//datos del arhivo
	$nombre_archivo = $_FILES['userfile']['name'];
	$tipo_archivo = $_FILES['userfile']['type'];
	$tamano_archivo = $_FILES['userfile']['size'];
	$destino = $_SESSION["Usuario"]."/".$nombre_archivo;
	//compruebo si las características del archivo son las que deseo

	if (!($_FILES['userfile']['type'] == "application/epub+zip")  && $tamano_archivo < 100000) {
	    echo "La extensión o el tamaño de los archivos no es correcta: $tipo_archivo. <br><br><table><tr><td><li>Se permiten archivos .gif o .jpg<br><li>se permiten archivos de 100 Kb máximo: $tamano_archivo.</td></tr></table>";
	}else{
	    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $destino)){
	       echo "El archivo ha sido cargado correctamente.";
	    }else{
	       echo "Ocurrió algún error al subir el fichero. No pudo guardarse.";
	    }
	}
}
?>