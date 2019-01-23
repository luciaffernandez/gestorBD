<?php
spl_autoload_register(function($nombre_clase) {
    include $nombre_clase . '.php';
});

$error = "";

if (isset($_POST['submit'])) {
    $host = $_POST['host'];
    $user = $_POST['usuario'];
    $pass = $_POST['pass'];
    $bd = new BD($host, $user, $pass);
}
?>
<!DOCTYPE html>
<div id = error>Error Conectando :SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost' (using password: YES)<br />Prueba con <strong>172.17.0.2</strong>, user <strong>root</strong> pass <strong>root</strong></div>
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
                <input type="submit" value="Conectar" name="conectar">
            </form>

        </fieldset>

    </body>
</html>
