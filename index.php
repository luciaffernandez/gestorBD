<?php
error_reporting(0);
spl_autoload_register(function($nombre_clase) {
    include $nombre_clase . '.php';
});

$error = "";
session_start();

if (isset($_SESSION['conexion']))
    $conexion = $_SESSION['conexion'];


if (isset($_POST['submit'])) {
    $host = $_POST['host'];
    $user = $_POST['usuario'];
    $pass = $_POST['pass'];
    $conexion = new BD($host, $user, $pass);
    $error = $conexion->getInfo();
    if ($error == "") {
        $_SESSION['conexion'] = [$host, $user, $pass];
        $consulta = "SHOW DATABASES";
        $databases = $conexion->consulta($consulta);
        while (($nomDatabase = $databases->fetchColumn(0)) !== false) {
            $radios .= "<input type='radio' name='radio' value=$nomDatabase>$nomDatabase</input><br/>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Conecta a la base de datos</title>
        <link rel="stylesheet" type="text/css" href="estilos.css" media="screen" />
        <meta charset="UTF-8">
    </head>
    <body>
        <div id ="error"><?php echo $error; ?></div>
        <fieldset style="width:70%; margin-top: -300px;">
            <legend>Datos de conexión</legend>
            <form action="index.php" method="POST">
                <label>Host</label>
                <input type="text" name="host" value="localhost">
                <label>Usuario</label>
                <input type="text" name="usuario" value="root">
                <label>Password</label>
                <input type="text" name="pass" value="root">
                <input type="submit" value="Conectar" name="submit">
            </form>
        </fieldset>
        <?php if ($radios): ?>
            <fieldset style="width:70%">
                <legend>Selecciona la base de datos</legend>
                <form action="tablas.php" method="POST">
                    <?php echo $radios; ?>
                    <input type="submit" value="Gestionar" name="submit"/>
                </form>
            </fieldset>
        <?php endif; ?>
    </body>
</html>
