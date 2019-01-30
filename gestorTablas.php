<?php
spl_autoload_register(function($nombre_clase) {
    include $nombre_clase . '.php';
});

session_start();

$host = $_SESSION['conexion'][0];
$user = $_SESSION['conexion'][1];
$pass = $_SESSION['conexion'][2];
$bd = $_SESSION['conexion'][3];
$conexion = new BD($host, $user, $pass, $bd);

if (isset($_POST['submit']))
    $nomTabla = $_POST['submit'];
else
    $nomTabla = $_GET['nomTabla'];


$submit = $_POST['accion'];
if (isset($submit)) {
    switch ($submit) {
        case "Borrar":
            $nomTabla = $_POST['tabla'];
            break;
        case "Editar":
            $campos = serialize($_POST['campos']);
            $nomTabla = $_POST['tabla'];
            header("Location:formulario.php?campos=$campos&tabla=$nomTabla");
            break;
        case "Añadir":
            header("Location:formulario.php");
            break;
        case "Cerrar":
            header("Location:tablas.php");
            break;
    }
}

function generoTabla($conexion, $nomTabla): string {

    $consulta = "Select * from $nomTabla";
    $titulos = $conexion->nomCol($nomTabla);
    $filas = $conexion->seleccion($consulta);
    $tabla = "<table id='tabla' class='display' border='1'>"
            . "<tr>";
    foreach ($titulos as $titulo) {
        $tabla .= "<th>$titulo</th>";
    }
    $tabla .= "<th colspan='2'>Acciones</th>"
            . "</tr>";
    foreach ($filas as $fila) {
        $tabla .= "<tr>"
                . "<form action='gestorTablas.php'  method='post'>"
                . "<input type='hidden' value='$nomTabla' name='tabla'>";
        foreach ($fila as $titulo => $dato) {
            $tabla .= "<td>$dato</td>"
                    . "<input type='hidden' name='campos[$titulo]' value='$dato'>";
        }
        $tabla .= "<td>"
                . "<input type = 'submit' value = 'Editar' name = 'accion'>"
                . "</td>"
                . "<td>"
                . "<input type = 'submit' value = 'Borrar' name = 'accion'>"
                . "</td>"
                . "</form>"
                . "</tr>";
    }
    $tabla .= "</table>";
    return $tabla;
}
?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Gestor de las tablas</title>
        <link rel="stylesheet" type="text/css" href="estilos.css" media="screen" />
    </head>
    <body>
        <fieldset style="width:70%">
            <legend>Admnistración de la tabla  <?php echo $nomTabla; ?></legend>
            <?php echo generoTabla($conexion, $nomTabla); ?>
            <form action='gestorTablas.php' method='post'>
                <input type="submit" value="Añadir" name="accion">
                <input type="submit" value="Cerrar" name="accion">
                <input type="hidden" value='<?php echo $nomTabla; ?>' name="tabla">
            </form>
        </fieldset>
    </body>
</html>




