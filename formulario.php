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

$nomTabla = $_GET['tabla'];
$campos = unserialize($_GET['campos']);

if (isset($_POST['enviar'])) {
    $nomTabla = $_POST['tabla'];
    switch ($_POST['enviar']) {
        case 'Guardar':
            if (isset($_GET['insert'])) {
                
            } else {
                $valorNuevo = $_POST['valorNuevo'];
                $valorAnt = $_POST['valorAnt'];
                $campos = $_POST['campos'];
                $sentencia = generaSentenciaUpdate($nomTabla, $campos, $valorAnt, $valorNuevo);
                $conexion->ejecutar($sentencia);
            }
            header("Location:gestorTablas.php?nomTabla=$nomTabla");
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
                foreach ($campos as $titulo => $campo) {
                    echo "<label>$titulo</label>";
                    if (isset($_GET['insert']))
                        echo "<input type = 'text' name = 'valorNuevo[]' value = ''/><br />";
                    else
                        echo "<input type = 'text' name = 'valorNuevo[]' value = '$campo'/><br />";

                    echo "<input type = 'hidden' name = 'campos[$titulo]' value = '$campo'/><br />" .
                    "<input type = 'hidden' name = 'valorAnt[]' value= '$campo' />";
                }
                ?>
                <input type="hidden" value='<?php echo $nomTabla; ?>' name="tabla">
                <input type="submit" value="Guardar" name='enviar'>
                <input type="submit" value="Cancelar" name='enviar'>
            </form>
        </fieldset>
    </body>
</html>

