<?php
spl_autoload_register(function($nombre_clase) {
    include $nombre_clase . '.php';
});

session_start();

if (isset($_POST['submit'])) {
    $host = $_SESSION['conexion'][0];
    $user = $_SESSION['conexion'][1];
    $pass = $_SESSION['conexion'][2];
    $bd = $_SESSION['conexion'][3];
    $conexion = new BD($host, $user, $pass, $bd);

    $nomTabla = $_POST['tabla'];
    $campos = $_POST['campos'];
    $formulario = "";
    foreach ($campos as $titulo => $campo) {
        $formulario .= "<label>$titulo</label>" .
                "<input type = 'text' name = 'valorNuevo[]' value = '$campo'/><br />" .
                "<input type = 'hidden'  name = 'campos[]' value ='$titulo' />" .
                "<input type = hidden name = valorAnt[] value= '$campo' />";
    }
}
?>
<html>
    <head>
        <title>Ejemplo de estilos CSS en un archivo externo</title>
        <link rel="stylesheet" type="text/css" href="estilo.css" media="screen" />
        <meta charset="UTF-8">
    </head>
    <body>
        <fieldset>
            <legend>Editanto Registro de la tabla <?php echo $nomTabla; ?> </legend>
            <form action="." method="post">
                <?php echo $formulario; ?>
                <input type="submit" value="Guardar" name='enviar'>
                <input type="submit" value="Cancelar" name='enviar'>
            </form>
        </fieldset>
    </body>
</html>

