<?php
spl_autoload_register(function($nombre_clase) {
    include $nombre_clase . '.php';
});

$error = "";

if (isset($_POST['submit'])) {
    $host = $_POST['host'];
    $user = $_POST['usuario'];
    $pass = $_POST['pass'];
    $conexion = new BD($host, $user, $pass);
    $error = $conexion->getInfo();
    if ($error == "") {
        $consulta = "SHOW DATABASES";
        $databases = $conexion->consulta($consulta);
        while (($NomDatabase = $databases->fetchColumn(0)) !== false) {
            $radios = "<input type='radio' name='radio' value=$NomDatabase";
        }
    }
}
?>
<!DOCTYPE html>
<div id = error><?php echo $error; ?></div>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Conecta a la base de datos</title>
        <link rel="stylesheet" type="text/css" href="estilo.css" media="screen" />
        <meta charset="UTF-8">
    </head>
    <body>
        <fieldset id="sup" style="width:70%">
            <legend>Datos de conexión</legend>
            <form action="." method="POST">
                <label>Host</label>
                <input type="text" name="host" value="localhost">
                <label>Usuario</label>
                <input type="text" name="usuario" value="root">
                <label>Password</label>
                <input type="text" name="pass" value="root">
                <input type="submit" value="Conectar" name="submit">
            </form>

        </fieldset>

    </body>
</html>
