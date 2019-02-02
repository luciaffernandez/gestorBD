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

if (isset($_POST['tabla']))
    $nomTabla = $_POST['tabla'];
else
    $nomTabla = $_GET['nomTabla'];


$submit = $_POST['accion'];
if (isset($submit)) {
    $campos = serialize($_POST['campos']);
    $nomTabla = $_POST['tabla'];
    switch ($submit) {
        case "Borrar":
            $campos = $_POST['campos'];
            borrar($conexion, $nomTabla, $campos);
            break;
        case "Editar":
            echo "Location:formulario.php?campos=$campos&tabla=$nomTabla";
            //header("Location:formulario.php?campos=$campos&tabla=$nomTabla");
            exit();
        case "Añadir":
            $insert;
            header("Location:formulario.php?campos=$campos&tabla=$nomTabla&añadir=$insert");
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




