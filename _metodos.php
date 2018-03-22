<?php
function VerificaArchivo($Usuario, $NombreArchivo){
	$ruta = $Usuario."/indice.txt";
	if(file_exists($ruta)){
		$datos = file_get_contents($ruta);
		$array = explode("#", $datos);
		foreach ($array as $key => $value) {
			$arrayIndice[$key] = explode("@", $value);
			if(count($arrayIndice[$key]) > 1){
				if($arrayIndice[$key][1] == $NombreArchivo){
					return False;
				}
			}
		}
		return True;
	}
	else{
		return True;
	}
}

function VerificaNombreArchivo($Usuario, $NombreArchivo){
	$ruta = $Usuario."/indice.txt";
	if(file_exists($ruta)){
		$datos = file_get_contents($ruta);
		$array = explode("#", $datos);
		foreach ($array as $key => $value) {
			$arrayIndice[$key] = explode("@", $value);
			if(count($arrayIndice[$key]) > 1){
				if($arrayIndice[$key][0] == $NombreArchivo){
					return False;
				}
			}
		}
		return True;
	}
	else{
		return True;
	}
}
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
	if(!VerificaNombreArchivo($_SESSION["Usuario"], $filename)){
		$_SESSION["Mensaje"] = "Ya existe un archivo con el nombre: $filename. Debe proporcionar un nombre distinto.";
		return;
	}
	$nombre_archivo = $_FILES['userfile']['name'];
	$destino = $_SESSION["Usuario"]."/".$nombre_archivo;
	if(!VerificaArchivo($_SESSION["Usuario"], $destino)){
		$_SESSION["Mensaje"] = "Ya existe un archivo con el nombre: $destino. Debe proporcionar un nombre distinto.";
		return;
	}
	$tipo_archivo = $_FILES['userfile']['type'];
	$tamano_archivo = $_FILES['userfile']['size'];
	
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
			if(isset($_SESSION["Buscar"])){
				if (!BuscarDatos($value, $_SESSION["Buscar"])) {
				 	continue;
				}
			}
			$arrayDatos[$key] = explode("@", $value);
		}
	}
	if(isset($_SESSION["Buscar"])){
		unset($_SESSION["Buscar"]);
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
			'<td><button name="btn_eliminar" value="'.$value[0]."@".$value[1]."@".$value[2]."@".$value[3].'">Eliminar</button></td></tr>';
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
		if(!VerificaNombreArchivo($_SESSION["Usuario"], $filename)){
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
	Cancelar();
	$_SESSION["Mensaje"] = "El archivo: $filename ha sido modificado con exito.";
}

function EscribirEnEspacio($CadenaD, $Usuario, $destino, $IndexViejo, $filename, $oldfilename){
	$ContenidoDatos = file_get_contents($Usuario."/datos.txt");
	$Blanco = " ";
	if (strpos($ContenidoDatos, str_pad($Blanco, strlen($CadenaD)))===false) {
		$datos = fopen($Usuario."/datos.txt", "a+");
	    $byte_inicio = filesize($Usuario."/datos.txt");
	    fwrite($datos, $CadenaD);
	    fclose($datos);
	    $ContenidoIndice = file_get_contents($Usuario."/indice.txt");
		$registro_indice = $filename."@".$destino."@".$byte_inicio."@".strlen($CadenaD);
		if (strpos($ContenidoIndice, $oldfilename)===false) {
			$indice = fopen($Usuario."/indice.txt", "a+");
	    	fwrite($indice, $registro_indice."#");
	    	fclose($indice);
		}
		else{
			$NuevoIndice = str_replace($IndexViejo, $registro_indice, $ContenidoIndice);
			file_put_contents($Usuario."/indice.txt", $NuevoIndice);			
		}
	    return false;
	}
	else{
		$Inicio = strpos($ContenidoDatos, str_pad($Blanco, strlen($CadenaD)));
		$NuevosDatos = str_replace_first(str_pad($Blanco,strlen($CadenaD)),$CadenaD,$ContenidoDatos);
		file_put_contents($Usuario."/datos.txt", $NuevosDatos);
		$ContenidoIndice = file_get_contents($Usuario."/indice.txt");
		$registro_indice = $filename."@".$destino."@".$Inicio."@".strlen($CadenaD);
		if (strpos($ContenidoIndice, $oldfilename)===false) {
			$indice = fopen($Usuario."/indice.txt", "a+");
	    	fwrite($indice, $registro_indice."#");
	    	fclose($indice);
		}
		else{
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

function Eliminar($DatosIndex){
	session_start();
	$Usuario = $_SESSION["Usuario"];
	$Datos = explode("@", $DatosIndex);
	$archivoDatos = fopen($Usuario."/datos.txt", "r+");
	fseek($archivoDatos, $Datos[2], SEEK_SET);
	$CadenaEditar = fread($archivoDatos, $Datos[3]);
	fclose($archivoDatos);
	$ContenidoDatos = file_get_contents($Usuario."/datos.txt");
	$Blanco = " ";
	$NuevoContenido = str_replace($CadenaEditar, str_pad($Blanco, strlen($CadenaEditar)), $ContenidoDatos);
	file_put_contents($Usuario."/datos.txt", $NuevoContenido);
	$ContenidoIndice = file_get_contents($Usuario."/indice.txt");
	$NuevoContenidoIndice = str_replace($DatosIndex."#", '', $ContenidoIndice);
	file_put_contents($Usuario."/indice.txt", $NuevoContenidoIndice);
	unlink($Datos[1]);
	$_SESSION["Mensaje"] = "El archivo: ".explode("/", $Datos[1])[1]." ha sido eliminado.";
	Cancelar();
}

function Buscar($Cadena){
	session_start();
	if(!empty(trim($Cadena))){
		$_SESSION["Buscar"] = trim($Cadena);
	}
}

function BuscarDatos($EntradaIndice, $Cadena){
	$Datos = explode("@", $EntradaIndice);
	$archivoDatos = fopen($_SESSION["Usuario"]."/datos.txt", "r+");
	fseek($archivoDatos, $Datos[2], SEEK_SET);
	$CadenaEditar = fread($archivoDatos, $Datos[3]);
	fclose($archivoDatos);
	$haystack = explode("@", $CadenaEditar);
	foreach ($haystack as $key => $value) {
		if (strpos($value, $Cadena) !== false) {
			return true;
		}
	}
	return false;
}
function Cancelar(){
	$_SESSION["meta_data"] = array('filename' => "", 'author' => "", 'date' => "",
										'size' => "", 'type' => "", 'description' => "");
	$_SESSION["accion"] = "Nuevo";
}
?>