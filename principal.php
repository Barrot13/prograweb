<!DOCTYPE html>
<html>
<head>
	<title>Proyecto PrograWeb</title>
</head>
<body>
	<h1>Index</h1>
	<form action="_principal.php" method="POST" enctype="multipart/form-data">
    <b>Campo de tipo texto:</b>
    <br>
    <input type="text" name="cadenatexto" size="20" maxlength="100">
    <input type="hidden" name="MAX_FILE_SIZE" value="100000">
    <br>
    <br>
    <b>Enviar un nuevo archivo: </b>
    <br>
    <input name="userfile" type="file">
    <br>
    <input type="submit" value="Enviar">
</form>
</body>
</html>