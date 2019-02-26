<?php
error_reporting(0);
spl_autoload_register(function($nombre_clase) {
    include $nombre_clase . '.php';
});

session_start();

if (isset($_POST['radio'])) {
    $bd = $_POST['radio'];
    $_SESSION['conexion'][3] = $bd;
} else {
    $bd = $_SESSION['conexion'][3];
}

$host = $_SESSION['conexion'][0];
$user = $_SESSION['conexion'][1];
$pass = $_SESSION['conexion'][2];
$conexion = new BD($host, $user, $pass, $bd);
$consulta = "SHOW TABLES";
$tablas = $conexion->consulta($consulta);

while (($nomTabla = $tablas->fetchColumn(0)) !== false) {
    $inputs .= "<input type='submit' name='tabla' value='$nomTabla'>";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Ejemplo de estilos CSS en un archivo externo</title>
        <link rel="stylesheet" type="text/css" href="estilos.css" media="screen" />
        <meta charset="UTF-8">
    </head>
    <body>
        <fieldset id="sup" style="width:40%">
            <legend>Listado bases de datos</legend>
            <form action="index.php" method='POST'>
                <input type="submit" value="Volver" name="volver">
            </form>
        </fieldset>
        <fieldset style="width:70%">
            <legend>Gestión de las Bases de Datos <span class="resaltar"></span></legend>
            <form action='gestorTablas.php' method='post'>
                <?php echo $inputs; ?>
            </form>
        </fieldset>

    </body>
</html>
