<?php
error_reporting(0);
spl_autoload_register(function($nombre_clase) {
    include $nombre_clase . '.php';
});

session_start();

$host = $_SESSION['conexion'][0];
$user = $_SESSION['conexion'][1];
$pass = $_SESSION['conexion'][2];
$bd = $_SESSION['conexion'][3];
$conexion = new BD($host, $user, $pass, $bd);

if (isset($_GET['error'])) {
    $error = $_GET['error'];
} else {
    $error = "";
}

if (isset($_POST['tabla']))
    $nomTabla = $_POST['tabla'];
else
    $nomTabla = $_GET['nomTabla'];


$submit = $_POST['accion'];
if (isset($submit)) {
    $campos = $_POST['campos'];
    $nomTabla = $_POST['tabla'];
    switch ($submit) {
        case "Borrar":
            borrar($conexion, $nomTabla, $campos);
            $error = $conexion->getInfo();
            break;
        case "Editar":
            $campos = serialize($campos);
            $_SESSION['campos'] = $campos;
            header("Location:formulario.php?tabla=$nomTabla");
            exit();
        case "Añadir":
            $add = "add";
            $campos = serialize($campos);
            $_SESSION['campos'] = $campos;
            header("Location:formulario.php?tabla=$nomTabla&add=$add");
            exit();
        case "Cerrar":
            header("Location:tablas.php");
            exit();
    }
}

function borrar($conexion, $nomTabla, $campos) {
    $sentencia = "DELETE FROM $nomTabla WHERE ";
    foreach ($campos as $titulo => $campo) {
        $sentencia .= "$titulo = '" . $campo . "' and ";
    }
    $sentencia = substr($sentencia, 0, strlen($sentencia) - 4);
    $conexion->ejecutar($sentencia);
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
            $tabla .= "<td>$dato</td>\n"
                    . "<input type='hidden' name='campos[$titulo]' value='$dato'>\n";
        }
        $tabla .= "<td>\n"
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
        <div id ="error"><?php echo $error; ?></div>
        <fieldset style="width:70%">
            <legend>Admnistración de la tabla  <?php echo $nomTabla; ?></legend>
            <form action='gestorTablas.php' method='post'>
                <?php echo generoTabla($conexion, $nomTabla); ?>
                <input type="submit" value="Añadir" name="accion">
                <input type="submit" value="Cerrar" name="accion">
                <input type="hidden" value='<?php echo $nomTabla; ?>' name="tabla">
            </form>
        </fieldset>
    </body>
</html>




