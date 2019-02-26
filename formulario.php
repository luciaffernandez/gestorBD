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

$nomTabla = $_GET['tabla'];
$campos = $_SESSION['campos'];
$campos = unserialize($campos);
$boton = $_GET['add'];

if ($boton == "add")
    $btn = "Insertar";
else
    $btn = "Guardar";


if (isset($_POST['enviar'])) {
    $nomTabla = $_POST['tabla'];
    switch ($_POST['enviar']) {
        case 'Guardar':
            $valorNuevo = $_POST['valorNuevo'];
            $valorAnt = $_POST['valorAnt'];
            $campos = $_POST['campos'];
            $sentencia = generaSentenciaUpdate($nomTabla, $campos, $valorAnt, $valorNuevo);
            $conexion->ejecutar($sentencia);
            $error = $conexion->getInfo();
            header("Location:gestorTablas.php?nomTabla=$nomTabla&error=$error");
            break;
        case 'Insertar':
            $valorNuevo = $_POST['valorNuevo'];
            $campos = $_POST['campos'];
            $sentencia = generaInsert($nomTabla, $campos, $valorNuevo);
            $conexion->ejecutar($sentencia);
            header("Location:gestorTablas.php?nomTabla=$nomTabla&error=$error");
            break;
        case 'Cancelar':
            header("Location:gestorTablas.php?nomTabla=$nomTabla");
            break;
    }
}

function generaSentenciaUpdate($nomTabla, $campos, $valorAnt, $valorNuevo) {
    $indice = 0;
    foreach ($campos as $titulo => $campo) {
        $set .= "$titulo = '" . $valorNuevo[$indice] . "', ";
        $where .= "$titulo = '" . $valorAnt[$indice] . "' and ";
        $indice++;
    }
    $set = substr($set, 0, strlen($set) - 2);
    $where = substr($where, 0, strlen($where) - 4);
    $sentencia = "UPDATE $nomTabla SET $set WHERE $where";
    return $sentencia;
}

function generaInsert($nombreTabla, $campos, $valorNuevo) {
    $cols = "";
    $indice = 0;
    foreach ($campos as $titulo => $campo) {
        $cols .= "$titulo,";
        $values .= "'" . $valorNuevo[$indice] . "',";
        $indice++;
    }
    $cols = substr($cols, 0, strlen($cols) - 1);
    $values = substr($values, 0, strlen($values) - 1);
    $sentencia = "INSERT INTO $nombreTabla ($cols) VALUES ($values)";
    return $sentencia;
}

function obtenerFormulario($campos, $boton) {
    foreach ($campos as $titulo => $campo) {
        echo "<label>$titulo</label>";
        if ($boton == "add") {
            echo "<input type = 'text' name = 'valorNuevo[]' value = ''/><br />";
        } else {
            echo "<input type = 'text' name = 'valorNuevo[]' value = '$campo'/><br />";
        }
        echo "<input type = 'hidden' name = 'campos[$titulo]' value = '$campo'/><br />" .
        "<input type = 'hidden' name = 'valorAnt[]' value= '$campo' />";
    }
}
?>
<html>
    <head>
        <title>Fomulario de edición</title>
        <link rel="stylesheet" type="text/css" href="estilos.css" media="screen" />
        <meta charset="UTF-8">
    </head>
    <body>
        <fieldset>
            <legend>Editanto Registro de la tabla <?php echo $nomTabla; ?> </legend>
            <form action="formulario.php" method="post">
                <?php
                obtenerFormulario($campos, $boton);
                ?>
                <input type="hidden" value='<?php echo $nomTabla; ?>' name="tabla">
                <input type="submit" value='<?php echo $btn; ?>' name='enviar'>
                <input type="submit" value="Cancelar" name='enviar'>
            </form>
        </fieldset>
    </body>
</html>

