<?php
function SubirArchivo(){
	session_start();
	$filename = $_POST["filename"];
	$author = $_POST["author"];
	$date = $_POST["date"];
	$size = $_POST["size"];
	$type = $_POST["type"];
	$description = $_POST["description"];

	//datos del arhivo
	$nombre_archivo = $_FILES['userfile']['name'];
	$tipo_archivo = $_FILES['userfile']['type'];
	$tamano_archivo = $_FILES['userfile']['size'];
	$destino = $_SESSION["Usuario"]."/".$nombre_archivo;
	//compruebo si las características del archivo son las que deseo

	if (!($_FILES['userfile']['type'] == "application/epub+zip")  || $tamano_archivo > 100000) {
	    $_SESSION["Mensaje"] = "La extensión o el tamaño de los archivos no es correcta";
	}
	else{
	    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $destino)){
	    	$datos = fopen($_SESSION["Usuario"]."/datos.txt", "a+");
	    	$registro_datos = $filename."@".$author."@".$date."@".$size."@".$type."@".$description."#";
	    	$byte_inicio = filesize($_SESSION["Usuario"]."/datos.txt");
	    	$tamano_registro = strlen($registro_datos);
	    	fwrite($datos, $registro_datos);
	    	fclose($datos);
	    	$indice = fopen($_SESSION["Usuario"]."/indice.txt", "a+");
	    	$registro_indice = $filename."@".$destino."@".$byte_inicio."@".$tamano_registro."#";
	    	fwrite($indice, $registro_indice);

	    	$_SESSION["Mensaje"] = "El archivo ha sido cargado correctamente.";
	    }
	    else{
	    	$_SESSION["Mensaje"] = "Ocurrió algún error al subir el fichero. No pudo guardarse.";
	    }
	}
} 

function get_Indices($Usuario){
	$ruta = $Usuario."/indice.txt";
	$datos = file_get_contents($ruta);
	$array = explode("#", $datos);
	foreach ($array as $key => $value) {
		if (!empty(trim($value))) {
			$arrayDatos[$key] = explode("@", $value);
		}
	}
	return (isset($arrayDatos)) ? $arrayDatos : false;
}

function DibujarTabla($Usuario){
	$Datos_Tabla = get_Indices($Usuario);
	if($Datos_Tabla){
		echo "<table><tr><th>Titulo del Archivo</th><th></th><th></th></tr>";
		foreach ($Datos_Tabla as $key => $value) {
			echo '<tr><td><a href="_index.php?descargar='.$value[1].'">'.$value[0].'</a></td>'.
			'<td><button name="btn_editar" type="submit" value="'.$value[0]."@".$value[2]."@".$value[3].'">Editar</button></td>'.
			'<td><button name="btn_eliminar" type="submit" value="'.$value[0]."@".$value[2]."@".$value[3].'">Eliminar</button></td></tr>';
		}
		echo "</table>";
	}
	else{
		echo "<p>El usuario no posee archivos...</p>";
	}
}
?>