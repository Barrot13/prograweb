<?php
function NombreArchivoValido($NombreArchivo, $Usuario){
	$ContenidoIndice = file_get_contents($Usuario."/indice.txt");
	if (strpos($ContenidoIndice, $NombreArchivo)===false) {
		return true;
	}
	else{
		return false;
	}
}
function SubirArchivo(){
	session_start();
	global $filename, $author, $date, $size, $type, $description;
	if(empty($filename)){
		$_SESSION["Mensaje"] = "Debe proporcionar el nombre del archivo";
		return;
	}
	if(!NombreArchivoValido($filename, $_SESSION["Usuario"])){
		$_SESSION["Mensaje"] = "Ya existe un archivo con el nombre: $filename. Debe proporcionar un nombre distinto.";
		return;
	}
	$nombre_archivo = $_FILES['userfile']['name'];
	if(!NombreArchivoValido($nombre_archivo, $_SESSION["Usuario"])){
		$_SESSION["Mensaje"] = "Ya existe un archivo con el nombre: $filename. Debe proporcionar un nombre distinto.";
		return;
	}
	$tipo_archivo = $_FILES['userfile']['type'];
	$tamano_archivo = $_FILES['userfile']['size'];
	$destino = $_SESSION["Usuario"]."/".$nombre_archivo;
	//compruebo si las características del archivo son las que deseo
	if (!($_FILES['userfile']['type'] == "application/epub+zip")  || $tamano_archivo > 100000) {
	    $_SESSION["Mensaje"] = "La extensión o el tamaño de los archivos no es correcta";
	}
	else{
	    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $destino)){
	    	$registro_datos = $filename."@".$author."@".$date."@".$size."@".$type."@".$description;
	    	$byte_inicio = filesize($_SESSION["Usuario"]."/datos.txt");
	    	$tamano_registro = strlen($registro_datos);
	    	$registro_indice = $filename."@".$destino."@".$byte_inicio."@".$tamano_registro."#";
	    	EscribirEnEspacio($registro_datos, $_SESSION["Usuario"], $destino, $registro_indice, $filename, $filename);
	    	//$_SESSION["Mensaje"] = "El archivo ha sido cargado correctamente.";
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
	if(empty($filename)){
		$_SESSION["Mensaje"] = "Debe proporcionar el nombre del archivo";
		return;
	}
	$Datos = explode("@", $DatosIndex);
	if($Datos[0] != $filename){
		if(!NombreArchivoValido($filename, $_SESSION["Usuario"])){
			$_SESSION["Mensaje"] = "Ya existe un archivo con el nombre: $filename. Debe proporcionar un nombre distinto.";
			return;
		}
	}
	//$Usuario = explode("/", $Datos[1]);
	$Usuario = $_SESSION["Usuario"];
	$archivoDatos = fopen($Usuario."/datos.txt", "r+");
	fseek($archivoDatos, $Datos[2], SEEK_SET);
	$CadenaEditar = fread($archivoDatos, $Datos[3]);
	fclose($archivoDatos);
	$CadenaNueva = $filename."@".$author."@".$date."@".$size."@".$type."@".$description;
	$ContenidoDatos = file_get_contents($Usuario."/datos.txt");
	$Blanco = " ";
	$NuevoContenido = str_replace($CadenaEditar, str_pad($Blanco, strlen($CadenaEditar)), $ContenidoDatos);
	file_put_contents($Usuario."/datos.txt", $NuevoContenido);
	EscribirEnEspacio($CadenaNueva, $Usuario, $Datos[1], $DatosIndex, $filename, $Datos[0]);
	$_SESSION["meta_data"] = array('filename' => "", 'author' => "", 'date' => "",
										'size' => "", 'type' => "", 'description' => "");
	$_SESSION["accion"] = "Nuevo";
}

function EscribirEnEspacio($CadenaD, $Usuario, $destino, $IndexViejo, $filename, $oldfilename){
	$ContenidoDatos = file_get_contents($Usuario."/datos.txt");
	$Blanco = " ";
	if (strpos($ContenidoDatos, str_pad($Blanco, strlen($CadenaD)))===false) {
		$_SESSION["Mensaje"] = "A";
		$datos = fopen($Usuario."/datos.txt", "a+");
	    $byte_inicio = filesize($Usuario."/datos.txt");
	    fwrite($datos, $CadenaD);
	    fclose($datos);
	    $ContenidoIndice = file_get_contents($Usuario."/indice.txt");
		$registro_indice = $filename."@".$destino."@".$byte_inicio."@".strlen($CadenaD);
		if (strpos($ContenidoIndice, $oldfilename)===false) {
			$_SESSION["Mensaje"] = "B";
			$indice = fopen($Usuario."/indice.txt", "a+");
	    	fwrite($indice, $registro_indice."#");
	    	fclose($indice);
		}
		else{
			$_SESSION["Mensaje"] = "C";
			$NuevoIndice = str_replace($IndexViejo, $registro_indice, $ContenidoIndice);
			file_put_contents($Usuario."/indice.txt", $NuevoIndice);			
		}
	    return false;
	}
	else{
		$Inicio = strpos($ContenidoDatos, str_pad($Blanco, strlen($CadenaD)));
		$NuevosDatos = str_replace_first(str_pad($Blanco,strlen($CadenaD)),$CadenaD,$ContenidoDatos);
		$_SESSION["Mensaje"] = $CadenaD;
		file_put_contents($Usuario."/datos.txt", $NuevosDatos);
		$ContenidoIndice = file_get_contents($Usuario."/indice.txt");
		$registro_indice = $filename."@".$destino."@".$Inicio."@".strlen($CadenaD);
		if (strpos($ContenidoIndice, $oldfilename)===false) {
			$_SESSION["Mensaje"] = "E";
			$indice = fopen($Usuario."/indice.txt", "a+");
	    	fwrite($indice, $registro_indice."#");
	    	fclose($indice);
		}
		else{
			echo "F";
			$NuevoIndice = str_replace($IndexViejo, $registro_indice, $ContenidoIndice);
			file_put_contents($Usuario."/indice.txt", $NuevoIndice);			
		}
		return true;
	}
}

function str_replace_first($from, $to, $content)
{
    $from = '/'.preg_quote($from, '/').'/';

    return preg_replace($from, $to, $content, 1);
}
?>