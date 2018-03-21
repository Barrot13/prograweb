<?php
function SubirArchivo(){
	session_start();
	global $filename, $author, $date, $size, $type, $description;
	if(empty($filename)){
		$_SESSION["Mensaje"] = "Debe proporcionar almenos el nombre del archivo";
		return;
	}
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
	    	$registro_datos = $filename."@".$author."@".$date."@".$size."@".$type."@".$description;
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
			echo '<tr><td><a href="'.$value[1].'" target="_blank">'.$value[0].'</a></td>'.
			'<td><button name="btn_editar" value="'.$value[0]."@".$value[1]."@".$value[2]."@".$value[3].'">Editar</button></td>'.
			'<td><button name="btn_eliminar" value="'.$value[0]."@".$value[2]."@".$value[3].'">Eliminar</button></td></tr>';
		}
		echo "</table>";
	}
	else{
		echo "<p>El usuario no posee archivos...</p>";
	}
}

function PrepararEditar($DatosIndex){
	session_start();
	$_SESSION["accion"] = $DatosIndex;
	$Datos = explode("@", $DatosIndex);
	$Usuario = explode("/", $Datos[1]);
	$archivoDatos = fopen($Usuario[0]."/datos.txt", "r+");
	fseek($archivoDatos, $Datos[2], SEEK_SET);
	$CadenaEditar = fread($archivoDatos, $Datos[3]);
	fclose($archivoDatos);
	$array = explode("@", $CadenaEditar);
	$_SESSION["meta_data"] = array('filename' => $array[0], 'author' => $array[1], 'date' => $array[2], 'size' => $array[3], 'type' => $array[4], 'description' => $array[5]);
}

function EditarArchivo($DatosIndex){
	session_start();
	global $filename, $author, $date, $size, $type, $description;
	$Datos = explode("@", $DatosIndex);
	$Usuario = explode("/", $Datos[1]);
	$archivoDatos = fopen($Usuario[0]."/datos.txt", "r+");
	fseek($archivoDatos, $Datos[2], SEEK_SET);
	$CadenaEditar = fread($archivoDatos, $Datos[3]);
	fclose($archivoDatos);
	$CadenaNueva = $filename."@".$author."@".$date."@".$size."@".$type."@".$description;
	$NuevaLong = strlen($CadenaNueva);
	$ContenidoDatos = file_get_contents($Usuario[0]."/datos.txt");
	$NuevoContenido = str_replace($CadenaEditar, $CadenaNueva, $ContenidoDatos);
	file_put_contents($Usuario[0]."/datos.txt", $NuevoContenido);
	$NuevoIndex = $filename."@".$Datos[1]."@".$Datos[2]."@".$NuevaLong;
	$ContenidoIndice = file_get_contents($Usuario[0]."/indice.txt");
	$NuevoIndice = str_replace($DatosIndex, $NuevoIndex, $ContenidoIndice);
	file_put_contents($Usuario[0]."/indice.txt", $NuevoIndice);
	$_SESSION["meta_data"] = array('filename' => "", 'author' => "", 'date' => "",
										'size' => "", 'type' => "", 'description' => "");
	$_SESSION["accion"] = "Nuevo";
}
?>