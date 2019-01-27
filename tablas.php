<?php
spl_autoload_register(function($nombre_clase) {
    include $nombre_clase . '.php';
});

session_start();

if (isset($_POST['submit'])) {

    $host = $_SESSION['conexion'][0];
    $user = $_SESSION['conexion'][1];
    $pass = $_SESSION['conexion'][2];
    $bd = $_POST['radio'];
    $conexion = new BD($host, $user, $pass, $bd);

    $_SESSION['conexion'][3] = $bd;

    $consulta = "SHOW TABLES";
    $tablas = $conexion->consulta($consulta);

    while (($nomTablas = $tablas->fetchColumn(0)) !== false) {
        $inputs .= "<input type='submit' name='submit' value='$nomTablas'>";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
        <title>Ejemplo de estilos CSS en un archivo externo</title>
        <link rel="stylesheet" type="text/css" href="estilos.css" media="screen" />
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <fieldset id="sup" style="width:40%">
            <legend>Listado bases de datos</legend>
            <form action="index.php" method='POST'>
                <input type="submit" value="Volver" name="submit">
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
